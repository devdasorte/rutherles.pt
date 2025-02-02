@php
    $languages = \App\Facades\UtilityFacades::languages();
    $currency = tenancy()->central(function ($tenant) {
        return Utility::getsettings('currency_symbol');
    });
@endphp
@extends('layouts.main-landing')
@section('title', __('Home'))

@section('content')
    

    <style>
        .site-footer{display:none}
        .site-header.header-style-one{
            display:none;
        }
    </style>
   

<link rel="stylesheet" href="https://brendodev1.rutherles.pt/vendor/landing-page2/css/landingpage-2.css">
   

    
   

        <section class="pricing-plans-sec pt pb home-sec" id="plans">
            <div class="container">
               
                   
                        <div class="section-title">
                            <h2>  Simples, Confiável
                                <b>Lucrativo
                                </b>
                            </h2>
                            <p>
                                 Tenha a completa estrutura para iniciar suas campanhas e seus lucros ainda hoje!
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
                                                            <p>Campanhas ilimitadas</p>
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
                                                            <p>Os maiores meios de pagamento</p>
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
                                                            <p>10.000.000 de números</p>
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
                                                            <p>Campanha Fazendinha</p>
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
                                                            <p>Campanha meia fazendinha</p>
                                                        </div>
                                                    </li>
                                                     @if ($plan->status_auto_cota == 1)
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
                                                            <p>{{ $plan->status_auto_cota == '1' ? 'Controle de cotas premiadas' : '' }}
                                                                </p>
                                                        </div>
                                                    </li>
                                                    @endif
                                                       @if ($plan->gerar_sorteio == 1)
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
                                                            <p>Função para realizar sorteio</p>
                                                        </div>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div
                                                class="basic-plans-bottom justify-content-between d-flex align-items-center">
                                                <div class="basic-plans-price d-flex">
                                                    <div class="basic-price-left">
                                                        <p>
                                                             {{ $plan->durationtype }}
                                                            
                                                        </p>
                                                        <ins>{{ 'R$' . '' . $plan->price }} </ins>
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
                                                            data-amount="{{ $plan->price }}">Testar
                                                            <i class="ti ti-chevron-right ms-2"></i></a>
                                                    @elseif ($plan->id != 1)
                                                        <a href="{{ route('request.domain.create', Crypt::encrypt(['plan_id' => $plan->id])) }}"
                                                            class="mt-2 subscribe_plan btn btn-primary btn-block"
                                                            data-id="{{ $plan->id }}"
                                                            data-amount="{{ $plan->price }}">Contratar
                                                            <i class="ti ti-chevron-right ms-2"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    
               
              
            </div>
        </section>


   

   
    

   
@endsection
@push('javascript')
    <script>
        // landing page announcement js
        var headerHright = $('header').outerHeight();
        $('header').next('.home-sec').css('padding-top', headerHright + 'px');
    </script>
@endpush
