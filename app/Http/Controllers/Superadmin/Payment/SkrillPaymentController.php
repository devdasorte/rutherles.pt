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
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;
use Illuminate\Http\RedirectResponse;

class SkrillPaymentController extends Controller
{
    public function planPaySkrill(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan           = Plan::find($planID);
        $skrillEmail    = UtilityFacades::getsettings('skrill_email');
        $currency       = UtilityFacades::getValByName('currency');
        $resData        =  tenancy()->central(function ($tenant) use ($plan, $request) {
            $order          = Order::find($request->order_id);
            $requestDomain  = RequestDomain::find($order->domainrequest_id);
            $orderID        = time();
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
            $order->status              = 0;
            $order->payment_id          = $orderID;
            $order->payment_type        = 'skrill';
            $order->save();
            $resData['total_price']         = $price;
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            $resData['payment_id']          = $orderID;
            $resData['name']                = $requestDomain->name;
            $resData['email']               = $requestDomain->email;
            return $resData;
        });
        $tran_id                = md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id');
        $skill                  = new SkrillRequest();
        $skill->pay_to_email    = $skrillEmail;
        $skill->return_url      = route('plan.skrill', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'order_id' => $resData['order_id'], 'payment_id' => $resData['payment_id'], 'amount' => $resData['total_price'], 'tansaction_id' => MD5($tran_id), 'payment_frequency' => $request->skrill_payment_frequency, 'coupon_id' => $resData['coupon'], 'plan_id' => $plan->id, 'firstname' => $resData['name'], 'email' => $resData['email'], 'status' => 'successfull']));
        $skill->cancel_url      = route('plan.skrill', Crypt::encrypt(['requestdomain_id' => $resData['requestdomain_id'], 'order_id' => $resData['order_id'], 'payment_id' => $resData['payment_id'], 'amount' => $resData['total_price'], 'tansaction_id' => MD5($tran_id), 'payment_frequency' => $request->skrill_payment_frequency, 'coupon_id' => $resData['coupon'], 'plan_id' => $plan->id, 'firstname' => $resData['name'], 'email' => $resData['email'], 'plan_id' => $plan->id, 'status' => 'failed']));
        $skill->transaction_id  = MD5($tran_id); // generate transaction id
        $skill->amount          = $resData['total_price'];
        $skill->currency        = $currency;
        $skill->language        = 'EN';
        $skill->prepare_only    = '1';
        $skill->merchant_fields = 'site_name, customer_email';
        $skill->site_name       = $resData['name'];
        $skill->customer_email  = $resData['email'];
        $client                 = new SkrillClient($skill);
        $sid                    = $client->generateSID();
        $jsonSID                = json_decode($sid);
        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST") {
            return redirect()->back()->with('errors', 'You dont have enough money in your balance. Make a deposit to your Skrill account or choose another payment option.');
        }
        $redirectUrl    = $client->paymentRedirectUrl($sid);
        if ($tran_id) {
            $data       = [
                'amount'    => $resData['total_price'],
                'trans_id'  => MD5($request['transaction_id']),
                'currency'  => $currency,
            ];
            session()->put('skrill_data', $data);
        }
        try {
            return  new RedirectResponse($redirectUrl);
        } catch (\Exception $e) {
            return redirect()->route('landingpage')->with('errors', __('Transaction has been failed!'));
        }
    }

    public function getPaySkrillCallback(Request $request, $data)
    {
        $data   = Crypt::decrypt($data);
        if ($request->status == 'successfull') {
            if (session()->has('skrill_data')) {
                $getData    = session()->get('skrill_data');
                $orderID    = time();
                $datas                  = Order::find($data['order_id']);
                $datas->payment_id      = $orderID;
                $datas->status          = 1;
                $datas->payment_type    = 'skrill';
                $datas->update();
                $coupons     = Coupon::find($data['coupon_id']);
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
                $order                  = Order::find($data['order_id']);
                $order->status          = 2;
                $order->payment_type    = 'skrill';
                $order->update();
                return redirect()->route('landingpage')->with('errors', __('Transaction has been failed! '));
            }
        } else {
            $order                  = Order::find($data['order_id']);
            $order->status          = 2;
            $order->payment_type    = 'skrill';
            $order->update();
            return redirect()->route('landingpage')->with('errors', __('Opps something went wrong.'));
        }
    }
}
