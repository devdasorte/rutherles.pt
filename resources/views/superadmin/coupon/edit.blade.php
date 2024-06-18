@extends('layouts.main')
@section('title', __('Edit Coupon'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">{{ __('Coupons') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Coupon') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Coupon') }}</h5>
                    </div>
                    <div class="card-body">
                        {{ Form::model($coupon, ['route' => ['coupon.update', $coupon->id], 'method' => 'PUT', 'data-validate']) }}
                        <div class="row">
                            <div class="form-group">
                                {{ Form::label('discount_type', __('Discount Type'), ['class' => 'form-label']) }}
                                <select name="discount_type" id="discount_type" required class="form-control" data-trigger>
                                    <option value="">{{ __('Select Discount Type') }}</option>
                                    <option value="flat">{{ __('Flat') }}</option>
                                    <option value="percentage">{{ __('Percentage') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
                                    {{ Form::number('discount', null, ['class' => 'form-control', 'placeholder' => __('Enter discount'), 'required' => 'required', 'step' => '0.01']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('limit', __('Limit'), ['class' => 'form-label']) }}
                                    {{ Form::number('limit', null, ['class' => 'form-control', 'placeholder' => __('Enter limit'), 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('code', __('Code'), ['class' => 'form-label']) }}
                                {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter code'), 'required' => 'required']) }}
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('coupon.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <input type="submit" value="{{ __('Save') }}" class="btn  btn-primary">
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
        </section>
    </div>
@endsection
@push('javascript')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
        var discount_type = '{{ $coupon->discount_type }}';
        $("#discount_type option[value=" + discount_type + "]").attr('selected', true);
    </script>
@endpush
