@extends('layouts.app')
@section('title', __('Two Factor Authentication'))
@section('content')
    <div class="login-content-inner">
        <div class="login-title">
            <h3>{{ __('Two Factor Authentication') }}</h3>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <small class="text-muted">{{ __('Enter the pin from Google Authenticator app:') }}</small><br /><br />
        <form class="form-horizontal" data-validate action="{{ route('2faVerify') }}" method="POST">
            @csrf
            <div class="form-group {{ $errors->has('one_time_password-code') ? 'is-invalid' : '' }} mb-4">
                {{ Form::label('one_time_password', __('One Time Password'), ['class' => 'form-label']) }}
                {!! Form::text('one_time_password', null, [
                    'class' => 'form-control',
                    'id' => 'one_time_password',
                    'placeholder' => __('Enter one time password'),
                    'required',
                ]) !!}
            </div>
            <div class="d-grid">
                {{ Form::button(__('Authenticate'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </form>
        {!! Form::close() !!}
    </div>
@endsection
