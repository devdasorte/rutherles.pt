@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
    $user = Auth::user();
@endphp
@extends('layouts.app')
@section('title', __('Sign in'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="current"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', $language) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="login-content-inner">
        <div class="login-title">
            <h3>{{ __('Sign In') }}</h3>
        </div>
        {{ Form::open(['route' => ['login'], 'method' => 'POST', 'data-validate', 'class' => 'needs-validation']) }}
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">{{ __('Email Address') }}</label>
            <input type="email" id="email" class="form-control" placeholder="{{ __('Enter email address') }}"
                name="email" tabindex="1" required autocomplete="email" autofocus>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">{{ __('Enter Password') }}</label>
            <a href="{{ route('password.request') }}" class="float-end forget-password">
                {{ __('Forgot Password ?') }}
            </a>
            <input id="password" type="password" class="form-control" placeholder="{{ __('Enter password') }}"
                name="password" tabindex="2" required autocomplete="current-password">
        </div>

        @if (Utility::getsettings('login_recaptcha_status') == '1')
            <div class="text-center">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
            </div>
        @endif

        <div class="d-grid">
            {{ Form::button(__('Sign In'), ['type' => 'submit', 'class' => 'mt-2 btn btn-primary btn-block']) }}
        </div>
        {{ Form::close() }}

        @if (tenant() && Utility::getsettings('register_setting') == '99')
            <div class="create_user text-center mt-4 text-muted text-page">
                {{ __('Do not have an account ?') }}
                <a href="{{ route('register') }}">{{ __('Create One') }}</a>
            </div>
        @endif

        @if (Utility::getsettings('googlesetting') == 'on' ||
                Utility::getsettings('facebooksetting') == 'on' ||
                Utility::getsettings('githubsetting') == 'on')
            <div class="register-option text-page">
                <p>{{ __('or register with') }}</p>
            </div>
        @endif

        <div class="social-media-icon">
            @if (Utility::getsettings('googlesetting') == 'on')
                <div>
                    <a href="{{ url('/redirect/google') }}"><img src="{{ asset('assets/images/auth/img-google.svg') }}">
                    </a>
                </div>
            @endif
            @if (Utility::getsettings('facebooksetting') == 'on')
                <div>
                    <a href="{{ url('/redirect/facebook') }}"><img
                            src="{{ asset('assets/images/auth/img-facebook.svg') }}">
                    </a>
                </div>
            @endif
            @if (Utility::getsettings('githubsetting') == 'on')
                <div>
                    <a href="{{ url('/redirect/github') }}"><img src="{{ asset('assets/images/auth/github.svg') }}"></a>
                </div>
            @endif
        </div>
    </div>
@endsection
