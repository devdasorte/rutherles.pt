<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Plan;

class PlanObserver
{
    public function created(Plan $plan)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($plan)
            ->withProperties($plan->toArray())
            ->event('created')
            ->log('Plan created');
    }

    public function updated(Plan $plan)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($plan)
            ->withProperties(UtilityFacades::getChangedAttributes($plan, $plan->getChanges()))
            ->event('updated')
            ->log('Plan updated');
    }

    public function deleted(Plan $plan)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($plan)
            ->withProperties($plan->toArray())
            ->event('deleted')
            ->log('Plan deleted');
    }
}
