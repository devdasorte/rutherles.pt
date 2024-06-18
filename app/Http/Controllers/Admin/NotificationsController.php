<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationsSetting;
use Illuminate\Http\Request;

class Notifications extends Controller
{
    public function mercadopago(Request $request, $id)
    {

        session(['webhook_id' => $id]);
        
    }
}
