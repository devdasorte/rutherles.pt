<?php

namespace App\Mail\Superadmin;

use App\Models\RequestDomain;

use Spatie\MailTemplates\TemplateMailable;

class RegisterMail extends TemplateMailable
{

    public $domain_name;
    public $name;
    public $email;
    public $domain_ip;

    public function __construct($request,$central_domainip)
    {
        $this->domain_name = $request->domains;
        $this->name = $request->name;
        $this->email = $request->email;
        $this->domain_ip = $central_domainip;
    }

   public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
