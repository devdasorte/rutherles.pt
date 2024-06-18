@extends('layouts.main')
@section('title', __('Edit Support Ticket'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('support-ticket.index') }}">{{ __('Support Tickets') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Support Ticket') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm btn-primary" id="ticket-info" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
                <i class="ti ti-edit text-white"></i>
            </button>
        </div>
    </div>
@endsection
@section('content')
    <div class="row ticket-info d-none">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{ Form::model($supportTicket, ['route' => ['support-ticket.update', $supportTicket->id], 'method' => 'PUT', 'data-validate', 'enctype' => 'multipart/form-data']) }}
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Ticket Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {!! Form::text('subject', null, ['placeholder' => __('Subject'), 'class' => 'form-control', 'required']) !!}
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
                    <div class="float-end">
                        <a href="{{ route('support-ticket.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5>
                            <span class="text-left">
                                {{ $supportTicket->name }}
                                <small>({{ $supportTicket->created_at->diffForHumans() }})</small>
                                <span class="d-block"><small>{{ $supportTicket->email }}</small></span>
                            </span>
                        </h5>
                        <small>
                            <span class="text-right">
                                {{ __('Status') }} :
                                <span
                                    class="badge rounded-pill
                                    @if ($supportTicket->status == 'In Progress') badge bg-warning
                                    @elseif($supportTicket->status == 'On Hold')
                                        badge bg-danger
                                    @else
                                        badge bg-success @endif">
                                    {{ __($supportTicket->status) }}
                                </span>
                            </span>
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <p>{!! $supportTicket->description !!}</p>
                    </div>
                    @php $attachments = json_decode($supportTicket->attachments); @endphp
                    @if (count($attachments))
                        <div class="m-1">
                            <h5>{{ __('Attachments') }} :</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($attachments as $index => $attachment)
                                    <li class="list-group-item px-0">
                                        {{ $attachment }} <a download=""
                                            href="{{ asset(Storage::url('tickets/' . $supportTicket->ticket_id . '/' . $attachment)) }}"
                                            class="edit-icon py-1 ml-2" title="{{ __('Download') }}"><i
                                                class="fas fa-download ms-2"></i></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @foreach ($supportTicket->conversions as $conversion)
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $conversion->replyBy()->name }}</h5>
                        <small>({{ $conversion->created_at->diffForHumans() }})</small>
                    </div>
                    <div class="card-body">
                        <div>{!! $conversion->description !!}</div>
                        @php $attachments = json_decode($conversion->attachments); @endphp
                        @if (count($attachments))
                            <div class="m-1">
                                <h6>{{ __('Attachments') }} :</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach ($attachments as $index => $attachment)
                                        <li class="list-group-item px-0">
                                            {{ $attachment }}<a download=""
                                                href="{{ asset(Storage::url('tickets/' . $supportTicket->ticket_id . '/' . $attachment)) }}"
                                                class="edit-icon py-1 ml-2" title="{{ __('Download') }}"><i
                                                    class="fa fa-download ms-2"></i></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Add Reply') }}</h5>
                </div>
                {!! Form::open([
                    'route' => ['conversion.store', $supportTicket->id],
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                    'data-validate',
                ]) !!}
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('reply_description', __('Description'), ['class' => 'form-label ']) }}
                            {!! Form::textarea('reply_description', null, [
                                'required' => true,
                                'autocomplete' => 'off',
                                'class' =>
                                    'form-control form-control-lg form-control-solid' . ($errors->has('reply_description') ? ' is-invalid' : null),
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group file-group">
                        <label class="require form-label">{{ __('Attachments') }}</label>
                        <label class="form-label"><small>({{ __('You can select multiple files') }})</small></label>
                        <div class="choose-file form-group">
                            <label for="file" class="form-label d-block">
                                <div class="form-label">{{ __('Choose File Here') }}</div>
                                {!! Form::file('reply_attachments[]', [
                                    'data-filename' => 'multiple_reply_file_selection',
                                    'class' => 'form-control ',
                                    'multiple',
                                    'id' => 'file',
                                ]) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('reply_attachments.*') }}
                                </div>
                            </label>
                        </div>
                    </div>
                    <p class="multiple_reply_file_selection"></p>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <a href="{{ route('support-ticket.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
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
        CKEDITOR.replace('reply_description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        $(document).ready(function() {
            $(document).on('click', '#ticket-info', function() {
                if ($('.ticket-info').hasClass('d-none')) {
                    $('.ticket-info').removeClass('d-none');
                    $('.ticket-info').fadeIn(500);
                } else {
                    $('.ticket-info').addClass('d-none');
                    $('.ticket-info').fadeOut(500);
                }
            });
        });
    </script>
@endpush
