<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeDomainRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'tenant_id',
        'actual_domain_name',
        'domain_name',
        'status'
    ];
}
