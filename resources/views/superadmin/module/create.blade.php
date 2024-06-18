@extends('layouts.main')
@section('title', __('Create Module'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">{{ __('Modules') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Module') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="col-lg-6 col-md-8 col-xxl-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Module') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'route' => 'modules.store',
                            'method' => 'Post',
                            'class' => 'form-horizontal',
                            'data-validate',
                        ]) !!}
                        <div class="form-group">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter name')]) !!}
                            @if ($errors->has('module'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('module') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('name', __('Permission'), ['class' => 'form-label']) }}
                            <div class="row">
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'M', null, [
                                        'id' => 'managepermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('managepermission', __('Manage'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox ">
                                    {!! Form::checkbox('permissions[]', 'C', null, [
                                        'id' => 'createpermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('createpermission', __('Create'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'E', null, [
                                        'id' => 'editpermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('editpermission', __('Edit'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'D', null, [
                                        'id' => 'deletepermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('deletepermission', __('Delete'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'S', null, [
                                        'id' => 'showpermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('showpermission', __('Show'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'U', null, [
                                        'id' => 'uploadpermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('uploadpermission', __('Upload'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="col-3 custom-control custom-checkbox">
                                    {!! Form::checkbox('permissions[]', 'MC', null, [
                                        'id' => 'masscreatepermission',
                                        'class' => 'form-check-input',
                                    ]) !!}
                                    {{ Form::label('masscreatepermission', __('Mass Create'), ['class' => 'form-check-label']) }}
                                </div>
                            </div>
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
