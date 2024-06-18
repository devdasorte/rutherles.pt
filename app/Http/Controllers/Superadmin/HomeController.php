<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\DataTables\Superadmin\SalesDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $this->middleware('auth');
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        } else {
            $user           = User::where('type', 'Admin')->count();
            $plan           = Plan::count();
            $languages      = count(UtilityFacades::languages());
            $earning        = Order::where('status', '=', 1)->orWhere('status', '3')
                ->where('created_at', '>=', Carbon::now()->subDays(365)->toDateString())
                ->where('created_at', '<=', Carbon::now()->toDateString())->sum('amount');
            $paymentTypes   = UtilityFacades::getpaymenttypes();
            $supports       = SupportTicket::latest()->take(7)->get();
            return view('superadmin.dashboard.home', compact('user', 'plan', 'languages', 'earning', 'paymentTypes', 'supports'));
        }
    }

    public function sales(SalesDataTable $dataTable)
    {
        if (Auth::user()->type == 'Super Admin') {
            return $dataTable->render('superadmin.sales.index');
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

        $orderReaports  = Order::select(DB::raw($dateFormat . ' AS ' . $timeType . ',SUM(amount) AS totalAmount'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy(DB::raw($dateFormat))
            ->get()
            ->toArray();
        $dateRange      = new DatePeriod($startDate, $interval, $endDate);
        switch ($timeType) {
            case 'date':
                $format         = 'Y-m-d';
                $labelFormat    = 'd M';
                break;
            case 'month':
                $format         = 'Y-m';
                $labelFormat    = 'M Y';
                break;
            default:
                $format         = 'Y';
                $labelFormat    = 'Y';
                break;
        }
        foreach ($dateRange as $date) {
            $foundReport    = false;
            $Date           = Carbon::parse($date->format('Y-m-d'));
            foreach ($orderReaports as $orderReaport) {
                if ($orderReaport[$timeType] == $date->format($format)) {
                    $arrLable[]     = $Date->format($labelFormat);
                    $arrValue[]     = $orderReaport['totalAmount'];
                    $foundReport    = true;
                    break;
                }
            }
            if (!$foundReport) {
                $arrLable[] = $Date->format($labelFormat);
                $arrValue[] = 0.0;
            } else if (!$orderReaports) {
                $arrLable[] = $Date->format($labelFormat);
                $arrValue[] = 0.0;
            }
        }
        return response()->json([
            'lable' => $arrLable,
            'value' => $arrValue
        ], 200);
    }

    public function readNotification()
    {
        auth()->user()->notifications->markAsRead();
        return response()->json(['is_success' => true], 200);
    }

    public function changeThemeMode()
    {
        $user = Auth::user();
        if ($user->dark_layout == 1) {
            $user->dark_layout = 0;
        } else {
            $user->dark_layout = 1;
        }
        $user->save();
        $data = [
            'dark_mode' => ($user->dark_layout == 1) ? 'on' : 'off',
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
        }
        return response()->json(['mode' => $user->dark_layout]);
    }
}
