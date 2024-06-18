<?php

include app_path('Includes/settings.php');

if ($_settings->userdata('id') != '') {
    $qry = $conn->query("SELECT * FROM `customer_list` WHERE id = '{$_settings->userdata('id')}'");
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

$orders = $conn->query("SELECT amount_paid, amount_pending FROM referral WHERE customer_id = '{$_settings->userdata('id')}' LIMIT 10");
$orders2 = $conn->query("SELECT COUNT(id) FROM order_list WHERE referral_id = '{$_settings->userdata('id')}'");

if ($orders2->num_rows > 0) {
    $rowOrder = $orders2->fetch_assoc();
    $quantity = $rowOrder['COUNT(id)'];
}

if ($orders->num_rows > 0) {
    $row = $orders->fetch_assoc();
    $amount_paid = $row['amount_paid'];
    $amount_pending = $row['amount_pending'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus rendimentos</title>
    <style>
        .block {
            display: flex;
            justify-content: space-around;
        }
        #customers {
            border-collapse: collapse;
            width: 100%;
        }
        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #customers tr:hover {
            background-color: #ddd;
        }
        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04aa6d;
            color: white;
        }
    </style>
</head>
<body>

<div class="container app-main app-form">
    <div class="row justify-content-between w-100 align-items-center">
        <div class="col">
            <div class="app-title">
                <h1>🤑 Meus rendimentos</h1>
            </div>
        </div>
    </div>

    <div class="text">
        Nesta página, você terá acesso exclusivo aos detalhes sobre suas afiliações, incluindo o valor que já conquistou até o momento e o montante disponível para receber. Entendemos que essas informações são cruciais para você, e queremos garantir total transparência e facilidade no acompanhamento do seu desempenho.
    </div>

    <div class="vendasExpressNumsSelect v2 mt-3 text-center">
        <div class="item mb-2">
            <div class="item-content flex-column p-2">
                <h5 class="mb-0 font">R$<?= number_format($amount_paid, 2, ',', '.') ?></h5>
                <p class="item-content-txt font-xss text-uppercase mb-0">RETIRADO</p>
            </div>
        </div>
        <div class="item mb-2">
            <div class="item-content flex-column p-2">
                <h5 class="mb-0 font">R$<?= number_format($amount_pending, 2, ',', '.') ?></h5>
                <p class="item-content-txt font-xss text-uppercase mb-0">SALDO</p>
            </div>
        </div>
        <div class="item mb-2">
            <div class="item-content flex-column p-2">
                <h5 class="mb-0 "><?= $quantity ?></h5>
                <p class="item-content-txt font-xss text-uppercase mb-0" style="color:#fff;">INDICAÇÕES</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-between w-100 align-items-center mt-2">
        <div class="col">
            <div class="app-title">
                <h1><i class="bi bi-link"></i> Seu link de afiliado</h1>
            </div>
        </div>
    </div>

    <div class="input-group mb-2">
        <input id="affiliate_url" type="text" class="form-control text-black" value="<?= BASE_URL ?>?ref=<?= $_settings->userdata('id') ?>">
        <div class="input-group-append">
            <button onclick="copyPix()" class="app-btn btn btn-success rounded-0 rounded-end">Copiar</button>
        </div>
    </div>

    <div class="row justify-content-between w-100 align-items-center mt-4">
        <div class="col">
            <div class="app-title">
                <h1><i class="bi bi-list-ul"></i> Últimas referências</h1>
            </div>
        </div>
    </div>

    <table id="customers">
        <tr>
            <th>Produto</th>
            <th>Comissão</th>
            <th>Data</th>
            <th>Status</th>
        </tr>
        <?php
        $orders = $conn->query("SELECT o.product_name, o.status, o.total_amount, o.date_created, r.percentage FROM order_list o INNER JOIN referral r ON o.referral_id = r.referral_code WHERE referral_id = '{$_settings->userdata('id')}' AND o.status <> 3 ORDER BY o.id DESC LIMIT 10");

        while ($row = $orders->fetch_assoc()) {
            $status = $row['status'];
            $product = $row['product_name'];
            $percentage = $row['percentage'];
            $amount = $row['total_amount'];
            $date = $row['date_created'];
        ?>
        <tr>
            <td class="small text-black"><?= $product ?></td>
            <td class="small text-black">R$<?= number_format(($amount * $percentage) / 100, 2, ',', '.') ?></td>
            <td class="small text-black"><?= date('d-m-Y', strtotime($date)) . ' às ' . date('H:i', strtotime($date)) ?></td>
            <td class="small text-black">
                <?= $status == 1 ? 'Pendente' : 'Aprovado' ?>
            </td>
        </tr>
        <?php } ?>
    </table>
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
</script>

</body>
</html>
