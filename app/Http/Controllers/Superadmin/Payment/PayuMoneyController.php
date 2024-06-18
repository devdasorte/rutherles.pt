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

class PayuMoneyController extends Controller
{
    public function PayUmoneypaypayment(Request $request)
    {
        $planID                 = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan                   = Plan::find($planID);
        $payumoneyMode          = UtilityFacades::getsettings('payumoney_mode');
        $payumoneyMerchantKey   = UtilityFacades::getsettings('payumoney_merchant_key');
        $payumoneySaltKey       = UtilityFacades::getsettings('payumoney_salt_key');
        $currency               = UtilityFacades::getsettings('currency');
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
                    $resData['errors'] = 'This coupon code has expired.';
                } else {
                    $discount       = $coupons->discount;
                    $discount_type  = $coupons->discount_type;
                    $discountValue  = UtilityFacades::calculateDiscount($price, $discount, $discount_type);
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
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['total_price']         = $price;
            $resData['coupon']              = $couponId;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            $resData['dial_code']           = $requestDomain->dial_code;
            $resData['phone']               = $requestDomain->phone;
            $resData['order_id']            = $order->id;
            $resData['plan_id']             = $plan->id;
            return $resData;
        });
        $txnId          = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $amount         = $resData['total_price'];
        $hashString     = $payumoneyMerchantKey . '|' . $txnId . '|' . $amount . '|' . $plan->name . '|' . $resData['name'] . '|' . $resData['email'] . '|' . '||||||||||' . $payumoneySaltKey;
        $hash           = strtolower(hash('sha512', $hashString));
        $payuUrl        = 'https://test.payu.in/_payment';  // For production environment, change it to 'https://secure.payumoney.com/_payment'
        $paymentData    = [
            'key'           => $payumoneyMerchantKey,
            'txnid'         => $txnId,
            'amount'        => $resData['total_price'],
            'productinfo'   => $plan->name,
            'firstname'     => $resData['name'],
            'email'         => $resData['email'],
            'coupon'        => $resData['coupon'],
            'order_id'      => $resData['order_id'],
            'hash'          => $hash,
            'surl'          => route('payu.pay.success', Crypt::encrypt(['key' => $payumoneyMerchantKey, 'productinfo' => $plan->name, 'firstname' => $resData['name'], 'email' => $resData['email'],  'txnid' => $txnId,  'order_id' => $resData['order_id'], 'domain_request_id' => $resData['requestdomain_id'], 'coupon' => $resData['coupon'], 'plan_id' => $plan->id, 'currency' => $currency, 'payment_type' => 'payumoney', 'status' => 'successfull'])),
            'furl'          => route('payu.pay.failure', Crypt::encrypt(['key' => $payumoneyMerchantKey, 'productinfo' => $plan->name, 'firstname' => $resData['name'], 'email' => $resData['email'],  'txnid' => $txnId, 'order_id' => $resData['order_id'], 'domain_request_id' => $resData['requestdomain_id'], 'coupon' => $resData['coupon'], 'plan_id' => $plan->id, 'currency' => $currency, 'payment_type' => 'payumoney', 'status' => 'failed'])),
        ];
        return view('admin.plans.payumoney-redirect', compact('payuUrl', 'paymentData'));
    }

    public function payuPaySuccess($data)
    {
        $data                   = Crypt::decrypt($data);
        $datas                  = Order::find($data['order_id']);
        $datas->status          = 1;
        $datas->payment_id      = $data['txnid'];
        $datas->payment_type    = 'payumoney';
        $datas->update();
        $coupons    = Coupon::find($data['coupon']);
        if (!empty($coupons)) {
            $userCoupon                 = new UserCoupon();
            $userCoupon->userrequest    = $datas->request_user_id;
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
        return redirect()->route('landingpage')->with('status', 'Thanks for registration, your account is in review and you get email when your account active.');
    }

    public function payuPayFailure(Request $request)
    {
        $order                  = Order::find($request['order_id']);
        $order->status          = 2;
        $order->payment_type    = 'payumoney';
        $order->update();
        return redirect()->route('landingpage')->with('failed', __('Payment failed.'));
    }
}
