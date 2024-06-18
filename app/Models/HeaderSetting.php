<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HeaderSetting extends Model
{
    use HasFactory;
    use HasSlug;

    protected $table = 'header_settings';
    protected $fillable = ['id' , 'menu', 'slug', 'page_id'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('menu')
        ->saveSlugsTo('slug');
    }
}
