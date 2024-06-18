<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Announcement;

class AnnouncementObserver
{
    public function created(Announcement $announcement)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties($announcement->toArray())
            ->event('created')
            ->log('Announcement created');
    }

    public function updated(Announcement $announcement)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties(UtilityFacades::getChangedAttributes($announcement, $announcement->getChanges()))
            ->event('updated')
            ->log('Announcement updated');
    }

    public function deleted(Announcement $announcement)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties($announcement->toArray())
            ->event('deleted')
            ->log('Announcement deleted');
    }
}
