<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SystemService
{
    private static $systemInfo = null;

    public function __construct()
    {
        // Load system info if it's not already loaded
        if (is_null(self::$systemInfo)) {
            $this->loadSystemInfo();
        }
    }

    protected function loadSystemInfo()
    {

        $settings = DB::table('settings')->get();

        $systemInfo = [];
        foreach ($settings as $setting) {
            $systemInfo[$setting->key] = $setting->value;

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
                $_SESSION[$setting->key] = $setting->value;

            }
        }

        self::$systemInfo = $systemInfo;
        session(['system_info' => $systemInfo]);
    }

    public function userdata($field = '')
    {
        if (!empty($field) && session()->has('userdata')) {
            return session('userdata.' . $field);
        }
        return null;
    }

    public function info($field = '')
    {
        if (!empty($field) && self::$systemInfo) {
            return self::$systemInfo[$field] ?? null;
        }
        return null;
    }
}
?>
