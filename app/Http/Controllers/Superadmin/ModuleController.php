<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Module;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Superadmin\ModuleDataTable;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(ModuleDataTable $dataTable)
    {
        if (Auth::user()->can('manage-module')) {
            return $dataTable->render('superadmin.module.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-module')) {
            return view('superadmin.module.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-module')) {
            request()->validate([
                'name'      => 'required|max:50|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:permissions',
            ]);
            $this->module   =  module::create([
                'name'      => str_replace(' ', '-', strtolower($request->name)),
            ]);
            $moduleName    = str_replace(' ', '-', strtolower($request->name));
            if (!empty($_POST['permissions'])) {
                foreach ($_POST['permissions'] as $check) {
                    if ($check == 'M') {
                        $data[] = ['name' => 'manage-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'C') {
                        $data[] = ['name' => 'create-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'E') {
                        $data[] = ['name' => 'edit-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'D') {
                        $data[] = ['name' => 'delete-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'S') {
                        $data[] = ['name' => 'show-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'U') {
                        $data[] = ['name' => 'upload-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    } else if ($check == 'MC') {
                        $data[] = ['name' => 'mass-create-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                    }
                }
            }
            Permission::insert($data);
            return redirect()->route('modules.index')->with('success', __('Module created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-module')) {
            $this->module = module::findOrfail($id);
            return view('superadmin.module.edit')->with('module', $this->module);
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-module')) {
            $modules    = Module::find($id);
            request()->validate([
                'name'  => 'required|max:50|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:modules,name,' . $modules->id,
            ]);
            $modules->name  = str_replace(' ', '-', strtolower($request->name));
            $permissions    = DB::table('permissions')
                ->where('name', 'like', '%' . $request->old_name . '%')
                ->get();
            $moduleName    = str_replace(' ', '-', strtolower($request->name));
            foreach ($permissions as $permission) {
                $updatePermission = permission::find($permission->id);
                if ($permission->name == 'manage-' . $request->old_name) {
                    $updatePermission->name = 'manage-' . $moduleName;
                }
                if ($permission->name == 'create-' . $request->old_name) {
                    $updatePermission->name = 'create-' . $moduleName;
                }
                if ($permission->name == 'edit-' . $request->old_name) {
                    $updatePermission->name = 'edit-' . $moduleName;
                }
                if ($permission->name == 'delete-' . $request->old_name) {
                    $updatePermission->name = 'delete-' . $moduleName;
                }
                if ($permission->name == 'show-' . $request->old_name) {
                    $updatePermission->name = 'show-' . $moduleName;
                }
                if ($permission->name == 'upload-' . $request->old_name) {
                    $updatePermission->name = 'upload-' . $moduleName;
                }
                if ($permission->name == 'mass-create-' . $request->old_name) {
                    $updatePermission->name = 'mass-create-' . $moduleName;
                }
                $updatePermission->save();
            }
            $modules->save();
            return redirect()->route('modules.index')->with('success', __('Module updated sucessfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-module')) {
            $this->module   = module::find($id);
            $users          = DB::table('permissions')
                ->where('name', 'like', '%' . $this->module->name . '%')
                ->get();
            foreach ($users as $user) {
                $permission = permission::find($user->id);
                $permission->delete();
            }
            $this->module->delete();
            return redirect()->route('modules.index')->with('success', __('Module deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
