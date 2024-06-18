@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
    
  
@endphp
<nav class="dash-sidebar light-sidebar {{ Utility::getsettings('transparent_layout') == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <div class="m-headers logo-col">
            <a href="{{ route('home') }}" class="b-brand">
              
                @if ($users->dark_layout == 1)
                    <img src="{{ Utility::getsettings('app_logo') ? Utility::getpath('logo/app-logo.png') : asset('assets/images/logo/app-logo.png') }}"
                        class="footer-light-logo">
                @else
                    <img src="{{ Utility::getsettings('app_dark_logo') ? Utility::getpath('logo/app-dark-logo.png') : asset('assets/images/logo/app-dark-logo.png') }}"
                        class="footer-dark-logo">
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar">
                <li class="dash-item dash-hasmenu">
                    <a href="{{ route('home') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span>
                        <span class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @if ($users->type == 'Super Admin')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span
                                class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                           
                                <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('users.index') }}">{{ __('Admins') }}</a>
                                </li>
                          
                                <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                </li>
                            
                        </ul>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('request-domain*') || request()->is('change-domain*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-lock"></i></span><span
                                class="dash-mtext">{{ __('Domain Management') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-domain-request')
                                <li class="dash-item {{ request()->is('request-domain*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('request.domain.index') }}">{{ __('Domain Requests') }}</a>
                                </li>
                            @endcan
                            @can('manage-domain-request')
                                <li class="dash-item {{ request()->is('change-domain*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('changedomain') }}">{{ __('Change Domain') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('coupon*') || request()->is('plans*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-gift"></i></span><span
                                class="dash-mtext">{{ __('Subscription') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-coupon')
                                <li class="dash-item {{ request()->is('coupon*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('coupon.index') }}">{{ __('Coupons') }}</a>
                                </li>
                            @endcan
                            @can('manage-plan')
                                <li
                                    class="dash-item {{ request()->is('plans*') || request()->is('payment*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('plans.index') }}">{{ __('Plans') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('offline*') || request()->is('sales*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-clipboard-check"></i></span><span
                                class="dash-mtext">{{ __('Payment') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('offline*') ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('offline.index') }}">{{ __('Offline Payments') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('sales*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('sales.index') }}">{{ __('Transactions') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('support-ticket*') || request()->is('announcement*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-database"></i></span><span
                                class="dash-mtext">{{ __('Support') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('support-ticket*') ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('support-ticket.index') }}">{{ __('Support Tickets') }}</a>
                            </li>
                            @can('manage-announcement')
                                <li class="dash-item {{ request()->is('announcement*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('announcement.index') }}">{{ __('Announcement') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('manage-activity-log')
                        <li class="dash-item dash-hasmenu {{ request()->is('activity-log*') ? 'active' : '' }}">
                            <a href="{{ route('activity.log.index') }}" class="dash-link">
                                <span class="dash-micon">
                                    <i class="ti ti-activity">
                                    </i>
                                </span>
                                <span class="dash-mtext">{{ __('Activity Log') }}
                                </span>
                            </a>
                        </li>
                    @endcan
                          {{--  
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('landingpage-setting*') ||
                        request()->is('faqs*') ||
                        request()->is('testimonial*') ||
                        request()->is('pagesetting*')
                            ? 'active dash-trigger'
                            : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Frontend Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-landingpage')
                                <li class="dash-item {{ request()->is('landingpage-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('landingpage.setting') }}">{{ __('Landing Page') }}</a>
                                </li>
                            @endcan
                            @can('manage-faqs')
                                <li class="dash-item {{ request()->is('faqs*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('faqs.index') }}">{{ __('Faqs') }}</a>
                                </li>
                            @endcan
                            @can('manage-testimonial')
                                <li class="dash-item {{ request()->is('testimonial*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('testimonial.index') }}">{{ __('Testimonials') }}</a>
                                </li>
                            @endcan
                            @can('manage-page-setting')
                                <li class="dash-item {{ request()->is('pagesetting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('pagesetting.index') }}">{{ __('Page Settings') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('email-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('sms-template*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span
                                class="dash-mtext">{{ __('Account Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-email-template')
                                <li class="dash-item {{ request()->is('email-template*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('email-template.index') }}">{{ __('Email Templates') }}</a>
                                </li>
                            @endcan
                            @can('manage-sms-template')
                                <li class="dash-item {{ request()->is('sms-template*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('sms-template.index') }}">{{ __('Sms Templates') }}</a>
                                </li>
                            @endcan
                            @can('manage-langauge')
                                <li
                                    class="dash-item {{ request()->is('manage-language*') || request()->is('create-language*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('manage.language', [$currantLang]) }}">{{ __('Manage Languages') }}</a>
                                </li>
                            @endcan
                            @can('manage-setting')
                                <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
          <li
                        class="dash-item dash-hasmenu {{ request()->is('telescope*')  ? 'active dash-trigger' : 'collapsed' }}">
                        <a class="dash-link"><span class="dash-micon"><i class="ti ti-device-desktop-analytics"></i></span><span
                                class="dash-mtext">{{ __('System Analytics') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('telescope*') ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('telescope') }}">{{ __('Telescope Dashboard') }}</a>
                            </li>
                        </ul>
                    </li> --}}
                @endif
                @if ($users->type == 'Super Admin')
                    @canany(['manage-user', 'manage-role'])
                        <li
                            class="dash-item dash-hasmenu {{ request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-layout-2"></i></span><span
                                    class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                @can('manage-user')
                                    <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                        <a class="dash-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                    </li>
                                @endcan
                                @can('manage-role')
                                    <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                        <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                  {{--  --}}
              
        
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('landingpage-setting*') ||
                        request()->is('faqs*') ||
                        request()->is('testimonial*') ||
                        request()->is('pagesetting*')
                            ? 'active dash-trigger'
                            : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Frontend Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-landingpage')
                                <li class="dash-item {{ request()->is('landingpage-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('landingpage.setting') }}">{{ __('Landing Page') }}</a>
                                </li>
                            @endcan
                            @can('manage-faqs')
                                <li class="dash-item {{ request()->is('faqs*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('faqs.index') }}">{{ __('Faqs') }}</a>
                                </li>
                            @endcan
                            @can('manage-testimonial')
                                <li class="dash-item {{ request()->is('testimonial*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('testimonial.index') }}">{{ __('Testimonials') }}</a>
                                </li>
                            @endcan
                            <li class="dash-item {{ request()->is('pagesetting*') ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('pagesetting.index') }}">{{ __('Page Settings') }}</a>
                            </li>
                        </ul>
                    </li>
                    @canany(['manage-setting', 'manage-email-template', 'manage-sms-template'])
                        <li
                            class="dash-item dash-hasmenu {{ request()->is('email-template*') || request()->is('sms-template*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-apps"></i></span><span
                                    class="dash-mtext">{{ __('Account Setting') }}</span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                @can('manage-email-template')
                                    <li class="dash-item {{ request()->is('email-template*') ? 'active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('email-template.index') }}">{{ __('Email Templates') }}</a>
                                    </li>
                                @endcan
                                @can('manage-sms-template')
                                    <li class="dash-item {{ request()->is('sms-template*') ? 'active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('sms-template.index') }}">{{ __('Sms Templates') }}</a>
                                    </li>
                                @endcan
                                @can('manage-setting')
                                    <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                        <a class="dash-link" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif
            </ul>
        </div>
    </div>
</nav>
