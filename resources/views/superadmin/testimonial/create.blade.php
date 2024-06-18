@extends('layouts.main')
@section('title', __('Create Testimonial'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">{{ __('Testimonials') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Testimonial') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Testimonial') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => 'testimonial.store',
                            'method' => 'Post',
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data',
                            'data-validate',
                        ]) !!}
                        <div class="form-group">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter name')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                            {!! Form::file('image', ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('designation', __('Designation'), ['class' => 'form-label']) }}
                            {!! Form::text('designation', null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => __('Enter designation'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                                'rows' => '3',
                                'required',
                                'placeholder' => __('Enter description'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('rating', __('Rating'), ['class' => 'form-label']) }}
                            <div id="rateYo" data-rating="0"></div>
                            {!! Form::hidden('rating', null, ['required']) !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/rateyo/ext-component-ratings.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('vendor/rateyo/jquery.rateyo.min.js') }}"></script>
    <script>
        var rating = $("#rateYo").data('rating');
        $("#rateYo").rateYo({
            halfStar: true,
            numStars: 5,
            rating: rating,
            normalFill: "#A0A0A0",
            precision: 2,
            onSet: function(rating, rateYoInstance) {
                $('input[name="rating"]')
                    .val(rating);
            }
        });
    </script>
@endpush
