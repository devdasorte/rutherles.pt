@php
    $primary_color = \App\Facades\UtilityFacades::getsettings('color');
    if (isset($primary_color)) {
        $color = $primary_color;
    } else {
        $color = 'theme-1';
    }
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
  
  
   
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' || $currantLang == 'ar' ? 'rtl' : '' }}">

<head>


    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
        content="{{ !empty(Utility::getsettings('meta_title')) ? Utility::getsettings('meta_title') : 'Full Multi Tenancy Laravel Admin Saas' }}">
    <meta name="keywords"
        content="{{ !empty(Utility::getsettings('meta_keywords')) ? Utility::getsettings('meta_keywords') : 'Full Multi Tenancy Laravel Admin Saas,Multi Domains,Multi Databases' }}">
    <meta name="description"
        content="{{ !empty(Utility::getsettings('meta_description')) ? Utility::getsettings('meta_description') : 'Discover the efficiency of Full Multi Tenancy, a user-friendly web application by Quebix Apps.' }}">
    <meta property="og:image"
        src="{{ !empty(Utility::getsettings('meta_image_logo'))
            ? Utility::getpath(Utility::getsettings('meta_image_logo'))
            : Storage::url('seeder-image/meta-image-logo.jpg') }}">

    <title>@yield('title') | {{ Utility::getsettings('app_name') }}</title>
    <link rel="icon" href="{{ Utility::getpath('logo/app-favicon-logo.png') }}" type="image/png">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

  

    {{-- Payment Coupon Checkbox --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
  
     <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">



    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">


    {{-- toggle button --}}




    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    @if (Auth::user()->rtl_layout == '1' || $currantLang == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    @if (Auth::user()->dark_layout == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('assets/css/telescope-dark.css') }}" id="telescope-style-link">
    @elseif(Auth::user()->rtl_layout != '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('assets/css/telescope.css') }}" id="telescope-style-link">
    @endif

    @stack('css')
</head>

<body class="{{ $color }}">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>


    @include('layouts.sidebar_SA')

    @include('layouts.header')
   

   
    <div class="dash-container">
        <div class="dash-content">
            
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                      
               
                          @yield('content')
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <div class="modal fade modal-animate anim-blur" id="common_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body"></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-animate anim-blur" id="common_modal1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="pt-5 modal-body px-xl-20">
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
   
 


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    {{-- tostr notification close --}}
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    {{-- sidebar active deactive menu --}}

    <script src="{{ asset('assets/js/dash.js') }}"></script>
    {{-- Form-validation  --}}
    <script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/form-validation.js') }}"></script>
    {{-- notification , alert pop-up --}}
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/notifier/bootstrap-notify.min.js') }}"></script>
    {{-- toggle button --}}
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @include('layouts.includes.alerts')

    @stack('javascript')

    @if (!empty(Utility::getsettings('gtag')))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ Utility::getsettings('gtag') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ Utility::getsettings('gtag') }}');
        </script>
    @endif

    <script>
        $(document).on("click", "#kt_activities_toggle", function() {
            $.ajax({
                url: '{{ tenant('id') == null ? route('read.notification') : route('admin.read.notification') }}',
                data: {
                    _token: $("meta[name='csrf-token']").attr('content')
                },
                method: 'post',
            }).done(function(data) {
                if (data.is_success) {
                    $("#kt_activities_toggle").find(".animation-blink").remove();
                }
            });
        });

       // feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }

        $(document).ready(function() {
            $('.add_dark_mode').on('click', function() {
                var $this = $(this);
                $.ajax({
                    url: "{{ route('change.theme.mode') }}",
                    method: "POST",
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                    },
                    success: function(response) {
                        if (response.mode == 1) {
                            $this.find('i').removeClass('ti-sun').addClass('ti-moon');
                            $(".m-headers > .b-brand > img").attr(
                                "src",
                                "{{ Storage::url(Utility::getsettings('app_logo')) ? Utility::getpath('logo/app-logo.png') : asset('assets/images/logo/app-logo.png') }}"
                            );
                            document.querySelector("#main-style-link").setAttribute("href",
                                "{{ asset('assets/css/style-dark.css') }}"
                            );
                            document.querySelector("#telescope-style-link").setAttribute("href",
                                "{{ asset('vendor/telescope/app-dark.css') }}"
                            );
                        } else {
                            $this.find('i').removeClass('ti-moon').addClass('ti-sun');
                            document.querySelector(".m-headers > .b-brand > img").setAttribute(
                                "src",
                                "{{ Utility::getsettings('app_dark_logo') ? Utility::getpath('logo/app-dark-logo.png') : asset('assets/logo/images/app-dark-logo.png') }}"
                            );
                            $(".m-headers > .b-brand > img").attr(
                                "src",
                                response.app_dark_logo_url
                            );
                            document.querySelector("#main-style-link").setAttribute("href",
                                "{{ asset('assets/css/style.css') }}"
                            );
                            document.querySelector("#telescope-style-link").setAttribute("href",
                                "{{ asset('vendor/telescope/app.css') }}"
                            );
                        }
                    }
                });
            });
        });
    </script>

    @if (Utility::getsettings('cookie_setting_enable') == 'on')
        @include('layouts.cookie-consent')
    @endif
    @livewireScripts
</body>

</html>
