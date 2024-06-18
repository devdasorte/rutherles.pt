<?php

namespace App\Notifications\Superadmin;

use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApproveOfflineNotification extends Notification
{
    use Queueable;
    public $offline;
    public $user;

    public function __construct($offline, $user)
    {
        $this->offline = $offline;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title', 'Offline Payment Request Verified')->first();
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
                'alldata' => $this->user,
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
