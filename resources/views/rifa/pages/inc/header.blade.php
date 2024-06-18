<div id="__next">
    <header class="header-app-header <?= $page ?>">
        <div class="header-app-header-container">
            <div class="container container-600 font-mdd">
                <div style="text-align-last: justify; padding: 10 0 10 0;">
                    <button type="button" aria-label="Menu" class="btn btn-link text-white font-lgg ps-0"
                        data-bs-toggle="modal" data-bs-target="#mobileMenu" style="margin-top:5px">
                       <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-filter-left" viewBox="0 0 16 16">
  <path d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
</svg>
                    </button>
                    <a class="flex-grow-1 text-center" href="/" wire:navigate>
                        <?php if ($logo) : ?>
                        <img src="<?= $logo ?>" class="header-app-brand">
                        <?php else : ?>
                        <img src="{{ asset('assets/img/logo.png') }}" class="header-app-brand">
                        <?php endif; ?>
                    </a>
                    <?php
                    if (CONTACT_TYPE == '1') {
                        echo '<a class="btn btn-link text-white pe-0 text-right text-decoration-none" href="/contato"wire:navigate>' . "\r\n";
                    } else {
                        echo '<a class="btn btn-link text-white pe-0 text-right text-decoration-none" href="https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone') . '"wire:navigate>' . "\r\n";
                    }
                    echo '<div class="suporte d-flex justify-content-end opacity-50"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-dots-fill" viewBox="0 0 16 16">
  <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353zM5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
</svg></div>' . "\r\n";
                    echo '<div class="suporte text-yellow font-xss">Suporte</div>' . "\r\n";
                    echo '</a>';
                    ?>
                </div>
            </div>
        </div>
    </header>
    <div class="black-bar fuse <?= $page ?>"></div>
    <menu id="mobileMenu" class="modal fade modal-fluid" tabindex="-1" aria-labelledby="mobileMenuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-cor-primaria">
                <header class="app-header app-header-mobile--show">
                    <div class="container container-600 h-100 d-flex align-items-center justify-content-between">
                        <?php if ($logo) : ?>
                        <a href="/" wire:navigate>
                            <img src="<?= $logo ?>" class="app-brand img-fluid">
                        </a>
                        <?php else : ?>
                        <a href="/" wire:navigate>
                            <img src="<?= BASE_URL ?>assets/img/logo.png" class="app-brand img-fluid">
                        </a>
                        <?php endif; ?>
                        <div class="app-header-mobile"><button type="button"
                                class="btn btn-link text-white menu-mobile--button pe-0 font-lgg"
                                data-bs-dismiss="modal" aria-label="Fechar"><i class="bi bi-x-circle"></i></button>
                        </div>
                    </div>
                </header>
                <div class="modal-body">
                    <div class="container container-600">
                        <?php if ($user_id) : ?>
                        <div class="card-usuario mb-2">
                            <picture>
                                <img src="<?= $_settings->userdata('avatar') ? validate_image($_settings->userdata('avatar')) : BASE_URL . 'assets/img/avatar.png' ?>"
                                    class="img-fluid img-perfil">
                            </picture>
                            <div class="card-usuario--informacoes">
                                <h3>Olá,
                                    <?= ucwords($_settings->userdata('firstname')) . ' ' . ucwords($_settings->userdata('lastname')) ?>
                                </h3>
                                <div class="email font-xss saldo-value"></div>
                            </div>
                            <div class="card-usuario--sair">
                                <a href="<?= BASE_URL . 'auth/Auth.php?action=logout_customer' ?>">
                                    <button type="button"
                                        class="btn btn-link text-center text-white-50 ps-1 pe-0 pt-0 pb-0 font-lg">
                                        <i class="bi bi-box-arrow-left"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <nav class="nav-vertical nav-submenu font-xs mb-2">
                            <ul>
                                <li>
                                    <a class="text-white" alt="Página Principal" href="/" wire:navigate><i
                                            class="icone bi bi-house"></i><span>Início</span></a>
                                </li>
                                <li>
                                    <a class="text-white" alt="Campanhas" href="/campanhas" wire:navigate><i
                                            class="icone bi bi-megaphone"></i><span>Campanhas</span></a>
                                </li>
                                <li>
                                    <a class="text-white" alt="Meus Números" href="/meus-numeros" wire:navigate><i
                                            class="icone bi bi-card-list"></i><span>Meus números</span></a>
                                </li>
                                <?php if ($user_id) : ?>
                                <li>
                                    <a alt="Atualizar cadastro" class="text-white" href="/user/atualizar-cadastro"
                                        wire:navigate><i class="icone bi bi-person-circle"></i><span>Cadastro</span></a>
                                </li>
                                <li>
                                    <a alt="Minhas compras" class="text-white" href="/user/compras" wire:navigate><i
                                            class="icone bi bi-cart-check"></i><span>Minhas compras</span></a>
                                </li>
                                <?php if ($enable_password == 1) : ?>
                                <li>
                                    <a alt="Alterar senha" class="text-white" href="/user/alterar-senha"
                                        wire:navigate><i class="icone bi bi-key-fill"></i><span>Alterar senha</span></a>
                                </li>
                                <?php endif; ?>
                                <?php else : ?>
                                <li>
                                    <a alt="Cadastre-se" class="text-white" href="/cadastrar" wire:navigate><i
                                            class="icone bi bi-box-arrow-in-right"></i><span>Cadastro</span></a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a alt="Ganhadores" class="text-white" href="/ganhadores" wire:navigate><i
                                            class="icone bi bi-trophy"></i><span>Ganhadores</span></a>
                                </li>
                                <?php if (!!$_settings->info('terms')) : ?>
                                <li>
                                    <a alt="Termos de Uso" class="text-white" href="/termos-de-uso" wire:navigate><i
                                            class="icone bi bi-blockquote-right"></i><span>Termos de uso</span></a>
                                </li>
                                <?php endif; ?>
                                <?php if (CONTACT_TYPE == 1) : ?>
                                <li class="col-contato-display">
                                    <a alt="Entre em contato conosco" class="text-white" href="/contato"
                                        wire:navigate><i class="icone bi bi-envelope"></i><span>Entrar em
                                            contato</span></a>
                                </li>
                                <?php else : ?>
                                <li class="col-contato-display">
                                    <a alt="Entre em contato conosco" class="text-white"
                                        href="<?= 'https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone') ?>"
                                        wire:navigate><i class="icone bi bi-envelope"></i><span>Entrar em
                                            contato</span></a>
                                </li>
                                <?php endif; ?>
                                <?php if ($affiliate) : ?>
                                <li class="col-contato-display">
                                    <a alt="Painel de afiliado" class="text-white" href="/user/afiliado"
                                        wire:navigate><i class="icone bi bi-wallet"></i></i><span>Painel de
                                            afiliado</span></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php if (!$user_id) : ?>
                        <div class="text-center">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal"
                                class="btn btn-primary w-100 rounded-pill"><i
                                    class="icone bi bi-box-arrow-in-right"></i> Entrar</button>
                        </div>
                        <?php else : ?>
                        <a href="<?= BASE_URL . 'auth/Auth.php?action=logout_customer' ?>">
                            <button type="button" class="btn btn-primary w-100 rounded-pill"><i
                                    class="icone bi bi-box-arrow-in-right"></i> Sair</button>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </menu>
  