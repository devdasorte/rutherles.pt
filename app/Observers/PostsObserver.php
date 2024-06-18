<?php

namespace App\Observers;

use App\Facades\UtilityFacades;
use App\Models\Posts;

class PostsObserver
{
    public function created(Posts $posts)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($posts)
            ->withProperties($posts->toArray())
            ->event('created')
            ->log('Posts created');
    }

    public function updated(Posts $posts)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($posts)
            ->withProperties(UtilityFacades::getChangedAttributes($posts, $posts->getChanges()))
            ->event('updated')
            ->log('Posts updated');
    }

    public function deleted(Posts $posts)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($posts)
            ->withProperties($posts->toArray())
            ->event('deleted')
            ->log('Posts deleted');
    }
}
