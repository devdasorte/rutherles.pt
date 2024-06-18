<?php

namespace App\Mail\Superadmin;

use Spatie\MailTemplates\TemplateMailable;

class SupportTicketMail extends TemplateMailable
{
    public $name;
    public $email;
    public $title;
    public $description;
    public $ticket_id;


    public function __construct($ticket)
    {
        $this->name = $ticket['name'];
        $this->email = $ticket['email'];
        $this->title = $ticket['subject'];
        $this->description = $ticket['description'];
        $this->ticket_id = $ticket['ticket_id'];
    }

    public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
