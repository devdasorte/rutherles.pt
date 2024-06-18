<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\SmsTemplate;

class SmsTemplateObserver
{
    public function created(SmsTemplate $smsTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($smsTemplate)
            ->withProperties($smsTemplate->toArray())
            ->event('created')
            ->log('SmsTemplate created');
    }

    public function updated(SmsTemplate $smsTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($smsTemplate)
            ->withProperties(UtilityFacades::getChangedAttributes($smsTemplate, $smsTemplate->getChanges()))
            ->event('updated')
            ->log('SmsTemplate updated');
    }

    public function deleted(SmsTemplate $smsTemplate)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($smsTemplate)
            ->withProperties($smsTemplate->toArray())
            ->event('deleted')
            ->log('SmsTemplate deleted');
    }
}
