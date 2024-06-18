<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\CategoryDataTable;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-category')) {
            return $dataTable->render('admin.category.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-category')) {
            $category   = Category::all();
            return view('admin.category.create', compact('category'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-category')) {
            request()->validate([
                'name'      => 'required|max:50',
                'status'    => 'required',
            ]);
            Category::create([
                'name'      => $request->name,
                'status'    => $request->status
            ]);
            return redirect()->route('category.index')->with('success', __('Category created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-category')) {
            $category   = Category::find($id);
            return view('admin.category.edit', compact('category'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-category')) {
            request()->validate([
                'name'      => 'required|max:50',
                'status'    => 'required',
            ]);
            $category           = Category::find($id);
            $category->name     = $request->name;
            $category->status   = $request->status;
            $category->update();
            return redirect()->route('category.index')->with('success', __('Category updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-category')) {
            $category       = Category::find($id);
            $category->delete();
            return redirect()->route('category.index')->with('success', __('Category deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function categoryStatus(Request $request, $id)
    {
        $category       = Category::find($id);
        $categoryStatus          = ($request->value == "true") ? 1 : 0;
        if ($category) {
            $category->status = $categoryStatus;
            $category->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Category status changed successfully.')
        ]);
    }
}
