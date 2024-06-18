@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Confirm Password'))
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
            <h3>{{ __('Confirm Password') }}</h3>
        </div>
        {!! Form::open([
            'route' => 'password.confirm',
            'method' => 'POST',
            'class' => 'needs-validation',
            'data-validate',
        ]) !!}
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control"
                name="password" required autocomplete="current-password">
        </div>
        <div class="d-grid row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="mt-2 btn btn-primary btn-block mt-2">
                    {{ __('Confirm Password') }}
                </button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password ?') }}
                    </a>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
