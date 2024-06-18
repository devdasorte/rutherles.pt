<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsSetting extends Model
{
    use HasFactory;

    protected $table = 'notifications_settings';

    protected $fillable = ['title','email_notification','sms_notification','notify', 'status'];
}
