<?php

namespace App\Http\Controllers\Superadmin;

use App\DataTables\Superadmin\ActivityLogDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(ActivityLogDataTable $dataTable)
    {
        if (Auth::user()->can('manage-activity-log')) {
            return $dataTable->render('superadmin.activity-log.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
