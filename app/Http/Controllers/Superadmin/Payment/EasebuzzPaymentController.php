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
use Illuminate\Support\Facades\Crypt;
use Easebuzz\Easebuzz;

class EasebuzzPaymentController extends Controller
{
    public function PayEasebuzz(Request $request)
    {
        $planID                 = Crypt::decrypt($request->plan_id);
        $plan                   = Plan::find($planID);
        $easebuzzMerchantKey    = UtilityFacades::getsettings('easebuzz_merchant_key');
        $easebuzzSalt           = UtilityFacades::getsettings('easebuzz_salt');
        $resData    =  tenancy()->central(function ($tenant) use ($plan, $request) {
            $couponId       = '0';
            $couponCode     = null;
            $discountValue  = null;
            $price          = $plan->price;
            $order          = Order::find($request->order_id);
            $requestDomain  = RequestDomain::find($order->domainrequest_id);
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
            $resData['total_price']         = $price;   //  number_format($resData['total_price'], 2, '.', '')
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            $resData['plan_id']             = $plan->id;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            $resData['phone']               = $requestDomain->phone;
            $resData['txnid']               = uniqid();
            // return $resData;
            // success call
            $datas                  = Order::find($resData['order_id']);
            $datas->status          = 1;
            $datas->payment_id      = $resData['txnid'];
            $datas->payment_type    = 'easebuzz';
            $datas->update();
            $coupons    = Coupon::find($resData['coupon']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $resData['requestdomain_id'];
                $userCoupon->coupon         = $coupons->id;
                $userCoupon->order          = $datas->id;
                $userCoupon->save();
                $usedCoupun     = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
            if (UtilityFacades::getsettings('approve_type') == 'Auto') {
                UtilityFacades::approved_request($datas);
            }
        });
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
        $easebuzz       = new Easebuzz($easebuzzMerchantKey, $easebuzzSalt, 'test');
        $paymentData    = array(
            'txnid'         => $resData['txnid'],
            'order_id'      =>  $resData['order_id'],
            'amount'        => number_format($resData['total_price'], 2, '.', ''),
            'firstname'     => $resData['name'],
            'email'         => $resData['email'],
            "phone"         => $resData['phone'],
            "productinfo"   => "Laptop",
            'surl'          => route('pay.easebuzz.callback', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'order_id' => $resData['order_id'], 'txnid' => $resData['txnid'], 'coupon_id' => $resData['coupon'], 'plan_id' => $planID, 'status' => 'successfull'])),
            'furl'          => route('pay.easebuzz.callback', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'order_id' => $resData['order_id'], 'txnid' => $resData['txnid'], 'coupon_id' => $resData['coupon'], 'plan_id' => $planID, 'status' => 'failed'])),
        );
        $paymentPageUrl = $easebuzz->initiatePaymentAPI($paymentData);
        return redirect($paymentPageUrl);
    }

    public function payEasebuzzCallback($data)
    {
        $data   = Crypt::decrypt($data);
        if ($data['status'] == 'successfull') {
            $datas                  = Order::find($data['order_id']);
            $datas->status          = 1;
            $datas->payment_id      = $data['txnid'];
            $datas->payment_type    = 'easebuzz';
            $datas->update();
            $coupons    = Coupon::find($data['coupon_id']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data['requestdomain_id'];
                $userCoupon->coupon         = $coupons->id;
                $userCoupon->order          = $datas->id;
                $userCoupon->save();
                $usedCoupun                 = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
            if (UtilityFacades::getsettings('approve_type') == 'Auto') {
                UtilityFacades::approved_request($datas);
            }
            return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
        } else {
            $order                  = Order::find($data['order_id']);
            $order->status          = 2;
            $order->payment_type    = 'easebuzz';
            $order->update();
            return redirect()->route('landingpage')->with('errors', __('Opps something went wrong.'));
        }
    }
}

