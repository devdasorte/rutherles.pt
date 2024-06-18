@extends('layouts.main')
@section('title', __('Contact Us Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Contact Us Setting') }}</li>
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
                                    'route' => ['landing.contactus.store'],
                                    'method' => 'Post',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="mb-0">{{ __('Contact Us Setting') }}</h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                {!! Form::checkbox(
                                                    'contactus_setting_enable',
                                                    null,
                                                    Utility::getsettings('contactus_setting_enable') == 'on' ? true : false,
                                                    [
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('contactus_name', __('Contact Us Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('contactus_name', Utility::getsettings('contactus_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter contact us name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('contactus_bold_name', __('Contact Us Bold Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('contactus_bold_name', Utility::getsettings('contactus_bold_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter contact us bold name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('contactus_detail', __('Contact Us Detail'), ['class' => 'form-label']) }}
                                                {!! Form::text('contactus_detail', Utility::getsettings('contactus_detail'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter contact us detail'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5>{{ __('Contact Us Details') }}</h5>
                                            <div class="form-group">
                                                {{ Form::label('contactus_email', __('Contact Us Email'), ['class' => 'col-form-label']) }}
                                                <div class="custom-input-group">
                                                    {!! Form::text('contactus_email', Utility::getsettings('contactus_email'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter contact us email'),
                                                    ]) !!}
                                                </div>
                                                <p class="text-sm">
                                                    {{ _('This email is for receive email when user submit contact us form.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('contactus_latitude', __('Contact Us Latitude'), ['class' => 'form-label']) }}
                                                    {!! Form::text('contactus_latitude', Utility::getsettings('contactus_latitude'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter contact us latitude'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('contactus_longitude', __('Contact Us Longitude'), ['class' => 'form-label']) }}
                                                    {!! Form::text('contactus_longitude', Utility::getsettings('contactus_longitude'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter contact us longitude'),
                                                    ]) !!}
                                                </div>
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
