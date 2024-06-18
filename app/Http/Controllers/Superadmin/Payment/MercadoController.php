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
use Exception;
use Illuminate\Support\Facades\Crypt;

class MercadoController extends Controller
{
    public function mercadoPagoPayment(Request $request)
    {
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
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
            $resData['requestdomain_id']    = $requestDomain->id;
            $resData['total_price']         = $price;
            $resData['coupon']              = $couponId;
            $resData['order_id']            = $order->id;
            return $resData;
        });
        $mercado_access_token   = UtilityFacades::getsettings('mercado_access_token');
        require_once 'vendor/autoload.php'; // You have to require the library from your Composer vendor folder

        MercadoPago\SDK::setAccessToken($mercado_access_token); // Either Production or SandBox AccessToken
  
    
        try {
          
    
          
            $preference = new MercadoPago\Payment();
           
            $item              = new \MercadoPago\Item();
            $item->title       = "Plan : " . $plan->name;
            $item->quantity    = 1;
            $item->unit_price  = $resData['total_price'];
            $preference->items = array($item);
            $success_url       = route('mercado.callback', [Crypt::encrypt(['order_id' => $resData['order_id'], 'requestdomain_id' => $resData['requestdomain_id'], 'coupon' => $resData['coupon'], 'flag' => 'success'])]);
            $failure_url       = route('mercado.callback', [Crypt::encrypt(['order_id' => $resData['order_id'], 'requestdomain_id' => $resData['requestdomain_id'], 'coupon' => $resData['coupon'], 'flag' => 'failure'])]);
            $pending_url       = route('mercado.callback', [Crypt::encrypt(['order_id' => $resData['order_id'], 'requestdomain_id' => $resData['requestdomain_id'], 'coupon' => $resData['coupon'], 'flag' => 'pending'])]);

            $preference->back_urls = array(
                "success" => $success_url,
                "failure" => $failure_url,
                "pending" => $pending_url,
            );
            $preference->auto_return = "approved";
            $preference->save();

      
                return $preference;



            if (UtilityFacades::getsettings('mercado_mode') == 'live') {
                $redirectUrl = $preference->init_point;
                return redirect($redirectUrl);
            } else {
                $redirectUrl = $preference->sandbox_init_point;
                return redirect($redirectUrl);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('failed', __('Something went wrong.'));
        }
    }

    public function mercadoPagoPaymentCallback(Request $request, $data)
    {
        $data   = Crypt::decrypt($data);
        if ($data['flag'] == 'success') {
            $datas                  = Order::find($data['order_id']);
            $datas->status          = 1;
            $datas->payment_id      = $request->payment_id;
            $datas->payment_type    = 'mercadopago';
            $datas->update();
            $coupons    = Coupon::find($data['coupon']);
            if (!empty($coupons)) {
                $userCoupon                 = new UserCoupon();
                $userCoupon->domainrequest  = $data['requestdomain_id'];
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
            $order->payment_id      = $request->transaction_id;
            $order->payment_type    = 'mercadopago';
            $order->update();
            return redirect()->back()->with('failed', __('Payment Failed.'));
        }
    }
}

