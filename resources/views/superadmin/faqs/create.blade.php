@extends('layouts.main')
@section('title', __('Create Faq'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">{{ __('Faqs') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Faq') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Faq') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => 'faqs.store',
                            'method' => 'Post',
                            'data-validate',
                        ]) !!}
                        <div class="form-group ">
                            {{ Form::label('quetion', __('Quetion'), ['class' => 'form-label']) }}
                            {!! Form::text('quetion', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter quetion')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('answer', __('Answer'), ['class' => 'form-label']) }}
                            {!! Form::textarea('answer', null, [
                                'class' => 'form-control',
                                'data-trigger',
                                ' required',
                                'placeholder' => __('Enter answer address'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('order', __('Order'), ['class' => 'form-label']) }}
                            {!! Form::number('order', null, ['placeholder' => __('Enter order'), 'class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('faqs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('javascript')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('answer', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
