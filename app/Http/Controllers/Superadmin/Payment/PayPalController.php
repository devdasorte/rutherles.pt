<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function processTransaction(Request $request)
    {
        $currency   = UtilityFacades::getsettings('currency');
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $resData    = tenancy()->central(function ($tenant) use ($plan, $request) {
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
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        $provider       = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken    = $provider->getAccessToken();
        $response       = $provider->createOrder([
            "intent"                => "CAPTURE",
            "application_context"   => [
                'return_url' => route('success.transaction', Crypt::encrypt(['coupon' => $resData['coupon'], 'product_name' => $plan->name, 'price' => $resData['total_price'], 'user_id' => $resData['domainrequest_id'], 'currency' => $plan->currency, 'product_id' => $plan->id, 'order_id' => $resData['order_id']])),
                'cancel_url' => route('cancel.transaction', Crypt::encrypt(['coupon' => $resData['coupon'], 'product_name' => $plan->name, 'price' => $resData['total_price'], 'user_id' => $resData['domainrequest_id'], 'currency' => $plan->currency, 'product_id' => $plan->id, 'order_id' => $resData['order_id']])),

            ],
            "purchase_units"        => [
                0 => [
                    "amount"    => [
                        "currency_code" => $currency,
                        "value"         => $resData['total_price'],
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->back()->with('failed',  __('Something went wrong.'));
        } else {

            return redirect()->back()->with('failed',  __('Something went wrong.'));
        }
    }

    public function cancelTransaction($data)
    {
        $data               = Crypt::decrypt($data);
        $data               = Order::find($data['order_id']);
        $data->status       = 2;
        $data->payment_type = 'paypal';
        $data->update();
        return redirect()->route('landingpage')->with('failed', __('Payment canceled!'));
    }

    public function successTransaction($data, Request $request)
    {
        $data                   = Crypt::decrypt($data);
        $database               = $data;
        $datas                  = Order::find($data['order_id']);
        $datas->payment_id      = $request['PayerID'];
        $datas->status          = 1;
        $datas->payment_type    = 'paypal';
        $datas->update();
        $coupons    = Coupon::find($data['coupon']);
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
        if (UtilityFacades::getsettings('database_permission') == '1') {
            UtilityFacades::approved_request($data['domainrequest_id'], $database);
        }
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}
