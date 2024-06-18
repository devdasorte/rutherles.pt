<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordResetLinkController extends Controller
{
    // use ResetsPasswords;
    public function create()
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.forgot-password', compact('lang'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status != Password::RESET_LINK_SENT) {
            return back()->withInput($request->only('email'))->with('errors', __($status));
        }
        return back()->with('status', __($status));
    }
}
