<?php

namespace App\Notifications\Superadmin;

use App\Facades\UtilityFacades;
use App\Mail\Superadmin\ConatctMail;
use App\Mail\Superadmin\RegisterMail;
use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Spatie\MailTemplates\Models\MailTemplate;

class ConatctNotification extends Notification
{
    use Queueable;
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title', 'new enquiry details')->first();
        if ($notify->notify == '1' && $notify->email_notification = '1') {
            return ['mail', 'database'];
        } elseif ($notify->notify = '1') {
            return ['database'];
        } elseif ($notify->email_notification = '1') {
            return ['mail'];
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
                'email' => $this->request->email,
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
