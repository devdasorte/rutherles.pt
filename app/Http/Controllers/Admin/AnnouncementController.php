<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function showAnnouncementList()
    {
        $currentDate = now()->toDateString();
        $announcementLists = tenancy()->central(function ($tenant) use ($currentDate) {
            return Announcement::where('status', '1')
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->get();
        });
        return view('admin.announcement.show-announcement-list', compact('announcementLists'));
    }

    public function showAnnouncement($id)
    {
        $showAnnouncement = tenancy()->central(function () use ($id) {
            return Announcement::find($id);
        });
        return view('admin.announcement.show-announcement', compact('showAnnouncement'));
    }
}
