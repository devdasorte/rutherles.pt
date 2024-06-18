<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Coupon;

class CouponObserver
{
    public function created(Coupon $coupon)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($coupon)
            ->withProperties($coupon->toArray())
            ->event('created')
            ->log('Coupon created');
    }

    public function updated(Coupon $coupon)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($coupon)
            ->withProperties(UtilityFacades::getChangedAttributes($coupon, $coupon->getChanges()))
            ->event('updated')
            ->log('Coupon updated');
    }

    public function deleted(Coupon $coupon)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($coupon)
            ->withProperties($coupon->toArray())
            ->event('deleted')
            ->log('Coupon deleted');
    }
}
