<?php

$enable_cpf = $_settings->info('enable_cpf');
$enable_email = $_settings->info('enable_email');
$enable_address = $_settings->info('enable_address');
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$enable_footer = $_settings->info('enable_footer');
$enable_password = $_settings->info('enable_password');
$enable_instagram = $_settings->info('enable_instagram');
$enable_birth = $_settings->info('enable_birth');
$enable_legal_age = $_settings->info('enable_legal_age');
$enable_two_phone = $_settings->info('enable_two_phone');
$enable_multiple_order = $_settings->info('enable_multiple_order');
$enable_ga4 = $_settings->info('enable_ga4');
$enable_hide_numbers = $_settings->info('enable_hide_numbers');
$enable_gtm = $_settings->info('enable_gtm');
$enable_pixel = $_settings->info('enable_pixel');
$enable_dwapi = $_settings->info('enable_dwapi');
$facebook_access_token = $_settings->info('facebook_access_token');
$text_footer = $_settings->info('text_footer');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');
##########


$facebook_pixel_id = $_settings->info('facebook_pixel_id');

#####
$whatsapp_footer = $_settings->info('whatsapp_footer');
$instagram_footer = $_settings->info('instagram_footer');
$facebook_footer = $_settings->info('facebook_footer');
$twitter_footer = $_settings->info('twitter_footer');
$youtube_footer = $_settings->info('youtube_footer');

$google_ga4_id = $_settings->info('google_ga4_id');

$google_gtm_id = $_settings->info('google_gtm_id');
$theme = $_settings->info('theme');
$email_order = $_settings->info('email_order');
$email_purchase = $_settings->info('email_purchase');
$dealer_active = $_settings->info('dealer_active');
$dealer_deactive_site = $_settings->info('dealer_deactive_site');
$dealer_split_mercadopago = $_settings->info('dealer_split_mercadopago');
$mercadopago_tax = $_settings->info('mercadopago_tax');
$gerencianet_tax = $_settings->info('gerencianet_tax');
$paggue_tax = $_settings->info('paggue_tax');
$openpix_app_id = $_settings->info('openpix_app_id');
$openpix_tax = $_settings->info('openpix_tax');
$pay2m_client_id = $_settings->info('pay2m_client_id');
$pay2m_client_secret = $_settings->info('pay2m_client_secret');
$pay2m_tax = $_settings->info('pay2m_tax');
$openpix = $_settings->info('openpix');
$pay2m = $_settings->info('pay2m');
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

    #cimg {
        max-width: 100%;
        max-height: 25em;
        object-fit: scale-down;
        object-position: center center;
    }

    h2.social-rodape {
        font-weight: bold;
        margin-top: 20px;
    }
</style>

