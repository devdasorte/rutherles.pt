@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            {{ __('Two Factor Authentication') }}
        </div>
        <div class="card-body">
            {!! Form::open(['route' => '2fa', 'method' => 'POST','class'=>'form-horizontal']) !!}
                <div class="form-group mb-3">
                    <div class="form-group">
                        {{ Form::label('email', __('One time Password')) }}
                        {!! Form::text('one_time_password', null, [
                            'class' => 'form-control',
                            'id' => 'one_time_password',
                            'placeholder' => __('One time password'),
                        ]) !!}
                        @if ($errors->has('email'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    @if ($errors->has('one_time_password'))
                        <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('one_time_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="text-center">
                    {{ Form::button(__('Sign in'), ['type' => 'submit', 'class' => 'btn btn-primary my-4']) }}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
