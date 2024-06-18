<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ActivityLogController;
use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Admin\DocumentGenratorController;
use App\Http\Controllers\Admin\DocumentMenuController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\OfflineRequestController;
use App\Http\Controllers\Admin\PlanController;
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
    Route::get('redirect/{provider}', [SocialLoginController::class, 'redirect']);
    Route::get('callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

    Route::get('contactus', [LandingController::class, 'contactUs'])->name('contact.us');
    Route::get('all/faqs', [LandingController::class, 'faqs'])->name('faqs.pages');
    Route::get('terms-conditions', [LandingController::class, 'termsAndConditions'])->name('terms.and.conditions');
    Route::post('contact-mail', [LandingController::class, 'contactMail'])->name('contact.mail');

    //sms
    Route::get('sms/notice', [SmsController::class, 'smsNoticeIndex'])->name('smsindex.noticeverification');
    Route::post('sms/notice', [SmsController::class, 'smsNoticeVerify'])->name('sms.noticeverification');
    Route::get('sms/verify', [SmsController::class, 'smsIndex'])->name('smsindex.verification');
    Route::post('sms/verify', [SmsController::class, 'smsVerify'])->name('sms.verification');
    Route::post('sms/verifyresend', [SmsController::class, 'smsResend'])->name('sms.verification.resend');

    //Blogs pages
    Route::get('blog/{slug}', [PostsController::class, 'viewBlog'])->name('view.blog');
    Route::get('see/blogs', [PostsController::class, 'seeAllBlogs'])->name('see.all.blogs');

    Route::get('pages/{slug}', [LandingPageController::class, 'pageDescription'])->name('description.page');
  });

  Route::group(['middleware' => ['auth', 'Setting', 'xss', '2fa', 'verified', 'verified_phone', 'Upload']], function () {
    Route::impersonate();
   
    Route::resource('category', CategoryController::class);
    Route::post('category-status/{id}', [CategoryController::class, 'categoryStatus'])->name('category.status');


    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity.log.index');

    Route::resource('faqs', FaqController::class);
    Route::resource('blogs', PostsController::class)->except(['show']);
    Route::post('notification/status/{id}', [NotificationsSettingController::class, 'changeStatus'])->name('notification.status.change');
    Route::resource('support-ticket', SupportTicketController::class);
    Route::resource('email-template', EmailTemplateController::class);
    Route::resource('sms-template', SmsTemplateController::class);
    Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
    Route::post('support-ticket/{id}/conversion', [ConversionsController::class, 'store'])->name('conversion.store');
    Route::resource('pagesetting', PageSettingController::class);


    Route::resource('users', UserController::class);
    Route::get('user-emailverified/{id}', [UserController::class, 'userEmailVerified'])->name('user.email.verified');
    Route::get('user-phoneverified/{id}', [UserController::class, 'userPhoneVerified'])->name('user.phone.verified');
    Route::post('user-status/{id}', [UserController::class, 'userStatus'])->name('user.status');


    Route::resource('roles', RoleController::class);
    Route::post('role-permission/{id}', [RoleController::class, 'assignPermission'])->name('role.permission');


    Route::post('change/theme/mode', [HomeController::class, 'changeThemeMode'])->name('change.theme.mode');
  
    Route::post('chart', [HomeController::class, 'chart'])->name('get.chart.data');
    Route::post('read/notification', [HomeController::class, 'readNotification'])->name('admin.read.notification');
    Route::get('sales', [HomeController::class, 'sales'])->name('sales.index');





 
    
    Route::get('home',  Adm::class)->name('home');
    Route::get('planos', Planos::class)->name('planos');
    Route::get('campanha-nova', Campanha::class)->name('campanha-nova');
    Route::get('campanha-{id}', Campanha::class)->name('editar');
    Route::get('campanha', Campanha::class)->name('campanha');
    Route::get('sorteios', Sorteios::class)->name('sorteios');
    Route::get('usuarios', Usuarios::class)->name('usuarios');
    Route::get('usuarios-{id}', Usuarios::class)->name('usuarios.editar');
    Route::get('usuarios-novo', Usuarios::class)->name('usuarios.novo');
    Route::get('relatorio', Relatorio::class)->name('relatorio');
    Route::get('ranking', Ranking::class)->name('ranking');
    Route::get('settings', Settings::class)->name('settings');
    Route::get('pedidos', Pedidos::class)->name('pedidos');
    Route::get('pedidos-{id}', Pedidos::class)->name('pedidos.editar');
    Route::get('pedidos-novo', Pedidos::class)->name('pedidos.novo');
    Route::get('clientes', Clientes::class)->name('clientes');
    Route::get('clientes/{id}', Clientes::class)->name('clientes.editar');
    Route::get('clientes-novo', Clientes::class)->name('clientes.novo');
    Route::get('afiliados', Afiliados::class)->name('afiliados');
    Route::get('afiliados/{id}', Afiliados::class)->name('afiliados.editar');
    Route::get('afiliados/novo', Afiliados::class)->name('afiliados.novo');
    Route::get('afiliados/pagamentos', Afiliados::class)->name('pagamentos');
    Route::get('profile', Profile::class)->name('perfil');
    Route::get('pagamento/{code}', pagamento::class)->name('pagamento.index');
    Route::get('gateway', Gateway::class)->name('gateway');
    Route::get('config', Config::class)->name('config');
    Route::get('logs', Adm::class)->name('logs');
    Route::get('cotas', Adm::class)->name('cotas');



    
















    Route::get('apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
    Route::resource('coupon', CouponController::class);
    Route::post('coupon-status/{id}', [CouponController::class, 'couponStatus'])->name('coupon.status');
    Route::get('coupon/show', [CouponController::class, 'show'])->name('coupons.show');
    Route::get('coupon/csv/upload', [CouponController::class, 'uploadCsv'])->name('coupon.upload');
    Route::post('coupon/csv/upload/store', [CouponController::class, 'uploadCsvStore'])->name('coupon.upload.store');
    Route::get('coupon/mass/create', [CouponController::class, 'massCreate'])->name('coupon.mass.create');
    Route::post('coupon/mass/store', [CouponController::class, 'massCreateStore'])->name('coupon.mass.store');

 
    Route::resource('testimonial', TestimonialController::class);
    Route::post('testimonial-status/{id}', [TestimonialController::class, 'testimonialStatus'])->name('testimonial.status');

    Route::get('event', [EventController::class, 'index'])->name('event.index');
    Route::post('event/getdata', [EventController::class, 'getEventData'])->name('event.get.data');
    Route::get('event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('event/store', [EventController::class, 'store'])->name('event.store');
    Route::get('event/edit/{event}', [EventController::class, 'edit'])->name('event.edit');
    Route::any('event/update/{event}', [EventController::class, 'update'])->name('event.update');
    Route::DELETE('event/delete/{event}', [EventController::class, 'destroy'])->name('event.destroy');


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

    // profile
   // Route::delete('/profile-destroy/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
    //Route::get('profile-status', [ProfileController::class, 'profileStatus'])->name('profile.status');
    //Route::post('update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    //Route::post('profile/basicinfo/update/', [ProfileController::class, 'BasicInfoUpdate'])->name('profile.update.basicinfo');
    //Route::post('update-login-details', [ProfileController::class, 'LoginDetails'])->name('update.login.details');

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

    //froentend
    Route::group(['prefix' => 'landingpage-setting'], function () {
      Route::get('app-setting', [LandingPageController::class, 'landingPageSetting'])->name('landingpage.setting');
      Route::post('app-setting/store', [LandingPageController::class, 'appSettingStore'])->name('landing.app.store');

      // menu
      Route::get('menu-setting', [LandingPageController::class, 'menuSetting'])->name('menusetting.index');
      Route::post('menu-setting-section1/store', [LandingPageController::class, 'menuSettingSection1Store'])->name('landing.menusection1.store');
      Route::post('menu-setting-section2/store', [LandingPageController::class, 'menuSettingSection2Store'])->name('landing.menusection2.store');
      Route::post('menu-setting-section3/store', [LandingPageController::class, 'menuSettingSection3Store'])->name('landing.menusection3.store');

      // feature
      Route::get('feature-setting', [LandingPageController::class, 'featureSetting'])->name('landing.feature.index');
      Route::post('feature-setting/store', [LandingPageController::class, 'featureSettingStore'])->name('landing.feature.store');
      Route::get('feature/create', [LandingPageController::class, 'featureCreate'])->name('feature.create');
      Route::post('feature/store', [LandingPageController::class, 'featureStore'])->name('feature.store');
      Route::get('feature/edit/{key}', [LandingPageController::class, 'featureEdit'])->name('feature.edit');
      Route::post('feature/update/{key}', [LandingPageController::class, 'featureUpdate'])->name('feature.update');
      Route::get('feature/delete/{key}', [LandingPageController::class, 'featureDelete'])->name('feature.delete');

      // business growth
      Route::get('business-growth-setting', [LandingPageController::class, 'businessGrowthSetting'])->name('landing.business.growth.index');
      Route::post('business-growth-setting/store', [LandingPageController::class, 'businessGrowthSettingStore'])->name('landing.business.growth.store');

      Route::get('business-growth/create', [LandingPageController::class, 'businessGrowthCreate'])->name('business.growth.create');
      Route::post('business-growth/store', [LandingPageController::class, 'businessGrowthStore'])->name('business.growth.store');
      Route::get('business-growth/edit/{key}', [LandingPageController::class, 'businessGrowthEdit'])->name('business.growth.edit');
      Route::post('business-growth/update/{key}', [LandingPageController::class, 'businessGrowthUpdate'])->name('business.growth.update');
      Route::get('business-growth/delete/{key}', [LandingPageController::class, 'businessGrowthDelete'])->name('business.growth.delete');

      Route::get('business-growth-view/create', [LandingPageController::class, 'businessGrowthViewCreate'])->name('business.growth.view.create');
      Route::post('business-growth-view/store', [LandingPageController::class, 'businessGrowthViewStore'])->name('business.growth.view.store');
      Route::get('business-growth-view/edit/{key}', [LandingPageController::class, 'businessGrowthViewEdit'])->name('business.growth.view.edit');
      Route::post('business-growth-view/update/{key}', [LandingPageController::class, 'businessGrowthViewUpdate'])->name('business.growth.view.update');
      Route::get('business-growth-view/delete/{key}', [LandingPageController::class, 'businessGrowthViewDelete'])->name('business.growth.view.delete');

      //Footer
      Route::get('footer-setting', [LandingPageController::class, 'footerSetting'])->name('landing.footer.index');
      Route::post('footer-setting/store', [LandingPageController::class, 'footerSettingStore'])->name('landing.footer.store');

      Route::get('main/menu/create', [LandingPageController::class, 'footerMainMenuCreate'])->name('footer.main.menu.create');
      Route::post('main/menu/store', [LandingPageController::class, 'footerMainMenuStore'])->name('footer.main.menu.store');
      Route::get('main/menu/edit/{id}', [LandingPageController::class, 'footerMainMenuEdit'])->name('footer.main.menu.edit');
      Route::post('main/menu/update/{id}', [LandingPageController::class, 'footerMainMenuUpdate'])->name('footer.main.menu.update');
      Route::get('main/menu/delete/{id}', [LandingPageController::class, 'footerMainMenuDelete'])->name('footer.main.menu.delete');

      Route::get('sub/menu/create', [LandingPageController::class, 'footerSubMenuCreate'])->name('footer.sub.menu.create');
      Route::post('sub/menu/store', [LandingPageController::class, 'footerSubMenuStore'])->name('footer.sub.menu.store');
      Route::get('sub/menu/edit/{id}', [LandingPageController::class, 'footerSubMenuEdit'])->name('footer.sub.menu.edit');
      Route::post('sub/menu/update/{id}', [LandingPageController::class, 'footerSubMenuUpdate'])->name('footer.sub.menu.update');
      Route::get('sub/menu/delete/{id}', [LandingPageController::class, 'footerSubMenuDelete'])->name('footer.sub.menu.delete');

      //Header
      Route::get('header-setting', [LandingPageController::class, 'headerSetting'])->name('landing.header.index');

      Route::get('headersub/menu/create', [LandingPageController::class, 'headerSubMenuCreate'])->name('header.sub.menu.create');
      Route::post('headersub/menu/store', [LandingPageController::class, 'headerSubMenuStore'])->name('header.sub.menu.store');
      Route::get('headersub/menu/edit/{id}', [LandingPageController::class, 'headerSubMenuEdit'])->name('header.sub.menu.edit');
      Route::post('headersub/menu/update/{id}', [LandingPageController::class, 'headerSubMenuUpdate'])->name('header.sub.menu.update');
      Route::get('headersub/menu/delete/{id}', [LandingPageController::class, 'headerSubMenuDelete'])->name('header.sub.menu.delete');

      Route::get('start-view-setting', [LandingPageController::class, 'startViewSetting'])->name('landing.start.view.index');
      Route::post('start-view-setting/store', [LandingPageController::class, 'startViewSettingStore'])->name('landing.start.view.store');

      Route::get('faq-setting', [LandingPageController::class, 'faqSetting'])->name('landing.faq.index');
      Route::post('faq-setting/store', [LandingPageController::class, 'faqSettingStore'])->name('landing.faq.store');

      Route::get('contactus-setting', [LandingPageController::class, 'contactusSetting'])->name('landing.contactus.index');
      Route::post('contactus-setting/store', [LandingPageController::class, 'contactusSettingStore'])->name('landing.contactus.store');

      Route::get('login-setting', [LandingPageController::class, 'loginSetting'])->name('landing.login.index');
      Route::post('login-setting/store', [LandingPageController::class, 'loginSettingStore'])->name('landing.login.store');

      Route::get('recaptcha-setting', [LandingPageController::class, 'recaptchaSetting'])->name('landing.recaptcha.index');
      Route::post('recaptcha-setting/store', [LandingPageController::class, 'recaptchaSettingStore'])->name('landing.recaptcha.store');

      Route::get('blog-setting', [LandingPageController::class, 'blogSetting'])->name('landing.blog.index');
      Route::post('blog-setting/store', [LandingPageController::class, 'blogSettingStore'])->name('landing.blog.store');

      Route::get('testimonial-setting', [LandingPageController::class, 'testimonialSetting'])->name('landing.testimonial.index');
      Route::post('testimonial-setting/store', [LandingPageController::class, 'testimonialSettingStore'])->name('landing.testimonial.store');

      Route::get('page-background-setting', [LandingPageController::class, 'pageBackground'])->name('landing.page.background.index');
      Route::post('page-background-setting/store', [LandingPageController::class, 'pageBackgroundStore'])->name('landing.page.background.tore');
    });

    //document
    Route::resource('document', DocumentGenratorController::class);
    Route::get('document/design/{id}', [DocumentGenratorController::class, 'design'])->name('document.design');
    Route::post('document/design-menu/{id}', [DocumentGenratorController::class, 'documentDesignMenu'])->name('document.design.menu');

    //status drag-drop
    Route::post('document/designmenu', [DocumentGenratorController::class, 'updateDesign'])->name('updatedesign.document');
    Route::get('document-status/{id}', [DocumentGenratorController::class, 'documentStatus'])->name('document.status');

    // menu
    Route::get('docmenu/create/{docmenuId}', [DocumentMenuController::class, 'create'])->name('docmenu.create');
    Route::post('docmenu/store', [DocumentMenuController::class, 'store'])->name('docmenu.store');
    Route::delete('document/menu/{id}', [DocumentMenuController::class, 'destroy'])->name('document.designdelete');

    // submenu
    Route::get('docsubmenu/create/{id}/{docMenuId}', [DocumentMenuController::class, 'subMenuCreate'])->name('docsubmenu.create');
    Route::post('docsubmenu/store', [DocumentMenuController::class, 'subMenuStore'])->name('docsubmenu.store');
    Route::get('document/submenu/{id}', [DocumentMenuController::class, 'subMenuDestroy'])->name('document.submenu.designdelete');

    //stripe
    Route::get('stripe', [StripeController::class, 'stripe'])->name('stripe.pay');
    Route::post('stripe/pending', [StripeController::class, 'stripePostPending'])->name('stripe.pending');
    Route::post('stripe/session', [StripeController::class, 'stripeSession'])->name('stripe.session');
    Route::get('payment-success/{id}', [StripeController::class, 'paymentSuccess'])->name('stripe.success.pay');
    Route::get('payment-cancel/{id}', [StripeController::class, 'paymentCancel'])->name('stripe.cancel.pay');

    //razorpay
    Route::post('razorpay/payment', [RazorpayController::class, 'razorpayPayment'])->name('payrazorpay.payment');
    Route::get('razorpay/transaction/callback/{transactionId}/{couponId}/{plansId}', [RazorpayController::class, 'RazorpayCallback']);

    //flutterwave
    Route::post('flutterwave/payment', [FlutterwaveController::class, 'flutterwavePayment'])->name('pay.flutterwave.payment');
    Route::get('flutterwave/transaction/callback/{transactionId}/{couponId}/{plansId}', [FlutterwaveController::class, 'FlutterwaveCallback']);

    //paystack
    Route::post('paystack/payment', [PaystackController::class, 'paystackPayment'])->name('paypaystack.payment');
    Route::get('paystack/transaction/callback/{transactionId}/{couponId}/{plansId}', [PaystackController::class, 'paystackCallback']);

    //coingate
    Route::post('coingate/prepare', [CoingateController::class, 'coingatePrepare'])->name('coingate.payment.prepare');
    Route::get('coingate-success/{id}', [CoingateController::class, 'coingateCallback'])->name('coingate.payment.callback');


    Route::post('mercado/prepare', [MercadoController::class, 'mercadoPrepare'])->name('mercado.payment.prepare');


    Route::any('mercado-payment-callback/{id}', [MercadoController::class, 'mercadoCallback'])->name('mercado.payment.callback');

    Route::any('mercadopago-notification', [MercadoController::class, 'mercadoPagoNotification'])->name('mercado.notification');

    Route::any('mercadopago-success', [MercadoController::class, 'mercadoPagoSuccess'])->name('mercado.success');


       Route::any('mercadopago-error', [MercadoController::class, 'mercadoPagoError'])->name('mercado.error');


    

    //payfast
    Route::post('payfast/prepare', [PayfastController::class, 'payfastPrepare'])->name('payfast.payment.prepare');
    Route::get('payfast/callback/{id}', [PayfastController::class, 'payfastCallback'])->name('payfast.payment.callback');

    //Toyyibpay
    Route::post('toyyibpay/prepare', [ToyyibpayController::class, 'charge'])->name('toyyibpay.payment.charge');
    Route::get('toyyibpay/callback/{planid}/{orderid}/{coupon}', [ToyyibpayController::class, 'toyyibpayCallback'])->name('toyyibpay.payment.callback');

    //Iyzipay
    Route::post('iyzipay/prepare', [IyziPayController::class, 'initiatePayment'])->name('iyzipay.payment.init');
    Route::post('iyzipay/callback', [IyzipayController::class, 'iyzipayCallback'])->name('iyzipay.payment.callback');

    // paytab
    Route::post('plan-pay-with-paytab', [PaytabController::class, 'planPayWithPaytab'])->name('plan.pay.with.paytab');
    Route::any('paytab-success/plan', [PaytabController::class, 'paytabGetPayment'])->name('plan.paytab.success');

    // Mollie
    Route::post('plan-pay-with-mollie', [MolliePaymentController::class, 'planPayWithMollie'])->name('plan.pay.with.mollie');
    Route::get('plan/mollie/{plan}', [MolliePaymentController::class, 'getPaymentStatus'])->name('plan.mollie');
  });


  Route::post('paypayment', [PaytmController::class, 'pay'])->name('paypaytm.payment');
  Route::post('paypayment/callback', [PaytmController::class, 'paymentCallback'])->name('paypaytm.callback');

  Route::post('class/{action?}', [ClassController::class, 'index'])->name('index');
  Route::get('class/{action?}', [ClassController::class, 'index'])->name('indexs');

  Route::post('customer/{action?}', [ClassController::class, 'customer'])->name('customer');
  Route::post('system/{action?}', [ClassController::class, 'system'])->name('system');

  Route::any('payumoney/payment', [PayuMoneyController::class, 'PayUmoneyPayment'])->name('payumoney.payment.init');
  Route::any('payumoney/success/{id}', [PayUMoneyController::class, 'payuSuccess'])->name('payu.success');
  Route::any('payumoney/failure/{id}', [PayUMoneyController::class, 'payuFailure'])->name('payu.failure');

  //sspay
  Route::post('sspay/payment', [SSPayController::class, 'initPayment'])->name('sspay.payment.init');
  Route::get('sspay/transaction/callback', [SSPayController::class, 'sspayCallback'])->name('sspay.payment.callback');

  //cashfree
  Route::post('cashfree/payment', [CashFreeController::class, 'cashfreePayment'])->name('cashfree.payment.prepare');
  Route::get('cashfree/transaction/callback', [CashFreeController::class, 'cashfreeCallback'])->name('cashfree.payment.callback');

  // Aamarpay
  Route::post('aamarpay/payment', [AamarpayController::class, 'planPayWithAamarpay'])->name('plan.pay.with.aamarpay');
  Route::any('aamarpay/success/{data}', [AamarpayController::class, 'getPaymentAamarpayStatus'])->name('plan.aamarpay');

  // cookie
  Route::get('cookie/consent', [SettingsController::class, 'CookieConsent'])->name('cookie.consent');

  // Benefit
  Route::any('payment/initiate', [BenefitPaymentController::class, 'initiatePayment'])->name('benefit.initiate');
  Route::any('call/back', [BenefitPaymentController::class, 'callBack'])->name('benefit.callback');

  // Skrill
  Route::any('plan-pay-with-skrill', [SkrillPaymentController::class, 'planPayWithSkrill'])->name('plan.pay.with.skrill');
  Route::get('plan/skrill/{data}', [SkrillPaymentController::class, 'getPayWithSkrillCallback'])->name('plan.skrill');

  //Easebuzz
  Route::post('plan-easebuzz', [EasebuzzPaymentController::class, 'planPayWithEasebuzz'])->name('plan.pay.with.easebuzz');
  Route::any('plan/easebuzz/{id}', [EasebuzzPaymentController::class, 'planWithEasebuzzCallback'])->name('plan.easebuzz.callback');

  //paypal
  Route::post('process-transaction', [PaypalController::class, 'processTransaction'])->name('pay.process.transaction');
  Route::get('success-transaction/{data}', [PaypalController::class, 'successTransaction'])->name('pay.success.transaction');
  Route::get('cancel-transaction/{data}', [PaypalController::class, 'cancelTransaction'])->name('pay.cancel.transaction');
  Route::post('process-transactionadmin', [PaypalController::class, 'processTransactionAdmin'])->name('pay.process.transaction.admin');

  // cache
  Route::any('config-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', __('Cache Clear Successfully'));
  })->name('config.cache');

  // public document
  Route::get('document/public/{slug}', [DocumentGenratorController::class, 'documentPublic'])->name('document.public')->middleware(['xss', 'Upload']);
  Route::get('documents/{slug}/{changeLog?}', [DocumentGenratorController::class, 'documentPublicMenu'])->name('document.menu.menu')->middleware(['xss', 'Upload']);
  Route::get('document/{slug}/{slugmenu}', [DocumentGenratorController::class, 'documentPublicSubmenu'])->name('document.sub.menu')->middleware(['xss', 'Upload']);
  

 
  
  Route::get('/campanhas/{slug}',Home::class)->name('campanhas.slug');
  Route::get('/',Home::class)->name('inicio');
  Route::get('/campanhas',Home::class)->name('campanhas');
  Route::get('/concluidas',Home::class)->name('concluidas');
  Route::get('/em-breve',Home::class)->name('em-breve');
  Route::get('/user/compras',Home::class)->name('compras');
  Route::get('/user/alterar-senha',Home::class)->name('alterar-senha');
  Route::get('/user/atualizar-cadastro',Home::class)->name('atualizar-cadastro');
  Route::get('/user/afiliado',Home::class)->name('afiliado');
  Route::get('/cadastrar',Home::class)->name('cadastrar');
  Route::get('/meus-numeros',Home::class)->name('meus-numeros');
  Route::get('/ganhadores',Home::class)->name('ganhadores');
  Route::get('/contato',Home::class)->name('contato');
  Route::get('/termos-de-uso',Home::class)->name('termos-de-uso');
  Route::get('/recuperar-senha',Home::class)->name('recuperar-senha');
  Route::get('/compra/{slug}',Home::class)->name('compr');
 Route::get('changeLang/{lang?}', [LandingController::class, 'changeLang'])->name('change.lang');
});
