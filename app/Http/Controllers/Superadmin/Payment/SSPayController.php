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

class SSPayController extends Controller
{
    public function sspayinitpayment(Request $request)
    {
        $planID             = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $sspayCategoryCode  = UtilityFacades::getsettings('sspay_category_code');
        $sspaySecretKey     = UtilityFacades::getsettings('sspay_secret_key');
        $sspayDescription   = UtilityFacades::getsettings('sspay_description');
        $plan               =  Plan::find($planID);
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
            $resData['domainrequest_id']    = $requestDomain->id;
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
            $someData = array(
                'userSecretKey'             => $sspaySecretKey,
                'categoryCode'              => $sspayCategoryCode,
                'billName'                  => $plan->name,
                'billDescription'           => $plan->description,
                'billPriceSetting'          => 1,
                'billPayorInfo'             => 1,
                'billAmount'                => round($resData['total_price'] * 100, 2),
                'billReturnUrl'             => route('sspay.callback') . '?&domain_request_id=' . $resData['domainrequest_id'] . '&order=' . $resData['order_id'] . '&coupon_id=' . $resData['coupon'] . '&status=failed' . '',
                'billCallbackUrl'           => route('sspay.callback') . '?&domain_request_id=' . $resData['domainrequest_id'] . '&order=' . $resData['order_id'] . '&coupon_id=' . $resData['coupon'] . '&status=successfull' . '',
                'billExternalReferenceNo'   => 'AFR341DFI',
                'billTo'                    => $resData['name'],
                'billEmail'                 => $resData['email'],
                'billPhone'                 => $resData['phone'],
                'billSplitPayment'          => 0,
                'billSplitPaymentArgs'      => '',
                'billPaymentChannel'        => '0',
                'billDisplayMerchant'       => 1,
                'billContentEmail'          => $sspayDescription,
                'billChargeToCustomer'      => 1
            );

            $curl       = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://sspay.my' . '/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $someData);
            $result     = curl_exec($curl);
            $info       = curl_getinfo($curl);
            curl_close($curl);
            $obj        = json_decode($result);
            $url        = 'https://sspay.my' . '/index.php/api/runBill';
            $billcode   = $obj[0]->BillCode;
            $someData   = array(
                'userSecretKey'         =>  $sspaySecretKey,
                'billCode'              => $billcode,
                'billpaymentAmount'     => round($resData['total_price'] * 100, 2),
                'billpaymentPayorName'  => $resData['name'],
                'billpaymentPayorPhone' => $resData['phone'],
                'billpaymentPayorEmail' => $resData['email'],
                'billBankID'            => 'TEST0021'
            );
            $curl       = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $someData);
            $result     = curl_exec($curl);
            curl_getinfo($curl);
            curl_close($curl);
            $obj        = json_decode($result);
            return redirect()->to('https://sspay.my' . '/' . $billcode);
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function sspayCallback(Request $request)
    {
        if ($request->status_id == 1) {
            $datas                  = Order::find($request->order);
            $datas->status          = 1;
            $datas->payment_id      = $request->transaction_id;
            $datas->payment_type    = 'sspay';
            $datas->update();
            $coupons    = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
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
        } else if ($request->status_id == 3) {
            $order                  = Order::find($request->order);
            $order->status          = 2;
            $order->payment_id      = $request->transaction_id;
            $order->payment_type    = 'sspay';
            $order->update();
            return redirect()->route('landingpage')->with('failed', __('Payment failed.'));
        } else {
            $order                  = Order::find($request->order);
            $order->payment_id      = $request->transaction_id;
            $order->payment_type    = 'sspay';
            $order->save();
            return redirect()->route('landingpage')->with('warning', __('Waiting for proccesing..'));
        }
    }
}
