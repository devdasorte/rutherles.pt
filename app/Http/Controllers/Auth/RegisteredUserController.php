<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    use RegistersUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function create()
    {
        $userData = User::where('tenant_id', tenant('id'))->first();
        if ($userData->tenant_id) {
            $lang = UtilityFacades::getActiveLanguage();
            \App::setLocale($lang);
            $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->pluck('name', 'name')->all();
            return view('auth.register', compact('roles', 'lang'));
        } else {
            return redirect('login')->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => tenant('id'),
            'type' => UtilityFacades::getsettings('roles'),
            'created_by' => 1,
            'plan_id' => 1,
            'email_verified_at' => (UtilityFacades::getsettings('email_verification') == '1') ? null : Carbon::now()->toDateTimeString(),
            'country_code' => $request->country_code,
            'dial_code' => $request->dial_code,
            'phone' => str_replace(' ', '', $request->phone),
            'phone_verified_at' => Carbon::now(),
            'lang' => 'en',
        ]);
        $user->assignRole(UtilityFacades::getsettings('roles'));
        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
