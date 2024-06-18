<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\PageSetting;

class PageSettingObserver
{
    public function created(PageSetting $pageSetting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($pageSetting)
            ->withProperties($pageSetting->toArray())
            ->event('created')
            ->log('PageSetting created');
    }

    public function updated(PageSetting $pageSetting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($pageSetting)
            ->withProperties(UtilityFacades::getChangedAttributes($pageSetting, $pageSetting->getChanges()))
            ->event('updated')
            ->log('PageSetting updated');
    }

    public function deleted(PageSetting $pageSetting)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($pageSetting)
            ->withProperties($pageSetting->toArray())
            ->event('deleted')
            ->log('PageSetting deleted');
    }
}
