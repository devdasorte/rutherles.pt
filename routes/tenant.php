<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ActivityLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SystemAnalyticsController;
use App\Http\Controllers\Admin\AnnouncementController;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConversionsController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\LoginSecurityController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocialLoginController;
use App\Http\Controllers\Admin\LandingController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\SmsTemplateController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\NotificationsSettingController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\DocumentGenratorController;
use App\Http\Controllers\Admin\DocumentMenuController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\OfflineRequestController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PlanoController;

use App\Http\Controllers\Admin\PlanRifaController;

use App\Http\Controllers\Admin\Payment\ToyyibpayController;
use App\Http\Controllers\Admin\Payment\SSPayController;
use App\Http\Controllers\Admin\Payment\SkrillPaymentController;
use App\Http\Controllers\Admin\Payment\PayuMoneyController;
use App\Http\Controllers\Admin\Payment\PaytmController;
use App\Http\Controllers\Admin\Payment\PaytabController;
use App\Http\Controllers\Admin\Payment\PaystackController;
use App\Http\Controllers\Admin\Payment\PaypalController;
use App\Http\Controllers\Admin\Payment\PayfastController;
use App\Http\Controllers\Admin\Payment\MolliePaymentController;
use App\Http\Controllers\Admin\Payment\MercadoController;
use App\Http\Controllers\Admin\Payment\IyziPayController;
use App\Http\Controllers\Admin\Payment\FlutterwaveController;
use App\Http\Controllers\Admin\Payment\EasebuzzPaymentController;
use App\Http\Controllers\Admin\Payment\CoingateController;
use App\Http\Controllers\Admin\Payment\CashFreeController;
use App\Http\Controllers\Admin\Payment\RazorpayController;
use App\Http\Controllers\Admin\Payment\StripeController;
use App\Http\Controllers\Admin\Payment\AamarpayController;
use App\Http\Controllers\Admin\Payment\BenefitPaymentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ClassController;
use App\Livewire\Home;
use App\Livewire\Adm;
use App\Livewire\Painel;
use App\Livewire\Planos;
use App\Livewire\Campanha;
use App\Livewire\Campanhas;

use App\Livewire\Sorteios;
use App\Livewire\Usuarios;
use App\Livewire\Relatorio;

use App\Livewire\Settings;
use App\Livewire\Pedidos;
use App\Livewire\Clientes;
use App\Livewire\Afiliados;
use App\Livewire\Profile;
use App\Livewire\Pagamento;
use App\Livewire\Gateway;
use App\Livewire\Config;
use App\Livewire\Logs;
use App\Livewire\Cotas;
use App\Livewire\Compras;
use App\Livewire\Cadastro;
use App\Livewire\Webhook;


