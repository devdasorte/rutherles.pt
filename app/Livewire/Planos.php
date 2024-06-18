<?php

namespace App\Livewire;
use App\Models\Coupon;
use Livewire\Component;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use App\Models\UserCoupon;
use Carbon\Carbon;
use App\Models\Order;
use Exception;
use MercadoPago\Checkout\Preference;
use MercadoPago\MPRequestOptions;
use MercadoPago\Client\Common\RequestOptions;

use MercadoPago\Resources\PreApprovalPlan;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Tests\MercadoPagoConfigTest;

use Illuminate\Support\Facades\Auth;
use App\Facades\UtilityFacades;

class Planos extends Component
{
    public $planos;
    public $user_plano;
    public $user;
    public $message;
    public $plano_id;
    public $fatura ;
    public $preferenceId;
    public $mercadoAccessToken;
    public $data;

    public function mount()
    {

        $this->mercadoAccessToken = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('mercado_access_token');
        });
        

        MercadoPagoConfig::setAccessToken($this->mercadoAccessToken);
        $this->planos = tenancy()->central(function ($tenant) {
            return Plan::all();
        });

        $this->user = tenancy()->central(function ($tenant) {
            return User::find($tenant->id);
        });

        $this->user_plano = $this->user->plan_id;


 
MercadoPagoConfig::setAccessToken($this->mercadoAccessToken);

$client = new PreferenceClient();
$preference = $client->create([
"back_urls"=>array(
    "success" => "http://test.com/success",
    "failure" => "http://test.com/failure",
    "pending" => "http://test.com/pending"
),
"differential_pricing" => array(
    "id" => 1,
),
"expires" => false,
"items" => array(
    array(
        "id" => "1234",
        "title" => "Dummy Title",
        "description" => "Dummy description",
        "picture_url" => "http://www.myapp.com/myimage.jpg",
        "category_id" => "car_electronics",
        "quantity" => 2,
        "currency_id" => "BRL",
        "unit_price" => 100
    )
),
"marketplace_fee" => 0,
"payer" => array(
    "name" => "Test",
    "surname" => "User",
    "email" => "your_test_email@example.com",
    "phone" => array(
        "area_code" => "11",
        "number" => "4444-4444"
    ),
    "identification" => array(
        "type" => "CPF",
        "number" => "19119119100"
    ),
    "address" => array(
        "zip_code" => "06233200",
        "street_name" => "Street",
        "street_number" => "123"
    )
),
"additional_info" => "Discount: 12.00",
"auto_return" => "all",
"binary_mode" => true,
"external_reference" => "1643827245",
"marketplace" => "none",
"notification_url" => "http://notificationurl.com",
"operation_type" => "regular_payment",
"payment_methods" => array(
    "default_payment_method_id" => "master",
    "excluded_payment_types" => array(
        array(
            "id" => "visa"
        )
    ),
    "excluded_payment_methods" => array(
        array(
            "id" => ""
        )
    ),
    "installments" => 5,
    "default_installments" => 1
),
"shipments" >= array(
    "mode" => "custom",
    "local_pickup" => false,
    "default_shipping_method" => null,
    "free_methods" => array(
        array(
            "id" => 1
        )
    ),
    "cost" => 10,
    "free_shipping" => false,
    "dimensions" => "10x10x20,500",
    "receiver_address" => array(
        "zip_code" => "06000000",
        "street_number" => "123",
        "street_name" => "Street",
        "floor" => "12",
        "apartment" => "120A",
        "city_name" => "Rio de Janeiro",
        "state_name" => "Rio de Janeiro",
        "country_name" => "Brasil"
    )
),
"statement_descriptor" => "Test Store",
]);


$this->preferenceId = $preference->id;




    }

    public function triggerJsFunction()
    {
        $this->dispatchBrowserEvent('trigger-js-function');
    }


    public function createpayment()
    {
    


  
  
        MercadoPagoConfig::setAccessToken($this->mercadoAccessToken);
  
        $client = new PaymentClient();
        $request_options = new MPRequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: 7778347834"]);
        if (isset($this->data['id'])) {

            echo $this->data;
            return false;
            $payment = $client->create([$this->data], $request_options);
        echo implode($payment);
        }
  
       
    }

    public function render()
    {

        if (!isset($_settings)) {
            include app_path('Includes/settings.php');
            $conn = $_settings->conn;
            $settings = $_settings;

        }




        

        return view('livewire.pagamento',compact('conn','settings'))->extends('layouts.adm')->section('content');
    }
}
