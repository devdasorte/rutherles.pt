<?php 
include app_path('Includes/settings.php');
?>

@php
$enable_password = $_settings->info("enable_password");
$enable_email = $_settings->info("enable_email");
$enable_cpf = $_settings->info("enable_cpf");
$enable_two_phone = $_settings->info("enable_two_phone");
$user_id = e($_settings->userdata('id'));
$user_type = e($_settings->userdata('type'));
$logo = e(validate_image($_settings->info('logo')));
$favicon = e(validate_image($_settings->info('favicon')));
$enable_password = e($_settings->info('enable_password'));
$enable_pixel = e($_settings->info('enable_pixel'));
$enable_ga4 = e($_settings->info('enable_ga4'));
$google_ga4_id = e($_settings->info('google_ga4_id'));
$enable_gtm = e($_settings->info('enable_gtm'));
$google_gtm_id = e($_settings->info('google_gtm_id'));
$facebook_access_token = e($_settings->info('facebook_access_token'));
$facebook_pixel_id = e($_settings->info('facebook_pixel_id'));
$affiliate = e($_settings->userdata('is_affiliate'));
$url = request()->fullUrl();
$parts = parse_url($url);

// Verifica se a chave 'path' existe antes de tentar acessá-la
$path_name = $parts['path'] ?? '';
$path = explode('/', $path_name);
$page = $path[1] ?? '';
$page2 = $path[2] ?? '';

if ($page2 != '' && $page == 'campanhas') {
$page = 'campanha';
}

if (isset($parts['query'])) {
parse_str($parts['query'], $query);
$ref = $query['ref'] ?? null;
if ($ref) {
session(['ref' => $ref]);
}
}
@endphp

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! exibir_cabecalho($conn, $_settings) !!}

    @if ($favicon)
    <link rel="shortcut icon" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon }}">
    @endif

    <meta name="theme-color" content="#000000">

    <link rel="stylesheet" href="{{ asset('assets/rifa/css/style.css') }}" defer>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" defer>
    <link rel="stylesheet" href="{{ asset('assets/rifa/css/style2.css') }}" defer>
    <script rel=preconnect src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        var _base_url_ = "{{ BASE_URL }}";
    </script>



</head>

