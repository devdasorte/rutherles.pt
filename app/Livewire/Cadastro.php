<?php

namespace App\Livewire;
use Illuminate\Http\Request;

use Livewire\Component;

class Cadastro extends Component
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







        $page = $request->path();
    
        switch ($page) {
           
          
            case 'contato':
                $cam = 'contact';
                break;
            case 'termos-de-uso':
                $cam = 'terms';
                break;
            case 'recuperar-senha':
                $cam = 'recover-password';
                break;
            
            case 'user/alterar-senha':
                $cam = 'change-password';
                break;
            case 'user/atualizar-cadastro':
                $cam = 'update-registration';
                break;
            case 'user/afiliado':
                $cam = 'affiliate';
                break;
           
            case 'cadastrar':
                $cam = 'register';
                break;
            
            default:
                $cam = 'home';
                break;
        }


        include app_path('Includes/ultils.php');


        return view('rifa.pages.' . $cam);
    }
}
