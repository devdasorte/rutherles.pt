<?php

namespace App\Mail\Superadmin;
use Spatie\MailTemplates\TemplateMailable;

class DisapprovedMail extends TemplateMailable
{

    public $domain_name;
    public $name;
    public $reason;


    public function __construct($domain_details)
    {
        $this->domain_name = $domain_details->domain_name;
        $this->name = $domain_details->name;
        $this->reason = $domain_details->reason;
    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
