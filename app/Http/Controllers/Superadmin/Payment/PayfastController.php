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

class PayfastController extends Controller
{
    public function payfastPrepare(Request $request)
    {
        $planID                 = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan                   = Plan::find($planID);
        $payfastMerchantId      = UtilityFacades::getsettings('payfast_merchant_id');
        $payfastMerchantKey     =  UtilityFacades::getsettings('payfast_merchant_key');
        $payfastSignature       = UtilityFacades::getsettings('payfast_signature');
        $resData   =  tenancy()->central(function ($tenant) use ($plan, $request) {
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
        $success = Crypt::encrypt([
            'plan_id'           => $plan->id,
            'order_id'          => $resData['order_id'],
            'domainrequest_id'  => $resData['domainrequest_id'],
            'coupon'            => $resData['coupon'],
            'plan_amount'       => $resData['total_price'],
            'flag'              => 'success',
        ]);
        $error = Crypt::encrypt([
            'plan_id'           => $plan->id,
            'order_id'          => $resData['order_id'],
            'domainrequest_id'  => $resData['domainrequest_id'],
            'coupon'            => $resData['coupon'],
            'plan_amount'       => $resData['total_price'],
            'flag'              => 'error',
        ]);
        $data = array(
            // Merchant details
            'merchant_id'   => $payfastMerchantId,
            'merchant_key'  => $payfastMerchantKey,
            'return_url'    => route('payfast.callback', $success),
            'cancel_url'    => route('payfast.callback', $error),
            'notify_url'    => route('payfast.callback', $success),
            // Buyer details
            'name_first'    => $resData['name'],
            'name_last'     => '',
            'email_address' => $resData['email'],
            // Transaction details
            'm_payment_id'  => $resData['order_id'], //Unique payment ID to pass through to notify_url
            'amount'        => number_format(sprintf('%.2f', $resData['total_price']), 2, '.', ''),
            'item_name'     => $plan->name,
        );
        $passphrase         = $payfastSignature;
        $signature          = $this->generateSignature($data, $passphrase);
        $data['signature']  = $signature;
        $htmlForm           = '';
        foreach ($data as $name => $value) {
            $htmlForm .= '<input name="' . $name . '" type="hidden" value=\'' . $value . '\' />';
        }
        return response()->json([
            'success'   => true,
            'inputs'    => $htmlForm,
        ]);
    }

    public function generateSignature($data, $passPhrase = null)
    {
        $pfOutput = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }
        return md5($getString);
    }

    public function payfastCallback(Request $request, $data)
    {
        $data       = Crypt::decrypt($data);
        if ($data['flag'] == 'success') {
            $datas                  = Order::find($data['order_id']);
            $datas->status          = 1;
            $datas->amount          = $data['plan_amount'];
            $datas->payment_id      = $request->signature;
            $datas->payment_type    = 'payfast';
            $datas->update();
            $coupons    = Coupon::find($data['coupon']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data['domainrequest_id'];
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
            $order->amount          = $data['plan_amount'];
            $order->payment_id      = $request->signature;
            $order->payment_type    = 'payfast';
            $order->update();
            return redirect()->back()->with('failed', __('Payment Failed.'));
        }
    }
}
