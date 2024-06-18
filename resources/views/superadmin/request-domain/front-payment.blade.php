@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.main-landing')
@section('title', __('Plan'))
@section('content')
    <section class="blog-page-banner"
        data-bg-image="{{ Utility::getsettings('background_image')
            ? Storage::url(Utility::getsettings('background_image'))
            : asset('vendor/landing-page2/image/blog-banner-image.png') }}"
        width="100% " height="100%">
        <div class="container">
            <div class="common-banner-content">
                <div class="section-title">
                    <h2>{{ __('Subscription Details') }}</h2>
                </div>
                <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                    <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                        <span>/</span>
                    </li>
                    <li><a href="javascript:void(0);">{{ __('Subscription Details') }}</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="plan-sec pt">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Billing Address') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-6 col-12 mb-md-0">
                                    <div class="flex-equal">
                                        <table class="table m-0 fs-6 gs-0 gy-2 gx-2">
                                            <tr>
                                                <td class="text-muted">{{ __('Bill to') }}:</td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 text-hover-primary">{{ $requestDomain->email }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Name') }}:</td>
                                                <td>{{ $requestDomain->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Domain') }}:</td>
                                                <td>{{ $requestDomain->domain_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="flex-equal flex-equal-right">
                                        <table class="table m-0 fs-6 gs-0 gy-2 gx-2">
                                            <tr>
                                                <td class="text-muted">{{ __('Subscription plan') }}:</td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 text-hover-primary">{{ $plan->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Subscription Description') }}:</td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 text-hover-primary">{{ isset($plan->description) ? $plan->description : '--' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Subscription Duration') }}:</td>
                                                <td>
                                                    {{ $plan->duration . ' ' . $plan->durationtype }}
                                                </td>
                                            </tr>
                                            <tr class="total_payable">
                                                <td class="text-muted">{{ __('Subscription Fees') }}:</td>
                                                <td>
                                                    {{ $adminPaymentSetting['currency_symbol'] }}{{ number_format($plan->price, 2) }}/{{ $plan->durationtype }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Disscount Price') }}:</td>
                                                <td class="discount_price">
                                                    {{ $adminPaymentSetting['currency_symbol'] }}0.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">{{ __('Total Price') }}:</td>
                                                <td class="final-price">
                                                    {{ $adminPaymentSetting['currency_symbol'] }}{{ number_format($plan->price, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Payment Methods') }}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-3 nav nav-tabs" id="myTab" role="tablist">
                                @if ($paymentTypes)
                                    @foreach ($paymentTypes as $key => $paymenttype)
                                        @php
                                            if (array_key_first($paymentTypes) == $key) {
                                                $active = 'active show';
                                            } else {
                                                $active = '';
                                            }
                                        @endphp

                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase {{ $active }} "
                                                id="{{ str_replace(' ', '_', $key) }}-tab" data-bs-toggle="tab"
                                                href="#payment{{ $key }}" role="tab" aria-controls="payment"
                                                aria-selected="true">{{ $paymenttype }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <h2>{{ 'Please contact to super admin for enable payments.' }}</h2>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                @foreach ($paymentTypes as $key => $paymenttype)
                                    @if (
                                        $key == 'stripe' &&
                                            $adminPaymentSetting['stripesetting'] == 'on' &&
                                            !empty($adminPaymentSetting['stripe_key']) &&
                                            !empty($adminPaymentSetting['stripe_secret']))
                                        @php
                                            $route = route('pre.stripe.pending');
                                            $id = 'stripe-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['stripe_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'paypal' &&
                                            $adminPaymentSetting['paypalsetting'] == 'on' &&
                                            !empty($adminPaymentSetting['paypal_client_id']) &&
                                            !empty($adminPaymentSetting['paypal_client_secret']))
                                        @php
                                            $route = route('process.transaction');
                                            $id = 'paypal-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['paypal_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'razorpay' &&
                                            isset($adminPaymentSetting['razorpaysetting']) &&
                                            $adminPaymentSetting['razorpaysetting'] == 'on')
                                        @php
                                            $route = route('razorpay.payment');
                                            $id = 'razorpay-payment-form';
                                            $button_type = 'button';
                                            $payment_description = $adminPaymentSetting['razorpay_description'];
                                        @endphp
                                    @elseif ($key == 'paytm' && isset($adminPaymentSetting['paytmsetting']) && $adminPaymentSetting['paytmsetting'] == 'on')
                                        @php
                                            $route = route('paytm.payment');
                                            $id = 'paytm-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['paytm_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'paystack' &&
                                            isset($adminPaymentSetting['paystacksetting']) &&
                                            $adminPaymentSetting['paystacksetting'] == 'on')
                                        @php
                                            $route = route('paystack.payment');
                                            $id = 'paystack-payment-form';
                                            $button_type = 'button';
                                            $payment_description = $adminPaymentSetting['paystack_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'flutterwave' &&
                                            isset($adminPaymentSetting['flutterwavesetting']) &&
                                            $adminPaymentSetting['flutterwavesetting'] == 'on')
                                        @php
                                            $route = route('flutterwave.payment');
                                            $id = 'flutterwave-payment-form';
                                            $button_type = 'button';
                                            $payment_description = $adminPaymentSetting['flutterwave_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'coingate' &&
                                            isset($adminPaymentSetting['coingatesetting']) &&
                                            $adminPaymentSetting['coingatesetting'] == 'on')
                                        @php
                                            $route = route('coingate.payment');
                                            $id = 'coingate-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['coingate_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'mercado' &&
                                            isset($adminPaymentSetting['mercadosetting']) &&
                                            $adminPaymentSetting['mercadosetting'] == 'on')
                                        @php
                                            $route = route('mercadopago.payment');
                                            $id = 'mercado-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['mercado_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'payfast' &&
                                            isset($adminPaymentSetting['payfastsetting']) &&
                                            $adminPaymentSetting['payfastsetting'] == 'on')
                                        @php
                                            $pfHost = $adminPaymentSetting['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                                            $route = 'https://' . $pfHost . '/eng/process';
                                            $id = 'payfast-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['payfast_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'toyyibpay' &&
                                            isset($adminPaymentSetting['toyyibpaysetting']) &&
                                            $adminPaymentSetting['toyyibpaysetting'] == 'on')
                                        @php
                                            $route = route('toyyibpay.charge');
                                            $id = 'toyyibpay-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['toyyibpay_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'iyzipay' &&
                                            isset($adminPaymentSetting['iyzipaysetting']) &&
                                            $adminPaymentSetting['iyzipaysetting'] == 'on')
                                        @php
                                            $route = route('iyzipay.init');
                                            $id = 'iyzipay-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['iyzipay_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'cashfree' &&
                                            isset($adminPaymentSetting['cashfreesetting']) &&
                                            $adminPaymentSetting['cashfreesetting'] == 'on')
                                        @php
                                            $route = route('cashfree.prepare');
                                            $id = 'cashfree-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['cashfree_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'aamarpay' &&
                                            $adminPaymentSetting['aamarpaysetting'] == 'on' &&
                                            !empty($adminPaymentSetting['aamarpay_store_id']) &&
                                            !empty($adminPaymentSetting['aamarpay_signature_key']))
                                        @php
                                            $route = route('plan.pay.aamarpay');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['aamarpay_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'paytab' &&
                                            $adminPaymentSetting['paytabsetting'] == 'on' &&
                                            !empty($adminPaymentSetting['paytab_profile_id']) &&
                                            !empty($adminPaymentSetting['paytab_server_key']))
                                        @php
                                            $route = route('plan.paytab');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['paytab_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'benefit' &&
                                            $adminPaymentSetting['benefitsetting'] == 'on' &&
                                            !empty($adminPaymentSetting['benefit_key']) &&
                                            !empty($adminPaymentSetting['benefit_secret_key']))
                                        @php
                                            $route = route('benefit.pay.initiate');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['benefit_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'mollie' &&
                                            $adminPaymentSetting['molliesetting'] == 'on' &&
                                            !empty($adminPaymentSetting['mollie_api_key']) &&
                                            !empty($adminPaymentSetting['mollie_profile_id']))
                                        @php
                                            $route = route('plan.pay.mollie');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['mollie_description'];
                                        @endphp
                                    @elseif ($key == 'skrill' && $adminPaymentSetting['skrillsetting'] == 'on' && !empty($adminPaymentSetting['skrill_email']))
                                        @php
                                            $route = route('plan.with.skrill');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['skrill_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'easebuzz' &&
                                            $adminPaymentSetting['easebuzzsetting'] == 'on' &&
                                            !empty($adminPaymentSetting['easebuzz_merchant_key']))
                                        @php
                                            $route = route('pay.easebuzz');
                                            $id = 'payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['easebuzz_description'];
                                        @endphp
                                    @elseif (
                                        $key == 'offline' &&
                                            isset($adminPaymentSetting['offlinesetting']) &&
                                            $adminPaymentSetting['offlinesetting'] == 'on')
                                        @php
                                            $route = route('offline.payment.entry');
                                            $id = 'offline-payment-form';
                                            $button_type = 'submit';
                                            $payment_description = $adminPaymentSetting['payment_details'];
                                        @endphp
                                    @endif
                                    @php
                                        if (array_key_first($paymentTypes) == $key) {
                                            $active = 'active show';
                                        } else {
                                            $active = '';
                                        }
                                    @endphp
                                    <div class="tab-pane fade {{ $active }}" id="payment{{ $key }}"
                                        role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', $key) }}-tab">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5>{{ __($paymenttype) }}</h5>
                                            </div>
                                            <form role="form" action="{{ $route }}" method="post"
                                                class="w3-container w3-display-middle w3-card-4" id="{{ $id }}">
                                                @csrf
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="mt-4 col-md-12">
                                                            @if ($payment_description != '')
                                                                <div class="form-group">
                                                                    <div class="form-label text-gray-800 frm-detail">
                                                                        {{ __('Description : ') }}{{ $payment_description }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($key == 'paytm')
                                                                <div class="form-group">
                                                                    <label for="mobile_number"
                                                                        class="form-label">{{ __('Mobile Number') }}</label>
                                                                    <input type="number" id="mobile_number" required
                                                                        name="mobile_number" class="form-control"
                                                                        placeholder="{{ __('Enter mobile number') }}">
                                                                </div>
                                                            @endif
                                                            <div class="d-flex coupne-code align-items-center">
                                                                <div class="form-group">
                                                                    <label for="paypal_coupon"
                                                                        class="form-label">{{ __('Coupon') }}</label>
                                                                    <input type="text" id="stripe_coupon" name="coupon"
                                                                        class="form-control coupon"
                                                                        placeholder="{{ __('Enter coupon code') }}">
                                                                </div>
                                                                <div class="mt-4 form-group ms-3">
                                                                    <a href="javascript:void(0)" class="text-muted"
                                                                        data-bs-toggle="tooltip"
                                                                        title="{{ __('Apply') }}"><i
                                                                            class="ti ti-square-check btn-apply"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($key == 'payfast')
                                                    <div id="get-payfast-inputs"></div>
                                                @endif
                                                <div class="card-footer">
                                                    <div class="text-end">
                                                        <button type="{{ $button_type }}" value="{{ __('Pay Now') }}"
                                                            id="pay_with_{{ $key }}"
                                                            class="btn btn-primary">{{ __('Pay Now') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/payment.css') }}" id="main-style-link">
@endpush
@push('javascript')
    @include('layouts.includes.alerts')
    <script src="{{ asset('vendor/jquery-form/jquery.form.js') }}"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    @if (env('PAYTM_ENVIRONMENT') == 'production')
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw.paytm.in\merchantpgpui\checkoutjs\merchants\{{ env('PAYTM_MERCHANT_ID') }}.js" ></script>
    @else
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw-stage.paytm.in\merchantpgpui\checkoutjs\merchants\{{ env('PAYTM_MERCHANT_ID') }}.js" ></script>
    @endif
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        // Landing Page Background Image
        document.addEventListener("DOMContentLoaded", function() {
            var bannerSection = document.querySelector(".blog-page-banner");
            var backgroundURL = bannerSection.getAttribute("data-bg-image");
            bannerSection.style.backgroundImage = "url(" + backgroundURL + ")";
        });

        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.btn-apply', function() {
                var ele = $(this);
                var coupon = ele.closest('.row').find('.coupon').val();
                $.ajax({
                    url: '{{ route('apply.coupon') }}',
                    datType: 'json',
                    data: {
                        plan_id: '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}',
                        coupon: coupon
                    },
                    success: function(data) {
                        if (data.final_price) {
                            $('.final-price').text(data.final_price);
                            $('.discount_price').text(data.discount_price);
                            // get_payfast_status(data.price, coupon);
                        }
                        $('#stripe_coupon, #paypal_coupon').val(coupon);
                        if (data != '') {
                            if (data.is_success == true) {
                                show_toastr("Successfully!", data.message, "success");
                            } else {
                                show_toastr("Error!", data.message, "danger");
                            }
                        } else {
                            show_toastr("Error!", "{{ __('Coupon code required.') }}",
                                "danger");
                        }
                    }
                })
            });
            @if (isset($adminPaymentSetting['stripesetting']) && $adminPaymentSetting['stripesetting'] == 'on')
                $(document).on("click", "#pay_with_stripe", function() {
                    $('#stripe-payment-form').ajaxForm(function(res) {
                        if (res.error) {
                            show_toastr("Error!", res.error, "danger");
                        }
                        const stripe = Stripe("{{ $adminPaymentSetting['stripe_key'] }}");
                        createCheckoutSession(res.plan_id, res.order_id, res.coupon, res
                            .total_price, res.domainrequest_id).then(function(data) {
                            if (data.sessionId) {
                                stripe.redirectToCheckout({
                                    sessionId: data.sessionId,
                                }).then(handleResult);
                            } else {
                                handleResult(data);
                            }
                        });
                    });
                }).submit();
                const createCheckoutSession = function(plan_id, order_id, coupon, amount, domainrequest_id) {
                    return fetch("{{ route('pre.stripe.session') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            createCheckoutSession: 1,
                            plan_id: plan_id,
                            order_id: order_id,
                            coupon: coupon,
                            amount: amount,
                            domainrequest_id: domainrequest_id,
                        }),
                    }).then(function(result) {
                        return result.json();
                    });
                };
                const handleResult = function(result) {
                    if (result.error) {
                        show_toastr("Error!", result.error.message, "danger");
                    }
                    setLoading(false);
                };
            @endif
            @if (isset($adminPaymentSetting['paystacksetting']) && $adminPaymentSetting['paystacksetting'] == 'on')
                $(document).on("click", "#pay_with_paystack", function() {
                    $('#paystack-payment-form').ajaxForm(function(res) {
                        var paystack_callback = "{{ url('/paystack/callback/') }}";
                        var order_id = '{{ time() }}';
                        var coupon_id = res.coupon;
                        var handler = PaystackPop.setup({
                            key: '{{ $adminPaymentSetting['paystack_key'] }}',
                            email: res.email,
                            amount: res.total_price * 100,
                            currency: res.currency,
                            ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                1
                            ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                            metadata: {
                                custom_fields: [{
                                    display_name: "Email",
                                    variable_name: "email",
                                    value: res.email,
                                }]
                            },

                            callback: function(response) {

                                window.location.href = paystack_callback + '/' +
                                    res.order_id + '/' +
                                    response
                                    .transaction +
                                    '/' + res.domainrequest_id +
                                    '/' + coupon_id

                            },
                            onClose: function() {

                                alert('window closed');
                            }
                        });
                        handler.openIframe();
                    }).submit();
                });
            @endif
            @if (isset($adminPaymentSetting['flutterwavesetting']) && $adminPaymentSetting['flutterwavesetting'] == 'on')
                $(document).on("click", "#pay_with_flutterwave", function() {
                    $('#flutterwave-payment-form').ajaxForm(function(res) {
                        var coupon_id = res.coupon;
                        var API_publicKey = '{{ $adminPaymentSetting['flutterwave_key'] }}';
                        var flutter_callback = "{{ url('/flutterwave/callback') }}";
                        const modal = FlutterwaveCheckout({
                            public_key: API_publicKey,
                            tx_ref: "titanic-48981487343MDI0NzMx",
                            amount: res.total_price,
                            currency: res.currency,
                            payment_options: "card, banktransfer, ussd",
                            callback: function(response) {
                                window.location.href = flutter_callback + '/' + res
                                    .order_id + '/' +
                                    response.transaction_id +
                                    '/' + res.domainrequest_id +
                                    '/' + coupon_id
                                modal.close();
                            },
                            onclose: function(incomplete) {
                                modal.close();
                            },
                            meta: {
                                consumer_id: res.plan_id,
                                consumer_mac: "92a3-912ba-1192a",
                            },
                            customer: {
                                email: res.email,
                                phone_number: '7421052101',
                                name: res.plan_name,
                            },
                            customizations: {
                                title: res.plan_name,
                                description: "Payment for an awesome cruise",
                                logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
                            },
                        });
                    }).submit();
                });
            @endif
            @if (isset($adminPaymentSetting['razorpaysetting']) && $adminPaymentSetting['razorpaysetting'] == 'on')
                $(document).on("click", "#pay_with_razorpay", function() {
                    $('#razorpay-payment-form').ajaxForm(function(res) {
                        var razorPay_callback = '{{ url('/razorpay/callback') }}';
                        var totalAmount = res.total_price * 100;
                        var coupon_id = res.coupon;
                        var options = {
                            "key": "{{ $adminPaymentSetting['razorpay_key'] }}", // your Razorpay Key Id
                            "amount": totalAmount,
                            "name": res.plan_name,
                            "currency": res.currency,
                            "description": "",
                            "handler": function(response) {
                                window.location.href = razorPay_callback + '/' + res
                                    .order_id + '/' +
                                    response.razorpay_payment_id +
                                    '/' + res.domainrequest_id +
                                    '/' + coupon_id
                            },
                            "theme": {
                                "color": "#528FF0"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    }).submit();
                });
            @endif
            @if (isset($adminPaymentSetting['paytmsetting']) && $adminPaymentSetting['paytmsetting'] == 'on')
                $(document).on("click", "#pay_with_paytm", function() {
                    $('#paytm-payment-form').ajaxForm(function(res) {
                        if (res.errors) {
                            show_toastr("Error!", res.errors, "danger");
                        }
                        window.Paytm.CheckoutJS.init({
                            "root": "",
                            "flow": "DEFAULT",
                            "data": {
                                "orderId": res.orderId,
                                "token": res.txnToken,
                                "tokenType": "TXN_TOKEN",
                                "amount": res.amount,
                            },
                            handler: {
                                transactionStatus: function(data) {},
                                notifyMerchant: function notifyMerchant(eventName, data) {
                                    if (eventName == "APP_CLOSED") {
                                        $('.paytm-pg-loader').hide();
                                        $('.paytm-overlay').hide();
                                    }
                                }
                            }
                        }).then(function() {
                            window.Paytm.CheckoutJS.invoke();
                        });
                    });
                }).submit();
            @endif
            @if (isset($adminPaymentSetting['payfastsetting']) &&
                    $adminPaymentSetting['payfastsetting'] == 'on' &&
                    !empty($adminPaymentSetting['payfast_merchant_id']) &&
                    !empty($adminPaymentSetting['payfast_merchant_key']))
                $(document).ready(function() {
                    get_payfast_status(amount = 0, coupon = null);
                });

                function get_payfast_status(amount, coupon) {
                    var plan_id = $('#plan_id').val();
                    $.ajax({
                        url: '{{ route('payfast.prepare') }}',
                        method: 'POST',
                        data: {
                            'plan_id': $('#payfast-payment-form').find('input[name="plan_id"]').val(),
                            'coupon': $('#payfast-payment-form').find('input[name="coupon"]').val(),
                            'amount': amount,
                            'order_id': $('#payfast-payment-form').find('input[name="order_id"]').val(),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success == true) {
                                $('#get-payfast-inputs').html('');
                                $('#get-payfast-inputs').append(data.inputs);
                            } else {
                                show_toastr("Error!", data.inputs, "danger");
                            }
                        }
                    });
                }
            @endif
        });
    </script>
@endpush
