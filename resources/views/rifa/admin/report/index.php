<?php

include app_path('Includes/settings.php');
$product_id = (isset($_GET['product_id']) ? $_GET['product_id'] : '');
$status_id = (isset($_GET['status_id']) ? $_GET['status_id'] : '');
$payment_method = (isset($_GET['payment_method']) ? $_GET['payment_method'] : '');
$start_date = (isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-6 days')));
$end_date = (isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'));
echo '<style>' . "\r\n" . '.order_numbers{white-space:normal}tr.text-gray-700.dark\\:text-gray-400{vertical-align:text-bottom}.exportar-contatos{max-width:189px;display:inline-block;margin-bottom:10px}@media all and (max-width:40em){.filtro-busca{display:block!important}}span#approve-payment{background:#2271b1;padding:6px;display:inline-block;margin-top:6px;border-radius:4px;color:#fff;cursor:pointer}td.px-4.py-3.text-sm {max-width: 240px;text-wrap: pretty;}@media only screen and (max-width:600px){.fb-2{margin-top:10px;width:100%}}@media only screen and (max-width:600px){.fb-2{margin-top:10px;width:100%}}' . "\r\n" . '</style>' . "\r\n\r\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\r\n" . '    <div class="container grid px-6 mx-auto">' . "\r\n" . '        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '        Relatórios' . "\r\n" . '        </h2>  ' . "\r\n\r\n" . '        <form action="" id="filter-form" style="margin-bottom:10px" method="GET">' . "\r\n" . '            <div class="flex filtro-busca">' . "\r\n" . '                <select name="product_id" id="product_id" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">' . "\r\n" . '                    <option value="">Todos as campanhas</option>' . "\r\n" . '                    ';
$qry = $conn->query('SELECT * FROM `product_list`');

while ($row = $qry->fetch_assoc()) {
	echo '                        <option value="';
	echo $row['id'];
	echo '" ';

	if ($product_id == $row['id']) {
		echo 'selected';
	}

	echo '>';
	echo $row['name'];
	echo '</option>' . "\r\n" . '                    ';
}

echo '                </select>' . "\r\n" . '                <select name="status_id" id="status_id" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">' . "\r\n" . '                    <option value="">Todos os status</option>' . "\r\n" . '                    <option value="2" ';

if ($status_id == '2') {
	echo 'selected';
}

echo '>Pago</option>' . "\r\n" . '                    <option value="1" ';

if ($status_id == '1') {
	echo 'selected';
}

echo '>Pendente</option>' . "\r\n" . '                    <option value="3" ';

if ($status_id == '3') {
	echo 'selected';
}

echo '>Cancelado</option>' . "\r\n" . '                </select>' . "\r\n\r\n" . '                <select name="payment_method" id="payment_method" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">' . "\r\n" . '                    <option value="">Todos os métodos</option>' . "\r\n" . '                    <option value="MercadoPago" ';

if ($payment_method == 'MercadoPago') {
	echo 'selected';
}

echo '>Mercado Pago</option>' . "\r\n" . '                    <option value="Paggue" ';

if ($payment_method == 'Paggue') {
	echo 'selected';
}

echo '>Paggue</option>' . "\r\n" . '                    <option value="Gerencianet" ';

if ($payment_method == 'Gerencianet') {
	echo 'selected';
}

echo '>Gerencianet</option>' . "\r\n" . '                    <option value="OpenPix" ';

if ($payment_method == 'OpenPix') {
	echo 'selected';
}

echo '>OpenPix</option>' . "\r\n" . '                    <option value="Manual" ';

if ($payment_method == 'Manual') {
	echo 'selected';
}

echo '>Manual</option>' . "\r\n" . '                </select>' . "\r\n\r\n" . '                <input name="start_date" id="start_date" type="date" value="';
echo ($start_date ? $start_date : date('Y-m-d', strtotime('-7 days')));
echo '" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">' . "\r\n" . '                <input name="end_date" id="end_date" type="date" value="';
echo ($end_date ? $end_date : date('Y-m-d'));
echo '" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">' . "\r\n\r\n" . '                <button class="fb-2 px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>' . "\r\n" . '            </div>' . "\r\n" . '        </form>' . "\r\n\r\n" . '        <div class="grid gap-6 mb-4 md:grid-cols-2 xl:grid-cols-4">' . "\r\n" . '            <!-- Card -->' . "\r\n" . '            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\r\n" . '                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">' . "\r\n" . '                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-megaphone" viewBox="0 0 16 16">' . "\r\n" . '                    <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49a68.14 68.14 0 0 0-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 74.663 74.663 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199V2.5zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0zm-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233c.18.01.359.022.537.036 2.568.189 5.093.744 7.463 1.993V3.85zm-9 6.215v-4.13a95.09 95.09 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A60.49 60.49 0 0 1 4 10.065zm-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68.019 68.019 0 0 0-1.722-.082z"/>' . "\r\n" . '                </svg>' . "\r\n" . '                </div>' . "\r\n" . '                <div>' . "\r\n" . '                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\r\n" . '                    Cotas vendidas' . "\r\n" . '                </p>' . "\r\n" . '                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '                ';
$where = '';

if ($product_id) {
	$where .= ' AND o.product_id = \'' . $product_id . '\'';
}

if ($status_id) {
	$where .= ' AND o.status = \'' . $status_id . '\'';
}

if ($payment_method) {
	$where .= ' AND o.payment_method = \'' . $payment_method . '\'';
}
if ($start_date || $end_date) {
	$where .= ' AND o.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$qry = $conn->query('SELECT SUM(o.quantity) as quantity FROM `order_list` o ' . $where);

if (0 < $qry->num_rows) {
	$row = $qry->fetch_assoc();

	if (!empty($row['quantity'])) {
		echo $row['quantity'];
	}
	else {
		echo 0;
	}
}

echo '                </p>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '            <!-- Card -->' . "\r\n" . '            <!-- Card -->' . "\r\n" . '            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\r\n" . '                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">' . "\r\n" . '                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">' . "\r\n" . '                    <path' . "\r\n" . '                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">' . "\r\n" . '                    </path>' . "\r\n" . '                </svg>' . "\r\n" . '                </div>' . "\r\n" . '                <div>' . "\r\n" . '                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\r\n" . '                    Novos clientes' . "\r\n" . '                </p>' . "\r\n" . '                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '                ';
$where = '';
if ($start_date || $end_date) {
	$where .= ' AND c.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$qry = $conn->query('SELECT COUNT(c.id) as id FROM `customer_list` c ' . $where);

if (0 < $qry->num_rows) {
	$row = $qry->fetch_assoc();
	echo $row['id'];
}
else {
	echo 0;
}

echo '                </p>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '            <!-- Card -->' . "\r\n" . '            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\r\n" . '                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">' . "\r\n" . '                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16">' . "\r\n" . '                <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>' . "\r\n" . '                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>' . "\r\n" . '                </svg>' . "\r\n" . '                </div>' . "\r\n" . '                <div>' . "\r\n" . '                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\r\n" . '                    Pedidos efetuados' . "\r\n" . '                </p>' . "\r\n" . '                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '                ';
$where = '';

if ($product_id) {
	$where .= ' AND o.product_id = \'' . $product_id . '\'';
}

if ($status_id) {
	$where .= ' AND o.status = \'' . $status_id . '\'';
}

if ($payment_method) {
	$where .= ' AND o.payment_method = \'' . $payment_method . '\'';
}
if ($start_date || $end_date) {
	$where .= ' AND o.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$qry = $conn->query('SELECT o.* FROM `order_list` o INNER JOIN product_list p ON o.product_id = p.id ' . $where);

if (0 < $qry->num_rows) {
	echo $qry->num_rows;
}
else {
	echo 0;
}

echo '                </p>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '            <!-- Card -->' . "\r\n" . '            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\r\n" . '                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">' . "\r\n" . '                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">' . "\r\n" . '                <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>' . "\r\n" . '                </svg>' . "\r\n" . '                </div>' . "\r\n" . '                <div>' . "\r\n" . '                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\r\n" . '                    Faturamento' . "\r\n" . '                </p>' . "\r\n" . '                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '                ';
$where = '';

if ($product_id) {
	$where .= ' AND o.product_id = \'' . $product_id . '\'';
}

if ($status_id) {
	$where .= ' AND o.status = \'' . $status_id . '\'';
}

if ($payment_method) {
	$where .= ' AND o.payment_method = \'' . $payment_method . '\'';
}
if ($start_date || $end_date) {
	$where .= ' AND o.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$qry = $conn->query('SELECT o.*, SUM(o.total_amount) as total FROM `order_list` o INNER JOIN product_list p ON o.product_id = p.id ' . $where);

if (0 < $qry->num_rows) {
	$row = $qry->fetch_assoc();
	echo 'R$' . number_format($row['total'], 2, ',', '.');
}
else {
	echo 0;
}

echo '                </p>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '            </div>' . "\r\n\r\n" . '        <div class="w-full overflow-hidden rounded-lg shadow-xs">' . "\r\n" . '            <div class="w-full overflow-x-auto">' . "\r\n" . '                <table class="w-full whitespace-no-wrap">' . "\r\n" . '                    <thead>' . "\r\n" . '                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">               ' . "\r\n" . '                            <th class="px-4 py-3">ID</th>' . "\r\n" . '                            <th class="px-4 py-3">Data</th>' . "\r\n" . '                            <th class="px-4 py-3">Campanha</th>' . "\r\n" . '                            <th class="px-4 py-3">Gateway</th>' . "\r\n" . '                            <th class="px-4 py-3">Qtd. Números</th>' . "\r\n" . '                            <th class="px-4 py-3">Total</th>' . "\r\n" . '                        </tr>' . "\r\n" . '                    </thead>' . "\r\n" . '                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">' . "\r\n" . '                        ';
$perPage = 20;
$page = (isset($_GET['pg']) ? $_GET['pg'] : 1);
$offset = $perPage * ($page - 1);
$i = 1;
$where = '';

if ($product_id) {
	$where .= ' AND o.product_id = \'' . $product_id . '\'';
}

if ($status_id) {
	$where .= ' AND o.status = \'' . $status_id . '\'';
}

if ($payment_method) {
	$where .= ' AND o.payment_method = \'' . $payment_method . '\'';
}
if ($start_date && $end_date) {
	$where .= ' AND o.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$qry = $conn->query('SELECT o.*' . "\r\n" . '                                FROM `order_list` o' . "\r\n" . '                                INNER JOIN product_list p ON o.product_id = p.id' . "\r\n" . '                                ' . $where . "\r\n" . '                                ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC' . "\r\n" . '                                LIMIT ' . $perPage . ' OFFSET ' . $offset);
$totalResults = $conn->query('SELECT o.*' . "\r\n" . '                            FROM `order_list` o' . "\r\n" . '                            INNER JOIN product_list p ON o.product_id = p.id' . "\r\n" . '                            ' . $where . ' ')->num_rows;

while ($row = $qry->fetch_assoc()) {
	echo '                        <tr class="text-gray-700 dark:text-gray-400">' . "\r\n" . '                            <td class="px-4 py-3">#';
	echo $row['id'];
	echo '</td>          ' . "\r\n" . '                            <td class="px-4 py-3">';
	echo date('d-m-Y', strtotime($row['date_created']));
	echo '</td>          ' . "\r\n" . '                            <td class="px-4 py-3">';
	echo $row['product_name'];
	echo '</td>          ' . "\r\n" . '                            <td class="px-4 py-3">';
	echo $row['payment_method'];
	echo '</td>          ' . "\r\n" . '                            <td class="px-4 py-3">';
	echo $row['quantity'];
	echo '</td>          ' . "\r\n" . '                            <td class="px-4 py-3">R$ ';
	echo format_num($row['total_amount'], 2);
	echo '</td>   ' . "\r\n" . '                        </tr>' . "\r\n" . '                        ';
}

echo '                    </tbody>' . "\r\n" . '                </table>' . "\r\n" . '            </div>' . "\r\n\r\n" . '            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">' . "\r\n" . '        <span class="flex items-center col-span-3"></span>' . "\r\n" . '        <span class="col-span-2"></span>' . "\r\n" . '        <!-- Pagination -->' . "\r\n" . '        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">' . "\r\n" . '            <nav aria-label="Table navigation">' . "\r\n" . '                <ul class="inline-flex items-center">' . "\r\n" . '                    ';
$totalPages = ceil($totalResults / $perPage);
echo '                    ';

if (1 < $page) {
	echo '                        <a href=\'/pedidos-';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page - 1;
	echo '\'><li>' . "\r\n" . '                            <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">' . "\r\n" . '                                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">' . "\r\n" . '                                    <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>' . "\r\n" . '                                </svg>' . "\r\n" . '                            </button>' . "\r\n" . '                        </li></a>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if (3 < $page) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>' . "\r\n" . '                        <li class="dots">...</li>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if (0 < ($page - 2)) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page - 2;
	echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page - 2;
	echo '</button></li></a>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if (0 < ($page - 1)) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page - 1;
	echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page - 1;
	echo '</button></li></a>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    <a href="/relatorio?product_id=';
echo $product_id;
echo '&status_id=';
echo $status_id;
echo '&payment_method=';
echo $payment_method;
echo '&start_date=';
echo $start_date;
echo '&end_date=';
echo $end_date;
echo '&pg=';
echo $page;
echo '">' . "\r\n" . '                        <li>' . "\r\n" . '                            <button' . "\t" . 'class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">';
echo $page;
echo '</button>' . "\r\n" . '                        </li>' . "\r\n" . '                    </a>' . "\r\n" . '                    ';

if (($page + 1) < ($totalPages + 1)) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page + 1;
	echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page + 1;
	echo '</button></li></a>' . "\t\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if (($page + 2) < ($totalPages + 1)) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page + 2;
	echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page + 2;
	echo '</button></li></a>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if ($page < ($totalPages - 2)) {
	echo '                        <li class="dots">...</li>' . "\r\n" . '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $totalPages;
	echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $totalPages;
	echo '</button></li></a>' . "\r\n" . '                    ';
}

echo "\r\n" . '                    ';

if ($page < $totalPages) {
	echo '                        <a href="/relatorio?product_id=';
	echo $product_id;
	echo '&status_id=';
	echo $status_id;
	echo '&payment_method=';
	echo $payment_method;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page + 1;
	echo '"><li>' . "\r\n" . '                            <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">' . "\r\n" . '                                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">' . "\r\n" . '                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>' . "\r\n" . '                                </svg>' . "\r\n" . '                            </button>' . "\r\n" . '                            </li>' . "\r\n" . '                        </a>' . "\r\n" . '                ';
}

echo '                </ul>' . "\r\n" . '            </nav>' . "\r\n" . '        </span>' . "\r\n" . '        <!-- End pagination -->' . "\r\n\r\n\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '</main>' . "\r\n\r\n" . '<script>' . "\r\n" . '    $(function(){' . "\r\n" . '        $(\'#filter-form\').submit(function(e){' . "\r\n" . '            e.preventDefault()' . "\r\n" . '            location.href = \'/relatorio?\'+$(this).serialize()' . "\r\n" . '        })' . "\r\n\t" . '})' . "\r\n" . '</script>';

?>