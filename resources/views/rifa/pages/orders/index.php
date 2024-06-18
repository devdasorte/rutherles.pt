<?php
include app_path('Includes/settings.php');

$enable_hide_numbers = $_settings->info('enable_hide_numbers');

if ($_settings->userdata('id') != '') {
    $qry = $conn->query('SELECT * FROM `customer_list` WHERE id = \'' . $_settings->userdata('id') . '\'');

    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
} else {
    echo '<script>alert("Você não tem permissão para acessar essa página"); location.replace("/");</script>';
    exit();
}
?>

<div class="container app-main">
    <div class="app-title mb-3">
        <h1>🛒 Compras</h1>
        <div class="app-title-desc">recentes</div>
    </div>
    <div>
        <?php
        $orders = $conn->query('SELECT o.*, p.image_path, p.qty_numbers, oi.product_id, p.type_of_draw 
                                FROM `order_list` o 
                                INNER JOIN `order_items` oi ON o.id = oi.order_id 
                                INNER JOIN `product_list` p ON oi.product_id = p.id 
                                WHERE o.customer_id = \'' . $_settings->userdata('id') . '\' 
                                ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC');

        while ($row = $orders->fetch_assoc()) {
            $class = '';
            $border = '';
            $btn = '';
            $status = $row['status'];

            if ($row['status'] == '1') {
                $class = 'bg-warning';
                $border = 'border-warning';
                $btn = 'btn-warning';
            }

            if ($row['status'] == '2') {
                $class = 'bg-success';
                $border = 'border-success';
                $btn = 'btn-success';
            }

            if ($row['status'] == '3') {
                $class = 'bg-danger';
                $border = 'border-danger';
                $btn = 'btn-danger';
            }
        ?>
        <div class="card app-card mb-2 pointer border-bottom border-2 <?= $border ?>">
            <div class="card-body">
                <div class="row align-items-center row-gutter-sm">
                    <div class="col-auto">
                        <div class="position-relative rounded-pill overflow-hidden box-shadow-08" style="width: 56px; height: 56px;">
                            <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                <img src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                <noscript></noscript>
                            </div>
                        </div>
                    </div>
                    <div class="col ps-2">
                        <div class="compra-title font-weight-500 text-uppercase"><?= $row['product_name'] ?></div>
                        <small class="compra-data font-xss opacity-50 text-uppercase"><i class="bi bi-calendar4-week"></i> <?= date('d-m-Y H:i', strtotime($row['date_created'])) ?></small>
                        <div class="compra-cotas font-xs mt-2">
                            <?php
                            if ($status != 3) {
                                $type_of_draw = $row['type_of_draw'];
                                $nCollection = explode(',', $row['order_numbers']);
                                $qty_nums = count($nCollection);

                                if ($type_of_draw > 1) {
                                    echo drope_format_luck_numbers_dashboard($row['order_numbers'], $row['qty_numbers'], $class, $opt = true, $type_of_draw);
                                } elseif ($type_of_draw == 1 && $status == 1 && $enable_hide_numbers == 1) {
                                    echo 'As cotas serão geradas após o pagamento.';
                                }  
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <a href="/compra/<?= $row['order_token'] ?>" >
                            <span class="btn <?= $btn ?> btn-sm p-1 px-2 w-100 font-xss">
                                <?php
                                if ($status == '1') {
                                    echo 'Efetuar pagamento';
                                }
                                if ($status == '2') {
                                    echo 'Visualizar compra';
                                }
                                if ($status == '3') {
                                    echo 'Compra cancelada';
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>
