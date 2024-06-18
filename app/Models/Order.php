<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_id',
        'user_id',
        'stripe_payment_id',
        'amount',
        'tenant_id',
        'status',
        'domainrequest_id',
        'payment_id',
        'coupon_code',
        'discount_amount',
        'payment_type'
    ];

    public function Plan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan_id');
    }
    
    public function orderUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
