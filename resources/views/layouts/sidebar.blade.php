



@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();

    $plans = Utility::getsettings('plan_setting');
    $plan = json_decode($plans, true);

@endphp
<link id="tw-1" rel="stylesheet" href="{{ asset('assets/build/assets/app-CLXaZiM_.css') }}">

<nav class="dash-sidebar light-sidebar {{ Utility::getsettings('transparent_layout') == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <div class="m-headers logo-col">
            <a href="{{ route('home') }}" wire:navigate class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                @if ($users->dark_layout == 1)
                    <img src="{{ Utility::getsettings('app_logo') ? Utility::getpath('logo/app-logo.png') : asset('assets/images/logo/app-logo.png') }}"
                        class="footer-light-logo">
                @else
                    <img src="{{ Utility::getsettings('app_dark_logo') ? Utility::getpath('logo/app-dark-logo.png') : asset('assets/images/logo/app-dark-logo.png') }}"
                        class="footer-dark-logo">
                @endif
            </a>
        </div>

  
        <div class="navbar-content">
            <ul class="dash-navbar">
 







                <li class="dash-item dash-hasmenu">
                    <a href="{{ route('home') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span>
                        <span class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>





                <li
                    class="dash-item dash-hasmenu {{ request()->is('campanha*') || request()->is('nova-campanha*') || request()->is('editar.campanha*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('campanha') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-clipboard-list"></i></span>
                        <span class="dash-mtext">
                            Campanhas
                        </span>
                    </a>
                </li>



                <li
                    class="dash-item dash-hasmenu {{ request()->is('pedidos*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('pedidos') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span>
                        <span class="dash-mtext">
                            Pedidos
                        </span>
                    </a>
                </li>
                <li
                    class="dash-item dash-hasmenu {{ request()->is('relatorio*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('relatorio') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-clipboard-check"></i></span>
                        <span class="dash-mtext">
                            Relatórios
                        </span>
                    </a>
                </li>
                <li
                    class="dash-item dash-hasmenu {{ request()->is('ranking*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('ranking') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                        <span class="dash-mtext">
                            Ranking
                        </span>
                    </a>
                </li>

                @php
                    $isActive = $plan['gerar_sorteio'] == 'on' ? true : false;

                @endphp



 


                <li
                    class="dash-item dash-hasmenu {{ request()->is('sorteios*') ? 'active dash-trigger' : 'collapsed' }}">

                    @if (!$isActive)

         
                       <span class="dash-link">

                            <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                            <span class="dash-mtext mr-2">
                                Sorteio


                                <span style="color: blueviolet" class="badge">Plus ✨</span>


                                



                            </span>

                        </span>
                
                  

                    @else 
                        <a href="{{ route('sorteios') }}" wire:navigate class="dash-link">
                            <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                            <span class="dash-mtext">
                                Sorteio
                            </span>
                        </a>

                    @endif

                </li>











                <li
                    class="dash-item  dash-hasmenu  {{ request()->is('usuarios*') || request()->is('clientes*') || request()->is('afiliados*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-users"></i></span><span
                            class="dash-mtext">{{ __('Usuarios') }}</span></a>


                    <ul class="dash-submenu">

                        <li class="dash-item {{ request()->is('usuarios*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('usuarios') }}" wire:navigate>{{ __('Usuarios') }}</a>
                        </li>

                        <li class="dash-item {{ request()->is('afiliados*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('afiliados') }}"
                                wire:navigate>{{ __('Afiliados') }}</a>
                        </li>

                        <li class="dash-item {{ request()->is('clientes*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('clientes') }}" wire:navigate>{{ __('Clientes') }}</a>
                        </li>

                    </ul>
                </li>







                <li
                    class="dash-item dash-hasmenu {{ request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('settings') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-settings" width="44" height="44"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                            </svg></span>
                        <span class="dash-mtext">
                            Configurações
                        </span>
                    </a>
                </li>
                <li class="dash-item dash-hasmenu {{ request()->is('logs*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('logs') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-article" width="44" height="44"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M7 8h10" />
                                <path d="M7 12h10" />
                                <path d="M7 16h10" />
                            </svg></i></span>
                        <span class="dash-mtext">
                            Logs
                        </span>
                    </a>
                </li>
                <li class="dash-item dash-hasmenu {{ request()->is('cotas*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('cotas') }}" wire:navigate class="dash-link">
                        <span class="dash-micon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trophy-filled"
                                width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M17 3a1 1 0 0 1 .993 .883l.007 .117v2.17a3 3 0 1 1 0 5.659v.171a6.002 6.002 0 0 1 -5 5.917v2.083h3a1 1 0 0 1 .117 1.993l-.117 .007h-8a1 1 0 0 1 -.117 -1.993l.117 -.007h3v-2.083a6.002 6.002 0 0 1 -4.996 -5.692l-.004 -.225v-.171a3 3 0 0 1 -3.996 -2.653l-.003 -.176l.005 -.176a3 3 0 0 1 3.995 -2.654l-.001 -2.17a1 1 0 0 1 1 -1h10zm-12 5a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm14 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"
                                    stroke-width="0" fill="currentColor" />
                            </svg>
                        </span>
                        <span class="dash-mtext">
                            Cotas Premiadas
                        </span>
                    </a>
                </li>

                <li
                    class="dash-item dash-hasmenu {{ request()->is('planos*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('planos') }}" wire:navigate class="dash-link">
                        <span class="dash-micon"><i class="ti ti-credit-card"></i></span>
                        <span class="dash-mtext">
                            Planos
                        </span>
                    </a>
                </li>







            </ul>
        </div>
    </div>
</nav>
