<?php

namespace App\Http\Controllers\Admin;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\Superadmin\ReceiveTicketReplyMail;
use App\Models\Conversions;
use App\Models\NotificationsSetting;
use App\Models\SupportTicket;
use App\Models\User;
use App\Notifications\Superadmin\ReceiveTicketReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class ConversionsController extends Controller
{
    public function store(Request $request, $ticket_id)
    {
        $order = tenancy()->central(function ($tenant) use ($request, $ticket_id) {
            $user       = \Auth::user();
            $ticket     = SupportTicket::find($ticket_id);
            request()->validate([
                'reply_description'     => 'required',
            ]);
            if ($request->hasfile('reply_attachments')) {
                $validation['reply_attachments.*']  = 'mimes:zip,rar,jpeg,jpg,png,gif,svg,pdf,txt,doc,docx,application/octet-stream,audio/mpeg,mpga,mp3,wav|max:204800';
                $this->validate($request, $validation);
            }
            $post                   = [];
            $post['sender']         = Auth::user()->tenant_id;
            $post['ticket_id']      = $ticket->id;
            $post['description']    = $request->reply_description;
            $data                   = [];
            if ($request->hasfile('reply_attachments')) {
                foreach ($request->file('reply_attachments') as $file) {
                    $name       = $file->getClientOriginalName();
                    $file->storeAs('/tickets/' . $ticket->ticket_id, $name);
                    $data[]     = $name;
                }
            }
            $post['attachments']    = json_encode($data);
            $post['tenant_id']      = Auth::user()->tenant_id;
            $conversion             = Conversions::create($post);
            $superAdminMail       = tenancy()->central(function ($tenant) {
                return User::where('type', 'Super Admin')->first()->email;
            });
            $user       = User::where('tenant_id', tenant('id'))->first();
            $notify     = NotificationsSetting::where('title', 'Received Ticket Reply')->first();
            if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                if (isset($notify)) {
                    if ($notify->notify = '1') {
                        $user->notify(new ReceiveTicketReplyNotification($ticket));
                    }
                    if ($notify->email_notification == '1') {
                        if (MailTemplate::where('mailable', ReceiveTicketReplyMail::class)->first()) {
                            try {
                                Mail::to($superAdminMail)->send(new ReceiveTicketReplyMail($conversion, $ticket));
                            } catch (\Exception $e) {
                                return redirect()->back()->with('errors', $e->getMessage());
                            }
                        }
                    }
                }
            }
        });
        return redirect()->back()->with('success', __('Reply created successfully.'));
    }
}
