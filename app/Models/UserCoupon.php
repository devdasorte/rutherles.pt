<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'coupon',
        'requestdomain'
    ];

    public function userDetail()
    {
        return $this->hasOne('App\Models\User', 'id', 'user');
    }

    public function requestdomain()
    {
        return $this->hasOne('App\Models\RequestDomain', 'id', 'domainrequest');
    }

    public function coupon_detail()
    {
        return $this->hasOne('App\Models\Coupon', 'id', 'coupon');
    }
}
