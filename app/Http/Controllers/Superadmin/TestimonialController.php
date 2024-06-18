<?php

namespace App\Http\Controllers\Superadmin;

use App\DataTables\Superadmin\TestimonialDataTable;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index(TestimonialDataTable $dataTable)
    {
        if (Auth::user()->can('manage-testimonial')) {
            return $dataTable->render('superadmin.testimonial.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-testimonial')) {
            return view('superadmin.testimonial.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-testimonial')) {
            request()->validate([
                'name'          => 'required|max:50',
                'title'         => 'required|max:191',
                'description'   => 'required',
                'designation'   => 'required',
                'rating'        => 'required',
                'image'         => 'required|mimes:jpeg,png,jpg',
            ]);
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('testimonials');
            }
            Testimonial::create([
                'name'          => $request->name,
                'title'         => $request->title,
                'description'   => $request->description,
                'image'         => $path,
                'designation'   => $request->designation,
                'rating'        => $request->rating,
                'status'        => 1,
            ]);
            return redirect()->route('testimonial.index')->with('success', __('Testimonial created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-testimonial')) {
            $testimonial    = Testimonial::find($id);
            return  view('superadmin.testimonial.edit', compact('testimonial'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-testimonial')) {
            request()->validate([
                'name'          => 'required|max:50',
                'title'         => 'required|max:191',
                'description'   => 'required',
                'designation'   => 'required',
                'rating'        => 'required',
            ]);
            $testimonial    = Testimonial::find($id);
            if ($request->hasFile('image')) {
                $path               = $request->file('image')->store('testimonials');
                $testimonial->image = $path;
            }
            $testimonial->name          = $request->name;
            $testimonial->title         = $request->title;
            $testimonial->description   = $request->description;
            $testimonial->designation   = $request->designation;
            $testimonial->rating        = $request->rating;
            $testimonial->save();
            return redirect()->route('testimonial.index')->with('success', __('Testimonials updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-testimonial')) {
            $testimonial    = Testimonial::find($id);
            $testimonial->delete();
            return redirect()->route('testimonial.index')->with('success', __('Testimonials deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function testimonialStatus(Request $request, $id)
    {
        $testimonial    = Testimonial::find($id);
        $input          = ($request->value == "true") ? 1 : 0;
        if ($testimonial) {
            $testimonial->status = $input;
            $testimonial->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Testimonial status changed successfully.')
        ]);
    }
}
