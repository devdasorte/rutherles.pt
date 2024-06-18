<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SystemAnalyticsController extends Controller
{
    public function telescope()
    {
        if (Auth::user()->type == 'Super Admin') {
            return view('vendor.telescope.layout');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function pulse()
    {
 
            return view('vendor.pulse.dashboard');
       
    }

    
}
