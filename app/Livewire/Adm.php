<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Facades\UtilityFacades;

use Illuminate\Support\Facades\Route;

use Livewire\Attributes\On;
class Adm extends Component
{
    public $path;
    public $id;
    public $product_id;
    public $planos;
    public $user_plano;

    public $message;
    public $plano_id;

    public $user_type;

    protected $conn;
    protected $settings;


    
    public function showDrawer3()
    {
        $this->showDrawer3 = !$this->showDrawer3 ;
    }
    
  
   
    public function mount(Request $request )
    {

        
        $this->path = $request->path();
        $this->id = $request->id;
        $this->product_id = $request->product_id;
        $this->title = $request->path();




       


  
        if (!isset($this->settings)) {
            include app_path('Includes/settings.php');
            $this->conn = $_settings->conn;
            $this->settings = $_settings;
        }


        $this->planos = tenancy()->central(function ($tenant) {
            return Plan::all();
        });

        $this->user = tenancy()->central(function ($tenant) {
            return User::find($tenant->id);
        });

        $this->user_plano = $this->user->plan_id;
 
        $this->user = tenancy()->central(function ($tenant) {
            return User::find($tenant->id);
        });

        $this->paymentTypes = 0;



    
        $this->user_type = Auth::user()->type;
    }



    public function mercadopago($id)
    {

        $mercadoAccessToken = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('mercado_access_token');
        });
        

        MercadoPagoConfig::setAccessToken($mercadoAccessToken);
        $client = new PreferenceClient();

        $plan = Plan::find($id);
        $price          = $plan->price;
        $total_price    = $price;
        $quantity       = 1;
        $unit_price     = $total_price;
        $title          = "Plan : " . $plan->name;
       


        

        $successUrl = route("mercado.success");
        $failureUrl = route("mercado.error");

        $user = Auth::user();

        $client = new PreferenceClient();
        $preference = $client->create([
            "items" => [
                [   
                    
                    "id" => $id . '-' . $user->id,
                    "title" => $title,
                    "quantity" => $quantity,
                    "unit_price" => $unit_price,
                    "currency_id" => "BRL",
                    "description" => $plan->description,
                ],
            ],
          

            "back_urls" => [
                "success" => $successUrl,
                "failure" => $failureUrl,
            ],


       
            "auto_return" => "approved",

            'payment_methods' => [
                'excluded_payment_methods' => [
                    ['id' => 'amex']
                ],
                'excluded_payment_types' => [
                    ['id' => 'atm']
                ],
                'installments' => 1
            ],

            "notification_url" => "https://admindev.rutherles.pt/notifications",


          


        ]);


        if (7 != 'live') {

            //$this->message = $preference->id;
            $redirectUrl = $preference->init_point;
           return redirect($redirectUrl);
        } else {
            $redirectUrl = $preference->sandbox_init_point;
            return redirect($redirectUrl);
        }



       // $this->message = json_encode($preference);





    }
 





    public function render()
    {
        $routes = [
            'campanha-nova' => 'rifa.admin.products.manage_product',
            'campanha' => 'rifa.admin.products.index',
            'sorteios' => 'rifa.admin.sorteio.index',
            'planos' => 'livewire.planos',
            'usuarios' => 'rifa.admin.user.list',
            'usuarios-novo' => 'rifa.admin.user.manage_user',
            'relatorio' => 'rifa.admin.report.index',
            'ranking' => 'rifa.admin.ranking.index',
            'pedidos' => 'rifa.admin.orders.index',
            'pedidos-novo' => 'rifa.admin.orders.create_order',
            'clientes' => 'rifa.admin.customers.index',
            'clientes-novo' => 'rifa.admin.customers.manage_customer',
            'settings' => 'admin.settings.index',
            'afiliados' => 'rifa.admin.affiliates.index',
            'afiliados/novo' => 'rifa.admin.affiliates.create_affiliate',
            'afiliados/pagamento' => 'rifa.admin.affiliates.create_payment',
            'gateway' => 'rifa.admin.gateway.index',
            'config' => 'rifa.admin.system_info.index',
            'logs' => 'rifa.admin.logs.index',
            'cotas' => 'rifa.admin.cotas.index',
            'profile' => 'admin.profile.index',
        ];

        if ($this->path === 'home') {
            $cam = $this->user_type == 'Super Admin' ? 'superadmin.dashboard.home' : 'admin.dashboard.home';
        } elseif (isset($routes[$this->path])) {
            $cam = $routes[$this->path];
        } elseif (preg_match('/^campanha-\d+$/', $this->path)) {
            $cam = 'rifa.admin.products.manage_product';
        } elseif (preg_match('/^usuarios-\d+$/', $this->path)) {
            $cam = 'rifa.admin.user.manage_user';
        } elseif (preg_match('/^pedidos-\d+$/', $this->path)) {
            $cam = 'rifa.admin.orders.view_order';
        } elseif (preg_match('/^clientes\/\d+$/', $this->path)) {
            $cam = 'rifa.admin.customers.manage_customer';
        } elseif (preg_match('/^afiliados-\d+$/', $this->path)) {
            $cam = 'rifa.admin.affiliates.manage_affiliates';
        } elseif (preg_match('/^-\d+$/', $this->path)) {
            $cam = 'rifa.admin.affiliates.manage_affiliates';
        } else {
            $cam = 'admin.dashboard.home';
        }

        $description = '';

        
        return view($cam, [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'path' => $this->path,
            'conn' => $this->conn,
            'settings' => $this->settings,
            'user'=> $this->user,
            'User' => $this->user,
            'Auth' => Auth::user(),

        ])->extends('layouts.adm')->section('content')->title($this->title);
    }
}
