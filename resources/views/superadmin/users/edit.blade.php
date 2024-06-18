@php
    $domain = str_replace('.' . parse_url(env('APP_URL'), PHP_URL_HOST), '', $userDomain->domain);
@endphp
@extends('layouts.main')
@section('title', __('Edit Admin'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Admins') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Admin') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="m-auto col-lg-6 col-md-8 col-xxl-4">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Admin') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::model($user, [
                            'route' => ['users.update', $user->id],
                            'method' => 'Put',
                            'data-validate',
                        ]) !!}
                        <div class="form-group ">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter name')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                            {!! Form::text('email', null, [
                                'class' => 'form-control',
                                ' required',
                                'placeholder' => __('Enter email address'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                            {!! Form::hidden('country_code', $user->country_code, []) !!}
                            {!! Form::hidden('dial_code', $user->dial_code, []) !!}
                            <input id="phone" name="phone" class="form-control"
                                value="+{{ $user->dial_code . '0' . $user->phone }}" type="tel"
                                placeholder="{{ __('Enter phone') }}" required>
                        </div>
                        <div class="form-group" id="domain">
                            {{ Form::label('domains', __('Domain'), ['class' => 'form-label']) }}
                            @if (Utility::getsettings('domain_config') == 'on')
                                <div class="input-group">
                                    {!! Form::text('domains', isset($domain) ? $domain : '', [
                                        'class' => 'form-control',
                                        'id' => 'domains',
                                        'required',
                                        'placeholder' => __('Enter domain name'),
                                    ]) !!}
                                    <span
                                        class="input-group-text">{{ '.' . parse_url(env('APP_URL'), PHP_URL_HOST) }}</span>
                                </div>
                            @else
                                {!! Form::text('domains', $userDomain->domain, [
                                    'class' => 'form-control',
                                    'id' => 'domains',
                                    'required',
                                    'placeholder' => __('Enter domain name'),
                                ]) !!}
                            @endif
                            <div class="error-message" id="bouncer-error_domains"></div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('plan_id', __('Plan'), ['class' => 'form-label']) }}
                            {!! Form::select('plan_id', $plan, $user->plan_id, [
                                'class' => 'form-select',
                                'required',
                                'data-trigger',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {{ Form::label('plan_expired_date', __('Data de expiração'), ['class' => 'form-label']) }}
                            <input
                            class="form-control"
                            type="datetime-local"
                            id="plan_expired_date"
                            name="plan_expired_date"
                            value="{{$user->plan_expired_date}}"
                          />
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
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
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        $("#phone").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback('{{ $user->country_code }}');
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
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
    </script>
@endpush
