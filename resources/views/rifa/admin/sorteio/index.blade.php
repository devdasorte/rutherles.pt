<?php

$plans = Utility::getsettings('plan_setting');
$plan = json_decode($plans,true);
$gerar_sorteio = $plan['gerar_sorteio'] ;



if($gerar_sorteio == 'off'){
    header('location:home');
    exit();
 }

$horainicial = isset($_GET['horainicial']) ? $_GET['horainicial'] : '';
$horafinal = isset($_GET['horafinal']) ? $_GET['horafinal'] : '';
$valorqt = isset($_GET['valorqt']) ? $_GET['valorqt'] : '';
$sorteando = isset($_GET['sorteando']) ? $_GET['sorteando'] : '';
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
?>


    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Gerar um novo Sorteio <a href="./?page=products/manage_product" id="create_new"></a>
        </h2>
       {{ $gerar_sorteio}}
        <div class="w-full overflow-hidden rounded-lg shadow-xs">

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Escolha a Campanha
                </span>
                <select id="product_id" name="product_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">

                    <?php $qry = $conn->query("SELECT * FROM product_list");

                    while ($row = $qry->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo $product_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                    <?php endwhile; ?>

                </select>
            </label>




            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Data e hora inicial</span>
                <p style="font-size:13px;color: orange;font-style:italic;">Hora inicial da compra *Opcional</p>
                <input type="datetime-local" name="horainicial" id="horainicial" class="form-input  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
            </label>
            <input required="" id="type" value="order" name="type" hidden="">

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Horário de Brasília Data e hora final</span>
                <p style="font-size:13px;color: orange;font-style:italic;">Hora final da compra</p>
                <input type="datetime-local" name="horafinal" id="horafinal" class="form-input  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Quantidade de cotas</span>
                <p style="font-size:13px;color: orange;font-style:italic;">Quantidade mínima de cotas </p>
                <input name="valorqt" id="valorqt" class="form-input  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg" placeholder="ex: 50" value="">
            </label>

            <label id="sorteando-container" class=" mt-4 text-sm hidden">
                <span class="text-gray-700 dark:text-gray-400">Sorteando</span>
                <div name="sorteando" id="sorteando" class="form-input  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
                    <div>
                        <p class="ml-5" id="sorteio-number">

                        </p>
                        <span class="ml-5 pulsar hidden" id="sorteio-number2">Carregando Resultado</span>
                    </div>
                </div>
            </label>

            <div id="user-table" class="w-full overflow-hidden rounded-lg shadow-xs mt-4 hidden">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Foto</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">Telefone</th>
                                <th class="px-4 py-3">Whatsapp</th>
                                <th class="px-4 py-3">Campanha</th>
                                <th class="px-4 py-3">Número Sorteado</th>
                                <th class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    <div class="relative  w-8 h-8 mr-3 rounded-full block">
                                        <img class="object-cover w-full h-full rounded-full" src="https://rifa.rutherles.pt/uploads/avatars/1.png?v=1649834664" alt="" loading="lazy">
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                </td>
                                <td id="user-nome" class="px-4 py-3"></td>
                                <td id="user-telefone" class="px-4 py-3">

                                </td>
                                <td id="user-whatsapp" class="px-4 py-3">
                                    <a href="" class="send-whatsapp">
                                        <img src="https://rifa.rutherles.pt/admin/assets/img/whatsapp.png" style="height: 30px">
                                    </a>

                                </td>
                                <td id="user-cota-id" class="px-4 py-3 text-sm">

                                </td>
                                <td id="user-numero-sorteado" class="px-4 py-3 text-sm">

                                </td>
                                <td id="edit" class="px-4 py-3 text-sm">
                                    <button id="save_winner" class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple ">
                                        Salvar Ganhador
                                    </button>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">

                    </span>
                    <span class="col-span-2"></span>
                </div>
            </div>

            <div id="actions" class="" style="margin-top:30px;">
                <button id="gerar" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple ">
                    Gerar Sorteio
                </button>

                <button id="gerarnovo" class="px-5 hidden py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Novo Sorteio
                </button>
            </div>



        </div>

   



<script>
    var intervalId;
    const AJAX_URL = _BASE_URL_ + "class/Main.php?action=manage_draw";
    $(document).ready(function() {


        $('#gerar').on('click', (function() {

                gerar_sorteio()

            })

        )
    });
    $(document).ready(function() {
        $("#gerarnovo").on('click', function() {
            $('#user-table').addClass('hidden')

            gerar_sorteio()
        })
    })
    $(document).ready(function() {
        $("#save_winner").on('click', function() {
            save_winner()


        })
    })

    function gerarNumeros(stop) {
        $('#sorteio-number').removeClass('hidden')
        if (stop == true) {
            setTimeout(() => {
                $('#sorteio-number2').removeClass('hidden')
                $('#sorteio-number').addClass('hidden')
                clearInterval(intervalId)
            }, 3000);

            return
        }

        var min = 1;
        var max = 10000;

        intervalId = setInterval(function() {
            var random = Math.floor(Math.random() * (+max - +min)) + +min;
            $('#sorteio-number').text(random)
        }, 500);
    }
    async function gerar_sorteio() {
        if ($('#valorqt').val() < 1) {

            return alert('Escolha a quantidade mínima de cotas')


        }
        gerarNumeros(false);
        toggleUIElements(false);

        var form = new FormData();
        form.append('product_id', $('#product_id').val());
        form.append('horainicial', $('#horainicial').val());
        form.append('horafinal', $('#horafinal').val());
        form.append('valorqt', $('#valorqt').val());
        try {
            const resp = await $.ajax({
                url: AJAX_URL,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: 'POST',
                type: 'POST',
                data: form,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false
            });

            handleResponse(resp);
        } catch (err) {
            show_toastr('error', 'Erro ao gerar sorteio', 'Erro');
            console.error(err);
            location.reload();

        }
    }

    function toggleUIElements(isHidden) {
        $('#sorteando-container').toggleClass('hidden', isHidden);
        $('#actions').toggleClass('hidden', !isHidden);

    }

    function handleResponse(resp) {
        console.log(resp)
        if (resp.draw_cota) {
            gerarNumeros(true);
            updateUserInfo(resp);

            setTimeout(() => {
                toggleUIElements(true);
show_toastr('success', 'Sorteio gerado com sucesso', 'success');
                $('#user-table').removeClass('hidden');
                $('#gerar').addClass('hidden');
                $('#gerarnovo').removeClass('hidden');
                $('#sorteio-number2').addClass('hidden');

            }, 6000);
        } else {
            setTimeout(() => {
                toggleUIElements(true);
                gerarNumeros(true);
                show_toastr('error', 'Vencedor não encontrado', 'Erro');


            }, 6000);
        }
    }

    function updateUserInfo(resp) {
        $('#user-nome').text(resp.customer_name);
        $('#user-telefone').text(resp.customer_phone);
        $('#user-whatsapp').html(`<a href="https://api.whatsapp.com/send?phone=55${resp.customer_phone}" class="send-whatsapp">
        <img src="https://rifa.rutherles.pt/admin/assets/img/whatsapp.png" style="height: 30px">
                </a>`);
        $('#user-cota-id').text(resp.product_name);
        $('#user-numero-sorteado').text(resp.draw_cota);
    }
    async function save_winner() {
        var form = new FormData();
        form.append('id', $('#product_id').val());
        form.append('draw_number', $('#user-numero-sorteado').text());
        form.append('draw_winner', $('#user-telefone').text());

        try {
            const resp = await $.ajax({
                url: _BASE_URL_ + "class/Main.php?action=save_raffle_winner",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                method: 'POST',
                type: 'POST',
                data: form,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false
            });

            show_toastr('success', 'Ganhador salvo com sucesso', 'success');
            window.location.reload();

        } catch (err) {
            console.error(err);
            show_toastr('error', 'Erro ao salvar ganhador', 'Erro');
            window.location.reload();
        }
    }
</script>