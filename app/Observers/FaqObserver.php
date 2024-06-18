<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Faq;

class FaqObserver
{
    public function created(Faq $faq)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($faq)
            ->withProperties($faq->toArray())
            ->event('created')
            ->log('Faq created');
    }

    public function updated(Faq $faq)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($faq)
            ->withProperties(UtilityFacades::getChangedAttributes($faq, $faq->getChanges()))
            ->event('updated')
            ->log('Faq updated');
    }

    public function deleted(Faq $faq)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($faq)
            ->withProperties($faq->toArray())
            ->event('deleted')
            ->log('Faq deleted');
    }
}
