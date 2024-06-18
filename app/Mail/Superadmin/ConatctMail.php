<?php

namespace App\Mail\Superadmin;

use Spatie\MailTemplates\TemplateMailable;

class ConatctMail extends TemplateMailable
{

    public $email;
    public $name;
    public $contact_no;
    public $message;


    public function __construct($details)
    {
        $this->name = $details['name'];
        $this->email = $details['email'];
        $this->contact_no = $details['contact_no'];
        $this->message = $details['message'];
    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
