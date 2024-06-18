@php
    $domain = str_replace('.' . parse_url(env('APP_URL'), PHP_URL_HOST), '', $requestDomain->domain_name);
@endphp
@extends('layouts.main')
@section('title', __('Approve User'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('request.domain.index') }}">{{ __('Domain Requests') }}</a></li>
    <li class="breadcrumb-item">{{ __('Approve User') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Approve User') }}</h5>
                    </div>
                    {!! Form::model($requestDomain, [
                        'route' => ['create.user', $requestDomain->id],
                        'method' => 'POST',
                        'data-validate',
                    ]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                {!! Form::hidden('type', $requestDomain->type, ['class' => 'form-control']) !!}
                                {!! Form::hidden('password', $requestDomain->password, ['class' => 'form-control']) !!}
                                <div class="form-group ">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('name', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter name')]) !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                    {!! Form::text('email', null, [
                                        'class' => 'form-control',
                                        ' required',
                                        'placeholder' => __('Enter email'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                                    {!! Form::hidden('country_code', $requestDomain->country_code, []) !!}
                                    {!! Form::hidden('dial_code', $requestDomain->dial_code, []) !!}
                                    <input id="phone" name="phone" class="form-control"
                                        value="+{{ $requestDomain->dial_code . '0' . $requestDomain->phone }}"
                                        type="tel" placeholder="{{ __('Enter phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <ul>
                                <li>{{ __('If you want to run your website in localhost then it is necessary to be a vhost, because
                                                                    of
                                                                    tenancy-based software it is necessary to create a vhost.') }}
                                </li>
                                <li class="text-danger">
                                    {{ __('If you give incorrect website host,then 404 error will be shown
                                                                        throughout the
                                                                        whole
                                                                        website') }}
                                </li>
                                <li> {{ __('if your website URL is') }} <span
                                        class="text-danger">{{ __('https://example.com/') }}</span>
                                    {{ __(',then host
                                                                        will be') }}
                                    <span class="text-danger">{{ __('example.com') }}</span>
                                </li>
                                <li> {{ __('if your website URL is') }} <span
                                        class="text-danger">{{ __('https://subdomain.example.com/') }}</span>
                                    {{ __(',then host
                                                                        will
                                                                        be') }}
                                    <span class="text-danger">{{ __('subdomain.example.com') }}</span> </li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    {{ Form::label('domains', __('Domain configration'), ['class' => 'form-label']) }}
                                    @if (Utility::getsettings('domain_config') == 'on')
                                        <div class="input-group">
                                            {!! Form::text('domains', isset($domain) ? $domain : '', [
                                                'class' => 'form-control',
                                                ' required',
                                                'placeholder' => __('Enter domain name'),
                                            ]) !!}
                                            <span
                                                class="input-group-text">{{ '.' . parse_url(env('APP_URL'), PHP_URL_HOST) }}</span>
                                        </div>
                                    @else
                                        {!! Form::text('domains', $requestDomain->domain_name, [
                                            'class' => 'form-control',
                                            ' required',
                                            'placeholder' => __('Enter domain name'),
                                        ]) !!}
                                    @endif
                                    <div class="error-message" id="bouncer-error_domains"></div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('db_name', __('Database Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('db_name', null, [
                                        'class' => 'form-control',
                                        ' required',
                                        'placeholder' => __('Enter database name'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    {{ Form::label('db_username', __('Database User'), ['class' => 'form-label']) }}
                                    {!! Form::text('db_username', null, [
                                        'class' => 'form-control',
                                        ' required',
                                        'placeholder' => __('Enter database username'),
                                    ]) !!}
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('db_password', __('Database Password'), ['class' => 'form-label']) }}
                                    {!! Form::password('db_password', [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter database password'),
                                    ]) !!}
                                </div>
                            </div>
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
