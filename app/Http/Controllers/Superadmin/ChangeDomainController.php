<?php

namespace App\Http\Controllers\Superadmin;

use App\DataTables\Superadmin\ChangeDomainRequestDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\Superadmin\DisapprovedMail;
use App\Models\ChangeDomainRequest;
use App\Models\NotificationsSetting;
use App\Models\User;
use App\Notifications\Superadmin\DisapprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;
use Stancl\Tenancy\Database\Models\Domain;

class ChangeDomainController extends Controller
{
    public function changeDomainIndex(ChangeDomainRequestDataTable $dataTable)
    {
        if (Auth::user()->can('manage-change-domain')) {
            return $dataTable->render('superadmin.change-domain.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function changeDomainApprove($id)
    {
        if (Auth::user()->can('edit-change-domain')) {
            $changeDomain           = ChangeDomainRequest::find($id);
            $changeDomain->status   = 1;
            $changeDomain->save();
            $domain                 = Domain::where('tenant_id', $changeDomain->tenant_id)->first();
            $domain->domain         = $changeDomain->domain_name;
            $domain->save();
            return redirect()->back()->with('success', __('Domain change successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function domainDisApprove($id)
    {
        if (Auth::user()->can('edit-change-domain')) {
            $requestDomain  = ChangeDomainRequest::find($id);
            $view           =   view('superadmin.change-domain.reason', compact('requestDomain'));
            return ['html'  => $view->render()];
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function domainDisApproveUpdate(Request $request, $id)
    {
        if (Auth::user()->can('edit-change-domain')) {
            request()->validate([
                'reason' => 'required',
            ]);
            $requestDomain          = ChangeDomainRequest::find($id);
            $requestDomain->reason  = $request->reason;
            $requestDomain->status  = 2;
            $requestDomain->update();
            $users  = User::where('type', 'Super Admin')->first();
            $notify = NotificationsSetting::where('title', 'Domain Unverified')->first();
            if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                if (isset($notify)) {
                    if ($notify->notify == '1') {
                        $users->notify(new DisapprovedNotification($requestDomain));
                    }
                    if ($notify->email_notification == '1') {
                        if (MailTemplate::where('mailable', DisapprovedMail::class)->first()) {
                            try {
                                Mail::to($requestDomain->email)->send(new DisapprovedMail($requestDomain));
                            } catch (\Exception $e) {
                                return redirect()->back()->with('errors', $e->getMessage());
                            }
                        }
                    }
                }
            }
            return redirect()->back()->with('success', __('Change domain request disapprove successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
