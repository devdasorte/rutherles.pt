<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class DocumentGenrator extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'id',
        'title',
        'logo',
        'json',
        'status',
        'slug',
        'tenant_id',
        'theme'
    ];

    public function document()
    {
        return DocumentMenu::all();
    }

    public function getFormArray()
    {
        return $this->belongsToMany(DocumentMenu::class, 'document_id', 'id');
    }

    public function document_menu()
    {
        return $this->hasOne(DocumentMenu::class, 'document_id');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
