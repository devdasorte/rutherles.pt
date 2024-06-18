<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ActivityLogDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(ActivityLogDataTable $dataTable)
    {
        if (Auth::user()->can('manage-activity-log')) {
            return $dataTable->render('admin.activity-log.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
