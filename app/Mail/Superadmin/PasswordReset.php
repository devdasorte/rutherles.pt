<?php

namespace App\Mail\Superadmin;

use Spatie\MailTemplates\TemplateMailable;

class PasswordReset extends TemplateMailable
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
