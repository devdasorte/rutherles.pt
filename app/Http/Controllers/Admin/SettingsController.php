<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use App\Mail\Admin\TestMail;
use App\Models\ChangeDomainRequest;
use App\Models\NotificationsSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;
use function PHPUnit\Framework\fileExists;

class SettingsController extends Controller
{
    public function index()
    {
        $user   = Auth::user()->tenant_id;
        $order  = tenancy()->central(function ($tenant) use ($user) {
            $changeDomainRequest = ChangeDomainRequest::where('tenant_id', $user)->latest()->first();
            return $changeDomainRequest;
        });
        $notificationsSettings = NotificationsSetting::all();
        return view('admin.settings.index', compact('order', 'notificationsSettings'));
    }

    public function appNameUpdate(Request $request)
    {
        request()->validate([
            'app_logo'          => 'image|max:5048|mimes:png',
            'app_dark_logo'     => 'image|max:5048|mimes:png',
            'favicon_logo'      => 'image|max:5048|mimes:png',

        ]);
        $data = [
            'app_name' => $request->app_name,
            'name' => $request->app_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address

        ];
        if ($request->app_logo) {
            Storage::delete(UtilityFacades::getsettings('app_logo'));
            $appLogoName        = 'app-logo.' . $request->app_logo->extension();
            $LogoName        = 'app-logo-' . time() . '.' . $request->app_logo->extension();
            $request->app_logo->storeAs('logo', $appLogoName);
            $request->app_logo->move(public_path('uploads'), $LogoName);
            $data['app_logo']   = 'logo/' . $appLogoName;
            $data['logo']   = 'uploads/' . $LogoName;
        }
        if ($request->app_dark_logo) {
            Storage::delete(UtilityFacades::getsettings('app_dark_logo'));
            $appDarkLogoName        = 'app-dark-logo.' . $request->app_dark_logo->extension();
            $DarkLogoName        = 'app-dark-logo-' . time() . '.' . $request->app_dark_logo->extension();
            $request->app_dark_logo->storeAs('logo', $appDarkLogoName);
            $request->app_dark_logo->move(public_path('uploads'), $appDarkLogoName);
            $data['app_dark_logo']  = 'logo/' . $appDarkLogoName;
            $data['dark_logo']  = 'uploads/' . $DarkLogoName;
        }
        if ($request->favicon_logo) {
            Storage::delete(UtilityFacades::getsettings('app-favicon_logo'));
            $faviconLogoName        = 'app-favicon-logo.' . $request->favicon_logo->extension();
            $favicoName        = 'favicon-' . time() . '.' . $request->favicon_logo->extension();

            $request->favicon_logo->storeAs('logo', $faviconLogoName);
            $request->favicon_logo->move(public_path('uploads'), $favicoName);
            $data['favicon_logo']   = 'logo/' . $faviconLogoName;
            $data['favicon']   = 'uploads/' . $favicoName;
        }
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('App Setting updated successfully.'));
    }

    public function cadastroSettingsUpdate(Request $request)
    {
   

        $data = [

            'enable_two_phone' => ($request->enable_two_phone == 'on') ? '1' : '0',
            'enable_password' => ($request->enable_password == 'on') ? '1' : '0',
            'enable_cpf' => ($request->enable_cpf == 'on') ? '1' : '0',
            'enable_email' => ($request->enable_email == 'on') ? '1' : '0',
            'enable_legal_age' => ($request->enable_legal_age == 'on') ? '1' : '0',
            'enable_address' => ($request->enable_address == 'on') ? '1' : '0',





        ];


        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }

        return redirect()->back()->with('success', __('General settings updated successfully.'));
    }


    public function authSettingsUpdate(Request $request)
    {
        $user = \Auth::user();

        $data = [
            '2fa'                   => ($request->two_factor_auth == 'on') ? '1' : '0',
            'enable_hide_numbers'   => ($request->enable_hide_numbers == 'on') ? '1' : '0',
            'enable_share' => ($request->enable_share == 'on') ? '1' : '0',
            'enable_multiple_order' => ($request->enable_multiple_order == 'on') ? '1' : '0',
            'enable_groups' => ($request->enable_groups == 'on') ? '1' : '0',


            'register_setting'      => ($request->register_setting == 'on') ? '1' : '0',


            'dark_mode'             => ($request->dark_mode == 'on') ? 'on' : 'off',
            'transparent_layout'    => ($request->transparent_layout == 'on') ? '1' : '0',
            'color'                 => ($request->color) ? $request->color : UtilityFacades::getsettings('color')


        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        $user->dark_layout          = ($request->dark_mode && $request->dark_mode == 'on') ? 1 : 0;

        $user->transprent_layout    = ($request->transparent_layout && $request->transparent_layout == 'on') ? 1 : 0;
        $user->theme_color          = ($request->color) ? $request->color : UtilityFacades::getsettings('color');
        $user->save();
        return redirect()->back()->with('success', __('General settings updated successfully.'));
    }

    public function changeDomainRequest(Request $request)
    {
        $order = tenancy()->central(function ($tenant) use ($request) {
            request()->validate([
                'domain_name' => 'required|max:50',
            ]);
            $data['name']               = Auth::user()->name;
            $data['email']              = Auth::user()->email;
            $data['domain_name']        = $request->domain_name;
            $data['actual_domain_name'] = $request->domain_name;
            $data['tenant_id']          = Auth::user()->tenant_id;
            $data['status']             = 0;
            $datas  = ChangeDomainRequest::create($data);
        });
        return redirect()->back()->with('success', __('Change domain request send successfully.'));
    }

    public function footerSettingsUpdate(Request $request)
    {
        $data = [
            'question1' => $request->question1,
            'question2' => $request->question2,
            'question3' => $request->question3,
            'question4' => $request->question4,
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
            
        ];

        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }

        
        return redirect()->back()->with('success', __('Storage setting updated successfully.'));
    }

    public function emailSettingUpdate(Request $request)
    {
        request()->validate([
            'mail_mailer'       => 'required',
            'mail_host'         => 'required',
            'mail_port'         => 'required',
            'mail_username'     => 'required|email',
            'mail_password'     => 'required',
            'mail_encryption'   => 'required',
            'mail_from_address' => 'required',
            'mail_from_name'    => 'required',
        ]);
        $data = [
            'email_setting_enable'  => $request->email_setting_enable == 'on' ? 'on' : 'off',
            'mail_mailer'           => $request->mail_mailer,
            'mail_host'             => $request->mail_host,
            'mail_port'             => $request->mail_port,
            'mail_username'         => $request->mail_username,
            'mail_password'         => $request->mail_password,
            'mail_encryption'       => $request->mail_encryption,
            'mail_from_address'     => $request->mail_from_address,
            'mail_from_name'        => $request->mail_from_name,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('Email Setting updated successfully.'));
    }

    public function pusherSettingUpdate(Request $request)
    {
        request()->validate([
            'pusher_id'         => 'required|regex:/^[0-9]+$/',
            'pusher_key'        => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_secret'     => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_cluster'    => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
        ]);
        $data = [
            'pusher_id'         => $request->pusher_id,
            'pusher_key'        => $request->pusher_key,
            'pusher_secret'     => $request->pusher_secret,
            'pusher_cluster'    => $request->pusher_cluster,
            'pusher_status'     => ($request->pusher_status == 'on') ? 1 : 0,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('Pusher API Keys updated successfully.'));
    }

    public function cookieSettingUpdate(Request $request)
    {
        request()->validate([
            'cookie_title'                  => 'required|max:50',
            'strictly_cookie_title'         => 'required|max:50',
            'cookie_description'            => 'required',
            'strictly_cookie_description'   => 'required',
            'contact_us_description'        => 'required',
            'contact_us_url'                => 'required',
        ]);
        $data = [
            'cookie_setting_enable'         => $request->cookie_setting_enable == 'on' ? 'on' : 'off',
            'cookie_logging'                => $request->cookie_logging == 'on' ? 'on' : 'off',
            'necessary_cookies'             => $request->necessary_cookies == 'on' ? 'on' : 'off',
            'cookie_title'                  => $request->cookie_title,
            'strictly_cookie_title'         => $request->strictly_cookie_title,
            'cookie_description'            => $request->cookie_description,
            'strictly_cookie_description'   => $request->strictly_cookie_description,
            'contact_us_description'        => $request->contact_us_description,
            'contact_us_url'                => $request->contact_us_url,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('Cookie updated successfully'));
    }

    public function CookieConsent(Request $request)
    {
        if (UtilityFacades::getsettings('cookie_setting_enable') == "on" &&  UtilityFacades::getsettings('cookie_logging') == "on") {
            try {
                $whichBrowser       = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
                // Generate new CSV line
                $browserName        = $whichBrowser->browser->name ?? null;
                $osName             = $whichBrowser->os->name ?? null;
                $browserLanguage    = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
                $deviceType         = UtilityFacades::GetDeviceType($_SERVER['HTTP_USER_AGENT']);
                $ip                 = $_SERVER['REMOTE_ADDR'];
                $query              = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
                if ($query['status'] == 'success') {
                    $date       = (new \DateTime())->format('Y-m-d');
                    $time       = (new \DateTime())->format('H:i:s') . ' UTC';
                    $newLine    = implode(',', [$ip, $date, $time, implode('-', $request['cookie']), $deviceType, $browserLanguage, $browserName, $osName, isset($query) ? $query['country'] : '', isset($query) ? $query['region'] : '', isset($query) ? $query['regionName'] : '', isset($query) ? $query['city'] : '', isset($query) ? $query['zip'] : '', isset($query) ? $query['lat'] : '', isset($query) ? $query['lon'] : '']);
                    if (!fileExists(Storage::url('cookie-csv/cookie_data.csv'))) {
                        $firstLine = 'IP,Date,Time,Accepted-cookies,Device type,Browser anguage,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                        file_put_contents(base_path() . Storage::url('cookie-csv/cookie_data.csv'), $firstLine . PHP_EOL, FILE_APPEND | LOCK_EX);
                    }
                    file_put_contents(base_path() . Storage::url('cookie-csv/cookie_data.csv'), $newLine . PHP_EOL, FILE_APPEND | LOCK_EX);
                }
            } catch (\Throwable $th) {
                return response()->json('errors');
            }
            return response()->json('success');
        }
        return response()->json('errors');
    }

    public function SeoSetting(Request $request)
    {
        request()->validate([
            'meta_title'        => 'required',
            'meta_keywords'     => 'required',
            'meta_description'  => 'required',
            'meta_image_logo'   => 'image|max:2048|mimes:jpeg,jpg,png,gif',
        ]);
        $data = [
            'meta_title'        => $request->meta_title,
            'meta_keywords'     => $request->meta_keywords,
            'meta_description'  => $request->meta_description,
        ];
        if ($request->meta_image_logo) {
            Storage::delete(UtilityFacades::getsettings('meta_image_logo'));
            $meta_image_logo            = 'meta-image-logo.' . $request->meta_image_logo->extension();
            $request->meta_image_logo->storeAs('seo', $meta_image_logo);
            $data['meta_image_logo']    = 'seo/' . $meta_image_logo;
        }
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('SEO Setting updated successfully'));
    }

    public function GoogleCalenderUpdate(Request $request)
    {

        $data = [
            'enable_groups' => ($request->enable_groups == 'on') ? '1' : '0',
            'telegram_group_url' => $request->telegram_group_url,
            'whatsapp_group_url' => $request->whatsapp_group_url,
            'enable_footer' => ($request->enable_footer == 'on') ? '1' : '0',
            'text_footer' => $request->text_footer,
            'whatsapp_footer' => $request->whatsapp_footer,
            'instagram_footer' => $request->instagram_footer,
            'facebook_footer' => $request->facebook_footer,
            'twitter_footer' => $request->twitter_footer,
            'youtube_footer' => $request->youtube_footer,
        ];

        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success',  __('Google calender API key updated successfully.'));
    }

    public function smsSettingUpdate(Request $request)
    {
        if ($request->smssetting == 'twilio') {
            request()->validate([
                'twilio_sid'        => 'required',
                'twilio_auth_token' => 'required',
                'twilio_verify_sid' => 'required',
                'twilio_number'     => 'required',
            ]);
        } else if ($request->smssetting == 'nexmo') {
            request()->validate([
                'nexmo_key'     => 'required',
                'nexmo_secret'  => 'required',
                'nexmo_url'     => 'required',
            ]);
        } else if ($request->smssetting == 'fast2sms') {
            request()->validate([
                'fast2sms_api_key' => 'required',
            ]);
        }
        $data = [
            'sms_setting_enable'    => $request->sms_setting_enable == 'on' ? 'on' : 'off',
            'smssetting'            => ($request->smssetting),
            'nexmo_key'             => $request->nexmo_key,
            'nexmo_secret'          => $request->nexmo_secret,
            'nexmo_url'             => $request->nexmo_url,
            'twilio_sid'            => $request->twilio_sid,
            'twilio_auth_token'     => $request->twilio_auth_token,
            'twilio_verify_sid'     => $request->twilio_verify_sid,
            'twilio_number'         => $request->twilio_number,
            'fast2sms_api_key'      => $request->fast2sms_api_key,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success',  __('Sms setting updated successfully.'));
    }

    public function socialSettingUpdate(Request $request)
    {

        $data = [

            'enable_pixel' => ($request->enable_pixel == 'on') ? '1' : '0',
            'google_ga4_id' => $request->google_ga4_id,
            'google_gtm_id' => $request->google_gtm_id,
            'facebook_pixel_id' => $request->facebook_pixel_id,
            'facebook_access_token' => $request->facebook_access_token,



        ];





        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }


        return redirect()->back()->with('success', __('Social setting updated successfully.'));
    }

    public function Update(Request $request)
    {
       
        $data = [
            'currency'                      => 'BRL',
            'currency_symbol'               => 'R$',
            'mercadopago_access_token'      => $request->mercadopago_access_token ? $request->mercadopago_access_token : '',
            'mercadopago_tax'               => $request->mercadopago_tax ? $request->mercadopago_tax : 0,
            'mercadopago'               => ( $request->get('mercadopago')) ? '1' : '2',

            'gerencianet_client_id'                  => $request->gerencianet_client_id ? $request->gerencianet_client_id : '',
            'gerencianet_client_secret'               => $request->gerencianet_client_secret ? $request->gerencianet_client_secret : '',

            'gerencianet'               => ($request->get('gerencianet')) ? '1' : '2',

            'gerencianet_tax'                   => $request->gerencianet_tax,
            'paggue_client_key'      => $request->paggue_client_key,
            'paggue_client_secret'  => $request->paggue_client_secret,
            'paggue_tax'            => $request->paggue_tax,
            'paggue'                 => ($request->get('paggue')) ? '1' : '2',

            'openpix_app_id'               => $request->openpix_app_id,
            'openpix_tax'            => $request->openpix_tax,
            'openpix'      => ($request->get('openpix')) ? '1' : '2',
            'pay2m'            => ($request->get('pay2m')) ? '1' : '2',

            'pay2m_client_id'           => $request->pay2m_client_id,
            'pay2m_client_secret'           => $request->pay2m_client_secret,
            'pay2m_tax'          => $request->pay2m_tax,

        ];
        if (Auth::user()->type == 'Admin') {
            foreach ($data as $key => $value) {
                UtilityFacades::storesettings([
                    'key'   => $key,
                    'value' => $value
                ]);
            }
        } else {
            foreach ($data as $key => $value) {
                UtilityFacades::setEnvironmentValue([$key => $value]);
            }
        }
        return redirect()->back()->with('success', __('Payment setting updated successfully.'));
    }

    public function testMail()
    {
        return view('admin.settings.test-mail');
    }

    public function testSendMail(Request $request)
    {
        $validator      = \Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            $messages   = $validator->getMessageBag();
            return redirect()->back()->with('errors', $messages->first());
        }
        $notify     = NotificationsSetting::where('title', 'Testing Purpose')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->email_notification == '1') {
                    if (MailTemplate::where('mailable', TestMail::class)->first()) {
                        try {
                            Mail::to($request->email)->send(new TestMail());
                        } catch (\Exception $e) {
                            return redirect()->back()->with('errors', $e->getMessage());
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('success', __('Email send successfully.'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName         = $request->file('upload')->getClientOriginalName();
            $fileName           = pathinfo($originName, PATHINFO_FILENAME);
            $extension          = $request->file('upload')->getClientOriginalExtension();
            $fileName           = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $url                = asset('public/images/' . $fileName);
            $msg                = 'Image uploaded successfully';
            $response           = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
