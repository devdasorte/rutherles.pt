<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Artisan;

class XSS
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            \App::setLocale(\Auth::user()->lang);
            // $migrations             = $this->getMigrations();
            // $dbMigrations           = $this->getExecutedMigrations();
            // $numberOfUpdatesPending = count($migrations) - count($dbMigrations);
            // // dd($migrations, $dbMigrations, $numberOfUpdatesPending );
            // if ($numberOfUpdatesPending > 0) {
            //     return redirect()->route('LaravelUpdater::welcome');
            // }
        }
        $input = $request->all();
        // array_walk_recursive($input, function(&$input) {
        //     $input = strip_tags($input);
        // });
        $request->merge($input);
        return $next($request);
    }
}
