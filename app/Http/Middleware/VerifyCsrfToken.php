<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // paytm
        'payment/callback*',
        'paypayment/callback*',
        'paypayment/paytm/callback*',

        // iyzipay
        'iyzipay/callback*',

        // mercado
        'mercado-payment-callback*',
        'mp*',
        
        'pagamento/sucesso*',
        'mercadopago-success*',
        'mercadopago-success',
        'mercadopago-*',

        'mercadopago-failure*',
        'mercadopago-error*',
        'mercadopago-notification*',

        // paymoney
        'payumoney/success*',
        'payumoney/failure*',
        'payumoneypay/success*',
        'payumoneypay/failure*',

        // paytab
        'paytab-success/*',
        'plan-paytab-success/plan/*',

        //Aamarpay
        'aamarpay*',
        'aamarpaypayment*',
    ];
}
