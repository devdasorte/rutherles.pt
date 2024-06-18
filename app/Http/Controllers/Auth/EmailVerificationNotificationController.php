<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request)
    {
        config([
            'mail.default' => UtilityFacades::getsettings('mail_mailer'),
            'mail.mailers.smtp.host' => UtilityFacades::getsettings('mail_host'),
            'mail.mailers.smtp.port' => UtilityFacades::getsettings('mail_port'),
            'mail.mailers.smtp.encryption' => UtilityFacades::getsettings('mail_encryption'),
            'mail.mailers.smtp.username' => UtilityFacades::getsettings('mail_username'),
            'mail.mailers.smtp.password' => UtilityFacades::getsettings('mail_password'),
            'mail.from.address' => UtilityFacades::getsettings('mail_from_address'),
            'mail.from.name' => UtilityFacades::getsettings('mail_from_name'),
        ]);
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return back()->with('errors', $e->getMessage());
        }
        return back()->with('status', 'verification-link-sent');
    }
}
