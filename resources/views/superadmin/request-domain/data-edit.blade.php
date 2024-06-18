@php
    $domain = str_replace('.' . parse_url(env('APP_URL'), PHP_URL_HOST), '', $requestDomain->domain_name);
@endphp
@extends('layouts.main')
@section('title', __('Edit Domain Request'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('request.domain.index') }}">{{ __('Domain Requests') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Domain Request') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Domain Request') }}</h5>
                    </div>
                    {!! Form::model($requestDomain, [
                        'route' => ['request.domain.update', $requestDomain->id],
                        'method' => 'POST',
                        'data-validate',
                    ]) !!}
                    <div class="card-body">
                        <div class="form-group ">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" value="{{ $requestDomain->name }}" type="text" class="form-control"
                                name="name" required autocomplete="name" placeholder="{{ __('Enter name') }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" value="{{ $requestDomain->email }}"
                                name="email" required placeholder="{{ __('Enter email') }}" autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control pwstrength"
                                placeholder="{{ __('Enter password') }}" data-indicator="pwindicator" name="password">
                            <div id="pwindicator" class="pwindicator">
                                <div class="bar"></div>
                                <div class="label"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password2" class="form-label">{{ __('Password Confirmation') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                placeholder="{{ __('Enter confirm password') }}" name="password_confirmation"
                                autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                            {!! Form::hidden('country_code', $requestDomain->country_code, []) !!}
                            {!! Form::hidden('dial_code', $requestDomain->dial_code, []) !!}
                            <input id="phone" name="phone" class="form-control"
                                value="+{{ $requestDomain->dial_code . '0' . $requestDomain->phone }}" type="tel"
                                placeholder="{{ __('Enter phone') }}" required>
                        </div>
                        <div class="form-group">
                            {{ Form::label('domains', __('Domain Configration'), ['class' => 'form-label']) }}
                            @if (Utility::getsettings('domain_config') == 'on')
                                <div class="input-group">
                                    {!! Form::text('domains', isset($domain) ? $domain : '', [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter domain name'),
                                    ]) !!}
                                    <span
                                        class="input-group-text">{{ '.' . parse_url(env('APP_URL'), PHP_URL_HOST) }}</span>
                                </div>
                            @else
                                {!! Form::text('domains', $requestDomain->domain_name, [
                                    'class' => 'form-control',
                                    'required',
                                    'placeholder' => __('Enter domain name'),
                                ]) !!}
                            @endif
                            <div class="error-message" id="bouncer-error_domains"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="{{ route('request.domain.index') }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
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
