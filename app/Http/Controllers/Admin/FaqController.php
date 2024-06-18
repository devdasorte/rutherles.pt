<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\FaqDataTable;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(FaqDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-faqs')) {
            return $dataTable->render('admin.faqs.index');
        } else {
            return $dataTable->render('admin.faqs.index');
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-faqs')) {
            return view('admin.faqs.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-faqs')) {
            request()->validate([
                'quetion'   => 'required|max:191',
                'answer'    => 'required',
                'order'     => 'required|unique:faqs,order,',
            ]);
            Faq::create([
                'quetion'   => $request->quetion,
                'answer'    => $request->answer,
                'order'     => $request->order,
            ]);
            return redirect()->route('faqs.index')
                ->with('success', __('Faq created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-faqs')) {
            $faq    = Faq::find($id);
            return view('admin.faqs.edit', compact('faq'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-faqs')) {
            request()->validate([
                'quetion'   => 'required|max:191',
                'answer'    => 'required',
                'order'     => 'required|unique:faqs,order,' . $id,
            ]);
            $faq            = Faq::find($id);
            $faq->quetion   = $request->quetion;
            $faq->answer    = $request->answer;
            $faq->order     = $request->order;
            $faq->update();
            return redirect()->route('faqs.index')->with('success', __('Faq updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-faqs')) {
            $faq    = Faq::find($id);
            $faq->delete();
            return redirect()->route('faqs.index')->with('success', __('Faq deleted successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
