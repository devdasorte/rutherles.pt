@php
    $languages = \App\Facades\UtilityFacades::languages();
    $phone = Auth()->user()->phone;
    $email = Auth()->user()->email;
@endphp
@extends('layouts.app')
@section('title', __('Send Sms Your Number'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
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
            <h3>{{ __('Send Sms Your Number') }}</h3>
        </div>
        <small class="text-muted">{{ __('Send Otp Your Number Click Send Otp Button') }}</small><br />
        {!! Form::open([
            'route' => 'sms.noticeverification',
            'data-validate',
            'method' => 'POST',
            'class' => 'form-horizontal',
        ]) !!}
        <div class="form-group mb-3">
            {{ Form::label('phone', __('Phone Number'), ['class' => 'form-label']) }}
            {!! Form::text('phone', $phone, [
                'autofocus' => '',
                'readonly',
                'required' => true,
                'autocomplete' => 'off',
                'placeholder' => 'Enter phone Number',
                'class' => 'form-control',
            ]) !!}
        </div>
        @if (Utility::getsettings('smssetting') == 'fast2sms')
            <div class="form-group">
                {!! Form::radio('smstype', 'sms', true, [
                    'class' => 'btn-check',
                    'id' => 'smstype_sms',
                ]) !!}
                {{ Form::label('smstype_sms', __('SMS'), ['class' => 'btn btn-outline-primary']) }}
                {!! Form::radio('smstype', 'call', false, [
                    'class' => 'btn-check',
                    'id' => 'smstype_call',
                ]) !!}
                {{ Form::label('smstype_call', __('Call'), ['class' => 'btn btn-outline-primary']) }}
            </div>
        @endif
        <input type="hidden" name="email" value="{{ isset($email) ? $email : $_GET['email'] }}">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Send Otp') }}</button>
        </div>
        {!! Form::close() !!}

        <p class="my-3 d-grid">
            <button type="submit" class="mt-2 btn btn-link">
                <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="f-w-400">
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
@endsection
