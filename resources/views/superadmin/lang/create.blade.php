@extends('layouts.main')
@section('title', __('Create Language'))
@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('manage.language', [$currantLang]) }}">{{ __('Languages') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create Language') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                {!! Form::open(['route' => 'store.language', 'method' => 'Post', 'class' => 'form-horizontal','data-validate']) !!}
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-xxl-4 m-auto order-xl-1">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Create Language') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{ Form::label('code', __('Language Code'), ['class' => 'form-label']) }}
                                                {{ Form::text('code', '', ['class' => 'form-control', 'placeholder' => __('Enter language code'), 'required' => 'required']) }}
                                                @if ($errors->has('code'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-end">
                                    <a href="{{ route('manage.language', [$currantLang]) }}"
                                        class="btn btn-secondary">{{ __('Cancel') }}</a>
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
