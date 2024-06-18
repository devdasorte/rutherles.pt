<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Role;

class RoleObserver
{
    public function created(Role $role)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties($role->toArray())
            ->event('created')
            ->log('Role created');
    }

    public function updated(Role $role)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties(UtilityFacades::getChangedAttributes($role, $role->getChanges()))
            ->event('updated')
            ->log('Role updated');
    }

    public function deleted(Role $role)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties($role->toArray())
            ->event('deleted')
            ->log('Role deleted');
    }
}
