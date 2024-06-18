<?php

namespace App\Livewire;
use Illuminate\Http\Request;

use Livewire\Component;
#[Layout('layouts.app')] 

class Webhook extends Component
{

    public $notify;


    public function mount($notify = null)
    {
        $this->notify = $notify;
        
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



        return view('rifa.webhook', compact('notify', 'page' , 'id', 'conn' , 'settings' ,'_settings'));
    }
}
