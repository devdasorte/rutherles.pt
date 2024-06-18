<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UtilityFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'utility';
    }
}
