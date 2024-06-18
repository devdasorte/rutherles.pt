<?php

namespace App\Facades;

use App\Mail\Superadmin\ApproveMail;
use App\Models\NotificationsSetting;
use App\Models\Order;
use App\Models\Plan;
use App\Models\RequestDomain;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserCoupon;
use App\Notifications\Superadmin\ApproveNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\MailTemplates\Models\MailTemplate;
use Stancl\Tenancy\Database\Models\Domain;

class Utility
{
    public function settings()
    {
        $data = DB::table('settings');
        $data = $data->get();
        $settings = [
            'date_format' => 'M j, Y',
            'time_format' => 'g:i A',
        ];
        foreach ($data as $row) {
            $settings[$row->key] = $row->value;
        }
        return $settings;
    }

    public function date_format($date)
    {
        return Carbon::parse($date)->format(Self::getsettings('date_format'));
    }

    public function time_format($date)
    {
        return Carbon::parse($date)->format(Self::getsettings('time_format'));
    }

    public function date_time_format($date)
    {
        return Carbon::parse($date)->format(Self::getsettings('date_format') . ' ' . Self::getsettings('time_format'));
    }

    public function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }
        return true;
    }

    public function getValByName($key)
    {
        $setting = Self::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }
        return $setting[$key];
    }

    public function languages()
    {
        $dir = base_path() . '/resources/lang/';
        $glob = glob($dir . '*', GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            },
            $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            },
            $arrLang
        );
        $arrLang = array_filter($arrLang);
        return $arrLang;
    }

    public function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }




    public function getsettings($value = '')
    {
        $setting = Setting::select('value');
        if (!empty(tenant('id'))) {
            $setting->where('tenant_id', tenant('id'));
        } else {
            $setting->whereNull('tenant_id');
        }
        $set =  $setting->where('key', $value)->first();
        $val = '';
        if (!empty($set->value)) {

            $val = $set->value;
        }
        return $val;
    }

    public function storesettings($formatted_array)
    {
        if (tenant('id') == null) {
            $row = Setting::where('key', $formatted_array['key'])->whereNull('tenant_id')->first();
        } else {
            $row = Setting::where('key', $formatted_array['key'])->where('tenant_id', tenant('id'))->first();
        }
        if (empty($row)) {
            Setting::create($formatted_array);
        } else {
            $row->update($formatted_array);
        }
        $affected_row = Setting::find($formatted_array['key']);
        return $affected_row;
    }

    public function getpath($name)
    {
        if (config('filesystems.default') == 'local'  && tenant('id') == null) {
            $src = $name ? Storage::url(tenant('id') . $name) : Storage::url('logo/app-logo.png');
        } elseif (config('filesystems.default') == 'local') {
            $src = $name ? Storage::url(tenant('id') . '/' . $name) : Storage::url('logo/app-logo.png');
        } else {
            $src = $name ? Storage::url($name) : Storage::url('logo/app-logo.png');
        }
        return $src;
    }

    public function approved_request($data, $database)
    {
        $req = RequestDomain::find($data);
        $data = Order::where('domainrequest_id', $req->id)->first();
        $input['name'] = $req->name;
        $input['email'] = $req->email;
        $input['password'] = $req->password;

        $input['country_code'] = $req->country_code;
        $input['dial_code'] = $req->dial_code;
        $input['phone'] = $req->phone;

        $input['type'] = 'Admin';
        $input['email_verified_at'] = Carbon::now();
        $input['phone_verified_at'] = Carbon::now();
        $input['plan_id'] = 1;
        $user = User::create($input);
        $user->assignRole('Admin');
        if (tenant('id') == null && Utility::getsettings('database_permission') == 1) {
            try {
                $tenant = Tenant::create([
                    'id' => $user->id,
                ]);
                $domain = Domain::create([
                    'domain' => $req->domain_name,
                    'actual_domain' => $req->actual_domain_name,
                    'tenant_id' => $tenant->id,
                ]);
                $user->tenant_id = $tenant->id;
                $user->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('errors', $e->getMessage());
            }
        } else {
            $tenant = Tenant::create([
                'id' => $user->id,
                'tenancy_db_name' => $database['db_name'],
                'tenancy_db_username' => $database['db_username'],
                'tenancy_db_password' => $database['db_password'],
            ]);
            $domain = Domain::create([
                'domain' => $req->domain_name,
                'actual_domain' => $req->actual_domain_name,
                'tenant_id' => $tenant->id,
            ]);
            $user->tenant_id = $tenant->id;
            $user->save();
        }
        $usercoupon =  UserCoupon::where('domainrequest', $req->id)->first();
        if ($usercoupon) {
            $usercoupon->user = $user->id;
            $usercoupon->domainrequest = null;
            $usercoupon->save();
        }
        $user = User::find($tenant->id);
        $plan = Plan::find($data->plan_id);
        $user->plan_id = $plan->id;
        if ($plan->durationtype == 'Month' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
        } elseif ($plan->durationtype == 'Year' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
        } else {
            $user->plan_expired_date = null;
        }
        $user->save();
        $req->is_approved = 1;
        $req->save();
        $data->user_id = $user->id;
        $data->save();

        $users = User::where('type', 'Super Admin')->first();
        $notify = NotificationsSetting::where('title', 'Domain Verified')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (isset($notify)) {
                if ($notify->notify == '1') {
                    $users->notify(new ApproveNotification($req));
                }
                if ($notify->email_notification == '1') {
                    if (MailTemplate::where('mailable', ApproveMail::class)->first()) {
                        try {
                            Mail::to($req->email)->send(new ApproveMail($req));
                        } catch (\Exception $e) {
                            return redirect()->back()->with('errors', $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    public function getplansetting()
    {
        $data = [];
        $data['stripesetting'] = Self::getsettings('stripesetting');
        $data['stripe_key'] = Self::getsettings('stripe_key');
        $data['stripe_secret'] = Self::getsettings('stripe_secret');
        $data['stripe_description'] = Self::getsettings('stripe_description');

        $data['razorpaysetting'] = Self::getsettings('razorpaysetting');
        $data['razorpay_key'] = Self::getsettings('razorpay_key');
        $data['razorpay_secret'] = Self::getsettings('razorpay_secret');
        $data['razorpay_description'] = Self::getsettings('razorpay_description');

        $data['paypalsetting'] = Self::getsettings('paypalsetting');
        $data['paypal_client_id'] = Self::getsettings('paypal_client_id');
        $data['paypal_client_secret'] = Self::getsettings('paypal_client_secret');
        $data['paypal_mode'] = Self::getsettings('paypal_mode');
        $data['paypal_description'] = Self::getsettings('paypal_description');

        $data['flutterwavesetting'] = Self::getsettings('flutterwavesetting');
        $data['flutterwave_key'] = Self::getsettings('flutterwave_key');
        $data['flutterwave_secret'] = Self::getsettings('flutterwave_secret');
        $data['flutterwave_description'] = Self::getsettings('flutterwave_description');

        $data['paystacksetting'] = Self::getsettings('paystacksetting');
        $data['paystack_key'] = Self::getsettings('paystack_public_key');
        $data['paystack_secret'] = Self::getsettings('paystack_secret_key');
        $data['paystack_currency'] = Self::getsettings('paystack_currency');
        $data['paystack_description'] = Self::getsettings('paystack_description');

        $data['paytmsetting'] = Self::getsettings('paytmsetting');
        $data['paytm_merchant_id'] = Self::getsettings('paytm_merchant_id');
        $data['paytm_merchant_key'] = Self::getsettings('paytm_merchant_key');
        $data['paytm_description'] = Self::getsettings('paytm_description');

        $data['coingatesetting'] = Self::getsettings('coingatesetting');
        $data['coingate_environment'] = Self::getsettings('coingate_environment');
        $data['coingate_auth_token'] = Self::getsettings('coingate_auth_token');
        $data['coingate_description'] = Self::getsettings('coingate_description');

        $data['mercadosetting'] = Self::getsettings('mercadosetting');
        $data['mercado_mode'] = Self::getsettings('mercado_mode');
        $data['mercado_access_token'] = Self::getsettings('mercado_access_token');
        $data['mercado_description'] = Self::getsettings('mercado_description');

        $data['payfastsetting'] = Self::getsettings('payfastsetting');
        $data['payfast_merchant_id'] = Self::getsettings('payfast_merchant_id');
        $data['payfast_merchant_key'] = Self::getsettings('payfast_merchant_key');
        $data['payfast_mode'] =  Self::getsettings('payfast_mode');
        $data['payfast_signature'] =  Self::getsettings('payfast_signature');
        $data['payfast_description'] = Self::getsettings('payfast_description');

        $data['toyyibpaysetting'] = Self::getsettings('toyyibpaysetting');
        $data['toyyibpay_secret_key'] =  Self::getsettings('toyyibpay_secret_key');
        $data['toyyibpay_category_code'] =  Self::getsettings('toyyibpay_category_code');
        $data['toyyibpay_description'] = Self::getsettings('toyyibpay_description');

        $data['iyzipaysetting'] = Self::getsettings('iyzipaysetting');
        $data['iyzipay_key'] = Self::getsettings('iyzipay_key');
        $data['iyzipay_secret'] = Self::getsettings('iyzipay_secret');
        $data['iyzipay_mode'] = Self::getsettings('iyzipay_mode');
        $data['iyzipay_description'] = Self::getsettings('iyzipay_description');

        $data['sspaysetting'] = Self::getsettings('sspaysetting');
        $data['sspay_category_code'] = Self::getsettings('sspay_category_code');
        $data['sspay_secret_key'] = Self::getsettings('sspay_secret_key');
        $data['sspay_description'] = Self::getsettings('sspay_description');

        $data['cashfreesetting'] = Self::getsettings('cashfreesetting');
        $data['cashfree_mode'] = Self::getsettings('cashfree_mode');
        $data['cashfree_app_id'] = Self::getsettings('cashfree_app_id');
        $data['cashfree_secret_key'] = Self::getsettings('cashfree_secret_key');
        $data['cashfree_description'] = Self::getsettings('cashfree_description');

        $data['aamarpaysetting'] = Self::getsettings('aamarpaysetting');
        $data['aamarpay_store_id'] = Self::getsettings('aamarpay_store_id');
        $data['aamarpay_signature_key'] = Self::getsettings('aamarpay_signature_key');
        $data['aamarpay_description'] = Self::getsettings('aamarpay_description');

        $data['payumoneysetting'] = Self::getsettings('payumoneysetting');
        $data['payumoney_mode'] = Self::getsettings('payumoney_mode');
        $data['payumoney_merchant_key'] = Self::getsettings('payumoney_merchant_key');
        $data['payumoney_salt_key'] = Self::getsettings('payumoney_salt_key');
        $data['payumoney_description'] = Self::getsettings('payumoney_description');

        $data['paytabsetting'] = Self::getsettings('paytabsetting');
        $data['paytab_profile_id'] = Self::getsettings('paytab_profile_id');
        $data['paytab_server_key'] = Self::getsettings('paytab_server_key');
        $data['paytab_region'] = Self::getsettings('paytab_region');
        $data['paytab_description'] = Self::getsettings('paytab_description');

        $data['benefitsetting'] = Self::getsettings('benefitsetting');
        $data['benefit_key'] = Self::getsettings('benefit_key');
        $data['benefit_secret_key'] = Self::getsettings('benefit_secret_key');
        $data['benefit_description'] = Self::getsettings('benefit_description');

        $data['molliesetting'] = Self::getsettings('molliesetting');
        $data['mollie_api_key'] = Self::getsettings('mollie_api_key');
        $data['mollie_profile_id'] = Self::getsettings('mollie_profile_id');
        $data['mollie_partner_id'] = Self::getsettings('mollie_partner_id');
        $data['mollie_description'] = Self::getsettings('mollie_description');

        $data['skrillsetting'] = Self::getsettings('skrillsetting');
        $data['skrill_email'] = Self::getsettings('skrill_email');
        $data['skrill_description'] = Self::getsettings('skrill_description');

        $data['easebuzzsetting'] = Self::getsettings('easebuzzsetting');
        $data['easebuzz_environment'] = Self::getsettings('easebuzz_environment');
        $data['easebuzz_merchant_key'] = Self::getsettings('easebuzz_merchant_key');
        $data['easebuzz_salt'] = Self::getsettings('easebuzz_salt');
        $data['easebuzz_description'] = Self::getsettings('easebuzz_description');

        $data['offlinesetting'] = Self::getsettings('offlinesetting');
        $data['payment_details'] = Self::getsettings('payment_details');

        $data['currency'] = Self::getsettings('currency');
        $data['currency_symbol'] = Self::getsettings('currency_symbol');
        return $data;
    }


    
    public function getplan()
    {

       return json_encode(Self::getsettings('plan_setting'));
       
       
    }



    public function getadminplansetting()
    {
        $data = [];
        $data['stripesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('stripesetting');
        });
        $data['stripe_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('stripe_key');
        });
        $data['stripe_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('stripe_secret');
        });
        $data['stripe_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('stripe_description');
        });

        $data['razorpaysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('razorpaysetting');
        });
        $data['razorpay_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('razorpay_key');
        });
        $data['razorpay_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('razorpay_secret');
        });
        $data['razorpay_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('razorpay_description');
        });

        $data['paypalsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paypalsetting');
        });
        $data['paypal_client_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paypal_client_id');
        });
        $data['paypal_client_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paypal_client_secret');
        });
        $data['paypal_mode'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paypal_mode');
        });
        $data['paypal_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paypal_description');
        });

        $data['flutterwavesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('flutterwavesetting');
        });
        $data['flutterwave_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('flutterwave_key');
        });
        $data['flutterwave_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('flutterwave_secret');
        });
        $data['flutterwave_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('flutterwave_description');
        });

        $data['paystacksetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paystacksetting');
        });
        $data['paystack_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paystack_public_key');
        });
        $data['paystack_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paystack_secret_key');
        });
        $data['paystack_currency'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paystack_currency');
        });
        $data['paystack_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paystack_description');
        });

        $data['paytmsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytmsetting');
        });
        $data['paytm_merchant_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytm_merchant_id');
        });
        $data['paytm_merchant_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytm_merchant_key');
        });
        $data['paytm_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytm_description');
        });

        $data['coingatesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('coingatesetting');
        });
        $data['coingate_environment'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('coingate_environment');
        });
        $data['coingate_auth_token'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('coingate_auth_token');
        });
        $data['coingate_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('coingate_description');
        });

        $data['mercadosetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mercadosetting');
        });
        $data['mercado_mode'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mercado_mode');
        });
        $data['mercado_access_token'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mercado_access_token');
        });
        $data['mercado_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mercado_description');
        });

        $data['payfastsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfastsetting');
        });
        $data['payfast_mode'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfast_mode');
        });
        $data['payfast_signature'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfast_signature');
        });
        $data['payfast_merchant_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfast_merchant_id');
        });
        $data['payfast_merchant_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfast_merchant_key');
        });
        $data['payfast_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payfast_description');
        });

        $data['toyyibpaysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('toyyibpaysetting');
        });
        $data['toyyibpay_secret_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('toyyibpay_secret_key');
        });
        $data['toyyibpay_category_code'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('toyyibpay_category_code');
        });
        $data['toyyibpay_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('toyyibpay_description');
        });

        $data['iyzipaysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('iyzipaysetting');
        });
        $data['iyzipay_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('iyzipay_key');
        });
        $data['iyzipay_secret'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('iyzipay_secret');
        });
        $data['iyzipay_mode'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('iyzipay_mode');
        });
        $data['iyzipay_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('iyzipay_description');
        });

        $data['sspaysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('sspaysetting');
        });
        $data['sspay_category_code'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('sspay_category_code');
        });
        $data['sspay_secret_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('sspay_secret_key');
        });
        $data['sspay_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('sspay_description');
        });

        $data['cashfreesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('cashfreesetting');
        });
        $data['cashfree_app_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('cashfree_app_id');
        });
        $data['cashfree_secret_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('cashfree_secret_key');
        });
        $data['cashfree_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('cashfree_description');
        });

        $data['aamarpaysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('aamarpaysetting');
        });
        $data['aamarpay_store_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('aamarpay_store_id');
        });
        $data['aamarpay_signature_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('aamarpay_signature_key');
        });
        $data['aamarpay_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('aamarpay_description');
        });

        $data['payumoneysetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payumoneysetting');
        });
        $data['payumoney_mode'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payumoney_mode');
        });
        $data['payumoney_merchant_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payumoney_merchant_key');
        });
        $data['payumoney_salt_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payumoney_salt_key');
        });
        $data['payumoney_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payumoney_description');
        });

        $data['paytabsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytabsetting');
        });
        $data['paytab_profile_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytab_profile_id');
        });
        $data['paytab_server_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytab_server_key');
        });
        $data['paytab_region'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytab_region');
        });
        $data['paytab_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('paytab_description');
        });

        $data['benefitsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('benefitsetting');
        });
        $data['benefit_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('benefit_key');
        });
        $data['benefit_secret_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('benefit_secret_key');
        });
        $data['benefit_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('benefit_description');
        });

        $data['molliesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('molliesetting');
        });
        $data['mollie_api_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mollie_api_key');
        });
        $data['mollie_profile_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mollie_profile_id');
        });
        $data['mollie_partner_id'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mollie_partner_id');
        });
        $data['mollie_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('mollie_description');
        });

        $data['skrillsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('skrillsetting');
        });
        $data['skrill_email'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('skrill_email');
        });
        $data['skrill_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('skrill_description');
        });

        $data['easebuzzsetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('easebuzzsetting');
        });
        $data['easebuzz_environment'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('easebuzz_environment');
        });
        $data['easebuzz_merchant_key'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('easebuzz_merchant_key');
        });
        $data['easebuzz_salt'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('easebuzz_salt');
        });
        $data['easebuzz_description'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('easebuzz_description');
        });

        $data['offlinesetting'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('offlinesetting');
        });
        $data['payment_details'] = tenancy()->central(function ($tenant) {
            return Self::getsettings('payment_details');
        });

        $data['currency_symbol'] = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('currency_symbol');
        });
        $data['currency'] = tenancy()->central(function ($tenant) {
            return UtilityFacades::getsettings('currency');
        });
        return $data;
    }

    public function getpaymenttypes()
    {
        $payment_type = [];
        if (Self::getsettings('stripesetting') == 'on') {
            $payment_type['stripe'] = 'Stripe';
        }
        if (Self::getsettings('razorpaysetting') == 'on') {
            $payment_type['razorpay'] = 'Razorpay';
        }
        if (Self::getsettings('paypalsetting') == 'on') {
            $payment_type['paypal'] = 'Paypal';
        }
        if (Self::getsettings('flutterwavesetting') == 'on') {
            $payment_type['flutterwave'] = 'Flutterwave';
        }
        if (Self::getsettings('paystacksetting') == 'on') {
            $payment_type['paystack'] = 'Paystack';
        }
        if (Self::getsettings('paytmsetting') == 'on') {
            $payment_type['paytm'] = 'Paytm';
        }
        if (Self::getsettings('coingatesetting') == 'on') {
            $payment_type['coingate'] = 'Coingate';
        }
        if (Self::getsettings('mercadosetting') == 'on') {
            $payment_type['mercado'] = 'Mercado Pago';
        }
        if (Self::getsettings('payfastsetting') == 'on') {
            $payment_type['payfast'] = 'PayFast';
        }
        if (Self::getsettings('toyyibpaysetting') == 'on') {
            $payment_type['toyyibpay'] = 'Toyyibpay';
        }
        if (Self::getsettings('iyzipaysetting') == 'on') {
            $payment_type['iyzipay'] = 'Iyzipay';
        }
        if (Self::getsettings('sspaysetting') == 'on') {
            $payment_type['sspay'] = 'sspay';
        }
        if (Self::getsettings('cashfreesetting') == 'on') {
            $payment_type['cashfree'] = 'cashfree';
        }
        if (Self::getsettings('aamarpaysetting') == 'on') {
            $payment_type['aamarpay'] = 'aamarpay';
        }
        if (Self::getsettings('payumoneysetting') == 'on') {
            $payment_type['payumoney'] = 'PayuMoney';
        }
        if (Self::getsettings('paytabsetting') == 'on') {
            $payment_type['paytab'] = 'Paytab';
        }
        if (Self::getsettings('benefitsetting') == 'on') {
            $payment_type['benefit'] = 'Benefit';
        }
        if (Self::getsettings('molliesetting') == 'on') {
            $payment_type['mollie'] = 'Mollie';
        }
        if (Self::getsettings('skrillsetting') == 'on') {
            $payment_type['skrill'] = 'Skrill';
        }
        if (Self::getsettings('easebuzzsetting') == 'on') {
            $payment_type['easebuzz'] = 'Easebuzz';
        }
        if (Self::getsettings('offlinesetting') == 'on') {
            $payment_type['offline'] = 'Offline';
        }
        return $payment_type;
    }

    public function amount_format($amount)
    {
        return Self::getsettings('currency_symbol') . ' ' . number_format($amount, 2);
    }

    public function calculateDiscount($price = "", $discount = "", $discount_type = "")
    {
        $discountedAmount = 0;
        if ($discount != "" && $price != "" && $discount_type != "") {
            if ($discount_type == "percentage") {
                $discountedAmount = ($price / 100) * $discount;
            }
            if ($discount_type == "flat") {
                $discountedAmount = $discount;
            }
        }
        return $discountedAmount;
    }

    // Cookie Device
    public function GetDeviceType($user_agent)
    {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if (preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {
            if (preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }

    // multi lang change cookie set
    public function getActiveLanguage()
    {
        $lang = Cookie::get('lang');
        if ($lang) {
            return $lang;
        } else {
            return Self::getValByName('default_language');
        }
    }

    // Get Cache Size
    public function CacheSize()
    {
        //start for cache clear
        $file_size = 0;
        foreach (\File::allFiles(base_path() . '/storage/framework') as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);
        return $file_size;
    }

    public function getChangedAttributes($model, array $changes): array
    {
        $changedAttributes = [];
        foreach ($changes as $key => $newValue) {
            $oldValue = $model->getOriginal($key);
            $changedAttributes[$key] = [
                'old' => $oldValue,
                'new' => $newValue,
            ];
        }
        return $changedAttributes;
    }
}
