<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\UserCoupon;
use CoinGate\CoinGate;
use Illuminate\Support\Facades\Crypt;

class CoingateController extends Controller
{
    public function coingatepayment(Request $request)
    {
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $resData    =  tenancy()->central(function ($tenant) use ($plan, $request) {
            $order          = Order::find($request->order_id);
            $requestDomain  = RequestDomain::find($order->domainrequest_id);
            $couponId       = '0';
            $couponCode     = null;
            $discountValue  = null;
            $price          = $plan->price;
            $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
            if ($coupons) {
                $couponCode     = $coupons->code;
                $usedCoupun     = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                    $resData['errors'] = __('This coupon code has expired.');
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
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        CoinGate::config(
            array(
                'environment'               => UtilityFacades::getsettings('coingate_environment'),    // sandbox OR live
                'auth_token'                => UtilityFacades::getsettings('coingate_auth_token'),
                'curlopt_ssl_verifypeer'    => FALSE     // default is false
            )
        );
        $currency   = UtilityFacades::getsettings('currency');
        $params     = array(
            'order_id'          => rand(),
            'price_amount'      => $resData['total_price'],
            'price_currency'    => $currency,
            'receive_currency'  => $currency,
            'callback_url'      => route('coingate.callback', Crypt::encrypt(['order_id' => $resData['order_id'], 'coupon_id' => $resData['coupon'], 'requestdomain_id' => $resData['requestdomain_id']])),
            'cancel_url'        => route('coingate.callback', Crypt::encrypt(['order_id' => $resData['order_id'], 'coupon_id' => $resData['coupon'], 'requestdomain_id' => $resData['requestdomain_id'], 'status' => 'failed'])),
            'success_url'       => route('coingate.callback', Crypt::encrypt(['order_id' => $resData['order_id'], 'coupon_id' => $resData['coupon'], 'requestdomain_id' => $resData['requestdomain_id'], 'status' => 'successfull'])),
        );
        $order      = \CoinGate\Merchant\Order::create($params);
        if ($order) {
            $payment_id             = Order::find($resData['order_id']);
            $payment_id->payment_id = $order->id;
            $payment_id->update();
            return redirect($order->payment_url);
        } else {
            return redirect()->back()->with('errors', __('Opps something went wrong.'));
        }
    }

    public function coingatePlanGetPayment($data)
    {
        $data   = Crypt::decrypt($data);
        if ($data['status'] == 'successfull') {
            $order                  = Order::find($data['order_id']);
            $order->status          = 1;
            $order->payment_type    = 'coingate';
            $order->update();
            $coupons    = Coupon::find($data['coupon_id']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data['requestdomain_id'];
                $userCoupon->coupon         = $coupons->id;
                $userCoupon->order          = $order->id;
                $userCoupon->save();
                $usedCoupun                 = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
            return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
        } else {
            $order                  = Order::find($data['order_id']);
            $order->status          = 2;
            $order->payment_type    = 'coingate';
            $order->update();
            $coupons                = Coupon::find($data['coupon_id']);
            if (!empty($coupons)) {
                $userCoupon         = new UserCoupon();
                $userCoupon->user   = $data['requestdomain_id'];
                $userCoupon->coupon = $coupons->id;
                $userCoupon->order  = $order->id;
                $userCoupon->save();
                $usedCoupun         = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
            return redirect()->route('landingpage')->with('failed', __('Payment canceled.'));
        }
    }
}
