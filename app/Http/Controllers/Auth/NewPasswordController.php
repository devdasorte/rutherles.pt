<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    public function create(Request $request, $token)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.reset-password', ['request' => $request,  'token' => $request->route('token'), 'lang' => $lang]);
    }

    public function store(Request $request)
    {
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                if (isset($user->tenant_id)) {
                    event(new PasswordReset($user));
                    tenancy()->initialize($user->tenant_id);
                    $users = User::where('tenant_id', $user->tenant_id)->first();
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                    ])->save();
                } else {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                    ])->save();
                }
            }
        );
        if ($status != Password::PASSWORD_RESET) {
            return back()->withInput($request->only('email'))->with('errors', __($status));
        }
        return redirect()->route('login')->with('status', __($status));
    }
}
