<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CouponDataTable;
use App\DataTables\Admin\UserCouponDatatable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(CouponDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-coupon')) {
            $totalCoupon        = Coupon::count();
            $expieredCoupon     = Coupon::where('is_active', '0')->count();
            $totalUsedCoupon    = UserCoupon::count();
            $totalUseAmount     =   Order::where('status', 1)->sum('discount_amount');
            return $dataTable->render('admin.coupon.index', compact('totalCoupon', 'expieredCoupon', 'totalUsedCoupon', 'totalUseAmount'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-coupon')) {
            return view('admin.coupon.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-coupon')) {
            request()->validate([
                'icon_input'    => 'required',
            ]);
            if ($request->icon_input == 'manual') {
                $request->merge(['code' => $request->manualCode]);
            } else {
                $request->merge(['code' => $request->autoCode]);
            }
            request()->validate([
                'discount'      => 'required',
                'discount_type' => 'required',
                'limit'         => 'required',
                'code'          => 'required|unique:coupons,code',
            ]);
            $coupon                 = new Coupon();
            $coupon->discount       = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $coupon->limit          = $request->limit;
            if ($request->icon_input == 'manual') {
                if (!empty($request->manualCode)) {
                    $coupon->code   = strtoupper($request->manualCode);
                } else {
                    return redirect()->back()->with('errors', __('Manual code is required.'));
                }
            } else {
                if (!empty($request->autoCode)) {
                    $coupon->code   = $request->autoCode;
                } else {
                    return redirect()->back()->with('errors', __('Auto code is required.'));
                }
            }
            $coupon->save();
            return redirect()->route('coupon.index')->with('success', __('Coupon created Successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function show(UserCouponDatatable $dataTable)
    {
        if (\Auth::user()->can('show-coupon')) {
            return $dataTable->render('admin.coupon.show');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-coupon')) {
            $coupon     = Coupon::find($id);
            return view('admin.coupon.edit', compact('coupon'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-coupon')) {
            request()->validate([
                'discount'       => 'required|numeric',
                'discount_type'  => 'required|string|max:191',
                'limit'          => 'required|integer',
                'code'           => 'required|string|max:191|unique:coupons,code,' . $id,
            ]);
            $coupon                 = Coupon::find($id);
            $coupon->discount       = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $coupon->limit          = $request->limit;
            $coupon->code           = $request->code;
            $coupon->save();
            return redirect()->route('coupon.index')
                ->with('success',  __('Coupon updated successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-coupon')) {
            $coupon     = Coupon::find($id);
            $coupon->delete();
            return redirect()->route('coupon.index')
                ->with('success',  __('Coupon deleted successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function uploadCsv()
    {
        return view('admin.coupon.upload-coupon');
    }

    public function uploadCsvStore(Request $request)
    {
        request()->validate([
            'file'  => 'required|file|mimes:csv'
        ]);
        if ($request->hasFile('file')) {
            $file       = $request->file;
            $fileName   = time() . '.' . $file->extension();
            $path       = $file->storeAs('/coupon', $fileName);
            $data       = array_map('str_getcsv', file(Storage::path($path)));
            array_shift($data);
            foreach ($data as $val) {
                $coupon                 = new Coupon();
                $coupon->discount_type  = $val[0];
                $coupon->code           = $val[1];
                $coupon->discount       = $val[2];
                $coupon->limit          = $val[3];
                $coupon->is_active      = 1;
                $coupon->save();
            }
        }
        return redirect()->route('coupon.index')
            ->with('success',  __('Coupon created successfully.'));
    }

    public function massCreate()
    {
        if (\Auth::user()->can('mass-create-coupon')) {
            return view('admin.coupon.mass-create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function massCreateStore(Request $request)
    {
        if (\Auth::user()->can('mass-create-coupon')) {
            request()->validate([
                'discount'          => 'required|numeric',
                'discount_type'     => 'required|string|max:191',
                'mass_create'       => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) {
                        if ($value > 50) {
                            $fail("The mass create may not be greater than 50.");
                        }
                    },
                ],
                'limit'             => 'required|integer',
            ]);
            $massCreate        = $request->mass_create;
            for ($i = 1; $i <= $massCreate; $i++) {
                $coupon                 = new Coupon();
                $coupon->discount       = $request->discount;
                $coupon->discount_type  = $request->discount_type;
                $coupon->limit          = $request->limit;
                $coupon->code           = strtoupper(Str::random(10));
                $coupon->save();
            }
            return redirect()->route('coupon.index')->with('success', __('Coupon created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function couponStatus(Request $request, $id)
    {
        $coupon         = Coupon::find($id);
        $couponStatus   = ($request->value == "true") ? 1 : 0;
        if ($coupon) {
            $coupon->is_active  = $couponStatus;
            $coupon->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Coupon status changed successfully.')
        ]);
    }

    public function applyCoupon(Request $request)
    {
        if (Auth::user()->type == 'Admin') {
            $plan   =  tenancy()->central(function ($tenant) use ($request) {
                return Plan::find(\Illuminate\Support\Facades\Crypt::decrypt($request->plan_id));
            });
            if ($plan && $request->coupon != '') {
                $originalPrice  = UtilityFacades::amount_format($plan->price);
                $coupons        =  tenancy()->central(function ($tenant) use ($request) {
                    return Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                });
                if (!empty($coupons)) {
                    $usedCoupun = $coupons->used_coupon();
                    if ($coupons->limit == $usedCoupun) {
                        return response()->json([
                            'is_success'    => false,
                            'final_price'   => $originalPrice,
                            'price'         => number_format($plan->price, 2),
                            'message'       => __(__('This coupon code has expired.')),
                        ]);
                    } else {
                        $discountType   = $coupons->discount_type;
                        $discountValue  =  UtilityFacades::calculateDiscount($plan->price, $coupons->discount, $discountType);
                        $planPrice      = $plan->price - $discountValue;
                        $price          = UtilityFacades::amount_format($plan->price - $discountValue);
                        $discountValue  = '-' . UtilityFacades::amount_format($discountValue);
                        if ($planPrice < 0) {
                            return response()->json([
                                'is_success'        => false,
                                'discount_price'    => UtilityFacades::amount_format(0),
                                'currency_symbol'   => UtilityFacades::getsettings('currency_symbol'),
                                'final_price'       => UtilityFacades::amount_format($plan->price),
                                'price'             => number_format($plan->price, 2),
                                'message'           => __('Price is negetive please enter currect coupon code.'),
                            ]);
                        } else {
                            return response()->json([
                                'is_success'        => true,
                                'discount_price'    => $discountValue,
                                'currency_symbol'   => UtilityFacades::getsettings('currency_symbol'),
                                'final_price'       => $price,
                                'price'             => number_format($planPrice, 2),
                                'message'           => __('Coupon code has applied successfully.'),
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'is_success'    => false,
                        'final_price'   => $originalPrice,
                        'price'         => number_format($plan->price, 2),
                        'message'       => __('This coupon code is invalid or has expired.'),
                    ]);
                }
            }
        } else {
            $plan       = Plan::find(\Illuminate\Support\Facades\Crypt::decrypt($request->plan_id));
            if ($plan && $request->coupon != '') {
                $originalPrice  = UtilityFacades::amount_format($plan->price);
                $coupons        =  Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if (!empty($coupons)) {
                    $usedCoupun = $coupons->used_coupon();
                    if ($coupons->limit == $usedCoupun) {
                        return response()->json([
                            'is_success'    => false,
                            'final_price'   => $originalPrice,
                            'price'         => number_format($plan->price, 2),
                            'message'       => __(__('This coupon code has expired.')),
                        ]);
                    } else {
                        $discountType   = $coupons->discount_type;
                        $discountValue  =  UtilityFacades::calculateDiscount($plan->price, $coupons->discount, $discountType);
                        $planPrice      = $plan->price - $discountValue;
                        $price          = UtilityFacades::amount_format($plan->price - $discountValue);
                        $discountValue  = '-' . UtilityFacades::amount_format($discountValue);
                        if ($planPrice < 0) {
                            return response()->json([
                                'is_success'        => false,
                                'discount_price'    => UtilityFacades::amount_format(0),
                                'currency_symbol'   => UtilityFacades::getsettings('currency_symbol'),
                                'final_price'       => UtilityFacades::amount_format($plan->price),
                                'price'             => number_format($plan->price, 2),
                                'message'           => __('Price is negetive please enter currect coupon code.'),
                            ]);
                        } else {
                            return response()->json([
                                'is_success'        => true,
                                'discount_price'    => $discountValue,
                                'currency_symbol'   => UtilityFacades::getsettings('currency_symbol'),
                                'final_price'       => $price,
                                'price'             => number_format($planPrice, 2),
                                'message'           => __('Coupon code has applied successfully.'),
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'is_success'    => false,
                        'final_price'   => $originalPrice,
                        'price'         => number_format($plan->price, 2),
                        'message'       => __('This coupon code is invalid or has expired.'),
                    ]);
                }
            }
        }
    }
}
