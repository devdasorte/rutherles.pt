<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties($category->toArray())
            ->event('created')
            ->log('Category created');
    }

    public function updated(Category $category)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties(UtilityFacades::getChangedAttributes($category, $category->getChanges()))
            ->event('updated')
            ->log('Category updated');
    }

    public function deleted(Category $category)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties($category->toArray())
            ->event('deleted')
            ->log('Category deleted');
    }
}
