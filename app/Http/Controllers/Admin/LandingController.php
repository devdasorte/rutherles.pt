<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\ConatctMail;
use App\Models\Posts;
use Spatie\MailTemplates\Models\MailTemplate;
use App\Models\Faq;
use App\Models\FooterSetting;
use App\Models\NotificationsSetting;
use App\Models\Testimonial;
use App\Notifications\Admin\ConatctNotification;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;
class LandingController extends Controller
{
    public function landingPage(Request $request)
    
      
    {
        
        
        $order_list =DB::table('order_list')->get();
        $products = DB::table('product_list')->get();
        $customer_list = DB::table('customer_list')->get();
        $centralDomain = config('tenancy.central_domains')[0];
        $currentDomain = tenant('domains');
        
        if (!empty($currentDomain)) {
            $currentDomain = $currentDomain->pluck('domain')->toArray()[0];
        }
        if ($currentDomain == null) {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            }
            $lang   = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            return view('welcome', compact('lang'));
        } else {
             return view('rifa.index');
        }
    }



    public function campanha($page = null, $slug = null)
    {
        $lang       = UtilityFacades::getActiveLanguage();
        $page       = $page;
        $slug       = $slug;
        \App::setLocale($lang);

        switch ($page) {
            case 'campanha/' . $slug:
                return view('rifa.index', compact('slug', 'page'));
                break;
        }
    }
    public function rifa($path = null, $slug = null)

    {
        $page = $path;
        $slug = $slug . '/' . $page;
        $cam = '';



        if ($slug == 'campanha/' . $page) {
            $cam = 'products.view_product';
        } elseif ($slug == '/campanhas') {
            $cam = 'campaign';
        } elseif ($slug == '/concluidas') {
            $cam = 'campaign-finished';
        } elseif ($slug == '/em-breve') {
            $cam = 'campaign-soon';
        } elseif ($slug == '/contato') {
            $cam = 'contact';
        } elseif ($slug == '/termos-de-uso') {
            $cam = 'terms';
        } elseif ($slug == '/recuperar-senha') {
            $cam = 'recover-password';
        } elseif ($slug == '/user/compras') {
            $cam = 'orders.index';
        } elseif ($slug == '/user/alterar-senha') {
            $cam = 'change-password';
        } elseif ($slug == '/user/atualizar-cadastro') {
            $cam = 'update-registration';
        } elseif ($slug == '/user/afiliado') {
            $cam = 'affiliate';
        } elseif ($slug == '/meus-numeros') {
            $cam = 'my-numbers';
        } elseif ($slug == '/ganhadores') {
            $cam = 'winners';
        } elseif ($slug == '/cadastrar') {
            $cam = 'register';
        } elseif ($slug == 'compra/' . $page) {
            $cam = 'orders.view_order';
        } else {
            $cam = 'home';
        }
        return view('rifa.index', compact('page', 'slug', 'cam'));
    }

    public function contactUs()
    {
        $lang       = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('contactus', compact('lang'));
    }

    public function termsAndConditions()
    {
        $lang       = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('terms-and-conditions', compact('lang'));
    }

    public function faqs()
    {
        $lang       = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $faqs       = Faq::orderBy('order')->get();
        return view('faq', compact('lang', 'faqs'));
    }

    public function contactMail(Request $request)
    {
        if (UtilityFacades::getsettings('contact_us_recaptcha_status') == '1') {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        $user   = User::where('tenant_id', tenant('id'))->first();
        $notify = NotificationsSetting::where('title', 'New Enquiry Details')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->notify = '1') {
                    $user->notify(new ConatctNotification($request));
                }
            }
        }
        if (UtilityFacades::getsettings('email_setting_enable') == 'on'  && UtilityFacades::getsettings('contact_email') != '') {
            if (isset($notify)) {
                if ($notify->email_notification == '1') {
                    if (UtilityFacades::getsettings('email_setting_enable') == 'on' && UtilityFacades::getsettings('contact_email') != '') {
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
        }
        return redirect()->back()->with('success', __('Enquiry details send successfully'));
    }

    public function changeLang($lang = '')
    {
        if ($lang == '') {
            $lang   = UtilityFacades::getActiveLanguage();
        }
        Cookie::queue('lang', $lang, 120);
        return redirect()->back()->with('success',__('Language successfully changed.'));
    }
}
