<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\DocumentGenrator;

class DocumentGenratorObserver
{
    public function created(DocumentGenrator $documentGenrator)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentGenrator)
            ->withProperties($documentGenrator->toArray())
            ->event('created')
            ->log('DocumentGenrator created');
    }

    public function updated(DocumentGenrator $documentGenrator)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentGenrator)
            ->withProperties(UtilityFacades::getChangedAttributes($documentGenrator, $documentGenrator->getChanges()))
            ->event('updated')
            ->log('DocumentGenrator updated');
    }

    public function deleted(DocumentGenrator $documentGenrator)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentGenrator)
            ->withProperties($documentGenrator->toArray())
            ->event('deleted')
            ->log('DocumentGenrator deleted');
    }
}
