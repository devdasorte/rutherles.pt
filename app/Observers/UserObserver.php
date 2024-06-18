<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties($user->toArray())
            ->event('created')
            ->log('User created');
    }

    public function updated(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(UtilityFacades::getChangedAttributes($user, $user->getChanges()))
            ->event('updated')
            ->log('User updated');
    }

    public function deleted(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties($user->toArray())
            ->event('deleted')
            ->log('User deleted');
    }
}
