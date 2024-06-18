<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\DocumentMenu;

class DocumentMenuObserver
{
    public function created(DocumentMenu $documentMenu)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentMenu)
            ->withProperties($documentMenu->toArray())
            ->event('created')
            ->log('DocumentMenu created');
    }

    public function updated(DocumentMenu $documentMenu)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentMenu)
            ->withProperties(UtilityFacades::getChangedAttributes($documentMenu, $documentMenu->getChanges()))
            ->event('updated')
            ->log('DocumentMenu updated');
    }

    public function deleted(DocumentMenu $documentMenu)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($documentMenu)
            ->withProperties($documentMenu->toArray())
            ->event('deleted')
            ->log('DocumentMenu deleted');
    }
}
