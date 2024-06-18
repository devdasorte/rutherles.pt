
<?php
use App\Facades\UtilityFacades;
use Illuminate\Support\Facades\Auth;


$tenant = tenant('domains');
if (!isset($tenant)) {
    redirect(config('tenancy.central_domains'));

}

$DB_NAME = tenant('tenancy_db_name');
$DB_PASSWORD = tenant('tenancy_db_password');
$DB_USERNAME = tenant('tenancy_db_username');
$currentDomain = tenant('domains');


   if (isset($tenant)) {
            $currentDomain = $currentDomain->pluck('domain')->toArray()[0];
        }
        
        
        if (isset($currentDomain)) {
    if (strstr($currentDomain, '.')) {
        $currentdomain = 'https://'.$currentDomain.'/';
    } else {
        $currentdomain = 'https://'.$currentDomain.'.rutherles.pt/';
    }
} 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);
if (!defined('BASE_URL')) define('BASE_URL', $currentdomain);
if (!defined('BASE_DOMAIN')) define('BASE_DOMAIN', $currentdomain);
if (!defined('base_url')) define('base_url', $currentdomain);
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');

if (!defined('BASE_APP')) define('BASE_APP', str_replace('\\', '/', __DIR__) . '/');
if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', $DB_USERNAME);
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', $DB_PASSWORD);
if (!defined('DB_NAME')) define('DB_NAME', $DB_NAME);
?>