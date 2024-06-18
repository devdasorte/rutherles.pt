<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $country;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user     = Auth::user();
            return $next($request);
        });
        $path = storage_path() . "/json/country.json";
        $this->countries    = json_decode(file_get_contents($path), true);
    }

    public function index()
    {
        if (!UtilityFacades::getsettings('2fa')) {
            $user       = auth()->user();
            $role       = $user->roles->first();
            $tenantId   = tenant('id');
            $countries  = $this->countries;
            return view('superadmin.profile.index', [
                'user'      => $user,
                'role'      => $role,
                'tenant_id' => $tenantId,
                'countries' => $countries,
            ]);
        }
        return $this->activeTwoFactor();
    }

    private function activeTwoFactor()
    {
        $user               = Auth::user();
        $google2faUrl       = "";
        $secretKey          = "";
        if ($user->loginSecurity()->exists()) {
            $google2fa      = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2faUrl   = $google2fa->getQRCodeInline(
                @UtilityFacades::getsettings('app_name'),
                $user->name,
                $user->loginSecurity->google2fa_secret
            );
            $secretKey     = $user->loginSecurity->google2fa_secret;
        }
        $user       = auth()->user();
        $role       = $user->roles->first();
        $tenantId   = tenant('id');
        $countries  = $this->countries;
        $data       = array(
            'user'          => $user,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'tenant_id'     => $tenantId,
            'countries'     => $countries

        );
        return view('superadmin.profile.index', [
            'user'          => $user,
            'role'          => $role,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'tenant_id'     => $tenantId,
            'countries'     => $countries

        ]);
    }

    public function BasicInfoUpdate(Request $request)
    {
        $user   = User::find(auth()->id());
        request()->validate([
            'name'          => 'required|regex:/^[A-Za-z0-9_.,() ]+$/|max:50',
            'address'       => 'required|regex:/^[A-Za-z0-9_.,() ]+$/|max:191',
            'country'       => 'required',
            'phone'         => 'required',
            'country_code'  => 'required',
            'dial_code'     => 'required',
        ]);
        $user->name         = $request->name;
        $user->address      = $request->address;
        $user->country      = $request->country;
        $user->country_code = $request->country_code;
        $user->dial_code    = $request->dial_code;
        $user->phone        = str_replace(' ', '', $request->phone);
        $user->save();
        return redirect()->back()->with('success',  __('Account details updated successfully.'));
    }

    public function LoginDetails(Request $request)
    {
        $userDetail     = Auth::user();
        $user           = User::findOrFail($userDetail['id']);
        request()->validate([
            'email'                 => 'required|email|unique:users,email,' . $userDetail['id'],
            'avatar'                => 'image|mimes:jpeg,png,jpg,svg|max:3072',
            'password'              => 'required|string|min:5|confirmed',
            'password_confirmation' => 'same:password',
        ]);
        if ($request->hasFile('avatar')) {
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir             = storage_path('avatar/');
            $imagePath      = $dir . $userDetail['avatar'];
            if (File::exists($imagePath)) {
                //File::delete($imagePath);
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $path = $request->file('avatar')->storeAs('avatar/', $fileNameToStore);
        }
        if (!empty($request->avatar)) {
            $user['avatar'] = 'avatar/' . $fileNameToStore;
        }
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user['email'] = $request['email'];
        $user->save();
        return redirect()->back()->with('success', __('successfully updated.'));
    }

    public function updateAvatar(Request $request)
    {
        $disk   = Storage::disk();
        $user   = User::find(auth()->id());
        request()->validate([
            'avatar' => 'required',
        ]);
        $image          = $request->avatar;
        $image          = str_replace('data:image/png;base64,', '', $image);
        $image          = str_replace(' ', '+', $image);
        $imageName      = time() . '.' . 'png';
        $imagePath      = "uploads/avatar/" . $imageName;
        $disk->put($imagePath, base64_decode($image));
        $user->avatar   = $imagePath;
        if ($user->save()) {
            return __("Avatar updated successfully.");
        }
        return __("Avatar updated failed.");
    }

    public function profileStatus()
    {
        $user       = tenancy()->central(function ($tenant) {
            $centralUser                   = User::find($tenant->id);
            $centralUser->active_status    = 0;
            $centralUser->save();
        });
        $user                   = User::find(Auth::user()->id);
        $user->active_status    = 0;
        $user->save();
        auth()->logout();
        return redirect()->route('home');
    }

    public function destroy()
    {
        if (Auth::user()->can('delete-user')) {
            $user = User::find(auth()->id());
            tenancy()->central(function ($tenant) {
                $centralUser                   = User::find($tenant->id);
                $centralUser->active_status    = 0;
                $centralUser->save();
            });
            if ($user->type == 'Admin') {
                $subUsers  = User::where('type', '!=', 'Admin')->get();
            } else {
                $subUsers  = User::where('created_by', $user->id)->get();
            }
            foreach ($subUsers as $sub_user) {
                if ($sub_user) {
                    $sub_user->active_status = 0;
                    $sub_user->save();
                }
            }
            $user->delete();
            auth()->logout();
            return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
