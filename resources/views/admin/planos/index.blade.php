@php

    use Carbon\Carbon;
    $users = \Auth::user();
       include app_path('Includes/settings.php');

    $primary_color = \App\Facades\UtilityFacades::getsettings('color');
    if (isset($primary_color)) {
        $color = $primary_color;
    } else {
        $color = 'theme-1';
    }
    if ($color == 'theme-1') {
        $chatcolor = '#0CAF60';
    } elseif ($color == 'theme-2') {
        $chatcolor = '#584ED2';
    } elseif ($color == 'theme-3') {
        $chatcolor = '#6FD943';
    } elseif ($color == 'theme-4') {
        $chatcolor = '#145388';
    } elseif ($color == 'theme-5') {
        $chatcolor = '#B9406B';
    } elseif ($color == 'theme-6') {
        $chatcolor = '#008ECC';
    } elseif ($color == 'theme-7') {
        $chatcolor = '#922C88';
    } elseif ($color == 'theme-8') {
        $chatcolor = '#C0A145';
    } elseif ($color == 'theme-9') {
        $chatcolor = '#48494B';
    } elseif ($color == 'theme-10') {
        $chatcolor = '#0C7785';
    }
@endphp
@extends('layouts.main')
@section('title','Logs')
<link id="tw-1" rel="stylesheet" href="{{ asset('assets/build/assets/app-CLXaZiM_.css') }}">

@section('content')
    <div class="row">
        @if (!$paymentTypes && Auth::user()->type == 'Admin')
            <div class="col-md-12">
                <div class="alert alert-warning">{{ __('Please set your payment key & payment secret') }} -
                    <a href="{{ url('/settings') }}/#payment_setting">{{ __('Click') }}</a>
                </div>
            </div>
        @endif
       @include('pricing')
    </div>
@endsection
