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

class FlutterwaveController extends Controller
{
    public function flutterwavepayment(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $order          = Order::find($request->order_id);
        $requestDomain  = RequestDomain::find($order->domainrequest_id);
        $plan           =  Plan::find($planID);
        $couponId       = 0;
        $couponCode     = null;
        $discountValue  = null;
        $price          = $plan->price;
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
        $order->status = 0;
        $order->save();
        $resData['email']               = $requestDomain->email;
        $resData['currency']            = UtilityFacades::getsettings('currency');
        $resData['domainrequest_id']    = $requestDomain->id;
        $resData['order_id']            = $order->id;
        $resData['total_price']         = $price;
        $resData['coupon']              = $couponId;
        $resData['plan_name']           = $plan->name;
        $resData['plan_id']             = $plan->id;
        return $resData;
    }

    public function flutterwavecallback($orderId, $transactionId, $requestDomainId, $couponId)
    {
        $data               = Order::find($orderId);
        $data->status       = 1;
        $data->payment_id   = $transactionId;
        $data->payment_type = 'flutterwave';
        $data->update();
        $coupons        = Coupon::find($couponId);
        $requestDomain  =  RequestDomain::find($requestDomainId);
        if (!empty($coupons)) {
            $userCoupon                 = new UserCoupon();
            $userCoupon->domainrequest  = $requestDomain->id;
            $userCoupon->coupon         = $coupons->id;
            $userCoupon->order          = $data->id;
            $userCoupon->save();
            $usedCoupun                 = $coupons->used_coupon();
            if ($coupons->limit <= $usedCoupun) {
                $coupons->is_active = 0;
                $coupons->save();
            }
        }
        if (UtilityFacades::getsettings('approve_type') == 'Auto') {
            UtilityFacades::approved_request($data);
        }
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}
