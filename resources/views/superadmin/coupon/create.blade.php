@extends('layouts.main')
@section('title', __('Create Coupon'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">{{ __('Coupons') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Coupon') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="m-auto col-lg-6 col-md-8 col-xxl-4">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Coupon') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => 'coupon.store',
                            'method' => 'Post',
                            'class' => 'form-horizontal',
                            'data-validate',
                        ]) !!}
                        <div class="row">
                            <div class="form-group">
                                {{ Form::label('discount_type', __('Discount Type'), ['class' => 'form-label']) }}
                                <select name="discount_type" required id="discount_type" class="form-control" data-trigger>
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
                            <div class="mb-1 form-group">
                                {{ Form::label('code', __('Code'), ['class' => 'form-label']) }}
                                <div class="d-flex radio-check">
                                    <div class="form-check form-check-inline col-md-6">
                                        <input type="radio" id="manual_code" value="manual" name="icon_input" class="form-check-input code"
                                            checked="checked">
                                        <label class="custom-control-label" for="manual_code">{{ __('Manual') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-6">
                                        <input type="radio" id="auto_code" value="auto" name="icon_input" class="form-check-input code">
                                        <label class="custom-control-label" for="auto_code">{{ __('Auto Generate') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 d-block" id="manual">
                                <input class="form-control font-uppercase" name="manualCode"
                                    placeholder="{{ __('Enter manual code') }}" type="text">
                            </div>
                            <div class="form-group col-md-12 d-none" id="auto">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input class="form-control" name="autoCode"
                                            placeholder="{{ __('Generate auto code') }}" type="text" id="auto-code">
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);" class="btn btn-primary" id="code-generate"><i
                                                class="ti ti-history"></i></a>
                                    </div>
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
        $(document).on('click', '.code', function() {
            var type = $(this).val();
            if (type == 'manual') {
                $('#manual').removeClass('d-none');
                $('#manual').addClass('d-block');
                $('#auto').removeClass('d-block');
                $('#auto').addClass('d-none');
            } else {
                $('#auto').removeClass('d-none');
                $('#auto').addClass('d-block');
                $('#manual').removeClass('d-block');
                $('#manual').addClass('d-none');
            }
        });

        $(document).on('click', '#code-generate', function() {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
