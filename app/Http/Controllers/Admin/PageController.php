<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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


class PageController extends Controller
{
public function campanhas($path = null)
{ 
    if($path == 'nova'){
        return view('admin.campanhas.nova');
    } elseif (is_numeric($path)) {
        return view('admin.campanhas.nova', ['id' => $path]);
    } else {
        return view('admin.campanhas.index');
    }
}
    public function usuarios($path = null)
    {
        if($path == 'novo'){
        return view('admin.usuarios.novo');
    } elseif (is_numeric($path)) {
        return view('admin.usuarios.novo', ['id' => $path]);
    } else {
        return view('admin.usuarios.index');
    }
    }

    public function relatorio()
    {
        return view('admin.relatorio.index');
    }

    public function ranking()
    {
        return view('admin.ranking.index');
    }

    public function pedidos($path = null)
    { 
if($path == 'novo'){
        return view('admin.pedidos.novo');
    } elseif (is_numeric($path)) {
        return view('admin.pedidos.novo', ['product_id' => $path]);
    } else {
        return view('admin.pedidos.index');
    }
    }

    public function clientes($path = null)
   { 
if($path == 'novo'){
        return view('admin.clientes.novo');
    } elseif (is_numeric($path)) {
        return view('admin.clientes.novo', ['id' => $path]);
    } else {
        return view('admin.clientes.index');
    }
}
    public function afiliados()
    {
        return view('admin.afiliados.index');
    }

    public function gateway()
    {
        return view('admin.gateway.index');
    }

    public function config()
    {
        return view('admin.config.index');
    }

    public function logs()
    {
        return view('admin.logs.index');
    }

    public function cotas()
    {
        return view('admin.cotas.index');
    }
 public function planos(){
        
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

  


}