<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Mail\Admin\PasswordResets;
use App\Mail\Superadmin\PasswordReset;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MailTemplates\Models\MailTemplate;

class OrderItem extends  Model
{

 
    
        protected $table = 'order_list';
    
        protected $fillable = [
            'code',
            'customer_id',
            'quantity',
            'total_amount',
            'status',
            'date_created',
            'date_updated',
            'product_name',
            'order_token',
            'order_numbers',
            'product_id',
            'payment_method',
            'order_expiration',
            'pix_code',
            'pix_qrcode',
            'txid',
            'discount_amount',
            'whatsapp_status',
            'dwapi_status',
            'id_mp',
            'referral_id'
        ];
    
        protected $casts = [
            'date_created' => 'datetime',
            'date_updated' => 'datetime',
        ];
    
}
