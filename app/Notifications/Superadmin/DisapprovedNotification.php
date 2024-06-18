<?php

namespace App\Notifications\Superadmin;

use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisapprovedNotification extends Notification
{
    use Queueable;
    public $requestdomain;

    public function __construct($requestdomain)
    {
        $this->requestdomain = $requestdomain;
    }

    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title', 'Domain Unverified')->first();
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
                'alldata' => $this->requestdomain,
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
