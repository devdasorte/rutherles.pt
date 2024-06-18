<?php

namespace App\Notifications\Admin;

use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketReplyNotification extends Notification
{
    use Queueable;
    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title', 'Send Ticket Reply')->first();
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
                'alldata' => $this->ticket,
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
