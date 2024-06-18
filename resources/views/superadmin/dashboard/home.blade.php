@php
    use Carbon\Carbon;
    $users = \Auth::user();

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
@section('title', __('Dashboard'))
@section('content')
    <div class="row">
        @if (!$paymentTypes)
            <div class="col-md-12">
                <div class="alert alert-warning">{{ __('Please set your payment key & payment secret') }} -
                    <a href="{{ url('/settings') }}/#payment_setting">{{ __('Click') }}</a>
                </div>
            </div>
        @endif
        <div class="col-xxl-7">
            <div class="row">
                @can('manage-user')
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-users"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2"> {{ __('Total') }} </p>
                                <h6 class="mb-3 text-primary"> {{ __('Admin') }} </h6>
                                <h3 class="mb-0 text-primary"> {{ $user }} </h3>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('manage-plan')
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-businessplan"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2"> {{ __('Total') }} </p>
                                <h6 class="mb-3 text-info"> {{ __('Plan') }} </h6>
                                <h3 class="mb-0 text-info"> {{ $plan }} </h3>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('manage-langauge')
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-world"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2"> {{ __('Total') }} </p>
                                <h6 class="mb-3 text-warning"> {{ __('Language') }} </h6>
                                <h3 class="mb-0 text-warning"> {{ $languages }} </h3>
                            </div>
                        </div>
                    </div>
                @endcan
                @if (Auth::user()->type == 'Super Admin' || Auth::user()->type == 'Admin')
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-danger">
                                    <i class="ti ti-thumb-up"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2"> {{ __('Total') }} </p>
                                <h6 class="mb-3 text-danger"> {{ __('Earning') }} </h6>
                                <h3 class="mb-0 text-danger"> {{ Utility::amount_format($earning) }} </h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5> {{ __('Earning Report') }} </h5>
                    <div class="chartRange">
                        <i class="ti ti-calendar"></i>
                        <span></span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div id="earning-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-5">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h2 class="text-white mb-3">{{ __('Olá Super Admin!') }}</h2>
                            <p class="text-white mb-4">
                                {{ __('Have a nice day! you can quickly add your forms or polls Chart') }}
                            </p>
                            <div class="dropdown quick-add-btn">
                                <a class="btn-q-add dropdown-toggle dash-btn btn btn-default btn-light"
                                    data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    <i class="ti ti-plus drp-icon"></i>
                                    <span class="ms-1">{{ __('Quick add') }}</span>
                                </a>
                                <div class="dropdown-menu">
                                    @can('manage-user')
                                        <a href="{{ route('users.create') }}" data-size="lg" data-ajax-popup="true"
                                            data-title="Add User" class="dropdown-item" data-bs-placement="top">
                                            <span> {{ __('Add New User') }} </span>
                                        </a>
                                    @endcan
                                    @can('manage-support-ticket')
                                        <a href="{{ route('support-ticket.index') }}" data-size="lg" data-ajax-popup="true"
                                            data-title="Support List" class="dropdown-item" data-bs-placement="top">
                                            <span> {{ __('Support List') }} </span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 d-none d-sm-flex">
                            <img src="{{ asset('vendor/landing-page2/image/img-auth-3.svg') }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card dash-supports">
                <div class="card-header">
                    <h5>{{ __('Supports') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @forelse ($supports as $support)
                                    <tr>
                                        <td>
                                            <a href="{{ route('support-ticket.edit', $support->id) }}"
                                                class="btn btn-outline-primary">
                                                {{ __($support->ticket_id) }} </a>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ __('User Name') }}</small>
                                            <h6 class="m-0">{{ $support->name }}</h6>
                                        </td>
                                        <td>
                                            @if ($support->status == 'In Progress')
                                                <span class="badge rounded-pill bg-warning p-2 px-3">
                                                    {{ __('In Progress') }}
                                                </span>
                                            @elseif($support->status == 'Closed')
                                                <span class="badge rounded-pill bg-success p-2 px-3">
                                                    {{ __('Closed') }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-danger p-2 px-3">
                                                    {{ __('On Hold') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ __('Support Subject') }}</small>
                                            <h6 class="m-0">{{ $support->subject }}</h6>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <div class="col-md-12 text-center">
                                                <h6 class="m-3">{{ __('No data available in table') }}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        $(function() {
            var start = moment().subtract(5, 'days');
            var end = moment();

            function cb(start, end) {
                $('.chartRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                var start = start.format('YYYY-MM-DD');
                var end = end.format('YYYY-MM-DD');
                $.ajax({
                    url: "{{ route('get.chart.data') }}",
                    type: 'POST',
                    data: {
                        start: start,
                        end: end,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        chartFun(result.lable, result.value);
                    },
                    error: function(data) {
                        return data.responseJSON;
                    }
                });
            }

            function chartFun(lable, value) {
                var options = {
                    chart: {
                        height: "85%",
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Earning',
                        data: value
                    }],
                    xaxis: {
                        categories: lable,
                    },
                    colors: ['{{ $chatcolor }}'],

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: false,
                    },
                    markers: {
                        size: 4,
                        colors: ['{{ $chatcolor }}'],
                        opacity: 0.9,
                        strokeWidth: 2,
                        hover: {
                            size: 7,
                        }
                    },
                    yaxis: {
                        tickAmount: 3,
                        min: 0,
                    }
                };
                $("#earning-chart").empty();
                var chart = new ApexCharts(document.querySelector("#earning-chart"), options);
                chart.render();
            }
            $('.chartRange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1,
                        'year').endOf('year')],
                }
            }, cb);
            cb(start, end);
        });
    </script>
@endpush
