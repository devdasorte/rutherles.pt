
<div class="container app-main">
    <div class="row">
        <div class="col-12">
            <div class="app-title">
                <h1>⚡ Campanhas</h1>
                <div class="app-title-desc">Escolha sua sorte</div>
            </div>
        </div>
        <?php
        $qry = $conn->query(
            'SELECT * FROM `product_list` WHERE status_display <> \'4\' AND featured_draw = \'1\' ORDER BY RAND() LIMIT 1'
        );

        while ($row = $qry->fetch_assoc()) { ?>
        <div class="col-12 mb-2">
            <a href="/campanhas/<?php echo $row['slug']; ?>" wire:navigate
                class="SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">
                <div class="custom-badge-display">
                    <?php if ($row["status_display"] == 1) { ?>
                    <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                    <?php } ?>

                    <?php if ($row["status_display"] == 2) { ?>
                    <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está
                        acabando!</span>
                    <?php } ?>

                    <?php if ($row["status_display"] == 3) { ?>
                    <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
                    <?php } ?>

                    <?php if ($row["status_display"] == 4) { ?>
                    <span class="badge bg-dark font-xsss">Concluído</span>
                    <?php
                    $date_of_draw = strtotime($row['date_of_draw']);
                    $date_of_draw = date('d/m', $date_of_draw);
                    ?>
                    <div class="SorteioTpl_dtSorteio__2mfSc custom-calendar-display"><i
                            class="bi bi-calendar2-check"></i> <?php echo $date_of_draw; ?></div>
                    <?php } ?>

                    <?php if ($row["status_display"] == 5) { ?>
                    <span class="badge bg-dark font-xsss">Em breve!</span>
                    <?php } ?>

                    <?php if ($row["status_display"] == 6) { ?>
                    <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
                    <?php } ?>
                </div>
                <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
                    <div id="carouselSorteio640d0a84b1fef407920230311"
                        class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style="width:100%;height:350px">
                                <div
                                    style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                    <img alt="<?php echo $row['name']; ?>" src="<?php echo validate_image($row['image_path']); ?>" decoding="async"
                                        data-nimg="fill" class="SorteioTpl_imagem__2GXxI"
                                        style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" loading="lazy">
                                    <noscript><img alt="<?php echo $row['name']; ?>" src="<?php echo validate_image($row['image_path']); ?>"
                                            decoding="async" data-nimg="fill"
                                            style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%"
                                            class="SorteioTpl_imagem__2GXxI" loading="lazy" /></noscript>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sc-fc529a77-9 dHkKcR">
                    <div class="sc-fc529a77-10 gQLCaq">
                        <h1 class="SorteioTpl_title__3RLtu_xl"><?php echo $row['name']; ?></h1>
                        <div class="sc-fc529a77-11 iZCVCw"><span><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></span></div>
                    </div>
                </div>

            </a>
        </div>
        <?php
        }

        $qry = $conn->query(
            'SELECT * FROM `product_list` WHERE featured_draw = \'0\' AND private_draw = \'0\' ORDER BY id DESC LIMIT 10'
        );

        if (0 < $qry->num_rows) {
            while ($row = $qry->fetch_assoc()) {
        ?>
        <div class="col-12 mb-2">


            
            <a href="/campanhas/<?php echo $row['slug']; ?>"wire:navigate>
                <div class="SorteioTpl_sorteioTpl__2s2Wu pointer">
                    <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
                        <div
                            style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                            <img alt="1.500,00 com apenas 0,03 centavos" src="<?php echo validate_image($row['image_path']); ?>" decoding="async"
                                data-nimg="fill" class="SorteioTpl_imagem__2GXxI"
                                style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                            <noscript><img alt="1.500,00 com apenas 0,03 centavos" src="<?php echo validate_image($row['image_path']); ?>"
                                    decoding="async" data-nimg="fill"
                                    style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%"
                                    class="SorteioTpl_imagem__2GXxI" loading="lazy" /></noscript>
                        </div>
                    </div>
                    <div class="SorteioTpl_info__t1BZr">
                        <h1 class="SorteioTpl_title__3RLtu"><?php echo $row['name']; ?></h1>
                        <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">
                            <?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?>
                        </p>

                        <?php if ($row["status_display"] == 1) { ?>
                        <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                        <?php } ?>

                        <?php if ($row["status_display"] == 2) { ?>
                        <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está
                            acabando!</span>
                        <?php } ?>

                        <?php if ($row["status_display"] == 3) { ?>
                        <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
                        <?php } ?>

                        <?php if ($row["status_display"] == 4) { ?>
                        <span class="badge bg-dark font-xsss">Concluído</span>
                        <?php
                        $date_of_draw = strtotime($row['date_of_draw']);
                        $date_of_draw = date('d/m', $date_of_draw);
                        ?>
                        <div class="SorteioTpl_dtSorteio__2mfSc"><i class="bi bi-calendar2-check"></i>
                            <?php echo $date_of_draw; ?></div>
                        <?php } ?>

                        <?php if ($row["status_display"] == 5) { ?>
                        <span class="badge bg-dark font-xsss">Em breve!</span>
                        <?php } ?>

                        <?php if ($row["status_display"] == 6) { ?>
                        <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }
        }else{ ?>
<div class="col-12 visually-hidden">

        <div class="alert alert-info"><i class="bi bi-info-circle"></i> Nenhuma ação encontrada</div>
</div>
        <?php } ?>

        <div class="col-12 mt-2">
            <div class="app-helpers mb-2">
                <div class="row">
                    <div class="col col-contato-display">
                        <div
                            class="d-flex align-items-center w-100 justify-content-center font-xs bg-white bg-opacity-25 box-shadow-08 p-2 rounded-10">
                            <div class="icone font-lg bg-dark rounded p-2 me-2 bg-opacity-10">🤷</div>
                            <a href="/contato"wire:navigate>
                                <div class="txt">
                                    <h3 class="mb-0 font-md">Dúvidas</h3>
                                    <p class="mb-0 font-xs">Fale conosco</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
$sql = "SELECT name AS product_name, draw_number, draw_winner, image_path, slug, date_of_draw FROM product_list WHERE draw_number <> '' ORDER BY date_of_draw DESC LIMIT 5";
$products = $conn->query($sql);

if ($products->num_rows > 0) {
    ?>
        <div class="app-ganhadores mb-2 mt-2">
            <div class="col-12">
                <div class="app-title">
                    <h1>🎉 Ganhadores</h1>
                    <div class="app-title-desc">sortudos</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <?php
                while ($row = $products->fetch_assoc()) {
                    $product_name = $row["product_name"];
                    $draw_number = $row["draw_number"];
                    $draw_name = $row["draw_winner"];
                    $draw_number_arr = json_decode($draw_number);
                    $draw_winner_arr = json_decode($draw_name);
                    $date_of_draw = date("d/m/y", strtotime($row["date_of_draw"]));
                    $image_path = validate_image($row["image_path"]);

                    if (!empty($draw_number_arr)) {
                        $winners = [];

                        foreach ($draw_winner_arr as $qty_index => $name) {
                            foreach ($draw_number_arr as $amount_index => $number) {
                                $query = $conn->query("SELECT CONCAT(firstname, ' ', lastname) as name, avatar FROM customer_list WHERE phone = '$name'");
                                $rowCustomer = $query->fetch_assoc();

                                if ($qty_index === $amount_index) {
                                    $winners[$qty_index] = [
                                        "name" => $rowCustomer["name"],
                                        "number" => $number,
                                        "product" => $product_name,
                                        "date" => $date_of_draw,
                                        "image" => $rowCustomer["avatar"] ? validate_image($rowCustomer["avatar"]) : BASE_URL . "assets/img/avatar.png",
                                    ];
                                }
                            }
                        }

                        foreach ($winners as $winner) {
                            ?>
                    <a href="/campanhas/<?php echo $row['slug']; ?>"wire:navigate>
                        <div class="ganhadorItem_ganhadorContainer__1Sbxm mb-2">
                            <div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">
                                <div
                                    style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                    <img alt="<?php echo $winner['product']; ?> ganhador do prêmio <?php echo $winner['product']; ?>"
                                        src="<?php echo $winner['image']; ?>" decoding="async" data-nimg="fill"
                                        style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                    <noscript><img alt="<?php echo $draw_name; ?> ganhador do prêmio <?php echo $winner['product']; ?>"
                                            src="<?php echo $winner['image']; ?>" decoding="async" data-nimg="fill"
                                            style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%"
                                            loading="lazy"></noscript>
                                </div>
                            </div>
                            <div class="undefined w-100">
                                <h3 class="ganhadorItem_ganhadorNome__2j_J-" style="text-transform: uppercase;">
                                    <?php echo $winner['name']; ?></h3>
                                <div class="ganhadorItem_ganhadorDescricao__Z4kO2">
                                    <p class="mb-0" style="text-transform:uppercase;">
                                        <b><?php echo $winner['product']; ?></b>
                                    </p>
                                    <p class="mb-0">Número da sorte <b> <?php echo $winner['number']; ?> </b>
                                    </p>
                                    <p class="mb-0">Data da premiação <b> <?php echo $winner['date']; ?> </b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                        }
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <?php
}
?>

        <!-- Perguntas frequentes -->
        <div class="app-perguntas">
            <div class="app-title">
                <h1>🙋🏼 Perguntas frequentes</h1>
            </div>
            <div id="perguntas-box">
                <?php if (!!$_settings->info("question1") && !!$_settings->info("answer1")) { ?>
                <div class="mb-2">
                    <div
                        class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse"
                            data-bs-target="#pergunta-63c30d4b6bd40368220230114" aria-expanded="false"
                            aria-controls="pergunta-63c30d4b6bd40368220230114">
                            <i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
                            <span><?php echo $_settings->info('question1'); ?></span>
                        </div>
                        <div class="d-block">
                            <div class="pergunta-item--resp mt-1 collapse" id="pergunta-63c30d4b6bd40368220230114"
                                data-bs-parent="#perguntas-box">
                                <p class="mb-0"><?php echo $_settings->info('answer1'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if (!!$_settings->info("question2") && !!$_settings->info("answer2")) { ?>
                <div class="mb-2">
                    <div
                        class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse"
                            data-bs-target="#pergunta-1" aria-expanded="false" aria-controls="pergunta-1">
                            <i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
                            <span><?php echo $_settings->info('question2'); ?></span>
                        </div>
                        <div class="d-block">
                            <div class="pergunta-item--resp mt-1 collapse" id="pergunta-1"
                                data-bs-parent="#perguntas-box">
                                <p class="mb-0"><?php echo $_settings->info('answer2'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if (!!$_settings->info("question3") && !!$_settings->info("answer3")) { ?>
                <div class="mb-2">
                    <div
                        class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse"
                            data-bs-target="#pergunta-2" aria-expanded="false" aria-controls="pergunta-2">
                            <i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
                            <span><?php echo $_settings->info('question3'); ?></span>
                        </div>
                        <div class="d-block">
                            <div class="pergunta-item--resp mt-1 collapse" id="pergunta-2"
                                data-bs-parent="#perguntas-box">
                                <p class="mb-0"><?php echo $_settings->info('answer3'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if (!!$_settings->info("question4") && !!$_settings->info("answer4")) { ?>
                <div class="mb-2">
                    <div
                        class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse"
                            data-bs-target="#pergunta-3" aria-expanded="false" aria-controls="pergunta-3">
                            <i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
                            <span><?php echo $_settings->info('question4'); ?></span>
                        </div>
                        <div class="d-block">
                            <div class="pergunta-item--resp mt-1 collapse" id="pergunta-3"
                                data-bs-parent="#perguntas-box">
                                <p class="mb-0"><?php echo $_settings->info('answer4'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php global $enable_password;
        if ($enable_password == 1) { ?>
                <div class="mb-2">
                    <div
                        class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse"
                            data-bs-target="#pergunta-4" aria-expanded="false" aria-controls="pergunta-4">
                            <i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
                            <span>Esqueci minha senha, como faço?</span>
                        </div>
                        <div class="d-block">
                            <div class="pergunta-item--resp mt-1 collapse" id="pergunta-4"
                                data-bs-parent="#perguntas-box">
                                <p class="mb-0">Você consegue recuperar sua senha indo no menu do site,
                                    depois
                                    em "Entrar" e logo a baixo tem "Esqueci&nbsp;minha senha".</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!--Fim perguntas frequentes -->
    </div>
    </div>
