<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Order;
use App\Models\RequestDomain;
use App\Models\UserCoupon;

class MolliePaymentController extends Controller
{
    public function planPayPaymentMollie(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan           = Plan::find($planID);
        $mollieApiKey   = UtilityFacades::getsettings('mollie_api_key');
        $currency       = UtilityFacades::getsettings('currency');
        $resData        =  tenancy()->central(function ($tenant) use ($plan, $request) {
            $order          = Order::find($request->order_id);
            $requestDomain  = RequestDomain::find($order->domainrequest_id);
            $orderID        = time();
            $couponId       = '0';
            $price          = $plan->price;
            $couponCode     = null;
            $discountValue  = null;
            $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
            if ($coupons) {
                $couponCode     = $coupons->code;
                $usedCoupun     = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                    $resData['errors'] = 'This coupon code has expired.';
                } else {
                    $discount       = $coupons->discount;
                    $discountType   = $coupons->discount_type;
                    $discountValue  = UtilityFacades::calculateDiscount($price, $discount, $discountType);
                    $price          = $price - $discountValue;
                    if ($price < 0) {
                        $price      = $plan->price;
                    }
                    $couponId       = $coupons->id;
                }
            }
            $data = Order::create([
                'plan_id'           => $plan->id,
                'domainrequest_id'  => $requestDomain->id,
                'amount'            => $price,
                'discount_amount'   => $discountValue,
                'coupon_code'       => $couponCode,
                'status'            => 0,
                'payment_id'        => $orderID,
            ]);
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['total_price']         = $price;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $data->id;
            $resData['plan_id']             = $plan->id;
            $resData['payment_id']          = $orderID;
            return $resData;
        });
        try {
            $mollie     = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($mollieApiKey);
            $payment    = $mollie->payments->create(
                [
                    "amount"        => [
                        "currency"  => $currency,
                        "value"     => number_format((float)$resData['total_price'], 2, '.', ''),
                    ],
                    "description" => "payment for product",
                    "redirectUrl" => route('plan.with.mollie', ['requestdomain' => $resData['requestdomain_id'], 'plan_id' => $resData['plan_id'], 'order_id' => $resData['order_id'], 'payment_id' => $resData['payment_id'], 'payment_frequency=' . $request->mollie_payment_frequency, 'coupon_id=' . $resData['coupon'], 'status' => 'successfull']),
                ]
            );
            session()->put('mollie_payment_id', $payment->id);
            return redirect($payment->getCheckoutUrl())->with('payment_id', $payment->id);
        } catch (\Exception $e) {
            return redirect()->route('landingpage')->with('errors', __($e->getMessage()));
        }
    }

    public function getPayPaymentStatus(Request $request)
    {
        $order  = tenancy()->central(function ($tenant) use ($request) {
            $datas                  = Order::find($request->order_id);
            $datas->status          = 1;
            $datas->payment_type    = 'mollie';
            $datas->update();
            $coupons    = Coupon::find($request->coupon_id);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $request->requestdomain;
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
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}

