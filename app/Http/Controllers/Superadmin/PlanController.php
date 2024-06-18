<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\DataTables\Superadmin\PlanDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index(PlanDataTable $dataTable)
    {
        if (Auth::user()->can('manage-plan')) {
            return $dataTable->render('superadmin.plans.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function myPlan(PlanDataTable $dataTable)
    {
        if (Auth::user()->can('manage-plan')) {
            $plans  = Plan::where('tenant_id', null)->get();
            $user   = User::where('tenant_id', tenant('id'))->where('type', 'Admin')->first();
            return view('plans.index', compact('user', 'plans'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-plan')) {
            return view('superadmin.plans.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {

        $vantagens = $request->vantagens;
        $vantagens = trim($vantagens, ' ');
       
       
 
        if (Auth::user()->can('create-plan')) {
            request()->validate([
                'name'          => 'required|max:50|unique:plans,name',
                'price'         => 'required',
                'duration'      => 'required',
                'durationtype'  => 'required',
               
                'description'   => 'max:200',
            ]);
            $paymentTypes = UtilityFacades::getpaymenttypes();
            if (!$paymentTypes) {
                return redirect()->route('plans.index')->with('errors', __('Please on at list one payment type.'));
            }
            Plan::create([
                'name'              => $request->name,
                'price'             => $request->price,
                'duration'          => $request->duration,
                'durationtype'      => $request->durationtype,
                'max_users'         => $request->max_users,
                'vantagens'         => $vantagens,
                
                
                'discount_setting'  => ($request->discount_setting) ? 'on' : 'off',
                'gerar_sorteio'     => $request->gerar_sorteio == 'on' ? 'on' : 'off',
                'status_auto_cota' => $request->status_auto_cota == 'on' ? 'on' : 'off',
                'discount'          => $request->discount_setting == 'on' ? $request->discount : null,
                'description'       => $request->description,
            ]);
            return redirect()->route('plans.index')->with('success', __('Plan created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-plan')) {
            $plan = Plan::find($id);
            // tenant database setting store
            $user = User::where('plan_id', $plan->id)->first();
            if (isset($user->tenant_id)) {
                tenancy()->initialize($user->tenant_id);
                $planSettings    = UtilityFacades::getsettings('plan_setting');
                tenancy()->end();
                return view('superadmin.plans.edit', compact('plan', 'planSettings'));
            } else {
                return view('superadmin.plans.edit', compact('plan'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {


        $vantagens = $request->vantagens;
        $vantagens = trim($vantagens, ' ');

        if (Auth::user()->can('edit-plan')) {
            request()->validate([
                'name'          => 'required|max:50|unique:plans,name,' . $id,
                'price'         => 'required',
                'duration'      => 'required',
      
                'description'   => 'max:191',
            ]);

      
            $plan = Plan::find($id);
            $plan->name             = $request->input('name');
            $plan->price            = $request->input('price');
            $plan->duration         = $request->input('duration');
            $plan->durationtype     = $request->input('durationtype');
            $plan->max_users        = $request->input('max_users');
            $plan->vantagens        = $request->input('vantagens');

            
            $plan->discount_setting = ($request->discount_setting) ? 'on' : 'off';
            $plan->gerar_sorteio    = $request->gerar_sorteio == 'on' ? 'on' : 'off';
            $plan->status_auto_cota = $request->status_auto_cota == 'on' ? 'on' : 'off';

            $plan->discount         = $request->discount_setting == 'on' ? $request->discount : null;
            $plan->description      = $request->input('description');
            $plan->save();

            // tenant database setting store
            $users = User::where('plan_id', $id)->first();
            if (isset($users->tenant_id)) {
                tenancy()->initialize($users->tenant_id);

                $plans = [
                    "plan_id"           => $plan->id,
                    "name"              => $plan->name,
                    "price"             => $plan->price,
                    "duration"          => $plan->duration,
                    "durationtype"      => $plan->durationtype,
                    "description"       => $plan->description,
                    "max_users"         => $plan->max_users,
                    "vantagens"         => $plan->vantagens,
                    "gerar_sorteio"     => $plan->gerar_sorteio == 'on' ? 'on' : 'off',
                    "status_auto_cota" => $plan->status_auto_cota == 'on' ? 'on' : 'off',

                    
                    "discount_setting"  => ($plan->discount_setting == 'on') ? 'on' : 'off',
                    "discount"          => $plan->discount_setting == 'on' ? $plan->discount : null,
                    "tenant_id"         => $plan->tenant_id,
                    "active_status"     => $plan->active_status,
                    "created_at"        => $plan->created_at,
                    "updated_at"        => $plan->updated_at,
                ];
                $planSetting = json_encode($plans);
                Setting::updateOrCreate(
                    ['key'      => 'plan_setting'],
                    ['value'    => $planSetting]
                );
                tenancy()->end();
            } else {
                return redirect()->route('plans.index')->with('success', __('Plan updated successfully.'));
            }

            return redirect()->route('plans.index')->with('success', __('Plan updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-plan')) {
            $plan   = Plan::find($id);
            if ($plan->id != 1) {
                $planExistInOrder = Order::where('plan_id', $plan->id)->first();
                if (empty($planExistInOrder)) {
                    $plan->delete();
                    return redirect()->route('plans.index')->with('success', __('Plan deleted successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('Can not delete this plan Because its Purchased by users.'));
                }
            } else {
                return redirect()->back()->with('failed', __('Can not delete this plan Because its free plan.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function planStatus(Request $request, $id)
    {
        $plan       = Plan::find($id);
        $input      = ($request->value == "true") ? 1 : 0;
        if ($plan) {
            $plan->active_status = $input;
            $plan->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Plan status changed successfully.')
        ]);
    }
}
