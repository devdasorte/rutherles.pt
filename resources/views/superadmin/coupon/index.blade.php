@extends('layouts.main')
@section('title', __('Coupons'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Coupons') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <div class="d-flex align-items-center">
            @if (\Auth::user()->can('mass-create-coupon'))
                <a href="{{ route('coupon.mass.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" class="btn btn-sm btn-primary"
                    data-bs-original-title="{{ __('Mass Create') }}">
                    <i class="ti ti-plus"></i>
                </a>
            @endif
            @if (\Auth::user()->can('upload-coupon'))
                <a href="javascript:void(0);" data-url="{{ route('coupon.upload') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" class="btn btn-sm btn-primary mx-1 upload_csv"
                    data-bs-original-title="{{ __('Upload') }}">
                    <i class="ti ti-upload"></i>
                </a>
            @endif
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20">{{ __('Total Coupon') }}</h6>
                            <h3 class="text-primary">{{ $totalCoupon }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="ti ti-discount bg-primary text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20">{{ __('Total Expired Coupon') }}</h6>
                            <h3 class="text-danger">{{ $expieredCoupon }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="ti ti-user-exclamation bg-danger text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20">{{ __('Total Used Coupon') }}</h6>
                            <h3 class="text-success">{{ $totalUsedCoupon }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="ti ti-user-check bg-success text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20">{{ __('Total Discounted Amount') }}</h6>
                            <h3 class="text-warning">{{ Utility::getsettings('currency_symbol') }}{{ $totalUseAmount }}
                            </h3>
                        </div>
                        <div class="col-auto">
                            <i class="ti ti-currency-dollar bg-warning text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@push('javascript')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            $('body').on('click', '.upload_csv', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Upload Coupon') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
