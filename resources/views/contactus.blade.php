@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.main-landing')
@section('title', __('ContactUs'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ url('change.lang', $language) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <section class="blog-page-banner"
        data-bg-image="{{ Utility::getsettings('background_image')
            ? Storage::url(Utility::getsettings('background_image'))
            : asset('vendor/landing-page2/image/blog-banner-image.png') }}"
        width="100%" height="100%">
        <div class="container">
            <div class="common-banner-content">
                <div class="section-title">
                    <h2>{{ __('Contact US') }}</h2>
                </div>
                <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                    <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                        <span>/</span>
                    </li>
                    <li><a href="javascript:void(0)">{{ __('Contact US') }}</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="home-faqs-sec pt">
        <div class="container">
            <div class="faqs-right-div">
                <article class="article article-detail article-noshadow">
                    <div class="p-0">
                        <div>
                            {!! Utility::getsettings('contactus_detail') !!}
                        </div>
                    </div>
                </article>
                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" class="faqs-bg">
            </div>
        </div>
    </section>
    <div class="container-fluid pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="article article-detail article-noshadow">
                        <div class="p-0">
                            <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q={{ Utility::getsettings('contactus_latitude') }},{{ Utility::getsettings('contactus_longitude') }}&hl=en&z=14&amp;output=embed">
                            </iframe>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <section class="blog-sidebar-sec pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="article article-detail article-noshadow">
                        <div class="p-0 pb">
                            <section class="custom-section" id="sct-form-contact">
                                <div class="container position-relative zindex-100">
                                    <div class="row justify-content-center mb-1">
                                        <div class="section-title col-lg-6 text-center">
                                            <h2>
                                                <b>{{ __('Contact us') }}<p>
                                                        {{ __('If there is something we can help you with jut let us know. We will be more than happy to offer you our help') }}
                                                    </p>
                                                </b>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="card">
                                                {!! Form::open([
                                                    'route' => 'contact.mail',
                                                    'method' => 'Post',
                                                    'class' => 'p-4',
                                                ]) !!}
                                                <div class="form-group">
                                                    {!! Form::text('name', null, [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Your name'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::email('email', null, [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('email@example.com'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::text('contact_no', null, [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('+40-745-234-567'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::textarea('message', null, [
                                                        'class' => 'form-control',
                                                        'data-toggle' => 'autosize',
                                                        'rows' => '3',
                                                        'placeholder' => __('Tell us a few words ...'),
                                                        'required',
                                                    ]) !!}
                                                </div>
                                                @if (Utility::getsettings('contact_us_recaptcha_status') == '1')
                                                    <div class="text-center">
                                                        {!! NoCaptcha::renderJs() !!}
                                                        {!! NoCaptcha::display() !!}
                                                    </div>
                                                @endif
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-block btn-lg btn-primary mt-3 float-end">{{ __('Send your message') }}</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('javascript')
    <script>
        // Landing Page Background Image
        document.addEventListener("DOMContentLoaded", function() {
            var bannerSection = document.querySelector(".blog-page-banner");
            var backgroundURL = bannerSection.getAttribute("data-bg-image");
            bannerSection.style.backgroundImage = "url(" + backgroundURL + ")";
        });
    </script>
@endpush
