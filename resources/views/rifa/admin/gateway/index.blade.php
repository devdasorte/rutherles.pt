<?php

$mercadopago = $_settings->info('mercadopago');
$mercadopago_access_token = $_settings->info('mercadopago_access_token');
$mercadopago_tax = $_settings->info('mercadopago_tax');
$gerencianet = $_settings->info('gerencianet');
$gerencianet_client_id = $_settings->info('gerencianet_client_id');
$gerencianet_client_secret = $_settings->info('gerencianet_client_secret');
$gerencianet_pix_key = $_settings->info('gerencianet_pix_key');
$gerencianet_tax = $_settings->info('gerencianet_tax');
$paggue = $_settings->info('paggue');
$paggue_client_key = $_settings->info('paggue_client_key');
$paggue_client_secret = $_settings->info('paggue_client_secret');
$paggue_tax = $_settings->info('paggue_tax');
$openpix = $_settings->info('openpix');
$openpix_app_id = $_settings->info('openpix_app_id');
$openpix_tax = $_settings->info('openpix_tax');
$pay2m = $_settings->info('pay2m');
$pay2m_client_id = $_settings->info('pay2m_client_id');
$pay2m_client_secret = $_settings->info('pay2m_client_secret');
?>
<style>
    .active-tab {
        border-bottom: none !important;
    }

    .can-toggle {
        position: relative;
        margin-bottom: 20px;
    }

    .can-toggle *,
    .can-toggle *:before,
    .can-toggle *:after {
        box-sizing: border-box;
    }

    .can-toggle input[type=checkbox] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
        content: attr(data-unchecked);
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        content: attr(data-checked);
    }

    .can-toggle label {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        display: flex;
        align-items: center;
    }

    .can-toggle label .can-toggle__switch {
        position: relative;
    }

    .can-toggle label .can-toggle__switch:before {
        content: attr(data-checked);
        position: absolute;
        top: 0;
        text-transform: uppercase;
        text-align: center;
    }

    .can-toggle label .can-toggle__switch:after {
        content: attr(data-unchecked);
        position: absolute;
        z-index: 5;
        text-transform: uppercase;
        text-align: center;
        background: white;
        transform: translate3d(0, 0, 0);
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
        background-color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        color: #5e5e5e;
    }

    .can-toggle input[type=checkbox]:hover~label {
        color: #6a6a6a;
    }

    .can-toggle input[type=checkbox]:checked~label:hover {
        color: #55bc49;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
        background-color: #70c767;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        color: #4fb743;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
        background-color: #5fc054;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        color: #47a43d;
    }

    .can-toggle label .can-toggle__switch {
        transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
        background: #848484;
    }

    .can-toggle label .can-toggle__switch:before {
        color: rgba(255, 255, 255, 0.5);
    }

    .can-toggle label .can-toggle__switch:after {
        transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        transform: translate3d(65px, 0, 0);
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle label {
        font-size: 14px;
    }

    .can-toggle label .can-toggle__switch {
        height: 36px;
        flex: 0 0 134px;
        border-radius: 4px;
    }

    .can-toggle label .can-toggle__switch:before {
        left: 67px;
        font-size: 12px;
        line-height: 36px;
        width: 67px;
        padding: 0 12px;
    }

    .can-toggle label .can-toggle__switch:after {
        top: 2px;
        left: 2px;
        border-radius: 2px;
        width: 65px;
        line-height: 32px;
        font-size: 12px;
    }

    .can-toggle label .can-toggle__switch:hover:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    @media all and (max-width:40em) {
        #tabs {
            flex-wrap: wrap;
        }

        #tabs .mr-1 {
            margin-bottom: 15px;
        }
    }
</style>

<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Gateway de pagamento
        </h2>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex">
                <ul class="flex" id="tabs">
                    <li class="mr-1">
                        <a href="#tab1" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">
                            MercadoPago
                        </a>
                    </li>
                    <li class="mr-1">
                        <a href="#tab2" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">
                            Gerencianet (Efí)
                        </a>
                    </li>
                    <li class="mr-1">
                        <a href="#tab3" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">
                            Paggue
                        </a>
                    </li>
                    <li class="mr-1">
                        <a href="#tab4" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">
                            OpenPix
                        </a>
                    </li>
                    <li class="mr-1">
                        <a href="#tab5" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">
                            Pay2m
                        </a>
                    </li>
                </ul>
            </div>
        </div>


    <form action="" id="gateway-form">
    @csrf
    <div class="mt-4">
        <div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Habilitar Mercado Pago?</span>
            </label>
            <div class="can-toggle">
                <input type="checkbox" name="mercadopago" id="mercadopago" <?php echo isset($mercadopago) && $mercadopago == 1 ? 'checked' : ''; ?>>
