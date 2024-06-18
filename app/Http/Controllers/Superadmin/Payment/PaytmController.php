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
use Paytm\JsCheckout\Facades\Paytm;

class PaytmController extends Controller
{
    public function pay(Request $request)
    {
        request()->validate([
            'mobile_number' => 'required|numeric|digits:10',
        ]);
        $payment    = Paytm::with('receive');
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
            $resData['user']            = $requestDomain->id;
            $resData['email']           = $requestDomain->email;
            $resData['total_price']     = $price;
            $resData['coupon']          = $couponId;
            $resData['order_id']        = $order->id;
            return $resData;
        });
        $payment->prepare([
            'order'         => rand(),
            'user'          => $resData['user'],
            'mobile_number' => $request->mobile_number,
            'email'         => $resData['email'],
            'amount'        =>  $resData['total_price'], // amount will be paid in INR.
            'callback_url'  => route('paytm.callback', ['coupon' => $resData['coupon'], 'order_id' => $resData['order_id'], 'requestdomain_id' => $resData['user']]) // callback URL
        ]);
        $response   = $payment->receive();  // initiate a new payment
        return $response;
    }

    public function paymentCallback(Request $request)
    {
        $transaction    = Paytm::with('receive');
        $response       = $transaction->response();
        $orderId        = $request->order_id; // return a order id
        if ($transaction->isSuccessful()) {
            $data               = Order::find($orderId);
            $data->status       = 1;
            $data->payment_id   = $transaction->getTransactionId();
            $data->payment_type = 'paytm';
            $data->update();
            $coupons            = Coupon::find($request->coupon);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data->domainrequest_id;
                $userCoupon->coupon         = $coupons->id;
                $userCoupon->order          = $orderId;
                $userCoupon->save();
                $usedCoupun                 = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
        } else if ($transaction->isFailed()) {
            $data               = Order::find($orderId);
            $data->status       = 2;
            $data->payment_id   = $transaction->getTransactionId();
            $data->payment_type = 'paytm';
            $data->update();
            return redirect()->route('landingpage')->with('errors', __('Transaction failed.'));
        } else {
            return redirect()->route('landingpage')->with('warning', __('Transaction in prossesing.'));
        }
        if (UtilityFacades::getsettings('approve_type') == 'Auto') {
            UtilityFacades::approved_request($data);
        }
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}
