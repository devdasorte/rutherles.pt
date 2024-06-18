@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Reset Password'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="current"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', [$request->route('token'), $language]) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="login-content-inner">
        <div class="login-title">
            <h3>{{ __('Reset Password') }}</h3>
        </div>
        {{ Form::open(['route' => ['password.update'], 'method' => 'POST', 'data-validate']) }}
        @csrf
        {!! Form::hidden('token', $token, ['class' => 'form-control']) !!}
        <div class="form-group mb-3">
            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="{{ __('Enter Email') }}" name="email" value="{{ $email ?? old('email') }}" required
                autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('Enter password') }}" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                placeholder="{{ __('Enter confirm password') }}" autocomplete="new-password">
        </div>
        <div class="d-grid">
            {{ Form::button(__('Reset Password'), ['type' => 'submit', 'class' => 'mt-2 btn btn-primary btn-block']) }}
        </div>
        {{ Form::close() }}
    </div>
@endsection
