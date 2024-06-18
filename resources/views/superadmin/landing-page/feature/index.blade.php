@extends('layouts.main')
@section('title', __('Feature Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Feature Setting') }}</li>
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
                            <div class="tab-pane fade show active" id="menu-setting" role="tabpanel"
                                aria-labelledby="landing-menu-setting">
                                {!! Form::open([
                                    'route' => ['landing.feature.store'],
                                    'method' => 'Post',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="mb-0">{{ __('Feature Setting') }}</h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                {!! Form::checkbox(
                                                    'feature_setting_enable',
                                                    null,
                                                    Utility::getsettings('feature_setting_enable') == 'on' ? true : false,
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
                                                {{ Form::label('feature_name', __('Feature Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('feature_name', Utility::getsettings('feature_name'), [
                                                    'class' => 'form-control',
                                                    'rows' => '1',
                                                    'placeholder' => __('Enter feature name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('feature_bold_name', __('Feature Bold Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('feature_bold_name', Utility::getsettings('feature_bold_name'), [
                                                    'class' => 'form-control',
                                                    'rows' => '3',
                                                    'placeholder' => __('Enter feature bold Name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('feature_detail', __('Feature Detail'), ['class' => 'form-label']) }}
                                                {!! Form::textarea('feature_detail', Utility::getsettings('feature_detail'), [
                                                    'class' => 'form-control',
                                                    'rows' => '3',
                                                    'placeholder' => __('Enter feature detail'),
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
                                    <h5>{{ __('Feature') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="javascript:void(0);" data-url="{{ route('feature.create') }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1 feature_create"
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
                                            <th>{{ __('Bold Text') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($featureSettings) || is_object($featureSettings))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($featureSettings as $key => $featureSetting)
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $featureSetting['feature_name'] }}</td>
                                                    <td>{{ $featureSetting['feature_bold_name'] }}</td>
                                                    <td>
                                                        <span>
                                                            <a href="javascript:void(0);"
                                                                data-url="{{ route('feature.edit', $key) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                class="btn btn-sm btn-primary mx-1 feature_edit"
                                                                data-bs-original-title="{{ __('Create') }}">
                                                                <i class="ti ti-pencil text-light"></i>
                                                            </a>
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'class' => 'd-inline',
                                                                'route' => ['feature.delete', $key],
                                                                'id' => 'delete-form-' . $key,
                                                            ]) !!}
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-sm small btn btn-danger show_confirm"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                id="delete-form-1"
                                                                data-bs-original-title="{{ __('Delete') }}">
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
            $('body').on('click', '.feature_create', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Create Feature') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.feature_edit', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Feature') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
