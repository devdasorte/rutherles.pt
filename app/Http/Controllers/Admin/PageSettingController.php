<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\PageSettingDataTable;
use App\Models\PageSetting;
use Illuminate\Support\Facades\Auth;

class PageSettingController extends Controller
{
    public function index(PageSettingDataTable $dataTable)
    {
        if (Auth::user()->can('manage-blog')) {
            return $dataTable->render('admin.page-settings.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-blog')) {
            return view('admin.page-settings.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-blog')) {
            request()->validate([
                'title'         => 'required|max:50',
                'type'          => 'required',
            ]);
            $pageSetting        =  new  PageSetting();
            $pageSetting->title = $request->title;
            $pageSetting->type  = $request->type;
            if($request->type == 'link'){
                $pageSetting->url_type      = $request->url_type;
                $pageSetting->page_url      = filter_var($request->page_url, FILTER_VALIDATE_URL) ? $request->page_url : url($request->page_url);
                $pageSetting->friendly_url  = filter_var($request->friendly_url, FILTER_VALIDATE_URL) ? $request->friendly_url : url($request->friendly_url);
            }else{
                $pageSetting->description = $request->descriptions;
            }
            $pageSetting->save();
            return redirect()->route('pagesetting.index')->with('success',  __('Page Setting Created successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-blog')) {
            $pageSettings = PageSetting::find($id);
            return view('admin.page-settings.edit', compact('pageSettings'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-blog')) {
            request()->validate([
                'title'         => 'required|max:50',
                'type'          => 'required',
            ]);
            $pageSettingUpdate          = PageSetting::find($id);
            $pageSettingUpdate->title   = $request->title;
            $pageSettingUpdate->type    = $request->type;
            if($request->type == 'link'){
                $pageSettingUpdate->url_type        = $request->url_type;
                $pageSettingUpdate->page_url        = filter_var($request->page_url, FILTER_VALIDATE_URL) ? $request->page_url : url($request->page_url);
                $pageSettingUpdate->friendly_url    = filter_var($request->friendly_url, FILTER_VALIDATE_URL) ? $request->friendly_url : url($request->friendly_url);
            } else {
                $pageSettingUpdate->description     = $request->descriptions;
            }
            $pageSettingUpdate->save();
            return redirect()->route('pagesetting.index')->with('success',  __('Page Setting Updated successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-blog')) {
            $pageSettingDelete = PageSetting::where('id', $id)->first();
            $pageSettingDelete->delete();
            return redirect()->back()->with('success', __('Page Setting Deleted Successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }
}
