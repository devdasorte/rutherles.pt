@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.main-landing')
@section('title', isset($pageFooter->menu) ? $pageFooter->menu : __('Main'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', [$slug, $language]) }}">
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
                    <h2>{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</h2>
                </div>
                <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                    <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                        <span>/</span>
                    </li>
                    <li><a href="javascript:void(0)">{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    @php
        $footerDescription = App\Models\PageSetting::where('id', $pageFooter->page_id)->first();
    @endphp
    <section class="blog-sidebar-sec pt">
        <div class="container">
            <div class="row">
                <div class="mx-auto col-lg-12 col-md-12 col-12">
                    <div class="sidebar-widget-area">
                        <h3 class="title">{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</h3>
                        <div class="blog-sec">
                            <p>{!! isset($footerDescription->description) ? $footerDescription->description : null !!}</p>
                        </div>
                    </div>
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
