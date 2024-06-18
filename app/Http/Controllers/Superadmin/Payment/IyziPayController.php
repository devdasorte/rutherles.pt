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
use Illuminate\Support\Facades\Http;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Options;

class IyziPayController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan           =  Plan::find($planID);
        $iyzipayKey     = UtilityFacades::getsettings('iyzipay_key');
        $iyzipaySecret  = UtilityFacades::getsettings('iyzipay_secret');
        $iyzipayMode    =  UtilityFacades::getsettings('iyzipay_mode');
        $currency       = UtilityFacades::getsettings('currency');
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
            $resData['total_price']        = $price;
            $resData['requestdomain_id']   = $requestDomain->id;
            $resData['coupon']             = $couponId;
            $resData['order_id']           = $order->id;
            return $resData;
        });
        $requestDomain  = RequestDomain::find($resData['requestdomain_id']);
        // set your Iyzico API credentials
        try {
            $setBaseUrl     = ($iyzipayMode == 'sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
            $options        = new Options();
            $options->setApiKey($iyzipayKey);
            $options->setSecretKey($iyzipaySecret);
            $options->setBaseUrl($setBaseUrl); // or "https://api.iyzipay.com" for production
            $ipAddress      = Http::get('https://ipinfo.io/?callback=')->json();
            $address        = 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1';
            // create a new payment request
            $request        = new CreateCheckoutFormInitializeRequest();
            $request->setLocale("en");
            $request->setPrice($resData['total_price']);
            $request->setPaidPrice($resData['total_price']);
            $request->setCurrency($currency);
            $request->setCallbackUrl(route('iyzipay.callback'));
            $request->setEnabledInstallments(array(1));
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
            $buyer          = new \Iyzipay\Model\Buyer();
            $buyer->setId($requestDomain->id);
            $buyer->setName(explode(' ', $requestDomain->name)[0]);
            $buyer->setSurname(explode(' ', $requestDomain->name)[1]);
            $buyer->setGsmNumber("+" . 911230124578);
            $buyer->setEmail($requestDomain->email);
            $buyer->setIdentityNumber(rand(0, 999999));
            $buyer->setLastLoginDate("2023-03-05 12:43:35");
            $buyer->setRegistrationDate("2023-04-21 15:12:09");
            $buyer->setRegistrationAddress($address);
            $buyer->setIp($ipAddress['ip']);
            $buyer->setCity($ipAddress['city']);
            $buyer->setCountry($ipAddress['country']);
            $buyer->setZipCode($ipAddress['postal']);
            $request->setBuyer($buyer);
            $shippingAddress    = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName($requestDomain->name);
            $shippingAddress->setCity($ipAddress['city']);
            $shippingAddress->setCountry($ipAddress['country']);
            $shippingAddress->setAddress($address);
            $shippingAddress->setZipCode($ipAddress['postal']);
            $request->setShippingAddress($shippingAddress);
            $billingAddress     = new \Iyzipay\Model\Address();
            $billingAddress->setContactName($requestDomain->name);
            $billingAddress->setCity($ipAddress['city']);
            $billingAddress->setCountry($ipAddress['country']);
            $billingAddress->setAddress($address);
            $billingAddress->setZipCode($ipAddress['postal']);
            $request->setBillingAddress($billingAddress);
            $basketItems        = array();
            $firstBasketItem    = new \Iyzipay\Model\BasketItem();
            $firstBasketItem->setId("BI101");
            $firstBasketItem->setName("Binocular");
            $firstBasketItem->setCategory1("Collectibles");
            $firstBasketItem->setCategory2("Accessories");
            $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $firstBasketItem->setPrice($resData['total_price']);
            $basketItems[0]     = $firstBasketItem;
            $request->setBasketItems($basketItems);
            $checkoutFormInitialize = CheckoutFormInitialize::create($request, $options);
            return redirect()->to($checkoutFormInitialize->getpaymentPageUrl());
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('errors', $e->getMessage());
        }
    }

    public function iyzipayCallback(Request $request)
    {
        $order                  = Order::orderBy('id', 'desc')->first();
        $order->status          = 1;
        $order->payment_type    = 'iyzipay';
        $order->payment_id      = $request->token;
        $order->update();
        $coupons                = Coupon::where('code', $order->coupon_code)->where('is_active', '1')->first();
        if (!empty($coupons)) {
            $userCoupon                 = new UserCoupon();
            $userCoupon->domainrequest  = $order->domainrequest_id;
            $userCoupon->coupon         = $coupons->id;
            $userCoupon->order          = $order->id;
            $userCoupon->save();
            $usedCoupun                 = $coupons->used_coupon();
            if ($coupons->limit <= $usedCoupun) {
                $coupons->is_active = 0;
                $coupons->save();
            }
        }
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }
}

