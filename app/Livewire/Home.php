<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public bool $showDrawer1 = false;
public bool $showDrawer2 = false;

    public function render()

    {
    

if(!isset($_settings)) {
    include app_path('Includes/settings.php');
    $conn = $_settings->conn;
    $settings = $_settings;
}



        return view('rifa.pages.home', compact( 'conn' , 'settings' ,'_settings'));
    }
}
