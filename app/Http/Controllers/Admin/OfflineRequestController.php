<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OfflineRequestDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\Admin\ApproveOfflineMail;
use App\Mail\Admin\OfflineMail;
use App\Models\Coupon;
use App\Models\NotificationsSetting;
use App\Models\OfflineRequest;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\Admin\ApproveOfflineNotification;
use App\Notifications\Admin\DisapprovedOfflineNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class OfflineRequestController extends Controller
{
    public function index(OfflineRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.offline-request.index');
        $plans  = Plan::where('active_status', 1)->get();
        $user   = User::where('id', Auth::user()->id)->first();
        return view('admin.offline-request.index', compact('user', 'offline_request'));
    }

    public function offlinePaymentEntry(Request $request)
    {
        $planID    = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $authUser  = Auth::user();
        if (Auth::user()->type == 'Admin') {
            $plan   = tenancy()->central(function ($tenant) use ($planID) {
                return Plan::find($planID);
            });
            $resData =  tenancy()->central(function ($tenant) use ($plan, $request) {
                $couponId       = '0';
                $couponCode     = null;
                $discountValue  = null;
                $price          = $plan->price;
                $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
                if ($coupons) {
                    $couponCode     = $coupons->code;
                    $usedCoupun     = $coupons->used_coupon();
                    if ($coupons->limit == $usedCoupun) {
                        $resData['errors'] = __('This coupon code has expired.');
                    } else {
                        $discount       = $coupons->discount;
                        $discountType   = $coupons->discount_type;
                        $discountValue  =  UtilityFacades::calculateDiscount($price, $discount, $discountType);
                        $price          = $price - $discountValue;
                        if ($price < 0) {
                            $price      = $plan->price;
                        }
                        $couponId       = $coupons->id;
                    }
                }
                $data = Order::create([
                    'plan_id'           => $plan->id,
                    'user_id'           => $tenant->id,
                    'amount'            => $price,
                    'payment_type'      => 'offline',
                    'discount_amount'   => $discountValue,
                    'coupon_code'       => $couponCode,
                    'status'            => 0,
                ]);
                $resData['total_price']    = $price;
                $resData['coupon']         = $couponId;
                $resData['order_id']       = $data->id;
                return $resData;
            });
            $order = tenancy()->central(function ($tenant) use ($resData, $plan, $authUser) {
                OfflineRequest::create([
                    'order_id'  => $resData['order_id'],
                    'plan_id'   => $plan->id,
                    'coupon_id' => $resData['coupon'],
                    'user_id'   =>  $tenant->id,
                    'email'     => $authUser->email,
                ]);
            });
        } else {
            $plan           =  Plan::find($planID);
            $couponId       = '0';
            $couponCode     = null;
            $discountValue  = null;
            $price          = $plan->price;
            $coupons        = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
            if ($coupons) {
                $couponCode     = $coupons->code;
                $usedCoupun     = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                    $resData['errors'] = __('This coupon code has expired.');
                } else {
                    $discount       = $coupons->discount;
                    $discountType   = $coupons->discount_type;
                    $discountValue  =  UtilityFacades::calculateDiscount($price, $discount, $discountType);
                    $price          = $price - $discountValue;
                    if ($price < 0) {
                        $price = $plan->price;
                    }
                    $couponId = $coupons->id;
                }
            }
            $data = Order::create([
                'plan_id'           => $plan->id,
                'user_id'           => $authUser->id,
                'amount'            => $price,
                'payment_type'      => 'offline',
                'discount_amount'   => $discountValue,
                'coupon_code'       => $couponCode,
                'status'            => 0,
            ]);
            $resData['total_price']    = $price;
            $resData['coupon']         = $couponId;
            $resData['order_id']       = $data->id;
            OfflineRequest::create([
                'order_id'  => $resData['order_id'],
                'plan_id'   => $plan->id,
                'coupon_id' => $resData['coupon'],
                'user_id'   =>  $authUser->id,
                'email'     => $authUser->email,
            ]);
        }
        return redirect()->route('plans.index')
            ->with('success',  __('Plan update request send successfully.'));
    }

    public function offlineRequestStatus($id)
    {
        $offline        = OfflineRequest::find($id);
        $user           = User::find($offline->user_id);
        $plan           = Plan::find($offline->plan_id);
        $order          = Order::find($offline->order_id);
        $user->plan_id  = $plan->id;
        if ($plan->durationtype == 'Month' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
        } elseif ($plan->durationtype == 'Year' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
        } else {
            $user->plan_expired_date = null;
        }
        $user->save();
        $offline->is_approved   = 1;
        $offline->update();
        $order->status          = 1;
        $order->payment_type    = 'offline';
        $order->update();

        $user   = User::where('id', $offline->user_id)->first();
        $users  = User::where('tenant_id', tenant('id'))->first();
        $notify = NotificationsSetting::where('title', 'Offline Payment Request Verified')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->notify == '1') {
                    $users->notify(new ApproveOfflineNotification($offline, $user));
                }
                if ($notify->email_notification == '1') {
                    if (MailTemplate::where('mailable', ApproveOfflineMail::class)->first()) {
                        try {
                            Mail::to($offline->email)->send(new ApproveOfflineMail($offline, $user));
                        } catch (\Exception $e) {
                            return redirect()->back()->with('errors', $e->getMessage());
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('success',  __('Plan update request send successfully.'));
    }

    public function destroy($id)
    {
        $offlineRequest = OfflineRequest::find($id);
        $offlineRequest->delete();
        return redirect()->back()->with('success', __('Offline request deleted successfully.'));
    }

    public function disApproveStatus($id)
    {
        $requestUser = OfflineRequest::find($id);
        if ($requestUser->is_approved == 0) {
            $view   = view('admin.offline-request.offline-reason', compact('requestUser'));
            return ['html' => $view->render()];
        } else {
            return redirect()->back();
        }
    }

    public function offlineDisApprove(Request $request, $id)
    {
        request()->validate([
            'disapprove_reason' => 'required',
        ]);
        $offline        = OfflineRequest::find($id);
        $order          = Order::find($offline->order_id);
        $offlineRequest = OfflineRequest::find($id);
        $offlineRequest->disapprove_reason  = $request->disapprove_reason;
        $offlineRequest->is_approved        = 2;
        $offlineRequest->update();
        $order->status          = 2;
        $order->payment_type    = 'offline';
        $order->update();

        $user   = User::where('id', $offline->user_id)->first();
        $users  = User::where('tenant_id', tenant('id'))->first();
        $notify = NotificationsSetting::where('title', 'Offline Payment Request Unverified')->first();
        if (isset($notify)) {
            if ($notify->notify == '1') {
                $users->notify(new DisapprovedOfflineNotification($offlineRequest, $user));
            }
        }
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->email_notification == '1') {
                    if (MailTemplate::where('mailable', OfflineMail::class)->first()) {
                        try {
                            Mail::to($offlineRequest->email)->send(new OfflineMail($offlineRequest, $user));
                        } catch (\Exception $e) {
                            return redirect()->back()->with('errors', $e->getMessage());
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('success', __('Domain request disapprove successfully.'));
    }
}
