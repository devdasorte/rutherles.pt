<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'social_type',
        'social_id',
		'avtar',
    ];
}
