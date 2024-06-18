<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use App\Support\Google2FAAuthenticator;
use Closure;

class LoginSecurityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (UtilityFacades::getsettings('2fa') == '1') {
            $authenticator = app(Google2FAAuthenticator::class)->boot($request);
            if ($authenticator->isAuthenticated()) {
                return $next($request);
            }
            return $authenticator->makeRequestOneTimePasswordResponse();
        } else {
            return $next($request);
        }
    }
}
