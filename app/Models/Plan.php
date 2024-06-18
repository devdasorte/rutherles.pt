<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'max_roles',
        'max_documents',
        'max_blogs',
        'discount',
        'durationtype',
        'description',
        'tenant_id',
        'active_status',
        'discount_setting',
        'vantagens',
    ];
}
