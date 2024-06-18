<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FooterSetting;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\NotificationsSetting;
use App\Models\PageSetting;
use App\Models\Plan;
use App\Models\System_info;
use App\Models\Setting;
use App\Models\SmsTemplate;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\MailTemplates\Models\MailTemplate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
class TenantDatabaseSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('cache:clear');
        $allpermissions  = [
            'role'                  => ['manage', 'create', 'edit', 'delete', 'show'],
            'user'                  => ['manage', 'create', 'edit', 'delete', 'impersonate'],
            'setting'               => ['manage'],
            'transaction'           => ['manage'],
            'landingpage'           => ['manage'],
            'chat'                  => ['manage'],
            'plan'                  => ['manage', 'create', 'edit', 'delete'],
            'blog'                  => ['manage', 'create', 'edit', 'delete'],
            'category'              => ['manage', 'create', 'edit', 'delete'],
            'email-template'        => ['manage', 'edit'],
            'sms-template'          => ['manage', 'edit'],
            'testimonial'           => ['manage', 'create', 'edit', 'delete'],
            'event'                 => ['manage', 'create', 'edit', 'delete'],
            'faqs'                  => ['manage', 'create', 'edit', 'delete'],
            'coupon'                => ['manage', 'create', 'edit', 'delete', 'show', 'mass-create', 'upload'],
            'document'              => ['manage', 'create', 'edit', 'delete'],
            'page-setting'          => ['manage', 'create', 'edit', 'delete'],
            'support-ticket'        => ['manage', 'create', 'edit', 'delete'],
            'announcement'          => ['manage', 'create', 'edit', 'delete'],
            'activity-log'          => ['manage'],
        ];

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        foreach ($allpermissions as $module => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission . '-' . $module]);
            }
        }

        $adminpermissions  = [
            'role'                  => ['manage', 'create', 'edit', 'delete', 'show'],
            'user'                  => ['manage', 'create', 'edit', 'delete', 'impersonate'],
            'setting'               => ['manage'],
            'transaction'           => ['manage'],
            'landingpage'           => ['manage'],
            'chat'                  => ['manage'],
            'plan'                  => ['manage', 'create', 'edit', 'delete'],
            'blog'                  => ['manage', 'create', 'edit', 'delete'],
            'category'              => ['manage', 'create', 'edit', 'delete'],
            'email-template'        => ['manage', 'edit'],
            'sms-template'          => ['manage', 'edit'],
            'testimonial'           => ['manage', 'create', 'edit', 'delete'],
            'event'                 => ['manage', 'create', 'edit', 'delete'],
            'faqs'                  => ['manage', 'create', 'edit', 'delete'],
            'coupon'                => ['manage', 'create', 'edit', 'delete', 'show', 'mass-create', 'upload'],
            'document'              => ['manage', 'create', 'edit', 'delete'],
            'page-setting'          => ['manage', 'create', 'edit', 'delete'],
            'support-ticket'        => ['manage', 'create', 'edit', 'delete'],
            'announcement'          => ['manage'],
            'activity-log'          => ['manage'],
        ];

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        foreach ($adminpermissions as $adminmodule => $adminpermissions) {
            Module::firstOrCreate(['name' => $adminmodule]);
            foreach ($adminpermissions as $adminpermission) {
                $temp1 = Permission::firstOrCreate(['name' => $adminpermission . '-' . $adminmodule]);
                $adminRole->givePermissionTo($temp1);
            }
        }

        $centralUser = tenancy()->central(function ($tenant) {
            return User::find($tenant->id);
        });

        $role = Role::firstOrCreate([
            'name'  => 'User'
        ], ['tenant_id' => $centralUser->tenant_id]);

        $user = User::firstOrCreate(['email' =>  $centralUser->email], [
            'name'              => $centralUser->name,
            'email'             =>  $centralUser->email,
            'password'          =>  $centralUser->password,
            'avatar'            => 'avatar/avatar.png',
            'type'              => 'Admin',
            'lang'              => 'pt-br',
            'plan_id'           => 1,
            'plan_expired_date' => null,
            'email_verified_at' => $centralUser->email_verified_at,
            'phone_verified_at' => $centralUser->phone_verified_at,
            'country_code'      => 'br',
            'dial_code'         => '+55',
            'phone'             => $centralUser->phone,
            'firstname'         => 'Admin',
        ]);

        $user->assignRole($adminRole->id);

        $settings = [
            ['key' => 'app_name', 'value' => 'Sorte em Dobro'],
            ['key' => 'app_logo', 'value' => 'logo/app-logo.png'],
            ['key' => 'app_dark_logo', 'value' => 'logo/app-dark-logo.png'],
            ['key' => 'favicon_logo', 'value' => 'logo/app-favicon-logo.png'],
            ['key' => 'default_language', 'value' => 'pt-br'],
            ['key' => 'currency', 'value' => 'BRL'],
            ['key' => 'currency_symbol', 'value' => 'R$'],
            ['key' => 'date_format', 'value' => 'DD MM, YY'],
            ['key' => 'time_format', 'value' => 'hh:mm'],
            ['key' => 'color', 'value' => 'theme-2'],
            ['key' => 'storage_type', 'value' => 'local'],
            ['key' => 'dark_mode', 'value' => 'on'],
            ['key' => 'transparent_layout', 'value' => '0'],
            ['key' => 'landing_page_status', 'value' => '1'],
            ['key' => 'roles', 'value' => 'User'],

            ['key' => 'apps_setting_enable', 'value' => 'on'],
            ['key' => 'apps_name', 'value' => 'Sorte em Dobro'],
            ['key' => 'apps_bold_name', 'value' => 'Sorte em Dobro'],
            ['key' => 'app_detail', 'value' => 'Sorte em dobro.'],
            ['key' => 'apps_image', 'value' => 'seeder-image/app.png'],
            ['key' => 'apps_multiple_image_setting', 'value' => '[
                {"apps_multiple_image":"seeder-image/1.png"},
                {"apps_multiple_image":"seeder-image/2.png"},
                {"apps_multiple_image":"seeder-image/3.png"},
                {"apps_multiple_image":"seeder-image/4.png"},
                {"apps_multiple_image":"seeder-image/5.png"},
                {"apps_multiple_image":"seeder-image/6.png"},
                {"apps_multiple_image":"seeder-image/7.png"},
                {"apps_multiple_image":"seeder-image/8.png"},
                {"apps_multiple_image":"seeder-image/9.png"}
            ]'],

            ['key' => 'feature_setting_enable', 'value' => 'on'],
            ['key' => 'feature_name', 'value' => 'Full Multi Tenancy Laravel Admin Saas'],
            ['key' => 'feature_bold_name', 'value' => 'Features'],
            ['key' => 'feature_detail', 'value' => 'Full Multi Tenant means that a single instance of the software and its supporting infrastructure serves multiple customers.
                Each customer shares the software application and also shares a single database. Each tenants data is isolated and remains invisible to other tenants.'],
            ['key' => 'feature_setting', 'value' => '[
                {"feature_image":"seeder-image/feature1.svg","feature_name":"Sms Notification","feature_bold_name":"On From Submit","feature_detail":"You can send a notification sms to someone in your organization when a contact submits a form. You can use this type of form processing step so that..."},
                {"feature_image":"seeder-image/feature2.svg","feature_name":"Two Factor","feature_bold_name":"Authentication","feature_detail":"Security is our priority. With our robust two-factor authentication (2FA) feature, you can add an extra layer of protection to your Full Tenancy Form"},
                {"feature_image":"seeder-image/feature3.svg","feature_name":"Events With","feature_bold_name":"Google Calender","feature_detail":"Assign roles and permissions to different users based on their responsibilities and requirements. Admins can manage user accounts, define access level"},
                {"feature_image":"seeder-image/feature4.svg","feature_name":"Multi Feature","feature_bold_name":"Dark Layout","feature_detail":"Template Library: Offer a selection of pre-designed templates for various document types. Template Creation: Allow users to create custom templates with placeholders for dynamic content.Template Library: Offer a selection of pre-designed templates for various document types.Template Creation: Allow users to create custom templates with placeholders for dynamic content."}
            ]'],

            ['key' => 'menu_setting_section1_enable', 'value' => 'on'],
            ['key' => 'menu_name_section1', 'value' => 'Feature'],
            ['key' => 'menu_bold_name_section1', 'value' => 'Events'],
            ['key' => 'menu_detail_section1', 'value' => 'Events are things that happen in the system you are programming the system produces a signal of some kind when
                an event occurs, and provides a mechanism by which an action can be automatically taken (that is, some code running) when the event occurs. Events are fired
                inside the browser window, and tend to be attached to a specific item that resides in it.'],
            ['key' => 'menu_image_section1', 'value' => 'seeder-image/menusection1.png'],

            ['key' => 'menu_setting_section2_enable', 'value' => 'on'],
            ['key' => 'menu_name_section2', 'value' => 'Multi Builder With'],
            ['key' => 'menu_bold_name_section2', 'value' => 'Plans'],
            ['key' => 'menu_detail_section2', 'value' => 'Planning is firmly correlated with discovery and creativity. However, the manager would first have to set goals.
                Planning is an essential step what managers at all levels take. It needs holding on to the decisions since it includes selecting a choice from alternative ways
                of performance.'],
            ['key' => 'menu_image_section2', 'value' => 'seeder-image/menusection2.png'],

            ['key' => 'menu_setting_section3_enable', 'value' => 'on'],
            ['key' => 'menu_name_section3', 'value' => 'Multi Tenant With'],
            ['key' => 'menu_bold_name_section3', 'value' => 'Documents'],
            ['key' => 'menu_detail_section3', 'value' => 'Document Builder is an extension package to the Adobe Acrobat Sign for Salesforce base package and does not
                require any additional purchase. The feature provides a step-by-step wizard for creating rules for merging data from salesforce object fields into a
                Word document template.'],
            ['key' => 'menu_image_section3', 'value' => 'seeder-image/menusection3.png'],

            ['key' => 'business_growth_setting_enable', 'value' => 'on'],
            ['key' => 'business_growth_front_image', 'value' => 'seeder-image/thumbnail.png'],
            ['key' => 'business_growth_video', 'value' => 'seeder-image//video.webm'],
            ['key' => 'business_growth_name', 'value' => 'Makes Quick'],
            ['key' => 'business_growth_bold_name', 'value' => 'Business Growth'],
            ['key' => 'business_growth_detail', 'value' => 'Offer unique products, services, or solutions that stand out in the market. Innovation and differentiation can attract customers and give you a competitive edge.'],
            ['key' => 'business_growth_view_setting', 'value' => '[
                {"business_growth_view_name":"Positive Reviews","business_growth_view_amount":"20 k+"},
                {"business_growth_view_name":"Total Sales","business_growth_view_amount":"300 +"},
                {"business_growth_view_name":"Happy Users","business_growth_view_amount":"100 k+"}
            ]'],
            ['key' => 'business_growth_setting', 'value' => '[
                {"business_growth_title":"User Friendly"},
                {"business_growth_title":"Products Analytic"},
                {"business_growth_title":"Manufacturers"},
                {"business_growth_title":"Order Status Tracking"},
                {"business_growth_title":"Supply Chain"},
                {"business_growth_title":"Chatting Features"},
                {"business_growth_title":"Workflows"},
                {"business_growth_title":"Transformation"},
                {"business_growth_title":"Easy Payout"},
                {"business_growth_title":"Data Adjustment"},
                {"business_growth_title":"Order Status Tracking"},
                {"business_growth_title":"Store Swap Link"},
                {"business_growth_title":"Manufacturers"},
                {"business_growth_title":"Order Status Tracking"}
            ]'],

            ['key' => 'contactus_setting_enable', 'value' => 'on'],
            ['key' => 'contactus_name', 'value' => 'Enterprise'],
            ['key' => 'contactus_bold_name', 'value' => 'Custom pricing'],
            ['key' => 'contactus_detail', 'value' => 'Offering tiered pricing options based on different levels of features or services allows customers.'],

            ['key' => 'faq_setting_enable', 'value' => 'on'],
            ['key' => 'faq_name', 'value' => 'Frequently asked questions'],

            ['key' => 'start_view_setting_enable', 'value' => 'on'],
            ['key' => 'start_view_name', 'value' => 'Start Using Full Multi Tenancy Laravel Admin Saas'],
            ['key' => 'start_view_detail', 'value' => 'a Full Multi Tenancy Laravel Admin Saas application is a complex process that requires careful planning and development.'],
            ['key' => 'start_view_link_name', 'value' => 'Contact Us'],
            ['key' => 'start_view_link', 'value' => route('contact.us')],
            ['key' => 'start_view_image', 'value' => 'seeder-image/startview.png'],

            ['key' => 'login_setting_enable', 'value' => 'on'],
            ['key' => 'login_image', 'value' => 'seeder-image/login.svg'],
            ['key' => 'login_name', 'value' => 'Attention is the new currency'],
            ['key' => 'login_detail', 'value' => 'The more effortless the writing looks, the more effort the writer actually put into the process.'],

            ['key' => 'testimonial_setting_enable', 'value' => 'on'],
            ['key' => 'testimonial_name', 'value' => 'Full Tenancy Laravel Admin Saas'],
            ['key' => 'testimonial_bold_name', 'value' => 'Testimonial'],
            ['key' => 'testimonial_detail', 'value' => 'A testimonial is an honest endorsement of your product or service that usually comes from a customer, colleague, or peer who has benefited from or experienced success as a result of the work you did for them.'],

            ['key' => 'footer_setting_enable', 'value' => 'on'],
            ['key' => 'footer_description', 'value' => 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.'],

            ['key' => 'blog_setting_enable', 'value' => 'on'],
            ['key' => 'blog_name', 'value' => 'Blogs'],
            ['key' => 'blog_detail', 'value' => 'Optimize your manufacturing business with Quebix, offering a seamless user interface for streamlined operations, one convenient platform.'],

            

["key"=>"name", "value"=>"Sorte em Dobro"],
["key"=>"short_name","value"=>"Sorte x2"],
["key"=>"logo","value"=>"uploads/app-logo.png"],
["key"=>"user_avatar","value"=>"uploads/user_avatar.jpg"],
["key"=>"cover","value"=>"uploads/clover.png"],
["key"=>"phone","value"=>"41999574716"],
["key"=>"mobile","value"=>"00000"],
["key"=>"email","value"=>"devdasrifas@gmail.com"],
["key"=>"address","value"=>"Endereço"],
["key"=>"mercadopago","value"=>"2"],
["key"=>"mercadopago_access_token","value"=>""],
["key"=>"gerencianet","value"=>"2"],
["key"=>"gerencianet_client_id","value"=>""],
["key"=>"gerencianet_client_secret","value"=>""],
["key"=>"gerencianet_pix_key","value"=>""],
["key"=>"gateway","value"=>"1"],
["key"=>"enable_cpf","value"=>"2"],
["key"=>"enable_email","value"=>"2"],
["key"=>"enable_address","value"=>"2"],
["key"=>"favicon","value"=>"uploads/favicon.png"],
["key"=>"enable_share","value"=>"2"],
["key"=>"enable_groups","value"=>"2"],
["key"=>"telegram_group_url","value"=>""],
["key"=>"whatsapp_group_url","value"=>""],
["key"=>"enable_footer","value"=>"1"],
["key"=>"text_footer","value"=>"Sorte em Dobro - Todos os direitos reservados."],
["key"=>"enable_password","value"=>"2"],
["key"=>"paggue","value"=>"2"],
["key"=>"paggue_client_key","value"=>""],
["key"=>"paggue_client_secret","value"=>""],
["key"=>"enable_pixel","value"=>"2"],
["key"=>"facebook_access_token","value"=>""],
["key"=>"facebook_pixel_id","value"=>""],
["key"=>"enable_hide_numbers","value"=>"1"],
["key"=>"whatsapp_footer","value"=>""],
["key"=>"instagram_footer","value"=>""],
["key"=>"facebook_footer","value"=>""],
["key"=>"twitter_footer","value"=>"https://twitter.com"],
["key"=>"youtube_footer","value"=>"https://youtube.com"],
["key"=>"enable_dwapi","value"=>"2"],
["key"=>"token_dwapi","value"=>""],
["key"=>"numero_dwapi","value"=>""],
["key"=>"mensagem_novo_pedido_dwapi","value"=>""],
["key"=>"mensagem_pedido_pago_dwapi","value"=>""],
["key"=>"smtp_host","value"=>"smtp.hostinger.com"],
["key"=>"smtp_port","value"=>" 465"],
["key"=>"smtp_user","value"=>""],
["key"=>"smtp_pass","value"=>""],
["key"=>"question1","value"=>"Como acessar minhas compras?"],
["key"=>"answer1","value"=>"Fazendo login no site e abrindo o Menu Principal você consegue consultar suas últimas compras no menu "],
["key"=>"question2","value"=>"Como envio o comprovante?"],
["key"=>"answer2","value"=>"Caso você tenha feito o pagamento via Pix QR Code ou copiando o código não é necessário enviar o comprovante aguardando até 5 minutos após o pagamento o sistema irá dar baixa automaticamente para mais dúvidas entre em contato conosco clicando aqui."],
["key"=>"question3","value"=>"Como é o processo do sorteio?"],
["key"=>"answer3","value"=>"O sorteio será realizado com base na extração da Loteria Federal conforme Condições de Participação constantes no título"],
["key"=>"question4","value"=>""],
["key"=>"answer4","value"=>""],
["key"=>"terms","value"=>"<b>1</b> Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br><br> <b>2)</b> Lorem Ipsum has been the industry&aposs standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries but also the leap into electronic typesetting remaining essentially unchanged. <br><br> <b>3)</b> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. <br><br> (i) It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. <br><br> (ii) Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text and a search for &aposlorem ipsum&apos will uncover many web sites still in their infancy."],
["key"=>"enable_ga4","value"=>"2"],
["key"=>"google_ga4_id","value"=>"1"],
["key"=>"license","value"=>"dee"],
["key"=>"enable_two_phone","value"=>"1"],
["key"=>"enable_gtm","value"=>"2"],
["key"=>"google_gtm_id","value"=>""],
["key"=>"theme","value"=>"2"],
["key"=>"email_order","value"=>""],
["key"=>"email_purchase","value"=>""],
["key"=>"enable_legal_age","value"=>"2"],
["key"=>"enable_birth","value"=>"2"],
["key"=>"enable_instagram","value"=>"2"],
["key"=>"enable_multiple_order","value"=>"2"],
["key"=>"dealer_active","value"=>"2"],
["key"=>"dealer_deactive_site","value"=>"2"],
["key"=>"dealer_split_mercadopago","value"=>"2"],
["key"=>"mercadopago_tax","value"=>""],
["key"=>"gerencianet_tax","value"=>""],
["key"=>"paggue_tax","value"=>"2"],
["key"=>"openpix_app_id","value"=>""],
["key"=>"openpix_tax","value"=>""],
["key"=>"pay2m_client_id","value"=>""],
["key"=>"pay2m_client_secret","value"=>""],
["key"=>"pay2m_tax","value"=>"0"],
["key"=>"openpix","value"=>"2"]
        ];

        tenancy()->central(function ($tenant) {
            Storage::copy('logo/app-logo.png', $tenant->id . '/logo/app-logo.png');
            Storage::copy('logo/app-favicon-logo.png', $tenant->id . '/logo/app-favicon-logo.png');
            Storage::copy('logo/app-dark-logo.png', $tenant->id . '/logo/app-dark-logo.png');
            Storage::copy('avatar/avatar.png', $tenant->id . '/avatar/avatar.png');

            Storage::copy('uploads/logo.png?v=1711644130', $tenant->id . '/uploads/logo.png?v=1711644130');
            Storage::copy('uploads/user_avatar.jpg', $tenant->id . '/uploads/user_avatar.jpg');
            Storage::copy('uploads/cover.png?v=1675042834', $tenant->id . '/upload/cover.png?v=1675042834');
            Storage::copy('uploads/favicon.png?v=1711644130', $tenant->id . '/uploads/favicon.png?v=1711644130');
  
            
            
            
            Storage::copy('seeder-image/2.png', $tenant->id . '/seeder-image/2.png');
            Storage::copy('seeder-image/3.png', $tenant->id . '/seeder-image/3.png');
            Storage::copy('seeder-image/4.png', $tenant->id . '/seeder-image/4.png');
            Storage::copy('seeder-image/5.png', $tenant->id . '/seeder-image/5.png');
            Storage::copy('seeder-image/6.png', $tenant->id . '/seeder-image/6.png');
            Storage::copy('seeder-image/7.png', $tenant->id . '/seeder-image/7.png');
            Storage::copy('seeder-image/8.png', $tenant->id . '/seeder-image/8.png');
            Storage::copy('seeder-image/9.png', $tenant->id . '/seeder-image/9.png');
            Storage::copy('seeder-image/thumbnail.png', $tenant->id . '/seeder-image/thumbnail.png');
            Storage::copy('seeder-image/admin/video.webm', $tenant->id . '/seeder-image/video.webm');
            Storage::copy('seeder-image/admin/13.jpg', $tenant->id . '/seeder-image/13.jpg');
            Storage::copy('seeder-image/admin/14.jpg', $tenant->id . '/seeder-image/14.jpg');
            Storage::copy('seeder-image/admin/15.jpg', $tenant->id . '/seeder-image/15.jpg');
            Storage::copy('seeder-image/admin/16.jpg', $tenant->id . '/seeder-image/16.jpg');
            Storage::copy('seeder-image/admin/feature1.svg', $tenant->id . '/seeder-image/feature1.svg');
            Storage::copy('seeder-image/admin/feature2.svg', $tenant->id . '/seeder-image/feature2.svg');
            Storage::copy('seeder-image/admin/feature3.svg', $tenant->id . '/seeder-image/feature3.svg');
            Storage::copy('seeder-image/admin/feature4.svg', $tenant->id . '/seeder-image/feature4.svg');
            Storage::copy('seeder-image/login.svg', $tenant->id . '/seeder-image/login.svg');
            Storage::copy('seeder-image/admin/menusection1.png', $tenant->id . '/seeder-image/menusection1.png');
            Storage::copy('seeder-image/admin/menusection2.png', $tenant->id . '/seeder-image/menusection2.png');
            Storage::copy('seeder-image/admin/menusection3.png', $tenant->id . '/seeder-image/menusection3.png');
            Storage::copy('seeder-image/admin/startview.png', $tenant->id . '/seeder-image/startview.png');
        });

        foreach ($settings as $setting) {
            Setting::firstOrCreate($setting);
        }

        Faq::firstOrCreate(['quetion' => 'How do I sign up for a tenant account?'], [
            'answer'    => 'To sign up for a tenant account, click the Sign Up button on the homepage, fill out the required information, and follow the on-screen instructions.',
            'order'     => '1',
        ]);
        Faq::firstOrCreate(['quetion' => 'What types of subscription plans do you offer?'], [
            'answer'    => 'We offer a range of subscription plans to accommodate various needs. Our plans include Basic, Pro, and Enterprise tiers, each with different features and pricing.',
            'order'     => '2',
        ]);
        Faq::firstOrCreate(['quetion' => 'How can I customize the appearance of my dashboard?'], [
            'answer'    => 'To customize your dashboard, navigate to the "Settings" section in your dashboard.',
            'order'     => '3'
        ]);
        Faq::firstOrCreate(['quetion' => 'What is Full Tenancy Laravel Saas?'], [
            'answer'    => 'Full Tenancy Laravel Saas is a software-as-a-service (SaaS) solution built on the Laravel framework. It is designed to provide a multi-tenant architecture for Laravel applications, allowing you to easily create and manage multiple independent instances of your application within a single codebase.',
            'order'     => '4'
        ]);

        Testimonial::firstOrCreate(['name' => 'Jeny'], [
            'title'         => 'Customer Support Specialist',
            'description'   => 'As a Customer Support Specialist for Full Tenancy Laravel Admin Saas, I have had the incredible opportunity to assist our valued customers in their journey of utilizing this revolutionary form-building solution.',
            'designation'   => 'Support Specialist',
            'image'         => 'seeder-image/13.jpg',
            'rating'        => 5.0,
            'status'        => 1,
        ]);
        Testimonial::firstOrCreate(['name' => 'Johnsi'], [
            'title'         => 'A Journey of Growth and Transformation',
            'description'   => 'As the Lead Developer for Full Tenancy Laravel Admin Saas, I have had the privilege of being at the forefront of developing a cutting-edge product that revolutionizes form-building.',
            'designation'   => 'Lead Developer',
            'image'         => 'seeder-image/14.jpg',
            'rating'        => 5.0,
            'status'        => 1,
        ]);
        Testimonial::firstOrCreate(['name' => 'Trisha'], [
            'title'         => 'Customer Support Specialist',
            'description'   => 'As a Customer Support Specialist for Full Tenancy Laravel Admin Saas, I have had the incredible opportunity to assist our valued customers in their journey of utilizing this revolutionary form-building solution.',
            'designation'   => 'Support Specialist',
            'image'         => 'seeder-image/15.jpg',
            'rating'        => 5.0,
            'status'        => 1,
        ]);
        Testimonial::firstOrCreate(['name' => 'Trusha'], [
            'title'         => 'A Remarkable Journey of Collaboration and Success',
            'description'   => 'As a Project Manager, my primary responsibility has been to ensure that projects are delivered on time, within budget. I have had the opportunity to work closely with cross-functional teams, marketers, and stakeholders, initiation to completion.',
            'designation'   => 'Project Manager',
            'image'         => 'seeder-image/16.jpg',
            'rating'        => 5.0,
            'status'        => 1,
        ]);

        $parent_id1 = FooterSetting::firstOrCreate(['menu' => 'Company'], [
            'slug'      => 'company',
            'parent_id' => 0,
            'page_id'   => null,
        ]);

        $parent_id2 = FooterSetting::firstOrCreate(['menu' => 'Product'], [
            'slug'      => 'product',
            'parent_id' => 0,
            'page_id'   => null,
        ]);

        $parent_id3 = FooterSetting::firstOrCreate(['menu' => 'Download'], [
            'slug'      => 'download',
            'parent_id' => 0,
            'page_id'   => null,
        ]);

        $parent_id4 = FooterSetting::firstOrCreate(['menu' => 'Support'], [
            'slug'      => 'support',
            'parent_id' => 0,
            'page_id'   => null,
        ]);

        $PageSetting1 = PageSetting::firstOrCreate(['title' => 'About Us'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'At Full Tenancy Laravel Admin Saas, we understand the importance of data privacy and security. Thats why we offer robust privacy settings
            to ensure the protection of your sensitive information. Here&#39;s how our privacy settings work:\r\n\r\n\r\n\r\nData Encryption: We employ industry-standard
            encryption protocols to safeguard your data during transit and storage. Your form submissions and user information are encrypted, making it extremely difficult
            for unauthorized parties to access or tamper with the data.\r\n\r\n\r\nUser Consent Management: Our privacy settings include options for managing user consents.
            You can configure your forms to include consent checkboxes for users to agree to your data handling practices. This helps you ensure compliance with privacy
            regulations and builds trust with your users.\r\n\r\n\r\nData Retention Controls: Take control of how long you retain user data with our data retention settings.
            Define retention periods that align with your business needs or regulatory requirements. Once the specified retention period expires, the data is automatically
            and permanently deleted from our servers.\r\n\r\n\r\nAccess Controls: Grant specific access permissions to team members or clients based on their roles and
            responsibilities. With our access control settings, you can limit who can view, edit, or export form data, ensuring that only authorized individuals can access
            sensitive information.\r\n\r\n\r\nThird-Party Integrations: If you integrate third-party services or applications with Full Tenancy Laravel Admin Saas, our privacy
            settings enable you to manage the data shared with these services. You have the flexibility to control which data is shared, providing an extra layer of privacy
            and control.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'About Us'], [
            'slug'      => 'about-us',
            'parent_id' => $parent_id1->id,
            'page_id'   => $PageSetting1->id,
        ]);

        $PageSetting2 = PageSetting::firstOrCreate(['title' => 'Our Team'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'Meet Our Team provides a grid layout to show all the team members into single page. To display the members information for more attractive by
            using jQuery effects. The viewers can easily identify the hierarchical structure of organization and who are all involved in which designation and their names.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Our Team'], [
            'slug'      => 'our-team',
            'parent_id' => $parent_id1->id,
            'page_id'   => $PageSetting2->id,
        ]);

        $PageSetting3 = PageSetting::firstOrCreate(['title' => 'Products'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'The Products module is a catalogue of the products and services you are offering. Users have the possibility to create an enumerated database
            with descriptions and prices or to synchronize this with Pohoda (the accounting system).',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Products'], [
            'slug'      => 'products',
            'parent_id' => $parent_id1->id,
            'page_id'   => $PageSetting3->id,
        ]);

        $PageSetting4 = PageSetting::firstOrCreate(['title' => 'Contact'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'A Contact Us page isn’t just another page on your website. In fact, it is one of your most valuable pages and you should
            treat it as such. A Contact Us page provides guidance for existing customers and offers an overview of your brand for new visitors.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Contact'], [
            'slug'      => 'contact',
            'parent_id' => $parent_id1->id,
            'page_id'   => $PageSetting4->id,
        ]);

        $PageSetting5 =  PageSetting::firstOrCreate(['title' => 'Feature'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'A feature module delivers a cohesive set of functionality focused on a specific application need such as a user workflow, routing, or forms.
            While you can do everything within the root module, feature modules help you partition the application into focused areas.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Feature'], [
            'slug'      => 'feature',
            'parent_id' => $parent_id2->id,
            'page_id'   => $PageSetting5->id,
        ]);

        $PageSetting6 =  PageSetting::firstOrCreate(['title' => 'Pricing'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'The prices module, also called Pricing, is a system responsible for the creation, editing and storing of your SKU pricing data. For a product
            to be sold, your customer needs to know the cost of each item displayed in your store.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Pricing'], [
            'slug'      => 'pricing',
            'parent_id' => $parent_id2->id,
            'page_id'   => $PageSetting6->id,
        ]);

        $PageSetting7 = PageSetting::firstOrCreate(['title' => 'Credit'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'One credit is typically described as being equal to 10 hours of notional learning. A module that involves 150 notional hours of learning will
            be assigned 15 credits. One that involves 400 notional hours of learning will be assigned 40 credits.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Credit'], [
            'slug'      => 'Credit',
            'parent_id' => $parent_id2->id,
            'page_id'   => $PageSetting7->id,
        ]);

        $PageSetting8 = PageSetting::firstOrCreate(['title' => 'News'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'The News module allows you to feature timely content on your website, such as announcements, special messages, or even your own blog articles.
            Before adding plain text to your homepage using the Text/HTML module, consider using the News module instead!',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'News'], [
            'slug'      => 'news',
            'parent_id' => $parent_id2->id,
            'page_id'   => $PageSetting8->id,
        ]);

        $PageSetting9   =  PageSetting::firstOrCreate(['title' => 'iOS'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'iOS Module Project
            Provides in-depth information about the structure of a module project as well as using Studio and the CLI to manage the projects. Also provides information about
            adding assets and third-party frameworks to the module.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'iOS'], [
            'slug'      => 'ios',
            'parent_id' => $parent_id3->id,
            'page_id'   => $PageSetting9->id,
        ]);

        $PageSetting10  = PageSetting::firstOrCreate(['title' => 'Android'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'Modules provide a container for your apps source code, resource files, and app level settings, such as the module-level build file and Android
            manifest file. Each module can be independently built, tested, and debugged. Android Studio uses modules to make it easy to add new devices to your project.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Android'], [
            'slug'      => 'android',
            'parent_id' => $parent_id3->id,
            'page_id'   => $PageSetting10->id,
        ]);

        $PageSetting11  =  PageSetting::firstOrCreate(['title' => 'Microsoft'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'This article presents an overview of the Microsoft Dynamics 365 Commerce module library. The Dynamics 365 Commerce module library is a collection
             of modules that can be used to build an e-Commerce website. Modules have both user interface (UI) aspects and functional behavior aspects.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Microsoft'], [
            'slug'      => 'microsoft',
            'parent_id' => $parent_id3->id,
            'page_id'   => $PageSetting11->id,
        ]);

        $PageSetting12  = PageSetting::firstOrCreate(['title' => 'Desktop'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'A module is a distinct assembly of components that can be easily added, removed or replaced in a larger system. Generally, a module is not
            functional on its own. In computer hardware, a module is a component that is designed for easy replacement. In computer software, a module is an extension to
            a main program dedicated to a specific function. In programming, a module is a section of code that is added in as a whole or is designed for easy reusability.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Desktop'], [
            'slug'      => 'desktop',
            'parent_id' => $parent_id3->id,
            'page_id'   => $PageSetting12->id,
        ]);

        $PageSetting13 =  PageSetting::firstOrCreate(['title' => 'Help'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'Help, aid, assist, succor agree in the idea of furnishing another with something needed, especially when the need comes at a particular time.
            Help implies furnishing anything that furthers ones efforts or relieves ones wants or necessities. Aid and assist, somewhat more formal, imply especially a
            furthering or seconding of anothers efforts. Aid implies a more active helping; assist implies less need and less help. To succor, still more formal and literary,
             is to give timely help and relief in difficulty or distress: Succor him in his hour of need.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Help'], [
            'slug'      => 'help',
            'parent_id' => $parent_id4->id,
            'page_id'   => $PageSetting13->id,
        ]);

        $PageSetting14 =   PageSetting::firstOrCreate(['title' => 'Terms'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'Full Tenancy Laravel Admin SaasTerms and Conditions
                Acceptance of Terms By accessing and using [Full Tenancy Laravel Admin Saas] (the &quot;Service&quot;), you agree to be bound by these terms and conditions.
                If you do not agree with any part of these terms, please refrain from using the Service.
                Intellectual Property Rights All content and materials provided on the Service are the property of [Full Tenancy Laravel Admin Saas- Saas]&nbsp;and protected
                by applicable intellectual property laws. You may not use, reproduce, distribute, or modify any content from the Service without prior written consent
                from [Full Tenancy Laravel Admin Saas].
                User Responsibilities a. You are solely responsible for any content you submit or upload on the Service. You agree not to post, transmit, or share any
                material that is unlawful, harmful, defamatory, obscene, or infringes upon the rights of others. b. You agree not to interfere with or disrupt the Service
                or its associated servers and networks. c. You are responsible for maintaining the confidentiality of your account information and agree to notify
                [Full Tenancy Laravel Admin Saas- Saas] immediately of any unauthorized use of your account.
                Disclaimer of Warranties The Service is provided on an &quot;as-is&quot; and &quot;as available&quot; basis. [Full Tenancy Laravel Admin Saas] makes no warranties,
                expressed or implied, regarding the accuracy, reliability, or availability of the Service. Your use of the Service is at your own risk.
                Limitation of Liability In no event shall [Full Tenancy Laravel Admin Saas] be liable for any direct, indirect, incidental, consequential, or punitive damages
                arising out of or in connection with the use of the Service. This includes but is not limited to any errors or omissions in the content, loss of data, or
                any other loss or damage. Indemnification You agree to indemnify and hold&nbsp; harmless from any claims, damages, liabilities, or expenses arising out of
                your use of the Service, your violation of these terms and conditions, or your infringement of any rights of a third party.
                Modification and Termination [Full Tenancy Laravel Admin Saas- Saas] reserves the right to modify or terminate the Service at any time, without prior notice.
                We also reserve the right to update these terms and conditions from time to time. It is your responsibility to review the most current version regularly.
                Governing Law These terms and conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising out of these terms
                shall be subject to the exclusive jurisdiction of the courts located in india.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Terms'], [
            'slug'      => 'terms',
            'parent_id' => $parent_id4->id,
            'page_id'   => $PageSetting14->id,
        ]);

        $PageSetting15 =   PageSetting::firstOrCreate(['title' => 'FAQ'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => 'A frequently asked questions (FAQ) list is often used in articles, websites, email lists, and online forums where common
            questions tend to recur, for example through posts or queries by new users related to common knowledge gaps.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'FAQ'], [
            'slug'      => 'fAQ',
            'parent_id' => $parent_id4->id,
            'page_id'   => $PageSetting15->id,
        ]);
        
        
 
        
       


        $PageSetting16 =    PageSetting::firstOrCreate(['title' => 'Privacy'], [
            'type'          => 'desc',
            'url_type'      => null,
            'page_url'      => null,
            'friendly_url'  => null,
            'description'   => '
                Acceptance of Terms By accessing and using [Full Tenancy Laravel Admin Saas] (the &quot;Service&quot;), you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please refrain from using the Service.
                Intellectual Property Rights All content and materials provided on the Service are the property of [Full Tenancy Laravel Admin Saas- Saas]&nbsp;and protected by applicable intellectual property laws. You may not use, reproduce, distribute, or modify any content from the Service without prior written consent from [Full Tenancy Laravel Admin Saas].
                User Responsibilities a. You are solely responsible for any content you submit or upload on the Service. You agree not to post, transmit, or share any material that is unlawful, harmful, defamatory, obscene, or infringes upon the rights of others. b. You agree not to interfere with or disrupt the Service or its associated servers and networks. c. You are responsible for maintaining the confidentiality of your account information and agree to notify [Full Tenancy Laravel Admin Saas- Saas] immediately of any unauthorized use of your account.
                Disclaimer of Warranties The Service is provided on an &quot;as-is&quot; and &quot;as available&quot; basis. [Full Tenancy Laravel Admin Saas] makes no warranties, expressed or implied, regarding the accuracy, reliability, or availability of the Service. Your use of the Service is at your own risk.
                Limitation of Liability In no event shall [Full Tenancy Laravel Admin Saas] be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or in connection with the use of the Service. This includes but is not limited to any errors or omissions in the content, loss of data, or any other loss or damage.
                Indemnification You agree to indemnify and hold&nbsp; harmless from any claims, damages, liabilities, or expenses arising out of your use of the Service, your violation of these terms and conditions, or your infringement of any rights of a third party.
                Modification and Termination [Full Tenancy Laravel Admin Saas- Saas] reserves the right to modify or terminate the Service at any time, without prior notice. We also reserve the right to update these terms and conditions from time to time. It is your responsibility to review the most current version regularly.
                Governing Law These terms and conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising out of these terms shall be subject to the exclusive jurisdiction of the courts located in india.',
        ]);

        FooterSetting::firstOrCreate(['menu' => 'Privacy'], [
            'slug'      => 'privacy',
            'parent_id' => $parent_id4->id,
            'page_id'   => $PageSetting16->id,
        ]);

        Plan::firstOrCreate(['name' => 'Free'], [
            'name'          => 'Free',
            'price'         => '0',
            'duration'      => '1',
            'durationtype'  => 'Year',
            'max_users'     => '10'
        ]);
        


        SmsTemplate::firstOrCreate(['event' => 'verification code sms'], [
            'event'     => 'verification code sms',
            'template'  => 'Hello :name, Your verification code is :code',
            'variables' => 'name,code'
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\TestMail::class], [
            'mailable'      => \App\Mail\Admin\TestMail::class,
            'subject'       => 'Mail send for testing purpose',
            'html_template' => '<p><strong>This Mail For Testing</strong></p>
            <p><strong>Thanks</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\ApproveOfflineMail::class], [
            'mailable'      => \App\Mail\Admin\ApproveOfflineMail::class,
            'subject'       => 'Offline Payment Request Verified',
            'html_template' => '<p><strong>Hi&nbsp;&nbsp;{{ name }}</strong></p>
            <p><strong>Your Plan Update Request {{ email }}&nbsp;is Verified By Super Admin</strong></p>
            <p><strong>Please Check</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\OfflineMail::class], [
            'mailable'      => \App\Mail\Admin\OfflineMail::class,
            'subject'       => 'Offline Payment Request Unverified',
            'html_template' => '<p><strong>Hi&nbsp;{{ name }}</strong></p>
            <p><strong>Your Request Payment {{ email }}&nbsp;Is Disapprove By Super Admin</strong></p>
            <p><strong>Because&nbsp;{{ disapprove_reason }}</strong></p>
            <p><strong>Please Contact to Super Admin</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\ConatctMail::class], [
            'mailable'      => \App\Mail\Admin\ConatctMail::class,
            'subject'       => 'New Enquiry Details',
            'html_template' => '<p><strong>Name : {{name}}</strong></p>
            <p><strong>Email : </strong><strong>{{email}}</strong></p>
            <p><strong>Contact No : {{ contact_no }}&nbsp;</strong></p>
            <p><strong>Message :&nbsp;</strong><strong>{{ message }}</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\PasswordResets::class], [
            'mailable'      => \App\Mail\Admin\PasswordResets::class,
            'subject'       => 'Reset Password Notification',
            'html_template' => '<p><strong>Hello!</strong></p><p>You are receiving this email because we received a password reset request for your account. To proceed with the password reset please click on the link below:</p><p><a href="{{url}}">Reset Password</a></p><p>This password reset link will expire in 60 minutes.&nbsp;<br>If you did not request a password reset, no further action is required.</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Admin\RegisterMail::class], [
            'mailable'      => \App\Mail\Admin\RegisterMail::class,
            'subject'       => 'Register Mail',
            'html_template' => '<p><strong>Hi {{name}}</strong></p>
            <p><strong>Email {{email}}</strong></p>
            <p><strong>Register Successfully</strong></p>',
            'text_template' => null,
        ]);
        
        
        

        NotificationsSetting::firstOrCreate(['title' => 'Testing Purpose'], [
            'title'                 => 'Testing Purpose',
            'email_notification'    => '1',
            'sms_notification'      => '0',
            'notify'                => '0',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Register Mail'], [
            'title'                 => 'Register Mail',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '1',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'New Enquiry Details'], [
            'title'                 => 'New Enquiry Details',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Send Ticket Reply'], [
            'title'                 => 'Send Ticket Reply',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Offline Payment Request Verified'], [
            'title'                 => 'Offline Payment Request Verified',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Offline Payment Request Unverified'], [
            'title'                 => 'Offline Payment Request Unverified',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);
        
        
      
        
    }
}
