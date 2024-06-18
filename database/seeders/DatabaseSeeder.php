<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FooterSetting;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\NotificationsSetting;
use App\Models\PageSetting;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\SmsTemplate;
use App\Models\Testimonial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\MailTemplates\Models\MailTemplate;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('cache:clear');
        $allpermissions = [
            'role'                  => ['manage', 'create', 'edit', 'delete', 'show'],
            'user'                  => ['manage', 'create', 'edit', 'delete', 'impersonate'],
            'module'                => ['manage', 'create', 'edit', 'delete'],
            'setting'               => ['manage'],
            'transaction'           => ['manage'],
            'landingpage'           => ['manage'],
            'chat'                  => ['manage'],
            'langauge'              => ['manage', 'create', 'edit', 'delete'],
            'plan'                  => ['manage', 'create', 'edit', 'delete'],
            'blog'                  => ['manage', 'create', 'edit', 'delete'],
            'category'              => ['manage', 'create', 'edit', 'delete'],
            'email-template'        => ['manage', 'edit'],
            'sms-template'          => ['manage', 'edit'],
            'support-ticket'        => ['manage', 'create', 'edit', 'delete'],
            'domain-request'        => ['manage', 'create', 'edit', 'delete'],
            'change-domain'         => ['manage', 'create', 'edit', 'delete'],
            'testimonial'           => ['manage', 'create', 'edit', 'delete'],
            'faqs'                  => ['manage', 'create', 'edit', 'delete'],
            'coupon'                => ['manage', 'create', 'edit', 'delete', 'show', 'mass-create', 'upload'],
            'event'                 => ['manage', 'create', 'edit', 'delete'],
            'document'              => ['manage', 'create', 'edit', 'delete'],
            'page-setting'          => ['manage', 'create', 'edit', 'delete'],
            'announcement'          => ['manage', 'create', 'edit', 'delete'],
            'activity-log'          => ['manage'],
        ];

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        foreach ($allpermissions as $module => $permissions) {
            Module::firstOrCreate(['name' => $module]);
            foreach ($permissions as $permission) {
                $temp = Permission::firstOrCreate(['name' => $permission . '-' . $module]);
                $superAdmin->givePermissionTo($temp);
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

        $user = User::firstOrCreate(['email' => 'superadmin@example.com'], [
            'name'              => 'Super Admin',
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('admin@1232'),
            'avatar'            => 'avatar/avatar.png',
            'type'              => 'Super Admin',
            'lang'              => 'en',
            'email_verified_at' => Carbon::now(),
            'phone_verified_at' => Carbon::now(),
            'phone'             => '1234567890',
            'country_code'      => 'br',
            'dial_code'         => '55',
        ]);

        $user->assignRole($superAdmin->id);

        $settings = [
            ['key' => 'app_name', 'value' => 'Full Multi Tenancy Laravel Admin Saas'],
            ['key' => 'app_logo', 'value' => 'logo/app-logo.png'],
            ['key' => 'app_dark_logo', 'value' => 'logo/app-dark-logo.png'],
            ['key' => 'favicon_logo', 'value' => 'logo/app-favicon-logo.png'],
            ['key' => 'default_language', 'value' => 'en'],
            ['key' => 'currency', 'value' => 'USD'],
            ['key' => 'currency_symbol', 'value' => '$'],
            ['key' => 'date_format', 'value' => 'M j, Y'],
            ['key' => 'time_format', 'value' => 'g:i A'],
            ['key' => 'color', 'value' => 'theme-2'],
            ['key' => 'storage_type', 'value' => 'local'],
            ['key' => 'domain_config', 'value' => 'off'],
            ['key' => 'dark_mode', 'value' => 'off'],
            ['key' => 'roles', 'value' => 'User'],
            ['key' => 'transparent_layout', 'value' => '1'],
            ['key' => 'landing_page_status', 'value' => '1'],

            ['key' => 'apps_setting_enable', 'value' => 'on'],
            ['key' => 'apps_name', 'value' => 'Full Multi Tenancy Laravel'],
            ['key' => 'apps_bold_name', 'value' => 'Admin Saas'],
            ['key' => 'app_detail', 'value' => 'Full Tenancy is a whole period of the time that the Tenant occupies the Property and / or pays rent for the Property,
                whichever is the longer, including the initial period of the Tenancy, any renewal or extension of the Tenancy and any period of holding over.'],
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
            ['key' => 'feature_detail', 'value' => 'Full Multi Tenancy means that a single instance of the software and its supporting infrastructure serves multiple customers.
                In the early days of the cloud, organizations were reluctant to adopt cloud strategies.'],
            ['key' => 'feature_setting', 'value' => '[
                {"feature_image":"seeder-image/feature1.svg","feature_name":"Email Notification","feature_bold_name":"On From Submit","feature_detail":"You can send a notification email to someone in your organization when a contact submits a form. You can use this type of form processing step so that..."},
                {"feature_image":"seeder-image/feature2.svg","feature_name":"Two Factor","feature_bold_name":"Authentication","feature_detail":"Security is our priority. With our robust two-factor authentication (2FA) feature, you can add an extra layer of protection to your Full Tenancy Form"},
                {"feature_image":"seeder-image/feature3.svg","feature_name":"Multi Users With","feature_bold_name":"Role & permission","feature_detail":"Assign roles and permissions to different users based on their responsibilities and requirements. Admins can manage user accounts, define access level"},
                {"feature_image":"seeder-image/feature4.svg","feature_name":"Multiple Section","feature_bold_name":"RTL Setting","feature_detail":"The RTL circuit consists of resistors at inputs and transistors at the output side. Transistors are used as the switching device. The emitter of the transistor is connected to the ground."}
            ]'],

            ['key' => 'menu_setting_section1_enable', 'value' => 'on'],
            ['key' => 'menu_name_section1', 'value' => 'Dashboard'],
            ['key' => 'menu_bold_name_section1', 'value' => 'Apexchart'],
            ['key' => 'menu_detail_section1', 'value' => 'ApexChart enables users to create and customize dynamic, visually engaging charts for data visualization. Users can select chart types, configure data sources, apply filters, customize appearance, and interact with data through various chart-related features. '],
            ['key' => 'menu_image_section1', 'value' => 'seeder-image/menusection1.png'],

            ['key' => 'menu_setting_section2_enable', 'value' => 'on'],
            ['key' => 'menu_name_section2', 'value' => 'Support System With'],
            ['key' => 'menu_bold_name_section2', 'value' => 'Issue Resolution'],
            ['key' => 'menu_detail_section2', 'value' => 'The Support System section is your gateway to comprehensive assistance. It provides access to a knowledge base, FAQs, and direct contact options for user inquiries and assistance.'],
            ['key' => 'menu_image_section2', 'value' => 'seeder-image/menusection2.png'],

            ['key' => 'menu_setting_section3_enable', 'value' => 'on'],
            ['key' => 'menu_name_section3', 'value' => 'Setting Features With'],
            ['key' => 'menu_bold_name_section3', 'value' => 'Multiple Section settings'],
            ['key' => 'menu_detail_section3', 'value' => 'A settings page is a crucial component of many digital products, allowing users to customize their experience according to their preferences. Designing a settings page with dynamic data enhances user satisfaction and engagement. Here s a guide on how to create such a page.'],
            ['key' => 'menu_image_section3', 'value' => 'seeder-image/menusection3.png'],

            ['key' => 'business_growth_setting_enable', 'value' => 'on'],
            ['key' => 'business_growth_front_image', 'value' => 'seeder-image/thumbnail.png'],
            ['key' => 'business_growth_video', 'value' => 'seeder-image/video.webm'],
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

            ['key' => 'plan_setting_enable', 'value' => 'on'],
            ['key' => 'plan_name', 'value' => 'Simple, Flexible'],
            ['key' => 'plan_bold_name', 'value' => 'Pricing'],
            ['key' => 'plan_detail', 'value' => 'The pricing structure is easy to comprehend, and all costs and fees are explicitly stated. There are no hidden charges or surprise costs for customers.'],

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
            ['key' => 'login_name', 'value' => 'Seu novo Painel'],
            ['key' => 'login_detail', 'value' => 'Gerencie de foma fácil e eficiente suas camapanhas e clientes.'],

            ['key' => 'testimonial_setting_enable', 'value' => 'on'],
            ['key' => 'testimonial_name', 'value' => 'Full Tenancy Laravel Admin Saas'],
            ['key' => 'testimonial_bold_name', 'value' => 'Testimonial'],
            ['key' => 'testimonial_detail', 'value' => 'A testimonial is an honest endorsement of your product or service that usually comes from a customer, colleague, or peer who has benefited from or experienced success as a result of the work you did for them.'],

            ['key' => 'footer_setting_enable', 'value' => 'on'],
            ['key' => 'footer_description', 'value' => 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.'],

            ['key' => 'announcements_setting_enable', 'value' => 'on'],
            ['key' => 'announcements_title', 'value' => 'Announcements'],
            ['key' => 'announcement_short_description', 'value' => 'An announcement letter is a formal document that can highlight possible changes occurring within a company or other relevant information. Companies send announcement letters to business clients, sales prospects or to their own employees, depending on the focus of the announcement.'],
        
        ];

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
            'description'   => 'At Full Tenancy Laravel Admin Saas, we understand the importance of data privacy and security. Thats why we
             offer robust privacy settings to ensure the protection of your sensitive information. Here&#39;s how our privacy settings work:\r\n\r\n\r\n\r\nData Encryption:
            We employ industry-standard encryption protocols to safeguard your data during transit and storage. Your form submissions and user information are encrypted,
            making it extremely difficult for unauthorized parties to access or tamper with the data.\r\n\r\n\r\nUser Consent Management: Our privacy settings include options
            for managing user consents. You can configure your forms to include consent checkboxes for users to agree to your data handling practices. This helps you ensure
            compliance with privacy regulations and builds trust with your users.\r\n\r\n\r\nData Retention Controls: Take control of how long you retain user data with our data
            retention settings. Define retention periods that align with your business needs or regulatory requirements. Once the specified retention period expires, the data is
            automatically and permanently deleted from our servers.\r\n\r\n\r\nAccess Controls: Grant specific access permissions to team members or clients based on their roles
            and responsibilities. With our access control settings, you can limit who can view, edit, or export form data, ensuring that only authorized individuals can access
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

        $PageSetting9 =  PageSetting::firstOrCreate(['title' => 'iOS'], [
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

        $PageSetting10 = PageSetting::firstOrCreate(['title' => 'Android'], [
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

        $PageSetting11 =  PageSetting::firstOrCreate(['title' => 'Microsoft'], [
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

        $PageSetting12 =   PageSetting::firstOrCreate(['title' => 'Desktop'], [
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
            'description'   => 'Full Tenancy Laravel Admin Saas Terms and Conditions
                Acceptance of Terms By accessing and using [Full Tenancy Laravel Admin Saas ] (the &quot;Service&quot;), you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please refrain from using the Service.
                Intellectual Property Rights All content and materials provided on the Service are the property of [Full Tenancy Laravel Admin Saas - Saas]&nbsp;and protected by applicable intellectual property laws. You may not use, reproduce, distribute, or modify any content from the Service without prior written consent from [Full Tenancy Laravel Admin Saas ].
                User Responsibilities a. You are solely responsible for any content you submit or upload on the Service. You agree not to post, transmit, or share any material that is unlawful, harmful, defamatory, obscene, or infringes upon the rights of others. b. You agree not to interfere with or disrupt the Service or its associated servers and networks. c. You are responsible for maintaining the confidentiality of your account information and agree to notify [Full Tenancy Laravel Admin Saas - Saas] immediately of any unauthorized use of your account.
                Disclaimer of Warranties The Service is provided on an &quot;as-is&quot; and &quot;as available&quot; basis. [Full Tenancy Laravel Admin Saas ] makes no warranties, expressed or implied, regarding the accuracy, reliability, or availability of the Service. Your use of the Service is at your own risk.
                Limitation of Liability In no event shall [Full Tenancy Laravel Admin Saas ] be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or in connection with the use of the Service. This includes but is not limited to any errors or omissions in the content, loss of data, or any other loss or damage.
                Indemnification You agree to indemnify and hold&nbsp; harmless from any claims, damages, liabilities, or expenses arising out of your use of the Service, your violation of these terms and conditions, or your infringement of any rights of a third party.
                Modification and Termination [Full Tenancy Laravel Admin Saas - Saas] reserves the right to modify or terminate the Service at any time, without prior notice. We also reserve the right to update these terms and conditions from time to time. It is your responsibility to review the most current version regularly.
                Governing Law These terms and conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising out of these terms shall be subject to the exclusive jurisdiction of the courts located in india.',
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

        FooterSetting::firstOrCreate(['menu' => 'Privacy',], [
            'slug'      => 'privacy',
            'parent_id' => $parent_id4->id,
            'page_id'   => $PageSetting16->id,
        ]);

        Plan::firstOrCreate(['name' => 'Free'], [
            'name'              => 'Free',
            'price'             => '0',
            'duration'          => '1',
            'durationtype'      => 'Month',
            'description'       => 'A payment plan an organized payment schedule.',
            'max_users'         => '5',
            'max_roles'         => '5',
            'max_documents'     => '5',
            'max_blogs'         => '5',
            'discount_setting'  => 'off',
            'discount'          => null,
        ]);
        Plan::firstOrCreate(['name' => 'Silver'], [
            'name'              => 'Silver',
            'price'             => '10',
            'duration'          => '1',
            'durationtype'      => 'Month',
            'description'       => 'Silver is nearly White, lustrous, Soft, Very Ductile, Malleable.',
            'max_users'         => '5',
            'max_roles'         => '5',
            'max_documents'     => '5',
            'max_blogs'         => '5',
            'discount_setting'  => 'off',
            'discount'          => null,
        ]);
        Plan::firstOrCreate(['name' => 'Gold'], [
            'name'              => 'Gold',
            'price'             => '20',
            'duration'          => '1',
            'durationtype'      => 'Month',
            'description'       => 'Gold is a bright, slightly orange-yellow, dense, soft, malleable, and ductile metal in pure form.',
            'max_users'         => '5',
            'max_roles'         => '5',
            'max_documents'     => '5',
            'max_blogs'         => '5',
            'discount_setting'  => 'off',
            'discount'          => null,
        ]);

        SmsTemplate::firstOrCreate(['event' => 'verification code sms'], [
            'event'     => 'verification code sms',
            'template'  => 'Hello :name, Your verification code is :code',
            'variables' => 'name,code'
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\TestMail::class], [
            'mailable'      => \App\Mail\Superadmin\TestMail::class,
            'subject'       => 'Mail send for testing purpose',
            'html_template' => '<p><strong>This Mail For Testing</strong></p>
            <p><strong>Thanks</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\ApproveMail::class], [
            'mailable'      => \App\Mail\Superadmin\ApproveMail::class,
            'subject'       => 'Domain Verified',
            'html_template' => '<p><strong>Hi {{name}}</strong></p>
            <p><strong>Your Domain&nbsp;{{ domain_name }}&nbsp;&nbsp;is Verified By SuperAdmin</strong></p>
            <p><strong>Please Check with by click below link</strong></p>
            <p><a href="{{login_button_url}}">Login</a></p>
            <p>&nbsp;</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\DisapprovedMail::class], [
            'mailable'      => \App\Mail\Superadmin\DisapprovedMail::class,
            'subject'       => 'Domain Unverified',
            'html_template' => '<p><strong>Hi&nbsp;{{ name }}</strong></p>
            <p><strong>Your Domain&nbsp;{{ domain_name }}&nbsp;is not Verified By SuperAdmin </strong></p>
            <p><strong>Because&nbsp;{{ reason }}</strong></p>
            <p><strong>Please contact to SuperAdmin</strong></p>
            <p>&nbsp;</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\ApproveOfflineMail::class], [
            'mailable'      => \App\Mail\Superadmin\ApproveOfflineMail::class,
            'subject'       => 'Offline Payment Request Verified',
            'html_template' => '<p><strong>Hi&nbsp;&nbsp;{{ name }}</strong></p>
            <p><strong>Your Plan Update Request {{ email }}&nbsp;is Verified By Super Admin</strong></p>
            <p><strong>Please Check</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\OfflineMail::class], [
            'mailable'      => \App\Mail\Superadmin\OfflineMail::class,
            'subject'       => 'Offline Payment Request Unverified',
            'html_template' => '<p><strong>Hi&nbsp;{{ name }}</strong></p>
            <p><strong>Your Request Payment {{ email }}&nbsp;Is Disapprove By Super Admin</strong></p>
            <p><strong>Because&nbsp;{{ disapprove_reason }}</strong></p>
            <p><strong>Please Contact to Super Admin</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\ConatctMail::class], [
            'mailable'      => \App\Mail\Superadmin\ConatctMail::class,
            'subject'       => 'New Enquiry Details',
            'html_template' => '<p><strong>Name : {{name}}</strong></p>
            <p><strong>Email : </strong><strong>{{email}}</strong></p>
            <p><strong>Contact No : {{ contact_no }}&nbsp;</strong></p>
            <p><strong>Message :&nbsp;</strong><strong>{{ message }}</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\PasswordReset::class], [
            'mailable'      => \App\Mail\Superadmin\PasswordReset::class,
            'subject'       => 'Reset Password Notification',
            'html_template' => '<p><strong>Hello!</strong></p><p>You are receiving this email because we received a password reset request for your account. To proceed with the password reset please click on the link below:</p><p><a href="{{url}}">Reset Password</a></p><p>This password reset link will expire in 60 minutes.&nbsp;<br>If you did not request a password reset, no further action is required.</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\SupportTicketMail::class], [
            'mailable'      => \App\Mail\Superadmin\SupportTicketMail::class,
            'subject'       => 'New Ticket Opened',
            'html_template' => '<p><strong>New Ticket Create {{ name }}</strong></p>
            <p><strong>A request for new Ticket&nbsp;&nbsp;{{ ticket_id }}</strong></p>
            <p><strong>Title : {{ title }}</strong></p>
            <p><strong>Email : {{ email }}</strong></p>
            <p><strong>Description :&nbsp;{{ description }}</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\ReceiveTicketReplyMail::class], [
            'mailable'      => \App\Mail\Superadmin\ReceiveTicketReplyMail::class,
            'subject'       => 'Received Ticket Reply',
            'html_template' => '<p><strong>Your Ticket id&nbsp; {{ ticket_id }} New&nbsp;Reply</strong></p>
            <p><strong>{{ reply }}</strong></p>
            <p><strong>Thank you</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\SupportTicketReplyMail::class], [
            'mailable'      => \App\Mail\Superadmin\SupportTicketReplyMail::class,
            'subject'       => 'Send Ticket Reply',
            'html_template' => '<p><strong>Your Ticket id&nbsp; {{ ticket_id }} New&nbsp;Reply</strong></p>
            <p><strong>{{ reply }}</strong></p>
            <p><strong>Thank you</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\Superadmin\RegisterMail::class], [
            'mailable'      => \App\Mail\Superadmin\RegisterMail::class,
            'subject'       => 'Register Mail',
            'html_template' => '<p><strong>Hi {{name}}</strong></p>
            <p><strong>Email : {{email}}</strong></p>
            <p><strong>Domain : {{domain_name}}</strong></p>
            <p><strong>Note:Please link your domain with {{domain_ip}} ip address</strong></p>
            <p><strong>Thanks for registration, your account is in review and you get email when your account active.</strong></p>',
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

        NotificationsSetting::firstOrCreate(['title' => 'New Ticket Opened'], [
            'title'                 => 'New Ticket Opened',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Received Ticket Reply'], [
            'title'                 => 'Received Ticket Reply',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Domain Verified'], [
            'title'                 => 'Domain Verified',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Domain Unverified'], [
            'title'                 => 'Domain Unverified',
            'email_notification'    => '1',
            'sms_notification'      => '2',
            'notify'                => '1',
            'status'                => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Offline Payment Request Verified'], [
            'title' => 'Offline Payment Request Verified',
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
