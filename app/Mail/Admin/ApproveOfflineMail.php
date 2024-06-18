<?php

namespace App\Mail\Admin;

use App\Models\OfflineRequest;

use Spatie\MailTemplates\TemplateMailable;

class ApproveOfflineMail extends TemplateMailable
{

    public $name;
    public $email;


    public function __construct(OfflineRequest $offline,$user)
    {
        $this->name = $user->name;
        $this->email = $offline->email;

    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