<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Configuração</h2>

        <div class="flex overflow-x-auto">
            <ul class="flex pb-1" id="tabs">
                <li class="mr-1">
                    <a href="#tab1" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">Configurações</a>
                </li>
                <li class="mr-1">
                    <a href="#tab2" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Cadastro</a>
                </li>

                <li class="mr-1">
                    <a href="#tab3" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Social</a>
                </li>
                <li class="mr-1">
                    <a href="#tab4" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Rodapé</a>
                </li>
                <li class="mr-1">
                    <a href="#tab6" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Cotas</a>
                </li>
                <li class="mr-1">
                    <a href="#tab7" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">WhatsApp</a>
                </li>
                <li class="mr-1">
                    <a href="#tab8" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Email</a>
                </li>
                <li class="mr-1">
                    <a href="#tab9" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">FAQ</a>
                </li>
                <li class="mr-1">
                    <a href="#tab10" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Termos</a>
                </li>
                <li class="mr-1">
                    <a href="#tab5" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Facebook</a>
                </li>
                <li class="mr-1">
                    <a href="#tab11" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Google</a>
                </li>

            </ul>
        </div>



        <form action="" id="manage-system">

            <div class="mt-4">


                <div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Titulo do site</span>
                        <input name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Titulo" value="<?php echo $_settings->info('name') ?>" />
                    </label>


                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">E-mail</span>
                        <input name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="admin@admin.com" value="<?php echo $_settings->info('email') ?>" />
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Telefone</span>
                        <input name="phone" id="phone" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="(00) 00000-0000" value="<?php echo $_settings->info('phone') ?>" />
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">
                            Tema
                        </span>
                        <select name="theme" id="theme" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="1">Padrão</option>
                            <option value="2" selected="">Preto</option>
                            <option value="3">Azul</option>
                            <option value="4">Roxo</option>
                            <option value="5">Laranja</option>
                        </select>
                    </label>


                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Logo:</span>
                        <input id="customFile1" name="img" onchange="displayImg(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" accept="image/png, image/jpeg">
                    </label>

                    <label class="block mt-4 text-sm">
                        <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail !min-w-[200px] !max-w-[280px]  max-w-30 max-h-30">


                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Favicon:</span>
                            <input id="customFile2" name="favicon" onchange="displayFavicon(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" accept="image/png, image/jpeg">
                        </label>

                        <label class="block mt-4 text-sm">
                            <img src="<?php echo validate_image($_settings->info('favicon')) ?>" alt="" id="favicon" class="img-fluid img-thumbnail !min-w-[200px] !max-w-[280px] ">
                        </label>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Bloquear múltiplos pedidos?</span>
                        <p class="mb-2" style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o cliente só poderá realizar um novo pedido após efetuar o pagamento do pedido anterior ou o mesmo expirar.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_multiple_order) && $enable_multiple_order == 1 ? 'checked' : '' ?> name="enable_multiple_order" id="enable_multiple_order">
                        <label for="enable_multiple_order">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>




                </div>

                <div id="tab2" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                    <p>Os dados habilitados abaixo serão obrigatórios no formulário de cadastro do site.</p>
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar dupla verificação de telefone?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Quando essa opção estiver ativa, o usuário deverá informar o telefone duas vezes na criação de conta</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_two_phone) && $enable_two_phone == 1 ? 'checked' : '' ?> name="enable_two_phone" id="enable_two_phone">
                        <label for="enable_two_phone">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar senha?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Quando essa opção estiver desabilitada, não será necessário inserir uma senha durante o processo de cadastro e também para fazer o login no sistema.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_password) && $enable_password == 1 ? 'checked' : '' ?> name="enable_password" id="enable_password">
                        <label for="enable_password">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar CPF?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá exigir que o usuário forneça seu CPF para efetuar um cadastro/compra e também para buscar seus números.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_cpf) && $enable_cpf == 1 ? 'checked' : '' ?> name="enable_cpf" id="enable_cpf">
                        <label for="enable_cpf">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar E-mail?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá exigir que o usuário forneça um email válido para efetuar um cadastro/compra.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_email) && $enable_email == 1 ? 'checked' : '' ?> name="enable_email" id="enable_email">
                        <label for="enable_email">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar data de nascimento?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá exigir que o usuário forneça sua data de nascimento para efetuar um cadastro/compra.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_birth) && $enable_birth == 1 ? 'checked' : '' ?> name="enable_birth" id="enable_birth">
                        <label for="enable_birth">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar usuários apenas maiores de 18 anos?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá aceitar apenas cadastros de clientes maiores de 18 anos.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_legal_age) && $enable_legal_age == 1 ? 'checked' : '' ?> name="enable_legal_age" id="enable_legal_age">
                        <label for="enable_legal_age">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar instagram?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá exigir que o usuário forneça seu instagram para efetuar um cadastro/compra.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_instagram) && $enable_instagram == 1 ? 'checked' : '' ?> name="enable_instagram" id="enable_instagram">
                        <label for="enable_instagram">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar Endereço?</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Ao habilitar esta opção, o sistema irá exibir opções de endereço na página de atualização de cadastro do usuário</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_address) && $enable_address == 1 ? 'checked' : '' ?> name="enable_address" id="enable_address">
                        <label for="enable_address">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                </div>

                <div id="tab3" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar botões de compartilhamento?</span>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_share) && $enable_share == 1 ? 'checked' : '' ?> name="enable_share" id="enable_share">
                        <label for="enable_share">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar botão para acessar os grupos?</span>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_groups) && $enable_groups == 1 ? 'checked' : '' ?> name="enable_groups" id="enable_groups">
                        <label for="enable_groups">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <div class="groups_social" id="groups_social">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Link do grupo Telegram:</span>
                            <input name="telegram_group_url" id="telegram_group_url" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://telegram.org" value="<?php echo $_settings->info('telegram_group_url') ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Link do grupo WhatsApp:</span>
                            <input name="whatsapp_group_url" id="whatsapp_group_url" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://whatsapp.com/" value="<?php echo $_settings->info('telegram_group_url') ?>">
                        </label>
                    </div>



                </div>
                <div id="tab4" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar rodapé?</span>
                    </label>
                    <div class="can-toggle">
                        <input <?= isset($enable_footer) && $enable_footer == 1 ? 'checked' : '' ?> type="checkbox" name="enable_footer" id="enable_footer">
                        <label for="enable_footer">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <div class="footer-text" style="display: none;">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Texto do rodapé:</span>
                            <input name="text_footer" id="text_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ex: Todos os direitos reservados." value="<?php echo $_settings->info('text_footer') ?>">
                        </label>


                    </div>

                    <h2 class="social-rodape">Redes Sociais - Rodapé</h2>
                    <p>Preencha os campos abaixo para exibir as redes sociais no rodapé ou deixe em branco para não exibir.</p>
                    <div class="groups">

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">WhatsApp:</span>
                            <input name="whatsapp_footer" id="whatsapp_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://api.whatsapp.com/send?l=pt_br&amp;phone=00000" value="<?php echo $_settings->info('whatsapp_footer') ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Instagram:</span>
                            <input name="instagram_footer" id="instagram_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://instagram.com/" value="<?php echo $_settings->info('instagram_footer') ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Facebook:</span>
                            <input name="facebook_footer" id="facebook_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://facebook.com/" value="<?php echo $_settings->info('facebook_footer') ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Twitter:</span>
                            <input name="twitter_footer" id="twitter_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://twitter.com/" value="<?php echo $_settings->info('facebook_footer') ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Youtube:</span>
                            <input name="youtube_footer" id="youtube_footer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="https://youtube.com/" value="<?php echo $_settings->info('youtube_footer') ?>">
                        </label>

                    </div>



                </div>

                <div id="tab5" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar API de conversão?</span>
                        <p>Área destinada ao gestor de tráfego para implantação da API de conversão do Facebook ADS.</p>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" <?= isset($enable_pixel) && $enable_pixel == 1 ? 'checked' : '' ?> name="enable_pixel" id="enable_pixel">
                        <label for="enable_pixel">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>
                    <div class="pixel-facebook">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Access Token (Facebook) *:</span>
                            <input value="<?php echo $_settings->info('facebook_access_token') ?>" name="facebook_access_token" id="facebook_access_token" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Informe o ACCESS TOKEN do facebook">
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Pixel ID (Facebook) *:</span>
                            <input name="facebook_pixel_id" id="facebook_pixel_id" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Informe o PIXEL ID do facebook" value="<?php echo $_settings->info('facebook_access_token') ?>">
                        </label>
                    </div>

                </div>

                <div id="tab11" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar Google Analytics?</span>
                        <p>Área destinada ao gestor de tráfego para implantação do Google Analytics (GA4)</p>
                    </label>

                    <div class="can-toggle">
                        <input type="checkbox" name="enable_ga4" <?= isset($enable_ga4) && $enable_ga4 == 1 ? 'checked' : '' ?> id="enable_ga4">
                        <label for="enable_ga4">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_settings->userdata('id') ?>">

                    <div class="pixel-google">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">ID (GA4)*:</span>
                            <input name="google_ga4_id" id="google_ga4_id" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Informe o ID do analytics" value="<?php echo $_settings->info('google_ga4_id') ?>">
                        </label>
                    </div>
                    <br>
                    <hr>
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar Google Tag Manager?</span>
                        <p>Área destinada ao gestor de tráfego para implantação do Google Tag Manager (GTM)</p>
                    </label>

                    <div class="can-toggle">
                        <input type="checkbox" name="enable_gtm" id="enable_gtm" <?= isset($enable_gtm) && $enable_gtm == 1 ? 'checked' : '' ?>>
                        <label for="enable_gtm">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <div class="pixel-google-gtm">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">ID (GTM)*:</span>
                            <input name="google_gtm_id" id="google_gtm_id" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Informe o ID do GTM" value="<?php echo $_settings->info('google_gtm_id') ?>">
                        </label>
                    </div>
                </div>

                <div id="tab6" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Cotas</span>
                        <p>Ao habilitar essa opção as cotas das <strong>campanhas automáticas</strong> só serão geradas e exibidas quando o pagamento for aprovado.</p>
                    </label>
                    <div class="can-toggle">
                        <input <?= isset($enable_hide_numbers) && $enable_hide_numbers == 1 ? 'checked' : '' ?> type="checkbox" name="enable_hide_numbers" id="enable_hide_numbers">
                        <label for="enable_hide_numbers">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                </div>

                <div id="tab7" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Ativar integração</span>
                        <p>Ao habilitar essa opção o sistema irá enviar automaticamente uma mensagem para o WhatsApp do cliente ao efetuar um novo pedido.</p>
                        <p style="font-size:13px;color: orange;font-style:italic;">Essa integração é feita através da <a href="https://dw-api.com/" target="_blank">DW-API</a>. É necessário um plano ativo na mesma para poder utilizar. Você pode testar por 3 dias grátis.</p>
                        <br>
                    </label>
                    <div class="can-toggle">
                        <input <?= isset($enable_dwapi) && $enable_dwapi == 1 ? 'checked' : '' ?> type="checkbox" name="enable_dwapi" id="enable_dwapi">
                        <label for="enable_dwapi">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>

                    <label class="block text-sm">
                        <p><b>[CAMPANHA]</b> - Irá exibir o nome da campanha</p>
                        <p><b>[CLIENTE]</b> - Irá exibir o nome do cliente</p>
                        <p><b>[COTAS]</b> - Irá exibir as cotas do pedido</p>
                        <p><b>[TOTAL]</b> - Irá exibir o valor total do pedido</p>
                        <p><b>[PIX]</b> - Irá exibir o código copia e cola do PIX</p>
                        <p><b>[N]</b> - Irá inserir uma quebra de linha</p>
                        <br>
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Token</span>
                        <input name="token_dwapi" id="token_dwapi" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('token_dwapi') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Número que irá fazer os envios</span>
                        <input name="numero_dwapi" id="numero_dwapi" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('numero_dwapi') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Mensagem que será enviada para o cliente quando um pedido for feito</span>
                        <input name="mensagem_novo_pedido_dwapi" id="mensagem_novo_pedido_dwapi" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('mensagem_novo_pedido_dwapi') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Mensagem que será enviada para o cliente quando um pedido for pago</span>
                        <input name="mensagem_pedido_pago_dwapi" id="mensagem_pedido_pago_dwapi" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('mensagem_pedido_pago_dwapi') ?>">
                    </label>

                </div>

                <div id="tab8" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Servidor de email customizado</span>
                        <p>Se deseja utilizar um servidor de email personalizado, preencha os dados do mesmo abaixo, caso contrário, deixe os campos em branco.</p>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Servidor SMTP</span>
                        <input name="smtp_host" id="smtp_host" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="smtp.yourhost.com" value="<?php echo $_settings->info('smtp_host') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Porta</span>
                        <input name="smtp_port" id="smtp_port" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="465" value="<?php echo $_settings->info('smtp_port') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Usuário</span>
                        <input name="smtp_user" id="smtp_user" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Usuário" value="<?php echo $_settings->info('smtp_user') ?>">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Senha</span>
                        <input name="smtp_pass" id="smtp_pass" type="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="*****" value="<?php echo $_settings->info('smtp_pass') ?>">
                    </label>

                    <hr class="mt-4 mb-4">

                    <label class="block text-sm">
                        <p class="mb-2">Shortcodes disponíveis</p>
                        <p><b>[CAMPANHA]</b> - Irá exibir o nome da campanha</p>
                        <p><b>[CLIENTE]</b> - Irá exibir o nome do cliente</p>
                        <p><b>[COTAS]</b> - Irá exibir as cotas do pedido</p>
                        <p><b>[TOTAL]</b> - Irá exibir o valor total do pedido</p>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Corpo do email que será enviado para o cliente ao efetuar uma compra</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Você pode utilizar tags html na descrição para uma melhor formatação</p>
                        <textarea name="email_order" id="email_order" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="6"></textarea>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Corpo do email que será enviado para o cliente ao efetuar um pagamento</span>
                        <p style="font-size:13px;color: orange;font-style:italic;">Você pode utilizar tags html na descrição para uma melhor formatação</p>
                        <textarea name="email_purchase" id="email_purchase" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="6"></textarea>
                    </label>

                </div>

                <div id="tab9" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">Pergunta 1</span>
                        <input name="question1" id="question1" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('question1') ?>">
                        <input name="answer1" id="answer1" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('answer1') ?>">
                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">Pergunta 2</span>
                        <input name="question2" id="question2" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('question2') ?>">
                        <input name="answer2" id="answer2" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('answer2') ?>">
                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">Pergunta 3</span>
                        <input name="question3" id="question3" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('question3') ?>">
                        <input name="answer3" id="answer3" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('answer3') ?>">
                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">Pergunta 4</span>
                        <input name="question4" id="question4" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('answer4') ?>">
                        <input name="answer4" id="answer4" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?php echo $_settings->info('answer4') ?>">
                    </label>

                </div>

                <div id="tab10" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">Termos de uso</span>
                        <input name="terms" id="terms" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" value="<?=  $_settings->info('terms') ? $_settings->info('terms') : '' ?>">
                    </label>

                </div>

            </div>




            <div style="margin-top:20px;">
                <button form="manage-system" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Salvar
                </button>
            </div>

        </form>

    </div>



