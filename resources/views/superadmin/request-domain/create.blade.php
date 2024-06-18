@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Register'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', [$data, $language]) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="login-content-inner register-tab">
        <div class="login-title">
            <h3>{{ __('Register') }}</h3>
        </div>
        {!! Form::open(['route' => 'request.domain.store', 'method' => 'POST', 'id' => 'request_form', 'data-validate']) !!}
        <div class="mb-3 form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => __('Enter name'),
                'required',
                'autofocus',
            ]) !!}
        </div>
        <div class="mb-3 form-group">
            {{ Form::label('email', __('Email Address'), ['class' => 'form-label']) }}
            {!! Form::email('email', null, [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => __('Enter email'),
                'required',
            ]) !!}
        </div>
        <div class="mb-3 form-group">
            {{ Form::label('password', __('Password'), ['class' => 'd-block form-label']) }}
            {!! Form::password('password', [
                'class' => 'form-control pwstrength',
                'id' => 'password',
                'placeholder' => __('Enter password'),
                'data-indicator' => 'pwindicator',
                'required',
            ]) !!}
            <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
            </div>
        </div>
        <div class="mb-3 form-group">
            {{ Form::label('password2', __('Password Confirmation'), ['class' => 'd-block form-label']) }}
            {!! Form::password('password_confirmation', [
                'class' => 'form-control',
                'id' => 'password-confirm',
                'placeholder' => __('Enter confirm password'),
                'required',
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
            <input id="phone" name="phone" type="tel" class="form-control" placeholder="{{ __('Enter phone') }}"
                required>
            {!! Form::hidden('country_code', null, []) !!}
            {!! Form::hidden('dial_code', null, []) !!}
        </div>
        <div class="form-group">
            {{ Form::label('domains', __('Domain Configration'), ['class' => 'form-label']) }}
            @if (Utility::getsettings('domain_config') == 'on')
                <div class="input-group">
                    {!! Form::text('domains', null, [
                        'class' => 'form-control',
                        'required',
                        'placeholder' => __('Enter domain name'),
                    ]) !!}
                    <span class="input-group-text">{{ '.' . parse_url(env('APP_URL'), PHP_URL_HOST) }}</span>
                </div>
            @else
                {!! Form::text('domains', null, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => __('Enter domain name'),
                ]) !!}
            @endif
            <small>
                {{ __('Note: Please link your domain with ' . $centralDomainIp . ' ip address.') }}
            </small>
            <div class="error-message" id="bouncer-error_domains"></div>
        </div>
        <div class="mb-4">
            <div class="form-check check-box">
                <label class="switch">
                    <input type="checkbox" required name="agree" id="flexCheckChecked">
                    <span class="slider round"></span>
                </label>
                <label for="flexCheckChecked" class="form-label lbl-check-box">{{ __('I agree with the') }}
                    <a href="{{ route('terms.and.conditions') }}">
                        {{ __('terms and conditions') }}
                    </a>
                </label>
            </div>
            <div class="error-message" id="bouncer-error_agree_on"></div>
        </div>
        <div class="d-grid">
            <input type="hidden" id="plan_id" name="plan_id" value="{{ $planId }}">
            <button type="submit" class="mt-2 btn btn-primary btn-block">
                {{ __('Register') }}
            </button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/intl-tel-input/intlTelInput.min.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('vendor/intl-tel-input/jquery.mask.js') }}"></script>
    <script src="{{ asset('vendor/intl-tel-input/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/intl-tel-input/utils.min.js') }}"></script>
    <script>
        $("#phone").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            initialCountry: "auto",
            separateDialCode: true,
        });
        $('#phone').on('countrychange', function(e) {
            $(this).val('');
            var selectedCountry = $(this).intlTelInput('getSelectedCountryData');
            var dialCode = selectedCountry.dialCode;
            var maskNumber = intlTelInputUtils.getExampleNumber(selectedCountry.iso2, 0, 0);
            maskNumber = intlTelInputUtils.formatNumber(maskNumber, selectedCountry.iso2, 2);
            maskNumber = maskNumber.replace('+' + dialCode + ' ', '');
            mask = maskNumber.replace(/[0-9+]/ig, '0');
            $('input[name="country_code"]').val(selectedCountry.iso2);
            $('input[name="dial_code"]').val(dialCode);
            $('#phone').mask(mask, {
                placeholder: maskNumber
            });
        });
    </script>
@endpush
