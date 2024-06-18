@extends('layouts.main')
@section('title', __('Business Growth Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Business Growth Setting') }}</li>
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
                                    'route' => ['landing.business.growth.store'],
                                    'method' => 'Post',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="mb-0">{{ __('Business Growth Setting') }}</h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                {!! Form::checkbox(
                                                    'business_growth_setting_enable',
                                                    null,
                                                    Utility::getsettings('business_growth_setting_enable') == 'on' ? true : false,
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
                                                {{ Form::label('business_growth_front_image', __('Thumbnail'), ['class' => 'form-label']) }} *
                                                {!! Form::file('business_growth_front_image', ['class' => 'form-control', 'id' => 'business_growth_front_image']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('business_growth_video', __('Video'), ['class' => 'form-label']) }} *
                                                {!! Form::file('business_growth_video', ['class' => 'form-control', 'id' => 'video', 'accept' => 'video/*']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('business_growth_name', __('Business Growth Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('business_growth_name', Utility::getsettings('business_growth_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter business growth name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('business_growth_bold_name', __('Business Growth Bold Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('business_growth_bold_name', Utility::getsettings('business_growth_bold_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter business growth bold name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('business_growth_detail', __('Business Growth Detail'), ['class' => 'form-label']) }}
                                                {!! Form::text('business_growth_detail', Utility::getsettings('business_growth_detail'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter business growth detail'),
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <h5>{{ __('Business Growth View') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="javascript:void(0);" data-url="{{ route('business.growth.view.create') }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1 business_growth_view_create"
                                        data-bs-original-title="{{ __('Create') }}">
                                        <i class="ti ti-plus text-light"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($businessGrowthViewSettings) || is_object($businessGrowthViewSettings))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($businessGrowthViewSettings as $key => $businessGrowthViewSetting)
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $businessGrowthViewSetting['business_growth_view_name'] }}</td>
                                                    <td>{{ $businessGrowthViewSetting['business_growth_view_amount'] }}</td>
                                                    <td>
                                                        <span>
                                                            <a href="javascript:void(0);"
                                                                data-url="{{ route('business.growth.view.edit', $key) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                class="btn btn-sm btn-primary mx-1 business_growth_edit"
                                                                data-bs-original-title="{{ __('Create') }}">
                                                                <i class="ti ti-pencil text-light"></i>
                                                            </a>
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'class' => 'd-inline',
                                                                'route' => ['business.growth.view.delete', $key],
                                                                'id' => 'delete-form-' . $key,
                                                            ]) !!}
                                                            <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <h5>{{ __('Business Growth') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="javascript:void(0);" data-url="{{ route('business.growth.create') }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1 business_growth_create"
                                        data-bs-original-title="{{ __('Create') }}">
                                        <i class="ti ti-plus text-light"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($businessGrowthSettings) || is_object($businessGrowthSettings))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($businessGrowthSettings as $key => $businessGrowthSetting)
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $businessGrowthSetting['business_growth_title'] }}</td>
                                                    <td>
                                                        <span>
                                                            <a href="javascript:void(0);"
                                                                data-url="{{ route('business.growth.edit', $key) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                class="btn btn-sm btn-primary mx-1 business_growth_edit"
                                                                data-bs-original-title="{{ __('Create') }}">
                                                                <i class="ti ti-pencil text-light"></i>
                                                            </a>
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'class' => 'd-inline',
                                                                'route' => ['business.growth.delete', $key],
                                                                'id' => 'delete-form-' . $key,
                                                            ]) !!}
                                                            <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.business_growth_create', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Create Business Growth') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.business_growth_edit', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Business Growth') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.business_growth_view_create', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Create Business Growth View') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.business_growth_edit', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Business Growth View') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
