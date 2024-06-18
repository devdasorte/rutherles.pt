@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Email verify'))
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
            <h3>{{ __('Verify Your Email Address') }}</h3>
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <p>{{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},</p>
        <br>
        <div class="text-center">
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="mt-2 btn btn-link">{{ __('Resend Verification Email') }}</button>
            </form>
            <p class="my-3 text-center">
                <button type="submit" class="mt-2 btn btn-link">
                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                        class="f-w-400">
                        {{ __('Logout') }}
                    </a>
                </button>
            </p>
            {!! Form::open([
                'route' => 'logout',
                'method' => 'POST',
                'id' => 'logout-form',
                'class' => 'd-none',
            ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
