<?php

namespace App\Mail\Admin;

use Spatie\MailTemplates\TemplateMailable;

class RegisterMail extends TemplateMailable
{

    public $name;
    public $email;


    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
