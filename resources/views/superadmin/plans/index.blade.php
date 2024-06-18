@php
    use Carbon\Carbon;
    if (Auth::user()->type == 'Admin') {
        $currencySymbol = tenancy()->central(function ($tenant) {
            return Utility::getsettings('currency_symbol');
        });
    } else {
        $currencySymbol = Utility::getsettings('currency_symbol');
    }
    if (Auth::user()->type != 'Admin') {
        $currency = Utility::getsettings('currency');
    } else {
        $currency = tenancy()->central(function ($tenant) {
            return Utility::getsettings('currency');
        });
    }
    $paymentType = [];
@endphp
@extends('layouts.main')
@if (Auth::user()->type == 'Super Admin')
    @section('title', __('Plans'))
@else
    @section('title', __('Pricing'))
@endif
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Plans') }}</li>
@endsection
@section('content')
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
@endpush
