<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Module;

class ModuleObserver
{
    public function created(Module $module)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($module)
            ->withProperties($module->toArray())
            ->event('created')
            ->log('Module created');
    }

    public function updated(Module $module)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($module)
            ->withProperties(UtilityFacades::getChangedAttributes($module, $module->getChanges()))
            ->event('updated')
            ->log('Module updated');
    }

    public function deleted(Module $module)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($module)
            ->withProperties($module->toArray())
            ->event('deleted')
            ->log('Module deleted');
    }
}
