@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.main-landing')
@section('title', __('Term-Condition'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', [$language]) }}">
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
        width="100% " height="100%">
        <div class="container">
            <div class="common-banner-content">
                <div class="section-title">
                    <h2>{{ __('Terms And Conditions') }}</h2>
                </div>
                <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                    <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                        <span>/</span>
                    </li>
                    <li><a href="javascript:void(0);">{{ __('Terms And Conditions') }}</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="home-faqs-sec pt pb">
        <div class="container">
            <div class="faqs-right-div">
                <article class="article article-detail article-noshadow">
                    <div class="p-0">
                        <div>
                            {!! Utility::getsettings('term_condition') !!}
                        </div>
                    </div>
                </article>
                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" class="faqs-bg">
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
