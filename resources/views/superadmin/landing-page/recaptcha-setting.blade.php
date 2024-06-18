@extends('layouts.main')
@section('title', __('Recaptcha Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Recaptcha Setting') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @include('superadmin.landing-page.landingpage-sidebar')
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                {!! Form::open([
                                    'route' => ['landing.recaptcha.store'],
                                    'method' => 'Post',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="mb-0">{{ __('Recaptcha Setting') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label
                                                    for="contact_us_recaptcha_status">{{ __('Contact Us Recaptcha Status') }}</label>
                                                <label class="form-switch mt-2 float-end custom-switch-v1">
                                                    {!! Form::checkbox(
                                                        'contact_us_recaptcha_status',
                                                        null,
                                                        Utility::getsettings('contact_us_recaptcha_status') ? true : false,
                                                        [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'contact_us_recaptcha_status',
                                                        ],
                                                    ) !!}
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="login_recaptcha_status">{{ __('LogIn Recaptcha Status') }}</label>
                                                <label class="form-switch mt-2 float-end custom-switch-v1">
                                                    {!! Form::checkbox(
                                                        'login_recaptcha_status',
                                                        null,
                                                        Utility::getsettings('login_recaptcha_status') ? true : false,
                                                        [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'login_recaptcha_status',
                                                        ],
                                                    ) !!}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_key', Utility::getsettings('recaptcha_key'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha key'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_secret', Utility::getsettings('recaptcha_secret'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha secret'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary']) }}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
