@extends('layouts.main')
@section('title', __('Edit Email Template'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('email-template.index') }}">{{ __('Email Templates') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Email Template') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-sm-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Email Template') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::model($mailTemplate, [
                            'method' => 'PATCH',
                            'route' => ['email-template.update', $mailTemplate->id],
                            'data-validate',
                        ]) !!}
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('variables', __('Variables ;'), ['class' => 'form-label fw-bolder text-dark fs-6']) }}
                                @foreach ($mailTemplate->variables as $variables)
                                    <span class="fw-bolder text-dark fs-6">{{ <?php echo $variables; ?> }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group fv-row mb-7">
                            {{ Form::label('subject', __('Subject'), ['class' => 'form-label fw-bolder text-dark fs-6']) }}
                            {!! Form::text('subject', null, [
                                'autofocus' => '',
                                'required' => true,
                                'autocomplete' => 'off',
                                'class' => 'form-control form-control-lg form-control-solid',
                                'readonly' . ($errors->has('subject') ? ' is-invalid' : null),
                            ]) !!}
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group fv-row mb-7">
                            {{ Form::label('html_template', __('HTML Template'), ['class' => 'form-label fw-bolder text-dark fs-6']) }}
                            {!! Form::textarea('html_template', null, [
                                'required' => true,
                                'autocomplete' => 'off',
                                'class' =>
                                    'form-control form-control-lg form-control-solid' . ($errors->has('html_template') ? ' is-invalid' : null),
                            ]) !!}
                            @error('html_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('email-template.index') }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
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
        CKEDITOR.replace('html_template', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
