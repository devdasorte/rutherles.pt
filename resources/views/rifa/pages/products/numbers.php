<?php
$ref = isset($_GET['ref']) ? $_GET['ref'] : '';
$paid_and_pending = $pending_numbers + $paid_numbers;
$available = (int) $qty_numbers - $paid_and_pending;
$percent = ($paid_and_pending * 100) / $qty_numbers;
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');
$max_discount = 0;

$user_id = $_settings->userdata('id');

if ($available < $min_purchase) {
    $min_purchase = $available;
}

$enable_cpf = $_settings->info('enable_cpf');

if ($enable_cpf == 1) {
    $search_type = 'search_orders_by_cpf';
} else {
    $search_type = 'search_orders_by_phone';
}

?>


<div id="overlay">
    <div class="cv-spinner"><span class="spinner"></span></div>
</div>
<style>
    .carousel,
    .carousel-inner,
    .carousel-item {
        position: relative
    }

    #overlay,
    .carousel-item {
        width: 100%;
        display: none
    }

    @media (min-width:1200px) {
        h3 {
            font-size: 1.75rem
        }
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem
    }

    img {
        vertical-align: middle
    }

    button {
        border-radius: 0;
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        text-transform: none
    }

    button:focus:not(:focus-visible) {
        outline: 0
    }

    [type=button],
    button {
        -webkit-appearance: button
    }

    .form-control-color:not(:disabled):not([readonly]),
    .form-control[type=file]:not(:disabled):not([readonly]),
    [type=button]:not(:disabled),
    [type=reset]:not(:disabled),
    [type=submit]:not(:disabled),
    button:not(:disabled) {
        cursor: pointer
    }

    ::-moz-focus-inner {
        padding: 0;
        border-style: none
    }

    ::-webkit-datetime-edit-day-field,
    ::-webkit-datetime-edit-fields-wrapper,
    ::-webkit-datetime-edit-hour-field,
    ::-webkit-datetime-edit-minute,
    ::-webkit-datetime-edit-month-field,
    ::-webkit-datetime-edit-text,
    ::-webkit-datetime-edit-year-field {
        padding: 0
    }

    ::-webkit-inner-spin-button {
        height: auto
    }

    ::-webkit-search-decoration {
        -webkit-appearance: none
    }

    ::-webkit-color-swatch-wrapper {
        padding: 0
    }

    ::-webkit-file-upload-button {
        font: inherit;
        -webkit-appearance: button
    }

    ::file-selector-button {
        font: inherit;
        -webkit-appearance: button
    }

    .container-fluid {
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        width: 100%;
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-right: auto;
        margin-left: auto
    }

    .form-control::file-selector-button {
        padding: .375rem .75rem;
        margin: -.375rem -.75rem;
        -webkit-margin-end: .75rem;
        margin-inline-end: .75rem;
        color: #212529;
        background-color: #e9ecef;
        pointer-events: none;
        border: 0 solid;
        border-inline-end-width: 1px;
        border-radius: 0;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        border-color: inherit
    }

    .form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
        background-color: #dde0e3
    }

    .form-control:hover:not(:disabled):not([readonly])::file-selector-button {
        background-color: #dde0e3
    }

    .form-control-sm::file-selector-button {
        padding: .25rem .5rem;
        margin: -.25rem -.5rem;
        -webkit-margin-end: .5rem;
        margin-inline-end: .5rem
    }

    .form-control-lg::file-selector-button {
        padding: .5rem 1rem;
        margin: -.5rem -1rem;
        -webkit-margin-end: 1rem;
        margin-inline-end: 1rem
    }

    .form-floating>.form-control-plaintext:not(:-moz-placeholder-shown),
    .form-floating>.form-control:not(:-moz-placeholder-shown) {
        padding-top: 1.625rem;
        padding-bottom: .625rem
    }

    .form-floating>.form-control:not(:-moz-placeholder-shown)~label {
        opacity: .65;
        transform: scale(.85) translateY(-.5rem) translateX(.15rem)
    }

    .input-group>.form-control:not(:focus).is-valid,
    .input-group>.form-floating:not(:focus-within).is-valid,
    .input-group>.form-select:not(:focus).is-valid,
    .was-validated .input-group>.form-control:not(:focus):valid,
    .was-validated .input-group>.form-floating:not(:focus-within):valid,
    .was-validated .input-group>.form-select:not(:focus):valid {
        z-index: 3
    }

    .input-group>.form-control:not(:focus).is-invalid,
    .input-group>.form-floating:not(:focus-within).is-invalid,
    .input-group>.form-select:not(:focus).is-invalid,
    .was-validated .input-group>.form-control:not(:focus):invalid,
    .was-validated .input-group>.form-floating:not(:focus-within):invalid,
    .was-validated .input-group>.form-select:not(:focus):invalid {
        z-index: 4
    }

    .btn:focus-visible {
        color: var(--bs-btn-hover-color);
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-border-color);
        outline: 0;
        box-shadow: var(--bs-btn-focus-box-shadow)
    }

    .btn-check:focus-visible+.btn {
        border-color: var(--bs-btn-hover-border-color);
        outline: 0;
        box-shadow: var(--bs-btn-focus-box-shadow)
    }

    .btn-check:checked+.btn:focus-visible,
    .btn.active:focus-visible,
    .btn.show:focus-visible,
    .btn:first-child:active:focus-visible,
    :not(.btn-check)+.btn:active:focus-visible {
        box-shadow: var(--bs-btn-focus-box-shadow)
    }

    .btn-link:focus-visible {
        color: var(--bs-btn-color)
    }

    .carousel-inner {
        width: 100%;
        overflow: hidden
    }

    .carousel-inner::after {
        display: block;
        clear: both;
        content: ""
    }

    .carousel-item {
        float: left;
        margin-right: -100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transition: transform .6s ease-in-out
    }

    .carousel-item.active {
        display: block
    }

    .carousel-control-next,
    .carousel-control-prev {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 15%;
        padding: 0;
        color: #fff;
        text-align: center;
        background: 0 0;
        border: 0;
        opacity: .5;
        transition: opacity .15s
    }

    .carousel-control-next:focus,
    .carousel-control-next:hover,
    .carousel-control-prev:focus,
    .carousel-control-prev:hover {
        color: #fff;
        text-decoration: none;
        outline: 0;
        opacity: .9
    }

    .carousel-control-prev {
        left: 0
    }

    .carousel-control-next {
        right: 0
    }

    .carousel-control-next-icon,
    .carousel-control-prev-icon {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 100% 100%
    }

    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\' fill=\'%23fff\'%3e%3cpath d=\'M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z\'/%3e%3c/svg%3e")
    }

    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\' fill=\'%23fff\'%3e%3cpath d=\'M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z\'/%3e%3c/svg%3e")
    }

    .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 2;
        display: flex;
        justify-content: center;
        padding: 0;
        margin-right: 15%;
        margin-bottom: 1rem;
        margin-left: 15%;
        list-style: none
    }

    .carousel-indicators [data-bs-target] {
        box-sizing: content-box;
        flex: 0 1 auto;
        width: 30px;
        height: 3px;
        padding: 0;
        margin-right: 3px;
        margin-left: 3px;
        text-indent: -999px;
        cursor: pointer;
        background-color: #fff;
        background-clip: padding-box;
        border: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: .5;
        transition: opacity .6s
    }

    @media (prefers-reduced-motion:reduce) {
        .form-control::file-selector-button {
            transition: none
        }

        .carousel-control-next,
        .carousel-control-prev,
        .carousel-indicators [data-bs-target],
        .carousel-item {
            transition: none
        }
    }

    .carousel-indicators .active {
        opacity: 1
    }

    .visually-hidden-focusable:not(:focus):not(:focus-within) {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important
    }

    .d-block {
        display: block !important
    }

    .mt-3 {
        margin-top: 1rem !important
    }

    .sorteio_sorteioShare__247_t {
        position: fixed;
        bottom: 120px;
        right: 12px;
        display: -moz-box;
        display: flex;
        -moz-box-orient: vertical;
        -moz-box-direction: normal;
        flex-direction: column
    }

    .top-compradores {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        margin-top: 20px
    }

    .comprador {
        margin-right: 3px;
        margin-bottom: 8px;
        border: 1px solid #198754;
        padding: 22px;
        text-align: center;
        margin-left: 10px;
        background: #fff;
        border-radius: 6px;
        min-width: 160px
    }

    .ranking {
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 18px
    }

    .customer-details {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 14px
    }

    #overlay {
        position: fixed;
        top: 0;
        height: 100%;
        background: rgba(0, 0, 0, .6);
        z-index: 99999999
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #ddd;
        border-top: 4px solid #2e93e6;
        border-radius: 50%;
        animation: .8s linear infinite sp-anime
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg)
        }
    }

    .is-hide {
        display: none
    }

    .numero-template {
        background-color: #37495d;
        border-radius: 5px;
        margin-bottom: 5px;
        text-align: center;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        padding: 8px;
        color: #fff;
        position: relative;
        transition: background-color .3s ease-in-out;
        cursor: pointer
    }

    .numero-template.numero-template-selected {
        background-color: #343a40
    }

    .sorteio-numeros-selecionados {
        box-shadow: 0 0 10px rgba(0, 0, 0, .35);
        transition: opacity .3s ease-in-out, bottom .3s ease-in-out;
        background-color: var(--incrivel-cardBg);
        color: #171717;
        padding: 15px 10px 10px;
        pointer-events: none;
        border-radius: 10px;
        min-height: 96px;
        max-width: 600px;
        position: -webkit-sticky;
        position: sticky;
        margin: 0 auto;
        bottom: -110px;
        opacity: 0;
        display: none;
        z-index: 999
    }

    .sorteio-numeros-selecionados.sorteio-numeros-selecionados-open {
        pointer-events: auto;
        bottom: 10px;
        opacity: 1;
        display: block !important;
    }

    .loading {
        padding: 10px;
        border-radius: 4px;
        background-color: #cff4fc;
        color: #056388;
        text-align: center
    }

    .tooltp::before {
        content: attr(data-nome);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px;
        background-color: #000;
        color: #fff;
        font-size: 12px;
        border-radius: 3px;
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s, visibility .3s
    }

    .tooltp:hover::before {
        opacity: 1;
        visibility: visible
    }

    @media only screen and (max-width:600px) {
        .custom-image {
            height: 310px !important
        }
    }

    @media only screen and (min-width:768px) {
        .custom-image {
            height: 450px !important
        }
    }

    .numeros-list {
        overflow-y: auto;
        max-height: 600px;
    }
