@extends('layouts.main')
@section('title', __('Create Mass Coupons'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">{{ __('Coupons') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Mass Coupons') }}</li>
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="m-auto col-lg-6 col-md-8 col-xxl-4">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Mass Coupons') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => 'coupon.mass.store',
                            'method' => 'Post',
                            'class' => 'form-horizontal',
                            'data-validate',
                        ]) !!}
                        <div class="row">
                            <div class="form-group ">
                                {{ Form::label('mass_create', __('Mass Create'), ['class' => 'form-label']) }}
                                {{ Form::number('mass_create', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter mass create'), 'required' => 'required']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('discount_type', __('Discount Type'), ['class' => 'form-label']) }}
                                <select name="discount_type" id="discount_type" class="form-control" required data-trigger>
                                    <option value="">{{ __('Select discount type') }}</option>
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
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('coupon.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
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
    </script>
@endpush
