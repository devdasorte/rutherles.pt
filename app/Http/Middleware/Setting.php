<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Tenancy;

use Illuminate\Support\Facades\View;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\DB;


class Setting
{


    public function handle($request, Closure $next)
    {



        

       
       
       
        
        if (tenant('domains') == null) {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            }
        }

        if (tenant('domains') == null) {
            config([
                'chatify.routes.middleware' => env('CHATIFY_ROUTES_MIDDLEWARE', ['web', 'auth', 'Setting'])
            ]);
        } else {
            config([
                'chatify.routes.middleware' => env('CHATIFY_ROUTES_MIDDLEWARE', ['web', 'auth', 'Setting', Middleware\InitializeTenancyByDomain::class])
            ]);
        }


        
        config([
            'app.name' => UtilityFacades::getsettings('app_name'),
            

           
        ]);
        return $next($request);
    }
}
