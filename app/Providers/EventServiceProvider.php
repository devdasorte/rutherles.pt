<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Models\Conversions;
use App\Observers\ConversionsObserver;
use App\Models\Coupon;
use App\Observers\CouponObserver;
use App\Models\DocumentGenrator;
use App\Observers\DocumentGenratorObserver;
use App\Models\DocumentMenu;
use App\Observers\DocumentMenuObserver;
use App\Models\Event;
use App\Observers\EventObserver;
use App\Models\Faq;
use App\Observers\FaqObserver;
use App\Models\Module;
use App\Observers\ModuleObserver;
use App\Models\OfflineRequest;
use App\Observers\OfflineRequestObserver;
use App\Models\PageSetting;
use App\Observers\PageSettingObserver;
use App\Models\Plan;
use App\Observers\PlanObserver;
use App\Models\Posts;
use App\Observers\PostsObserver;
use App\Models\RequestDomain;
use App\Observers\RequestDomainObserver;
use App\Models\Role;
use App\Observers\RoleObserver;
use App\Models\Setting;
use App\Observers\SettingObserver;
use App\Models\SmsTemplate;
use App\Observers\SmsTemplateObserver;
use App\Models\SupportTicket;
use App\Observers\SupportTicketObserver;
use App\Models\Testimonial;
use App\Observers\TestimonialObserver;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\UserCode;
use App\Observers\UserCodeObserver;
use Spatie\MailTemplates\Models\MailTemplate;
use App\Observers\MailTemplateObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot()
    {
        Coupon::observe(CouponObserver::class);
        Faq::observe(FaqObserver::class);
        PageSetting::observe(PageSettingObserver::class);
        Plan::observe(PlanObserver::class);
        Role::observe(RoleObserver::class);
        SupportTicket::observe(SupportTicketObserver::class);
        Testimonial::observe(TestimonialObserver::class);
        User::observe(UserObserver::class);
        Conversions::observe(ConversionsObserver::class);
        MailTemplate::observe(MailTemplateObserver::class);
        SmsTemplate::observe(SmsTemplateObserver::class);
        OfflineRequest::observe(OfflineRequestObserver::class);
        Setting::observe(SettingObserver::class);
        Announcement::observe(AnnouncementObserver::class);
        Module::observe(ModuleObserver::class);
        RequestDomain::observe(RequestDomainObserver::class);
        Category::observe(CategoryObserver::class);
        Posts::observe(PostsObserver::class);
        DocumentGenrator::observe(DocumentGenratorObserver::class);
        DocumentMenu::observe(DocumentMenuObserver::class);
        Event::observe(EventObserver::class);
        UserCode::observe(UserCodeObserver::class);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
