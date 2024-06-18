<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;
    protected $fillable = ['id' , 'title', 'type' ,'url_type', 'page_url', 'friendly_url', 'description'];
}
