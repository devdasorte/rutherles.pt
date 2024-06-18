<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Announcement extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'image',
        'end_date',
        'share_with_public',
        'show_landing_page_announcebar',
        'status',
        'slug'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');

    }

}