</style>

<div class="container app-main">
    <div class="campanha-header mb-2">
        <div class="SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">
            <div style="bottom:40px !important; top: auto !important; right:16px !important; position: absolute !important;left:auto!important"
                class="custom-badge-display">
                <?php if ($status_display == 1) : ?>
                <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                <?php endif; ?>

                <?php if ($status_display == 2) : ?>
                <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
                <?php endif; ?>

                <?php if ($status_display == 3) : ?>
                <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
                <?php endif; ?>

                <?php if ($status_display == 4) : ?>
                <span class="badge bg-dark font-xsss">Concluído</span>
                <?php endif; ?>

                <?php if ($status_display == 5) : ?>
                <span class="badge bg-dark font-xsss">Em breve!</span>
                <?php endif; ?>

                <?php if ($status_display == 6) : ?>
                <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
                <?php endif; ?>
            </div>
            <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
                <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade"
                    data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $image_gallery = isset($image_gallery) ? $image_gallery : "";
                        if ($image_gallery != "[]" && !empty($image_gallery)) {
                            $image_gallery = json_decode($image_gallery, true);
                            array_unshift($image_gallery, $image_path);
                            $slide = 0;

                            foreach ($image_gallery as $image) {
                                ++$slide;
                        ?>
                        <div class="custom-image carousel-item <?php echo $slide == 1 ? 'active' : ''; ?>">
                            <img alt="<?php echo isset($name) ? $name : ''; ?>" src="<?php echo BASE_URL . $image; ?>" decoding="async" data-nimg="fill"
                                class="SorteioTpl_imagem__2GXxI">
                        </div>
                        <?php
                            }
                        } else {
                            ?>
                        <div class="custom-image carousel-item active">
                            <img src="<?php echo validate_image(isset($image_path) ? $image_path : ''); ?>" alt="<?php echo isset($name) ? $name : ''; ?>" class="SorteioTpl_imagem__2GXxI"
                                style="width:100%">
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
                <?php if ($image_gallery != "[]" && !empty($image_gallery)) : ?>
                <button class="carousel-control-prev" type="button"
                    data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button"
                    data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <?php endif; ?>
            </div>
            <div class="SorteioTpl_info__t1BZr custom-content-wrapper <?php echo $status_display != '4' && $status_display != '5' ? 'custom-content-wrapper-details' : ''; ?>">
                <h1 class="SorteioTpl_title__3RLtu_xl"><?php echo isset($name) ? $name : ''; ?></h1>
                <div class="iZCVCw">
                    <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">
                        <?php echo isset($subtitle) ? $subtitle : ''; ?></p>
                </div>
                <?php if ($status_display != "4" && $status_display != "5") : ?>
                <div class="btn btn-sm btn-success box-shadow-08 w-100" data-bs-toggle="modal"
                    data-bs-target="#modal-consultaCompras">
                    <i class="bi bi-cart"></i> Ver meus números
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="sorteio-buscas  mt-2">
        <div class="row row-gutter-sm">
            <div class="col">

                <div class="">
                    <?php if ($percent > 0 && $enable_progress_bar == 1) { ?>
                    <div class="progress">
                        <div class="progress-bar bg-success progress-bar-striped fw-bold progress-bar-animated"
                            role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0"
                            aria-valuemax="100">
                            <span style="margin-left: 12px;">
                                <? isset($percent) ? $percent : 0; ?>
                                %
                            </span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($status == "1") : ?>
    <div
        class="campanha-preco porApenas font-xs d-flex align-items-center justify-content-center mt-2 mb-2 font-weight-500">
        <div class="item d-flex align-items-center font-xs me-2">
            <?php if (!empty($date_of_draw)) : ?>
            <span class="ms-2 me-1">Campanha</span>
            <div class="tag btn btn-sm bg-white bg-opacity-50 font-xss box-shadow-08">
                <?php
                $dataFormatada = date('d/m/y', strtotime($date_of_draw));
                $horaFormatada = date('H\\hi', strtotime($date_of_draw));
                $date_of_draw = $dataFormatada . ' às ' . $horaFormatada;
                echo $date_of_draw;
                ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="item d-flex align-items-center font-xs">
            <div class="me-1">por apenas</div>
            <div class="tag btn btn-sm bg-cor-primaria text-cor-primaria-link box-shadow-08">R$
                <?php echo isset($price) ? format_num($price, 2) : ''; ?></div>
        </div>
    </div>
    <?php endif; ?>



    <?php if ($status_display < '3' && intval($percent) < 100 && $status == '1') { ?>
    <div class="sc-3f9a15f1-13 byugCZ mb-2">

        <div class="sc-3f9a15f1-28 kfFTzL line">⚡


        </div>

        <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;"
            class="sc-3f9a15f1-14 jQlWTy">Cotas </h5>
        <div class="app-title-desc">Escolha sua sorte</div>

    </div>
    <?php } ?>


    <?php if ($status == "1") : ?>
    <div class="campanha-seletor mb-2 mt-1">
        <div class="d-flex justify-content-between font-weight-600">
            <div onclick="loadnumbers(1)"
                class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs">
                <div class="nome bg-white rounded-start text-dark p-2">Livres</div>
                <div class="num bg-cota text-white p-2 rounded-end"><?php echo $available; ?></div>
            </div>
            <div onclick="loadnumbers(2)"
                class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs">
                <div class="nome bg-white rounded-start text-dark p-2">Reservados</div>
                <div class="num bg-info text-white p-2 rounded-end"><?php echo $pending_numbers; ?></div>
            </div>
            <div onclick="loadnumbers(3)"
                class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs">
                <div class="nome bg-white rounded-start text-dark p-2">Pagos</div>
                <div class="num bg-success text-white p-2 rounded-end"><?php echo $paid_numbers; ?></div>
            </div>
        </div>
    </div>


    <?php endif; ?>

    <?php if ((int) $percent < 100 && $status == "1") : ?>
    <div class="loading-message"></div>
    <div class="numeros-list row row-cols-6 row-gutter-sm mb-4"></div>
    <?php endif; ?>

    <?php
    $discount_qty = isset($discount_qty) ? $discount_qty : '';
    $discount_amount = isset($discount_amount) ? $discount_amount : '';
    if ($available > 0 && $discount_qty && $discount_amount && $enable_discount == 1) {
        $discount_qty = json_decode($discount_qty, true);
        $discount_amount = json_decode($discount_amount, true);
        $discounts = [];

        foreach ($discount_qty as $qty_index => $qty) {
            foreach ($discount_amount as $amount_index => $amount) {
                if ($qty_index === $amount_index) {
                    $discounts[$qty_index] = ['qty' => $qty, 'amount' => $amount];
                }
            }
        }

        if (isset($discounts)) {
            $max_discount = count($discounts);
        } else {
            $max_discount = 0;
        }

        if ($available > 0 && $status == '1') {
    ?>
    <div class="app-promocao-numeros mb-4 mt-2">
        <div class="sc-3f9a15f1-13 byugCZ mt-2">

            <div class="sc-3f9a15f1-28 kfFTzL line">📣


            </div>

            <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;"
                class="sc-3f9a15f1-14 jQlWTy">Promoção</h5>

        </div>

        <div class=" sc-3f9a15f1-7 iVtoESs">
            <div class="app-card card">

                <div class="card-body ">

                    <div class="row px-2">
                        <?php
                                $count = 0;
                                foreach ($discounts as $discount) {
                                ?>
                        <div class="col-auto px-1 ">
                            <?php if ($user_id) { ?>
                            <button onclick="qtyRaffle('<?php echo $discount['qty']; ?>', true);"
                                class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                <?php } else { ?>
                                <span id="add_to_cart"></span>
                                <button data-bs-toggle="modal" data-bs-target="#loginModal"
                                    onclick="qtyRaffle('<?php echo $discount['qty']; ?>', true);"
                                    class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                    <?php } ?>
                                    <span class="font-weight-500">
                                        <b class="font-weight-600">
                                            <span id="discount_qty_<?php echo $count; ?>"><?php echo $discount['qty']; ?></span>
                                        </b>
                                        <small>por R$</small>
                                        <span class="font-weight-600">
                                            <span id="discount_amount_<?php echo $count; ?>"
                                                style="display:none"><?php echo $discount['amount']; ?></span>
                                            <?php
                                            $discount_price = $price * $discount['qty'] - $discount['amount'];
                                            echo number_format($discount_price, 2, ',', '.');
                                            ?>
                                        </span>
                                    </span>
                                </button>
                        </div>
                        <?php ++$count;
                                } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }
    } ?>
    <?php
    $check_ranking = $conn->query("SELECT id FROM order_list WHERE product_id = $id AND status = 2");
    $check_ranking = $check_ranking->num_rows;
    if ($check_ranking == 0) {
        $enable_ranking = 0;
    }


    ?>

    <?php if (0 < $enable_ranking) : ?>



        <div class="sc-3f9a15f1-13 byugCZ">

            <div class="sc-3f9a15f1-28 kfFTzL line">🏆</div>

            <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Ranking</h5>

        </div>



        <div class=" sc-3f9a15f1-7 " style=" padding-block:8px">
            <div class="grid  gap-2">
                <?php
                $today = date('Y-m-d');
                if ($ranking_type == 1) {
                    $requests = $conn->query("
                SELECT c.firstname, c.lastname, SUM(o.quantity) AS total_quantity
                FROM order_list o
                INNER JOIN customer_list c ON o.customer_id = c.id
                WHERE o.product_id = $id AND o.status = 2
                GROUP BY o.customer_id
                ORDER BY total_quantity DESC
                LIMIT $ranking_qty
              ");
                } else {
                    $requests = $conn->query("
                SELECT c.firstname, c.lastname, SUM(o.quantity) AS total_quantity
                FROM order_list o
                INNER JOIN customer_list c ON o.customer_id = c.id
                WHERE o.product_id = $id AND o.status = 2
                AND o.date_created BETWEEN '$today 00:00:00' AND '$today 23:59:59'
                GROUP BY o.customer_id
                ORDER BY total_quantity DESC
                LIMIT $ranking_qty
              ");
                }
                $count = 0;

                while ($row = $requests->fetch_assoc()) {
                    ++$count;
                    if ($count == 1) {
                        $medal = '🥇';
                        $prize = $ranking_1;
                    } elseif ($count == 2) {
                        $medal = '🥈';
                        $prize = $ranking_2;
                    } elseif ($count == 3) {
                        $medal = '🥉';
                        $prize = $ranking_3;
                    } elseif ($count == 4) {
                        $medal = '🏅';
                        $prize = $ranking_4;
                    }elseif ($count == 5) {
                        $medal = '🏅';
                        $prize = $ranking_5;
                    };
                ?>

                    <div class="cards" style="pointer-events:<?php if($enable_ranking_show == 1){echo 'auto';}else{echo 'none';} ;?>">
                        <div class="outlinePage<?= $count ?> p-2">
                        <span class="icon trophy"><?=$medal?></span>

                            <p class="ranking_number<?= $count ?> "><?= $count ?>° <span class="ranking_word"><?php echo $row['firstname'] .' '. $row['lastname']; ?></span></p>
                            <div class="splitLine<?= $count ?>"></div>
                        <span class="userAvatar">
                        🏆
                        </span>
                            <p class="userName">
                                <?=$prize ?>
                            </p>
                        </div>
                        <?php if ($enable_ranking_show == 1){
                            ?>
                        <div class="detailPage">
                           <span class="icon medals slide-in-top"><?=$medal?></span>
                            <div class="gradesBox">
                                <svg class="icon gradesIcon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="60" height="60">

                                </svg>
                                <p class="gradesBoxLabel">Cotas </p>
                                <p class="gradesBoxNum">
                                    <?php echo $row['total_quantity']; ?> Cotas <?php if($ranking_type == 1){ echo ' na campanha';}else{ echo ' hoje';} ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>


                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if ($description) {
    ?>
        <div class="sc-3f9a15f1-2 eAApiE bottom-container mb-4">
            <div class="sc-3f9a15f1-13 byugCZ">
                <div class="sc-3f9a15f1-28 kfFTzL line"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg></div>
                <h5 style="font-size: 1.3em !important;" class="  sc-3f9a15f1-14 jQlWTy">Descrição</h5>
            </div>
            <div class="sc-3f9a15f1-7 iVtoES">
                <div class="sc-3f9a15f1-8 kOqdiR">
                    <div class="sc-8e721470-0 jJuTYb">
                        <div id="descripition" class="sc-8e721470-1 gaogiP overflow">
                            <h4 style="font-size: 1em !important;"><strong>Informações:</strong></h4>
                            <?php echo blockHTML($description); ?>
                        </div>
                        <div class="sc-8e721470-2 fngIaM"><svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor">
                                <path fill-rule="evenodd" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17.2 9.5l-1.3-2.2q-0.2-0.3-0.5-0.6-0.3-0.2-0.7-0.3-0.4-0.1-0.8-0.1-0.3 0.1-0.7 0.3-0.3 0.2-0.6 0.5-0.2 0.3-0.3 0.7-0.1 0.4-0.1 0.8 0.1 0.4 0.3 0.7l0.7 1.2">
                                </path>
                                <path fill-rule="evenodd" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 10.2l-1-1.8c-0.3-0.4-0.7-0.8-1.2-0.9-0.6-0.1-1.1-0.1-1.6 0.2-0.4 0.3-0.8 0.7-0.9 1.2-0.1 0.5-0.1 1.1 0.2 1.5l1 1.8">
                                </path>
                                <path fill-rule="evenodd" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9.3 11.7l-2.8-4.7c-0.3-0.5-0.7-0.8-1.2-1-0.5-0.1-1.1 0-1.5 0.2-0.5 0.3-0.8 0.7-1 1.3-0.1 0.5 0 1 0.2 1.5l4.5 7.8">
                                </path>
                                <path fill-rule="evenodd" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.9 17.1l-2.4-0.6c-0.5-0.1-1 0-1.5 0.2-0.4 0.3-0.7 0.7-0.8 1.2-0.2 0.5-0.1 1.1 0.1 1.5 0.3 0.5 0.7 0.8 1.2 1l4.9 1.3c2 0.5 3.9 0.4 6.3-1l1.8-1q1.4-0.8 2.3-2.1 1-1.2 1.4-2.8 0.4-1.5 0.2-3.1-0.2-1.5-1-2.9l-1.5-2.6c-0.3-0.5-0.7-0.8-1.2-1-0.5-0.1-1.1 0-1.5 0.2-0.5 0.3-0.8 0.7-1 1.3-0.1 0.5 0 1 0.2 1.5l0.5 0.8">
                                </path>
                            </svg><span>Deslize para baixo</span></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    if (!empty($draw_number)) {
        $winners_qty = 5;
        $draw_number = isset($draw_number) ? $draw_number : '';
        if ($winners_qty && $draw_number) {
            $draw_winner = json_decode($draw_winner, true);
            $draw_number = json_decode($draw_number, true);
            $winners = [];

            foreach ($draw_winner as $qty_index => $name) {
                foreach ($draw_number as $amount_index => $number) {
                    $query = $conn->query('SELECT CONCAT(firstname, \' \', lastname) as name, avatar FROM customer_list WHERE phone = \'' . $name . '\'');
                    $rowCustomer = $query->fetch_assoc();

                    if ($qty_index === $amount_index) {
                        $winners[$qty_index] = [
                            'name' => $rowCustomer['name'],
                            'number' => $number,
                            'image' => $rowCustomer['avatar'] ? validate_image($rowCustomer['avatar']) : BASE_URL . 'assets/img/avatar.png',
                        ];
                    }
                }
            }
        }

        $count = 0;

        foreach ($winners as $winner) {
            ++$count;
    ?>
    <div class="sc-3f9a15f1-2 eAApiE bottom-container mb-2 ">
        <div class="sc-3f9a15f1-13 byugCZ">
            <div class="sc-3f9a15f1-28 kfFTzL line">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-award">
                    <path
                        d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                    </path>
                    <circle cx="12" cy="8" r="6"></circle>
                </svg>
            </div>
            <h5 style="font-size: 1.3em !important;" class="  sc-3f9a15f1-14 jQlWTy">Ganhadores</h5>
        </div>
        <div class="sc-3f9a15f1-7 iVtoES">
            <div class="sc-3f9a15f1-8 ">
                <div class="ganhadorItem_ganhadorContainer__1Sbxm ">
                    <div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">

                        <div
                            style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                            <img alt="<?php echo $winner['name']; ?>" src="<?php echo $winner['image']; ?>" decoding="async"
                                data-nimg="fill"
                                style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                            <noscript></noscript>
                        </div>

                    </div>
                    <div class="undefined w-100">
                        <h5 class="mb-0" style="text-transform: uppercase;"><?php echo $count; ?>º -
                            <?php echo $winner['name']; ?>&nbsp;<i class="bi bi-check-circle text-white-50"></i></h5>
                        <div class="text-white-50"><small>Ganhador(a) com a cota
                                <?php echo $winner['number']; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    }

    ?>


<?php if ($user_id && $status == '1' ){
        ?>
 <div class="btn btn-sm btn-success" style="margin-inline: auto;display: flex;width: fit-content;margin-block: 19px;" data-bs-toggle="modal" data-bs-target="#modal-afiliado">
      Compartilhe e ganhe como um afiliado
</div>

<?php } ?>
         
<div class="modal fade" id="modal-afiliado" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">
            Seja um afiliado
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body font-xs">
        <p>
        Ao se tornar um afiliado você ganha comissões por cada venda realizada através do seu link de afiliado.</p>
        <p>
            Ao prosseguir você concorda com os termos de uso do programa de afiliados.
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#modal-afiliado-link" data-bs-toggle="modal">Gerar link</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-afiliado-link" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">
            Compartilhe seu link de afiliado
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-2">
          <input id="affiliate_url" type="text" class="form-control text-black" value="<?= BASE_URL ?>campanhas/<?=$slug?>?&ref=<?= $_settings->userdata('id') ?>">
          <div class="input-group-append">
            <button onclick="copyPix()" class="app-btn btn btn-success rounded-0 rounded-end">Copiar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="modal-consultaCompras">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="consultMyNumbers">
                    <div class="modal-header">
                        <h6 class="modal-title">Consulta de compras</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?php if ($enable_cpf != 1) : ?>
                            <label class="form-label">Informe seu telefone</label>
                            <div class="input-group mb-2">
                                <input onkeyup="formatarTEL(this);" maxlength="15" class="form-control"
                                    aria-label="Número de telefone" maxlength="15" id="phone" name="phone"
                                    required="" value="">
                                <button class="btn btn-secondary" type="submit" id="button-addon2">
                                    <div class=""><i class="bi bi-check-circle"></i></div>
                                </button>
                            </div>
                            <?php else : ?>
                            <label class="form-label">Informe seu CPF</label>
                            <div class="input-group mb-2">
                                <input name="cpf" class="form-control" id="cpf" value=""
                                    maxlength="14" minlength="14" placeholder="000.000.000-00"
                                    oninput="formatarCPF(this.value)" required>
                                <button class="btn btn-secondary" type="submit" id="button-addon2">
                                    <div class=""><i class="bi bi-check-circle"></i></div>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </form>
</div>

<!-- Modal checkout -->
<div class="modal fade" id="modal-checkout">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
        <div class="modal-content rounded-0">
            <span class="d-none">Usuário não autenticado</span>
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body checkout">
                <div class="alert alert-info p-2 mb-2 font-xs"><i class="bi bi-check-circle"></i> Você está
                    adquirindo<span class="font-weight-500">&nbsp;<span id="qty_cotas"></span>
                        cotas</span><span>&nbsp;da ação entre amigos</span><span
                        class="font-weight-500">&nbsp;<?php echo isset($name) ? $name : ''; ?></span>,<span>&nbsp;seus
                        números serão gerados</span><span>&nbsp;assim que concluir a compra.</span></div>
                <div class="mb-3">
                    <div class="card app-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-pill p-1 bg-white box-shadow-08"
                                        style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                                        <div
                                            style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                            <img src="<?php echo validate_image($_settings->userdata('avatar')); ?>" decoding="async" data-nimg="fill"
                                                style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                            <noscript></noscript>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="mb-1"><?php echo $_settings->userdata('firstname'); ?>
                                        <?php echo $_settings->userdata('lastname'); ?></h5>
                                    <div class="text-muted">
                                        <small><?php echo formatPhoneNumber($_settings->userdata('phone')); ?></small>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="bi bi-chevron-compact-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="place_order" data-id="<?=$ref?>" class="btn btn-success w-100 mb-2">Concluir
                    reserva <i class="bi bi-arrow-right-circle"></i></button>
                <button type="button" class="btn btn-link btn-sm text-secondary text-decoration-none w-100 my-2"><a
                        href="<?php echo BASE_URL . 'logout?' . $_SERVER['REQUEST_URI']; ?>">Utilizar outra
                        conta</a></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal checkout -->
<!-- Modal Aviso -->
<button id="aviso_sorteio" data-bs-toggle="modal" data-bs-target="#modal-aviso" class="btn btn-success w-100 py-2"
    style="display:none"></button>
<div class="modal fade" id="modal-aviso">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body checkout">
                <div class="alert alert-danger p-2 mb-2 font-xs aviso-content">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Aviso -->
<div class="modal fade" id="modal-indique">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Indique e ganhe!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">Faça login para ter seu link de indicao, e ganhe at 0,00% de créditos
                nas compras aprovadas!</div>
        </div>
    </div>
</div>

<div class="sorteio-numeros-selecionados   ">
    <div class="row row-gutter-sm align-items-center sorteio_sorteioCheckoutInfo__uriIE">
        <div class="col-12">
            <div class="row row-gutter-sm row-cols-4 cotas-checkout" style="min-height: 40px;">

            </div>
        </div>
        <div class="col-12">
            <input type="hidden" class="qty" value="0">
            <span class="addNumero"></span>
            <span class="removeNumero"></span>
            <?php if ($user_id) { ?>
            <button id="add_to_cart" data-bs-toggle="modal" data-bs-target="#modal-checkout"
                class="btn btn-success w-100 py-2">
                <?php } else {  ?>
                <button data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-success w-100 py-2">
                    <?php } ?>
                    <div class="row align-items-center" style="line-height: 85%;">
                        <div class="col pe-0 text-nowrap"><i class="bi bi-check2-circle me-1"></i><span>Participar do
                                sorteio</span></div>
                        <div class="col-auto ps-0">
                            <div class="pe-3">
                                <div id="total"></div>
                            </div>
                        </div>
                    </div>
                </button>

        </div>
    </div>
</div>
<?php if ($enable_groups == 1) : ?>
<div class="sorteio_sorteioShare__247_t">
    <div class="campanha-share d-flex mb-1 justify-content-between align-items-center">
        <?php if ($enable_share == 1) : ?>
        <div class="item d-flex align-items-center">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>"
                target="_blank">
                <div alt="Compartilhe no Facebook" class="sorteio_sorteioShareLinkFacebook__2McKU"
                    style="margin-right:5px;">
                    <i class="bi bi-facebook"></i>
                </div>
            </a>
            <a href="https://t.me/share/url?url=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>text=<?php echo $name; ?>"
                target="_blank">
                <div alt="Compartilhe no Telegram" class="sorteio_sorteioShareLinkTelegram__3a2_s"
                    style="margin-right:5px;">
                    <i class="bi bi-telegram"></i>
                </div>
            </a>
            <a href="https://www.twitter.com/share?url=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>"
                target="_blank">
                <div alt="Compartilhe no Twitter" class="sorteio_sorteioShareLinkTwitter__1E4XC"
                    style="margin-right:5px;">
                    <i class="bi bi-twitter"></i>
                </div>
            </a>
            <a href="https://api.whatsapp.com/send/?text=<?php echo $name; ?>%21%21%3A+<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>&type=custom_url&app_absent=0"
                target="_blank">
                <div alt="Compartilhe no WhatsApp" class="sorteio_sorteioShareLinkWhatsApp__2Vqhy"><i
                        class="bi bi-whatsapp"></i></div>
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php if ($whatsapp_group_url) : ?>
    <a href="<?php echo $whatsapp_group_url; ?>" target="_blank">
        <div class="whatsapp-grupo">
            <div class="btn btn-sm btn-success mb-1 w-100"><i class="bi bi-whatsapp"></i> Grupo</div>
        </div>
    </a>
    <?php endif; ?>
    <?php if ($telegram_group_url) : ?>
    <a href="<?php echo $telegram_group_url; ?>" target="_blank">
        <div class="telegram-grupo">
            <div class="btn btn-sm btn-info btn-block text-white mb-1 w-100"><i class="bi bi-telegram"></i> Telegram
            </div>
        </div>
    </a>
    <?php endif; ?>
    <?php endif; ?>

    <script>
          function copyPix() {
        var copyText = document.getElementById("affiliate_url");

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        document.execCommand("copy");
        navigator.clipboard.writeText(copyText.value);

        alert("Link copiado com sucesso");
    }
        $(function() {
            $('#add_to_cart').click(function() {
                add_cart();
            })
            $('#place_order').click(function() {
                var ref = $(this).attr('data-id');
                place_order(ref);
            })

            $(".addNumero").click(function() {
                let value = parseInt($(".qty").val());
                value++;
                $(".qty").val(value);

                calculatePrice(value);

            })

            $(".removeNumero").click(function() {
                let value = parseInt($(".qty").val());
                if (value <= 1) {
                    value = 0;
                } else {
                    value--;
                }
                $(".qty").val(value);
                calculatePrice(value);
            })

            $('.cotas-checkout').on('click', '.cota', function() {
                var valor = $(this).find('.numero-template').text();
                var sessao = sessionStorage.getItem('valores');
                var valores = sessao ? JSON.parse(sessao) : [];
                var index = valores.indexOf(valor.toString());

                if (index !== -1) {
                    valores.splice(index, 1);
                    $('.cota').filter(function() {
                        return $(this).find('.numero-template').text() === valor;
                    }).find('.numero-template').addClass('bg-cota').removeClass(
                        'numero-template-selected');
                }
                $(".removeNumero").click();
                $(this).remove();
                sessionStorage.setItem('valores', JSON.stringify(valores.map(String)));

                $('.cota').filter(function() {
                    return $(this).find('.numero-template').data('cota') === valor;
                }).find('.numero-template').addClass('bg-cota').removeClass('numero-template-selected');
            });

            $('.numeros-list').on('click', '.cota', function() {

                var pendingNumbers = $(this).find('.bg-info');
                var paidNumbers = $(this).find('.bg-success');
                if (pendingNumbers.length == 0 && paidNumbers.length == 0) {
                    var divNumero = $(this).find('.numero-template');
                    var valor = divNumero.text();
                    var cota = divNumero.data('cota');
                    var sessao = sessionStorage.getItem('valores');
                    var valores = sessao ? JSON.parse(sessao) : [];
                    var index = valores.indexOf(cota.toString());

                    if (index === -1) {
                        valores.push(cota);
                        divNumero.addClass('numero-template-selected').removeClass('bg-cota');
                        var clonedDiv = $(this).clone();
                        clonedDiv.find('.numero-template').text(cota);
                        clonedDiv.appendTo('.cotas-checkout');
                        $(".addNumero").click();
                        if (!$('.sorteio-numeros-selecionados').hasClass(
                                'sorteio-numeros-selecionados-open')) {
                            $('.sorteio-numeros-selecionados').addClass(
                                'sorteio-numeros-selecionados-open');
                        }
                    } else {
                        valores.splice(index, 1);
                        divNumero.addClass('bg-cota').removeClass('numero-template-selected');
                        $('.cotas-checkout').find('.numero-template:contains(' + cota + ')').parent()
                            .remove();
                        $(".removeNumero").click();

                        $('.cota').filter(function() {
                            return $(this).find('.numero-template').text() === cota;
                        }).find('.numero-template').addClass('bg-cota').removeClass(
                            'numero-template-selected');
                    }

                    sessionStorage.setItem('valores', JSON.stringify(valores.map(String)));
                }
            });
        })

        function place_order($ref) {
            $('#overlay').fadeIn(300);
            var sessao = sessionStorage.getItem('valores');
            var valores = sessao ? JSON.parse(sessao) : [];

            $.ajax({
                url: _base_url_ + 'class/Main.php?action=place_order_process',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: {
                    ref: $ref,
                    product_id: <?php echo $id; ?>,
                    numbers: valores
                },
                dataType: 'json',
                error: err => {
                    console.log(err)
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.replace(resp.redirect)
                    } else if (resp.status == 'pay2m') {
                        alert(resp.error);
                        location.replace(resp.redirect)
                    } else {
                        alert(resp.error);
                        location.reload();
                    }
                }

            })
        }

        function formatCurrency(total) {
            var decimalSeparator = ',';
            var thousandsSeparator = '.';

            var formattedTotal = total.toFixed(2); // Define 2 casas decimais

            // Substitui o ponto pelo separador decimal desejado
            formattedTotal = formattedTotal.replace('.', decimalSeparator);

            // Formata o separador de milhar
            var parts = formattedTotal.split(decimalSeparator);
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);

            // Retorna o valor formatado
            return parts.join(decimalSeparator);
        }



        function calculatePrice(qty) {
            let price = '0.01';
            let enable_sale = parseInt('0');
            let sale_qty = parseInt('0');
            let sale_price = '0.00';

            let available = parseInt('23');
            let total = price * qty;
            var max = parseInt('10000');
            var min = parseInt('1');

            if (qty > available) {
                $('.aviso-content').html('Restam apenas ' + available + ' cotas disponíveis no momento.');
                $('#aviso_sorteio').click();
                $(".qty").val(available);
                calculatePrice(available);
                return;
            }

            if (qty < min) {
                $(".qty").val(0);
                $('.sorteio-numeros-selecionados').removeClass('sorteio-numeros-selecionados-open');
                return;
            }

            if (qty > max) {
                //alert('A quantidade máxima de cotas é de: ' + max + '');
                $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
                //$('#aviso_sorteio').click();
                $(".qty").val(max);
                total = price * max;
                calculatePrice(max);
                //$('#total').html('R$ '+formatCurrency(total)+'');
                return;
            }
            // Desconto acumulativo
            var qtd_desconto = parseInt('0');

            let dropeDescontos = [];
            for (i = 0; i < qtd_desconto; i++) {
                dropeDescontos[i] = {
                    qtd: parseInt($(`#discount_qty_${i}`).text()),
                    vlr: parseFloat($(`#discount_amount_${i}`).text())
                };
            }
            //console.log(dropeDescontos);

            var drope_desconto_qty = null;
            var drope_desconto = null;

            for (i = 0; i < dropeDescontos.length; i++) {
                if (qty >= dropeDescontos[i].qtd) {
                    drope_desconto_qty = dropeDescontos[i].qtd;
                    drope_desconto = dropeDescontos[i].vlr;
                }
            }

            var drope_desconto_aplicado = total;
            var desconto_acumulativo = false;
            var quantidade_de_numeros = drope_desconto_qty;
            var valor_do_desconto = drope_desconto;


            if (desconto_acumulativo && qty >= quantidade_de_numeros) {
                var multiplicador_do_desconto = Math.floor(qty / quantidade_de_numeros);
                drope_desconto_aplicado = total - (valor_do_desconto * multiplicador_do_desconto);
            }

            // Aplicar desconto normal quando desconto acumulativo estiver desativado
            if (!desconto_acumulativo && qty >= drope_desconto_qty) {
                drope_desconto_aplicado = total - valor_do_desconto;
            }

            if (parseInt(qty) >= parseInt(drope_desconto_qty)) {
                $('#total').html('De <strike>R$ ' + formatCurrency(total) + '</strike> por R$ ' + formatCurrency(
                    drope_desconto_aplicado));
            } else {
                if (enable_sale == 1 && qty >= sale_qty) {
                    total_sale = qty * sale_price;

                    $('#total').html('De <strike>R$ ' + formatCurrency(total) + '</strike> por R$ ' + formatCurrency(
                        total_sale));
                } else {
                    $('#total').html('R$ ' + formatCurrency(total));
                }

            }
            //Fim desconto acumulativo

        }

        function qtyRaffle(qty, opt) {
            qty = parseInt(qty);
            let value = parseInt($(".qty").val());
            let qtyTotal = (value + qty);
            if (opt === true) {
                qtyTotal = (qtyTotal - value);
            }

            $(".qty").val(qtyTotal);
            calculatePrice(qtyTotal);

        }

        function add_cart() {
            let qty = $('.qty').val();
            $('#qty_cotas').text(qty);
            $.ajax({
                url: _base_url_ + "class/Main.php?action=add_to_card",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    product_id: <?php echo $id; ?>,
                    qty: qty
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert("[PP07] - An error occured.", 'error');
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        //location.reload();
                    } else if (!!resp.msg) {
                        alert(resp.msg, 'error');
                    } else {
                        alert("[PP08] - An error occured.", 'error');
                    }
                }
            })
        }

        $(document).ready(function() {

            sessionStorage.removeItem('valores');
            //$('.cota').on('click', function() {


        });



        $('.cota .numero-template').each(function() {
            var cota = $(this).text();
            $(this).data('cota', cota);
        });





        //Lista numeros
        var loadingNumbers = false;


        function loadnumbers(status) {
            if (loadingNumbers) {
                return;
            }

            loadingNumbers = true;
            var classe = (status == 1) ? 'bg-cota' : (status == 2) ? 'tooltp bg-info' : (status == 3) ?
                'tooltp bg-success' :
                '';
            var numerosList = $('.numeros-list');
            var mgsList = $('.loading-message');
            numerosList.empty();
            var loadingMessage = $('<p class="loading">').html(
                '<span class="d-inline-block spin-animation me-2"><i class="bi bi-arrow-repeat"></i></span> Carregando números...'
            ).appendTo(mgsList);

            $.ajax({
                url: _base_url_ + "class/Main.php?action=load_numbers",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    status: status,
                    id: <?php echo $id; ?>
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        var numeros = response.numeros || [];
                        var numerosNomes = {};
                        var vendidos = response.vendidos || [];
                        console.log(vendidos);


                        for (var i = 0; i < numeros.length; i++) {
                            var numero = numeros[i];
                            numerosNomes[numero] = '';
                        }
                        numeros.sort(function(a, b) {
                            return a - b;
                        });

                        for (var i = 0; i < numeros.length; i++) {
                            var numero = numeros[i];
                            var divCota = $('<div>').addClass('col cota');
                            var divNumero = $('<div>').addClass('numero-template ' + classe).attr('data-cota',
                                numero).text(numero);

                            divNumero.appendTo(divCota);
                            divCota.appendTo(numerosList);
                        }
                    } else {
                        alert('Ocorreu um erro ao consultar os números por status.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Ocorreu um erro na requisição Ajax: ' + error);
                },
                complete: function() {
                    loadingMessage.remove();
                    loadingNumbers = false;
                }
            });
            //Fim lista números
        }

        $(document).ready(function() {
            loadnumbers(1)

            $('#consultMyNumbers').submit(function(e) {
                e.preventDefault()
                var tipo = "search_orders_by_phone";
                $.ajax({
                    url: _base_url_ + "class/Main.php?action=" + tipo,
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
                        console.log(err)
                        alert('An error occurred')

                    },
                    success: function(resp) {
                        if (resp.status == 'success') {
                            location.href = (resp.redirect)
                        } else {
                            alert('Nenhum registro de compra foi encontrado')
                            console.log(resp)
                        }
                    }
                })
            })
        })
        
    </script>
</div>
