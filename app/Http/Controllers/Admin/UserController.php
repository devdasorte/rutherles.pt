<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UsersDataTable;
use App\Facades\UtilityFacades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Database\Models\Domain;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        if (Auth::user()->can('manage-user')) {
            return $dataTable->render('admin.users.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        $settingData    = UtilityFacades::getsettings('plan_setting');
        $plans          = json_decode($settingData, true);
        $user           = User::all()->count();
        if ($user <= $plans['max_roles']) {
            if (Auth::user()->can('create-user')) {
                if (Auth::user()->type == 'Admin') {
                    $roles      = Role::where('name', '!=', 'Super Admin')->where('name', '!=', 'Admin')->pluck('name', 'name');
                    $domains    = Domain::pluck('domain', 'domain')->all();
                } else {
                    $roles      = Role::where('name', '!=', 'Admin')->where('name', Auth::user()->type)->pluck('name', 'name');
                    $domains    = Domain::pluck('domain', 'domain')->all();
                }
                return view('admin.users.create', compact('roles', 'domains'));
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Please update your plan because roles limit low.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-user')) {
            if (Auth::user()->type == 'Admin') {
                request()->validate([
                    'name'          => 'required|max:50',
                    'email'         => 'required|email|unique:users,email,',
                    'password'      => 'same:confirm-password',
                    'country_code'  => 'required',
                    'dial_code'     => 'required',
                    'phone'         => 'required',
                    'roles'         => 'required',
                ]);
                $userData                      = $request->all();
                $userData['password']          = Hash::make($userData['password']);
                $userData['type']              = $userData['roles'];
                $userData['created_by']        = Auth::user()->id;
                $userData['plan_id']           = 1;
                $userData['email_verified_at'] = (UtilityFacades::getsettings('email_verification') == '1') ? null : Carbon::now()->toDateTimeString();
                $userData['phone_verified_at'] = (UtilityFacades::getsettings('phone_verification') == '1') ? null : Carbon::now()->toDateTimeString();
                $userData['country_code']      = $request->country_code;
                $userData['dial_code']         = $request->dial_code;
                $userData['phone']             = str_replace(' ', '', $request->phone);
                $user                          = User::create($userData);
                $user->assignRole($request->input('roles'));
                $user->update();
            } else {
                request()->validate([
                    'name'          => 'required|max:50',
                    'email'         => 'required|email|unique:users,email,',
                    'password'      => 'same:confirm-password',
                    'country_code'  => 'required',
                    'dial_code'     => 'required',
                    'phone'         => 'required',
                    'roles'         => 'required',
                ]);
                $users  = User::where('tenant_id', tenant('id'))->where('created_by', Auth::user()->id)->count();
                $usr    = Auth::user();
                $user   = user::where('email', $usr->email)->first();
                $plan   = Plan::find($user->plan_id);
                if ($users < $plan->max_users) {
                    $userData                       = $request->all();
                    $userData['password']           = Hash::make($userData['password']);
                    $userData['type']               = $userData['roles'];
                    $userData['email_verified_at']  = (UtilityFacades::getsettings('email_verification') == '1') ? null : Carbon::now()->toDateTimeString();
                    $userData['phone_verified_at']  = (UtilityFacades::getsettings('phone_verification') == '1') ? null : Carbon::now()->toDateTimeString();
                    $userData['country_code']       = $request->country_code;
                    $userData['dial_code']          = $request->dial_code;
                    $userData['phone']              = str_replace(' ', '', $request->phone);
                    $userData['created_by']         = Auth::user()->id;
                    $user   = User::create($userData);
                    $user->assignRole($request->input('roles'));
                    $user->update();
                } else {
                    return redirect()->back()->with('failed', __('Your user limit is over, Please upgrade plan.'));
                }
            }
            return redirect()->route('users.index')->with('success', __('User created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-user')) {
            $user   = User::find($id);
            if (Auth::user()->type == 'Admin') {
                $roles      = Role::where('name', '!=', 'Super Admin')->where('name', '!=', 'Admin')->pluck('name', 'name');
                $domains    = Domain::pluck('domain', 'domain')->all();
            } else {
                $roles      = Role::where('name', '!=', 'Admin')->where('name', Auth::user()->type)->pluck('name', 'name');
                $domains    = Domain::pluck('domain', 'domain')->all();
            }
            return view('admin.users.edit', compact('user', 'roles', 'domains'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-user')) {
            request()->validate([
                'name'          => 'required|max:50',
                'email'         => 'required|email|unique:users,email,' . $id,
                'country_code'  => 'required',
                'dial_code'     => 'required',
                'phone'         => 'required',
                'roles'         => 'required',
            ]);
            $input          = $request->all();
            $input['type']  = $input['roles'];
            $user           = User::find($id);
            $user->country_code = $request->country_code;
            $user->dial_code    = $request->dial_code;
            $user->phone        = str_replace(' ', '', $request->phone);
            $currentdate        = Carbon::now();
            $newEndingDate      = date("Y-m-d", strtotime(date("Y-m-d", strtotime($user->created_at)) . " + 1 year"));
            if ($currentdate <= $newEndingDate) {
            }
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.index')->with('success', __('User updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-user')) {
            $user = User::find($id);
            if ($user->id != 1) {
                $user->delete();
            }
            return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function userEmailVerified($id)
    {
        $user = User::find($id);
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $user->save();
            return redirect()->back()->with('success', __('User email unverified successfully.'));
        } else {
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->back()->with('success', __('User email verified successfully.'));
        }
    }

    public function userPhoneVerified($id)
    {
        $user = User::find($id);
        if ($user->phone_verified_at) {
            $user->phone_verified_at = null;
            $user->save();
            return redirect()->back()->with('success', __('User phone unverified successfully.'));
        } else {
            $user->phone_verified_at = Carbon::now();
            $user->save();
            return redirect()->back()->with('success', __('User phone verified successfully.'));
        }
    }

    public function userStatus(Request $request, $id)
    {
        $user   = User::find($id);
        $input  = ($request->value == "true") ? 1 : 0;
        if ($user) {
            $user->active_status = $input;
            $user->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('User status changed successfully.')
        ]);
    }
}