<label for="mercadopago">
    <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
</label>
</div>
<div class="mercadopago">
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400"><strong>Access Token:</strong></span>
        <input name="mercadopago_access_token" id="mercadopago_access_token"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003"
            value="<?php echo isset($mercadopago_access_token) ? $mercadopago_access_token : ''; ?>" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400"><strong>Taxa (%):</strong>
            <p>Taxa adicional que será cobrada para o cliente no ato do pagamento.</p>
        </span>
        <input name="mercadopago_tax" id="mercadopago_tax"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="0" type="number" value="<?php echo isset($mercadopago_tax) ? $mercadopago_tax : 0; ?>" />
    </label>
</div>
</div>

<div id="tab2" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Habilitar Gerencianet (Efí)?</span>
    </label>
    <div class="can-toggle">
        <input type="checkbox" name="gerencianet" id="gerencianet" <?php echo isset($gerencianet) && $gerencianet == 1 ? 'checked' : ''; ?>>
        <label for="gerencianet">
            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
        </label>
    </div>
    <div class="gerencianet">
        <p>Preencha os dados abaixo e faça upload do certificado com o nome <strong>pagamentos.pem</strong> no diretório
            principal do site.</p>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client ID:</strong></span>
            <input name="gerencianet_client_id" id="gerencianet_client_id"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="ex: Client_Id_2456913797e93b8933243e1d4ef36e52c9c6" value="<?php echo isset($gerencianet_client_id) ? $gerencianet_client_id : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
            <input name="gerencianet_client_secret" id="gerencianet_client_secret"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="ex: Client_Secret_afc18534a5534ab49b36f370871d088a1cce3cc" value="<?php echo isset($gerencianet_client_secret) ? $gerencianet_client_secret : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Chave Aleatória:</strong></span>
            <input name="gerencianet_pix_key" id="gerencianet_pix_key"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="ex: b3b6d68a-50db-3d88-b7ee-g215b41d0ec2" value="<?php echo isset($gerencianet_pix_key) ? $gerencianet_pix_key : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Taxa (%):</strong>
                <p>Taxa adicional que será cobrada para o cliente no ato do pagamento.</p>
            </span>
            <input name="gerencianet_tax" id="gerencianet_tax"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="0" type="number" value="<?php echo isset($gerencianet_tax) ? $gerencianet_tax : 0; ?>" />
        </label>
    </div>
</div>

<div id="tab3" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Habilitar Paggue?</span>
    </label>
    <div class="can-toggle">
        <input type="checkbox" name="paggue" id="paggue" <?php echo isset($paggue) && $paggue == 1 ? 'checked' : ''; ?>>
        <label for="paggue">
            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
        </label>
    </div>
    <div class="paggue">
        <p>Clique no link para obter as chaves de integração com o <a style="color:blue;text-decoration:underline;"
                href="https://portal.paggue.io/integrations" target="_blank">Paggue</a></p>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client KEY:</strong></span>
            <input name="paggue_client_key" id="paggue_client_key"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Informe a chave Client Key do Paggue" value="<?php echo isset($paggue_client_key) ? $paggue_client_key : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
            <input name="paggue_client_secret" id="paggue_client_secret"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Informe a chave Client Secret do Paggue" value="<?php echo isset($paggue_client_secret) ? $paggue_client_secret : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Taxa (%):</strong>
                <p>Taxa adicional que será cobrada para o cliente no ato do pagamento.</p>
            </span>
            <input name="paggue_tax" id="paggue_tax"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="0" type="number" value="<?php echo isset($paggue_tax) ? $paggue_tax : 0; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Webhook URL:</strong>
                <p>Adicione a URL abaixo na área "Webhook URL" no Paggue!</p>
            </span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                value="<?php echo BASE_URL . 'webhook.php?notify=paggue'; ?>" readonly />
        </label>
    </div>
</div>








