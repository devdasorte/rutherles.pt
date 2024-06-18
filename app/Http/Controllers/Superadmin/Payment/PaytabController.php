<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use App\Models\Plan;
use App\Models\UserCoupon;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\RequestDomain;

class PaytabController extends Controller
{
    public function planPaytab(Request $request)
    {
        config([
            'paytabs.profile_id' => UtilityFacades::getsettings('paytab_profile_id'),
            'paytabs.server_key' => UtilityFacades::getsettings('paytab_server_key'),
            'paytabs.region' =>  UtilityFacades::getsettings('paytab_region'),
            'paytabs.currency' => UtilityFacades::getsettings('currency'),   // 'INR'
        ]);
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $order          = Order::find($request->order_id);
        $requestDomain  = RequestDomain::find($order->domainrequest_id);
        $plan           =  Plan::find($planID);
        $couponId       = 0;
        $couponCode     = null;
        $discountValue  = null;
        $price      = $plan->price;
        $coupons    = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
        if ($coupons) {
            $couponCode     = $coupons->code;
            $usedCoupun     = $coupons->used_coupon();
            if ($coupons->limit == $usedCoupun) {
                $resData['error'] = __('This coupon code has expired.');
            } else {
                $discount       = $coupons->discount;
                $discount_type  = $coupons->discount_type;
                $discountValue  =  UtilityFacades::calculateDiscount($price, $discount, $discount_type);
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
        $resData['currency']            = UtilityFacades::getsettings('currency');   // 'INR'
        $resData['domainrequest_id']    = $requestDomain->id;
        $resData['order_id']            = $order->id;
        $resData['total_price']         = $price;
        $resData['coupon']              = $couponId;
        $resData['plan_name']           = $plan->name;
        $resData['plan_id']             = $plan->id;
        $customerName   = isset($resData['domainrequest_id']) ? $resData['domainrequest_id'] : "";
        $pay            = paypage::sendPaymentCode('all')
            ->sendTransaction('sale')
            ->sendCart(1, $resData['total_price'], 'plan payment')
            ->sendCustomerDetails('', '', '', '', '', '', '', '', '')
            ->sendURLs(
                route('paytab.success', ['success' => 1, 'data' => $request->all(), 'plan_id' => $plan->id, 'amount' => $resData['total_price'], 'coupon' => $resData['coupon']]),
                route('paytab.success', ['success' => 0, 'data' => $request->all(), 'plan_id' => $plan->id, 'amount' => $resData['total_price'], 'coupon' => $resData['coupon']])
            )
            ->sendLanguage('en')
            ->sendFramed(false)
            ->create_pay_page();
        return $pay;
    }

    public function PaytabPayment(Request $request)
    {
        if ($request->respMessage == "Authorised") {
            $datas                  = Order::find($request->data['order_id']);
            $datas->status          = 1;
            $datas->payment_id      = $request->payment_id;
            $datas->payment_type    = 'paytab';
            $datas->update();
            $coupons    = Coupon::find($request->coupon);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $datas->domainrequest_id;
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
        } else {
            $order                  = Order::find($request->data['order_id']);
            $order->status          = 2;
            $order->payment_id      = $request->transaction_id;
            $order->payment_type    = 'paytab';
            $order->update();
            return redirect()->back()->with('failed', __('Payment failed.'));
        }
    }
}
