<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;

class Upload
{


    public function handle($request, Closure $next)


    {


        if (tenant('domains') == null) {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            }
        }

   

        config([
            'filesystems.default'                       => (UtilityFacades::getsettings('storage_type') != '') ? UtilityFacades::getsettings('storage_type') : 'local',
           
        ]);
        return $next($request);
    }
}
