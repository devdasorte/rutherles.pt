<?php
include app_path('Includes/settings.php');
$enable_cpf = $_settings->info('enable_cpf');
$enable_email = $_settings->info('enable_email');
$enable_address = $_settings->info('enable_address');
$enable_password = $_settings->info('enable_password');
$enable_two_phone = $_settings->info('enable_two_phone');
$enable_birth = $_settings->info('enable_birth');
$enable_instagram = $_settings->info('enable_instagram');

if ($_settings->userdata('id') != '') {
    echo '<script>alert(\'Você já está cadastrado\'); location.replace(\'/\');</script>';
    exit();
}
?>

<div class="container app-main app-form">
    <form id="form-cadastro" method="get" action=".">
        <div class="perfil app-card card mb-2">
            <div class="card-body">
                <div class="mb-2">
                    <label for="firstname" class="form-label">Nome</label>
                    <input type="text" name="firstname" class="form-control text-black" id="firstname" placeholder="Primeiro nome" required="">
                </div>
                <div class="mb-2">
                    <label for="lastname" class="form-label">Sobrenome</label>
                    <input type="text" name="lastname" class="form-control text-black" id="lastname" placeholder="Sobrenome" required="">
                </div>

                <?php if ($enable_cpf == 1) : ?>
                    <div class="mb-2">
                        <label for="cpf" class="form-label">CPF</label>
                        <input name="cpf" class="form-control text-black" id="cpf" value="" maxlength="14" minlength="14" placeholder="000.000.000-00" oninput="formatarCPF(this.value)" required>
                    </div>
                <?php endif; ?>

                <?php if ($enable_email == 1) : ?>
                    <div class="mb-2">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control text-black" id="email" placeholder="exemplo@exemplo.com" required>
                    </div>
                <?php endif; ?>

                <div class="mb-2">
                    <label for="phone" class="form-label">Telefone</label>
                    <input onkeyup="formatarTEL(this);" class="form-control text-black mb-2" name="phone" id="phone" maxlength="15" placeholder="(00) 0000-0000" required="" value="">
                </div>

                <?php if ($enable_two_phone == 2) : ?>
                    <div class="mb-2">
                        <label for="phone_confirm" class="form-label">Confirme seu telefone</label>
                        <input onkeyup="formatarTEL(this);" class="form-control text-black mb-2" name="phone_confirm" id="phone_confirm" maxlength="15" placeholder="(00) 0000-0000" required="" value="">
                    </div>
                <?php endif; ?>

                <?php if ($enable_password == 1) : ?>
                    <div class="mb-2">
                        <label for="password" class="form-label">Senha</label>
                        <input class="form-control text-black mb-2" name="password" id="password" required="" minlength="5" maxlength="20" type="password">
                    </div>
                <?php endif; ?>

                <?php if ($enable_birth == 1) : ?>
                    <div class="mb-2">
                        <label for="birth" class="form-label">Data de nascimento</label>
                        <input type="date" name="birth" id="birth" placeholder="11/11/1990" class="form-control text-black mb-2" required>
                    </div>
                <?php endif; ?>

                <?php if ($enable_instagram == 1) : ?>
                    <div class="mb-2">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input name="instagram" class="form-control text-black" id="instagram" placeholder="@usuario">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($enable_address == 1) : ?>
            <div class="endereco app-card card mb-2">
                <div class="card-body">
                    <div class="mb-2">
                        <label for="zipcode" class="form-label">CEP</label>
                        <input name="zipcode" class="form-control text-black" type="text" id="zipcode" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);" />
                    </div>
                    <div class="mb-2">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" name="address" class="form-control text-black" id="address" required="">
                    </div>
                    <div class="mb-2">
                        <label for="number" class="form-label">Número</label>
                        <input type="text" name="number" class="form-control text-black" id="number">
                    </div>
                    <div class="mb-2">
                        <label for="neighborhood" class="form-label">Bairro</label>
                        <input name="neighborhood" class="form-control text-black" type="text" id="neighborhood" size="40" required="" />
                    </div>
                    <div class="mb-2">
                        <label for="complement" class="form-label">Complemento</label>
                        <input type="text" name="complement" class="form-control text-black" id="complement">
                    </div>
                    <div class="mb-2">
                        <label for="state" class="form-label">Estado</label>
                        <select class="form-select" name="state" id="state" required="">
                            <option value="">-- Estado --</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="city" class="form-label">Cidade</label>
                        <input name="city" class="form-control text-black" type="text" id="city" size="40" />
                    </div>
                    <div class="mb-2">
                        <label for="reference_point" class="form-label">Ponto de referência</label>
                        <input type="text" name="reference_point" class="form-control text-black" id="reference_point">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-secondary btn-wide">Cadastrar</button>
    </form>
