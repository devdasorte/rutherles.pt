<?php

namespace App\Mail\Admin;

use Spatie\MailTemplates\TemplateMailable;

class TestMail extends TemplateMailable
{
    public function __construct()
    {
    }

    public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
