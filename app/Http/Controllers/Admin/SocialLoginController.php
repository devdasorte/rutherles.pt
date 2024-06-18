<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SocialLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    public function redirect($type)
    {
        $redirectUrl = route('social.callback', $type);
        return Socialite::driver($type)->redirectUrl($redirectUrl)->redirect();
    }

    public function callback($type)
    {
        try {
            $user       = Socialite::driver($type)->user();
            $contents   = file_get_contents($user->avatar);
            $name       = substr($user->avatar, strrpos($user->avatar, '/') + 1);
            $picture    = Storage::put("uploads/avatar/" . $user->getId() . ".png", $contents);
            $avatar     = "uploads/avatar/" . $user->getId() . ".png";

            $findUser   = SocialLogin::where('social_id', $user->id)->first();
            if ($findUser) {
                $existUser              = User::find($findUser->user_id);
                $existUser->social_type = $type;
                $existUser->save();
                Auth::login($existUser);
                return redirect()->intended('home');
            } else {
                $checkUser      =  User::where('email', $user->email)->first();
                if (!$checkUser) {
                    $name       = ($type  == 'github') ? $user->nickname : $user->name;
                    $newUser    = User::create([
                        'name'          => $name,
                        'email'         => $user->email,
                        'password'      => Hash::make('123456dummy'),
                        'type'          => 'User',
                        'lang'          => 'en',
                        'created_by'    => '1',
                        'plan_id'       => '1',
                        'avatar'        => $avatar,
                        'social_type'   => $type,
                    ]);
                    $newUser->assignRole('User');
                    SocialLogin::create([
                        'user_id'       => $newUser->id,
                        'social_type'   => $type,
                        'social_id'     => $user->id,
                    ]);
                    $newUser->social_type = $type;
                    $newUser->save();
                    Auth::login($newUser);
                } else {
                    SocialLogin::create([
                        'user_id'       => $checkUser->id,
                        'social_type'   => $type,
                        'social_id'     => $user->id,
                    ]);
                    $checkUser->social_type = $type;
                    $checkUser->save();
                    Auth::login($checkUser);
                }
                return redirect()->intended('home');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
