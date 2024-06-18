<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\PlanDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;

use Exception;
use App\Models\Coupon;
use App\Models\UserCoupon;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use App\Livewire\Adm;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;



class PlanoController extends Controller
{
    public function index(Request $request)
    {


        try{
    
            $mercadoAccessToken = tenancy()->central(function ($tenant) {
                return UtilityFacades::getsettings('mercado_access_token');
            });
            
    
    
    
            MercadoPagoConfig::setAccessToken($mercadoAccessToken);

         

      
        $client = new PaymentClient();
   $data = [];
        $new_order  = tenancy()->central(function ($tenant) use ($data, $request) {
        $order = Order::create([
            'plan_id'           => $request->plan_id,
            'user_id'           => $tenant->id,
            'amount'            => $request->transaction_amount,
            'discount_amount'   => 0,
            'coupon_code'       => null,
            'status'            => 0,
        ]);
        return $order;

    });
        

        $payment = $client->create([
            "payment_method_id" =>$request->payment_method_id,
            "transaction_amount" => (float) $request->transaction_amount,
            "notification_url" => "https://rifei.rutherles.pt/mp",
            
           "external_reference" => $new_order->id,
                
            "payer" => [
              "email" => $request->payer['email']
              

            ]

          ]);

          
        return response()->json($payment);
       

        }catch (MPApiException $e) {
            echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
            echo "Content: ";
            var_dump($e->getApiResponse()->getContent());
            echo "\n";
        } catch (Exception $e) {
            echo "General Exception: " . $e->getMessage() . "\n";
        }
        //return response()->json($payment);

    }

    public function preferencia(Request $request)

    {


        try{
    
        $mercadoAccessToken = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('mercado_access_token');
        });
        



        MercadoPagoConfig::setAccessToken($mercadoAccessToken);