<body>

    @include('rifa.pages.inc.header')
    {{ $slot }}
    <?php if ($_settings->info("enable_footer") == "1") 
    {
     ?>
    @include('rifa.pages.inc.footer')
    <?php 
	
    }  
	?>

    <?php if (!$user_id) { ?>
    <form class="modal fade" id="loginModal">
        <div class="modal-dialog modal-md modal-fullscreen-md-down modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body app-form">
                    <p class="text-muted font-xs">Por favor, entre com seus dados ou faça um cadastro.</p>
                    <span id="aviso-login"></span>
                    <div class=" sc-edb71a0-0 bVkLus">
                        <div class="form-floating font-weight-500">
                            <input onkeyup="formatarTEL(this);" maxlength="15" name="phone" id="phone" required
                                class="form-control text-black sc-edb71a0-5 bICAcA" placeholder="(00) 0000-0000"
                                value="">
                            <label for="username">Telefone</label>
                        </div>
                    </div>
                    <?php if ($enable_password == "1") { ?>
                    <div class="mb-4">
                        <div class="form-floating font-weight-500">
                            <input type="password" name="password" id="password"
                                class="form-control text-black sc-edb71a0-5 bICAcA" placeholder="Senha" required>
                            <label for="password">Senha</label>
                        </div>
                    </div>
                    <div class="btn btn-link btn-sm text-decoration-none mb-4 text-cardLink opacity-75">
                        <a href="/recuperar-senha">Esqueci minha senha</a>
                    </div>
                    <?php } ?>
                    <div class="d-flex justify-content-end gap-4 align-items-center ">

                        <div class="btn btn-link btn-sm text-decoration-none">
                            <a href="<?php echo BASE_URL; ?>cadastrar">Criar conta</a>
                        </div>
                        <button type="submit"
                            class="btn btn-wide-in btn-primary font-weight-500 rounded-pill mb-2">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php } ?>

    <span id="openCadastro" data-bs-toggle="modal" data-bs-target="#cadastroModal" style="display:none;"></span>
    <form class="modal fade" id="cadastroModal">
        <div class="modal-dialog modal-md modal-fullscreen-md-down modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body app-form">
                    <p class="text-muted font-xs">Por favor, entre com seus dados para finalizar o cadastro.</p>
                    <span id="aviso-login"></span>
                    <div class="mb-2" style="text-align:left">
                        <label for="firstname" class=" form-label">Nome</label>
                        <input type="text" name="firstname" class="form-control text-black sc-edb71a0-5 bICAcA"
                            id="firstname" placeholder="Nome" required>
                    </div>
                    <div class="mb-2" style="text-align:left">
                        <label for="lastname" class=" form-label">Sobrenome</label>
                        <input type="text" name="lastname" class="form-control text-black sc-edb71a0-5 bICAcA"
                            id="lastname" placeholder="Sobrenome" required>
                    </div>
                    <?php if ($enable_cpf == 1) { ?>
                    <div class="mb-2" style="text-align:left">
                        <label for="cpf" class=" form-label">CPF</label>
                        <input id="cpf" name="cpf" type="text" class="form-control text-black sc-edb71a0-5 bICAcA"
                            maxlength="14" pattern=".{14,}" placeholder="000.000.000-00"
                            onkeydown="javascript: fMasc(this, mCPF);" required>
                    </div>
                    <?php } ?>
                    <div class="mb-2" style="text-align:left">
                        <label for="phone" class=" form-label">Telefone</label>
                        <input onkeyup="formatarTEL(this);" maxlength="15" name="phone" id="phone" required
                            class="phone form-control text-black sc-edb71a0-5 bICAcA" placeholder="(00) 0000-0000"
                            value="">
                    </div>
                    <?php if ($enable_two_phone == 1) { ?>
                    <div class="mb-2" style="text-align:left">
                        <label for="phone_confirm" class=" form-label">Confirme seu telefone</label>
                        <input onkeyup="formatarTEL(this);" maxlength="15" name="phone_confirm" id="phone_confirm"
                            required class="phone_confirm form-control text-black sc-edb71a0-5 bICAcA"
                            placeholder="(00) 0000-0000" value="">
                    </div>
                    <?php } ?>
                    <?php if ($enable_email == 1) { ?>
                    <div class="mb-2" style="text-align:left">
                        <label for="email" class=" form-label">E-mail</label>
                        <input type="email" name="email" class="form-control text-black sc-edb71a0-5 bICAcA" id="email"
                            placeholder="exemplo@exemplo.com" required>
                    </div>
                    <?php } ?>
                    <?php if ($enable_password == "1") { ?>
                    <div class="mb-2">
                        <div class="form-floating font-weight-500">
                            <input type="password" name="password" id="password"
                                class="form-control text-black sc-edb71a0-5 bICAcA" placeholder="Senha" required>
                            <label for="password">Senha</label>
                        </div>
                    </div>
                    <div class="btn btn-link btn-sm text-decoration-none mb-4 text-cardLink opacity-75">
                        <a href="/recuperar-senha">Esqueci minha senha</a>
                    </div>
                    <?php } ?>
                    <?php if (!!$_settings->info("terms")) { ?>
                    <div class="alert alert-primary mt-3 font-xss">
                        Ao se cadastrar você concorda com nossos <a style="color:var(--incrivel-primaria);"
                            href="<?php echo BASE_URL; ?>termos-de-uso" target="_blank">termos</a>.
                    </div>
                    <?php } ?>
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <button type="submit"
                            class="btn btn-wide-in btn-primary font-weight-500 rounded-pill mb-2">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function fMasc(objeto, mascara) {
                    obj = objeto;
                    masc = mascara;
                    setTimeout("fMascEx()", 1);
                }
    
                function fMascEx() {
                    obj.value = masc(obj.value);
                }
    
                function mCPF(cpf) {
                    cpf = cpf.replace(/\D/g, "");
                    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
                    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
                    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
                    return cpf;
                }
    
                function mascara(i) {
                    let valor = i.value.replace(/\D/g, '');
    
                    if (isNaN(valor[valor.length - 1])) {
                        i.value = valor.slice(0, -1);
                        return;
                    }
    
                    i.setAttribute("maxlength", "14");
    
                    i.value = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                }
    
                $(document).ready(function() {
                    $('#form-cadastrar, #cadastroModal').submit(function(e) {
                        e.preventDefault();
                        var phoneValue = $('.phone').val();
                        var phoneConfirmValue = $('.phone_confirm').val();
                        if ($('.phone')) {
                            if (phoneValue.length < 15 || phoneValue.length > 15) {
                                alert('Telefone inválido. Por favor corrija.');
                                return;
                            }
                        }
                        if (phoneConfirmValue) {
                            if (phoneConfirmValue != phoneValue) {
                                alert('Telefone inválido. Por favor corrija');
                                return;
                            }
                        }
    
                        $.ajax({
                            url: _base_url_ + "customer/Customer.php?action=registration",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            type: 'POST',
                            data: new FormData($(this)[0]),
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            error: err => {
                                console.log(err);
                                alert('An error occurred');
                            },
                            success: function(resp) {
                                if (resp.status == 'success') {
                                    $('.btn-close').click();
                                    $('#overlay').fadeIn(300);
                                    setTimeout(function() {
                                        $('#add_to_cart').click();
                                    }, 1000);
                                    setTimeout(function() {
                                        $('#place_order').click();
                                    }, 2000);
                                } else if (resp.status == 'phone_already') {
                                    alert(resp.msg);
                                } else if (resp.status == 'cpf_already') {
                                    alert(resp.msg);
                                } else if (resp.status == 'email_already') {
                                    alert(resp.msg);
                                } else {
                                    alert('An error occurred');
                                    console.log(resp);
                                }
                            }
                        });
                    });
                });
    
                $(document).ready(function() {
                    $('#loginModal').submit(function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: _base_url_ + "auth/Auth.php?action=login_customer",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            type: 'POST',
                            data: new FormData($(this)[0]),
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            error: err => {
                                console.log(err);
                                alert('An error occurred');
                            },
                            success: function(resp) {
                                if (resp.status == 'success') {
                                    var currentPath = window.location.pathname;
                                    var redirects = currentPath.includes('campanhas')
                                    console.log(currentPath);
                                    if (redirects) {
    
    
    
                                        $('.btn-close').click();
                                        $('#overlay').fadeIn(300);
                                        setTimeout(function() {
                                            $('#add_to_cart').click();
                                        }, 1000);
                                        setTimeout(function() {
                                            $('#place_order').click();
                                        }, 2000);
                                    } else {
                                        location.reload();
                                    }
    
                                } else if (!!resp.msg) {
                                    var currentPath = window.location.pathname;
                                    var redirects = currentPath.includes('campanhas')
                                    console.log(currentPath);
                                    if (!redirects) {
                                        $('#aviso-login').html(
                                            '<div style="color:red;font-size:14px;margin-bottom:10px;">Telefone ou senha incorretos!</div>'
                                        );
                                    } else {
                                        var phone = $('#loginModal #phone').val();
                                        $('#cadastroModal #phone').val(phone);
                                        $('#openCadastro').click();
                                    }
                                } else {
                                    alert('An error occurred');
                                    console.log(resp);
                                }
                            }
                        });
                    });
                });
    
                function formatarTEL(e) {
                    let v = e.value;
                    v = v.replace(/\D/g, "");
                    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
                    v = v.replace(/(\d)(\d{4})$/, "$1-$2");
                    e.value = v;
                }
    
                function formatarCPF(r) {
                    var e = r.replace(/\D/g, "").replace(/(\\d{3})(\\d{3})(\\d{3})(\\d{2})/, "$1.$2.$3-$4");
                    document.getElementById("cpf").value = e;
                }
    </script>



    <script rel=preconnect src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"
        data-nscript="afterInteractive" defer>
    </script>
</body>

</html>