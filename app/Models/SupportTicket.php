<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'name',
        'email',
        'subject',
        'status',
        'description',
        'attachments',
        'tenant_id'
    ];

    public function conversions()
    {
        return $this->hasMany('App\Models\Conversions', 'ticket_id', 'id')->orderBy('id');
    }
}
