<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Conversions;

class ConversionsObserver
{
    public function created(Conversions $conversions)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($conversions)
            ->withProperties($conversions->toArray())
            ->event('created')
            ->log('Conversions created');
    }

    public function updated(Conversions $conversions)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($conversions)
            ->withProperties(UtilityFacades::getChangedAttributes($conversions, $conversions->getChanges()))
            ->event('updated')
            ->log('Conversions updated');
    }

    public function deleted(Conversions $conversions)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($conversions)
            ->withProperties($conversions->toArray())
            ->event('deleted')
            ->log('Conversions deleted');
    }
}