Route::middleware([
  'web',
  InitializeTenancyByDomainOrSubdomain::class,
  PreventAccessFromCentralDomains::class,
])->group(function () {
  require __DIR__ . '/auth.php';
  Route::get('/tenant-impersonate/{token}', function ($token) {
    return UserImpersonation::makeResponse($token);
  });
  Route::group(['middleware' => ['auth', 'Setting', '2fa', 'Upload']], function () {
    Route::get('show-announcement-list/', [AnnouncementController::class, 'showAnnouncementList'])->name('show.announcement.list');
    Route::get('show-announcement/{id}', [AnnouncementController::class, 'showAnnouncement'])->name('show.announcement');

    Route::post('check', [AuthenticatedSessionController::class, 'check']);
  });
  Route::group(['middleware' => ['Setting', 'xss', 'Upload']], function () {

  });

  Route::group(['middleware' => ['auth', 'Setting', 'xss', '2fa', 'verified', 'verified_phone', 'Upload']], function () {
    Route::impersonate();

    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity.log.index');




    Route::resource('roles', RoleController::class);
    Route::post('role-permission/{id}', [RoleController::class, 'assignPermission'])->name('role.permission');


    Route::post('change/theme/mode', [HomeController::class, 'changeThemeMode'])->name('change.theme.mode');
  
    Route::post('chart', [HomeController::class, 'chart'])->name('get.chart.data');
    Route::post('read/notification', [HomeController::class, 'readNotification'])->name('admin.read.notification');
    Route::get('sales', [HomeController::class, 'sales'])->name('sales.index');
 
    
 


    Route::get('home', Adm::class)->name('home');
    Route::get('campanha',Adm::class)->name('campanha');





    Route::get('planos', Adm::class)->name('planos');
    Route::get('pagamento', Planos::class)->name('pagamento');


    Route::get('pulse/{option?}', [SystemAnalyticsController::class, 'pulse'])->name('pulse');


    Route::get('campanha-nova', Adm::class)->name('campanha-nova');
    Route::get('campanha-{id}', Adm::class)->name('editar');
    Route::get('campanha', Adm::class)->name('campanha');
  
    Route::get('sorteios', Adm::class)->name('sorteios');
  
    Route::get('usuarios', Adm::class)->name('usuarios');
    Route::get('usuarios-{id}', Adm::class)->name('usuarios.editar');
    Route::get('usuarios-novo', Adm::class)->name('usuarios.novo');
         
    Route::get('relatorio', Adm::class)->name('relatorio');
       
    Route::get('ranking', Adm::class)->name('ranking');
    Route::get('settings', Adm::class)->name('settings');
    Route::get('pedidos', Adm::class)->name('pedidos');
    Route::get('pedidos-{id}', Adm::class)->name('pedidos.editar');
    Route::get('pedidos-novo', Adm::class)->name('pedidos.novo');
     
    Route::get('clientes', Adm::class)->name('clientes');
    Route::get('clientes/{id}', Adm::class)->name('clientes.editar');
    Route::get('clientes-novo', Adm::class)->name('clientes.novo');
      
    Route::get('afiliados', Adm::class)->name('afiliados');
    Route::get('afiliados/{id}', Adm::class)->name('afiliados.editar');
    Route::get('afiliados/novo', Adm::class)->name('afiliados.novo');
    Route::get('afiliados/pagamento', Adm::class)->name('pagamentos');
    Route::get('profile', Adm::class)->name('perfil');


        
    Route::get('gateway', Adm::class)->name('gateway');
    Route::get('config', Adm::class)->name('config');
    Route::get('logs', Adm::class)->name('logs');
          
    Route::get('cotas', Adm::class)->name('cotas');

  


    Route::resource('plans', PlanController::class);
    Route::get('plano',  [PlanRifaController::class, 'index'])->name('index');
    Route::get('myplans', [PlanController::class, 'myPlan'])->name('plans.myplan');
    Route::get('myplans-create', [PlanController::class, 'createMyPlan'])->name('plans.createmyplan');
    Route::get('myplans/{id}/edit', [PlanController::class, 'editMyplan'])->name('requestdomain.editplan');
    Route::post('myplan-status/{id}', [PlanController::class, 'planStatus'])->name('myplan.status');
    Route::get('payment/{code}', [PlanController::class, 'payment'])->name('payment');

    Route::resource('offline', OfflineRequestController::class);
    Route::get('offline-request/{id}', [OfflineRequestController::class, 'offlineRequestStatus'])->name('offline.request.status');
    Route::get('offline-request/disapprove/{id}', [OfflineRequestController::class, 'disApproveStatus'])->name('offline.disapprove.status');
    Route::post('offline-request/disapprove-update/{id}', [OfflineRequestController::class, 'offlineDisApprove'])->name('request.user.disapprove.update');
    Route::post('offline-payment', [OfflineRequestController::class, 'offlinePaymentEntry'])->name('offline.payment.request');


  });


    Route::group(['prefix' => '2fa'], function () {
      Route::get('/', [LoginSecurityController::class, 'show2faForm']);
      Route::post('generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
      Route::post('enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
      Route::post('disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');
      Route::post('2faVerify', function () {
        return redirect(route('home'));
        // return redirect(URL()->previous());
      })->name('2faVerify');
    });



    Route::delete('/profile-destroy/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
    Route::get('profile-status', [ProfileController::class, 'profileStatus'])->name('profile.status');
    Route::post('update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    Route::post('profile/basicinfo/update/', [ProfileController::class, 'BasicInfoUpdate'])->name('profile.update.basicinfo');
    Route::post('update-login-details', [ProfileController::class, 'LoginDetails'])->name('update.login.details');

    //setting
    //Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings/app-name/update', [SettingsController::class, 'appNameUpdate'])->name('settings.appname.update');
    Route::post('settings/pusher-setting/update', [SettingsController::class, 'pusherSettingUpdate'])->name('settings.pusher.setting.update');
    Route::post('settings/s3-setting/update', [SettingsController::class, 's3SettingUpdate'])->name('settings.s3.setting.update');
    Route::post('settings/email-setting/update', [SettingsController::class, 'emailSettingUpdate'])->name('settings.email.setting.update');
    Route::post('settings/sms-setting/update', [SettingsController::class, 'smsSettingUpdate'])->name('settings.sms.setting.update');
    Route::post('settings/payment-setting/update', [SettingsController::class, 'Update'])->name('settings.payment.setting.update');
    Route::post('settings/social-setting/update', [SettingsController::class, 'socialSettingUpdate'])->name('settings.social.setting.update');
    Route::post('settings/google-calender/update', [SettingsController::class, 'GoogleCalenderUpdate'])->name('settings.google.calender.update');
    Route::post('settings/auth-settings/update', [SettingsController::class, 'authSettingsUpdate'])->name('settings.auth.settings.update');
    Route::post('settings/cadastro-settings/update', [SettingsController::class, 'cadastroSettingsUpdate'])->name('cadastro.settings.update');
    Route::post('settings/footer-settings/update', [SettingsController::class, 'footerSettingsUpdate'])->name('footer.settings.update');

    Route::post('test-mail', [SettingsController::class, 'testSendMail'])->name('test.send.mail');
    Route::post('ckeditor/upload', [SettingsController::class, 'upload'])->name('ckeditor.upload');
    Route::post('settings/change-domain', [SettingsController::class, 'changeDomainRequest'])->name('settings.change.domain');
    Route::get('test-mail', [SettingsController::class, 'testMail'])->name('test.mail');
    Route::post('settings/cookie-setting/update', [SettingsController::class, 'cookieSettingUpdate'])->name('settings.cookie.setting.update');
    Route::post('setting/seo/save', [SettingsController::class, 'SeoSetting'])->name('setting.seo.save');



    Route::group(['prefix' => 'landingpage-setting'], function () {
      
  


   
    Route::any('mercado-payment-callback/{id}', [MercadoController::class, 'mercadoCallback'])->name('mercado.payment.callback');

    Route::any('mercadopago-notification', [MercadoController::class, 'mercadoPagoNotification'])->name('mercado.notification');

    Route::any('mercadopago-success', [MercadoController::class, 'mercadoPagoSuccess'])->name('mercado.success');


       Route::any('mercadopago-error', [MercadoController::class, 'mercadoPagoError'])->name('mercado.error');


    
  });


  Route::post('paypayment', [PaytmController::class, 'pay'])->name('paypaytm.payment');
  Route::post('paypayment/callback', [PaytmController::class, 'paymentCallback'])->name('paypaytm.callback');



  Route::post('mercado/prepare', [MercadoController::class, 'mercadoPrepare'])->name('mercado.payment.prepare');
  Route::post('mp', [PlanoController::class, 'receive_notify'])->name('check.mp');
  Route::get('mp', [PlanoController::class, 'receive_notify'])->name('check.mp');




  // cookie
  Route::get('cookie/consent', [SettingsController::class, 'CookieConsent'])->name('cookie.consent');



  Route::post('class/{action?}', [ClassController::class, 'index'])->name('index');
  Route::get('class/{action?}', [ClassController::class, 'index'])->name('indexs');
  Route::post('auth/{action?}', [ClassController::class, 'auth'])->name('auth_customer');
  Route::post('auth/{action?}', [ClassController::class, 'auth'])->name('auth_system');
  Route::get('auth/{action?}', [ClassController::class, 'auth'])->name('auth_customer');
  Route::post('customer/{action?}', [ClassController::class, 'customer'])->name('customer');
  Route::post('system/{action?}', [ClassController::class, 'system'])->name('system');

  Route::get('/',Home::class)->name('inicio');

  Route::get('/campanhas/{slug}',Campanhas::class)->name('campanhas.slug');
  Route::get('/campanhas',Campanhas::class)->name('campanhas');
  Route::get('/ganhadores',Campanhas::class)->name('ganhadores');

  Route::get('/notifications', [NotificationsController::class , 'mercadopago'])->name('mercadopago.notifications');


  Route::get('/user/alterar-senha',Cadastro::class)->name('alterar-senha');
  Route::get('/user/atualizar-cadastro',Cadastro::class)->name('atualizar-cadastro');
  Route::get('/user/afiliado',Cadastro::class)->name('afiliado');
  Route::get('/cadastrar',Cadastro::class)->name('cadastrar');
  Route::get('/contato',Cadastro::class)->name('contato');
  Route::get('/termos-de-uso',Cadastro::class)->name('termos-de-uso');
  Route::get('/recuperar-senha',Cadastro::class)->name('recuperar-senha');
  Route::get('/user/alterar-senha',Cadastro::class)->name('alterar-senha');
  Route::get('/user/atualizar-cadastro',Cadastro::class)->name('atualizar-cadastro');
  Route::get('/user/afiliado',Cadastro::class)->name('afiliado');


  Route::get('/compra/{slug}',Compras::class)->name('ver-compra');
  Route::get('/meus-numeros',Compras::class)->name('meus-numeros');
  Route::get('/user/compras',Compras::class)->name('compras');



  















  Route::post('/pagamento', [PlanoController::class, 'index'])->name('planos-compra');
  Route::post('pagamento/sucesso', [PlanoController::class, 'Update_user'])->name('planos-suc');
  Route::post('check-status', [PlanoController::class, 'checkStatus'])->name('check.status');
  Route::post('/pref', [PlanoController::class, 'preferencia'])->name('preferencia');


  Route::any('config-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', __('Cache Clear Successfully.'));
})->name('config.cache');

 Route::get('changeLang/{lang?}', [LandingController::class, 'changeLang'])->name('change.lang');


});


