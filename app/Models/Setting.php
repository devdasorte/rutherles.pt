<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Setting extends Model
{
    use HasFactory, BelongsToTenant;
    public $timestamps = false;
    
    protected $fillable = [
        'key',
        'value',
        'tenant_id'
    ];
}
