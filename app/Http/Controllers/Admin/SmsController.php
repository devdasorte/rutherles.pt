<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use App\Models\User;
use App\Models\UserCode;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function smsNoticeIndex(Request $request)
    {
        $lang   = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        if (UtilityFacades::getsettings('sms_verification') == 1) {
            return view('auth.smsnotice', compact('lang'));
        } else {
            return redirect()->route('home');
        }
    }

    public function smsNoticeVerify(Request $request)
    {
        $smstype        = 'sms';
        $user           = User::where('email', $request->email)->where('phone', $request->phone)->first();
        $code           = rand(100000, 999999);
        $smsSetting     = UtilityFacades::getsettings('smssetting');
        if ($smsSetting == 'nexmo') {
            $response   = Http::asForm()->post(UtilityFacades::getsettings('nexmo_url'), [
                'api_key'       => UtilityFacades::getsettings('nexmo_key'),
                'api_secret'    => UtilityFacades::getsettings('nexmo_secret'),
                'from'          => UtilityFacades::getsettings('app_name'),
                'text'          => $code,
                'to'            => $user->dial_code . $user->phone,
            ]);
        }
        if ($smsSetting == 'fast2sms') {
            $fast2smsApiKey = UtilityFacades::getsettings('fast2sms_api_key');
            $url            = 'https://www.fast2sms.com/dev/bulkV2';
            if ($request->smstype == 'call') {
                $smstype = $request->smstype;
                $url     = 'https://www.fast2sms.com/dev/voice';
            }
            $fields = array(
                "variables_values"  => $code,
                "route"             => "otp",
                "numbers"           => $user->phone,
            );
            $curl   = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL             => $url,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_ENCODING        => "",
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_TIMEOUT         => 30,
                CURLOPT_SSL_VERIFYHOST  => 0,
                CURLOPT_SSL_VERIFYPEER  => 0,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   => "POST",
                CURLOPT_POSTFIELDS      => json_encode($fields),
                CURLOPT_HTTPHEADER      => array(
                    "authorization: " . $fast2smsApiKey,
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));
            $response   = curl_exec($curl);
            $err        = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return redirect()->back()->with('errors', $err);
            }
        }
        if ($smsSetting == 'twilio' || $smsSetting == 'fast2sms' || $smsSetting == 'nexmo' && $response->status() == 200) {
            UserCode::updateOrCreate(
                ['user_id'  => $user->id],
                ['code'     => $code]
            );
            $datas  =  UserCode::where('user_id', $user->id)->first();
            $data   = [];
            $data['code'] = $datas->code;
            $data['name'] = $user->name;
        } else {
            return redirect()->back()->with('errors', __('Please check nexmo sms setting.'));
        }
        if (UtilityFacades::getsettings('sms_verification') == 1) {
            if ($send_sms = SmsTemplate::where('event', 'verification code sms')->first()) {
                $send_sms->send("+" . $user->dial_code . $user->phone, $data);
            } else {
                return redirect()->back()->with('errors', __('Sms template not found.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Please check sms setting.'));
        }
        return redirect()->route('smsindex.verification', ['smstype' => $smstype])->with('success', __('Sms Code Successfully send.'));
    }

    public function smsIndex(Request $request)
    {
        $lang   = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        if (UtilityFacades::getsettings('sms_verification') == '1') {
            return view('auth.sms', compact('lang'));
        } else {
            return redirect()->route('home');
        }
    }

    public function smsVerify(Request $request)
    {
        $user   = Auth::user();
        if (!empty($user)) {
            if ($user->type == 'Super Admin') {
                if (UserCode::where('code', $request->code)->where('user_id', $user->id)->first()) {
                    $user['phone_verified_at'] = Carbon::now()->toDateTimeString();
                    $user->save();
                    return redirect()->route('home');
                } else {
                    return redirect()->back()->with('errors', __('Code invalid.'));
                }
            } elseif (!empty($user->id)) {
                if ($user->active_status == 1) {
                    if (UserCode::where('code', $request->code)->where('user_id', $user->id)->first()) {
                        $user['phone_verified_at'] = Carbon::now()->toDateTimeString();
                        $user->save();
                        return redirect()->route('home');
                    } else {
                        return redirect()->back()->with('errors', __('Code invalid.'));
                    }
                } else {
                    return redirect()->back()->with('errors', __('Please contact to administrator.'));
                }
            } else {
                return redirect()->back()->with('errors', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('errors', __('User not found.'));
        }
    }

    public function smsResend(Request $request)
    {
        $smstype    = 'sms';
        $user       = auth()->user();
        $code       = rand(100000, 999999);
        $smsSetting = UtilityFacades::getsettings('smssetting');
        if ($smsSetting == 'nexmo') {
            $response = Http::asForm()->post(UtilityFacades::getsettings('nexmo_url'), [
                'api_key'       => UtilityFacades::getsettings('nexmo_key'),
                'api_secret'    => UtilityFacades::getsettings('nexmo_secret'),
                'from'          => UtilityFacades::getsettings('app_name'),
                'text'          => $code,
                'to'            => $user->dial_code . $user->phone,
            ]);
        }
        if ($smsSetting == 'fast2sms') {
            $fast2smsApiKey = UtilityFacades::getsettings('fast2sms_api_key');
            $url            = 'https://www.fast2sms.com/dev/bulkV2';
            if ($request->smstype == 'call') {
                $smstype    = $request->smstype;
                $url        = 'https://www.fast2sms.com/dev/voice';
            }
            $fields = array(
                "variables_values"  => $code,
                "route"             => "otp",
                "numbers"           => $user->phone,
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL             => $url,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_ENCODING        => "",
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_TIMEOUT         => 30,
                CURLOPT_SSL_VERIFYHOST  => 0,
                CURLOPT_SSL_VERIFYPEER  => 0,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   => "POST",
                CURLOPT_POSTFIELDS      => json_encode($fields),
                CURLOPT_HTTPHEADER      => array(
                    "authorization: " . $fast2smsApiKey,
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));
            $response   = curl_exec($curl);
            $err        = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return redirect()->back()->with('errors', $err);
            }
        }
        if ($smsSetting == 'twilio' || $smsSetting == 'fast2sms' || $smsSetting == 'nexmo' && $response->status() == 200) {
            UserCode::updateOrCreate(
                ['user_id'  => $user->id],
                ['code'     => $code]
            );
            $datas  =  UserCode::where('user_id', '=', $user->id)->first();
            $data   = [];
            $data['code'] = $datas->code;
            $data['name'] = $user->name;
        } else {
            return redirect()->back()->with('errors', __('Please check nexmo sms setting.'));
        }
        if (UtilityFacades::getsettings('sms_verification') == 1) {
            if ($send_sms = SmsTemplate::where('event', 'verification code sms')->first()) {
                $send_sms->send("+" . $user->dial_code . $user->phone, $data);
            } else {
                return redirect()->back()->with('errors', __('Please check sms setting.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Please check sms setting.'));
        }
        return redirect()->route('sms.verification', ['smstype' => $smstype])->with('success', __('We have resent OTP on your mobile number.'));
    }
}
