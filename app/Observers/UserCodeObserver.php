<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\UserCode;

class UserCodeObserver
{
    public function created(UserCode $userCode)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($userCode)
            ->withProperties($userCode->toArray())
            ->event('created')
            ->log('UserCode created');
    }

    public function updated(UserCode $userCode)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($userCode)
            ->withProperties(UtilityFacades::getChangedAttributes($userCode, $userCode->getChanges()))
            ->event('updated')
            ->log('UserCode updated');
    }

    public function deleted(UserCode $userCode)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($userCode)
            ->withProperties($userCode->toArray())
            ->event('deleted')
            ->log('UserCode deleted');
    }
}
