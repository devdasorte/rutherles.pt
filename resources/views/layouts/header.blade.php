@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
    $plan_id = $users->plan_id;
    $plan_expire_date = '';
    $plan_message = '';


    if ($users->plan_id != 1) {
        $plan_expire_date = $users->plan_expire_date;
        $plan_message = 'Seu plano tem validade até' . $plan_expire_date;

    } else {
        $plan_message = 'Plano Gratuito';
    }

@endphp

<header class="dash-header {{ Utility::getsettings('transparent_layout') == 1 ? 'transprent-bg' : '' }}">
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="dropdown dash-h-item drp-company">
                    <a href="javascript:void(0)" class="dash-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                        <span>
                            <img src="{{ asset('assets/images/avatar/avatar.png') }}" class="rounded-circle mr-1">
                        </span>
                        <span class="hide-mob ms-2">{{ __('OI,') }} {{ Auth::user()->name }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{ route('perfil') }}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <a href="javascript:void(0)" class="dropdown-item"
                            onclick="document.getElementById('logout-form').submit()">
                            <i class="ti ti-power"></i>
                            <span>{{ __('Logout') }}</span>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form"> @csrf </form>
                        </a>
                    </div>
                </li>
            </ul>
        </div>




        <div class="ms-auto">
            <ul class="list-unstyled">
            
                @impersonating($guard = null)
                    <li class="dropdown dash-h-item drp-company">
                        <a class="btn btn-primary btn-active-color-primary btn-outline-secondary me-3"
                            href="{{ route('impersonate.leave') }}"><i class="ti ti-ban"></i>
                            {{ __('Exit Impersonation') }}
                        </a>
                    </li>
                @endImpersonating
                <li class="dash-h-item theme_mode">
                    <a class="dash-head-link add_dark_mode me-0" role="button">
                        <i class="ti {{ Auth::user()->dark_layout == 0 ? 'ti-sun' : 'ti-moon' }}"></i>
                    </a>
                </li>

                <li class="dropdown dash-h-item drp-notification">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" id="kt_activities_toggle"
                        data-bs-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-bell"></i>
                        <span
                            class="bg-danger dash-h-badge
                                @if (auth()->user()->unreadnotifications->count()) dots @endif"><span
                                class="sr-only"></span></span>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                        <div class="noti-header">
                            <h5 class="m-0">{{ __('Notification') }}</h5>
                        </div>
                        <div class="noti-body ps">
                            @foreach (auth()->user()->notifications->where('read_at', '=', '') as $notification)
                                <div class="d-flex align-items-start my-4">
                                    @if ($notification->type == 'App\Notifications\Superadmin\RegisterNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New Domain Request') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['domain']['email']) ? $notification->data['data']['domain']['email'] : '' }}{{ __(' User Create and') }}
                                                    {{ __('User Domain Name:') }}
                                                    {{ isset($notification->data['data']['domain']['domain_name']) ? $notification->data['data']['domain']['domain_name'] : '' }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (
                                        $notification->type == 'App\Notifications\Superadmin\ConatctNotification' ||
                                            $notification->type == 'App\Notifications\Admin\ConatctNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New Enquiry') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['email']) ? $notification->data['data']['email'] : '' }}{{ __(' Enquiry Details') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\Superadmin\ApproveNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Domain Verified') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Domain') }}
                                                    {{ isset($notification->data['data']['alldata']['domain_name']) ? $notification->data['data']['alldata']['domain_name'] : '' }}{{ __(' is Verified By SuperAdmin') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\Superadmin\DisapprovedNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Domain Unverified') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Domain') }}
                                                    {{ isset($notification->data['data']['alldata']['domain_name']) ? $notification->data['data']['alldata']['domain_name'] : '' }}{{ __(' is not Verified By SuperAdmin') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (
                                        $notification->type == 'App\Notifications\Superadmin\ApproveOfflineNotification' ||
                                            $notification->type == 'App\Notifications\Admin\ApproveOfflineNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Offline Payment Request Verified') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Plan Update Request') }}
                                                    {{ isset($notification->data['data']['alldata']['email']) ? $notification->data['data']['alldata']['email'] : '' }}{{ __(' is Verified By Super Admin') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (
                                        $notification->type == 'App\Notifications\Superadmin\DisapprovedOfflineNotification' ||
                                            $notification->type == 'App\Notifications\Admin\DisapprovedOfflineNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Offline Payment Request Unverified') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Request Payment') }}
                                                    {{ isset($notification->data['data']['alldata']['email']) ? $notification->data['data']['alldata']['email'] : '' }}{{ __(' is Disapprove By Super Admin') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\Superadmin\SupportTicketNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New Ticket Opened') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['alldata']['ticket_id']) ? $notification->data['data']['alldata']['ticket_id'] : '' }}{{ __(' Ticket Opened') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\Superadmin\ReceiveTicketReplyNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Received Ticket Reply') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Ticket id') }}
                                                    {{ isset($notification->data['data']['alldata']['ticket_id']) ? $notification->data['data']['alldata']['ticket_id'] : '' }}{{ __(' New Reply') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\Superadmin\SupportTicketReplyNotification')
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Send Ticket Reply') }}</h6>
                                                </a>
                                                <a href="javascript:void(0);" class="text-hover-danger"><i
                                                        class="ti ti-x"></i></a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('Your Ticket id') }}
                                                    {{ isset($notification->data['data']['alldata']['ticket_id']) ? $notification->data['data']['alldata']['ticket_id'] : '' }}{{ __(' New Reply') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>


                    </div>



                </li>
                <li class="dropdown dash-h-item drp-language d-none ">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-world nocolor"></i>
                        <span class="drp-text hide-mob">{{ Str::upper($currantLang) }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>

                </li>
            </ul>
        </div>



    </div>

    



</header>




@push('javascript')
    <script>
        $(document).on("click", "#kt_activities_toggle", function() {
            $.ajax({
                url: '{{ route('admin.read.notification') }}',
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

        setTimeout(function() {
            document.querySelector(".loader-bg").remove();
        }, 400);
        // remove pre-loader end
        if (!document.querySelector("body").classList.contains("dash-horizontal")) {
            addscroller();
        }
        if (document.querySelector("body").classList.contains("dash-horizontal")) {
            if (
                document
                .querySelector(".dash-horizontal")
                .classList.contains("navbar-overlay")
            ) {
                addscroller();
            }
        }
        var hamburger = document.querySelector(".hamburger:not(.is-active)");
        if (hamburger) {
            hamburger.addEventListener("click", function() {
                if (
                    document.querySelector(".hamburger").classList.contains("is-active")
                ) {
                    document.querySelector(".hamburger").classList.remove("is-active");
                } else {
                    document.querySelector(".hamburger").classList.add("is-active");
                }
            });
        }
        // Menu overlay layout start
        var tempoverlaymenu = document.querySelector("#overlay-menu");
        if (tempoverlaymenu) {
            tempoverlaymenu.addEventListener("click", function() {
                menuclick();
                if (
                    document
                    .querySelector(".dash-sidebar")
                    .classList.contains("dash-over-menu-active")
                ) {
                    rmovermenu();
                } else {
                    document
                        .querySelector(".dash-sidebar")
                        .classList.add("dash-over-menu-active");
                    document
                        .querySelector(".dash-sidebar")
                        .insertAdjacentHTML(
                            "beforeend",
                            '<div class="dash-menu-overlay"></div>'
                        );
                    document
                        .querySelector(".dash-menu-overlay")
                        .addEventListener("click", function() {
                            rmovermenu();
                            document.querySelector(".hamburger").classList.remove("is-active");
                        });
                }
            });
        }
        // Menu overlay layout end
        // vertical-nav-toggle start

        var verticalnavtoggle = document.querySelector("#vertical-nav-toggle");
        if (verticalnavtoggle) {
            verticalnavtoggle.addEventListener("click", function() {
                if (document.body.classList.contains("minimenu")) {
                    document.body.classList.remove("minimenu");
                    // menuclick();

                    // ===============
                    var elem = document.querySelectorAll(
                        ".dash-navbar li:not(.dash-trigger) .dash-submenu"
                    );
                    for (var j = 0; j < elem.length; j++) {
                        elem[j].style.display = "none";
                    }
                    // ===============
                } else {
                    document.body.classList.add("minimenu");
                    var tc = document.querySelectorAll(".dash-navbar li .dash-submenu");
                    for (var t = 0; t < tc.length; t++) {
                        var c = tc[t];
                        c.removeAttribute("style");
                    }
                    collapseedge();
                }
            });
        }
        // vertical-nav-toggle end
        // Menu collapse click start
        var mobilecollapsever = document.querySelector("#mobile-collapse");
        if (mobilecollapsever) {
            mobilecollapsever.addEventListener("click", function() {
                if (
                    !document.querySelector("body").classList.contains("dash-horizontal")
                ) {
                    // menuclick();
                }
                var tempsdbr = document.querySelector(".dash-sidebar");
                if (tempsdbr) {
                    if (
                        document
                        .querySelector(".dash-sidebar")
                        .classList.contains("mob-sidebar-active")
                    ) {
                        rmmenu();
                    } else {
                        document
                            .querySelector(".dash-sidebar")
                            .classList.add("mob-sidebar-active");
                        document
                            .querySelector(".dash-sidebar")
                            .insertAdjacentHTML(
                                "beforeend",
                                '<div class="dash-menu-overlay"></div>'
                            );
                        document
                            .querySelector(".dash-menu-overlay")
                            .addEventListener("click", function() {
                                document
                                    .querySelector(".hamburger")
                                    .classList.remove("is-active");
                                rmmenu();
                            });
                    }
                }
            });
        }
        // Menu collapse click end

        // Menu collapse click start
        var mobilecollapse = document.querySelector(
            ".dash-horizontal #mobile-collapse"
        );
        if (mobilecollapse) {
            mobilecollapse.addEventListener("click", function() {
                if (
                    document
                    .querySelector(".topbar")
                    .classList.contains("mob-sidebar-active")
                ) {
                    rmmenu();
                } else {
                    document.querySelector(".topbar").classList.add("mob-sidebar-active");
                    document
                        .querySelector(".topbar")
                        .insertAdjacentHTML(
                            "beforeend",
                            '<div class="dash-menu-overlay"></div>'
                        );
                    document
                        .querySelector(".dash-menu-overlay")
                        .addEventListener("click", function() {
                            rmmenu();
                            document.querySelector(".hamburger").classList.remove("is-active");
                        });
                }
            });
        }

        var topbarlinklist = document.querySelector(
            ".dash-horizontal .topbar .dash-navbar>li>a"
        );
        if (topbarlinklist) {
            topbarlinklist.addEventListener("click", function(e) {
                var targetElement = e.target;
                setTimeout(function() {
                    targetElement.parentNodes.children[1].removeAttribute("style");
                }, 1000);
            });
        }
        // Horizontal menu click js end

        function formmat(e) {
            var temp = 0;
            try {
                temp = e.attr("placeholder").length;
            } catch (err) {
                temp = 0;
            }
            if (e.value.length > 0) {
                e.parentNode(".form-group").classList.add("fill");
            } else {
                e.parentNode(".form-group").classList.remove("fill");
            }
        }
        // Material form end
        if (document.querySelector("body").classList.contains("dash-horizontal")) {
            horizontalmobilemenuclick();
        }
        if (document.querySelector("body").classList.contains("minimenu")) {
            collapseedge();
        }
        // notification scrollbar start
        if (document.querySelector(".drp-notification .noti-body")) {
            var px = new PerfectScrollbar(".drp-notification .noti-body", {
                wheelSpeed: 0.5,
                swipeEasing: 0,
                suppressScrollX: !0,
                wheelPropagation: 1,
                minScrollbarLength: 40,
            });
        }
        // notification scrollbar end


        if (typeof window.slideUp !== "function") {
            window.slideUp = function(target, duration = 0) {
                if (!target) return; // Verifica se o target é válido
                target.style.transitionProperty = "height, margin, padding";
                target.style.transitionDuration = `${duration}ms`;
                target.style.boxSizing = "border-box";
                target.style.height = `${target.offsetHeight}px`;
                target.offsetHeight; // Força o reflow para garantir que a transição ocorra
                target.style.overflow = "hidden";
                target.style.height = 0;
                target.style.paddingTop = 0;
                target.style.paddingBottom = 0;
                target.style.marginTop = 0;
                target.style.marginBottom = 0;

                window.setTimeout(() => {
                    target.style.display = "none";
                    target.style.removeProperty("height");
                    target.style.removeProperty("overflow");
                    target.style.removeProperty("transition-duration");
                    target.style.removeProperty("transition-property");
                    target.style.removeProperty("padding-top");
                    target.style.removeProperty("padding-bottom");
                    target.style.removeProperty("margin-top");
                    target.style.removeProperty("margin-bottom");
                }, duration);
            };
        }
    </script>
@endpush
