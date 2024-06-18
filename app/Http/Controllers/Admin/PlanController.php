<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\PlanDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index(PlanDataTable $dataTable)
    {
        if (Auth::user()->can('manage-plan')) {
            if (Auth::user()->type == 'Admin') {
                $plans  = tenancy()->central(function ($tenant) {
                    return Plan::all();
                });
                $user   = tenancy()->central(function ($tenant) {
                    return User::find($tenant->id);
                });
                return view('admin.plans.index', compact('user', 'plans'));
            } else {
                $plans  =  Plan::all();
                $user   = User::find(Auth::user()->id);
                return view('admin.plans.index', compact('user', 'plans'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function myPlan(PlanDataTable $dataTable)
    {
        if (Auth::user()->can('manage-plan')) {
            if (Auth::user()->type == 'Admin') {
                return $dataTable->render('admin.plans.my-plans');
            } else {
                $plans  = Plan::where('tenant_id', null)->get();
                $user   = User::where('tenant_id', tenant('id'))->where('type', 'Admin')->first();
                return view('admin.plans.index', compact('user', 'plans'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function createMyPlan()
    {
        if (Auth::user()->can('create-plan')) {
            return view('admin.plans.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('create-plan')) {
            request()->validate([
                'name'          => 'required|unique:plans,name|max:50',
                'price'         => 'required',
                'duration'      => 'required',
                'durationtype'  => 'required',
                'max_users'     => 'required',
                'description'   => 'max:191',
            ]);
            $paymentTypes = UtilityFacades::getpaymenttypes();
            if (!$paymentTypes) {
                return redirect()->route('plans.index')->with('errors', __('Please on at list one payment type.'));
            }
            Plan::create([
                'name'          => $request->name,
                'price'         => $request->price,
                'duration'      => $request->duration,
                'durationtype'  => $request->durationtype,
                'max_users'     => $request->max_users,
                'description'   => $request->description,
            ]);
            return redirect()->route('plans.myplan')->with('success', __('Plan created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function editMyplan($id)
    {
        if (Auth::user()->can('edit-plan')) {
            $plan   = Plan::find($id);
            return view('admin.plans.edit', compact('plan'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-plan')) {
            if (Auth::user()->type == 'Super Admin') {
                request()->validate([
                    'name'          => 'required|max:50|unique:plans,name,' . $id,
                    'price'         => 'required',
                    'duration'      => 'required',
                    'description'   => 'max:191',
                ]);
                $plan               = Plan::find($id);
                $plan->name         = $request->input('name');
                $plan->price        = $request->input('price');
                $plan->duration     = $request->input('duration');
                $plan->durationtype = $request->input('durationtype');
                $plan->description  = $request->input('description');
                $plan->save();
            } else {
                request()->validate([
                    'name'      => 'required|max:50|unique:plans,name,' . $id,
                    'price'     => 'required',
                    'duration'  => 'required',
                    'max_users' => 'required',
                ]);
                $plan               = Plan::find($id);
                $plan->name         = $request->input('name');
                $plan->price        = $request->input('price');
                $plan->duration     = $request->input('duration');
                $plan->durationtype = $request->input('durationtype');
                $plan->max_users    = $request->input('max_users');
                $plan->description  = $request->input('description');
                $plan->save();
            }
            if (Auth::user()->type == 'Admin') {
                return redirect()->route('plans.myplan')->with('success', __('Plan updated successfully.'));
            } else {
                return redirect()->route('plans.index')->with('success', __('Plan updated successfully.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-plan')) {
            $plan = Plan::find($id);
            if ($plan->id != 1) {
                $planExistInOrder = Order::where('plan_id', $plan->id)->first();
                if (empty($planExistInOrder)) {
                    $plan->delete();
                    return redirect()->route('plans.myplan')->with('success', __('Plan deleted successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('Can not delete this plan because its purchased by users.'));
                }
            } else {
                return redirect()->back()->with('failed', __('Can not delete this plan because its free plan.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function planStatus(Request $request,$id)
    {
        $plan   = Plan::find($id);
        $planStatus  = ($request->value == "true") ? 1 : 0;
        if ($plan) {
            $plan->active_status = $planStatus;
            $plan->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Plan status changed successfully.')
        ]);
    }

    public function payment($code)
    {
        $plan_id  = \Illuminate\Support\Facades\Crypt::decrypt($code);
        if (Auth::user()->type == 'Admin') {
            $plan           = tenancy()->central(function ($tenant) use ($plan_id) {
                return Plan::find($plan_id);
            });
            $paymentTypes   = tenancy()->central(function ($tenant) {
                return UtilityFacades::getpaymenttypes();
            });
            $adminPaymentSetting    = UtilityFacades::getadminplansetting();
        } else {
            $plan                   = Plan::find($plan_id);
            $paymentTypes           = UtilityFacades::getpaymenttypes();
            $adminPaymentSetting    = UtilityFacades::getplansetting();
        }
        if ($plan) {
            return view('admin.plans.payment', compact('plan', 'adminPaymentSetting', 'paymentTypes'));
        } else {
            return redirect()->back()->with('errors', __('Plan deleted successfully.'));
        }
    }
}
