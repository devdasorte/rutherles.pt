@extends('layouts.main')
@section('title', __('Edit Announcement'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('announcement.index') }}">{{ __('Announcements') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Announcement') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Announcement') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => ['announcement.update', $announcement->id],
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                            'data-validate',
                        ]) !!}
                        <div class="row">
                            <div class="form-group col-6">
                                {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                                {!! Form::text('title', $announcement->title, [
                                    'class' => 'form-control',
                                    'required',
                                    'placeholder' => __('Enter title'),
                                ]) !!}
                            </div>
                            <div class="form-group col-6">
                                {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                                {!! Form::file('image', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                            {!! Form::textarea('description', $announcement->description, [
                                'class' => 'form-control',
                                'rows' => '3',
                                'required',
                                'placeholder' => __('Enter description'),
                            ]) !!}
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {!! Form::text('start_date', $startDate, [
                                    'class' => 'form-control',
                                    'id' => 'datepicker-start-date',
                                    'required',
                                    'placeholder' => __('Start Date'),
                                ]) !!}
                            </div>
                            <div class="form-group col-6">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {!! Form::text('end_date', $endDate, [
                                    'class' => 'form-control',
                                    'id' => 'datepicker-end-date',
                                    'required',
                                    'placeholder' => __('End Date'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="share_with_public"
                                        {{ $announcement->share_with_public == 1 ? 'checked' : '' }}
                                        class="form-check-input" id="share_with_public">
                                    {{ Form::label('share_with_public', __('Share With Public'), ['class' => 'form-check-label']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="show_landing_page_announcebar"
                                        {{ $announcement->show_landing_page_announcebar == 1 ? 'checked' : '' }}
                                        class="form-check-input" id="show_landing_page_announcebar">
                                    {{ Form::label('show_landing_page_announcebar', __('Show Landing Page Announcebar'), ['class' => 'form-check-label']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('announcement.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-start-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-end-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
    </script>
@endpush
