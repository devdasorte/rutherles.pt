<?php

namespace App\Models;

use App\Facades\UtilityFacades;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class SmsTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'template',
        'variables',
    ];

    public function send($number, $data)
    {
        $message = __($this->template, $data);
        return $this->__sendSMS($number, $message);
    }

    private function __sendSMS($number, $message)
    {
        try {
            $sid = UtilityFacades::getsettings('twilio_sid');
            $token = UtilityFacades::getsettings('twilio_auth_token');
            $twilioNumber = UtilityFacades::getsettings('twilio_number');
            $client = new Client($sid, $token);
            $client->messages->create($number, [
                'from' => $twilioNumber,
                'body' => $message
            ]);
            return ['is_success' => true];
        } catch (\Exception $e) {
            return ['is_success' => false, 'message' => $e->getMessage()];
        }
    }
}
