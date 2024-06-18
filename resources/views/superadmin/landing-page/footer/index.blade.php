@extends('layouts.main')
@section('title', __('Footer Setting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Footer Setting') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @include('admin.landing-page.landingpage-sidebar')
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="menu-setting" role="tabpanel"
                                aria-labelledby="landing-menu-setting">
                                {!! Form::open([
                                    'route' => ['landing.footer.store'],
                                    'method' => 'Post',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <h5 class="mb-0">{{ __('Footer Setting') }}</h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                {!! Form::checkbox(
                                                    'footer_setting_enable',
                                                    null,
                                                    Utility::getsettings('footer_setting_enable') == 'on' ? true : false,
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
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('footer_description', __('Footer Description'), ['class' => 'form-label']) }}
                                                {!! Form::textarea('footer_description', Utility::getsettings('footer_description'), [
                                                    'class' => 'form-control',
                                                    'rows' => '3',
                                                    'placeholder' => __('Enter footer desciption'),
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
                                    <h5>{{ __('Footer Main Menu') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="javascript:void(0);" data-url="{{ route('footer.main.menu.create') }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1 footer_menu_create"
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
                                            <th>{{ __('Menu Name') }}</th>
                                            <th>{{ __('Slug') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($footerMainMenus) || is_object($footerMainMenus))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($footerMainMenus as $key => $footerMainMenu)
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $footerMainMenu['menu'] }}</td>
                                                    <td>{{ $footerMainMenu['slug'] }}</td>
                                                    <td>
                                                        <span>
                                                            <a href="javascript:void(0);"
                                                                data-url="{{ route('footer.main.menu.edit', $footerMainMenu->id) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                class="btn btn-sm btn-primary mx-1 footer_main_menu_edit"
                                                                data-bs-original-title="{{ __('Create') }}">
                                                                <i class="ti ti-pencil text-light"></i>
                                                            </a>
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'class' => 'd-inline',
                                                                'route' => ['footer.main.menu.delete', $footerMainMenu->id],
                                                                'id' => 'delete-form-' . $footerMainMenu->id,
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <h5>{{ __('Footer Sub Menu') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="{{ route('footer.sub.menu.create') }}" data-ajax-popup="true"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1" data-bs-original-title="{{ __('Create') }}">
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
                                            <th>{{ __('Sub Page Name') }}</th>
                                            <th>{{ __('Slug') }}</th>
                                            <th>{{ __('Main Menu') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($footerSubMenus) || is_object($footerSubMenus))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($footerSubMenus as $key => $footerSubMenu)
                                                @php
                                                    $pageName = App\Models\PageSetting::select('title')
                                                            ->where('id', $footerSubMenu->page_id)
                                                            ->first();
                                                    $parentName = App\Models\FooterSetting::select('menu', 'slug')
                                                        ->where('id', $footerSubMenu['parent_id'])
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $pageName->title }}</td>
                                                    <td>{{ $parentName['slug'] }}</td>
                                                    <td>{{ $parentName['menu'] }}</td>
                                                    <td>
                                                        <span>
                                                            <a href="{{ route('footer.sub.menu.edit', $footerSubMenu->id) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                class="btn btn-sm btn-primary mx-1"
                                                                data-bs-original-title="{{ __('Create') }}">
                                                                <i class="ti ti-pencil text-light"></i>
                                                            </a>
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'class' => 'd-inline',
                                                                'route' => ['footer.sub.menu.delete', $footerSubMenu->id],
                                                                'id' => 'delete-form-' . $footerSubMenu->id,
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
            $('body').on('click', '.footer_menu_create', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Create Main Menu') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.footer_main_menu_edit', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Main Menu') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
