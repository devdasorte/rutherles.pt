<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\RequestDomain;

class RequestDomainObserver
{
    public function created(RequestDomain $requestDomain)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($requestDomain)
            ->withProperties($requestDomain->toArray())
            ->event('created')
            ->log('RequestDomain created');
    }

    public function updated(RequestDomain $requestDomain)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($requestDomain)
            ->withProperties(UtilityFacades::getChangedAttributes($requestDomain, $requestDomain->getChanges()))
            ->event('updated')
            ->log('RequestDomain updated');
    }

    public function deleted(RequestDomain $requestDomain)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($requestDomain)
            ->withProperties($requestDomain->toArray())
            ->event('deleted')
            ->log('RequestDomain deleted');
    }
}
