<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use App\Models\LoginSecurity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginSecurityController extends Controller
{
    protected $country;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user     = Auth::user();
            return $next($request);
        });
        $path               = storage_path() . "/json/country.json";
        $this->countries    = json_decode(file_get_contents($path), true);
    }

    public function show2faForm()
    {
        $user   = Auth::user();
        $google2faUrl  = "";
        $secretKey     = "";
        if ($user->loginSecurity()->exists()) {
            $google2fa      = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2faUrl  = $google2fa->getQRCodeInline(
                @UtilityFacades::getsettings('app_name'),
                $user->name,
                $user->loginSecurity->google2fa_secret
            );
            $secretKey = $user->loginSecurity->google2fa_secret;
        }
        $user       = auth()->user();
        $role       = $user->roles->first();
        $tenantId   = tenant('id');
        $countries  = $this->countries;
        $data       = array(
            'user'          => $user,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'tenant_id'     => $tenantId
        );
        return view('admin.profile.index', [
            'user'          => $user,
            'role'          => $role,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'countries'     => $countries,
            'tenant_id'     => $tenantId
        ]);
    }

    public function generate2faSecret()
    {
        $user           = Auth::user();
        $google2fa      = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $loginSecurity = LoginSecurity::firstOrNew(array('user_id' => $user->id));
        $loginSecurity->user_id            = $user->id;
        $loginSecurity->google2fa_enable   = 0;
        $loginSecurity->google2fa_secret   = $google2fa->generateSecretKey();
        $loginSecurity->save();
        return redirect('/2fa')->with('success', __("Secret key is generated."));
    }

    public function enable2fa(Request $request)
    {
        $user       = Auth::user();
        $google2fa  = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $secret     = $request->input('secret');
        $valid      = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
        if ($valid) {
            $user->loginSecurity->google2fa_enable = 1;
            $user->loginSecurity->save();
            return redirect('2fa')->with('success', __("2FA is enabled successfully."));
        } else {
            return redirect('2fa')->with('failed', __("Invalid verification code, Please try again."));
        }
    }

    public function disable2fa(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("failed", __("Your password does not matches with your account password. Please try again."));
        }
        request()->validate([
            'current-password' => 'required',
        ]);
        $user                                   = Auth::user();
        $user->loginSecurity->google2fa_enable  = 0;
        $user->loginSecurity->save();
        return redirect('/2fa')->with('success', __("2FA is now disabled."));
    }
}
