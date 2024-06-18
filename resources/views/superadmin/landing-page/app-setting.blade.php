@extends('layouts.main')
@section('title', __('App Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('App Setting') }}</li>
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
                    <div class="card"></div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="card">
                                <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                    aria-labelledby="landing-apps-setting">
                                    {!! Form::open([
                                        'route' => ['landing.app.store'],
                                        'method' => 'Post',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 d-flex align-items-center">
                                                <h5 class="mb-0">{{ __('App Setting') }}</h5>
                                            </div>
                                            <div class="col-lg-4 d-flex justify-content-end">
                                                <div class="form-switch custom-switch-v1 d-inline-block">
                                                    {!! Form::checkbox(
                                                        'apps_setting_enable',
                                                        null,
                                                        Utility::getsettings('apps_setting_enable') == 'on' ? true : false,
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
                                                    {{ Form::label('apps_image', __('App Image'), ['class' => 'form-label']) }} *
                                                    {!! Form::file('apps_image', ['class' => 'form-control', 'id' => 'apps_image']) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('apps_multiple_image', __('App Multiple Image'), ['class' => 'form-label']) }} *
                                                    {!! Form::file('apps_multiple_image[]', ['class' => 'form-control', 'id' => 'apps_multiple_image', 'multiple']) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('apps_name', __('App Name'), ['class' => 'form-label']) }}
                                                    {!! Form::text('apps_name', Utility::getsettings('apps_name'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter app name'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('apps_bold_name', __('App Bold Name'), ['class' => 'form-label']) }}
                                                    {!! Form::text('apps_bold_name', Utility::getsettings('apps_bold_name'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter app bold name'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    {{ Form::label('app_detail', __('App Detail'), ['class' => 'form-label']) }}
                                                    {!! Form::textarea('app_detail', Utility::getsettings('app_detail'), [
                                                        'class' => 'form-control',
                                                        'rows' => '3',
                                                        'placeholder' => __('Enter app detail'),
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
    </div>
@endsection
