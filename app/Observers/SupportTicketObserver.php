<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\SupportTicket;

class SupportTicketObserver
{
    public function created(SupportTicket $supportTicket)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($supportTicket)
            ->withProperties($supportTicket->toArray())
            ->event('created')
            ->log('SupportTicket created');
    }

    public function updated(SupportTicket $supportTicket)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($supportTicket)
            ->withProperties(UtilityFacades::getChangedAttributes($supportTicket, $supportTicket->getChanges()))
            ->event('updated')
            ->log('SupportTicket updated');
    }

    public function deleted(SupportTicket $supportTicket)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($supportTicket)
            ->withProperties($supportTicket->toArray())
            ->event('deleted')
            ->log('SupportTicket deleted');
    }
}
