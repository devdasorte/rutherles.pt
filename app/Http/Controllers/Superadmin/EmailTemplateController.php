<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\DataTables\Superadmin\EmailTemplateDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MailTemplates\Models\MailTemplate;

class EmailTemplateController extends Controller
{
    public function index(EmailTemplateDataTable $dataTable)
    {
        if (Auth::user()->can('manage-email-template')) {
            return $dataTable->render('superadmin.email-template.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-email-template')) {
            $mailTemplate = MailTemplate::find($id);
            return view('superadmin.email-template.edit', compact('mailTemplate'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-email-template')) {
            request()->validate([
                'subject' => 'required',
                'html_template' => 'required',
            ]);
            $mailTemplates = $request->all();
            $mailTemplate = MailTemplate::find($id);
            $mailTemplate->update($mailTemplates);
            return redirect()->route('email-template.index')->with('success', __('Email template updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
