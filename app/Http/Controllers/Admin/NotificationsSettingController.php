<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationsSetting;
use Illuminate\Http\Request;

class NotificationsSettingController extends Controller
{
    public function changeStatus(Request $request, $id)
    {
        if ($request->type == 'email') {
            $notify     = NotificationsSetting::find($id);
            $email      = ($request->email_notification == "true") ? 1 : 0;
            if ($notify) {
                $notify->email_notification = $email;
                $notify->save();
            }
            return response()->json([
                'is_success'    => true,
                'type'          => 'email',
                'message'       => __('Notification status changed successfully.')
            ]);
        } elseif ($request->type == 'sms') {
            $notify     = NotificationsSetting::find($id);
            $sms        = ($request->sms_notification == "true") ? 1 : 0;
            if ($notify) {
                $notify->sms_notification = $sms;
                $notify->save();
            }
            return response()->json([
                'is_success'    => true,
                'type'          => 'sms',
                'message'       => __('Notification status changed successfully.')
            ]);
        } elseif ($request->type == 'notify') {
            $notify = NotificationsSetting::find($id);
            $notification     = ($request->notify == "true") ? 1 : 0;
            if ($notify) {
                $notify->notify = $notification;
                $notify->save();
            }
            return response()->json([
                'is_success'    => true,
                'type'          => 'notify',
                'message'       => __('Notification status changed successfully.')
            ]);
        } else {
            return redirect()->back()->with('failed', __('something wenth wrong..!'));
        }
    }
}
