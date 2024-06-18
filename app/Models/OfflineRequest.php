<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'plan_id','coupon_id','user_id','email'
    ];

    public function Plan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan_id');
    }

    public function orderUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    public function Coupon()
    {
        return $this->hasOne('App\Models\Coupon', 'id', 'coupon_id');
    }
}
