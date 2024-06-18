@php

    include app_path('Includes/settings.php');

    $enable_groups = $_settings->info('enable_groups');

    $enable_pixel = $_settings->info('enable_pixel');
    $enable_dwapi = $_settings->info('enable_dwapi');

    $openpix_app_id = $_settings->info('openpix_app_id');
    $openpix_tax = $_settings->info('openpix_tax');
    $pay2m_client_id = $_settings->info('pay2m_client_id');
    $pay2m_client_secret = $_settings->info('pay2m_client_secret');

    $openpix = $_settings->info('openpix');
    $pay2m = $_settings->info('pay2m');

@endphp





<div class="row">



    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-3">
                <div class="card sticky-top stick-top">
                    <div class="list-group list-group-flush" id="useradd-sidenav">


                        <a href="#tab1" class="border-0 list-group-item list-group-item-action">
                            {{ __('Configurações do site') }}


                        </a>


                        <a href="#tab2" class="border-0 list-group-item list-group-item-action">
                            {{ __('General Setting') }}


                        </a>



                        <a href="#tab3" class="border-0 list-group-item list-group-item-action">
                            {{ __('Configuração de Cadastro') }}


                        </a>


                        <a href="#tab4" class="border-0 list-group-item list-group-item-action">
                            {{ __('Rodapé') }}


                        </a>


                        <a href="#tab5" class="border-0 list-group-item list-group-item-action">
                            {{ __('CEO') }}


                        </a>


                        <a href="#tab6" class="border-0 list-group-item list-group-item-action">
                            {{ __('WhatsApp') }}



                        </a>


                        <a href="#tab7" class="border-0 list-group-item list-group-item-action">
                            {{ __('Email') }}


                        </a>


                        <a href="#tab8" class="border-0 list-group-item list-group-item-action">
                            {{ __('FAQ') }}


                        </a>





                        <a href="#tab9" class="border-0 list-group-item list-group-item-action">
                            {{ __('Domínio') }}


                        </a>


                        <a href="#tab10" class="border-0 list-group-item list-group-item-action">
                            {{ __('Configuração de cache') }}


                        </a>

                        <a href="#tab11" class="border-0 list-group-item list-group-item-action">
                            {{ __('Gateway') }}


                        </a>




                    </div>
                </div>
            </div>
            <div class="col-xl-9">



                <div id="tab1">




                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('App Setting') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['settings.appname.update'],
                            'method' => 'POST',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-body">


                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('App Dark Logo') }}</h5>
                                        </div>
                                        <div class="pt-0 card-body">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                    <a href="{{ Utility::getpath(Utility::getsettings('app_dark_logo')) }}"
                                                        target="_blank">
                                                        <img src="{{ Utility::getpath(Utility::getsettings('app_dark_logo')) }}"
                                                            id="app_dark">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="app_dark_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('app_dark_logo', ['class' => 'form-control file', 'id' => 'app_dark_logo', 'onchange' => "document.getElementById('app_dark').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_dark_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('App Light Logo') }}</h5>
                                        </div>
                                        <div class="pt-0 card-body bg-primary">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content light-logo-content">
                                                    <a href="{{ Utility::getpath(Utility::getsettings('app_logo')) }}"
                                                        target="_blank">
                                                        <img src="{{ Utility::getpath(Utility::getsettings('app_logo')) }}"
                                                            id="app_light">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="app_logo">
                                                        <div class="company_logo_update w-logo"> <i
                                                                class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('app_logo', ['class' => 'form-control file', 'id' => 'app_logo', 'onchange' => "document.getElementById('app_light').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('App Favicon Logo') }}</h5>
                                        </div>
                                        <div class="pt-0 card-body">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content">
                                                    <a href="{{ Utility::getpath(Utility::getsettings('favicon_logo')) }}"
                                                        target="_blank">
                                                        <img height="35px"
                                                            src="{{ Utility::getpath(Utility::getsettings('favicon_logo')) }}"
                                                            id="app_favicon">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="favicon_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="px-1 ti ti-upload"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('favicon_logo', ['class' => 'form-control file', 'id' => 'favicon_logo', 'onchange' => "document.getElementById('app_favicon').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'favicon_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('app_name', __('Application Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('app_name', Utility::getsettings('app_name'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter application name'),
                                    ]) !!}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                    {!! Form::text('email', Utility::getsettings('email'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Email'),
                                    ]) !!}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('terms', __('Termos de uso'), ['class' => 'form-label']) }}
                                    {!! Form::text('terms', Utility::getsettings('terms'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Termos de uso'),
                                    ]) !!}
                                </div>



                                <div class="form-group">
                                    {{ Form::label('phone', __('Telefone'), ['class' => 'phone']) }}
                                    {!! Form::text('phone', Utility::getsettings('phone'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Telefone'),
                                    ]) !!}
                                </div>



                                <div class="form-group">
                                    {{ Form::label('address', __('Endereço'), ['class' => 'address']) }}
                                    {!! Form::text('address', Utility::getsettings('address'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Endereço'),
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>


                <div id="tab2">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('General Setting') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['settings.auth.settings.update'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Two Factor Authentication') }}</strong>
                                                {{ !Utility::getsettings('2fa') ? 'Activate' : 'Deactivate' }}
                                                {{ __('Two Factor Authentication') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('two_factor_auth', null, Utility::getsettings('2fa') ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                            @if (!extension_loaded('imagick'))
                                                <small>
                                                    {{ __('Note: for 2FA your server must have Imagick.') }} <a
                                                        href="https://www.php.net/manual/en/book.imagick.php"
                                                        target="_new">{{ __('Imagick Document') }}</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Ocultar cotas') }}</strong>

                                                {{ __('As cotas das campanhas automáticas só serão geradas e exibidas quando o pagamento for aprovado.') }}
                                            </div>

                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox(
                                                    'enable_hide_numbers',
                                                    null,
                                                    Utility::getsettings('enable_hide_numbers') == 1 ? true : false,
                                                    [
                                                        'data-toggle' => 'switchbutton',
                                                        'class'=> 'switch',
                                                        'data-onstyle' => 'primary',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <strong class="d-block">{{ __('') }}</strong>
                                                {{ __('Habilitar botões de compartilhamento?') }}
                                            </div>
                                            <div class="col-sm-4 text-end">

                                                {!! Form::checkbox('enable_share', null, Utility::getsettings('enable_share') == '1' ? true : false, [
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch'
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">


                                                {{ __('Habilitar botão para acessar os grupos?') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_groups', null, Utility::getsettings('enable_groups') == 1 ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong
                                                    class="d-block">{{ __('Bloquear múltiplos pedidos?') }}</strong>

                                                {{ __('O cliente só poderá realizar um novo pedido após efetuar o pagamento do pedido anterior.') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox(
                                                    'enable_multiple_order',
                                                    null,
                                                    Utility::getsettings('enable_multiple_order') == '1' ? true : false,
                                                    [
                                                        'data-toggle' => 'switchbutton',
                                                        'class'=> 'switch',
                                                        'data-onstyle' => 'primary',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Register Setting') }}</strong>
                                                {{ Utility::getsettings('register_setting') == '1' ? __('Deactivate') : __('Activate') }}
                                                {{ __('Register Setting For Application.') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('register_setting', null, Utility::getsettings('register_setting') == 1 ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="my-3">{{ __('Theme Customizer') }}</h5>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h6>
                                                    {{ __('Tema') }}
                                                </h6>
                                                <hr class="my-2">
                                                <div class="theme-color themes-color">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                        data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-1">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-2' ? 'active_color' : '' }} "
                                                        data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-2">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                        data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-3">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                        data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-4">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-5' ? 'active_color' : '' }}"
                                                        data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-5">
                                                    <br>
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-6' ? 'active_color' : '' }}"
                                                        data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-6">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-7' ? 'active_color' : '' }}"
                                                        data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-7">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-8' ? 'active_color' : '' }}"
                                                        data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-8">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-9' ? 'active_color' : '' }}"
                                                        data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-9">
                                                    <a href="#!"
                                                        class="{{ $color == 'theme-10' ? 'active_color' : '' }}"
                                                        data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                    <input type="radio" class="theme_color tm-color" name="color"
                                                        value="theme-10">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <h6>
                                                    {{ __('Sidebar Settings') }}
                                                </h6>
                                                <hr class="my-2">
                                                <div class="form-check form-switch switch ">
                                                    {!! Form::checkbox(
                                                        'transparent_layout',
                                                        null,
                                                        Utility::getsettings('transparent_layout') == '1' ? true : false,
                                                        [
                                                            'id' => 'cust-theme-bg',
                                                            'class' => 'form-check-input',
                                                        ],
                                                    ) !!}
                                                    {!! Form::label('cust-theme-bg', __('Transparent layout'), ['class' => 'form-check-label f-w-600 pl-1 me-2']) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <h6>
                                                    {{ __('Layout Settings') }}
                                                </h6>
                                                <hr class="my-2">
                                                <div class="mt-2 form-check form-switch switch ">
                                                    {!! Form::checkbox('dark_mode', null, Utility::getsettings('dark_mode') == 'on' ? true : false, [
                                                        'id' => 'cust-darklayout',
                                                        'class' => 'form-check-input',
                                                    ]) !!}
                                                    {!! Form::label('cust-darklayout', __('Dark Layout'), ['class' => 'form-check-label f-w-600 pl-1 me-2']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>



                <div id="tab3">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Configuração de Cadastro') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['cadastro.settings.update'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong
                                                    class="d-block">{{ __('Habilitar dupla verificação de telefone?') }}</strong>

                                                {{ __('O suário deverá informar o telefone duas vezes na criação de conta') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_two_phone', null, Utility::getsettings('enable_two_phone') ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Habilitar senha?') }}</strong>

                                                {{ __('Será necessário inserir uma senha durante o processo de cadastro e também para fazer o login no sistema.') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_password', null, Utility::getsettings('enable_password') == 1 ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <strong class="d-block">{{ __('Habilitar CPF?') }}</strong>
                                                {{ __('O sistema irá exigir que o usuário forneça seu CPF para efetuar um cadastro/compra e também para buscar seus números.') }}
                                            </div>
                                            <div class="col-sm-4 text-end">
                                                {!! Form::checkbox('enable_cpf', null, Utility::getsettings('enable_cpf') == '1' ? true : false, [
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch'
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Habilitar E-mail?') }}</strong>

                                                {{ __('O sistema irá exigir que o usuário forneça um email válido para efetuar um cadastro/compra.') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_email', null, Utility::getsettings('enable_email') == 1 ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong
                                                    class="d-block">{{ __('Apenas maiores de 18 anos?') }}</strong>
                                                {{ __('Apenas cadastros de clientes maiores de 18 anos.') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_legal_age', null, Utility::getsettings('enable_legal_age') == '1' ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Habilitar Endereço?') }}</strong>

                                                {{ __('O sistema irá exibir opções de endereço na página de atualização de cadastro do usuário') }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                {!! Form::checkbox('enable_address', null, Utility::getsettings('enable_address') == 1 ? true : false, [
                                                    'data-toggle' => 'switchbutton',
                                                    'class'=> 'switch',
                                                    'data-onstyle' => 'primary',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>








                <div id="tab4">
                    <div class="card">

                        {{ Form::open([
                            'route' => 'settings.google.calender.update',
                            'method' => 'POST',
                        ]) }}

                        <div class="card-header">
                            <div class="row align-items-center">

                                <div class="col-6">
                                    <h5>
                                        {{ __('Habilitar botão para acessar os grupos?') }}
                                    </h5>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-switch switch  custom-switch-v1 d-inline-block">
                                        {!! Form::checkbox('enable_groups', null, $enable_groups ? true : false, [
                                            'data-toggle' => 'switchbutton',
                                            'class'=> 'switch',
                                            'data-onstyle' => 'primary',
                                        ]) !!}
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="card-body">
                            <div class="row">








                                <div class="groups_social" id="groups_social">
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Link do


                                            Telegram:</span>
                                        <input name="telegram_group_url" id="telegram_group_url" class="form-control"
                                            placeholder="https://telegram.org" value="<?php echo $_settings->info('telegram_group_url'); ?>">
                                    </label>

                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Link do
                                            grupo
                                            WhatsApp:</span>
                                        <input name="whatsapp_group_url" id="whatsapp_group_url" class="form-control"
                                            placeholder="https://whatsapp.com/" value="<?php echo $_settings->info('whatsapp_group_url'); ?>">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), [
                                    'type' => 'submit',
                                    'class' => 'btn-submit btn
                                                                                                                                                                                                                                                                                                                                                                        btn-primary',
                                ]) !!}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>





                <div id="tab5">
                    <div class="card">
                        <div class="card-header">
                            <h5> {{ __('Social Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => ['settings.social.setting.update'],
                                'method' => 'POST',
                                'data-validate',
                            ]) !!}
                            <div class="faq justify-content-center">
                                <div class="row">
                                    <div class="col-sm-12 col-xxl-12">
                                        <div class="accordion accordion-flush" id="accordionExamples">
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading111">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse111"
                                                        aria-expanded="true" aria-controls="collapse111">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-brand-google text-primary"></i>
                                                            {{ __('Google') }}
                                                        </span>
                                                        @if (Utility::getsettings('googlesetting') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse111" class="accordion-collapse collapse"
                                                    aria-labelledby="heading111" data-bs-parent="#accordionExamples">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-6">
                                                                <p class="text-sm">
                                                                    {{ __('Habilitar
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        Google Analytics?') }}
                                                                    <a href="{{ Storage::url('pdf/login with facebook.pdf') }}"
                                                                        target="_blank">{{ __('Document') }}</a>
                                                                </p>
                                                            </div>
                                                            <div class="py-2 col-6 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox('socialsetting[]', 'facebook', $enable_pixel == '1' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'enable_pixel',
                                                                    ]) !!}
                                                                    {{ Form::label('enable_pixel', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>




                                                            <label class="block mt-4 text-sm">

                                                                <p>Área destinada ao gestor de tráfego para
                                                                    implantação do Google Analytics (GA4)</p>
                                                            </label>



                                                            <input type="hidden" name="user_id" id="user_id"
                                                                value="<?php echo $_settings->userdata('id'); ?>">

                                                            <div class="pixel-google">
                                                                <label class="block mt-4 text-sm">
                                                                    <span class="text-gray-700 dark:text-gray-400">ID
                                                                        (GA4)*:</span>
                                                                    <input name="google_ga4_id" id="google_ga4_id"
                                                                        class="form-control"
                                                                        placeholder="Informe o ID do analytics"
                                                                        value="<?php echo $_settings->info('google_ga4_id'); ?>">
                                                                </label>
                                                            </div>
                                                            <br>
                                                            <hr>






                                                            <div class="pixel-google-gtm">
                                                                <label class="block mt-4 text-sm">
                                                                    <span class="text-gray-700 dark:text-gray-400">ID
                                                                        (GTM)*:</span>
                                                                    <input name="google_gtm_id" id="google_gtm_id"
                                                                        class="form-control"
                                                                        placeholder="Informe o ID do GTM"
                                                                        value="<?php echo $_settings->info('google_gtm_id'); ?>">
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading112">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse112"
                                                        aria-expanded="true" aria-controls="collapse112">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-brand-facebook text-primary"></i>
                                                            {{ __('Facebook') }}
                                                        </span>
                                                        @if (Utility::getsettings('facebooksetting') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>

                                                <div id="collapse112" class="accordion-collapse collapse"
                                                    aria-labelledby="heading112" data-bs-parent="#accordionExamples">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-6">
                                                                <p class="text-sm">
                                                                    {{ __('How To Enable Login With Facebook') }}
                                                                    <a href="{{ Storage::url('pdf/login with facebook.pdf') }}"
                                                                        target="_blank">{{ __('Document') }}</a>
                                                                </p>
                                                            </div>
                                                            <div class="py-2 col-6 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox('socialsetting[]', 'facebook', $enable_pixel == '1' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'enable_pixel',
                                                                    ]) !!}
                                                                    {{ Form::label('enable_pixel', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>


                                                            <div class="pixel-facebook">
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400">Access
                                                                        Token (Facebook) *:</span>
                                                                    <input value="<?php echo $_settings->info('facebook_access_token'); ?>"
                                                                        name="facebook_access_token"
                                                                        id="facebook_access_token"
                                                                        class="form-control"
                                                                        placeholder="Informe o ACCESS TOKEN do facebook">
                                                                </label>
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400">Pixel
                                                                        ID (Facebook) *:</span>
                                                                    <input name="facebook_pixel_id"
                                                                        id="facebook_pixel_id" class="form-control"
                                                                        placeholder="Informe o PIXEL ID do facebook"
                                                                        value="<?php echo $_settings->info('facebook_pixel_id'); ?>">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>



















                <div id="tab6">
                    <div class="card">
                        <div class="card-header">

                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5>{{ __('WhatsApp') }}</h5>
                                </div>






                                <div class="col-6 text-end">
                                    <div class="form-switch switch   custom-switch-v1 d-inline-block">
                                        {!! Form::checkbox('enable_dwapi', null, $enable_dwapi == '1' ? true : false, [
                                            'class' => 'custom-control custom-switch form-check-input input-primary',
                                            'data-onstyle' => 'primary',
                                            'data-toggle' => 'switchbutton',
                                            'class'=> 'switch'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::open([
                            'route' => ['settings.auth.settings.update'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="row">

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ativar
                                        integração</span>
                                    <p>Ao habilitar essa opção o sistema irá
                                        enviar
                                        automaticamente uma mensagem para o
                                        WhatsApp
                                        do cliente ao efetuar um novo
                                        pedido.</p>
                                    <p style="font-size:13px;color: orange;font-style:italic;">
                                        Essa integração é feita através da
                                        <a href="https://dw-api.com/" target="_blank">DW-API</a>. É
                                        necessário um plano ativo na mesma
                                        para
                                        poder utilizar. Você pode testar por
                                        3 dias
                                        grátis.
                                    </p>
                                    <br>
                                </label>

                                <label class="block text-sm">
                                    <p><b>[CAMPANHA]</b> - Irá exibir o nome
                                        da
                                        campanha</p>
                                    <p><b>[CLIENTE]</b> - Irá exibir o nome
                                        do
                                        cliente</p>
                                    <p><b>[COTAS]</b> - Irá exibir as cotas
                                        do
                                        pedido</p>
                                    <p><b>[TOTAL]</b> - Irá exibir o valor
                                        total do
                                        pedido</p>
                                    <p><b>[PIX]</b> - Irá exibir o código
                                        copia e
                                        cola do PIX</p>
                                    <p><b>[N]</b> - Irá inserir uma quebra
                                        de linha
                                    </p>
                                    <br>
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Token</span>
                                    <input name="token_dwapi" id="token_dwapi" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('token_dwapi'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Número
                                        que irá fazer os envios</span>
                                    <input name="numero_dwapi" id="numero_dwapi" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('numero_dwapi'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Mensagem
                                        que será enviada para o cliente
                                        quando um
                                        pedido for feito</span>
                                    <input name="mensagem_novo_pedido_dwapi" id="mensagem_novo_pedido_dwapi"
                                        class="form-control" placeholder="" value="<?php echo $_settings->info('mensagem_novo_pedido_dwapi'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Mensagem
                                        que será enviada para o cliente
                                        quando um
                                        pedido for pago</span>
                                    <input name="mensagem_pedido_pago_dwapi" id="mensagem_pedido_pago_dwapi"
                                        class="form-control" placeholder="" value="<?php echo $_settings->info('mensagem_pedido_pago_dwapi'); ?>">
                                </label>

                            </div>
                        </div>
                    </div>
                </div>


                <div id="tab7">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Email') }}</h5>
                        </div>


                        {!! Form::open([
                            'route' => ['settings.auth.settings.update'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="row">

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Servidor
                                        de
                                        email customizado</span>
                                    <p>Se deseja utilizar um servidor de email
                                        personalizado,
                                        preencha os dados do mesmo abaixo, caso
                                        contrário, deixe
                                        os campos em branco.</p>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Servidor
                                        SMTP</span>
                                    <input name="smtp_host" id="smtp_host" class="form-control"
                                        placeholder="smtp.yourhost.com" value="<?php echo $_settings->info('smtp_host'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Porta</span>
                                    <input name="smtp_port" id="smtp_port" class="form-control" placeholder="465"
                                        value="<?php echo $_settings->info('smtp_port'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Usuário</span>
                                    <input name="smtp_user" id="smtp_user" class="form-control"
                                        placeholder="Usuário" value="<?php echo $_settings->info('smtp_user'); ?>">
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Senha</span>
                                    <input name="smtp_pass" id="smtp_pass" type="password" class="form-control"
                                        placeholder="*****" value="<?php echo $_settings->info('smtp_pass'); ?>">
                                </label>

                                <hr class="mt-4 mb-4">

                                <label class="block text-sm">
                                    <p class="mb-2">Shortcodes disponíveis</p>
                                    <p><b>[CAMPANHA]</b> - Irá exibir o nome da campanha
                                    </p>
                                    <p><b>[CLIENTE]</b> - Irá exibir o nome do cliente
                                    </p>
                                    <p><b>[COTAS]</b> - Irá exibir as cotas do pedido
                                    </p>
                                    <p><b>[TOTAL]</b> - Irá exibir o valor total do
                                        pedido</p>
                                </label>

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Corpo
                                        do
                                        email que será enviado para o cliente ao efetuar
                                        uma
                                        compra</span>
                                    <p style="font-size:13px;color: orange;font-style:italic;">
                                        Você pode utilizar tags html na descrição para
                                        uma
                                        melhor formatação</p>
                                    <textarea name="email_order" id="email_order" class="form-control" rows="6"></textarea>
                                </label>

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Corpo
                                        do
                                        email que será enviado para o cliente ao efetuar
                                        um
                                        pagamento</span>
                                    <p style="font-size:13px;color: orange;font-style:italic;">
                                        Você pode utilizar tags html na descrição para
                                        uma
                                        melhor formatação</p>
                                    <textarea name="email_purchase" id="email_purchase" class="form-control" rows="6"></textarea>
                                </label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), [
                                    'type' => 'submit',
                                    'class' => 'btn-submit btn
                                                                                                                                                                                                                                                                                                                                                    btn-primary',
                                ]) !!}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>




                </div>

                <div id="tab8">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Perguntas frequentes') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['footer.settings.update'],
                            'method' => 'POST',
                        ]) !!}


                        <div class="card-body">
                            <div class="row">
                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">Pergunta
                                        1</span>
                                    <input name="question1" id="question1" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('question1'); ?>">
                                    <input name="answer1" id="answer1" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('answer1'); ?>">
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">Pergunta
                                        2</span>
                                    <input name="question2" id="question2" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('question2'); ?>">
                                    <input name="answer2" id="answer2" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('answer2'); ?>">
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">Pergunta
                                        3</span>
                                    <input name="question3" id="question3" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('question3'); ?>">
                                    <input name="answer3" id="answer3" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('answer3'); ?>">
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">Pergunta
                                        4</span>
                                    <input name="question4" id="question4" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('question4'); ?>">
                                    <input name="answer4" id="answer4" class="form-control" placeholder=""
                                        value="<?php echo $_settings->info('answer4'); ?>">
                                </label>



                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), [
                                    'type' => 'submit',
                                    'class' => 'btn-submit btn
                                                                                                                                                                                                                                                                                                                                                    btn-primary',
                                ]) !!}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>


                <div id="tab9">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Send Change Domain Request Setting') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['settings.change.domain'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="col-12">
                                <p class="text-sm">
                                    {{ __('Note: If you want to change your domain name, send a request to the super admin to keep the domain name.') }}
                                </p>
                            </div>
                            @if (isset($order) && $order->status == 0)
                                <div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <span
                                                    class="p-2 px-3 badge rounded-pill bg-warning">{{ __('Request Pending') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{ Form::label('domain_name', __('Domain Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('domain_name', null, [
                                                    'class' => 'form-control',
                                                    'id' => 'domain_name',
                                                    'placeholder' => __('Enter domain name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Send'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div id="tab10">
                    <div class="card">
                        <div class="card-header">
                            {!! Form::open([
                                'route' => 'config.cache',
                                'method' => 'Post',
                                'data-validate',
                            ]) !!}
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5> {{ __('Cache Setting') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 form-group">
                                    {{ Form::label('Current cache size', __('Current cache size'), ['class' => 'col-form-label']) }}
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            value="{{ Utility::CacheSize() }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ __('MB') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {{ Form::button(__('Cache Clear'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div id="tab11">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Payment Settings') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => ['settings.payment.setting.update'],
                            'method' => 'POST',
                            'data-validate',
                        ]) !!}
                        <div class="card-body">
                            <div class="faq justify-content-center">
                                <div class="row">


                                    <div class="col-sm-12 col-xxl-12">
                                        <div class="accordion accordion-flush" id="accordionExample">

                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading1">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                        aria-expanded="true" aria-controls="collapse1">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            {{ __('Mercado Pago') }}
                                                        </span>
                                                        @if (Utility::getsettings('mercadopago') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>













                                                <div id="collapse1" class="accordion-collapse collapse"
                                                    aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox(
                                                                        'paymentsetting[]',
                                                                        'mercadopago',
                                                                    
                                                                        Utility::getsettings('mercadopago') == '1' ? true : false,
                                                                        [
                                                                            'class' => 'form-check-input mx-2',
                                                                            'id' => 'mercadopago',
                                                                        ],
                                                                    ) !!}
                                                                    {{ Form::label('Mercado Pago', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    {{ Form::label('mercadopago_access_token', __('Mercadopago Access_token'), ['class' => 'col-form-label']) }}
                                                                    {{ Form::text('mercadopago_access_token', Utility::getsettings('mercadopago_access_token'), ['class' => 'form-control', 'placeholder' => __('ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003')]) }}

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    {{ Form::label('mercadopago_tax', __('Taxa (%)'), ['class' => 'col-form-label']) }}
                                                                    {{ Form::text('mercadopago_tax', Utility::getsettings('mercadopago_tax'), ['class' => 'form-control ', 'placeholder' => __('Taxa adicional que será cobrada para o cliente no ato do pagamento.')]) }}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>







                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading2">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                        aria-expanded="true" aria-controls="collapse2">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            {{ __('Habilitar Gerencianet (Efí)?') }}
                                                        </span>
                                                        @if (Utility::getsettings('gerencianet') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse2" class="accordion-collapse collapse"
                                                    aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox(
                                                                        'paymentsetting[]',
                                                                        'gerencianet',
                                                                        Utility::getsettings('gerencianet') == '1' ? true : false,
                                                                        [
                                                                            'class' => 'form-check-input mx-2',
                                                                            'id' => 'gerencianet',
                                                                        ],
                                                                    ) !!}
                                                                    {{ Form::label('gerencianet', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>
                                                            <div class="gerencianet">
                                                                <p>Preencha os dados abaixo e faça upload do certificado
                                                                    com o nome <strong>pagamentos.pem</strong> no
                                                                    diretório
                                                                    principal do site.</p>
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                            ID:</strong></span>
                                                                    <input name="gerencianet_client_id"
                                                                        id="gerencianet_client_id"
                                                                        class="form-control"
                                                                        placeholder="ex: Client_Id_2456913797e93b8933243e1d4ef36e52c9c6"
                                                                        value="<?php echo isset($gerencianet_client_id) ? $gerencianet_client_id : ''; ?>" />
                                                                </label>
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                            Secret:</strong></span>
                                                                    <input name="gerencianet_client_secret"
                                                                        id="gerencianet_client_secret"
                                                                        class="form-control"
                                                                        placeholder="ex: Client_Secret_afc18534a5534ab49b36f370871d088a1cce3cc"
                                                                        value="<?php echo isset($gerencianet_client_secret) ? $gerencianet_client_secret : ''; ?>" />
                                                                </label>
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400"><strong>Chave
                                                                            Aleatória:</strong></span>
                                                                    <input name="gerencianet_pix_key"
                                                                        id="gerencianet_pix_key" class="form-control"
                                                                        placeholder="ex: b3b6d68a-50db-3d88-b7ee-g215b41d0ec2"
                                                                        value="<?php echo isset($gerencianet_pix_key) ? $gerencianet_pix_key : ''; ?>" />
                                                                </label>
                                                                <label class="block mt-4 text-sm">
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-400"><strong>Taxa
                                                                            (%):</strong>
                                                                        <p>Taxa adicional que será cobrada para o
                                                                            cliente no ato do pagamento.</p>
                                                                    </span>
                                                                    <input name="gerencianet_tax" id="gerencianet_tax"
                                                                        class="form-control" placeholder="0"
                                                                        type="number" value="<?php echo isset($gerencianet_tax) ? $gerencianet_tax : 0; ?>" />
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Paypal -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading3">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse3"
                                                        aria-expanded="true" aria-controls="collapse3">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            {{ __('Paggue') }}
                                                        </span>
                                                        @if (Utility::getsettings('paggue') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse3" class="accordion-collapse collapse"
                                                    aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox('paymentsetting[]', 'paggue', Utility::getsettings('paggue') == '1' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'paggue',
                                                                    ]) !!}
                                                                    {{ Form::label('paggue', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="paggue">
                                                                    <p>Clique no link para obter as chaves de integração
                                                                        com o <a
                                                                            style="color:blue;text-decoration:underline;"
                                                                            href="https://portal.paggue.io/integrations"
                                                                            target="_blank">Paggue</a></p>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                                KEY:</strong></span>
                                                                        <input name="paggue_client_key"
                                                                            id="paggue_client_key"
                                                                            class="form-control"
                                                                            placeholder="Informe a chave Client Key do Paggue"
                                                                            value="<?php echo isset($paggue_client_key) ? $paggue_client_key : ''; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                                Secret:</strong></span>
                                                                        <input name="paggue_client_secret"
                                                                            id="paggue_client_secret"
                                                                            class="form-control"
                                                                            placeholder="Informe a chave Client Secret do Paggue"
                                                                            value="<?php echo isset($paggue_client_secret) ? $paggue_client_secret : ''; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Taxa
                                                                                (%):</strong>
                                                                            <p>Taxa adicional que será cobrada para o
                                                                                cliente no ato do pagamento.</p>
                                                                        </span>
                                                                        <input name="paggue_tax" id="paggue_tax"
                                                                            class="form-control" placeholder="0"
                                                                            type="number"
                                                                            value="<?php echo isset($paggue_tax) ? $paggue_tax : 0; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Webhook
                                                                                URL:</strong>
                                                                            <p>Adicione a URL abaixo na área "Webhook
                                                                                URL" no Paggue!</p>
                                                                        </span>
                                                                        <input class="form-control"
                                                                            value="<?php echo BASE_URL . 'webhook.php?notify=paggue'; ?>" readonly />
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FLUTTERWAVE -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading4">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                                                        aria-expanded="true" aria-controls="collapse4">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            {{ __('OpenPix') }}
                                                        </span>
                                                        @if (Utility::getsettings('openpix') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse4" class="accordion-collapse collapse"
                                                    aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox('paymentsetting[]', 'openpix', Utility::getsettings('openpix') == '1' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'openpix',
                                                                    ]) !!}
                                                                    {{ Form::label('openpix', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="openpix">
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>App
                                                                                ID:</strong></span>
                                                                        <input name="openpix_app_id"
                                                                            id="openpix_app_id" class="form-control"
                                                                            placeholder="Informe o App ID do OpenPix"
                                                                            value="<?php echo isset($openpix_app_id) ? $openpix_app_id : ''; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Taxa
                                                                                (%):</strong>
                                                                            <p>Taxa adicional que será cobrada para o
                                                                                cliente no ato do pagamento.</p>
                                                                        </span>
                                                                        <input name="openpix_tax" id="openpix_tax"
                                                                            class="form-control" placeholder="0"
                                                                            type="number"
                                                                            value="<?php echo isset($openpix_tax) ? $openpix_tax : 0; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Webhook
                                                                                URL:</strong>
                                                                            <p>Adicione a URL abaixo na área "Webhook"
                                                                                no OpenPix!</p>
                                                                        </span>
                                                                        <input class="form-control"
                                                                            value="<?php echo BASE_URL . 'webhook.php?notify=openpix'; ?>" readonly />
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading5">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                                                        aria-expanded="true" aria-controls="collapse5">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            {{ __('Pay2m') }}
                                                        </span>
                                                        @if (Utility::getsettings('pay2m') == '1')
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3">{{ __('Active') }}</a>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse5" class="accordion-collapse collapse"
                                                    aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                                    <div style="visibility: visible" class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch switch  d-inline-block">
                                                                    {!! Form::checkbox('paymentsetting[]', 'pay2m', Utility::getsettings('pay2m') == '1' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'pay2m',
                                                                    ]) !!}
                                                                    {{ Form::label('pay2m', __('Enable'), ['class' => 'form-check-label']) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="pay2m">
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                                ID:</strong></span>
                                                                        <input name="pay2m_client_id"
                                                                            id="pay2m_client_id" class="form-control"
                                                                            placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003"
                                                                            value="<?php echo isset($pay2m_client_id) ? $pay2m_client_id : ''; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Client
                                                                                Secret:</strong></span>
                                                                        <input name="pay2m_client_secret"
                                                                            id="pay2m_client_secret"
                                                                            class="form-control"
                                                                            placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003"
                                                                            value="<?php echo isset($pay2m_client_secret) ? $pay2m_client_secret : ''; ?>" />
                                                                    </label>
                                                                    <label class="block mt-4 text-sm">
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-400"><strong>Taxa
                                                                                (%):</strong>
                                                                            <p>Taxa adicional que será cobrada para o
                                                                                cliente no ato do pagamento.</p>
                                                                        </span>
                                                                        <input name="pay2m_tax" id="pay2m_tax"
                                                                            class="form-control" placeholder="0"
                                                                            type="number"
                                                                            value="<?php echo isset($pay2m_tax) ? $pay2m_tax : 0; ?>" />
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: '#useradd-sidenav',
                offset: 300,

            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });

        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        // theme color
        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }

        // transprent background
        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });

        // dark layout
        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document.querySelector(".m-headers > .b-brand > img").setAttribute("src",
                    "{{ Utility::getpath('logo/app-logo.png') }}");
                document.querySelector("#main-style-link").setAttribute("href",
                    "{{ asset('assets/css/style-dark.css') }}");
            } else {
                document.querySelector(".m-headers > .b-brand > img").setAttribute("src",
                    "{{ Utility::getpath('logo/app-dark-logo.png') }}");
                document.querySelector("#main-style-link").setAttribute("href",
                    "{{ asset('assets/css/style.css') }}");
            }
        });

        $(document).on('click', "input[name$='smssetting']", function() {
            var test = $(this).val();
            $("#twilio").fadeOut(500);
            if (test == 'twilio') {
                $("#twilio").fadeIn(500);
                $("#twilio").removeClass('d-none');
                $("#nexmo").addClass('d-none');
                $("#fast2sms").addClass('d-none');
                $("#nexmo").fadeOut(500);
                $("#fast2sms").fadeOut(500);
            } else if (test == 'nexmo') {
                $("#nexmo").fadeIn(500);
                $("#twilio").addClass('d-none');
                $("#nexmo").removeClass('d-none');
                $("#fast2sms").addClass('d-none');
                $("#twilio").fadeOut(500);
                $("#fast2sms").fadeOut(500);
            } else if (test == 'fast2sms') {
                $("#fast2sms").fadeIn(500);
                $("#twilio").addClass('d-none');
                $("#nexmo").addClass('d-none');
                $("#fast2sms").removeClass('d-none');
                $("#nexmo").fadeOut(500);
                $("#twilio").fadeOut(500);
            }
        });

        $(document).on('change', ".socialsetting", function() {
            var test = $(this).val();
            if ($(this).is(':checked')) {
                if (test == 'google') {
                    $("#google").fadeIn(500);
                    $("#google").removeClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeIn(500);
                    $("#facebook").removeClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeIn(500);
                    $("#github").removeClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeIn(500);
                    $("#linkedin").removeClass('d-none');
                }
            } else {
                if (test == 'google') {
                    $("#google").fadeOut(500);
                    $("#google").addClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeOut(500);
                    $("#facebook").addClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeOut(500);
                    $("#github").addClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeOut(500);
                    $("#linkedin").addClass('d-none');
                }
            }
        });

        $('body').on('click', '.send_mail', function() {
            var action = $(this).data('url');
            var modal = $('#common_modal');
            $.get(action, function(response) {
                modal.find('.modal-title').html('{{ 'Test Mail ' }}');
                modal.find('.body').html(response);
                modal.modal('show');
            })
        });

        $(document).on('click', "input[name='storage_type']", function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });

        // notification status
        $(document).on("change", ".chnageEmailNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var email = $(this).parent().find("input[name=email_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'email',
                    email_notification: email,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
        $(document).on("change", ".chnagesmsNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var sms = $(this).parent().find("input[name=sms_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'sms',
                    sms_notification: sms,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
        $(document).on("change", ".chnageNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var notify = $(this).parent().find("input[name=notify]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'notify',
                    notify: notify,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
    </script>

