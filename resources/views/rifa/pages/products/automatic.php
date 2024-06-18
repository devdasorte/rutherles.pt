<?php
use League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
$ref = isset($_GET['ref']) ? $_GET['ref'] : '';
$string = isset($cotas_premiadas) ? $cotas_premiadas : '';
$numbers = explode(',', $string);
$cotas_reservadas = count($numbers);

if (substr($string, -1) == ',') {
    $cotas_reservadas--;
}
$min_cotas_purchased = 0;
if (isset($valor_base_auto) && is_numeric($valor_base_auto) && is_numeric($qty_numbers)) {
    $min_cotas_purchased = (intval($valor_base_auto) / 100) * intval($qty_numbers);
}
$paid_and_pending = $pending_numbers + $paid_numbers;
$total_reservadas = $paid_numbers;
if ($total_reservadas >= $min_cotas_purchased) {
    $min_cotas_purchased = 0;
    $cotas_reservadas = 0;
}
if ($status_auto_cota == 0) {
    $min_cotas_purchased = 0;
    $cotas_reservadas = 0;
}
$available = (int) $qty_numbers - $paid_and_pending - $cotas_reservadas;
$percent = (($paid_and_pending + $cotas_reservadas) * 100) / $qty_numbers;
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');
$support_number = $_settings->info('phone');
$user_id = $_settings->userdata('id');
$max_discount = 0;
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
<style>

    
    .skeleton {
        background-color: #343a40;
        border-radius: 0.2rem;
        font-weight: 600;
        animation: blink 1s infinite;
        cursor: pointer;
        width: 98%;
        height: 12px;
        margin: 6px ;


    }

    #overlay,
    .carousel-item {
        width: 100%;
        display: none
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
        background: rgba(0, 0, 0, .8);
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

    @media only screen and (max-width:600px) {
        .custom-image {
            height: 350px !important
        }
    }

    @media only screen and (min-width:768px) {
        .custom-image {
            height: 450px !important
        }
    }
</style>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<div id="overlay">
    <div class="cv-spinner">
        <div class="card" style="border:none; padding:10px;background: transparent;color: #fff !important;font-weight: 800;">
            <span class="spinner mb-2" style="align-self:center;"></span>
            <div class="text-center font-xs">
                Estamos gerando seu pedido, aguarde...
            </div>
        </div>
    </div>
</div>
<div class="container app-main">
    <div class="campanha-header SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">
        <div style="bottom:40px !important; top: auto !important; right:16px !important; position: absolute !important;left:auto!important" class="custom-badge-display">
            <?php if ($status_display == 1) { ?>
                <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
            <?php } ?>

            <?php if ($status_display == 2) { ?>
                <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
            <?php } ?>

            <?php if ($status_display == 3) { ?>
                <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
            <?php } ?>

            <?php if ($status_display == 4) { ?>
                <span class="badge bg-dark font-xsss">Concluído</span>
            <?php } ?>

            <?php if ($status_display == 5) { ?>
                <span class="badge bg-dark font-xsss">Em breve!</span>
            <?php } ?>

            <?php if ($status_display == 6) { ?>
                <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
            <?php } ?>
        </div>
       
        <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
            <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $image_gallery = isset($image_gallery) ? $image_gallery : '';
                    if ($image_gallery != '[]' && !empty($image_gallery)) {
                        $image_gallery = json_decode($image_gallery, true);
                        array_unshift($image_gallery, $image_path);
                        $slide = 0;
                        foreach ($image_gallery as $image) {
                            ++$slide;
                    ?>
                            <div class="custom-image carousel-item <?php echo $slide == 1 ? 'active' : ''; ?>">
                                <img alt="<?php echo isset($name) ? $name : ''; ?>" src="<?php echo BASE_URL . $image; ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI">
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="custom-image carousel-item active" style="">
                            <img alt="<?php echo isset($name) ? $name : ''; ?>" src="<?php echo validate_image($image_path); ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            if ($image_gallery != '[]' && !empty($image_gallery)) {
            ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            <?php } ?>
        </div>
        <div class="SorteioTpl_info__t1BZr custom-content-wrapper <?php echo $status_display != '4' && $status_display != '5' ? 'custom-content-wrapper-details' : ''; ?>">
            <h1 class="SorteioTpl_title__3RLtu_xl"><?php echo isset($name) ? $name : ''; ?></h1>
            <div class="iZCVCw">
                <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">
                    <?php echo isset($subtitle) ? $subtitle : ''; ?></p>
            </div>
            <?php if ($status_display != '4' && $status_display != '5') { ?>
                <div class="btn btn-sm btn-success box-shadow-08 w-100" data-bs-toggle="modal" data-bs-target="#modal-consultaCompras">
                    <i class="bi bi-cart"></i> Ver meus números
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="campanha-buscas mt-2">
        <div class="row row-gutter-sm">
            <div class="col">
                <div>
                    <?php if (0 < $percent && $enable_progress_bar == 1) { ?>
                        <div class="progress">
                            <div class="progress-bar bg-info progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                            <div class="progress-bar bg-success progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="<?php echo number_format($percent, 1, '.', ''); ?>" aria-valuemin="0" aria-valuemax="<?php echo $qty_numbers; ?>" style="width: <?php echo number_format($percent, 1, '.', ''); ?>%;">
                                <?php echo number_format($percent, 1, '.', ''); ?>%
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>

    <?php if ($status == '1') { ?>
        <div class="campanha-preco porApenas font-xs d-flex align-items-center justify-content-center mt-2 mb-2 font-weight-500">
            <div class="item d-flex align-items-center font-xs me-2">
                <?php if (!empty($date_of_draw)) { ?>
                    <span class="ms-2 me-1">Campanha</span>
                    <div class="tag btn btn-sm bg-white bg-opacity-50 font-xss box-shadow-08">
                        <?php
                        $dataFormatada = date('d/m/y', strtotime($date_of_draw));
                        $horaFormatada = date('H\\hi', strtotime($date_of_draw));
                        $date_of_draw = $dataFormatada . ' às ' . $horaFormatada;
                        echo $date_of_draw;
                        ?>
                    </div>
                <?php } ?>
            </div>
            <div class="item d-flex align-items-center font-xs">
                <div class="me-1">por apenas</div>
                <div class="tag btn btn-sm bg-cor-primaria text-cor-primaria-link box-shadow-08">R$
                    <?php echo isset($price) ? format_num($price, 2) : ''; ?>
                </div>
            </div>
        </div>
    <?php } ?>
   
    

    <?php if ($available > 0 && $status == '1') { ?>
        <div class="app-card card mb-4">
            <div class="card-body text-center">
                <p class="font-xs">Quanto mais comprar, maiores são as suas chances de ganhar!</p>
            </div>
        </div>
    <?php } ?>

 

    <?php if ($status_display == '6') { ?>
        <div class="alert alert-warning font-xss mb-2 mt-2">Todos os números já foram reservados ou pagos</div>
    <?php } ?>

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
            <div class="app-promocao-numeros mb-4">
                <div class="sc-3f9a15f1-13 byugCZ">

                    <div class="sc-3f9a15f1-28 kfFTzL line">📣


                    </div>

                    <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Promoção</h5>

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
                                            <button onclick="qtyRaffle('<?php echo $discount['qty']; ?>', true);" class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                            <?php } else { ?>
                                                <span id="add_to_cart"></span>
                                                <button data-bs-toggle="modal" data-bs-target="#loginModal" onclick="qtyRaffle('<?php echo $discount['qty']; ?>', true);" class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                                <?php } ?>
                                                <span class="font-weight-500">
                                                    <b class="font-weight-600">
                                                        <span id="discount_qty_<?php echo $count; ?>"><?php echo $discount['qty']; ?></span>
                                                    </b>
                                                    <small>por R$</small>
                                                    <span class="font-weight-600">
                                                        <span id="discount_amount_<?php echo $count; ?>" style="display:none"><?php echo $discount['amount']; ?></span>
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

    <?php if ($available > 0 && $enable_sale == 1 && $enable_discount == 0 && $status == '1') { ?>
        <div class="app-promocao-numeros mb-4">
            <div class="sc-3f9a15f1-13 byugCZ">

                <div class="sc-3f9a15f1-28 kfFTzL line">📣


                </div>

                <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Promoção</h5>

            </div>

            <div class=" sc-3f9a15f1-7 iVtoES">
                <div class="card-body pb-1">
                    <div class="row px-2">
                        <div class="col-auto px-1 mb-2">
                            <button onclick="qtyRaffle('<?php echo $sale_qty; ?>', false);" class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                <span class="font-weight-500">Comprando
                                    <b class="font-weight-600"><span><?php echo $sale_qty; ?> cotas</span></b> sai por
                                    apenas<small> R$</small>
                                    <span class="font-weight-600"><?php echo number_format($sale_price, 2, ',', '.'); ?></span>
                                    cada
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($available > 0 && $status == '1') { ?>

        <div class="app-vendas-express mb-4">
            <div class="numeros-select d-flex align-items-center justify-content-center flex-column">
                <div class="vendasExpressNumsSelect v2">
                    <div onclick="qtyRaffle(<?php echo $qty_select_1; ?>, false);" class="item mb-2">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_1; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0">Selecionar</p>
                        </div>
                    </div>
                    <div onclick="qtyRaffle(<?php echo $qty_select_2; ?>, false);" class="item mb-2">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_2; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0">Selecionar</p>
                        </div>
                    </div>
                    <div onclick="qtyRaffle(<?php echo $qty_select_3; ?>, false);" class="item mb-2 mais-popular">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_3; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0" style="color:#fff;">Selecionar</p>
                        </div>
                    </div>
                    <div onclick="qtyRaffle(<?php echo $qty_select_4; ?>, false);" class="item mb-2">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_4; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0">Selecionar</p>
                        </div>
                    </div>
                    <div onclick="qtyRaffle(<?php echo $qty_select_5; ?>, false);" class="item mb-2">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_5; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0">Selecionar</p>
                        </div>
                    </div>
                    <div onclick="qtyRaffle(<?php echo $qty_select_6; ?>, false);" class="item mb-2">
                        <div class="item-content flex-column p-2">
                            <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small><?php echo $qty_select_6; ?>
                            </h3>
                            <p class="item-content-txt font-xss text-uppercase mb-0">Selecionar</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex w-100 justify-content-center items-center">
                    <div class="vendasExpressNums app-card card mb-2 w-100 font-xs me-1">
                        <div class="card-body d-flex align-items-center justify-content-center font-xss p-1">
                            <div class="left pointer">
                                <div class="removeNumero numeroChange"><i class="bi bi-dash-circle"></i></div>
                            </div>
                            <div class="center">
                                <input class="form-control text-center qty" readonly value="<?php echo isset($min_purchase) ? $min_purchase : ''; ?>" aria-label="Quantidade de números" placeholder="<?php echo isset($min_purchase) ? $min_purchase : ''; ?>">
                            </div>
                            <div class="right pointer">
                                <div class="addNumero numeroChange"><i class="bi bi-plus-circle"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php if ($user_id) { ?>
                        <button @click="open = ! open" id="add_to_cart" data-bs-toggle="modal" data-bs-target="#modal-checkout" class="btn btn-success w-100 app-card card mb-2">
                        <?php } else { ?>
                            <span id="add_to_cart"></span>
                            <button data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-success w-100 app-card card mb-2">
                            <?php } ?>
                            <div class="d-flex align-items-center" style="display: flex; flex-direction:row;">
                                <span class="me-4" style="background-color: #e9ecef; border-radius:6px; ">
                                    <i style="color: #198754;display:flex; border-radius:10px; padding:0.6rem" class="bi bi-arrow-right"></i>
                                </span>
                                <div style="flex-direction:column; display:flex; align-items: flex-start;">
                                    <div class="col pe-0 text-nowrap"><span>Participar</span></div>
                                    <div class="col pe-0 text-nowrap price-mobile" style="margin-top: 0px !important;">
                                        <span id="total" style="opacity: 0.7; font-size:0.75rem !important">R$
                                            <?php
                                            if (isset($price)) {
                                                $price_total = $price * $min_purchase;
                                                echo format_num($price_total, 2);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </button>
                </div>
            </div>
        </div>

    <?php } ?>

   



    <?php
    if ($available > 0 && $status == '1') {
        if ($cotas_premiadas) {
            $cotas_premiada = explode(',', $cotas_premiadas);
    ?>
            <div class="app-promocao-numeros flex-column mb-4 ">
                <div class="sc-3f9a15f1-13 byugCZ" style="align-items:center;justify-content:space-between;">

                    <div style="display:flex; align-items:center">
                        <div class="sc-3f9a15f1-28 kfFTzL line">🔥


                        </div>

                        <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Cotas premiadas</h5>
                    </div>

                    <button style="color:#fff;background-color:inherit; font-weight:500 ; margin-right:4px " type="button" data-bs-toggle="modal" data-bs-target="#modal-cotas">Ver mais</button>


                </div>
                <div id="cotas-container" class="iVtoES" style="padding:4px">

                      <div class="skeleton"></div>
                      <div class="hr"></div>
<div class="skeleton"></div>
<div class="hr"></div>
<div class="skeleton"></div>
                </div>

            </div>
    <?php
        }
    }
    ?>










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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award">
                            <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
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

                                <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                    <img alt="<?php echo $winner['name']; ?>" src="<?php echo $winner['image']; ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                    <noscript></noscript>
                                </div>

                            </div>
                            <div class="undefined w-100">
                                <h5 class="mb-0" style="text-transform: uppercase;"><?php echo $count; ?>º -
                                    <?php echo $winner['name']; ?>&nbsp;<i class="bi bi-check-circle text-white-50"></i></h5>
                                <div class="text-white-50"><small>Ganhador(a) com a cota <?php echo $winner['number']; ?></small>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?php if ($enable_cpf != 1) : ?>
                                <label class="form-label">Informe seu telefone</label>
                                <div class="input-group mb-2">
                                    <input onkeyup="formatarTEL(this);" maxlength="15" class="form-control" aria-label="Número de telefone" id="phone" name="phone" required>
                                    <button class="btn btn-secondary" type="submit" id="button-addon2">
                                        <div class=""><i class="bi bi-check-circle"></i></div>
                                    </button>
                                </div>
                            <?php else : ?>
                                <label class="form-label">Informe seu CPF</label>
                                <div class="input-group mb-2">
                                    <input name="cpf" class="form-control" id="cpf" maxlength="14" minlength="14" placeholder="000.000.000-00" oninput="formatarCPF(this.value)" required>
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


    <div x-data="{ open: false }" class="modal fade" id="modal-checkout">
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
                            cotas</span><span>&nbsp;da ação entre amigos</span><span class="font-weight-500">&nbsp;<?php echo isset($name) ? $name : ''; ?></span>,<span>&nbsp;seus
                            números serão
                            gerados</span><span>&nbsp;assim que concluir a compra.</span></div>
                    <div class="mb-3">
                        <div class="card app-card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="rounded-pill p-1 bg-white box-shadow-08" style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                                            <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                                <img src="<?php echo validate_image($_settings->userdata('avatar')); ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                                <noscript></noscript>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1"><?php echo $_settings->userdata('firstname'); ?>
                                            <?php echo $_settings->userdata('lastname'); ?></h5>
                                        <div>
                                            <small><?php echo formatPhoneNumber($_settings->userdata('phone')); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="bi bi-chevron-compact-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="place_order" data-id="<?=$ref?>" class="btn btn-success w-100 mb-2">Concluir reserva <i class="bi bi-arrow-right-circle"></i></button>
                    <button type="button" class="btn btn-link btn-sm text-secondary text-decoration-none w-100 my-2"><a href="<?php echo BASE_URL . 'logout?' . $_SERVER['REQUEST_URI']; ?>">Utilizar outra
                            conta</a></button>
                </div>
            </div>
        </div>
    </div>

    <button id="aviso_sorteio" data-bs-toggle="modal" data-bs-target="#modal-aviso" class="btn btn-success w-100 py-2" style="display:none"></button>



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
                <div class="modal-body text-center">Faça login para ter seu link de indicação, e ganhe até 0,00% de
                    créditos nas compras aprovadas!</div>
            </div>
        </div>
    </div>


    <?php if ($enable_groups == 1) { ?>
        <div class="sorteio_sorteioShare__247_t" style="z-index:10;">
            <div class="campanha-share d-flex mb-1 justify-content-between align-items-center">
                <?php if ($enable_share == 1) { ?>
                    <div class="item d-flex align-items-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>" target="_blank">
                            <div alt="Compartilhe no Facebook" class="sorteio_sorteioShareLinkFacebook__2McKU" style="margin-right:5px;">
                                <i class="bi bi-facebook"></i>
                            </div>
                        </a>
                        <a href="https://t.me/share/url?url=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>&text=<?php echo $name; ?>" target="_blank">
                            <div alt="Compartilhe no Telegram" class="sorteio_sorteioShareLinkTelegram__3a2_s" style="margin-right:5px;">
                                <i class="bi bi-telegram"></i>
                            </div>
                        </a>
                        <a href="https://www.twitter.com/share?url=<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>" target="_blank">
                            <div alt="Compartilhe no Twitter" class="sorteio_sorteioShareLinkTwitter__1E4XC" style="margin-right:5px;">
                                <i class="bi bi-twitter"></i>
                            </div>
                        </a>
                        <a href="https://api.whatsapp.com/send/?text=<?php echo $name; ?>%21%21%3A+<?php echo BASE_URL; ?>campanha/<?php echo $slug; ?>&type=custom_url&app_absent=0" target="_blank">
                            <div alt="Compartilhe no WhatsApp" class="sorteio_sorteioShareLinkWhatsApp__2Vqhy">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <?php if ($whatsapp_group_url) { ?>
                <a href="<?php echo $whatsapp_group_url; ?>" target="_blank">
                    <div class="whatsapp-grupo">
                        <div class="btn btn-sm btn-success mb-1 w-100"><i class="bi bi-whatsapp"></i> Grupo</div>
                    </div>
                </a>
            <?php } ?>
            <?php if ($telegram_group_url) { ?>
                <a href="<?php echo $telegram_group_url; ?>" target="_blank">
                    <div class="telegram-grupo">
                        <div class="btn btn-sm btn-info btn-block text-white mb-1 w-100"><i class="bi bi-telegram"></i>
                            Telegram</div>
                    </div>
                </a>
            <?php } ?>
            <?php if ($support_number) { ?>
                <a href="https://api.whatsapp.com/send?phone=55<?php echo $support_number; ?>" target="_blank">
                    <div class="suporte">
                        <div class="btn btn-sm btn-warning mb-1 w-100"><i class="bi bi-headset"></i> Suporte</div>
                    </div>
                </a>
            <?php } ?>
        </div>
    <?php } ?>



    <!-- Modal cotas premiadas -->

    <div style="color:#fff" class="modal fade" tabindex="-1" id="modal-cotas">
        <div class="modal-dialog">
            <div style="background-color:#343a40" class="modal-content">
                <div class="modal-header">
                    <div class="sc-3f9a15f1-13 byugCZ">

                        <div class="sc-3f9a15f1-28 kfFTzL line">🔥</div>

                        <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Cotas premiadas</h5>

                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="cotas_modal" style="padding:4px">

                    </div>

                </div>

            </div>
        </div>
    </div>




    <script>

    function copyPix() {
        var copyText = document.getElementById("affiliate_url");

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        document.execCommand("copy");
        navigator.clipboard.writeText(copyText.value);

        alert("Link copiado com sucesso");
    }
        $(document).ready(function() {
            var cotas_array = '<?php echo isset($cotas_premiadas_premios) ? $cotas_premiadas_premios : ""; ?>';
            var product_id = parseInt("<?php echo isset($id) ? $id : ''; ?>");
            var cotas_premiadas = "<?php echo isset($cotas_premiadas) ? $cotas_premiadas : ''; ?>";
            $.ajax({
                url: _base_url_ + "class/Main.php?action=load_cotas",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: {
                    product_id: product_id,
                    cotas_premiadas: cotas_premiadas,
                    cotas_array: cotas_array
                },
                success: function(response) {
                    var cotas = response.split('<div class="hr"></div>');
                    var cotas_premiadas = cotas.slice(0, 3).join('<div class="hr"></div>');
                    $('#cotas-container').html(cotas_premiadas);
                    $('.cotas_modal').html(response);

                },
                error: function() {
                    $('#cotas-container').html('<p>Erro ao carregar as cotas.</p>');
                }
            });
        });

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
                    value = 1;
                } else {
                    value--;
                }
                $(".qty").val(value);
                calculatePrice(value);
            })

            function place_order($ref) {
                $('#overlay').fadeIn(300);
                $.ajax({
                    url: _base_url_ + 'class/Main.php?action=place_order_process',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: {
                        ref: $ref,
                        product_id: parseInt("<?php echo isset($id) ? $id : ''; ?>")
                    },
                    dataType: 'json',
                    error: err => {
                        console.error(err)
                    },
                    success: function(resp) {
                        if (resp.status == 'success') {
                            Livewire.navigate(resp.redirect)


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

        })

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
            let price = '<?php echo $price; ?>';
            let enable_sale = parseInt('<?php echo $enable_sale; ?>');
            let sale_qty = parseInt('<?php echo $sale_qty; ?>');
            let sale_price = '<?php echo $sale_price; ?>';

            let available = parseInt('<?php echo $available; ?>');
            let total = price * qty;
            var max = parseInt('<?php echo isset($max_purchase) ? $max_purchase : ''; ?>');
            var min = parseInt('<?php echo isset($min_purchase) ? $min_purchase : ''; ?>');

            if (qty > available) {
                $('.aviso-content').html('Restam apenas ' + available + ' cotas disponíveis no momento.');
                $('#aviso_sorteio').click();
                $(".qty").val(available);
                calculatePrice(available);
                return;
            }

            if (qty < min) {
                $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
                $(".qty").val(min);
                calculatePrice(min);
                return;
            }

            if (qty > max) {
                $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
                $(".qty").val(max);
                calculatePrice(max);
                return;
            }

            var qtd_desconto = parseInt('<?php echo $max_discount; ?>');

            let dropeDescontos = [];
            for (i = 0; i < qtd_desconto; i++) {
                dropeDescontos[i] = {
                    qtd: parseInt($(`#discount_qty_${i}`).text()),
                    vlr: parseFloat($(`#discount_amount_${i}`).text())
                };
            }

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

            <?php if ($enable_cumulative_discount == 1) { ?>
                desconto_acumulativo = true;
            <?php } ?>

            if (desconto_acumulativo && qty >= quantidade_de_numeros) {
                var multiplicador_do_desconto = Math.floor(qty / quantidade_de_numeros);
                drope_desconto_aplicado = total - (valor_do_desconto * multiplicador_do_desconto);
            }

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
                    product_id: "<?php echo isset($id) ? $id : ''; ?>",
                    qty: qty
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert("[PP01] - An error occured.", 'error');
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        //location.reload();
                    } else if (!!resp.msg) {
                        alert(resp.msg, 'error');
                    } else {
                        alert("[PP02] - An error occured.", 'error');
                    }
                }
            })
        }

        $(document).ready(function() {
            $('.qty').on('keyup', function() {
                var value = parseInt($(this).val());
                var min = parseInt('<?php echo isset($min_purchase) ? $min_purchase : ''; ?>');
                var max = parseInt('<?php echo isset($max_purchase) ? $max_purchase : ''; ?>');
                if (value < min) {
                    calculatePrice(min);
                    $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
                    $('#aviso_sorteio').click();
                    $(".qty").val(min);
                }
                if (value > max) {
                    calculatePrice(max);
                    $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
                    $('#aviso_sorteio').click();
                    $(".qty").val(max);
                }
            });
        });
    
        $(document).ready(function() {
            $('#consultMyNumbers').submit(function(e) {
                e.preventDefault()
                var tipo = "<?php echo $search_type; ?>";
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
                        }
                    }
                })
            })

        })

        
    </script>

</div>