</div>

<script>
    function date_formator(date) {
        console.log(date);
        date = date.replace('//', '/');
        var result = date.split("/");
        var length = result.length;
        if (length <= 2 && result[length - 1] != "") {
            var last_two_digits = result[length - 1];
            if (last_two_digits.length >= 2) {
                date = date.slice(0, -last_two_digits.length);
                date = date + last_two_digits.slice(0, 2) + "/";
            }
        }
        if (typeof result[2] != "undefined") {
            var year = result[2];
            if (year.length > 4) {
                date = date.slice(0, -year.length);
                year = year.slice(0, 4);
                date = date + year;
            }
        }
        return date;
    }

    function limpa_formulario_cep() {
        document.getElementById('address').value = ("");
        document.getElementById('neighborhood').value = ("");
        document.getElementById('city').value = ("");
        document.getElementById('state').value = ("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('address').value = (conteudo.logradouro);
            document.getElementById('neighborhood').value = (conteudo.bairro);
            document.getElementById('city').value = (conteudo.localidade);
            document.getElementById('state').value = (conteudo.uf);
        } else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                document.getElementById('address').value = "...";
                document.getElementById('neighborhood').value = "...";
                document.getElementById('city').value = "...";
                document.getElementById('state').value = "...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);
            } else {
                limpa_formulario_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulario_cep();
        }
    }

    function formatarCPF(valor) {
        var cpf = valor.replace(/\D/g, '');
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        document.getElementById('cpf').value = cpf;
    }

    function formatarTEL(i) {
        var v = i.value;
        if (v.length <= 13) {
            v = v.replace(/\D/g, "");
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
            v = v.replace(/(\d)(\d{4})$/, "$1-$2");
        } else {
            v = v.replace(/\D/g, "");
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
            v = v.replace(/(\d)(\d{4})$/, "$1-$2");
        }
        i.value = v;
    }
    $(document).ready(function() {
        $('#form-cadastro').submit(function(e) {
            e.preventDefault()
            var phoneValue = $('#phone').val();

            $.ajax({
                url: _base_url_ + "customer/Customer.php?action=registration",
                method: 'POST',
                type: 'POST',
                data: new FormData($(this)[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                error: err => {
                    console.log(err)
                    alert('An error occurred')
                },
                success: function(resp) {
                    console.log(resp)
                    if (resp.status == 'success') {
                        alert('Cadastro realizado com sucessso.');
                        location.href = (resp.redirect);
                    } else if (resp.status == 'phone_already') {
                        alert('Este telefone já está cadastrado.');
                    } else if (resp.status == 'cpf_already') {
                        alert('Este CPF já está cadastrado.');
                    } else if (resp.status == 'cpf_invalid') {
                        alert(resp.msg);
                    } else if (!!resp.msg) {
                        el.html(resp.msg)
                        el.show('slow')
                        _this.prepend(el)
                    } else {
                        alert('An error occurred')
                        console.log(resp)
                    }
                }
            })
        })
    })
</script>