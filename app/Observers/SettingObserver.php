<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Setting;

class SettingObserver
{
    public function created(Setting $setting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($setting)
            ->withProperties($setting->toArray())
            ->event('created')
            ->log('Setting created');
    }

    public function updated(Setting $setting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($setting)
            ->withProperties(UtilityFacades::getChangedAttributes($setting, $setting->getChanges()))
            ->event('updated')
            ->log('Setting updated');
    }

    public function deleted(Setting $setting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($setting)
            ->withProperties($setting->toArray())
            ->event('deleted')
            ->log('Setting deleted');
    }
}
