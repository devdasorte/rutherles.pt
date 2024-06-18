<?php

namespace App\Mail\Superadmin;

use Spatie\MailTemplates\TemplateMailable;

class ReceiveTicketReplyMail extends TemplateMailable
{
    public $reply;
    public $ticket_id;
    public $title;


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
