@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
@endphp
@extends('layouts.app')
@section('title', __('Forgot Password'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('change.lang', $language) }}">{{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="login-content-inner">
        <div class="login-title">
            <h3>{{ __('Forgot Password') }}</h3>
        </div>
        {!! Form::open([
            'route' => 'password.email',
            'method' => 'POST',
            'class' => 'needs-validation',
            'data-validate',
        ]) !!}
        <div class="form-group">
            {{ Form::label('email', __('E-mail address'), ['class' => 'form-label']) }}
            {!! Form::email('email', null, [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => __('E-mail Address'),
                'tabindex' => '1',
                'required',
                'autocomplete' => 'email',
                'autofocus',
            ]) !!}
        </div>
        @if (Utility::getsettings('login_recaptcha_status') == '1')
            <div class="my-3 text-center">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
            </div>
        @endif
        <div class="text-center">
            {{ Form::button(__('Email Password Reset Link'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            <a href="{{ route('home') }}" class="mt-2 text-white btn btn-secondary">{{ __('Back') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

