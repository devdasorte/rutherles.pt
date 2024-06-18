<?php

namespace App\Mail\Admin;

use Spatie\MailTemplates\TemplateMailable;

class PasswordResets extends TemplateMailable
{
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$url)
    {
        $this->url = $url;
    }

    public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }

}
