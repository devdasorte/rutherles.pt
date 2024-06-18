<?php


require_once('../class/System.php');
global $_settings;
$name = $_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname');
$params = $_GET;
$paggue = $_settings->info('paggue');

$valor = $params['order_amount'];
$o_id = $params['order_id'];

function drope_paggue_get_info2($info)
{
    require_once('../class/System.php');
    global $_settings;
    $client_key = $_settings->info('paggue_client_key');
    $client_secret = $_settings->info('paggue_client_secret');

    $access_token = '';
    $curl = curl_init();
    $data = ['client_key' => $client_key, 'client_secret' => $client_secret];
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://ms.paggue.io/auth/v1/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($data)
    ]);
    $response = curl_exec($curl);
    $get = json_decode($response, true);
    curl_close($curl);

    if ($info == 'access_token') {
        $info = $get['access_token'];
    }

    if ($info == 'company_id') {
        $info = $get['user']['companies'][0]['id'];
    }

    return $info;
}

function drope_paggue_create_order2($order_user, $order_item, $order_amount, $order_id)
{
    require_once('../class/System.php');
    global $_settings;
    $client_key = $_settings->info('paggue_client_key');
    $client_secret = $_settings->info('paggue_client_secret');

    $curl = curl_init();
    $data = ['payer_name' => $order_user, 'amount' => $order_amount, 'external_id' => $order_id, 'description' => $order_item];
    $signature = hash_hmac('sha256', json_encode($data), $client_secret);
    $headers = [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . drope_paggue_get_info2('access_token'),
        'X-Company-ID: ' . drope_paggue_get_info2('company_id'),
        'Signature: ' . $signature
    ];
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://ms.paggue.io/cashin/api/billing_order',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  // Get HTTP status code
    curl_close($curl);

    $get = json_decode($response, true);
    $data = [];

    if (isset($get['payment']) && isset($get['hash'])) {
        $data = ['pix' => $get['payment'], 'hash' => $get['hash']];
    } else {
        $data = 'ERRO - PIX INDISPONÍVEL';
    }
    echo $response;
    return $data;
}



function paggue_generate_pix2($val, $oid, $name)
{
    global $conn;
    $order_user = $name;
    require_once('../gateway/phpqrcode/qrlib.php');
    require_once('db.php');
    require_once('../gateway/funcoes_pix.php');

    $order_id = $oid;
    $order_item = $order_id;
    $tax = 2;
    $order_amount = drope_normalize_price($val);
    $order_amount = number_format($order_amount, 2, '.', '');

    if ($tax) {
        $percentage = $order_amount * ($tax / 100);
        $percentage = $percentage * 100;
    }

    $order_amount = $order_amount * 100;
    $order_amount = (int) $order_amount;

    if ($tax) {
        $order_amount = $order_amount + (int) $percentage;
    }

    $data = drope_paggue_create_order2($order_user, $order_item, $order_amount, $order_id);

    $pix_code = $data['pix'];
    $hash = $data['hash'];
    $px = decode_brcode($pix_code);
    $monta_pix = montaPix($px);
    ob_start();
    QRCode::png($monta_pix, NULL, 'M', 5);
    $imageString = base64_encode(ob_get_contents());
    ob_end_clean();
    $pix_qrcode = $imageString;
    $payment_method = 'Paggue';

    // Assume $db is your database connection object
    $sql = 'UPDATE order_list' . "\r\n" . 'SET payment_method = \'' . $payment_method . '\', pix_code = \'' . $pix_code . '\', pix_qrcode = \'' . $pix_qrcode . '\', order_expiration = \'' . 15 . '\', id_mp = \'' . $hash . '\'' . "\r\n" . 'WHERE id = ' . $order_id;

    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(['pix_qrcode' => $pix_qrcode, 'pix_code' => $pix_code]);
    }
}


if ($paggue == 1) {
    paggue_generate_pix2($valor, $o_id, $name);
}
