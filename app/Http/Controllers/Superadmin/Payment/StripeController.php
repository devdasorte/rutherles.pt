<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;
use App\Models\Coupon;
use App\Models\UserCoupon;

class StripeController extends Controller
{
    public function stripePostPending(Request $request)
    {
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = tenancy()->central(function ($tenant) use ($planID) {
            return Plan::find($planID);
        });
        $resData    =  tenancy()->central(function ($tenant) use ($plan, $request) {
            $order          = Order::find($request->order_id);
            $requestDomain  = RequestDomain::find($order->domainrequest_id);
            $couponId       = '0';
            $price          = $plan->price;
            $couponCode     = null;
            $discountValue  = null;
            $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
            if ($coupons) {
                $couponCode     = $coupons->code;
                $usedCoupun     = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                    $resData['error'] = __('This coupon code has expired.');
                } else {
                    $discount       = $coupons->discount;
                    $discountType   = $coupons->discount_type;
                    $discountValue  =  UtilityFacades::calculateDiscount($price, $discount, $discountType);
                    $price          = $price - $discountValue;
                    if ($price < 0) {
                        $price      = $plan->price;
                    }
                    $couponId       = $coupons->id;
                }
            }
            $order->plan_id             = $plan->id;
            $order->domainrequest_id    = $requestDomain->id;
            $order->amount              = $price;
            $order->discount_amount     = $discountValue;
            $order->coupon_code         = $couponCode;
            $order->status              = 0;
            $order->save();
            $resData['total_price']         = $price;
            $resData['domainrequest_id']    = $requestDomain->id;
            $resData['plan_id']             = $plan->id;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        return $resData;
    }

    public function preStripeSession(Request $request)
    {
        Stripe::setApiKey(UtilityFacades::getsettings('stripe_secret'));
        $currency   = UtilityFacades::getsettings('currency');
        if (!empty($request->createCheckoutSession)) {
            $plan_details   = tenancy()->central(function ($tenant) use ($request) {
                return Plan::find($request->plan_id);
            });
            try {
                $checkoutSession    = \Stripe\Checkout\Session::create([
                    'payment_method_types'  => ['card'],
                    'line_items'    => [[
                        'price_data'    => [
                            'currency'      => $currency,
                            'product_data'  => [
                                'name'      => $plan_details->name,
                                'metadata'  => [
                                    'plan_id'           => $request->plan_id,
                                    'domainrequest_id'  => $request->domainrequest_id
                                ]
                            ],
                            'unit_amount'   => $request->amount * 100,
                        ],
                        'quantity'  => 1,
                    ]],
                    'mode'          => 'payment',
                    'success_url'   => route('pre.stripe.success.pay', Crypt::encrypt([
                        'coupon'            => $request->coupon,
                        'plan_id'           => $plan_details->id,
                        'price'             => $request->amount,
                        'domainrequest_id'  => $request->domainrequest_id,
                        'order_id'          => $request->order_id,
                        'type'              => 'stripe'
                    ])),
                    'cancel_url'    => route('pre.stripe.cancel.pay', Crypt::encrypt([
                        'coupon'            => $request->coupon,
                        'plan_id'           => $plan_details->id,
                        'price'             => $request->amount,
                        'domainrequest_id'  => $request->domainrequest_id,
                        'order_id'          => $request->order_id,
                        'type'              => 'stripe'
                    ])),
                ]);
            } catch (Exception $e) {
                $api_error  = $e->getMessage();
            }
            if (empty($api_error) && $checkoutSession) {
                $response   = [
                    'status'    => 1,
                    'message'   => 'Checkout session created successfully.',
                    'sessionId' => $checkoutSession->id
                ];
            } else {
                $response   = [
                    'status'    => 0,
                    'error'     => [
                        'message'   => 'Checkout session creation failed. ' . $api_error
                    ]
                ];
            }
        }
        return response()->json($response);
    }

    function prePaymentCancel($data)
    {
        $data   = Crypt::decrypt($data);
        $order  = tenancy()->central(function ($tenant) use ($data) {
            $datas                  = Order::find($data['order_id']);
            $datas->status          = 2;
            $datas->payment_type    = 'stripe';
            $datas->update();
        });
        return redirect()->route('landingpage')->with('errors', 'Payment canceled.');
    }

    function prePaymentSuccess($data)
    {
        $data       = Crypt::decrypt($data);
        $database   = $data;
        $order      = tenancy()->central(function ($tenant) use ($data) {
            $datas                  = Order::find($data['order_id']);
            $datas->status          = 1;
            $datas->payment_type    = 'stripe';
            $datas->update();
            $coupons    = Coupon::find($data['coupon']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data['domainrequest_id'];
                $userCoupon->coupon         = $coupons->id;
                $userCoupon->order          = $datas->id;
                $userCoupon->save();
                $usedCoupun                 = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
        });
        if (UtilityFacades::getsettings('database_permission') == 1) {
            UtilityFacades::approved_request($data['domainrequest_id'], $database);
        }
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}
