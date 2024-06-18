@extends('layouts.main-landing')
@section('title', __('Main'))
@section('content')
    <section class="blog-page-banner"
        style="background-image: url({{ tenant('id') == null
            ? (Utility::getsettings('background_image')
                ? Storage::url(Utility::getsettings('background_image'))
                : asset('vendor/landing-page2/image/blog-banner-image.png'))
            : (Utility::getsettings('background_image')
                ? Storage::url(tenant('id') . '/' . Utility::getsettings('background_image'))
                : asset('vendor/landing-page2/image/blog-banner-image.png')) }});"
        width="100%" height="100%">
        <div class="container">
            <div class="common-banner-content">
                <div class="section-title">
                    <h2>{{ isset($page_footer->menu) ? $page_footer->menu : null }}</h2>
                </div>
                <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                    <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                        <span>/</span>
                    </li>
                    <li><a href="#">{{ isset($page_footer->menu) ? $page_footer->menu : null }}</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="blog-sidebar-sec pt">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="sidebar-widget-area">
                        <h3 class="title">{{ isset($page_footer->menu) ? $page_footer->menu : null }}</h3>
                        @php
                            $page_description = App\Models\PageSetting::find($page_footer->page_id);
                        @endphp
                        <div class="blog-sec">
                            <p>{!! isset($page_description->description) ? $page_description->description : null !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
