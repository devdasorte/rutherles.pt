<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\SalesDataTable;
use App\Facades\UtilityFacades;
use App\Models\DocumentGenrator;
use App\Models\Event;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Posts;
use App\Models\Role;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
  

    public function index()
    {
        $this->middleware('auth');
        
  


        


        if (Auth::user()->type == 'Admin') {
            $planExpiredDate    = tenancy()->central(function ($tenant) {
                $usr            = User::where('email', Auth::user()->email)->first();
               
            });
        } else {
            $usr                = User::where('email', Auth::user()->email)->first();
            $planExpiredDate    = $usr->plan_expired_date;
        }
        $paymentTypes       = UtilityFacades::getpaymenttypes();
        $earning            = Order::select(['orders.*', 'users.type'])->join('users', 'users.id', '=', 'orders.user_id')->where('users.type', '!=', 'Admin')->where('status', '=', 1)->orWhere('status', '3')->sum('orders.amount');
        $user               = User::where('tenant_id', tenant('id'))->where('type', '!=', 'Admin')->where('created_by', Auth::user()->id)->count();
          $user_data               = tenant();
        $role               = Role::where('tenant_id')->count();
        $planExpiredDate    = $planExpiredDate;
        $documents          = DocumentGenrator::where('tenant_id', tenant('id'))->count();
        $supports           = tenancy()->central(function ($tenant) {
            return SupportTicket::where('tenant_id', $tenant->id)->latest()->take(7)->get();
        });
        $documentsDatas = DocumentGenrator::where('tenant_id', tenant('id'))->latest()->take(5)->get();
        $posts          = Posts::latest()->take(6)->get();
        $events         = Event::latest()->take(5)->get();
        return view('admin.dashboard.home', compact('user', 'role', 'planExpiredDate', 'earning', 'paymentTypes', 'documents', 'supports','documentsDatas', 'posts', 'events', 'user_data'));
    }

    public function sales(SalesDataTable $dataTable)
    {
        if (Auth::user()->type == 'Super Admin' | Auth::user()->type == 'Admin') {
            return $dataTable->render('admin.sales.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function chart(Request $request)
    {
        $arrLable   = [];
        $arrValue   = [];
        $startDate  = Carbon::parse($request->start);
        $endDate    = Carbon::parse($request->end);
        $monthsDiff = $endDate->diffInMonths($startDate);
        if ($monthsDiff >= 0 && $monthsDiff < 3) {
            $endDate    = $endDate->addDay();
            $interval   = CarbonInterval::day();
            $timeType   = "date";
            $dateFormat = "DATE_FORMAT(created_at, '%Y-%m-%d')";
        } elseif ($monthsDiff >= 3 && $monthsDiff < 12) {
            $interval   = CarbonInterval::month();
            $timeType   = "month";
            $dateFormat = "DATE_FORMAT(created_at, '%Y-%m')";
        } else {
            $interval   = CarbonInterval::year();
            $timeType   = "year";
            $dateFormat = "YEAR(created_at)";
        }
        $userReaports = User::select(DB::raw($dateFormat . ' AS ' . $timeType . ',COUNT(id) AS userCount'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy(DB::raw($dateFormat))
            ->get()
            ->toArray();
        $dateRange  = new DatePeriod($startDate, $interval, $endDate);
        switch ($timeType) {
            case 'date':
                $format = 'Y-m-d';
                $labelFormat = 'd M';
                break;
            case 'month':
                $format = 'Y-m';
                $labelFormat = 'M Y';
                break;
            default:
                $format = 'Y';
                $labelFormat = 'Y';
                break;
        }
        foreach ($dateRange as $date) {
            $foundReport = false;
            $Date = Carbon::parse($date->format('Y-m-d'));
            foreach ($userReaports as $orderReaport) {
                if ($orderReaport[$timeType] == $date->format($format)) {
                    $arrLable[] = $Date->format($labelFormat);
                    $arrValue[] = $orderReaport['userCount'];
                    $foundReport = true;
                    break;
                }
            }
            if (!$foundReport) {
                $arrLable[] = $Date->format($labelFormat);
                $arrValue[] = 0.0;
            } else if (!$userReaports) {
                $arrLable[] = $Date->format($labelFormat);
                $arrValue[] = 0.0;
            }
        }
        return response()->json(
            ['lable'    => $arrLable,
            'value'     => $arrValue
        ], 200);
    }

    public function readNotification()
    {
        $user   = User::where('tenant_id', tenant('id'))->first();
        $user->notifications->markAsRead();
        return response()->json(['is_success' => true], 200);
    }

    public function changeThemeMode()
    {
        $user   = \Auth::user();
        if ($user->dark_layout == 1) {
            $user->dark_layout = 0;
        } else {
            $user->dark_layout = 1;
        }
        $user->save();
        $data   = [
            'dark_mode' => ($user->dark_layout == 1) ? 'on' : 'off',
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return response()->json(['mode' => $user->dark_layout]);
    }
}