        $preference = new PreferenceClient();



$items = array(

    array(
        "title" => "Teste",
        "quantity" => 1,
        "currency_id" => "BRL",
        "unit_price" => 100.0
    )
);

$payer = array(
    "name" => "João",
    "surname" => "Silva",
    "email" => "teste@gmail.com",
);

$payment_methods = array(
  "excluded_payment_methods" => array(
    array("id" => "master")
  ),
  "excluded_payment_types" => array(
    array("id" => "ticket")
  ),
  "installments" => 1
);

$back_urls = array(
    "success" => "https://rifei.rutherles.pt/mp/Main.php?action=receive_notify",
    "failure" => "https://rifei.rutherles.pt/mp/Main.php?action=receive_notify",
    "pending" => "https://rifei.rutherles.pt/mp/Main.php?action=receive_notify"
);

$auto_return = "approved";


$notification_url = "https://rifei.rutherles.pt/mp/Main.php?action=receive_notify";

$external_reference = "1234";


$data =[
    "items"=> $items,
    "payer"=> $payer,
    "payment_methods"=> $payment_methods,
    "back_urls"=> $back_urls,
    "auto_return"=> $auto_return,
    "notification_url"=> $notification_url,
    "external_reference"=> $external_reference

];


// Dados da API e do token de autorização
$url = 'https://api.mercadopago.com/checkout/preferences';
$accessToken = $mercadoAccessToken;


// Inicializa a sessão cURL
$ch = curl_init($url);

// Configurações da requisição cURL
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executa a requisição e captura a resposta
$response = curl_exec($ch);

// Verifica se ocorreu algum erro na requisição
if (curl_errno($ch)) {
    echo 'Erro na requisição: ' . curl_error($ch);
} else {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo 'Código HTTP: ' . $httpCode . PHP_EOL;
    echo 'Resposta: ' . $response . PHP_EOL;
}

// Fecha a sessão cURL
curl_close($ch);



echo json_encode($response);

return response()->json($response);

        }

        catch (MPApiException $e) {
            echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
            echo "Content: ";
            var_dump($e->getApiResponse()->getContent());
            echo "\n";
        } catch (Exception $e) {
            echo "General Exception: " . $e->getMessage() . "\n";
        }




    }

    public function createMyPlan()
    {
        if (Auth::user()->can('create-plan')) {
            return view('admin.plans.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('create-plan')) {
            request()->validate([
                'name'          => 'required|unique:plans,name|max:50',
                'price'         => 'required',
                'duration'      => 'required',
                'durationtype'  => 'required',
                'max_users'     => 'required',
                'description'   => 'max:191',
            ]);
            $paymentTypes = UtilityFacades::getpaymenttypes();
            if (!$paymentTypes) {
                return redirect()->route('plans.index')->with('errors', __('Please on at list one payment type.'));
            }
            Plan::create([
                'name'          => $request->name,
                'price'         => $request->price,
                'duration'      => $request->duration,
                'durationtype'  => $request->durationtype,
                'max_users'     => $request->max_users,
                'description'   => $request->description,
            ]);
            return redirect()->route('plans.myplan')->with('success', __('Plan created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function editMyplan($id)
    {
        if (Auth::user()->can('edit-plan')) {
            $plan   = Plan::find($id);
            return view('admin.plans.edit', compact('plan'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-plan')) {
            if (Auth::user()->type == 'Super Admin') {
                request()->validate([
                    'name'          => 'required|max:50|unique:plans,name,' . $id,
                    'price'         => 'required',
                    'duration'      => 'required',
                    'description'   => 'max:191',
                ]);
                $plan               = Plan::find($id);
                $plan->name         = $request->input('name');
                $plan->price        = $request->input('price');
                $plan->duration     = $request->input('duration');
                $plan->durationtype = $request->input('durationtype');
                $plan->description  = $request->input('description');
                $plan->save();
            } else {
                request()->validate([
                    'name'      => 'required|max:50|unique:plans,name,' . $id,
                    'price'     => 'required',
                    'duration'  => 'required',
                    'max_users' => 'required',
                ]);
                $plan               = Plan::find($id);
                $plan->name         = $request->input('name');
                $plan->price        = $request->input('price');
                $plan->duration     = $request->input('duration');
                $plan->durationtype = $request->input('durationtype');
                $plan->max_users    = $request->input('max_users');
                $plan->description  = $request->input('description');
                $plan->save();
            }
            if (Auth::user()->type == 'Admin') {
                return redirect()->route('plans.myplan')->with('success', __('Plan updated successfully.'));
            } else {
                return redirect()->route('plans.index')->with('success', __('Plan updated successfully.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-plan')) {
            $plan = Plan::find($id);
            if ($plan->id != 1) {
                $planExistInOrder = Order::where('plan_id', $plan->id)->first();
                if (empty($planExistInOrder)) {
                    $plan->delete();
                    return redirect()->route('plans.myplan')->with('success', __('Plan deleted successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('Can not delete this plan because its purchased by users.'));
                }
            } else {
                return redirect()->back()->with('failed', __('Can not delete this plan because its free plan.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function planStatus(Request $request,$id)
    {
        $plan   = Plan::find($id);
        $planStatus  = ($request->value == "true") ? 1 : 0;
        if ($plan) {
            $plan->active_status = $planStatus;
            $plan->save();
        }
        return response()->json([
            'is_success'    => true,
            'message'       => __('Plan status changed successfully.')
        ]);
    }

    public function payment($code)
    {
        $plan_id  = \Illuminate\Support\Facades\Crypt::decrypt($code);
        if (Auth::user()->type == 'Admin') {
            $plan           = tenancy()->central(function ($tenant) use ($plan_id) {
                return Plan::find($plan_id);
            });
            $paymentTypes   = tenancy()->central(function ($tenant) {
                return UtilityFacades::getpaymenttypes();
            });
            $adminPaymentSetting    = UtilityFacades::getadminplansetting();
        } else {
            $plan                   = Plan::find($plan_id);
            $paymentTypes           = UtilityFacades::getpaymenttypes();
            $adminPaymentSetting    = UtilityFacades::getplansetting();
        }
        if ($plan) {
            return view('admin.plans.payment', compact('plan', 'adminPaymentSetting', 'paymentTypes'));
        } else {
            return redirect()->back()->with('errors', __('Plan deleted successfully.'));
        }
    }
    public function Update_user($external_reference = null, $payment_id = null)
    {


        $data = [];
        $request = new Request();
        $order  = tenancy()->central(function ($tenant) use ($data, $request) {
            $datas                  = Order::find($external_reference);
            $datas->status          = 1;
            $datas->payment_id      = $payment_id;
            $datas->payment_type    = 'mercadopago';
            $datas->update();
            $user       = User::find($datas->user_id);
            $plan           = Plan::find($datas->plan_id);
            $user->plan_id  = $plan->id;
            if ($plan->durationtype == 'mes' && $plan->id != '1') {
                $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
            } elseif ($plan->durationtype == 'ano' && $plan->id != '1') {
                $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
            } else {
                $user->plan_expired_date = null;
            }
            $user->save();
            return $datas;
        });
        return response()->json($order);
    }

    public function checkStatus(Request $request)
    {
       $id = $request->order_id;
         $order  = tenancy()->central(function ($tenant) use ($id) {
              return Order::find($id);
         });
            return response()->json($order);
    }



    public function receive_notify(Request $request){

        $data = $request->all();
        $data = json_encode($data);
        
        if(strpos($data, 'amp;') !== false)
        {
            $data = str_replace('amp;', '', $data);
        }
        $data = json_decode($data, true);
        $id = $data['id'];
        $type = $data['topic'];
       


    

 
        $mercadoAccessToken = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('mercado_access_token');
        });
       
        
         
          
    
     
    
      
    
        if ($type == 'payment') {
            $url = 'https://api.mercadopago.com/v1/payments/' . $id;
            $headers = ['Accept: application/json', 'Authorization: Bearer ' . $mercadoAccessToken];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resposta = curl_exec($ch);
            curl_close($ch);
    
            $payment_info = json_decode($resposta, true);
            $payment_id = $payment_info['id'];
            $status = $payment_info['status'];
            $payment_type = $payment_info['payment_type_id'];
            $uid = $payment_info['external_reference'];
            
            if ($status == 'approved') {
               
 
                $data = [
                    'external_reference' => $uid,
                    'payment_id' => $payment_id,
                ];
                
                // Converte os dados para JSON
                $jsonData = json_encode($data);
                
                // URL do endpoint
 
                $order  = tenancy()->central(function ($tenant) use ($data, $request) {
                    $datas                  = Order::find($data['external_reference']);
                    $datas->status          = 1;
                    $datas->payment_id      = $data['payment_id'];
                    $datas->payment_type    = 'mercadopago';
                    $datas->update();
                    $user       = User::find($datas->user_id);
                    $plan           = Plan::find($datas->plan_id);
                    $user->plan_id  = $plan->id;
                    if ($plan->durationtype == 'mes' && $plan->id != '1') {
                        $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
                    } elseif ($plan->durationtype == 'ano' && $plan->id != '1') {
                        $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
                    } else {
                        $user->plan_expired_date = null;
                    }
                    $user->save();
                    return $datas;
                });
 
              
                return response()->json($order);
   
                
            } elseif ($status == 'pending') {
               
                echo 'pending';
            } else {
                $data = [
                    'external_reference' => $uid,
                  
                ];
                
                // Converte os dados para JSON
                $jsonData = json_encode($data);
                
                // URL do endpoint
 
                $order  = tenancy()->central(function ($tenant) use ($data, $request) {
                    $datas                  = Order::find($data['external_reference']);
                    $datas->status          = 2;
                    $datas->payment_id      = null;
                    $datas->payment_type    = null;
                    
                    $datas->update();
                    return $datas;
                });
 
              
                return response()->json($order);
   
            }
    

        }}
}
