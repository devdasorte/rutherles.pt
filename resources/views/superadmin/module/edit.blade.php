@extends('layouts.main')
@section('title', __('Edit Module'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">{{ __('Modules') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Module') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit Module') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => ['modules.update', $module->id],
                            'method' => 'POST',
                            'class' => 'form-horizontal',
                            'data-validate',
                        ]) !!}
                        @method('PUT')
                        <div class="form-group">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', $module->name, [
                                'class' => 'form-control',
                                ' required',
                                'placeholder' => __('Enter name'),
                            ]) !!}
                            @if ($errors->has('module'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('module') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('modules.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
