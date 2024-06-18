<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ClassController extends Controller

{
 
    public function index(Request $request){
        
        $action = $request->input('action');
        
        require app_path('Includes/class/Main.php');
        

  
    }
    
    public function auth(Request $request)
    {
        $action = $request->input('action');

        require app_path('Includes/class/Auth.php');
    }

    public function customer(Request $request){
        
        $action = $request->input('action');
     
        require app_path('Includes/class/Customer.php');
        

  
    }


 public function system(Request $request){
    $action = $request->input('action');
    
        require app_path('Includes/class/System.php');
        

  
    }




    

    
    
    
    
    
    
    
}