<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ToyyibpayController extends Controller
{
    public function charge(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $secretKey      = UtilityFacades::getsettings('toyyibpay_secret_key');
        $categoryCode   = UtilityFacades::getsettings('toyyibpay_category_code');
        $description    = UtilityFacades::getsettings('toyyibpay_description');
        $plan           =  Plan::find($planID);
        $resData        =  tenancy()->central(function ($tenant) use ($plan, $request) {
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
            $resData['domainrequest_id']    = $requestDomain->id;
            $resData['total_price']         = $price;
            $resData['coupon']              = $couponId;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        try {
            $amount             = $resData['total_price'];
            $billName           = $plan->name;
            $billExpiryDate     = Carbon::now()->addDays(3);
            $billContentEmail   = $plan->description;
            $billReturnUrl      = route('toyyibpay.payment.callback',  [$resData['domainrequest_id'], $resData['order_id'], $resData['coupon']]);
            $billCallbackUrl    = route('toyyibpay.payment.callback', [$resData['domainrequest_id'], $resData['order_id'], $resData['coupon']]);
            $someData           = array(
                'userSecretKey'             => $secretKey,
                'categoryCode'              => $categoryCode,
                'billName'                  => $billName,
                'billDescription'           => $description,
                'billPriceSetting'          => 1,
                'billPayorInfo'             => 1,
                'billAmount'                => 100 * $amount,
                'billReturnUrl'             => $billReturnUrl,
                'billCallbackUrl'           => $billCallbackUrl,
                'billExternalReferenceNo'   => 'AFR341DFI',
                'billTo'                    => $resData['name'],
                'billEmail'                 => $resData['email'],
                'billPhone'                 => '0194342411',
                'billSplitPayment'          => 0,
                'billSplitPaymentArgs'      => '',
                'billPaymentChannel'        => '0',
                'billContentEmail'          => $billContentEmail,
                'billChargeToCustomer'      => 1,
                'billExpiryDate'            => $billExpiryDate,
                'billExpiryDays'            => 3
            );

            $curl       = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $someData);
            $result     = curl_exec($curl);
            $info       = curl_getinfo($curl);
            curl_close($curl);
            $obj        = json_decode($result);
            return redirect('https://toyyibpay.com/' . $obj[0]->BillCode);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function toyyibpayCallback(Request $request, $domainrequest_id, $orderId, $couponId)
    {
        if ($request->status_id == 1) {
            $datas                  = Order::find($orderId);
            $datas->status          = 1;
            $datas->payment_id      = $request->transaction_id;
            $datas->payment_type    = 'toyyibpay';
            $datas->update();
            $coupons = Coupon::find($couponId);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $domainrequest_id;
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
        } else if ($request->status_id == 3) {
            $order                  = Order::find($orderId);
            $order->status          = 2;
            $order->payment_id = $request->transaction_id;
            $order->payment_type    = 'toyyibpay';
            $order->update();
            return redirect()->back()->with('failed', __('Payment failed.'));
        } else {
            return redirect()->back()->with('failed', __('Payment pending.'));
        }
    }
}
