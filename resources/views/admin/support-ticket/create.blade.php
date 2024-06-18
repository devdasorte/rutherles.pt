@extends('layouts.main')
@section('title', __('Create Support Ticket'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('support-ticket.index') }}">{{ __('Support Tickets') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Support Ticket') }}</li>
@endsection
@section('content')
    {!! Form::open([
        'route' => 'support-ticket.store',
        'method' => 'Post',
        'enctype' => 'multipart/form-data',
        'data-validate',
    ]) !!}
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Ticket Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                            {!! Form::select(
                                'status',
                                ['In Progress' => 'In Progress', 'On Hold' => 'On Hold', 'Closed' => 'Closed'],
                                'In Progress',
                                [
                                    'class' => 'form-control',
                                    'data-trigger',
                                ],
                            ) !!}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {!! Form::text('subject', null, ['placeholder' => __('Enter subject'), 'class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="require form-label">{{ __('Attachments') }}
                                    <small>({{ __('You can select multiple files') }})</small> </label>
                                <div class="choose-file form-group">
                                    <label for="file" class="form-label d-block">
                                        {!! Form::file('attachments[]', [
                                            'data-filename' => 'multiple_file_selection',
                                            'class' => "form-control $errors->has('attachments') ? ' is-invalid' : ''",
                                            'multiple',
                                            'id' => 'file',
                                        ]) !!}
                                    </label>
                                </div>
                                <p class="multiple_file_selection mx-4"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'), ['class' => 'form-label ']) }}
                                {!! Form::textarea('description', null, [
                                    'required' => true,
                                    'autocomplete' => 'off',
                                    'class' => 'form-control form-control-lg form-control-solid' . ($errors->has('description') ? ' is-invalid' : null),
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <a href="{{ route('support-ticket.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('javascript')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
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
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
