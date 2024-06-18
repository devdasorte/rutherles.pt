<?php

namespace App\Livewire;
use Illuminate\Http\Request;

use Livewire\Component;

class Compras extends Component
{

    public $slug;


    public function mount($slug = null)
    {
        $this->slug = $slug;
        
    }
       
      
    

    
    public function render(Request $request)

    {
        $path = $request->path();
        $cam = 'home';
        $id = $request->id;
        $page = $request->page;


if(!isset($_settings)) {
    include app_path('Includes/settings.php');
    $conn = $_settings->conn;
    $settings = $_settings;
}



$id = $request->slug;


        $page = $request->path();
        
        switch ($page) {
           
            case 'compra/' . $id:
                $cam = 'orders.view_order';
                break;

            case 'meus-numeros':
                $cam = 'my-numbers';
                break;
            default:
                $cam = 'orders.index';
                break;
        }





        return view('rifa.pages.' . $cam, compact('slug', 'page' , 'id', 'conn' , 'settings' ,'_settings'));
    }
}
