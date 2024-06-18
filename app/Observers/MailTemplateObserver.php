<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use Spatie\MailTemplates\Models\MailTemplate;

class MailTemplateObserver
{
    public function created(MailTemplate $mailTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($mailTemplate)
            ->withProperties($mailTemplate->toArray())
            ->event('created')
            ->log('MailTemplate created');
    }

    public function updated(MailTemplate $mailTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($mailTemplate)
            ->withProperties(UtilityFacades::getChangedAttributes($mailTemplate, $mailTemplate->getChanges()))
            ->event('updated')
            ->log('MailTemplate updated');
    }

    public function deleted(MailTemplate $mailTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($mailTemplate)
            ->withProperties($mailTemplate->toArray())
            ->event('deleted')
            ->log('MailTemplate deleted');
    }
}
