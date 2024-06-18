<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\RolesDataTable;
use App\Facades\UtilityFacades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        if (Auth::user()->can('manage-role')) {
            return $dataTable->render('admin.roles.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        $settingData    = UtilityFacades::getsettings('plan_setting');
        $plans          = json_decode($settingData, true);
        $role           = Role::all()->count();
        if ($role <= $plans['max_roles']) {
            if (Auth::user()->can('create-role')) {
                $permission = Permission::get();
                return view('admin.roles.create', compact('permission'));
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Please update your plan because roles limit low.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-role')) {
            request()->validate([
                'name'  => 'required|unique:roles,name|max:50',
            ]);
            Role::create([
                'name'      => $request->input('name'),
                'tenant_id' => tenant('id')
            ]);
            return redirect()->route('roles.index')
                ->with('success', __('Role created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function show($id)
    {
        $role   = Role::find($id);
        if ($id == 1) {
            $permissions    = $role->permissions->pluck('name', 'id')->toArray();
            $allPermissions = Permission::all()->pluck('name', 'id')->toArray();
        } else {
            $permissions = DB::table("role_has_permissions")
                ->select(['role_has_permissions.*', 'permissions.name'])
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where("role_has_permissions.role_id", $id)
                ->pluck('permissions.name', 'role_has_permissions.permission_id')
                ->toArray();
            $allPermissions = Auth::user()->roles->first()->permissions->pluck('name', 'id')->toArray();
        }
        $allModules     = Module::all()->pluck('name', 'id')->toArray();
        return view('admin.roles.show')
            ->with('role', $role)
            ->with('permissions', $permissions)
            ->with('allPermissions', $allPermissions)
            ->with('allModules', $allModules);
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-role')) {
            $role               = Role::find($id);
            $permission         = Permission::get();
            $rolePermissions    = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
            return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-role')) {
            request()->validate([
                'name'  => 'required|unique:roles,name|max:50',
            ]);
            $role       = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));
            return redirect()->route('roles.index')
                ->with('success', __('Role updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        $role   = Role::find($id);
        if ($role->id != 1) {
            $role->delete();
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function assignPermission(Request $request, $id)
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role           = Role::find($id);
        $permissions    = $role->permissions()->get();
        $role->revokePermissionTo($permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('roles.index')->with('success', __('Permissions assigned to role successfully.'));
    }
}
