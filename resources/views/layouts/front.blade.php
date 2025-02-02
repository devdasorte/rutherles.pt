@php
    $users = App\Models\user::where('tenant_id', tenant('id'))->first();
    $lang = App\Facades\UtilityFacades::getActiveLanguage();
    \App::setLocale($lang);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' || $lang == 'ar' ? 'rtl' : '' }}">
<head>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
        content="{{ !empty(Utility::getsettings('meta_title'))
            ? Utility::getsettings('meta_title')
            : 'Full Multi Tenancy Laravel Admin Saas' }}">
    <meta name="keywords"
        content="{{ !empty(Utility::getsettings('meta_keywords'))
            ? Utility::getsettings('meta_keywords')
            : 'Full Multi Tenancy Laravel Admin Saas,Multi Domains,Multi Databases' }}">
    <meta name="description"
        content="{{ !empty(Utility::getsettings('meta_description'))
            ? Utility::getsettings('meta_description')
            : 'Discover the efficiency of Full Multi Tenancy, a user-friendly web application by Quebix Apps.' }}">
    <meta property="og:image"
        src="{{ !empty(Utility::getsettings('meta_image_logo'))
            ? Utility::getpath(Utility::getsettings('meta_image_logo'))
            : Storage::url('seeder-image/meta-image-logo.jpg') }}">

    <title>@yield('title') | {{ Utility::getsettings('app_name') }}</title>
    <link rel="icon"
        href="{{ Utility::getsettings('favicon_logo') ? Utility::getpath('logo/app-favicon-logo.png') : asset('assets/images/logo/app-favicon-logo.png') }}"
        type="image/png">

    @if (Utility::getsettings('seo_setting') == 'on')
        {!! app('seotools')->generate() !!}
    @endif

    {{-- Payment Coupon Checkbox --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage-2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage2-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/custom.css') }}">
    @stack('css')
</head>

<body class="light">
    <div class="auth-wrapper auth-v3">

        <div class="login-page-wrapper">
            <div class="login-container">
                <div class="login-row d-flex">
                    <div class="login-col-6">
                        @yield('content')
                    </div>
                    <div class="login-media-col">
                        <div class="login-media-inner">
                            @if (tenant('id') == null)
                                <img
                                    src="{{ Utility::getsettings('login_image')
                                        ? Storage::url(Utility::getsettings('login_image'))
                                        : asset('vendor/landing-page2/image/img-auth-3.svg') }}">
                            @else
                                <img
                                    src="{{ Utility::getsettings('login_image')
                                        ? Storage::url(tenant('id') . '/' . Utility::getsettings('login_image'))
                                        : asset('vendor/landing-page2/image/img-auth-3.svg') }}">
                            @endif
                            <h3>
                                {{ Utility::getsettings('login_name') ? Utility::getsettings('login_name') : __('“Seu novo Painel”') }}
                            </h3>
                            <p>
                                {{ Utility::getsettings('login_detail')
                                    ? Utility::getsettings('login_detail')
                                    : __('Gerencie suas campanhas e clientes da melhor forma') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="{{ asset('vendor/landing-page2/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/landing-page2/js/slick.min.js') }}"></script>
{{-- tostr notification close --}}
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
{{-- notification , alert pop-up --}}
<script src="{{ asset('vendor/notifier/bootstrap-notify.min.js') }}"></script>
{{-- Form-validation  --}}
<script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('vendor/landing-page2/js/custom.js') }}"></script>
<script>
    function myFunction() {
        const element = document.body;
        element.classList.toggle("dark-mode");
        const isDarkMode = element.classList.contains("dark-mode");
        const expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 30);
        document.cookie = `mode=${isDarkMode ? "dark" : "light"}; expires=${expirationDate.toUTCString()}; path=/`;
        if (isDarkMode) {
            $('.switch-toggle').find('.switch-moon').addClass('d-none');
            $('.switch-toggle').find('.switch-sun').removeClass('d-none');
        } else {
            $('.switch-toggle').find('.switch-sun').addClass('d-none');
            $('.switch-toggle').find('.switch-moon').removeClass('d-none');
        }
    }
    window.addEventListener("DOMContentLoaded", () => {
        const modeCookie = document.cookie.split(";").find(cookie => cookie.includes("mode="));
        if (modeCookie) {
            const mode = modeCookie.split("=")[1];
            if (mode === "dark") {
                $('.switch-toggle').find('.switch-moon').addClass('d-none');
                $('.switch-toggle').find('.switch-sun').removeClass('d-none');
                document.body.classList.add("dark-mode");
            } else {
                $('.switch-toggle').find('.switch-sun').addClass('d-none');
                $('.switch-toggle').find('.switch-moon').removeClass('d-none');
            }
        }
    });
</script>

@include('layouts.includes.alerts')
@stack('javascript')

</body>

@if (Utility::getsettings('cookie_setting_enable') == 'on')
    @include('layouts.cookie-consent')
@endif

</html>
