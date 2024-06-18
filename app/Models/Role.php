<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tenant_id',
    ];
}