</main>
<span id="openModal" href="javascript:void(0)" @click="openModal"></span>
<div  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
    <!-- Modal -->
    <div  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <div class="mt-4 mb-6">
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                Parabéns!
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-400">
                Alterações salvas com sucesso!
            </p>
        </div>

    </div>
</div>
<script>
    if ($('#enable_groups').is(":checked")) {
        $('.groups_social').show();
    } else {
        $('.groups_social').hide();
    }
    $('#enable_groups').change(function() {
        if ($('#enable_groups').is(":checked")) {
            $('.groups_social').show();
        } else {
            $('.groups_social').hide();
        }
    });

    if ($('#enable_footer').is(":checked")) {
        $('.footer-text').show();
    } else {
        $('.footer-text').hide();
    }
    $('#enable_footer').change(function() {
        if ($('#enable_footer').is(":checked")) {
            $('.footer-text').show();
        } else {
            $('.footer-text').hide();
        }
    });
    $('#enable_pixel').change(function() {
        if ($('#enable_pixel').is(":checked")) {
            $('.pixel-facebook').show();
        } else {
            $('.pixel-facebook').hide();
        }
    });
    $('#enable_ga4').change(function() {
        if ($('#enable_ga4').is(":checked")) {
            $('.pixel-google').show();
        } else {
            $('.pixel-google').hide();
        }
    });
    $('#enable_gtm').change(function() {
        if ($('#enable_gtm').is(":checked")) {
            $('.pixel-google-gtm').show();
        } else {
            $('.pixel-google-gtm').hide();
        }
    });




    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            $('#cimg').attr('src', "<?php echo validate_image($_settings->info('logo')) ?>");
        }
    }

    function displayFavicon(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#favicon').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            $('#favicon').attr('src', "<?php echo validate_image($_settings->info('favicon')) ?>");
        }
    }

    var pageToken = 'system_info';
    $("#tabs a").click(function() {
        var selectedTab = $(this).attr("href");
        $("#tabs a").removeClass("active-tab");
        $(this).addClass("active-tab");
        $(".tabcontent").hide();
        $(selectedTab).show();
        localStorage.setItem('selectedTab_' + pageToken, pageToken + '_' + selectedTab);
        return false;
    });
    $(document).ready(function() {

        var storedTab = localStorage.getItem('system_info' + pageToken);
        if (storedTab) {
            var selectedTab = storedTab.substring(pageToken.length + 1);
            $("#tabs a").removeClass("active-tab");
            $(selectedTab).addClass("active-tab");
            $(".tabcontent").hide();
            $(selectedTab).show();
        }


        $('#manage-system').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: _base_url_ + 'classes/SystemSettings.php?f=update_settings',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    var returnedData = JSON.parse(resp);
                    if (returnedData.status == 'success') {
                        alert('Configurações salvas com sucesso!');
                        location.reload();
                    } else {
                        alert('Ops');
                    }
                }
            })
        })

    });
</script>