<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SupportTicketDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\Superadmin\SupportTicketMail;
use App\Models\Conversions;
use App\Models\NotificationsSetting;
use App\Models\SupportTicket;
use App\Models\User;
use App\Notifications\Superadmin\SupportTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class SupportTicketController extends Controller
{
    public function index(SupportTicketDataTable $dataTable)
    {
        if (Auth::user()->can('manage-support-ticket')) {
            return $dataTable->render('admin.support-ticket.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-support-ticket')) {
            return  view('admin.support-ticket.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-support-ticket')) {
            $order  = tenancy()->central(function ($tenant) use ($request) {
                request()->validate([
                    'subject'       => 'required|max:191',
                    'status'        => 'required|max:100',
                    'description'   => 'required',
                ]);
                if ($request->hasfile('attachments')) {
                    $validation['attachments.*'] = 'mimes:zip,rar,jpeg,jpg,png,gif,svg,pdf,txt,doc,docx,application/octet-stream,audio/mpeg,mpga,mp3,wav|max:204800';
                    $this->validate($request, $validation);
                }
                $post              = $request->all();
                $post['ticket_id'] = time();
                $data              = [];
                if ($request->hasfile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $name   = $file->getClientOriginalName();
                        $file->storeAs('/tickets/' . $post['ticket_id'], $name);
                        $data[] = $name;
                    }
                }
                $post['attachments']    = json_encode($data);
                $post['tenant_id']      = Auth::user()->tenant_id;
                $post['name']           = Auth::user()->name;
                $post['email']          = Auth::user()->email;
                $ticket                 = SupportTicket::create($post);
                $superAdminMail     = tenancy()->central(function ($tenant) {
                    return User::where('type', 'Super Admin')->first()->email;
                });
                $user   = User::where('tenant_id', tenant('id'))->first();
                $notify = NotificationsSetting::where('title', 'New Ticket Opened')->first();
                if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                    if (isset($notify)) {
                        if ($notify->notify = '1') {
                            $user->notify(new SupportTicketNotification($ticket));
                        }
                        if ($notify->email_notification == '1') {
                            if (MailTemplate::where('mailable', SupportTicketMail::class)->first()) {
                                try {
                                    Mail::to($superAdminMail)->send(new SupportTicketMail($ticket));
                                } catch (\Exception $e) {
                                    return redirect()->back()->with('errors', $e->getMessage());
                                }
                            }
                        }
                    }
                }
            });
            return redirect()->route('support-ticket.index')->with('success', __('Support ticket created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-support-ticket')) {
            $supportTicket  = tenancy()->central(function ($tenant) use ($id) {
                return SupportTicket::find($id);
            });
            $conversion     = tenancy()->central(function ($tenant) use ($id) {
                return Conversions::all();
            });
            return view('admin.support-ticket.edit', compact('supportTicket', 'conversion'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-support-ticket')) {
            $order = tenancy()->central(function ($tenant) use ($request, $id) {
                $supportTicket  = SupportTicket::find($id);
                request()->validate([
                    'subject'       => 'required|max:191',
                    'status'        => 'required|max:100',
                    'description'   => 'required',
                ]);
                if ($request->hasfile('attachments')) {
                    $validation['attachments.*'] = 'mimes:zip,rar,jpeg,jpg,png,gif,svg,pdf,txt,doc,docx,application/octet-stream,audio/mpeg,mpga,mp3,wav|max:204800';
                    $this->validate($request, $validation);
                }
                $post   = $request->all();
                if ($request->hasfile('attachments')) {
                    $data   = json_decode($supportTicket->attachments, true);
                    foreach ($request->file('attachments') as $file) {
                        $name   = $file->getClientOriginalName();
                        $file->storeAs('/tickets/' . $supportTicket->ticket_id, $name);
                        $data[] = $name;
                    }
                    $post['attachments'] = json_encode($data);
                }
                $supportTicket->update($post);
            });
            return redirect()->route('support-ticket.index')->with('success', __('Support ticket updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-support-ticket')) {
            $order  = tenancy()->central(function ($tenant) use ($id) {
                $supportTicket  = SupportTicket::find($id);
                $conversions    = Conversions::where('ticket_id', $id);
                $supportTicket->delete();
                $conversions->delete();
            });
            return redirect()->route('support-ticket.index')->with('success', __('Support ticket deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
