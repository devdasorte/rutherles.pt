<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class RequestDomain extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use BelongsToTenant;
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'tenant_id',
        'domain_name',
        'actual_domain_name',
        'plan_id',
        'country',
        'country_code',
        'dial_code',
        'phone'
    ];
    
    public function payStatus()
    {
        return $this->hasOne('App\Models\Order', 'domainrequest_id', 'id');
    }
}
