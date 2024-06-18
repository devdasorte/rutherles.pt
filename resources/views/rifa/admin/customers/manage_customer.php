<?php
include app_path('Includes/settings.php');

if (isset($id)) {
    $user = $conn->query("SELECT * FROM customer_list where id ='{$id}' ");
    foreach ($user->fetch_array() as $k => $v) {
        if (!is_numeric($k))
            $$k = $v;
    }
}
$enable_email = $_settings->info('enable_email');
$enable_cpf = $_settings->info('enable_cpf');
$enable_password = $_settings->info('enable_password');
$enable_address = $_settings->info('enable_address');
$enable_birth = $_settings->info('enable_birth');
$enable_instagram = $_settings->info('enable_instagram');
?>
<style>
    #cimg {
        max-width: 100%;
        max-height: 25em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <?= isset($id) ? "Editar usuário" : "Novo usuário" ?> <a href="/clientes"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Voltar
                </button></a>
        </h2>


        <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="" id="manage-user">
                <?php if (isset($id)) : ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nome</span>
                    <input name="firstname" id="firstname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nome" value="<?= isset($firstname) ? $firstname : '' ?>" />
                </label>


                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Sobrenome</span>
                    <input name="lastname" id="lastname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Sobrenome" value="<?= isset($lastname) ? $lastname : '' ?>" />
                </label>
<?php if($enable_cpf == 1) {?>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">CPF</span>
                    <input name="cpf" id="cpf" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="CPF" value="<?= isset($cpf) ? $cpf : '' ?>" />
                </label>
<?php } ?>
<?php if($enable_email == 1) {?>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">E-mail</span>
                    <input name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="example@example.com" value="<?= isset($email) ? $email : '' ?>" />
                </label>
<?php } ?>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Telefone</span>
                    <input onkeyup="leowpMask(this);" maxlength="15" name="phone" id="phone" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="(00) 00000-00000" value="<?= isset($phone) ? formatPhoneNumber($phone) : '' ?>" />
                </label>
<?php if($enable_address == 1) {?>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">CEP:</span>
                    <input name="zipcode" id="zipcode" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="CEP" value="<?= isset($zipcode) ? $zipcode : '' ?>" />
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Endereço:</span>
                    <input name="address" id="address" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Endereço" value="<?= isset($address) ? $address : '' ?>" />
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Número:</span>
                    <input name="number" id="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Número" value="<?= isset($number) ? $number : '' ?>" />
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Bairro:</span>
                    <input name="neighborhood" id="neighborhood" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Bairro" value="<?= isset($neighborhood) ? $neighborhood : '' ?>" />
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Complemento:</span>
                    <input name="complement" id="complement" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Complemento" value="<?= isset($complement) ? $complement : '' ?>" />
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Estado:</span>
                    <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="state" id="state">
                        <option value="">-- Estado --</option>
                        <option value="AC" <?php if ($state == 'AC') {
                                                echo 'selected';
                                            }; ?>>Acre</option>
                        <option value="AL" <?php if ($state == 'AL') {
                                                echo 'selected';
                                            }; ?>>Alagoas</option>
                        <option value="AP" <?php if ($state == 'AP') {
                                                echo 'selected';
                                            }; ?>>Amapá</option>
                        <option value="AM" <?php if ($state == 'AM') {
                                                echo 'selected';
                                            }; ?>>Amazonas</option>
                        <option value="BA" <?php if ($state == 'BA') {
                                                echo 'selected';
                                            }; ?>>Bahia</option>
                        <option value="CE" <?php if ($state == 'CE') {
                                                echo 'selected';
                                            }; ?>>Ceará</option>
                        <option value="DF" <?php if ($state == 'DF') {
                                                echo 'selected';
                                            }; ?>>Distrito Federal</option>
                        <option value="ES" <?php if ($state == 'ES') {
                                                echo 'selected';
                                            }; ?>>Espí&shy;rito Santo</option>
                        <option value="GO" <?php if ($state == 'GO') {
                                                echo 'selected';
                                            }; ?>>Goiás</option>
                        <option value="MA" <?php if ($state == 'MA') {
                                                echo 'selected';
                                            }; ?>>Maranhão</option>
                        <option value="MT" <?php if ($state == 'MT') {
                                                echo 'selected';
                                            }; ?>>Mato Grosso</option>
                        <option value="MS" <?php if ($state == 'MS') {
                                                echo 'selected';
                                            }; ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php if ($state == 'MG') {
                                                echo 'selected';
                                            }; ?>>Minas Gerais</option>
                        <option value="PA" <?php if ($state == 'PA') {
                                                echo 'selected';
                                            }; ?>>Pará</option>
                        <option value="PB" <?php if ($state == 'PB') {
                                                echo 'selected';
                                            }; ?>>Paraiba</option>
                        <option value="PR" <?php if ($state == 'PR') {
                                                echo 'selected';
                                            }; ?>>Paraná</option>
                        <option value="PE" <?php if ($state == 'PE') {
                                                echo 'selected';
                                            }; ?>>Pernambuco</option>
                        <option value="PI" <?php if ($state == 'PI') {
                                                echo 'selected';
                                            }; ?>>Piauí&shy;</option>
                        <option value="RJ" <?php if ($state == 'RJ') {
                                                echo 'selected';
                                            }; ?>>Rio de Janeiro</option>
                        <option value="RN" <?php if ($state == 'RN') {
                                                echo 'selected';
                                            }; ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php if ($state == 'RS') {
                                                echo 'selected';
                                            }; ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php if ($state == 'RO') {
                                                echo 'selected';
                                            }; ?>>Rondônia</option>
                        <option value="RR" <?php if ($state == 'RR') {
                                                echo 'selected';
                                            }; ?>>Roraima</option>
                        <option value="SC" <?php if ($state == 'SC') {
                                                echo 'selected';
                                            }; ?>>Santa Catarina</option>
                        <option value="SP" <?php if ($state == 'SP') {
                                                echo 'selected';
                                            }; ?>>São Paulo</option>
                        <option value="SE" <?php if ($state == 'SE') {
                                                echo 'selected';
                                            }; ?>>Sergipe</option>
                        <option value="TO" <?php if ($state == 'TO') {
                                                echo 'selected';
                                            }; ?>>Tocantins</option>
                    </select>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Cidade:</span>
                    <input name="city" id="city" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cidade" value="<?= isset($city) ? $city : '' ?>" />
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Ponto de referência:</span>
                    <input name="reference_point" id="reference_point" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Ponto de referência" value="<?= isset($reference_point) ? $reference_point : '' ?>" />
                </label>
<?php }?>

