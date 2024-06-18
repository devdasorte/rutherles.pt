@php
    $primary_color = \App\Facades\UtilityFacades::getsettings('color');
    $color = $primary_color ?? 'theme-1';
    $user = \Auth::user();
    $path = request()->path();

    include app_path('Includes/settings.php');
@endphp
<!DOCTYPE html>
<html x-data="data()" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
        content="{{ !empty(Utility::getsettings('meta_title')) ? Utility::getsettings('meta_title') : 'Viver de Rifa' }}">
    <meta name="keywords"
        content="{{ !empty(Utility::getsettings('meta_keywords')) ? Utility::getsettings('meta_keywords') : 'Viver de Rifa' }}">
    <meta name="description"
        content="{{ !empty(Utility::getsettings('meta_description')) ? Utility::getsettings('meta_description') : 'Rifas e fazendinha.' }}">
    <meta property="og:image"
        content="{{ !empty(Utility::getsettings('meta_image_logo')) ? Utility::getpath(Utility::getsettings('meta_image_logo')) : Storage::url('seeder-image/meta-image-logo.jpg') }}">

    <title> {{$title}} | {{ Utility::getsettings('app_name') }}</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <link rel="icon" href="{{ Utility::getpath('logo/app-favicon-logo.png') }}" type="image/png">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- Payment Coupon Checkbox --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('assets/admin/css/tailwind.output.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    {{-- toggle button --}}

    <script src="{{ asset('assets/admin/js/focus-trap.js') }}"></script>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    @if ($path !== 'settings')
        <link id="tw-1" rel="stylesheet" href="{{ asset('assets/build/assets/app-DpKivxkK.css') }}">
        <link id="tw-2" rel="stylesheet" href="{{ asset('assets/admin/css/tailwind.output.css') }}">
  
    @endif

    
    @if ($user->dark_layout == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif


    <script src="{{ asset('assets/admin/js/init-alpine.js') }}"></script>



    @stack('css')

    <script>
        var _base_url_ = "{{ BASE_URL }}";
        var _BASE_URL_ = "{{ BASE_URL }}";
    </script>
</head>


<body class="{{ $color }}">

      

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>



    @include('layouts.sidebar')

    @include('layouts.header')




    <div class="dash-container">

        @livewire('componentes.modal', ['id' => 'mymodal'])

        <div class="dash-content">

            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="page-header-title">
                                <h4 class="m-b-10">@yield('title')</h4>
                            </div>

                        </div>
                        <div class="col">
                            @yield('action-btn')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @yield('content')

                </div>
            </div>
        </div>
    </div>




    @include('layouts.footer')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>



    {{-- <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>   --}}
    <script src="{{ asset('assets/js/dash.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/form-validation.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/notifier/bootstrap-notify.min.js') }}"></script>


    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('vendor/modules/moment.min.js') }}"></script>

    @include('layouts.includes.alerts')


    <script>
        document.addEventListener('livewire:navigated', (event) => {

            event.preventDefault()
            const context = event.srcElement;
            const t1 = context.getElementById('tw-1');
            const t2 = context.getElementById('tw-2');
            const path = event.target.location.pathname;            ;



            console.log(path);
   
            if (path == '/settings') {
                if (t1) {
                   t1.remove();

                } else if (t2) {
                   t2.remove();
                }


            }

        })
    </script>


    @stack('javascript')



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



        //{//{// feather.replace()}}
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

                        }
                    }
                });
            });
        });
    </script>


</body>

</html>
