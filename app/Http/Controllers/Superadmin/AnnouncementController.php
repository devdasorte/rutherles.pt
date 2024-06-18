<?php

namespace App\Http\Controllers\Superadmin;

use App\DataTables\Superadmin\AnnouncementDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(AnnouncementDataTable $dataTable)
    {
        if (Auth::user()->can('manage-announcement')) {
            return $dataTable->render('superadmin.announcement.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('create-announcement')) {
            return view('superadmin.announcement.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-announcement')) {
            $request->validate([
                'title'            => 'required|max:191',
                'description'      => 'required',
                'start_date'       => 'required|date_format:d/m/Y',
                'end_date'         => 'required|date_format:d/m/Y',
                'image'            => 'required|mimes:jpeg,png,jpg',
            ]);
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('announcement');
            }
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            Announcement::create([
                'title'                        => $request->title,
                'description'                  => $request->description,
                'image'                        => $path,
                'start_date'                   => $startDate,
                'end_date'                     => $endDate,
                'share_with_public'            => ($request->share_with_public == 'on') ? '1' : '0',
                'show_landing_page_announcebar'   => ($request->show_landing_page_announcebar == 'on') ? '1' : '0',
                'status'                       => 1,
            ]);
            return redirect()->route('announcement.index')->with('success', __('Announcement created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-announcement')) {
            $announcement    = Announcement::find($id);
            $startDate = Carbon::createFromFormat('Y-m-d', $announcement->start_date)->format('d/m/Y');
            $endDate = Carbon::createFromFormat('Y-m-d', $announcement->end_date)->format('d/m/Y');
            return  view('superadmin.announcement.edit', compact('announcement', 'startDate', 'endDate'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-announcement')) {
            $request->validate([
                'title' => 'required|max:191',
                'description' => 'required',
                'start_date' => 'required|date_format:d/m/Y',
                'end_date' => 'required|date_format:d/m/Y',
                'image' => 'mimes:jpeg,png,jpg',
            ]);
            $announcement    = Announcement::find($id);
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            if ($request->hasFile('image')) {
                Storage::delete($announcement->image);
                $path               = $request->file('image')->store('announcement');
                $announcement->image = $path;
            }
            $announcement->title                          = $request->title;
            $announcement->description                    = $request->description;
            $announcement->start_date                     = $startDate;
            $announcement->end_date                       = $endDate;
            $announcement->share_with_public              = ($request->share_with_public == 'on') ? '1' : '0';
            $announcement->show_landing_page_announcebar  = ($request->show_landing_page_announcebar == 'on') ? '1' : '0';
            $announcement->save();
            return redirect()->route('announcement.index')->with('success', __('Announcement updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-announcement')) {
            $announcement    = Announcement::find($id);
            $announcement->delete();
            return redirect()->route('announcement.index')->with('success', __('Announcement deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function announcementStatus(Request $request, $id)
    {
        $announcement    = Announcement::find($id);
        $input          = ($request->value == "true") ? 1 : 0;
        if ($announcement) {
            $announcement->status = $input;
            $announcement->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Announcement status changed successfully.')]);
    }

    public function showPublicAnnouncement($slug)
    {
        $lang       = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $announcement       =  Announcement::where('slug', $slug)->first();
        $allAnnouncement   =  Announcement::all();
        return view('superadmin.announcement.show-public-announcement', compact('announcement', 'allAnnouncement', 'lang'));
    }
}
