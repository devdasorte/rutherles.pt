<?php

namespace App\Livewire;
use Illuminate\Http\Request;

use Livewire\Component;

class Campanhas extends Component
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
           
            case 'campanhas/' . $id:
                $cam = 'products.view_product';
                break;

            case 'ganhadores':
                $cam = 'winners';
                break;
            default:
                $cam = 'campaign';
                break;
        }

        include app_path('Includes/ultils.php');
     



        return view('rifa.pages.' . $cam, compact('slug', 'page' , 'id', 'conn' , 'settings' ,'_settings'));
    }
}
