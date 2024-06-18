@php
    $lang = Utility::getValByName('default_language');
    $primary_color = Utility::getsettings('color');
    if (isset($primary_color)) {
        $color = $primary_color;
    } else {
        $color = 'theme-4';
    }
@endphp
@extends('layouts.main')
@section('title', __('Settings'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top stick-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#app_setting" class="border-0 list-group-item list-group-item-action">
                                {{ __('App Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#general_setting" class="border-0 list-group-item list-group-item-action">
                                {{ __('General Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#domainconfig_setting" class="border-0 list-group-item list-group-item-action">
                                {{ __('Domain Configuration Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#storage_setting" class="border-0 list-group-item list-group-item-action">
                                {{ __('Storage Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#email_setting" class="border-0 list-group-item list-group-item-action">
                                {{ __('Email Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#cookie_setting" class="list-group-item list-group-item-action border-0">
                                {{ __('Cookie Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#cache_setting" class="list-group-item list-group-item-action border-0">
                                {{ __('Cache Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#seo_setting" class="list-group-item list-group-item-action border-0">
                                {{ __('SEO Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#notification_setting" class="list-group-item list-group-item-action border-0">
                                {{ __('Notification Setting') }}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>
                            @if (\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin')
                                <a href="#payment_setting" class="border-0 list-group-item list-group-item-action">
                                    {{ __('Payment Setting') }}
                                    <div class="float-end">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="app_setting">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('App Setting') }}</h5>
                            </div>
                            {!! Form::open([
                                'route' => 'settings.appname.update',
                                'method' => 'Post',
                                'enctype' => 'multipart/form-data',
                                'data-validate',
                            ]) !!}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('App Dark Logo') }}</h5>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="{{ Utility::getpath(Utility::getsettings('app_dark_logo')) }}"
                                                            target="_blank">
                                                            <img src="{{ Utility::getpath(Utility::getsettings('app_dark_logo')) }}"
                                                                id="app_dark">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="app_dark_logo">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            {{ Form::file('app_dark_logo', ['class' => 'form-control file', 'id' => 'app_dark_logo', 'onchange' => "document.getElementById('app_dark').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_dark_logo']) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('App Light Logo') }}</h5>
                                            </div>
                                            <div class="pt-0 card-body bg-primary">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content light-logo-content">
                                                        <a href="{{ Utility::getpath(Utility::getsettings('app_logo')) }}"
                                                            target="_blank">
                                                            <img src="{{ Utility::getpath(Utility::getsettings('app_logo')) }}"
                                                                id="app_light">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="app_logo">
                                                            <div class="company_logo_update w-logo"> <i
                                                                    class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            {{ Form::file('app_logo', ['class' => 'form-control file', 'id' => 'app_logo', 'onchange' => "document.getElementById('app_light').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_logo']) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('App Favicon Logo') }}</h5>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content">
                                                        <a href="{{ Utility::getpath(Utility::getsettings('favicon_logo')) }}"
                                                            target="_blank">
                                                            <img height="35px"
                                                                src="{{ Utility::getpath(Utility::getsettings('favicon_logo')) }}"
                                                                id="app_favicon">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="favicon_logo">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            {{ Form::file('favicon_logo', ['class' => 'form-control file', 'id' => 'favicon_logo', 'onchange' => "document.getElementById('app_favicon').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'favicon_logo']) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('app_name', __('Application Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('app_name', Utility::getsettings('app_name'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter application name'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary ']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="general_setting">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('General Setting') }}</h5>
                            </div>
                            {!! Form::open([
                                'route' => 'settings.auth.settings.update',
                                'method' => 'Post',
                                'data-validate',
                            ]) !!}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <strong class="d-block">{{ __('Two Factor Authentication') }}</strong>
                                                    {{ !Utility::getsettings('2fa') ? 'Activate' : 'Deactivate' }}
                                                    {{ __('Two Factor Authentication') }}
                                                </div>
                                                <div class="col-sm-4 text-end">
                                                    {!! Form::checkbox('two_factor_auth', null, Utility::getsettings('2fa') ? true : false, [
                                                        'data-toggle' => 'switchbutton',
                                                        'data-onstyle' => 'primary',
                                                    ]) !!}
                                                </div>
                                                @if (!extension_loaded('imagick'))
                                                    <small>
                                                        {{ __('Note: for 2FA your server must have Imagick.') }} <a
                                                            href="https://www.php.net/manual/en/book.imagick.php"
                                                            target="_new">{{ __('Imagick Document') }}</a>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <strong class="d-block">{{ __('Database Permission') }}</strong>
                                                    {{ Utility::getsettings('database_permission') == '0' ? __('Activate') : __('Deactivate') }}
                                                    {{ __('To Automatically Generate a User Database.') }}
                                                </div>
                                                <div class="col-sm-4 text-end">
                                                    {!! Form::checkbox(
                                                        'database_permission',
                                                        null,
                                                        Utility::getsettings('database_permission') == 1 ? true : false,
                                                        [
                                                            'data-toggle' => 'switchbutton',
                                                            'data-onstyle' => 'primary',
                                                        ],
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <strong class="d-block">{{ __('Landing Page Setting') }}</strong>
                                                    {{ Utility::getsettings('landing_page_status') == '1' ? __('Deactivate') : __('Activate') }}
                                                    {{ __('Landing Page For Application.') }}
                                                </div>
                                                <div class="col-sm-4 text-end">
                                                    {!! Form::checkbox(
                                                        'landing_page_status',
                                                        null,
                                                        Utility::getsettings('landing_page_status') == 1 ? true : false,
                                                        [
                                                            'data-toggle' => 'switchbutton',
                                                            'data-onstyle' => 'primary',
                                                        ],
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <strong class="d-block">{{ __('RTL Setting') }}</strong>
                                                    {{ Utility::getsettings('rtl') == '0' ? __('Activate') : __('Deactivate') }}
                                                    {{ __('Rtl Setting For Application.') }}
                                                </div>
                                                <div class="col-sm-4 text-end">
                                                    {!! Form::checkbox('rtl_setting', null, Utility::getsettings('rtl') == '1' ? true : false, [
                                                        'data-toggle' => 'switchbutton',
                                                        'data-onstyle' => 'primary',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="my-3">{{ __('Theme Customizer') }}</h5>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6>
                                                        <i data-feather="credit-card"
                                                            class="me-2"></i>{{ __('Primary color Settings') }}
                                                    </h6>
                                                    <hr class="my-2">
                                                    <div class="theme-color themes-color">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                            data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-1">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-2' ? 'active_color' : '' }} "
                                                            data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-2">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                            data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-3">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                            data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-4">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-5' ? 'active_color' : '' }}"
                                                            data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-5">
                                                        <br>
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-6' ? 'active_color' : '' }}"
                                                            data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-6">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-7' ? 'active_color' : '' }}"
                                                            data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-7">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-8' ? 'active_color' : '' }}"
                                                            data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-8">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-9' ? 'active_color' : '' }}"
                                                            data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-9">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-10' ? 'active_color' : '' }}"
                                                            data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                        <input type="radio" class="theme_color tm-color" name="color"
                                                            value="theme-10">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6>
                                                        <i data-feather="layout"
                                                            class="me-2"></i>{{ __('Sidebar Settings') }}
                                                    </h6>
                                                    <hr class="my-2">
                                                    <div class="form-check form-switch">
                                                        {!! Form::checkbox(
                                                            'transparent_layout',
                                                            null,
                                                            Utility::getsettings('transparent_layout') == '1' ? true : false,
                                                            [
                                                                'id' => 'cust-theme-bg',
                                                                'class' => 'form-check-input',
                                                            ],
                                                        ) !!}
                                                        {!! Form::label('cust-theme-bg', __('Transparent layout'), ['class' => 'form-check-label f-w-600 pl-1 me-2']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6>
                                                        <i data-feather="sun"
                                                            class="me-2"></i>{{ __('Layout Settings') }}
                                                    </h6>
                                                    <hr class="my-2">
                                                    <div class="mt-2 form-check form-switch">
                                                        {!! Form::checkbox('dark_mode', null, Utility::getsettings('dark_mode') == 'on' ? true : false, [
                                                            'id' => 'cust-darklayout',
                                                            'class' => 'form-check-input',
                                                        ]) !!}
                                                        {!! Form::label('cust-darklayout', __('Dark Layout'), ['class' => 'form-check-label f-w-600 pl-1 me-2']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                            <select class="form-control" data-trigger name="default_language"
                                                id="default_language"
                                                placeholder="{{ __('This is a search placeholder') }}">
                                                @foreach (Utility::languages() as $language)
                                                    <option @if ($lang == $language) selected @endif
                                                        value="{{ $language }}">
                                                        {{ Str::upper($language) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('date_format', __('Date Format'), ['class' => 'form-label']) }}
                                            <select name="date_format" class="form-control" id="date_format"
                                                data-trigger>
                                                <option value="M j, Y"
                                                    {{ Utility::getsettings('date_format') == 'M j, Y' ? 'selected' : '' }}>
                                                    {{ __('Jan 1, 2020') }}</option>
                                                <option value="d-M-y"
                                                    {{ Utility::getsettings('date_format') == 'd-M-y' ? 'selected' : '' }}>
                                                    {{ __('01-Jan-20') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('time_format', __('Time Format'), ['class' => 'form-label']) }}
                                            <select name="time_format" class="form-control" id="time_format"
                                                data-trigger>
                                                <option value="g:i A"
                                                    {{ Utility::getsettings('time_format') == 'g:i A' ? 'selected' : '' }}>
                                                    {{ __('hh:mm AM/PM') }}</option>
                                                <option value="H:i:s"
                                                    {{ Utility::getsettings('time_format') == 'H:i:s' ? 'selected' : '' }}>
                                                    {{ __('HH:mm:ss') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if (\Auth::user()->type == 'Super Admin')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('gtag', __('Gtag Tracking ID'), ['class' => 'form-label']) }}
                                                {!! Html::link(
                                                    'https://support.google.com/analytics/answer/1008080?hl=en#zippy=%2Cin-this-article',
                                                    __('Document'),
                                                    ['target' => '_blank'],
                                                ) !!}
                                                {!! Form::text('gtag', Utility::getsettings('gtag'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter gtag tracking id'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="domainconfig_setting">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Domain Configuration Setting') }}</h5>
                                <small class="text-muted">{{ __('Domain Configuration') }}</small>
                            </div>
                            {!! Form::open([
                                'route' => 'settings.domain.config.setting.update',
                                'method' => 'Post',
                                'data-validate',
                            ]) !!}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-sm">
                                            {{ __('Note: if you want to use it on sub domain the check it otherwise unchecked for use other domain') }}
                                        </p>
                                        <div class="alert alert-info">
                                            <div class="app-image-set">
                                                <a>
                                                    <img src="{{ Utility::getpath('seeder-image/domain-config.png') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                {{ Form::label('domain_config', __('Domain Config'), ['class' => 'form-label']) }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <label class="form-switch custom-switch-v1">
                                                    {!! Form::checkbox('domain_config', null, Utility::getsettings('domain_config') == 'on' ? true : false, [
                                                        'class' => 'form-check-input',
                                                        'id' => 'domain_config',
                                                    ]) !!}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group main-domain {{ Utility::getsettings('domain_config') == 'on' ? 'd-block' : 'd-none' }}">
                                            {{ Form::label('main_domain', __('Main Domain'), ['class' => 'form-label']) }}
                                            {!! Form::text('main_domain', env('APP_URL'), [
                                                'class' => 'form-control',
                                                'readonly',
                                                'disabled',
                                                'placeholder' => __('Enter main domain'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="storage_setting">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Storage Setting') }}</h5>
                                <small class="text-muted">{{ __('Aws,S3 Storage Configuration') }}</small>
                            </div>
                            {!! Form::open([
                                'route' => 'settings.s3.setting.update',
                                'method' => 'Post',
                                'data-validate',
                            ]) !!}
                            <div class="card-body">
                                <small
                                class="text">{{ __('Notes: If you Add S3 & wasabi Storage settings you have to store images First.') }}</small>
                                <div class="form-group mt-2">
                                    <div class="d-flex">
                                        <div class="pe-2">
                                            {!! Form::radio('storage_type', 'local', Utility::getsettings('storage_type') == 'local' ? true : false, [
                                                'class' => 'btn-check',
                                                'id' => 'local-outlined',
                                            ]) !!}
                                            {!! Form::label('local-outlined', __('Local'), ['class' => 'btn btn-outline-primary']) !!}
                                        </div>
                                        <div class="pe-2">
                                            {!! Form::radio('storage_type', 's3', Utility::getsettings('storage_type') == 's3' ? true : false, [
                                                'class' => 'btn-check',
                                                'id' => 's3-outlined',
                                            ]) !!}
                                            {!! Form::label('s3-outlined', __('AWS S3'), ['class' => 'btn btn-outline-primary']) !!}
                                        </div>

                                        <div class="pe-2">
                                            {!! Form::radio('storage_type', 'wasabi', Utility::getsettings('storage_type') == 'wasabi' ? true : false, [
                                                'class' => 'btn-check',
                                                'id' => 'wasabi-outlined',
                                            ]) !!}
                                            {!! Form::label('wasabi-outlined', __('Wasabi'), ['class' => 'btn btn-outline-primary']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div
                                            class="local-setting {{ Utility::getsettings('storage_type') == 'local' ? 'block' : 'd-none' }}">
                                        </div>
                                        <div
                                            class="s3-setting {{ Utility::getsettings('storage_type') == 's3' ? 'block' : 'd-none' }}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_key', __('S3 Key'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_key', Utility::getsettings('s3_key'), [
                                                            'placeholder' => __('Enter s3 key'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_secret', __('S3 Secret'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_secret', Utility::getsettings('s3_secret'), [
                                                            'placeholder' => __('Enter s3 secret'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_region', __('S3 Region'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_region', Utility::getsettings('s3_region'), [
                                                            'placeholder' => __('Enter s3 region'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_bucket', __('S3 Bucket'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_bucket', Utility::getsettings('s3_bucket'), [
                                                            'placeholder' => __('Enter s3 bucket'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_url', __('S3 URL'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_url', Utility::getsettings('s3_url'), [
                                                            'placeholder' => __('Enter s3 url'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('s3_endpoint', __('S3 Endpoint'), ['class' => 'form-label']) }}
                                                        {!! Form::text('s3_endpoint', Utility::getsettings('s3_endpoint'), [
                                                            'placeholder' => __('Enter s3 endpoint'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="wasabi-setting {{ Utility::getsettings('storage_type') == 'wasabi' ? 'block' : 'd-none' }}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_key', __('Wasabi Key'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_key', Utility::getsettings('wasabi_key'), [
                                                            'placeholder' => __('Enter wasabi key'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_secret', __('Wasabi Secret'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_secret', Utility::getsettings('wasabi_secret'), [
                                                            'placeholder' => __('Enter wasabi secret'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_region', __('Wasabi Region'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_region', Utility::getsettings('wasabi_region'), [
                                                            'placeholder' => __('Enter wasabi region'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_bucket', __('Wasabi Bucket'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_bucket', Utility::getsettings('wasabi_bucket'), [
                                                            'placeholder' => __('Enter wasabi bucket'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_url', __('Wasabi URL'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_url', Utility::getsettings('wasabi_url'), [
                                                            'placeholder' => __('Enter wasabi url'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('wasabi_root', __('Wasabi Endpoint'), ['class' => 'form-label']) }}
                                                        {!! Form::text('wasabi_root', Utility::getsettings('wasabi_root'), [
                                                            'placeholder' => __('Enter wasabi endpoint'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="email_setting">
                        <div class="card">
                            <div class="card-header">
                                {!! Form::open([
                                    'route' => 'settings.email.setting.update',
                                    'method' => 'Post',
                                    'data-validate',
                                ]) !!}
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5> {{ __('Email Setting') }}</h5>
                                        <small
                                            class="text-muted">{{ __('Email Smtp Settings, Notifications And Others Related To Email.') }}</small>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            {!! Form::checkbox(
                                                'email_setting_enable',
                                                null,
                                                Utility::getsettings('email_setting_enable') == 'on' ? true : false,
                                                [
                                                    'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_mailer', __('Mail Mailer'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_mailer', Utility::getsettings('mail_mailer'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail mailer'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_host', __('Mail Host'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_host', Utility::getsettings('mail_host'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail host'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_port', __('Mail Port'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_port', Utility::getsettings('mail_port'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail port'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_username', __('Mail Username'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_username', Utility::getsettings('mail_username'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail username'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_password', __('Mail Password'), ['class' => 'form-label']) }}
                                            <input class="form-control"
                                                value="{{ Utility::getsettings('mail_password') }}"
                                                placeholder="{{ __('Enter mail password') }}" name="mail_password"
                                                type="password" id="mail_password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_encryption', Utility::getsettings('mail_encryption'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail encryption'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_from_address', Utility::getsettings('mail_from_address'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail from address'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label']) }}
                                            {!! Form::text('mail_from_name', Utility::getsettings('mail_from_name'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail from name'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {!! Form::button(__('Send Test Mail'), [
                                        'class' => 'btn btn-info send_mail float-start',
                                        'data-url' => route('test.mail'),
                                        'id' => 'test-mail',
                                    ]) !!}
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="cookie_setting">
                        <div class="card">
                            <div class="card-header">
                                {!! Form::open([
                                    'route' => 'settings.cookie.setting.update',
                                    'method' => 'Post',
                                    'data-validate',
                                ]) !!}
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5> {{ __('Cookie Setting') }}</h5>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            {!! Form::checkbox(
                                                'cookie_setting_enable',
                                                null,
                                                Utility::getsettings('cookie_setting_enable') == 'on' ? true : false,
                                                [
                                                    'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                            <input type="checkbox" name="cookie_logging"
                                                class="form-check-input input-primary cookie_setting" id="cookie_logging"
                                                {{ Utility::getsettings('cookie_logging') == 'on' ? ' checked ' : '' }}>
                                            <label class="form-check-label" for="cookie_logging">
                                                {{ __('Enable logging') }}
                                            </label>
                                        </div>
                                        <small class="text">
                                            {{ __('Notes: After enabling logging, user cookie data will be stored in CSV file.') }}
                                        </small>
                                        <div class="form-group mt-2">
                                            {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'form-label']) }}
                                            {!! Form::text('cookie_title', Utility::getsettings('cookie_title'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter cookie title'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('cookie_description', __('Cookie Description'), ['class' => 'form-label']) }}
                                            {!! Form::text('cookie_description', Utility::getsettings('cookie_description'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter cookie description'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1 my-2">
                                            <input type="checkbox" name="necessary_cookies"
                                                class="form-check-input input-primary cookie_setting"
                                                id="necessary_cookies"
                                                {{ Utility::getsettings('necessary_cookies') == 'on' ? ' checked ' : '' }}>
                                            <label class="form-check-label"
                                                for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('strictly_cookie_title', __('Strictly Cookie Title'), ['class' => 'form-label']) }}
                                            {!! Form::text('strictly_cookie_title', Utility::getsettings('strictly_cookie_title'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter strictly cookie title'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => 'form-label']) }}
                                            {!! Form::text('strictly_cookie_description', Utility::getsettings('strictly_cookie_description'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter strictly cookie description'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <h5> {{ __('More Information') }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('contact_us_description', __('Contact Us Description'), ['class' => 'form-label']) }}
                                            {!! Form::text('contact_us_description', Utility::getsettings('contact_us_description'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter contact us description'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('contact_us_url', __('Contact Us Url'), ['class' => 'form-label']) }}
                                            {!! Form::text('contact_us_url', Utility::getsettings('contact_us_url'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter contact us url'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        @if (Utility::getsettings('cookie_logging') == 'on')
                                            @if (Storage::url('cookie-csv/cookie_data.csv'))
                                                <label for="file"
                                                    class="form-label">{{ __('Download cookie accepted data') }}</label>
                                                <a href="{{ Storage::url('cookie-csv/cookie_data.csv') }}"
                                                    class="btn btn-primary mr-3">
                                                    <i class="ti ti-download"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-6 text-end">
                                        <input class="btn btn-print-invoice btn-primary cookie_btn" type="submit"
                                            value="{{ __('Save') }}">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="cache_setting">
                        <div class="card">
                            <div class="card-header">
                                {!! Form::open([
                                    'route' => 'config.cache',
                                    'method' => 'Post',
                                    'data-validate',
                                ]) !!}
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5> {{ __('Cache Setting') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        {{ Form::label('Current cache size', __('Current cache size'), ['class' => 'col-form-label']) }}
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                value="{{ Utility::CacheSize() }}" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('MB') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Cache Clear'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="seo_setting">
                        <div class="card">
                            <div class="card-header">
                                {!! Form::open([
                                    'route' => 'setting.seo.save',
                                    'method' => 'Post',
                                    'enctype' => 'multipart/form-data',
                                    'data-validate',
                                ]) !!}
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5> {{ __('SEO Setting') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('meta_title', __('Meta Title'), ['class' => 'col-form-label']) }}
                                            {{ Form::text('meta_title', Utility::getsettings('meta_title'), ['class' => 'form-control ', 'required', 'placeholder' => 'Meta Title']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label']) }}
                                            {{ Form::textarea('meta_keywords', Utility::getsettings('meta_keywords'), ['class' => 'form-control ', 'required', 'placeholder' => 'Meta Keywords', 'rows' => 2]) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('meta_description', __('Meta Description'), ['class' => 'col-form-label']) }}
                                            {{ Form::textarea('meta_description', Utility::getsettings('meta_description'), ['class' => 'form-control ', 'required', 'placeholder' => 'Meta Description', 'rows' => 3]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label ms-4']) }}
                                            <div class="pt-0 card-body">
                                                <div class="setting_card">
                                                    <div class="logo-content">
                                                        <a href="{{ Utility::getsettings('meta_image_logo')
                                                        ? Utility::getpath(Utility::getsettings('meta_image_logo'))
                                                        : Storage::url('seeder-image/meta-image-logo.jpg') }}"
                                                            target="_blank">
                                                            <img id="meta-image-logo"
                                                                src="{{ Utility::getsettings('meta_image_logo')
                                                                ? Utility::getpath(Utility::getsettings('meta_image_logo'))
                                                                : Storage::url('seeder-image/meta-image-logo.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="mt-4 choose-files">
                                                        <label for="meta_image">
                                                            <div class="bg-primary logo input-img-div">
                                                                <i class="px-1 ti ti-upload"></i>
                                                                {{ __('Choose file here') }}
                                                                <input type="file"
                                                                    class="form-control file image-input"
                                                                    accept="image/png, image/gif, image/jpeg, image/jpg"
                                                                    id="meta_image" property="og:image"
                                                                    onchange="document.getElementById('meta-image-logo').src = window.URL.createObjectURL(this.files[0])"
                                                                    data-fileproperty="og:image">
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id="notification_setting">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Notifications Setting ') }}</h5>
                                <small
                                    class="text-muted">{{ __('Here you can setup and manage your integration settings.') }}</small>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive mt-0">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Title') }}</th>
                                                <th class="w-auto text-end">{{ __('Email') }}</th>
                                                <th class="w-auto text-end">{{ __('Notification') }}</th>
                                            </tr>
                                        </thead>
                                        @foreach ($notificationsSettings as $notificationsSetting)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <span name="title" class="form-control"
                                                                placeholder="Enter title"
                                                                value="{{ $notificationsSetting->id }}">
                                                                {{ $notificationsSetting->title }}</span>
                                                        </div>
                                                    </td>
                                                    @if ($notificationsSetting->email_notification != 2)
                                                        <td class="text-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                {!! Form::checkbox('email_notification', null, $notificationsSetting->email_notification == 1 ? true : false, [
                                                                    'class' => 'form-check-input chnageEmailNotifyStatus',
                                                                    'data-url' => route('notification.status.change', $notificationsSetting->id),
                                                                ]) !!}
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td class="text-end">
                                                        <div class="form-check form-switch d-inline-block">
                                                            {!! Form::checkbox('notify', null, $notificationsSetting->notify == 1 ? true : false, [
                                                                'class' => 'form-check-input chnageNotifyStatus',
                                                                'data-url' => route('notification.status.change', $notificationsSetting->id),
                                                            ]) !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin')
                        <div id="payment_setting">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Payment Settings') }}</h5>
                                </div>
                                {!! Form::open([
                                    'route' => 'settings.payment.setting.update',
                                    'method' => 'Post',
                                    'data-validate',
                                ]) !!}
                                <div class="card-body">
                                    <div class="faq justify-content-center">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {{ Form::label('currency', __('Currency'), ['class' => 'form-label']) }}
                                                    {!! Form::text('currency', Utility::getsettings('currency'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter currency'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {{ Form::label('currency_symbol', __('Currency Symbol'), ['class' => 'form-label']) }}
                                                    {!! Form::text('currency_symbol', Utility::getsettings('currency_symbol'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter currency symbol'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xxl-12">
                                                <div class="accordion accordion-flush" id="accordionExample">
                                                    <!-- Stripe -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                                aria-expanded="true" aria-controls="collapse1">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Stripe') }}
                                                                </span>
                                                                @if (Utility::getsettings('stripesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse"
                                                            aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'stripe', Utility::getsettings('stripesetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'is_stripe_enabled',
                                                                            ]) !!}
                                                                            {{ Form::label('is_stripe_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('stripe_key', __('Stripe Key'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('stripe_key', Utility::getsettings('stripe_key'), ['class' => 'form-control', 'placeholder' => __('Enter stripe key')]) }}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('stripe_secret', __('Stripe Secret'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('stripe_secret', Utility::getsettings('stripe_secret'), ['class' => 'form-control ', 'placeholder' => __('Enter stripe secret')]) }}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('stripe_description', __('Stripe Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('stripe_description', Utility::getsettings('stripe_description'), ['class' => 'form-control ', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Razorpay -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                                aria-expanded="true" aria-controls="collapse2">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Razorpay') }}
                                                                </span>
                                                                @if (Utility::getsettings('razorpaysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse"
                                                            aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'razorpay',
                                                                                Utility::getsettings('razorpaysetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_razorpay_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_razorpay_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('razorpay_key', __('Razorpay Key'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('razorpay_key', Utility::getsettings('razorpay_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter razorpay key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('razorpay_secret', __('Razorpay Secret'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('razorpay_secret', Utility::getsettings('razorpay_secret'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter razorpay secret'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('razorpay_description', __('Razorpay Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('razorpay_description', Utility::getsettings('razorpay_description'), ['class' => 'form-control ', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Paypal -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse3"
                                                                aria-expanded="true" aria-controls="collapse3">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Paypal') }}
                                                                </span>
                                                                @if (Utility::getsettings('paypalsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse"
                                                            aria-labelledby="heading-2-4"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'paypal', Utility::getsettings('paypalsetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'is_paypal_enabled',
                                                                            ]) !!}
                                                                            {{ Form::label('is_paypal_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Paypal Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        {!! Form::radio('paypal_mode', 'sandbox', env('PAYPAL_MODE') == 'sandbox' ? true : false, [
                                                                                            'class' => 'form-check-input',
                                                                                            'id' => 'Sandbox',
                                                                                        ]) !!}
                                                                                        {{ Form::label('Sandbox', __('Sandbox'), ['class' => 'form-check-label text-dark']) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        {!! Form::radio('paypal_mode', 'live', env('PAYPAL_MODE') == 'live' ? true : false, [
                                                                                            'class' => 'form-check-input',
                                                                                            'id' => 'Live',
                                                                                        ]) !!}
                                                                                        {{ Form::label('Live', __('Live'), ['class' => 'form-check-label text-dark']) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('client_id', __('Paypal Key'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text(
                                                                                'client_id',
                                                                                env('PAYPAL_MODE') == 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_ID') : env('PAYPAL_LIVE_CLIENT_ID'),
                                                                                [
                                                                                    'class' => 'form-control',
                                                                                    'placeholder' => __('Enter paypal key'),
                                                                                ],
                                                                            ) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('client_secret', __('Paypal Secret'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text(
                                                                                'client_secret',
                                                                                env('PAYPAL_MODE') == 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_SECRET') : env('PAYPAL_LIVE_CLIENT_SECRET'),
                                                                                [
                                                                                    'class' => 'form-control',
                                                                                    'placeholder' => __('Enter paypal secret'),
                                                                                ],
                                                                            ) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paypal_description', __('Paypal Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('paypal_description', Utility::getsettings('paypal_description'), ['class' => 'form-control ', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- FLUTTERWAVE -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse4"
                                                                aria-expanded="true" aria-controls="collapse4">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Flutterwave') }}
                                                                </span>
                                                                @if (Utility::getsettings('flutterwavesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse"
                                                            aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'flutterwave',
                                                                                Utility::getsettings('flutterwavesetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_flutterwave_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_flutterwave_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('flutterwave_key', __('Flutterwave Key'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('flutterwave_key', Utility::getsettings('flutterwave_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter flutterwave key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('flutterwave_secret', __('Flutterwave Secret'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('flutterwave_secret', Utility::getsettings('flutterwave_secret'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter flutterwave secret'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('flutterwave_description', __('Flutterwave Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('flutterwave_description', Utility::getsettings('flutterwave_description'), ['class' => 'form-control ', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- paystack -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading5">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse5"
                                                                aria-expanded="true" aria-controls="collapse5">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Paystack') }}
                                                                </span>
                                                                @if (Utility::getsettings('paystacksetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse5" class="accordion-collapse collapse"
                                                            aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'paystack',
                                                                                Utility::getsettings('paystacksetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_paystack_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_paystack_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('public_key', __('Paystack Public key'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('public_key', Utility::getsettings('paystack_public_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter public key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('secret_key', __('Paystack Secret key'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::text('secret_key', Utility::getsettings('paystack_secret_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter secret key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paystack_description', __('Paystack Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('paystack_description', Utility::getsettings('paystack_description'), ['class' => 'form-control', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paystack_currency', __('Paystack Currency'), ['class' => 'col-form-label']) }}
                                                                            <select name="paystack_currency"
                                                                                id="paystack_currency" data-trigger
                                                                                class="form-control">
                                                                                <option value="NGN">
                                                                                    {{ __('NGN') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Paytm -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading6">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse6"
                                                                aria-expanded="true" aria-controls="collapse6">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Paytm') }}
                                                                </span>
                                                                @if (Utility::getsettings('paytmsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse6" class="accordion-collapse collapse"
                                                            aria-labelledby="heading6" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'paytm', Utility::getsettings('paytmsetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'is_paytm_enabled',
                                                                            ]) !!}
                                                                            {{ Form::label('is_paytm_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Paytm Environment') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'paytm_environment',
                                                                                                'local',
                                                                                                Utility::getsettings('paytm_environment') == 'local' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Local') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'paytm_environment',
                                                                                                'production',
                                                                                                Utility::getsettings('paytm_environment') == 'production' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Production') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('merchant_id', __('Paytm Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('merchant_id', env('PAYTM_MERCHANT_ID'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter paytm id'),
                                                                            ]) !!}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('merchant_key', __('Paytm Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('merchant_key', env('PAYTM_MERCHANT_KEY'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter paytm key'),
                                                                            ]) !!}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paytm_description', __('Paytm Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('paytm_description', Utility::getsettings('paytm_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter description'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Coingate -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading7">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse7"
                                                                aria-expanded="true" aria-controls="collapse7">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Coingate') }}
                                                                </span>
                                                                @if (Utility::getsettings('coingatesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse7" class="accordion-collapse collapse"
                                                            aria-labelledby="heading7" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'coingate',
                                                                                Utility::getsettings('coingatesetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_coingate_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_coingate_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('CoinGate Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'coingate_mode',
                                                                                                'sandbox',
                                                                                                Utility::getsettings('coingate_environment') == 'sandbox' ? true : false,
                                                                                                ['class' => 'form-check-input'],
                                                                                            ) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('coingate_mode', 'live', Utility::getsettings('coingate_environment') == 'live' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Live') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('coingate_auth_token', __('CoinGate Auth Token'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('coingate_auth_token', Utility::getsettings('coingate_auth_token'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter coingate auth token'),
                                                                                'id' => 'coingate_auth_token',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('coingate_description', __('CoinGate Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('coingate_description', Utility::getsettings('coingate_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter description'),
                                                                            ]) !!}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- mercado -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading8">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse8"
                                                                aria-expanded="true" aria-controls="collapse8">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Mercado Pago') }}
                                                                </span>
                                                                @if (Utility::getsettings('mercadosetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse8" class="accordion-collapse collapse"
                                                            aria-labelledby="heading8" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'mercado',
                                                                                Utility::getsettings('mercadosetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_mercado_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_mercado_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Mercado Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('mercado_mode', 'sandbox', Utility::getsettings('mercado_mode') == 'sandbox' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('mercado_mode', 'live', Utility::getsettings('mercado_mode') == 'live' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Live') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mercado_access_token', __('Mercado Access Token'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('mercado_access_token', Utility::getsettings('mercado_access_token'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter access token'),
                                                                                'id' => 'mercado_access_token',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mercado_description', __('Mercado Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('mercado_description', Utility::getsettings('mercado_description'), [
                                                                                'class' => 'form-control ',
                                                                                'placeholder' => __('Enter description'),
                                                                            ]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- PayFast -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading9">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse9"
                                                                aria-expanded="true" aria-controls="collapse9">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('PayFast') }}
                                                                </span>
                                                                @if (Utility::getsettings('payfastsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse9" class="accordion-collapse collapse"
                                                            aria-labelledby="heading9" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'payfast',
                                                                                Utility::getsettings('payfastsetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_payfast_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_payfast_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Payfast Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('payfast_mode', 'sandbox', Utility::getsettings('payfast_mode') == 'sandbox' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('payfast_mode', 'live', Utility::getsettings('payfast_mode') == 'live' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Live') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payfast_signature', __('Payfast Signature'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('payfast_signature', Utility::getsettings('payfast_signature'), ['class' => 'form-control', 'placeholder' => __('Enter payfast signature')]) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payfast_merchant_id', __('Payfast Id'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('payfast_merchant_id', Utility::getsettings('payfast_merchant_id'), ['class' => 'form-control', 'placeholder' => __('Enter payfast id')]) }}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payfast_merchant_key', __('Payfast Key'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('payfast_merchant_key', Utility::getsettings('payfast_merchant_key'), ['class' => 'form-control ', 'placeholder' => __('Enter payfast key')]) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payfast_description', __('PayFast Description'), ['class' => 'col-form-label']) }}
                                                                            {{ Form::text('payfast_description', Utility::getsettings('payfast_description'), ['class' => 'form-control ', 'placeholder' => __('Enter description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Toyibpay -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading10">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse10"
                                                                aria-expanded="true" aria-controls="collapse10">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Toyyibpay') }}
                                                                </span>
                                                                @if (Utility::getsettings('toyyibpaysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse10" class="accordion-collapse collapse"
                                                            aria-labelledby="heading10"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'toyyibpay',
                                                                                Utility::getsettings('toyyibpaysetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_toyyibpay_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_toyyibpay_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('toyyibpay_secret_key', __('Toyyibpay Secret Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('toyyibpay_secret_key', Utility::getsettings('toyyibpay_secret_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter toyyibpay secret key'),
                                                                                'id' => 'toyyibpay_secret_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('toyyibpay_category_code', __('Toyyibpay Category Code'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('toyyibpay_category_code', Utility::getsettings('toyyibpay_category_code'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter toyyibpay category code'),
                                                                                'id' => 'toyyibpay_category_code',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('toyyibpay_description', __('Toyyibpay Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('toyyibpay_description', Utility::getsettings('toyyibpay_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter description'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Iyzipay -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading11">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse11"
                                                                aria-expanded="true" aria-controls="collapse11">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Iyzipay') }}
                                                                </span>
                                                                @if (Utility::getsettings('iyzipaysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse11" class="accordion-collapse collapse"
                                                            aria-labelledby="heading11"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'iyzipay',
                                                                                Utility::getsettings('iyzipaysetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_iyzipay_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_iyzipay_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Iyzipay Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('iyzipay_mode', 'sandbox', Utility::getsettings('iyzipay_mode') == 'sandbox' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'iyzipay_mode',
                                                                                                'production',
                                                                                                Utility::getsettings('iyzipay_mode') == 'production' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Production') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('iyzipay_key', __('Iyzipay Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('iyzipay_key', Utility::getsettings('iyzipay_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter iyzipay key'),
                                                                                'id' => 'iyzipay_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('iyzipay_secret', __('Iyzipay Secret'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('iyzipay_secret', Utility::getsettings('iyzipay_secret'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter iyzipay secret'),
                                                                                'id' => 'iyzipay_secret',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('iyzipay_description', __('Iyzipay Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('iyzipay_description', Utility::getsettings('iyzipay_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter description'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Sspay -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading12">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse12"
                                                                aria-expanded="true" aria-controls="collapse12">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('SSPay') }}
                                                                </span>
                                                                @if (Utility::getsettings('sspaysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse12" class="accordion-collapse collapse"
                                                            aria-labelledby="heading12"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'sspay', Utility::getsettings('sspaysetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'payment_sspay',
                                                                            ]) !!}
                                                                            {{ Form::label('payment_sspay', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('sspay_category_code', __('SSPay Category Code'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('sspay_category_code', Utility::getsettings('sspay_category_code'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter sspay category code'),
                                                                                'id' => 'sspay_category_code',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('sspay_secret_key', __('SSPay Secret Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('sspay_secret_key', Utility::getsettings('sspay_secret_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter sspay secret key'),
                                                                                'id' => 'sspay_secret_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('sspay_description', __('Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('sspay_description', Utility::getsettings('sspay_description'), ['class' => 'form-control ', 'placeholder' => __('Enter sspay description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Cashfree -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading13">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse13"
                                                                aria-expanded="true" aria-controls="collapse13">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Cashfree') }}
                                                                </span>
                                                                @if (Utility::getsettings('cashfreesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse13" class="accordion-collapse collapse"
                                                            aria-labelledby="heading13"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'cashfree',
                                                                                Utility::getsettings('cashfreesetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'payment_cashfree',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('payment_cashfree', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('Cashfree Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('cashfree_mode', 'sandbox', Utility::getsettings('cashfree_mode') == 'sandbox' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio('cashfree_mode', 'live', Utility::getsettings('cashfree_mode') == 'live' ? true : false, [
                                                                                                'class' => 'form-check-input',
                                                                                            ]) !!}{{ __('Live') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('cashfree_app_id', __('Cashfree App Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('cashfree_app_id', Utility::getsettings('cashfree_app_id'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter cashfree app id'),
                                                                                'id' => 'cashfree_app_id',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('cashfree_secret_key', __('Cashfree Secret Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('cashfree_secret_key', Utility::getsettings('cashfree_secret_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter cashfree secret key'),
                                                                                'id' => 'cashfree_secret_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('cashfree_description', __('Cashfree Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('cashfree_description', Utility::getsettings('cashfree_description'), ['class' => 'form-control ', 'placeholder' => __('Enter cashfree description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Aamarpay -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading14">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse14"
                                                                aria-expanded="true" aria-controls="collapse14">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Aamarpay') }}
                                                                </span>
                                                                @if (Utility::getsettings('aamarpaysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse14" class="accordion-collapse collapse"
                                                            aria-labelledby="heading14"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'aamarpay',
                                                                                Utility::getsettings('aamarpaysetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'payment_aamarpay',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('payment_aamarpay', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('aamarpay_store_id', __('Aamarpay Store Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('aamarpay_store_id', Utility::getsettings('aamarpay_store_id'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter aamarpay store id'),
                                                                                'id' => 'aamarpay_store_id',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('aamarpay_signature_key', __('Aamarpay Signature Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('aamarpay_signature_key', Utility::getsettings('aamarpay_signature_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter aamarpay signature key'),
                                                                                'id' => 'aamarpay_signature_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('aamarpay_description', __('Aamarpay Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('aamarpay_description', Utility::getsettings('aamarpay_description'), ['class' => 'form-control ', 'placeholder' => __('Enter aamarpay description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- PayUMoney -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading15">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse15"
                                                                aria-expanded="true" aria-controls="collapse15">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('PayUMoney') }}
                                                                </span>
                                                                @if (Utility::getsettings('payumoneysetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">
                                                                        {{ __('Active') }}
                                                                    </a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse15" class="accordion-collapse collapse"
                                                            aria-labelledby="heading15"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'payumoney',
                                                                                Utility::getsettings('payumoneysetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_payumoney_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_payumoney_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pb-4 col-md-12">
                                                                        <strong
                                                                            class="mb-2 d-block">{{ __('PayUMoney Mode') }}</strong>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'payumoney_mode',
                                                                                                'sandbox',
                                                                                                Utility::getsettings('payumoney_mode') == 'sandbox' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Sandbox') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="p-3 border card">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'payumoney_mode',
                                                                                                'production',
                                                                                                Utility::getsettings('payumoney_mode') == 'production' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Production') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payumoney_merchant_key', __('PayUMoney Merchant Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('payumoney_merchant_key', Utility::getsettings('payumoney_merchant_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter PayUMoney merchant key'),
                                                                                'id' => 'payumoney_merchant_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payumoney_salt_key', __('PayUMoney Salt Secret'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('payumoney_salt_key', Utility::getsettings('payumoney_salt_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter PayUMoney salt secret'),
                                                                                'id' => 'payumoney_salt_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('payumoney_description', __('PayUMoney Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('payumoney_description', Utility::getsettings('payumoney_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter PayUMoney description'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Paytab -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading16">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse16"
                                                                aria-expanded="true" aria-controls="collapse16">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Paytab') }}
                                                                </span>
                                                                @if (Utility::getsettings('paytabsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse16" class="accordion-collapse collapse"
                                                            aria-labelledby="heading16"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'paytab', Utility::getsettings('paytabsetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'payment_paytab',
                                                                            ]) !!}
                                                                            {{ Form::label('payment_paytab', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paytab_profile_id', __('Paytab Profile Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('paytab_profile_id', Utility::getsettings('paytab_profile_id'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter paytab profile id'),
                                                                                'id' => 'paytab_profile_id',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paytab_server_key', __('Paytab Server Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('paytab_server_key', Utility::getsettings('paytab_server_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter paytab server key'),
                                                                                'id' => 'paytab_server_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paytab_region', __('Paytab Region'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('paytab_region', Utility::getsettings('paytab_region'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter paytab region'),
                                                                                'id' => 'paytab_region',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('paytab_description', __('Paytab Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('paytab_description', Utility::getsettings('paytab_description'), ['class' => 'form-control ', 'placeholder' => __('Enter paytab description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Benefit -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading17">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse17"
                                                                aria-expanded="true" aria-controls="collapse17">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Benefit') }}
                                                                </span>
                                                                @if (Utility::getsettings('benefitsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse17" class="accordion-collapse collapse"
                                                            aria-labelledby="heading17"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'benefit',
                                                                                Utility::getsettings('benefitsetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'payment_benefit',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('payment_benefit', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('benefit_key', __('Benefit Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('benefit_key', Utility::getsettings('benefit_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter benefit key'),
                                                                                'id' => 'benefit_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('benefit_secret_key', __('Benefit Secret Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('benefit_secret_key', Utility::getsettings('benefit_secret_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter benefit secret key'),
                                                                                'id' => 'benefit_secret_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('benefit_description', __('Benefit Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('benefit_description', Utility::getsettings('benefit_description'), ['class' => 'form-control ', 'placeholder' => __('Enter benefit description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Mollie -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading18">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse18"
                                                                aria-expanded="true" aria-controls="collapse18">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Mollie') }}
                                                                </span>
                                                                @if (Utility::getsettings('molliesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">
                                                                        {{ __('Active') }}
                                                                    </a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse18" class="accordion-collapse collapse"
                                                            aria-labelledby="heading18"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'mollie', Utility::getsettings('molliesetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'payment_mollie',
                                                                            ]) !!}
                                                                            {{ Form::label('payment_mollie', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mollie_api_key', __('Mollie Api Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('mollie_api_key', Utility::getsettings('mollie_api_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter mollie api key'),
                                                                                'id' => 'mollie_api_key',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mollie_profile_id', __('Mollie Profile Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('mollie_profile_id', Utility::getsettings('mollie_profile_id'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter mollie profile id'),
                                                                                'id' => 'mollie_profile_id',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mollie_partner_id', __('Mollie Partner Id'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('mollie_partner_id', Utility::getsettings('mollie_partner_id'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter mollie partner id'),
                                                                                'id' => 'mollie_partner_id',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('mollie_description', __('Mollie Description'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('mollie_description', Utility::getsettings('mollie_description'), ['class' => 'form-control ', 'placeholder' => __('Enter mollie description')]) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Skrill -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading19">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse19"
                                                                aria-expanded="true" aria-controls="collapse19">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Skrill') }}
                                                                </span>
                                                                @if (Utility::getsettings('skrillsetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">
                                                                        {{ __('Active') }}
                                                                    </a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse19" class="accordion-collapse collapse"
                                                            aria-labelledby="heading19"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox('paymentsetting[]', 'skrill', Utility::getsettings('skrillsetting') == 'on' ? true : false, [
                                                                                'class' => 'form-check-input mx-2',
                                                                                'id' => 'payment_skrill',
                                                                            ]) !!}
                                                                            {{ Form::label('payment_skrill', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('skrill_email', __('Skrill Email'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('skrill_email', Utility::getsettings('skrill_email'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter skrill email'),
                                                                                'id' => 'skrill_email',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('skrill_description', __('Skrill Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('skrill_description', Utility::getsettings('skrill_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter skrill description'),
                                                                                'id' => 'skrill_description',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Esebuzz -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading20">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse20"
                                                                aria-expanded="true" aria-controls="collapse20">
                                                                <span class="d-flex align-items-center flex-1">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Esebuzz') }}
                                                                </span>
                                                                @if (Utility::getsettings('easebuzzsetting') == 'on')
                                                                    <a
                                                                        class="btn btn-sm btn-primary float-end me-3 text-white">
                                                                        {{ __('Active') }}
                                                                    </a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse20" class="accordion-collapse collapse"
                                                            aria-labelledby="heading-20"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="col-6 py-2">
                                                                    </div>
                                                                    <div class="col-6 py-2 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'easebuzz',
                                                                                Utility::getsettings('easebuzzsetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2 paymenttsetting',
                                                                                    'id' => 'is_easebuzz_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_easebuzz_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 pb-4">
                                                                        {{ Form::label('easebuzz_environments', __('Easebuzz Environment'), ['class' => 'form-label']) }}
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2 pay-method">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'easebuzz_environment',
                                                                                                'local',
                                                                                                Utility::getsettings('easebuzz_environment') == 'local' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Local') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            {!! Form::radio(
                                                                                                'easebuzz_environment',
                                                                                                'production',
                                                                                                Utility::getsettings('easebuzz_environment') == 'production' ? true : false,
                                                                                                [
                                                                                                    'class' => 'form-check-input',
                                                                                                ],
                                                                                            ) !!}{{ __('Production') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('easebuzz_merchant_key', __('Easebuzz Merchant Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('easebuzz_merchant_key', Utility::getsettings('easebuzz_merchant_key'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter Easebuzz Merchant Key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('easebuzz_salt', __('Easebuzz Salt Key'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('easebuzz_salt', Utility::getsettings('easebuzz_salt'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter Easebuzz Salt Key'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            {{ Form::label('easebuzz_description', __('Easebuzz Description'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('easebuzz_description', Utility::getsettings('easebuzz_description'), [
                                                                                'class' => 'form-control',
                                                                                'placeholder' => __('Enter Easebuzz description'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- OFFLINE -->
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading100">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse100"
                                                                aria-expanded="true" aria-controls="collapse100">
                                                                <span class="flex-1 d-flex align-items-center">
                                                                    <i class="ti ti-credit-card text-primary"></i>
                                                                    {{ __('Offline') }}
                                                                </span>
                                                                @if (Utility::getsettings('offlinesetting') == 'on')
                                                                    <a
                                                                        class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="collapse100" class="accordion-collapse collapse"
                                                            aria-labelledby="heading100"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="py-2 col-12 text-end">
                                                                        <div
                                                                            class="form-check form-switch d-inline-block">
                                                                            {!! Form::checkbox(
                                                                                'paymentsetting[]',
                                                                                'offline',
                                                                                Utility::getsettings('offlinesetting') == 'on' ? true : false,
                                                                                [
                                                                                    'class' => 'form-check-input mx-2',
                                                                                    'id' => 'is_offline_enabled',
                                                                                ],
                                                                            ) !!}
                                                                            {{ Form::label('is_offline_enabled', __('Enable'), ['class' => 'form-check-label']) }}
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="form-group">
                                                                            {{ Form::label('payment_details', __('Payment Details'), ['class' => 'col-form-label']) }}
                                                                            {!! Form::textarea('payment_details', Utility::getsettings('payment_details'), [
                                                                                'class' => 'form-control',
                                                                                'rows' => '3',
                                                                                'placeholder' => __('Enter payment details'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        });

        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });

        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        // theme color
        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];
            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }

        // transparent card
        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });

        // dark layout
        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document.querySelector(".m-headers > .b-brand > img").setAttribute("src",
                    "{{ Utility::getpath('logo/app-logo.png') }}");
                document.querySelector("#main-style-link").setAttribute("href",
                    "{{ asset('assets/css/style-dark.css') }}");
            } else {
                document.querySelector(".m-headers > .b-brand > img").setAttribute("src",
                    "{{ Utility::getpath('logo/app-dark-logo.png') }}");
                document.querySelector("#main-style-link").setAttribute("href",
                    "{{ asset('assets/css/style.css') }}");
            }
        });

        $(document).on('change', 'input[name="domain_config"]', function() {
            if ($(this).is(':checked')) {
                $('.main-domain').addClass('d-block');
                $('.main-domain').removeClass('d-none');
            } else {
                $('.main-domain').addClass('d-none');
                $('.main-domain').removeClass('d-block');
            }
        });

        $('body').on('click', '.send_mail', function() {
            var action = $(this).data('url');
            var modal = $('#common_modal');
            $.get(action, function(response) {
                modal.find('.modal-title').html('{{ __('Test Mail') }}');
                modal.find('.body').html(response);
                modal.modal('show');
            })
        });
        $(document).on('click', "input[name='storage_type']", function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });

        // change notification status
        $(document).on("change", ".chnageEmailNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var email = $(this).parent().find("input[name=email_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'email',
                    email_notification: email,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
        $(document).on("change", ".chnagesmsNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var sms = $(this).parent().find("input[name=sms_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'sms',
                    sms_notification: sms,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
        $(document).on("change", ".chnageNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var notify = $(this).parent().find("input[name=notify]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'notify',
                    notify: notify,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
    </script>
@endpush
