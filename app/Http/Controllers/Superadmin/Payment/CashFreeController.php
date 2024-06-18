<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CashFreeController extends Controller
{
    public function cashfreepayment(Request $request)
    {
        $planID             = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan               = Plan::find($planID);
        $cashfreeAppId      = UtilityFacades::getsettings('cashfree_app_id');
        $cashfreeSecretKey  = UtilityFacades::getsettings('cashfree_secret_key');
        $cashfreeMode       =  UtilityFacades::getsettings('cashfree_mode');
        $currency           = UtilityFacades::getsettings('currency');
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
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            $resData['dial_code']           = $requestDomain->dial_code;
            $resData['phone']               = $requestDomain->phone;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        try {
            $url        = ($cashfreeMode == 'sandbox') ? 'https://sandbox.cashfree.com/pg/orders' : 'https://sandbox.cashfree.com/pg/orders';
            $headers    = array(
                "Content-Type: application/json",
                "x-api-version: 2022-01-01",
                "x-client-id: " . $cashfreeAppId,
                "x-client-secret: " . $cashfreeSecretKey
            );
            $data = json_encode([
                'order_id'          =>  'order_' . rand(1111111111, 9999999999),
                'order_amount'      => $resData['total_price'],
                "order_currency"    => 'INR',
                "order_name"        => $plan->name,
                "customer_details"  => [
                    "customer_id"       => 'customer_' . $resData['requestdomain_id'],
                    "customer_name"     => $resData['name'],
                    "customer_email"    => $resData['email'],
                    "customer_phone"    => '+' . $resData['dial_code'] . $resData['phone'],
                ],
                "order_meta"        => [
                    "return_url"    => route('cashfree.callback') . '?order_id={order_id}&order_token={order_token}&order=' . Crypt::encrypt($resData['order_id']) . '?&order_ids=' . $resData['order_id'] . '&coupon_id=' . $resData['coupon'] . '&plan_id=' . $planID . '',
                ]
            ]);

            $curl   = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $resp   = curl_exec($curl);
            curl_close($curl);
            return redirect()->to(json_decode($resp)->payment_link);
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function cashfreecallback(Request $request)
    {
        $orderId            = Crypt::decrypt($request->order);
        $cashfreeAppId      = UtilityFacades::getsettings('cashfree_app_id');
        $cashfreeSecretKey  = UtilityFacades::getsettings('cashfree_secret_key');
        $cashfreeMode       =  UtilityFacades::getsettings('cashfree_mode');
        $cashfreeUrl        = ($cashfreeMode == 'sandbox') ? 'https://sandbox.cashfree.com/pg/orders' : 'https://sandbox.cashfree.com/pg/orders';
        $client             = new \GuzzleHttp\Client();
        $response           = $client->request('GET', $cashfreeUrl . '/' . $request->get('order_id') . '/settlements', [
            'headers'       => [
                'accept'            => 'application/json',
                'x-api-version'     => '2022-09-01',
                "x-client-id"       => $cashfreeAppId,
                "x-client-secret"   => $cashfreeSecretKey
            ],
        ]);
        $respons        = json_decode($response->getBody());
        if ($respons->order_id && $respons->cf_payment_id != NULL) {
            $response   = $client->request('GET', $cashfreeUrl . '/' . $respons->order_id . '/payments/' . $respons->cf_payment_id . '', [
                'headers'   => [
                    'accept'            => 'application/json',
                    'x-api-version'     => '2022-09-01',
                    'x-client-id'       => $cashfreeAppId,
                    'x-client-secret'   => $cashfreeSecretKey,
                ],
            ]);
            $info   = json_decode($response->getBody());
            if ($info->payment_status == "SUCCESS") {
                $datas                  = Order::find($orderId);
                $datas->status          = 1;
                $datas->payment_id      = $info->cf_payment_id;
                $datas->payment_type    = 'cashfree';
                $datas->update();
                $coupons    = Coupon::find($datas['coupon']);
                if (!empty($coupons)) {
                    $userCoupon                 = new UserCoupon();
                    $userCoupon->domainrequest  = $datas['requestdomain_id'];
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
                $order                  = Order::find($orderId);
                $order->status          = 2;
                $order->payment_id      = $info->cf_payment_id;
                $order->payment_type    = 'cashfree';
                $order->update();
                return redirect()->route('landingpage')->with('failed', __('Payment canceled.'));
            }
        } else {
            $order                  = Order::find($orderId);
            $order->status          = 2;
            $order->payment_type    = 'cashfree';
            $order->update();
            return redirect()->route('landingpage')->with('failed', 'Payment failed.');
        }
    }
}
