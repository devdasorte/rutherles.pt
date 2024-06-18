<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\DataTables\Superadmin\SmsTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Auth;

class SmsTemplateController extends Controller
{
    public function index(SmsTemplateDataTable $dataTable)
    {
        if (Auth::user()->can('manage-sms-template')) {
            return $dataTable->render('superadmin.sms-template.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-sms-template')) {
            $smsTemplate   = SmsTemplate::find($id);
            return view('superadmin.sms-template.edit', compact('smsTemplate'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-sms-template')) {
            request()->validate([
                'event'     => 'required',
                'template'  => 'required',
            ]);
            $smsTemplates  = $request->all();
            $smsTemplate   = SmsTemplate::find($id);
            $smsTemplate->update($smsTemplates);
            return redirect()->route('sms-template.index')->with('success', __('Sms template updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
