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
use GuzzleHttp\Client;

class BenefitPaymentController extends Controller
{
    public function initiatePayPayment(Request $request)
    {
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $secretKey  = UtilityFacades::getsettings('benefit_secret_key');
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
            $resData['order_id']            = $order->id;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            return $resData;
        });
        $userData = [
            "amount"                => $resData['total_price'],
            "currency"              => UtilityFacades::getsettings('currency'),  // BHD
            "customer_initiated"    => true,
            "threeDSecure"          => true,
            "save_card"             => false,
            "description"           => " Plan - " . $plan->name,
            "metadata"              => ["udf1" => "Metadata 1"],
            "reference"             => ["transaction" => "txn_01", "order" => "ord_01"],
            "receipt"               => ["email" => true, "sms" => true],
            "customer"              => ["first_name" => $resData['name'], "middle_name" => "", "last_name" => "", "email" => $resData['email'], "phone" => ["country_code" => 965, "number" => 51234567]],
            "source"                => ["id" => "src_bh.benefit"],
            "post"                  => ["url" => "https://webhook.site/fd8b0712-d70a-4280-8d6f-9f14407b3bbd"],
            "redirect"              => ["url" => route('benefit.pay.callback', ['order_id' => $resData['order_id'], 'requestdomain_id' => $resData['requestdomain_id'], 'plan_id' => $plan->id, 'amount' => $resData['total_price'], 'coupon' => $resData['coupon']])],
        ];
        $responseData   = json_encode($userData);
        $client         = new Client();
        try {
            $response       = $client->request('POST', 'https://api.tap.company/v2/charges', [
                'body'      => $responseData,
                'headers'   => [
                    'Authorization' => 'Bearer ' . $secretKey,
                    'accept'        => 'application/json',
                    'content-type'  => 'application/json',
                ],
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'Currency Not Supported.Contact To Your Site Admin');
        }
        $data   = $response->getBody();
        $res    = json_decode($data);
        return redirect($res->transaction->url);
    }

    public function callBackpay(Request $request)
    {
        $secretKey  = UtilityFacades::getsettings('benefit_secret_key');
        $orderID    = strtoupper(str_replace('.', '', uniqid('', true)));
        $post       = $request->all();
        $client     = new Client();
        $response   = $client->request('GET', 'https://api.tap.company/v2/charges/' . $post['tap_id'], [
            'headers' => [
                'Authorization' => 'Bearer ' . $secretKey,
                'accept'        => 'application/json',
            ],
        ]);
        $json       = $response->getBody();
        $data       = json_decode($json);
        $statusCode = $data->gateway->response->code;
        if ($statusCode == '00') {
            $datas                  = Order::find($request['order_id']);
            $datas->payment_id      = $orderID;
            $datas->status          = 1;
            $datas->payment_type    = 'benefit';
            $datas->update();
            $coupons = Coupon::find($request['coupon']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $datas['domainrequest_id'];
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
            $order                  = Order::find($request['order_id']);
            $order->payment_id      = $orderID;
            $order->status          = 2;
            $order->payment_type    = 'benefit';
            $order->update();
            return redirect()->route('landingpage')->with('errors', __('Opps something went wrong.'));
        }
        return redirect()->route('landingpage');
    }
}
