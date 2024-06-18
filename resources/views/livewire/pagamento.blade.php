<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
</head>


<style>
    .modal.fade.show {
        opacity: 1;
        display: block;

    }

    .ticket__qrcode-image {
        width: 200px;
        margin-inline: auto;

    }

    .ticket__instruction {
        margin: 16px 0;
    }

    .ticket__instruction--step {
        display: flex;
        line-height: 0;
    }

    .ticket__circle-count {
        align-items: center;
        border: 2px solid #009ee3;
        border-radius: 50%;
        box-sizing: border-box;
        color: #009ee3;
        display: flex;
        flex-shrink: 0;
        font-size: 15px;
        height: 26px;
        justify-content: center;
        margin-right: 16px;
        width: 26px;
    }

    .ticket__circle-count span {
        margin-bottom: .5px;
        margin-left: .5px;
    }

    .ticket__small-text {
        font-size: 14px;
        line-height: 18px;
    }

    .ticket__instruction-title {
        font-size: 18px;
        font-weight: 700;
        line-height: 25px;
        margin: 16px 0;
        text-align: left;
    }
</style>
<main class="h-full pb-16 overflow-y-auto">




    <div class="container grid px-6 mx-auto">

        <div class="bg-white dark:bg-gray-800 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-4xl sm:text-center">
                    <h2 class="text-base font-semibold leading-7 text-gray-600 dark:text-gray-200">Planos e Assinaturas
                    </h2>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-5xl">
                        Escolha o plano ideal para você
                    </p>
                </div>
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-200 sm:text-center">
                    Escolha o plano que melhor se adapta às suas necessidades e comece a concorrer agora mesmo!


                </p>

                <?= 'status' . $status ?>




                <div class="modal fade " id="checkout" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <div id="statusScreenBrick" class="mt-20"
                            style="max-width: 100%;--text-primary-color: #1A1A1A;--text-secondary-color: #737373;--input-background-color: #fff;--form-background-color: #fff;--secondary-background-color: #F5F5F5;--base-color: #009EE3;--base-color-first-variant: #007EB5;--base-color-second-variant: #005E88;--secondary-color: #E4F0F8;--error-color: #F23D4F;--warning-color: #FF7733;--success-color: #00A650;--outline-primary-color: #BFBFBF;--outline-secondary-color: #E5E5E5;--disabled-text-color: #BFBFBF;--disabled-background-color: #F5F5F5;--button-text-color: #fff;--font-size-extra-small: 12px;--font-size-small: 13px;--font-size-medium: 14px;--font-size-large: 16px;--font-size-extra-large: 18px;--font-size-extra-extra-large: 20px;--font-weight-normal: 400;--font-weight-semi-bold: 600;--form-inputs-text-transform: none;--input-vertical-padding: 8px;--input-horizontal-padding: 12px;--input-focused-box-shadow: 0px 0px 0px 3px transparent;--input-error-focused-box-shadow: 0px 0px 0px 3px transparent;--input-border-width: 1px;--input-focused-border-width: 2px;--border-radius-small: 4px;--border-radius-medium: 6px;--border-radius-large: 12px;--border-radius-full: 100%;--form-padding: 16px;--skeleton-light-color: #F5F5F5;--skeleton-dark-color: #DBDBDB;--skeleton-border-color: #E5E5E5CF;--input-min-height: 38px;--label-spacing: 4px;--row-spacing: 18px;--button-padding: 14px 48px;--row-gap: 16px;--width-small: 16px;--height-small: 16px;--width-medium: 36px;--height-medium: 24px;--wallet-icon-background-color: #F5F5F5;--link-text-color: #009EE3; pointer-events:auto">

                            <div class="fade-wrapper-34hB2J svelte-18v2ee9" style="">
                                <section class="svelte-1dfe9c6">
                                    <header>
                                        <div class="svelte-ax97e0">
                                            <div>
                                                <div class="row-110EZX svelte-pfis07">
                                                    <div class="banner-Xq-sBS svelte-pfis07 success-17Dpf_">
                                                    </div>
                                                    <div class="icon-VMfCsI svelte-pfis07 success-17Dpf_"><svg
                                                            data-testid="success" width="18" height="14"
                                                            viewBox="0 0 18 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M6.74857 9.79197L15.9019 0.638672L17.9589 2.69571L6.74857 13.906L0.386719 7.54419L2.44376 5.48716L6.74857 9.79197Z"
                                                                fill="var(--form-background-color)"></path>
                                                        </svg></div>
                                                </div>
                                                <div class="row-110EZX svelte-pfis07">
                                                    <h1 id="value" class="svelte-1ghw4p8 extra-extra-large-1GVurj">
                                                        Pague R$
                                                        0,10 via pix</h1>
                                                    <h2 id="dueDate"
                                                        class="svelte-1jwum41 secondary-style-gCK82g padding-top-2ELFwu">
                                                        Vencimento:
                                                        12
                                                        de
                                                        junho às
                                                        02:53 h.</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </header>
                                    <div class="status-body-3Mumug svelte-1dfe9c6" style="position: relative;">
                                        <section class="svelte-h9a98r">

                                            <div class="svelte-1f3lu4g container-small-1cE5Z_ "
                                                style="position: relative;">
                                                <div class="ticket__qrcode-image hidden"><img alt="QRCode"
                                                        class="ticket__qrcode-canva--desktop" id="qrCode"
                                                        src=""></div>
                                                <input id="paymentCode" inputmode="text" type="text"
                                                    name="paymentCode" placeholder="" disabled=""
                                                    class="svelte-7y0bx9"
                                                    style="height:40px;
                                                             margin-bottom: 20px;
                                                            ">


                                                </input> <button id="copyCode" class="svelte-1bb0x5s"> <span
                                                        class="svelte-1bb0x5s">Copiar
                                                        Código</span></button>
                                                <button id="showQR"
                                                    class="svelte-1bb0x5s secondary-2q8mFz margin-3bc9tb"> <span
                                                        class="svelte-1bb0x5s">Abrir código QR</span></button>

                                                <div class="ticket__instruction-title">Como pagar?</div>
                                                <div class="ticket__instruction">
                                                    <div class="ticket__instruction--step">
                                                        <div class="ticket__circle-count"><span>1</span></div>
                                                        <div class="ticket__instruction--step-text"><span
                                                                class="ticket__small-text">Entre no app ou site do seu
                                                                banco e escolha a opção de pagamento via Pix.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ticket__instruction">
                                                    <div class="ticket__instruction--step">
                                                        <div class="ticket__circle-count"><span>2</span></div>
                                                        <div class="ticket__instruction--step-text"><span
                                                                class="ticket__small-text">Escaneie o código QR ou copie
                                                                e cole o código de pagamento.</span></div>
                                                    </div>
                                                </div>
                                                <div class="ticket__instruction">
                                                    <div class="ticket__instruction--step">
                                                        <div class="ticket__circle-count"><span>3</span></div>
                                                        <div class="ticket__instruction--step-text"><span
                                                                class="ticket__small-text">Pronto! O pagamento será
                                                                creditado na hora e você receberá um e-mail de
                                                                confirmação.</span></div>
                                                    </div>
                                                </div>
                                        </section>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>






                <div id="paymentBrick_container" class="mt-20"></div>
                <div id="statusScreenBrick_container" class="mt-20 visually-hidden ">

                </div>




                <div id="planos_list" class="mt-20 flow-root">
                    <div
                        class="isolate -mt-16 grid max-w-sm grid-cols-1 gap-y-16 divide-y divide-gray-100 sm:mx-auto lg:-mx-8 lg:mt-0 lg:max-w-none lg:grid-cols-3 lg:divide-x lg:divide-y-0 xl:-mx-4">
                        @foreach ($planos as $item)
                            <div wire:key="{{ $item->id }}" class="pt-16 lg:px-8 lg:pt-0 xl:px-14">
                                <h3 id="tier-basic"
                                    class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">

                                    {{ $item['name'] }}
                                </h3>
                                <p class="mt-6 flex items-baseline gap-x-1">
                                    <span class="text-5xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                                        R$ {{ $item['price'] }}
                                    </span>
                                    <span class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-200">
                                        /{{ $item['durationtype'] }}
                                    </span>
                                </p>
                                <p class="mt-3 text-sm leading-6 text-gray-500">$12 per month if paid annually</p>

                                @if (session()->has('mensagem'))
                                    <div>{{ session('mensagem') }}</div>
                                @endif




                                {{ $message }}



                                @if ($item['id'] == $user_plano)
                                    <button onclick="initpag({{ $item['id'] }})" aria-describedby="tier-basic"
                                        class="mt-10 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm">Seu
                                        Plano</button>
                                @else
                                    <button onclick="initpag({{ $item['id'] }})" aria-describedby="tier-basic"
                                        class="mt-10 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Upgrade</button>
                                @endif












                                <p class="mt-10 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">
                                    {{ $item['description'] }}
                                </p>
                                <ul role="list"
                                    class="mt-6 space-y-3 text-sm leading-6 text-gray-600 dark:text-gray-200">
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $item['vantagem1'] }}
                                    </li>
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $item['vantagem2'] }}
                                    </li>
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $item['vantagem3'] }}
                                    </li>
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $item['vantagem4'] }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var order_id = null
    var data = {};
    const mp = new MercadoPago('APP_USR-b6c48671-6cb5-46b1-a41c-62f688d820c1', {
        locale: 'pt'
    });

    function initpag(id) {
        let bricksBuilder = mp.bricks();
        const renderPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {

                    amount: 0.10,
                    preferenceId: {$preferenceId },
                    payer: {
                        firstName: "",
                        lastName: "",
                        email: "",
                    },
                },
                customization: {
                    visual: {
                        style: {
                            theme: "default",
                        },
                    },
                    paymentMethods: {
                        creditCard: "all",
                        debitCard: "all",
                        ticket: "all",
                        bankTransfer: "all",
                        atm: "all",
                        maxInstallments: 1
                    },
                },
                callbacks: {
                    onReady: () => {
                        $('#planos_list').hide();
                    },


                    onSubmit: ({
                        selectedPaymentMethod,
                        formData
                    }) => {


                        return new Promise((resolve, reject) => {
                            const formData = {
                                payment_method_id: selectedPaymentMethod,
                                token: formData.token,
                                installments: formData.installments,
                                issuer_id: formData.issuer,
                                payment_type: formData.payment_type,
                                transaction_amount: formData.transaction_amount,
                                description: formData.description,
                                payer: {
                                    email: formData.email,
                                    identification: {
                                        type: formData.identification.type,
                                        number: formData.identification.number,
                                    },
                                },
                            };



                            let $wire;


                            $wire.emit('createpayment', formData);
                            resolve();




                        });
                    },
                    onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                        console.error(error);
                    },
                },
            };
            window.paymentBrickController = await bricksBuilder.create(
                "payment",
                "paymentBrick_container",
                settings
            );
        };
        renderPaymentBrick(bricksBuilder);
    }



</script>
