<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'title', 'start_date', 'end_date', 'color', 'description', 'user'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}
