@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Sign Up'))
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
    <div class="login-content-inner register-tab">
        <div class="login-title">
            <h3>{{ __('Sign Up') }}</h3>
        </div>
        <form method="POST" data-validate action="{{ route('register') }}">
            @csrf
            <div class="form-group mb-3">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                {!! Form::text('name', old('name'), [
                    'class' => 'form-control',
                    'placeholder' => __('Enter name'),
                    'required',
                    'id' => 'name',
                    'autocomplete' => 'name',
                    'autofocus',
                ]) !!}
            </div>
            <div class="form-group mb-3">
                {{ Form::label('email', __('Email'), ['class' => 'form-label mb-2']) }}
                {!! Form::email('email', old('email'), [
                    'class' => 'form-control',
                    'id' => 'email',
                    'placeholder' => __('Enter email address'),
                    'onfocus',
                    'required',
                ]) !!}
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                    name="password" placeholder="{{ __('Enter password') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Password Confirmation') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password" placeholder="{{ __('Enter password confirmation') }}">
            </div>
            <div class="form-group">
                {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                <input id="phone" name="phone" type="tel" class="form-control"
                    placeholder="{{ __('Enter phone') }}" required>
                {!! Form::hidden('country_code', null, []) !!}
                {!! Form::hidden('dial_code', null, []) !!}
            </div>
            <div class="mb-4">
                <div class="form-check check-box">
                    <label class="switch">
                        <input type="checkbox" name="terms" id="flexCheckChecked">
                        <span class="slider round"></span>
                    </label>
                    <label for="flexCheckChecked" class="form-label lbl-check-box">{{ __('I accept the ') }}
                        <a href="{{ route('terms.and.conditions') }}">
                            {{ __('Terms & conditions') }}
                        </a>
                    </label>
                </div>
            </div>

            @if (Utility::getsettings('login_recaptcha_status') == '1')
                <div class="text-center">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                </div>
            @endif

            <div class="d-grid">
                {{ Form::button(__('Sign Up'), ['type' => 'submit', 'class' => 'mt-2 btn btn-primary btn-block']) }}
            </div>
        </form>
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
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
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
