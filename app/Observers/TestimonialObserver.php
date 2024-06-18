<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Testimonial;

class TestimonialObserver
{
    public function created(Testimonial $testimonial)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($testimonial)
            ->withProperties($testimonial->toArray())
            ->event('created')
            ->log('Testimonial created');
    }

    public function updated(Testimonial $testimonial)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($testimonial)
            ->withProperties(UtilityFacades::getChangedAttributes($testimonial, $testimonial->getChanges()))
            ->event('updated')
            ->log('Testimonial updated');
    }

    public function deleted(Testimonial $testimonial)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($testimonial)
            ->withProperties($testimonial->toArray())
            ->event('deleted')
            ->log('Testimonial deleted');
    }
}