<div id="tab4" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Habilitar OpenPix?</span>
    </label>
    <div class="can-toggle">
        <input type="checkbox" name="openpix" id="openpix" <?php echo isset($openpix) && $openpix == 1 ? 'checked' : ''; ?>>
        <label for="openpix">
            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
        </label>
    </div>
    <div class="openpix">
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>App ID:</strong></span>
            <input name="openpix_app_id" id="openpix_app_id"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Informe o App ID do OpenPix" value="<?php echo isset($openpix_app_id) ? $openpix_app_id : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Taxa (%):</strong>
                <p>Taxa adicional que será cobrada para o cliente no ato do pagamento.</p>
            </span>
            <input name="openpix_tax" id="openpix_tax"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="0" type="number" value="<?php echo isset($openpix_tax) ? $openpix_tax : 0; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Webhook URL:</strong>
                <p>Adicione a URL abaixo na área "Webhook" no OpenPix!</p>
            </span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                value="<?php echo BASE_URL . 'webhook.php?notify=openpix'; ?>" readonly />
        </label>
    </div>
</div>



<div id="tab5" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Habilitar Pay2m?</span>
    </label>
    <div class="can-toggle">
        <input type="checkbox" name="pay2m" id="pay2m" <?php echo isset($pay2m) && $pay2m == 1 ? 'checked' : ''; ?>>
        <label for="pay2m">
            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
        </label>
    </div>
    <div class="pay2m">
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client ID:</strong></span>
            <input name="pay2m_client_id" id="pay2m_client_id"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003"
                value="<?php echo isset($pay2m_client_id) ? $pay2m_client_id : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
            <input name="pay2m_client_secret" id="pay2m_client_secret"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003"
                value="<?php echo isset($pay2m_client_secret) ? $pay2m_client_secret : ''; ?>" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400"><strong>Taxa (%):</strong>
                <p>Taxa adicional que será cobrada para o cliente no ato do pagamento.</p>
            </span>
            <input name="pay2m_tax" id="pay2m_tax"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="0" type="number" value="<?php echo isset($pay2m_tax) ? $pay2m_tax : 0; ?>" />
        </label>
    </div>
</div>
<div style="margin-top:20px;">
    <input type="hidden" name="gateway" value='1'>
    <button form="gateway-form"
        class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        Salvar
    </button>
</div>
</form>
</div>
</div>



</main>

<script>
	var pageToken = 'gateway'; 
	$("#tabs a").click(function() {
		var selectedTab = $(this).attr("href");
		$("#tabs a").removeClass("active-tab");
		$(this).addClass("active-tab");
		$(".tabcontent").hide();
		$(selectedTab).show();
		localStorage.setItem('selectedTab_' + pageToken, pageToken + '_' + selectedTab);
		return false;
	});
	$(document).ready(function(){
		var storedTab = localStorage.getItem('selectedTab_' + pageToken);
		if (storedTab) {
			var selectedTab = storedTab.substring(pageToken.length + 1);
			$("#tabs a").removeClass("active-tab");
			$(selectedTab).addClass("active-tab");
			$(".tabcontent").hide();
			$(selectedTab).show();
		}	


		if($('#mercadopago').is(":checked")){
			$('.mercadopago').show();
		}else{
			$('.mercadopago').hide();	
		}
		$('#mercadopago').change(function() {
			if($('#mercadopago').is(":checked")){
				$('.mercadopago').show();
			}else{
				$('.mercadopago').hide();	
			}
		});

		if($('#pay2m').is(":checked")){
			$('.pay2m').show();
		}else{
			$('.pay2m').hide();	
		}
		$('#pay2m').change(function() {
			if($('#pay2m').is(":checked")){
				$('.pay2m').show();
			}else{
				$('.pay2m').hide();	
			}
		});

		if($('#gerencianet').is(":checked")){
			$('.gerencianet').show();
		}else{
			$('.gerencianet').hide();	
		}
		$('#gerencianet').change(function() {
			if($('#gerencianet').is(":checked")){
				$('.gerencianet').show();
			}else{
				$('.gerencianet').hide();	
			}
		}); 
		if($('#paggue').is(":checked")){
			$('.paggue').show();
		}else{
			$('.paggue').hide();	
		}
		$('#paggue').change(function() {
			if($('#paggue').is(":checked")){
				$('.paggue').show();
			}else{
				$('.paggue').hide();	
			}
		});
		if($('#openpix').is(":checked")){
			$('.openpix').show();
		}else{
			$('.openpix').hide();	
		}
		$('#openpix').change(function() {
			if($('#openpix').is(":checked")){
				$('.openpix').show();
			}else{
				$('.openpix').hide();	
			}
		}); 
// Fim ranking


//Save products
		$('#gateway-form').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:_base_url_+'class/System.php?action=update_system',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success:function(resp){
						var returnedData = JSON.parse(resp);
						if(returnedData.status == 'success'){
							alert('Configurações salvas com sucesso!');
							location.reload();
						}else{
							alert('Ops');
						}
					}
				})
		})
//End save products

	});

</script>      