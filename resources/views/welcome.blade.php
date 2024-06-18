@php
    $languages = \App\Facades\UtilityFacades::languages();
    $currency = tenancy()->central(function ($tenant) {
        return Utility::getsettings('currency_symbol');
    });
@endphp
@extends('layouts.main-landing')
@section('title', __('Home'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected focus @endif
                    value="{{ route('change.lang', $language) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    @if (Utility::getsettings('apps_setting_enable') == 'on')
        <section class="home-banner-sec home-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="banner-image">
                            <img src="{{ Utility::getsettings('apps_image')
                                ? Utility::getpath(Utility::getsettings('apps_image'))
                                : Storage::url('seeder-image/app.png') }}"
                                width="100% " height="100%">
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{ asset('vendor/landing-page2/image/slider-image-dark.png') }}" class="home-bg-image">
            <img src="{{ asset('vendor/landing-page2/image/bacground-image.png') }}" class="bg-fir-img">
            <img src="{{ asset('vendor/landing-page2/image/bacground-image-2.png') }}" class="bg-sec-img">
            <img src="{{ asset('vendor/landing-page2/image/slider-sec-image.png') }}" class="bg-the-img">
        </section>
        <section class="admin-saas-sec pt pb">
            <img src="{{ asset('vendor/landing-page2/image/bacground-image-3.png') }}" class="admin-bg">
            <div class="container">
                <div class="text-center section-title">
                    <h2>
                        @if (Utility::getsettings('apps_name'))
                            {{ Utility::getsettings('apps_name') }}
                        @else
                            {{ __('Full Multi') }} <b>{{ __('Tenancy') }}</b> {{ __('Laravel Admin Saas') }}
                        @endif
                        <b> {{ Utility::getsettings('apps_bold_name') ? Utility::getsettings('apps_bold_name') : null }}
                        </b>
                    </h2>
                </div>
                <div class="section-content">
                    <p>
                        {{ Utility::getsettings('app_detail')
                            ? Utility::getsettings('app_detail')
                            : __('A flexible full-tenancy package for Laravel. Single & multi-database tenancy,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                automatic & manual mode, event-based architecture.') }}
                    </p>
                    <div class="admin-btn-wrapper d-flex align-items-center justify-content-center">
                        <a href="{{ route('login') }}" tabindex="0" class="btn">{{ __('Get Started') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12"
                                fill="none">
                                <path
                                    d="M17.6705 6.93385L13.6846 11.6132C13.4649 11.8711 13.177 12 12.8891 12C12.6011 12 12.3132 11.8711 12.0935 11.6132C11.6542 11.0974 11.6542 10.2612 12.0935 9.74541L14.159 7.32069L1.125 7.32069C0.503684 7.32069 0 6.72939 0 6C0 5.2706 0.503684 4.6793 1.125 4.6793L14.159 4.6793L12.0935 2.25458C11.6542 1.73881 11.6542 0.902603 12.0935 0.38683C12.5329 -0.128943 13.2452 -0.128943 13.6846 0.38683L17.6705 5.06614C18.1098 5.58187 18.1098 6.41812 17.6705 6.93385Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @if (isset($appsMultipleImageSettings))
            <section class="client-logo-section">
                <img src="{{ asset('vendor/landing-page2/image/client-logo-bg1.png') }}" class="client-bg" loading="lazy">
                <img src="{{ asset('vendor/landing-page2/image/client-logo-bg2.png') }}" class="client-bg2" loading="lazy">
                <div class="container">
                    <div class="client-logo-wrap">
                        <div class="client-logo-slider slick-slider">
                            @foreach ($appsMultipleImageSettings as $appsMultipleImageSetting)
                                <div class="client-logo-iteam">
                                    <a href="javascript:void(0);">
                                        <img src="{{ Utility::getpath($appsMultipleImageSetting->apps_multiple_image) }}"
                                            width="100% " height="100%">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if (Utility::getsettings('feature_setting_enable') == 'on')
        @if (isset($features))
            <section class="features-sec pt pb home-sec" id="features">
                <div class="container">
                    <div class="text-center section-title">
                        <h2>{{ Utility::getsettings('feature_name') ? Utility::getsettings('feature_name') : 'Stunning with' }}
                            <b>{{ Utility::getsettings('feature_bold_name') ? Utility::getsettings('feature_bold_name') : 'lots of features' }}</b>
                        </h2>
                    </div>
                    <div class="text-center feature-sec-content">
                        <p>{{ Utility::getsettings('feature_detail')
                            ? Utility::getsettings('feature_detail')
                            : "Optimize your manufacturing business with Digitize, offering a seamless user interface for
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        streamlined operations, one convenient platform." }}
                        </p>
                    </div>
                    <div class="features-card-slide">
                        @foreach ($features as $key => $feature)
                            <div class="features-card">
                                <div class="features-card-inner">
                                    <div class="features-card-image">
                                        <a href="javascript:void(0);">
                                            <img src="{{ $feature->feature_image ? Utility::getpath($feature->feature_image) : Storage::url('seeder-image/feature1.svg') }}"
                                                width="100% " height="100%">
                                        </a>
                                    </div>
                                    <div class="features-card-content">
                                        <div class="features-top-content">
                                            <h3>
                                                <a href="javascript:void(0);">{{ isset($feature) ? $feature->feature_name : 'Feature' }}<b>
                                                        {{ isset($feature) ? $feature->feature_bold_name : 'Management' }}</b></a>
                                            </h3>
                                        </div>
                                        <div class="features-bottom-content">
                                            <p>{{ isset($feature) ? $feature->feature_detail : ' Full tenancy' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <img src="{{ asset('vendor/landing-page2/image/features-bg-image') }}.png" class="features-bg">
                </div>
            </section>
        @endif
    @endif

    @if (Utility::getsettings('menu_setting_section1_enable') == 'on')
        <section class="apex-chart-sec pt home-sec" id="menu_section_1">
            <img src="{{ asset('vendor/landing-page2/image/features-bg-2.png') }}" class="features-sec-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="{{ asset('vendor/landing-page2/image/blue.png') }}" class="blue-bg left-blue">
                            <img src="{{ asset('vendor/landing-page2/image/purple.png') }}" class="purple-bg left-purple">
                            <img src="{{ asset('vendor/landing-page2/image/yellow-squre.png') }}"
                                class="yellow-bg left-yellow">
                            <img src="{{ Utility::getsettings('menu_image_section1')
                                ? Utility::getpath(Utility::getsettings('menu_image_section1'))
                                : Storage::url('seeder-image/menusection1.png') }}"
                                width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                @if (Utility::getsettings('menu_name_section1'))
                                    {{ Utility::getsettings('menu_name_section1') }}
                                @else
                                    {{ __('All in one place') }} <b> {{ __('CRM system') }} </b> {{ __('with') }}
                                @endif
                                <b> {{ Utility::getsettings('menu_bold_name_section1') }} </b>
                            </h2>
                            <p>
                                {{ Utility::getsettings('menu_detail_section1')
                                    ? Utility::getsettings('menu_detail_section1')
                                    : __(
                                        'ApexCharts is a modern charting library that helps developers to create beautiful and interactive visualizations for web pages with a simple API, while React-ApexCharts is                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ApexChart’s React integration that allows us to use ApexCharts in our applications.',
                                    ) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (Utility::getsettings('menu_setting_section2_enable') == 'on')
        <section class="support-system-sec pt pb home-sec" id="menu_section_2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="{{ asset('vendor/landing-page2/image/blue-small-round.png') }}"
                                class="blue-small-round blue-bg">
                            <img src="{{ asset('vendor/landing-page2/image/purple.png') }}" class="purple-bg left-purple">
                            <img src="{{ asset('vendor/landing-page2/image/yellow-squre.png') }}"
                                class="yellow-bg section2-yellow">
                            <img src="{{ Utility::getsettings('menu_image_section2')
                                ? Utility::getpath(Utility::getsettings('menu_image_section2'))
                                : Storage::url('seeder-image/menusection2.png') }}"
                                width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                @if (Utility::getsettings('menu_name_section2'))
                                    {{ Utility::getsettings('menu_name_section2') }}
                                @else
                                    {{ __('All in one place CRM system with') }} <b> {{ __('Support System') }} </b>
                                @endif
                                <b> {{ Utility::getsettings('menu_bold_name_section2') }} </b>
                            </h2>
                            <p>
                                {{ Utility::getsettings('menu_detail_section2')
                                    ? Utility::getsettings('menu_detail_section2')
                                    : __('A decision support system (DSS) is a computer program application used to improve a
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    companys decision-making capabilities. It analyzes large amounts of data and presents an
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    organization with the best possible options available.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (Utility::getsettings('menu_setting_section3_enable') == 'on')
        <section class="apex-chart-sec home-sec" id="menu_section_3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="{{ asset('vendor/landing-page2/image/blue.png') }}" class="blue-bg section3-blue">
                            <img src="{{ asset('vendor/landing-page2/image/purple.png') }}" class="section3-purple">
                            <img src="{{ asset('vendor/landing-page2/image/yellow-squre.png') }}"
                                class="section3-yellow">
                            <img src="{{ Utility::getsettings('menu_image_section3')
                                ? Utility::getpath(Utility::getsettings('menu_image_section3'))
                                : Storage::url('seeder-image/menusection3.png') }}"
                                width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                @if (Utility::getsettings('menu_name_section3'))
                                    {{ Utility::getsettings('menu_name_section3') }}
                                @else
                                    {{ __('Empowering with Streamlined') }} <b> {{ __('Manufacturers') }} </b>
                                @endif
                                <b> {{ Utility::getsettings('menu_bold_name_section3') }} </b>
                            </h2>
                            <p>
                                {{ Utility::getsettings('menu_detail_section3')
                                    ? Utility::getsettings('menu_detail_section3')
                                    : __('Digitize SAAS software is a game-changing solution designed exclusively for
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    manufacturers, revolutionizing their operations and driving digital transformation. With
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    its advanced features and cutting-edge technology,') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (Utility::getsettings('business_growth_setting_enable') == 'on')
        <section class="video-play-sec pt pb home-sec" id="business_growth">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="video-wrapper-div">
                            <div class="video-image">
                                @if (!empty(Utility::getsettings('business_growth_video')))
                                    <video id="videoPlayer" controls width="100%" height="100%"
                                        poster="{{ Utility::getpath(Utility::getsettings('business_growth_front_image')) }}"
                                        data-setup="{}">
                                        <source
                                            src="{{ Utility::getpath(Utility::getsettings('business_growth_video')) }}"
                                            type='video/mp4' />
                                        <source
                                            src="{{ Utility::getpath(Utility::getsettings('business_growth_video')) }}"
                                            type="video/ogg">
                                    </video>
                                @else
                                    <img src="{{ asset('vendor/landing-page2/image/video-image.png') }}" width="100%"
                                        height="100%">
                                @endif
                            </div>
                            <a href="javascript:void(0);" class="play-btn" id="playButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="123" height="123"
                                    viewBox="0 0 123 123" fill="none">
                                    <path
                                        d="M90.3519 110.096C81.8393 115.252 71.8538 118.221 61.1745 118.221C30.0286 118.221 4.7793 92.9717 4.7793 61.8255C4.7793 30.6791 30.0286 5.43027 61.1745 5.43027C92.3207 5.43027 117.57 30.6791 117.57 61.8255C117.57 73.4073 113.999 84.1735 108.011 93.1296"
                                        stroke="#645BE1" stroke-width="9.55851" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M53.5816 80.2225L77.4064 66.4197C80.9328 64.3768 80.9328 59.2738 77.4064 57.2309L53.5816 43.4282C50.0528 41.3841 45.6406 43.9369 45.6406 48.0225V75.6282C45.6406 79.7139 50.0528 82.2668 53.5816 80.2225Z"
                                        stroke="#645BE1" stroke-width="9.55851" stroke-miterlimit="10"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{ asset('vendor/landing-page2/image/video-bg.png') }}" class="video-bg">
            <img src="{{ asset('vendor/landing-page2/image/video-bg-2.png') }}" class="video-bg-sec">
        </section>
        <section class="counter-sec pb">
            <div class="container">
                <div class="section-title">
                    <h2> {{ Utility::getsettings('business_growth_name')
                        ? Utility::getsettings('business_growth_name')
                        : __('Makes Quick') }}
                        <b>
                            {{ Utility::getsettings('business_growth_bold_name')
                                ? Utility::getsettings('business_growth_bold_name')
                                : __('Business Growth') }}
                        </b>
                    </h2>
                    <p>
                        {{ Utility::getsettings('business_growth_detail')
                            ? Utility::getsettings('business_growth_detail')
                            : __('Offer unique products, services, or solutions that stand out in the market. Innovation and
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            differentiation can attract customers and give you a competitive edge.') }}
                    </p>
                </div>
                <div class="main-counter-div">
                    <div class="row">
                        @if (isset($businessGrowthsViewSettings))
                            @foreach ($businessGrowthsViewSettings as $businessGrowthsViewSetting)
                                <div class="col-sm-4 col-12 ">
                                    <div class="text-center counter-iteam counter">
                                        <h3>
                                            <span class="count" data-target="2">
                                                {{ $businessGrowthsViewSetting->business_growth_view_amount }}
                                            </span>
                                        </h3>
                                        <span class="counter-content">
                                            {{ $businessGrowthsViewSetting->business_growth_view_name }} </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="advance-feature">
                <div class="advance-feature-slider">
                    @if (isset($businessGrowthsSettings))
                        @foreach ($businessGrowthsSettings as $businessGrowthsSetting)
                            <div>
                                <div class="advance-feature-card">
                                    <div class="advance-card-inner d-flex align-items-center">
                                        <div class="advance-card-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                viewBox="0 0 25 25" fill="none">
                                                <path
                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                    fill="#645BE1" />
                                            </svg>
                                        </div>
                                        <div class="advance-card-content">
                                            <p> {{ $businessGrowthsSetting->business_growth_title }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if (Utility::getsettings('testimonial_setting_enable') == 'on')
        <section class="testimonials-sec home-sec" id="testimonials">
            <div class="container">
                <div class="section-title">
                    <h2> {{ Utility::getsettings('testimonial_name') ? Utility::getsettings('testimonial_name') : __('Full Tenancy Laravel Admin Saas') }}
                        <b> {{ Utility::getsettings('testimonial_bold_name') ? Utility::getsettings('testimonial_bold_name') : __('Testimonial') }}
                        </b>
                    </h2>
                    <p>
                        {{ Utility::getsettings('testimonial_detail')
                            ? Utility::getsettings('testimonial_detail')
                            : __('A testimonial is an honest endorsement of your product or service that usually comes from a customer, colleague,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                or peer who has benefited from or experienced success as a result of the work you did for them.') }}
                    </p>
                </div>
                <div class="testimonial-slider">
                    @if (isset($testimonials))
                        @foreach ($testimonials as $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="testimonial-card-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="37"
                                            viewBox="0 0 42 37" fill="none">
                                            <path
                                                d="M2.10973 -2.722e-06L14.9411 -4.78488e-07C16.1061 -2.74801e-07 17.0515 0.945469 17.0515 2.11042L17.0515 14.9418C17.0515 16.1068 16.1061 17.0522 14.9411 17.0522L8.79977 17.0522C8.87997 20.412 9.66082 23.1007 11.1381 25.1225C12.3031 26.7179 14.0673 28.0391 16.4268 29.0816C17.5116 29.5586 17.9801 30.8417 17.4736 31.9139L15.9541 35.1217C15.4645 36.1515 14.2531 36.6032 13.2063 36.1515C10.4121 34.9444 8.05264 33.4164 6.12797 31.5593C3.78114 29.2927 2.17304 26.7348 1.30355 23.8815C0.434012 21.0282 -0.000693456 17.1366 -0.000692593 12.1982L-0.000690829 2.11042C-0.000690626 0.945508 0.944822 -2.92568e-06 2.10973 -2.722e-06Z"
                                                fill="black" />
                                            <path
                                                d="M36.6786 36.1431C33.9182 34.9402 31.5714 33.4123 29.634 31.5593C27.2661 29.2927 25.6496 26.7433 24.7801 23.9111C23.9106 21.0789 23.4759 17.1746 23.4759 12.1982L23.4759 2.11042C23.4759 0.945466 24.4213 -2.92569e-06 25.5863 -2.722e-06L38.4177 -4.78488e-07C39.5826 -2.74801e-07 40.5281 0.945469 40.5281 2.11042L40.5281 14.9418C40.5281 16.1068 39.5826 17.0522 38.4177 17.0522L32.2763 17.0522C32.3565 20.4121 33.1374 23.1007 34.6147 25.1225C35.7796 26.7179 37.5439 28.0391 39.9034 29.0816C40.9882 29.5586 41.4567 30.8417 40.9502 31.9139L39.4349 35.1133C38.9452 36.1431 37.7254 36.599 36.6786 36.1431Z"
                                                fill="black" />
                                        </svg>
                                        <p>{{ $testimonial->description }}</p>
                                        <div class="client-info">
                                            <div class="client-img">
                                                <img src="{{ Utility::getpath($testimonial->image) }}" width="100%"
                                                    height="100%">
                                            </div>
                                            <div class="client-name">
                                                <a href="javascript:void(0);">{{ $testimonial->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" class="testimonial-bg">
                <img src="{{ asset('vendor/landing-page2/image/test-bg-2.png') }}" class="testimonial-bg-2">
                <img src="{{ asset('vendor/landing-page2/image/test-bg-3.png') }}" class="testimonial-bg-3">
            </div>
        </section>
    @endif

    @if (Utility::getsettings('plan_setting_enable') == 'on')
        <section class="pricing-plans-sec pt pb home-sec" id="plans">
            <div class="container">
                @if (Utility::getsettings('plan_setting_enable') == 'on')
                    @if (tenant('id') == null)
                        <div class="section-title">
                            <h2> {{ Utility::getsettings('plan_name') ? Utility::getsettings('plan_name') : __('Simple, Flexible') }}
                                <b> {{ Utility::getsettings('plan_bold_name') ? Utility::getsettings('plan_bold_name') : __('Pricing') }}
                                </b>
                            </h2>
                            <p>
                                {{ Utility::getsettings('plan_detail')
                                    ? Utility::getsettings('plan_detail')
                                    : __('The pricing structure is easy to comprehend, and all costs and fees are explicitly stated. There
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                are no hidden charges or surprise costs for customers.') }}
                            </p>
                        </div>
                        <div class="row">
                            @foreach ($plans as $key => $plan)
                                @if ($plan->active_status == 1)
                                    <div class="col-md-6 col-lg-4 col-12 plans-top">
                                        <div
                                            class="basic-plans  @if ($key % 2 == 1) professional-plans @endif">
                                            <div class="basic-plans-top">
                                                <h3>
                                                    {{ $plan->name }}
                                                </h3>
                                                <ul>
                                                    <li class="d-flex align-items-center">
                                                        <div class="plan-card-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                                    fill="#645BE1" />
                                                            </svg>
                                                        </div>
                                                        <div class="plan-card-content">
                                                            <p>{{ $plan->max_users . ' ' . __('Users') }}</p>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <div class="plan-card-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                                    fill="#645BE1" />
                                                            </svg>
                                                        </div>
                                                        <div class="plan-card-content">
                                                            <p>{{ $plan->duration . ' ' . $plan->durationtype }}
                                                                {{ __('Duration') }}</p>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <div class="plan-card-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                                    fill="#645BE1" />
                                                            </svg>
                                                        </div>
                                                        <div class="plan-card-content">
                                                            <p>{{ $plan->max_roles . ' ' . __('Roles') }}</p>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <div class="plan-card-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                                    fill="#645BE1" />
                                                            </svg>
                                                        </div>
                                                        <div class="plan-card-content">
                                                            <p>{{ $plan->max_documents . ' ' . __('Documents') }}</p>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <div class="plan-card-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                                    fill="#645BE1" />
                                                            </svg>
                                                        </div>
                                                        <div class="plan-card-content">
                                                            <p>{{ $plan->max_blogs . ' ' . __('Blogs') }}</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div
                                                class="basic-plans-bottom justify-content-between d-flex align-items-center">
                                                <div class="basic-plans-price d-flex">
                                                    <div class="basic-price-left">
                                                        <p>{{ __('Billed') }}</p>
                                                        <ins>{{ $currency . '' . $plan->price }} </ins>
                                                    </div>
                                                    <div class="basic-price-right">
                                                        @if ($plan->discount_setting == 'on')
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="7"
                                                                    height="7" viewBox="0 0 7 7" fill="none">
                                                                    <path
                                                                        d="M3.3054 3.09353C2.49302 2.28126 1.60225 1.855 1.3157 2.14144C1.28426 2.17438 1.26112 2.21433 1.2482 2.25799L1.24359 2.25338L0.969932 3.37484L0.697428 4.49295L0.374405 5.8169L0.169922 6.65538L1.38058 6.19725L2.92044 5.61462L4.14891 5.14979L4.14744 5.14832C4.18856 5.13521 4.22619 5.11296 4.25749 5.08323C4.54404 4.79669 4.11778 3.90591 3.3054 3.09353Z"
                                                                        fill="#DD1C4B" />
                                                                    <path
                                                                        d="M3.3069 3.09362C2.49455 2.28127 1.60375 1.85499 1.31724 2.14151C1.03073 2.42802 1.457 3.31882 2.26935 4.13117C3.0817 4.94351 3.9725 5.36979 4.25901 5.08328C4.54552 4.79676 4.11925 3.90596 3.3069 3.09362Z"
                                                                        fill="#D1E3EE" />
                                                                    <path
                                                                        d="M4.03739 5.18625C3.89071 5.18882 3.74518 5.15994 3.61061 5.10156L2.60653 5.4815L1.06615 6.06361L0.240144 6.37615L0.169922 6.66406L1.38058 6.20594L2.92044 5.6233L4.04787 5.19673L4.03739 5.18625Z"
                                                                        fill="#B21D48" />
                                                                    <path
                                                                        d="M5.30594 4.35807C5.29339 4.35803 5.28095 4.35579 5.26916 4.35147C4.73708 4.15213 4.16192 4.09624 3.60143 4.18943L3.22705 4.25179C3.16975 4.25997 3.11666 4.22014 3.10848 4.16284C3.10058 4.10747 3.13754 4.05566 3.19246 4.04511L3.56695 3.98222C4.16376 3.88306 4.77615 3.94253 5.34273 4.15463C5.39721 4.17421 5.42549 4.23424 5.40592 4.28871C5.3908 4.33079 5.35066 4.35865 5.30594 4.35807Z"
                                                                        fill="#FFBF41" />
                                                                    <path
                                                                        d="M3.4206 3.72912C3.36272 3.72878 3.31607 3.68158 3.31641 3.6237C3.31664 3.58374 3.33957 3.54739 3.37553 3.52998L5.57653 2.48189C5.62881 2.457 5.69135 2.47919 5.71624 2.53146C5.74113 2.58374 5.71894 2.64628 5.66667 2.67117L3.46567 3.71927C3.45157 3.72586 3.43618 3.72923 3.4206 3.72912Z"
                                                                        fill="#FFBF41" />
                                                                    <path
                                                                        d="M2.19458 3.51945C2.18076 3.51947 2.16707 3.51673 2.15434 3.51138C2.10091 3.48909 2.07566 3.42772 2.09795 3.3743V3.37428L2.25034 3.0086C2.48481 2.44833 2.53949 1.82907 2.40682 1.23638C2.39322 1.18011 2.42782 1.12349 2.48408 1.10989C2.54035 1.09629 2.59697 1.13089 2.61057 1.18715C2.61087 1.18839 2.61115 1.18964 2.61141 1.1909C2.75353 1.82579 2.69493 2.48916 2.44372 3.08931L2.29122 3.45499C2.27495 3.49399 2.23685 3.51941 2.19458 3.51945Z"
                                                                        fill="#FFBF41" />
                                                                    <path
                                                                        d="M5.83022 4.77567C5.94571 4.77567 6.03934 4.68204 6.03934 4.56655C6.03934 4.45105 5.94571 4.35742 5.83022 4.35742C5.71472 4.35742 5.62109 4.45105 5.62109 4.56655C5.62109 4.68204 5.71472 4.77567 5.83022 4.77567Z"
                                                                        fill="#D5557E" />
                                                                    <path
                                                                        d="M3.31459 1.84159C3.43009 1.84159 3.52372 1.74796 3.52372 1.63246C3.52372 1.51697 3.43009 1.42334 3.31459 1.42334C3.1991 1.42334 3.10547 1.51697 3.10547 1.63246C3.10547 1.74796 3.1991 1.84159 3.31459 1.84159Z"
                                                                        fill="#DD95C1" />
                                                                    <path
                                                                        d="M2.37123 0.898228C2.25573 0.898228 2.16211 0.804606 2.16211 0.689104C2.16211 0.573602 2.25573 0.47998 2.37123 0.47998C2.48673 0.47998 2.58036 0.573602 2.58036 0.689104C2.58036 0.804606 2.48673 0.898228 2.37123 0.898228Z"
                                                                        fill="#7FCCCB" />
                                                                    <path
                                                                        d="M5.30785 1.31858C5.25002 1.31858 5.20312 1.27168 5.20312 1.21385V1.10912C5.20312 1.05129 5.25002 1.00439 5.30785 1.00439C5.36569 1.00439 5.41258 1.05129 5.41258 1.10912V1.21385C5.41258 1.27168 5.3657 1.31858 5.30785 1.31858Z"
                                                                        fill="#2276BB" />
                                                                    <path
                                                                        d="M5.30785 0.79465C5.25002 0.79465 5.20312 0.747758 5.20312 0.689923V0.585196C5.20312 0.52736 5.25002 0.480469 5.30785 0.480469C5.36569 0.480469 5.41258 0.52736 5.41258 0.585196V0.689923C5.41258 0.747758 5.3657 0.79465 5.30785 0.79465Z"
                                                                        fill="#2276BB" />
                                                                    <path
                                                                        d="M5.61961 1.00486H5.51488C5.45705 1.00486 5.41016 0.957973 5.41016 0.900137C5.41016 0.842302 5.45705 0.79541 5.51488 0.79541H5.61961C5.67745 0.79541 5.72434 0.842302 5.72434 0.900137C5.72434 0.957973 5.67746 1.00486 5.61961 1.00486Z"
                                                                        fill="#2276BB" />
                                                                    <path
                                                                        d="M5.09617 1.00486H4.99145C4.93361 1.00486 4.88672 0.957973 4.88672 0.900137C4.88672 0.842302 4.93361 0.79541 4.99145 0.79541H5.09617C5.15401 0.79541 5.2009 0.842302 5.2009 0.900137C5.2009 0.957973 5.15402 1.00486 5.09617 1.00486Z"
                                                                        fill="#2276BB" />
                                                                    <path
                                                                        d="M1.00174 3.51955C0.989998 3.47469 0.979517 3.42942 0.96977 3.3833L0.697266 4.50141L0.718228 4.75704C0.763911 5.30203 0.998029 5.81408 1.38031 6.20519L2.92027 5.62308C2.91189 5.62046 2.90319 5.61857 2.89481 5.61574C1.96102 5.26561 1.25522 4.48407 1.00174 3.51955Z"
                                                                        fill="white" />
                                                                    <path
                                                                        d="M2.92139 5.62248C2.913 5.61986 2.90431 5.61797 2.89592 5.61514C2.79504 5.57695 2.69623 5.53347 2.59994 5.48486L1.21289 6.00964C1.26548 6.07785 1.32177 6.14311 1.38153 6.20511L2.92139 5.62248Z"
                                                                        fill="#F6F6E7" />
                                                                    <path
                                                                        d="M4.57034 1.73584V2.26126H4.04492V1.73584H4.57034Z"
                                                                        fill="#C9DA53" />
                                                                    <path
                                                                        d="M2.68665 3.62236C2.62886 3.62235 2.58202 3.57548 2.58203 3.51769C2.58204 3.48805 2.59461 3.45981 2.61664 3.43997L3.66308 2.49817C3.70679 2.46035 3.77287 2.46513 3.81068 2.50883C3.84745 2.55131 3.84411 2.61525 3.8031 2.65367L2.75666 3.59547C2.73745 3.61277 2.71251 3.62235 2.68665 3.62236Z"
                                                                        fill="#FFBF41" />
                                                                    <path
                                                                        d="M5.72582 3.20481C5.66799 3.20481 5.62109 3.15791 5.62109 3.10008V2.99535C5.62109 2.93752 5.66799 2.89062 5.72582 2.89062C5.78366 2.89062 5.83055 2.93752 5.83055 2.99535V3.10008C5.83055 3.15791 5.78367 3.20481 5.72582 3.20481Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M6.09741 3.05174C6.06961 3.05182 6.04295 3.04077 6.02336 3.02105L5.94932 2.94701C5.90915 2.90541 5.91028 2.8391 5.95189 2.79893C5.99247 2.75973 6.05681 2.75973 6.09741 2.79893L6.17145 2.87297C6.21234 2.91388 6.21233 2.98018 6.17142 3.02108C6.1518 3.0407 6.12517 3.05174 6.09741 3.05174Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M6.24852 2.68113H6.14379C6.08595 2.68113 6.03906 2.63424 6.03906 2.57641C6.03906 2.51857 6.08595 2.47168 6.14379 2.47168H6.24852C6.30635 2.47168 6.35324 2.51857 6.35324 2.57641C6.35324 2.63424 6.30637 2.68113 6.24852 2.68113Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M6.02267 2.38427C5.96483 2.38425 5.91796 2.33736 5.91797 2.27951C5.91797 2.25175 5.929 2.22512 5.94863 2.2055L6.02267 2.13146C6.06427 2.09127 6.13056 2.09242 6.17075 2.13402C6.20995 2.1746 6.20995 2.23894 6.17075 2.27954L6.09671 2.35358C6.07708 2.37322 6.05045 2.38427 6.02267 2.38427Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M5.72582 2.26145C5.66799 2.26145 5.62109 2.21456 5.62109 2.15672V2.05199C5.62109 1.99416 5.66799 1.94727 5.72582 1.94727C5.78366 1.94727 5.83055 1.99416 5.83055 2.05199V2.15672C5.83055 2.21456 5.78367 2.26145 5.72582 2.26145Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M5.42748 2.38426C5.3997 2.38426 5.37308 2.37321 5.35344 2.35357L5.2794 2.27953C5.23922 2.23793 5.24036 2.17162 5.28197 2.13145C5.32255 2.09225 5.38689 2.09225 5.42748 2.13145L5.50153 2.20549C5.54242 2.2464 5.54241 2.3127 5.5015 2.3536C5.48188 2.37322 5.45525 2.38426 5.42748 2.38426Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M0.693143 0.584961L0.854818 0.912602L1.21636 0.965133L0.954753 1.22015L1.01649 1.58023L0.693143 1.41018L0.369792 1.58023L0.431532 1.22015L0.169922 0.965133L0.531468 0.912602L0.693143 0.584961Z"
                                                                        fill="#FFDB43" />
                                                                    <path
                                                                        d="M6.31975 6.15672C6.2699 5.98005 6.15512 5.82877 5.9984 5.73318L5.95522 5.66841C5.7131 5.30633 5.33237 5.06013 4.90283 4.98788C4.84553 4.97971 4.79244 5.01953 4.78427 5.07684C4.77637 5.1322 4.81332 5.18402 4.86824 5.19456C5.17806 5.24715 5.4604 5.40455 5.66805 5.64042C5.49347 5.67183 5.34079 5.77668 5.24881 5.92834C5.13593 6.1305 5.20831 6.38588 5.41048 6.49876C5.61264 6.61164 5.86802 6.53926 5.9809 6.33709C6.02402 6.25386 6.0473 6.16177 6.04892 6.06805C6.16044 6.23002 6.16936 6.44153 6.07188 6.61232C6.04235 6.66211 6.05876 6.72641 6.10855 6.75594C6.15833 6.78547 6.22263 6.76905 6.25216 6.71927C6.2531 6.71767 6.25401 6.71606 6.25487 6.71441C6.35009 6.54463 6.37345 6.34381 6.31975 6.15672ZM5.79811 6.2348C5.74217 6.33616 5.61466 6.37298 5.51331 6.31703C5.41194 6.26109 5.37513 6.13358 5.43107 6.03223C5.43139 6.03166 5.4317 6.03109 5.43201 6.03052C5.49386 5.92925 5.59819 5.86136 5.71584 5.84585C5.73406 5.84535 5.7521 5.84955 5.76824 5.85801C5.8567 5.90737 5.86142 6.12139 5.79811 6.2348Z"
                                                                        fill="#2BB3CE" />
                                                                </svg>
                                                                {{ __('SAVE') . ' ' . $plan->discount . __('%') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="basic-plans-button d-flex">
                                                    @if ($plan->id == 1)
                                                        <a href="{{ route('request.domain.create', Crypt::encrypt(['plan_id' => $plan->id])) }}"
                                                            class="mt-2 subscribe_plan btn btn-primary btn-block"
                                                            data-id="{{ $plan->id }}"
                                                            data-amount="{{ $plan->price }}">{{ __('Free') }}
                                                            <i class="ti ti-chevron-right ms-2"></i></a>
                                                    @elseif ($plan->id != 1)
                                                        <a href="{{ route('request.domain.create', Crypt::encrypt(['plan_id' => $plan->id])) }}"
                                                            class="mt-2 subscribe_plan btn btn-primary btn-block"
                                                            data-id="{{ $plan->id }}"
                                                            data-amount="{{ $plan->price }}">{{ __('Subscribe') }}
                                                            <i class="ti ti-chevron-right ms-2"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endif
                @if (Utility::getsettings('contactus_setting_enable') == 'on')
                    <div class="custom-pricing-div d-flex align-items-center justify-content-between">
                        <div class="custom-pricing-left">
                            <h4>
                                <b>{{ Utility::getsettings('contactus_name') ? Utility::getsettings('contactus_name') : __('Enterprise') }}</b>
                                {{ Utility::getsettings('contactus_bold_name') ? Utility::getsettings('contactus_bold_name') : __('Custom pricing') }}
                            </h4>
                        </div>
                        <div class="custom-pricing-center">
                            <p>
                                {{ Utility::getsettings('contactus_detail')
                                    ? Utility::getsettings('contactus_detail')
                                    : __('Offering tiered pricing options based on different levels of features or services allows
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        customers.') }}
                            </p>
                        </div>
                        <div class="custom-pricing-right">
                            <a href="{{ route('contact.us') }}" class="btn">{{ __('Contact us') }}</a>
                        </div>
                    </div>
                @endif
                <img src="{{ asset('vendor/landing-page2/image/features-bg-image') }}.png" class="pricing-bg">
            </div>
        </section>
    @endif

    @if (Utility::getsettings('faq_setting_enable') == 'on')
        <section class="home-faqs-sec pt home-sec" id="faqs">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="faqs-left-div">
                            <h2>
                                {{ Utility::getsettings('faq_name') ? Utility::getsettings('faq_name') : __('Frequently asked questions') }}
                            </h2>
                            <a href="{{ route('faqs.pages') }}" class="btn"> {{ __('View All FAQs') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                                    viewBox="0 0 17 11" fill="none">
                                    <path
                                        d="M15.8434 6.63069L12.4502 10.6141C12.2632 10.8337 12.0181 10.9434 11.773 10.9434C11.5279 10.9434 11.2828 10.8337 11.0958 10.6141C10.7218 10.175 10.7218 9.46319 11.0958 9.02412L12.8541 6.96L1.75847 6.96C1.22956 6.96 0.800781 6.45664 0.800781 5.83572C0.800781 5.21479 1.22956 4.71143 1.75847 4.71143L12.8541 4.71143L11.0958 2.64731C10.7218 2.20825 10.7218 1.4964 11.0958 1.05733C11.4698 0.61826 12.0762 0.61826 12.4502 1.05733L15.8434 5.04074C16.2174 5.47977 16.2174 6.19166 15.8434 6.63069Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="faqs-right-div">
                            @if (isset($faqs))
                                @foreach ($faqs as $faq)
                                    <div class="set has-children">
                                        <a href="javascript:;" class="nav-label">
                                            <span>{{ $faq->quetion }}</span>
                                        </a>
                                        <div class="nav-list">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" class="faqs-bg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (tenant('id') == null)
        @if (Utility::getsettings('announcements_setting_enable') == 'on')
            <section class="home-article-sec pt pb home-sec" id="announcementLists">
                <div class="container">
                    <div class="section-title">
                        <h2> {{ Utility::getsettings('announcements_title') ? Utility::getsettings('announcements_title') : 'Public Announcements' }}
                        </h2>
                        <p> {{ Utility::getsettings('announcement_short_description')
                            ? Utility::getsettings('announcement_short_description')
                            : 'Public Announcement of Voluntary Liquidation Process' }}
                        </p>
                    </div>
                    <div class="article-slider">
                        @foreach ($announcementLists as $announcementList)
                            <div class="article-card">
                                <div class="article-card-inner">
                                    <div class="article-card-image">
                                        <a href="{{ route('show.public.announcement', $announcementList->slug) }}">
                                            <img
                                                src="{{ isset($announcementList->image) ? Utility::getpath($announcementList->image) : asset('vendor/landing-page2/image/blog-card-img.png') }}">
                                        </a>
                                    </div>
                                    <div class="article-card-content">
                                        <div class="author-info d-flex align-items-center justify-content-between">
                                            <div class="date d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                    viewBox="0 0 23 23" fill="none">
                                                    <path
                                                        d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                        fill="black" />
                                                </svg>
                                                <span>{{ App\Facades\UtilityFacades::date_time_format($announcementList->created_at) }}</span>
                                            </div>
                                        </div>
                                        <h3>
                                            <a
                                                href="{{ route('show.public.announcement', $announcementList->slug) }}">{{ isset($announcementList->title) ? $announcementList->title : __('Benefits of Multi-Tenancy in Laravel Dashboard') }}</a>
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <img src="{{ asset('vendor/landing-page2/image/features-bg-image.png') }}" class="article-bg">
                </div>
            </section>
        @endif
    @endif

    @if (Utility::getsettings('blog_setting_enable') == 'on')
        @if (tenant('id') != null)
            <section class="home-article-sec pt pb home-sec" id="blogs">
                <div class="container">
                    <div class="section-title">
                        <h2> {{ Utility::getsettings('blog_name') ? Utility::getsettings('blog_name') : 'What’s New?' }}
                        </h2>
                        <p> {{ Utility::getsettings('blog_detail')
                            ? Utility::getsettings('blog_detail')
                            : 'Optimize your manufacturing business with Digitize, offering a seamless user interface for
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            streamlined operations, one convenient platform.' }}
                        </p>
                    </div>
                    <div class="article-slider">
                        @foreach ($blogs as $blog)
                            <div class="article-card">
                                <div class="article-card-inner">
                                    <div class="article-card-image">
                                        <a href="{{ route('view.blog', $blog->slug) }}">
                                            <img
                                                src="{{ isset($blog->photo) ? Utility::getpath($blog->photo) : asset('vendor/landing-page2/image/blog-card-img.png') }}">
                                        </a>
                                    </div>
                                    <div class="article-card-content">
                                        <div class="author-info d-flex align-items-center justify-content-between">
                                            <div class="date d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                    viewBox="0 0 23 23" fill="none">
                                                    <path
                                                        d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                        fill="black" />
                                                </svg>
                                                <span>{{ App\Facades\UtilityFacades::date_time_format($blog->created_at) }}</span>
                                            </div>
                                        </div>
                                        <h3>
                                            <a
                                                href="{{ route('view.blog', $blog->slug) }}">{{ isset($blog->title) ? $blog->title : __('Benefits of Multi-Tenancy in Laravel Dashboard') }}</a>
                                        </h3>
                                        <p>{!! isset($blog->short_description)
                                            ? $blog->short_description
                                            : __(
                                                'Exploring the advantages of implementing multi-tenancy, such as cost savings,scalability, easier maintenance, and improved security.',
                                            ) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <img src="{{ asset('vendor/landing-page2/image/features-bg-image.png') }}" class="article-bg">
                </div>
            </section>
        @endif
    @endif

    @if (Utility::getsettings('start_view_setting_enable') == 'on')
        <section class="contact-banner-sec pt pb home-sec" id="start_view">
            <div class="container">
                <div class="row contact-banner-row align-items-center">
                    <div class="col-md-6">
                        <div class="contact-banner-leftside">
                            <h2>
                                {{ Utility::getsettings('start_view_name')
                                    ? Utility::getsettings('start_view_name')
                                    : __('Start Using Prime Laravel Admin') }}
                            </h2>
                            <p>
                                {{ Utility::getsettings('start_view_detail')
                                    ? Utility::getsettings('start_view_detail')
                                    : __('Instead of forcing you to change how you write your code, the package by default
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            bootstraps tenancy automatically, in the background.') }}
                            </p>
                            <div class="contact-btn-wrapper d-flex align-items-center">
                                <a href="{{ route('login') }}" class="white-btn"> {{ __('Get Started') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                                        viewBox="0 0 17 11" fill="none">
                                        <path
                                            d="M15.728 6.42841L12.219 10.5478C12.0256 10.7749 11.7722 10.8884 11.5187 10.8884C11.2652 10.8884 11.0118 10.7749 10.8184 10.5478C10.4316 10.0938 10.4316 9.35761 10.8184 8.90355L12.6367 6.76896L1.16226 6.76896C0.615291 6.76896 0.171875 6.24841 0.171875 5.60629C0.171875 4.96417 0.615291 4.44362 1.16226 4.44362L12.6367 4.44362L10.8184 2.30903C10.4316 1.85497 10.4316 1.11882 10.8184 0.664763C11.2052 0.210704 11.8322 0.210704 12.219 0.664763L15.728 4.78417C16.1148 5.2382 16.1148 5.97438 15.728 6.42841Z"
                                            fill="#645BE1" />
                                    </svg>
                                </a>
                                <a href="{{ Utility::getsettings('start_view_link') ? Utility::getsettings('start_view_link') : route('register') }}"
                                    class="btn contact-btn">
                                    {{ Utility::getsettings('start_view_link_name') ? Utility::getsettings('start_view_link_name') : __('Register') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="demo-bannerimg">
                            <img src="{{ asset('vendor/landing-page2/image/bg-round.png') }}" class="demo-bg-img">
                            <img src="{{ Utility::getsettings('start_view_image')
                                ? Utility::getpath(Utility::getsettings('start_view_image'))
                                : asset('vendor/landing-page2/image/contact-us-banner.png') }}"
                                width="100% " height="100%">
                        </div>
                    </div>
                </div>
                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" class="contact-bg">
            </div>
        </section>
    @endif
@endsection
@push('javascript')
    <script>
        // landing page announcement js
        var headerHright = $('header').outerHeight();
        $('header').next('.home-sec').css('padding-top', headerHright + 'px');
    </script>
@endpush