<?php if($enable_password == 1) {?>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400"><?= isset($id) ? "Nova" : "" ?> Senha</span>
                    <input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="" />
                    <?php if (isset($id)) : ?>
                        <small class="text-gray-700 dark:text-gray-200"><i>Deixe em branco se não quiser alterar a senha.</i></small>
                    <?php endif; ?>

                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Confirme a senha</span>
                    <input type="password" id="cpassword" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="" />

                </label>

<?php }?>

             







                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Avatar</span>
                    <input id="customFile" name="img" onchange="displayImg(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" accept="image/png, image/jpeg">
                </label>

                <label class="block mt-4 text-sm">
                    <img src="<?php echo validate_image(isset($avatar) ? $avatar : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
        </div>


        <div class="">
            <button form="manage-user" class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Salvar
            </button>
        </div>

</main>
<?php
$id = isset($id) ? $id : '';
$change = '';
$msg = '';
if ($id) {
    $change = 'update_customer';
    $msg = 'Cliente atualizado com sucesso';
} else {
    $change = 'registration';
    $msg = 'Cliente cadastrado com sucesso';
}
?>
<script>
    function leowpMask(e) {
        v = e.value, console.log("v:" + v), console.log("v.length:" + v.length), v = v.replace(/\D/g, ""), v = v.replace(/^(\d{2})(\d)/g, "($1) $2"), console.log("v:" + v), v = v.replace(/(\d)(\d{4})$/, "$1-$2"), e.value = v
    }

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            $('#cimg').attr('src', "<?php echo validate_image(isset($avatar) ? $avatar : '') ?>");
        }
    }
    $('#manage-user').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: _base_url_ + 'customer/Customers.php?action=<?= $change; ?>',
                             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            
            success: function(resp) {
                var returnedData = JSON.parse(resp);
                if (returnedData.status == 'success') {
                    alert('<?= $msg; ?>');
                    location.href = '/clientes';
                } else {
                    alert('E-mail em uso!');
                }
            }
        })
    })
</script>