<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsurePhoneIsVerified
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() || (! $request->user()->hasVerifiedPhone())) {
            return $request->expectsJson()
                    ? abort(403, 'Your phone number is not verified.')
                    : Redirect::guest(URL::route('smsindex.verification'));
        }
        return $next($request);
    }
}
