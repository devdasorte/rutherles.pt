<?php
// Consultar produtos com sorteios concluídos
$sql = '
    SELECT name AS product_name, draw_number, draw_winner, date_of_draw, image_path, slug
    FROM product_list
    WHERE draw_number <> \'\'';

$products = $conn->query($sql);
?>

<div class="container app-main">
    <div class="app-title mb-2">
        <h1>🏆 Ganhadores</h1>
        <div class="app-title-desc">confira os sortudos</div>
    </div>
    <div class="app-content">
        <?php while ($row = $products->fetch_assoc()): ?>
            <?php
            $product_name = $row['product_name'];
            $draw_number_arr = json_decode($row['draw_number'], true);
            $draw_winner_arr = json_decode($row['draw_winner'], true);
            $date_of_draw = date('d/m/y', strtotime($row['date_of_draw']));
            $image_path = validate_image($row['image_path']);
            ?>

            <?php if (!empty($draw_number_arr)): ?>
                <?php
                $winners_qty = 5;
                $winners = [];

                foreach ($draw_winner_arr as $qty_index => $name) {
                    foreach ($draw_number_arr as $amount_index => $number) {
                        $query = $conn->query("SELECT CONCAT(firstname, ' ', lastname) as name, avatar FROM customer_list WHERE phone = '$name'");
                        $rowCustomer = $query->fetch_assoc();

                        if ($qty_index === $amount_index) {
                            $winners[$qty_index] = [
                                'name' => $rowCustomer['name'],
                                'number' => $number,
                                'product' => $product_name,
                                'date' => $date_of_draw,
                                'image' => $rowCustomer['avatar'] ? validate_image($rowCustomer['avatar']) : BASE_URL . 'assets/img/avatar.png'
                            ];
                        }
                    }
                }
                ?>

                <?php foreach ($winners as $winner): ?>
                    <a href="/campanhas/<?= $row['slug'] ?>" wire:navigate>
                        <div class="ganhadorItem_ganhadorContainer__1Sbxm mb-2">
                            <div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">
                                <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                    <img alt="<?= $winner['product'] ?> ganhador do prêmio <?= $winner['product'] ?>" src="<?= $winner['image'] ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                    <noscript>
                                        <img alt="<?= $winner['product'] ?> ganhador do prêmio <?= $winner['product'] ?>" src="<?= $winner['image'] ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" loading="lazy">
                                    </noscript>
                                </div>
                            </div>
                            <div class="undefined w-100">
                                <h3 class="ganhadorItem_ganhadorNome__2j_J-" style="text-transform: uppercase;"><?= $winner['name'] ?></h3>
                                <div class="ganhadorItem_ganhadorDescricao__Z4kO2">
                                    <p class="mb-0" style="text-transform:uppercase;"><b><?= $winner['product'] ?></b></p>
                                    <p class="mb-0">Número da sorte <b><?= $winner['number'] ?></b></p>
                                    <p class="mb-0">Data da premiação <b><?= $winner['date'] ?></b></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>
