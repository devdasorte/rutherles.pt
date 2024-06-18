<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\OfflineRequest;

class OfflineRequestObserver
{
    public function created(OfflineRequest $offlineRequest)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($offlineRequest)
            ->withProperties($offlineRequest->toArray())
            ->event('created')
            ->log('OfflineRequest created');
    }

    public function updated(OfflineRequest $offlineRequest)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($offlineRequest)
            ->withProperties(UtilityFacades::getChangedAttributes($offlineRequest, $offlineRequest->getChanges()))
            ->event('updated')
            ->log('OfflineRequest updated');
    }

    public function deleted(OfflineRequest $offlineRequest)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($offlineRequest)
            ->withProperties($offlineRequest->toArray())
            ->event('deleted')
            ->log('OfflineRequest deleted');
    }
}
