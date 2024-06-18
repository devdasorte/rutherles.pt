<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversions extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id', 'description', 'attachments', 'sender', 'tenant_id'
    ];
    
    public function replyBy()
    {
        if (auth()->user()->type == 'Super Admin') {
            return $this->hasOne(User::class, 'id', 'sender')->first();
        } else {
            $user = tenancy()->central(function ($tenant) {
                return $this->hasOne(User::class, 'id', 'sender')->first();
            });
            return $user;
        }
    }

    public function sendsupport()
    {
        return $this->hasOne('App\Models\Sendsupport', 'id', 'ticket_id');
    }
}
