<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\DataTables\Superadmin\RequestDomainDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Superadmin\ConatctMail;
use App\Mail\Superadmin\DisapprovedMail;
use App\Mail\Superadmin\RegisterMail;
use App\Models\Announcement;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\FooterSetting;
use App\Models\NotificationsSetting;
use App\Models\Testimonial;
use App\Notifications\Superadmin\ConatctNotification;
use App\Notifications\Superadmin\DisapprovedNotification;
use App\Notifications\Superadmin\RegisterNotification;
use Illuminate\Support\Facades\Auth;
use Spatie\MailTemplates\Models\MailTemplate;
use Illuminate\Support\Facades\Cookie;

class RequestDomainController extends Controller
{    
    
    
    public function pricing(){
        
       $centralDomain     = config('tenancy.central_domains')[0];
        $currentDomain     = tenant('domains');
        if (!empty($currentDomain)) {
            $currentDomain = $currentDomain->pluck('domain')->toArray()[0];
        }
        if ($currentDomain == null) {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            }
            $lang                           = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $appsMultipleImageSettings      = json_decode(UtilityFacades::getsettings('apps_multiple_image_setting'));
            $features                       = json_decode(UtilityFacades::getsettings('feature_setting'));
            $businessGrowthsSettings        = json_decode(UtilityFacades::getsettings('business_growth_setting'));
            $businessGrowthsViewSettings    = json_decode(UtilityFacades::getsettings('business_growth_view_setting'));
            $testimonials                   = Testimonial::where('status', 1)->get();
            $plans                          = Plan::where('active_status', 1)->get();
            $faqs                           = Faq::orderBy('order')->take(4)->get();
            $footerMainMenus                = FooterSetting::where('parent_id', 0)->get();
            $currentDate = now()->toDateString();
            $announcementLists = Announcement::where('status', '1')
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('share_with_public', '1')
                ->get();
            $announcementBars = Announcement::where('status', '1')
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('show_landing_page_announcebar', '1')
                ->get();
            if (UtilityFacades::getsettings('landing_page_status') == '1') {
                return view('admin.planos.index', compact(
                    'plans',
                    'features',
                    'faqs',
                    'testimonials',
                    'businessGrowthsSettings',
                    'businessGrowthsViewSettings',
                    'appsMultipleImageSettings',
                    'footerMainMenus',
                    'lang',
                    'announcementLists',
                    'announcementBars'
                ));
            } else {
                return redirect()->route('home');
            }
        } else {
            $lang                           = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $appsMultipleImageSettings      = json_decode(UtilityFacades::getsettings('apps_multiple_image_setting'));
            $features                       = json_decode(UtilityFacades::getsettings('feature_setting'));
            $businessGrowthsSettings        = json_decode(UtilityFacades::getsettings('business_growth_setting'));
            $businessGrowthsViewSettings    = json_decode(UtilityFacades::getsettings('business_growth_view_setting'));
            $testimonials                   = Testimonial::where('status', 1)->get();
            $plans                          = Plan::where('active_status', 1)->get();
            $faqs                           = Faq::orderBy('order')->take(4)->get();
            $footerMainMenus                = FooterSetting::where('parent_id', 0)->get();
            return view('admin.planos.index', compact(
                'plans',
                'features',
                'faqs',
                'testimonials',
                'businessGrowthsSettings',
                'businessGrowthsViewSettings',
                'appsMultipleImageSettings',
                'footerMainMenus',
                'lang'
            ));
        }
    }
    public function landingPage()
    {
        $centralDomain     = config('tenancy.central_domains')[0];
        $currentDomain     = tenant('domains');
        if (!empty($currentDomain)) {
            $currentDomain = $currentDomain->pluck('domain')->toArray()[0];
        }
        if ($currentDomain == null) {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            }
            $lang                           = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $appsMultipleImageSettings      = json_decode(UtilityFacades::getsettings('apps_multiple_image_setting'));
            $features                       = json_decode(UtilityFacades::getsettings('feature_setting'));
            $businessGrowthsSettings        = json_decode(UtilityFacades::getsettings('business_growth_setting'));
            $businessGrowthsViewSettings    = json_decode(UtilityFacades::getsettings('business_growth_view_setting'));
            $testimonials                   = Testimonial::where('status', 1)->get();
            $plans                          = Plan::where('active_status', 1)->get();
            $faqs                           = Faq::orderBy('order')->take(4)->get();
            $footerMainMenus                = FooterSetting::where('parent_id', 0)->get();
            $currentDate = now()->toDateString();
            $announcementLists = Announcement::where('status', '1')
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('share_with_public', '1')
                ->get();
            $announcementBars = Announcement::where('status', '1')
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('show_landing_page_announcebar', '1')
                ->get();
            if (UtilityFacades::getsettings('landing_page_status') == '1') {
                return view('welcome', compact(
                    'plans',
                    'features',
                    'faqs',
                    'testimonials',
                    'businessGrowthsSettings',
                    'businessGrowthsViewSettings',
                    'appsMultipleImageSettings',
                    'footerMainMenus',
                    'lang',
                    'announcementLists',
                    'announcementBars'
                ));
            } else {
                return redirect()->route('home');
            }
        } else {
            $lang                           = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $appsMultipleImageSettings      = json_decode(UtilityFacades::getsettings('apps_multiple_image_setting'));
            $features                       = json_decode(UtilityFacades::getsettings('feature_setting'));
            $businessGrowthsSettings        = json_decode(UtilityFacades::getsettings('business_growth_setting'));
            $businessGrowthsViewSettings    = json_decode(UtilityFacades::getsettings('business_growth_view_setting'));
            $testimonials                   = Testimonial::where('status', 1)->get();
            $plans                          = Plan::where('active_status', 1)->get();
            $faqs                           = Faq::orderBy('order')->take(4)->get();
            $footerMainMenus                = FooterSetting::where('parent_id', 0)->get();
            return view('welcome', compact(
                'plans',
                'features',
                'faqs',
                'testimonials',
                'businessGrowthsSettings',
                'businessGrowthsViewSettings',
                'appsMultipleImageSettings',
                'footerMainMenus',
                'lang'
            ));
        }
    }

    public function index(RequestDomainDataTable $dataTable)
    {
        if (Auth::user()->can('manage-domain-request')) {
            return $dataTable->render('superadmin.request-domain.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create($data)
    {
        try {
            $lang               = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $datas              = Crypt::decrypt($data);
            $planId            = $datas['plan_id'];
            $centralDomainIp   = gethostbyname(config('tenancy.central_domains')[0]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
        return view('superadmin.request-domain.create', compact('planId', 'data', 'lang', 'centralDomainIp'));
    }

    public function store(Request $request)
    {
        if (UtilityFacades::getsettings('domain_config') == 'on') {
            $request->merge(['domains' => $request->domains . '.' . parse_url(env('APP_URL'), PHP_URL_HOST)]);
        }
        request()->validate([
            'name'      => 'required|max:50',
            'email'     => 'required|email|unique:users,email,',
            'domains'   => 'required|unique:domains,domain|max:50',
            'password'  => 'same:password_confirmation',
            'phone'     => 'required|unique:users,phone,',
        ]);
        $domain                     = new RequestDomain();
        $domain->name               = $request->name;
        $domain->email              = $request->email;
        $domain->password           = Hash::make($request->password);
        $domain->domain_name        = $request->domains;
        $domain->actual_domain_name = $request->domains;
        $domain->plan_id            = $request->plan_id;
        $domain->country_code       = $request->country_code;
        $domain->dial_code          = $request->dial_code;
        $domain->phone              = str_replace(' ', '', $request->phone);
        $domain->type               = 'Admin';
        $domain->save();
        $centralDomain             = config('tenancy.central_domains')[0];
        $centralDomainIp           = gethostbyname($centralDomain);

        $user       = User::where('type', 'Super Admin')->first();
        $order      = tenancy()->central(function ($tenant) use ($request, $domain) {
            $data['plan_details']   = Plan::find($request->plan_id);
            $paymentType           = '';
            $paymentStatus         = 0;
            $data       = Order::create([
                'plan_id'           => $request->plan_id,
                'domainrequest_id'  => $domain->id,
                'amount'            => $data['plan_details']->price,
                'payment_type'      => $paymentType,
                'status'            => $paymentStatus,
            ]);
            return $data;
        });
        $notify         = NotificationsSetting::where('title', 'Register Mail')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->notify == '1') {
                    $user->notify(new RegisterNotification($centralDomainIp, $domain));
                }
                if ($notify->email_notification == '1') {
                    if (UtilityFacades::getsettings('mail_host') == true) {
                        if (MailTemplate::where('mailable', RegisterMail::class)->first()) {
                            try {
                                Mail::to($request->email)->send(new RegisterMail($request, $centralDomainIp));
                            } catch (\Exception $e) {
                                return redirect()->back()->with('errors', $e->getMessage());
                            }
                        }
                    }
                }
            }
        }
        $database       = $request->all();
        if ($request->plan_id != 1) {
            return redirect()->route('request.domain.payment', $order->id);
        } else {
            if (UtilityFacades::getsettings('database_permission') == 1) {
                UtilityFacades::approved_request($domain->id, $database);
            }
            return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
        }
    }

    public function approveStatus($id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            $requestDomain  = RequestDomain::find($id);
            if ($requestDomain->is_approved == 0) {
                return view('superadmin.request-domain.edit', compact('requestDomain'));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function disApproveStatus($id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            $requestDomain  = RequestDomain::find($id);
            if ($requestDomain->is_approved == 0) {
                $view       =   view('superadmin.request-domain.reason', compact('requestDomain'));
                return ['html' => $view->render()];
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            request()->validate([
                'reason'                => 'required',
            ]);
            $requestDomain              = RequestDomain::find($id);
            $requestDomain->reason      = $request->reason;
            $requestDomain->is_approved = 2;
            $requestDomain->update();
            $users      = User::where('type', 'Super Admin')->first();
            $notify     = NotificationsSetting::where('title', 'Domain Unverified')->first();
            if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                if (isset($notify)) {
                    if ($notify->notify == '1') {
                        $users->notify(new DisapprovedNotification($requestDomain));
                    }
                    if ($notify->email_notification == '1') {
                        if (MailTemplate::where('mailable', DisapprovedMail::class)->first()) {
                            try {
                                Mail::to($requestDomain->email)->send(new DisapprovedMail($requestDomain));
                            } catch (\Exception $e) {
                                return redirect()->back()->with('errors', $e->getMessage());
                            }
                        }
                    }
                }
            }
            return redirect()->back()->with('success', __('Domain request disapprove successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            $requestDomain = RequestDomain::find($id);
            return view('superadmin.request-domain.data-edit', compact('requestDomain'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function requestDomainUpdate(Request $request, $id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            if (UtilityFacades::getsettings('domain_config') == 'on') {
                $request->merge(['domains' => $request->domains . '.' . parse_url(env('APP_URL'), PHP_URL_HOST)]);
            }
            request()->validate([
                'name'      => 'required|max:50',
                'email'     => 'required|email|unique:users,email,',
                'domains'   => 'required|max:50|unique:domains,domain,',
                'password'  => 'same:password_confirmation',
                'phone'     => 'required|unique:users,phone,',
            ]);
            $requestDomain                          = RequestDomain::find($id);
            $requestDomain['name']                  = $request->name;
            $requestDomain['email']                 = $request->email;
            $requestDomain['country_code']          = $request->country_code;
            $requestDomain['dial_code']             = $request->dial_code;
            $requestDomain['phone']                 = str_replace(' ', '', $request->phone);
            $requestDomain['domain_name']           = $request->domains;
            $requestDomain['actual_domain_name']    = $request->domains;
            if (!empty($request->password)) {
                $requestDomain->password            = Hash::make($request->password);
            }
            $requestDomain->update();
            return redirect()->route('request.domain.index')->with('success', __('Domain request updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-domain-request')) {
            $requestDomain  = RequestDomain::find($id);
            $requestDomain->delete();
            return redirect()->route('request.domain.index')->with('success', __('Domain Request deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-domain-request')) {
            if (UtilityFacades::getsettings('domain_config') == 'on') {
                $request->merge(['domains' => $request->domains . '.' . parse_url(env('APP_URL'), PHP_URL_HOST)]);
            }

            request()->validate([
                'name'      => 'required|max:50',
                'email'     => 'required|email|unique:users,email,',
                'domains'   => 'required|max:50|unique:domains,domain',
                'phone'     => 'required|unique:users,phone,',
            ]);

            $data                       = RequestDomain::find($id);
            $data->name                 = $request->name;
            $data->email                = $request->email;
            $data->domain_name          = $request->domains;
            $data->actual_domain_name   = $request->domains;
            $data->country_code         = $request->country_code;
            $data->dial_code            = $request->dial_code;
            $data->phone                = str_replace(' ', '', $request->phone);
            $data->save();
            $database                   = $request->all();
            try {
                \DB::beginTransaction();
                UtilityFacades::approved_request($data->id, $database);
                \DB::commit();
            } catch (\Exception $e) {
                return redirect()->back()->with('errors', 'Please check database name, database user name and database password.');
            }
            return redirect()->route('request.domain.index')->with('success', __('User created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function payment(Request $request, $id)
    {
        $lang               = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $order                  = Order::find($id);
        $requestDomain          = RequestDomain::find($order->domainrequest_id);
        $plan                   = Plan::find($requestDomain->plan_id);
        $paymentTypes           = UtilityFacades::getpaymenttypes();
        $adminPaymentSetting    = UtilityFacades::getadminplansetting();
        return view('superadmin.request-domain.front-payment', compact('requestDomain', 'adminPaymentSetting', 'paymentTypes', 'order', 'plan', 'lang'));
    }

    public function contactUs()
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('contactus', compact('lang'));
    }

    public function termsAndConditions()
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('terms-and-conditions', compact('lang'));
    }

    public function faqs()
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $faqs = Faq::orderBy('order')->get();
        return view('faq', compact('lang', 'faqs'));
    }

    public function contactMail(Request $request)
    {
        if (UtilityFacades::getsettings('contact_us_recaptcha_status') == '1') {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        $user       = User::where('type', '=', 'Super Admin')->first();
        $notify     = NotificationsSetting::where('title', 'New Enquiry Details')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->notify = '1') {
                    $user->notify(new ConatctNotification($request));
                }
            }
        }
        if (UtilityFacades::getsettings('email_setting_enable') == 'on' && UtilityFacades::getsettings('contact_email') != '') {
            if (isset($notify)) {
                if (isset($notify->email_notification) == '1') {
                    if (MailTemplate::where('mailable', ConatctMail::class)->first()) {
                        try {
                            Mail::to(UtilityFacades::getsettings('contact_email'))->send(new ConatctMail($request->all()));
                        } catch (\Exception $e) {
                            return redirect()->back()->with('errors', $e->getMessage());
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('success', __('Enquiry details send successfully'));
    }

    //offline
    public function offlinePaymentEntry(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $order          = Order::find($request->order_id);
        $requestDomain  = RequestDomain::find($order->domainrequest_id);
        $plan           = Plan::find($planID);
        $couponId       = 0;
        $couponCode     = null;
        $discountValue  = null;
        $price          = $plan->price;
        $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
        if ($coupons) {
            $couponCode     = $coupons->code;
            $usedCoupun     = $coupons->used_coupon();
            if ($coupons->limit == $usedCoupun) {
                $res_data['error'] = __('This coupon code has expired.');
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
        $order->payment_type        = 'offline';
        $order->discount_amount     = $discountValue;
        $order->coupon_code         = $couponCode;
        $order->status              = 3;
        $order->save();
        return redirect()->route('landingpage')->with('status', __('Thanks for registration, Your account is in review and you get email when your account active.'));
    }

    public function changeLang($lang = '')
    {
        if ($lang == '') {
            $lang   = UtilityFacades::getActiveLanguage();
        }
        Cookie::queue('lang', $lang, 120);
        return redirect()->back()->with('success', __('Language successfully changed.'));
    }
}
