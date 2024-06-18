<?php

namespace App\Mail\Superadmin;

use App\Models\RequestDomain;

use Spatie\MailTemplates\TemplateMailable;

class ApproveMail extends TemplateMailable
{
   
    public $domain_name;
    public $name;
    public $login_button_url;


    public function __construct(RequestDomain $domain_details)
    {
        $this->domain_name = $domain_details->domain_name;
        $this->name = $domain_details->name;
        $this->login_button_url = $domain_details->domain_name;
    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}