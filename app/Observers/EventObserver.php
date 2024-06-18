<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Event;

class EventObserver
{
    public function created(Event $event)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->withProperties($event->toArray())
            ->event('created')
            ->log('Event created');
    }

    public function updated(Event $event)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->withProperties(UtilityFacades::getChangedAttributes($event, $event->getChanges()))
            ->event('updated')
            ->log('Event updated');
    }

    public function deleted(Event $event)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->withProperties($event->toArray())
            ->event('deleted')
            ->log('Event deleted');
    }
}
