<?php

namespace App\Mail\Superadmin;

use Spatie\MailTemplates\TemplateMailable;

class SupportTicketReplyMail extends TemplateMailable
{
    public $reply;
    public $ticket_id;


    public function __construct($conversion,$ticket)
    {
        $this->reply = $conversion['description'];
        $this->ticket_id = $ticket['ticket_id'];

    }

    public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
