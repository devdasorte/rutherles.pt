<?php

namespace App\Notifications\Superadmin;

use App\Facades\UtilityFacades;
use App\Mail\Superadmin\RegisterMail;
use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Spatie\MailTemplates\Models\MailTemplate;

class RegisterNotification extends Notification
{
    use Queueable;
    public $central_domainip;
    public $domain;

    public function __construct($central_domainip, $domain)
    {
        $this->central_domainip = $central_domainip;
        $this->domain = $domain;
    }

    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title', 'Register mail')->first();
        if ($notify->email_notification == '1' && $notify->notify == '1') {
            return ['mail', 'database'];
        } elseif ($notify->email_notification == '1') {
            return ['mail'];
        } elseif ($notify->notify == '1') {
            return ['database'];
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' => [
                'domain' => $this->domain,
            ],
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'data' => $this->data['body']
        ];
    }
}
