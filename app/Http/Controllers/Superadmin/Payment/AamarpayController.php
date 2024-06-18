<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use Illuminate\Support\Facades\Crypt;
use App\Models\UserCoupon;

class AamarpayController extends Controller
{
    public function planPayAamarpay(Request $request)
    {
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $url        = 'https://sandbox.aamarpay.com/request.php';
        $aamarpayStoreId      = UtilityFacades::getsettings('aamarpay_store_id');
        $aamarpaySignatureKey = UtilityFacades::getsettings('aamarpay_signature_key');
        $aamarpayDescription  = UtilityFacades::getsettings('aamarpay_description');
        $currency             = UtilityFacades::getsettings('currency');
        $resData =  tenancy()->central(function ($tenant) use ($plan, $request) {
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
                    $resData['errors'] = __('This coupon code has expired.');
                } else {
                    $discount       = $coupons->discount;
                    $discount_type  = $coupons->discount_type;
                    $discountValue  =  UtilityFacades::calculateDiscount($price, $discount, $discount_type);
                    $price          = $price - $discountValue;
                    if ($price < 0) {
                        $price  = $plan->price;
                    }
                    $couponId   = $coupons->id;
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
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            $resData['phone']               = $requestDomain->phone;
            $resData['country']             = $requestDomain->country;
            return $resData;
        });
        if ($resData['phone'] == null) {
            return redirect()->back()->with('failed', __('Please add phone number to your profile.'));
        }
        try {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            $fields = array(
                'store_id'      => $aamarpayStoreId,
                'amount'        => $resData['total_price'],
                'payment_type'  => '',
                'currency'      => $currency,
                'tran_id'       => $orderID,
                'cus_name'      => $resData['name'],
                'cus_email'     => $resData['email'],
                'cus_add1'      => '',
                'cus_add2'      => '',
                'cus_city'      => '',
                'cus_state'     => '',
                'cus_postcode'  => '',
                'cus_country'   => $resData['country'],
                'cus_phone'     => $resData['phone'],
                'success_url'   => route('plan.payment.aamarpay', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'response' => 'success', 'coupon_id' => $resData['coupon'], 'plan_id' => $plan->id, 'price' => $resData['total_price'], 'order_id' => $resData['order_id']])),
                'fail_url'      => route('plan.payment.aamarpay', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'response' => 'failure', 'coupon_id' => $resData['coupon'], 'plan_id' => $plan->id, 'price' => $resData['total_price'], 'order_id' => $resData['order_id']])),
                'cancel_url'    => route('plan.payment.aamarpay', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'response' => 'cancel', 'coupon_id' => $resData['coupon'], 'plan_id' => $plan->id, 'price' => $resData['total_price'], 'order_id' => $resData['order_id']])),
                'signature_key' => $aamarpaySignatureKey,
                'desc'          => $aamarpayDescription,
            );
            $fieldsString   = http_build_query($fields);
            $ch             = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $urlForward    = str_replace('"', '', stripslashes(curl_exec($ch)));
            curl_close($ch);
            $this->redirect_to_merchant($urlForward);
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e);
        }
    }

    function redirect_to_merchant($url)
    {
        $token = csrf_token();
        ?>
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <script type="text/javascript">
                        function closethisasap() {
                            document.forms["redirectpost"].submit();
                        }
                    </script>
                </head>
                <body onLoad="closethisasap();">
                    <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/' . $url; ?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </body>
            </html>
        <?php
        exit;
    }

    public function getPayAamarpayStatus($data)
    {
        $data   = Crypt::decrypt($data);
        $order  = tenancy()->central(function ($tenant) use ($data) {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            if ($data['response'] == "success") {
                $order                  = Order::find($data['order_id']);
                $order->payment_id      = $orderID;
                $order->status          = 1;
                $order->payment_type    = 'aamarpay';
                $order->update();
                $coupons    = Coupon::find($data['coupon_id']);
                if (!empty($coupons)) {
                    $userCoupon                 = new UserCoupon();
                    $userCoupon->domainrequest  = $data['requestdomain_id'];
                    $userCoupon->coupon         = $coupons->id;
                    $userCoupon->order          = $order->id;
                    $userCoupon->save();
                    $usedCoupun     = $coupons->used_coupon();
                    if ($coupons->limit <= $usedCoupun) {
                        $coupons->is_active = 0;
                        $coupons->save();
                    }
                }
                if (UtilityFacades::getsettings('approve_type') == 'Auto') {
                    UtilityFacades::approved_request($order);
                }
                return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
            } elseif ($data['response'] == "cancel") {
                $order                  = Order::find($data['order_id']);
                $order->payment_id      = $orderID;
                $order->status          = 2;
                $order->payment_type    = 'aamarpay';
                $order->update();
                return redirect()->route('landingpage')->with('failed', __('Ypur Payment canceled.'));
            } else {
                $order = Order::find($data['order_id']);
                $order->payment_id      = $orderID;
                $order->status          = 2;
                $order->payment_type    = 'aamarpay';
                $order->update();
                return redirect()->route('landingpage')->with('errors', __('Your Transaction is fail please try again'));
            }
        });
        return redirect()->route('landingpage');
    }
}
