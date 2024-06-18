<?php


$root_dir = $_SERVER['DOCUMENT_ROOT'];
require_once $root_dir . '/settings.php';
$sql = 'SELECT `date_created`, `order_expiration`, `product_id`, `quantity`, `id`, `id_mp`, `payment_method` FROM `order_list` WHERE `status` = 1';
$result = $conn->query($sql);

if (0 < $result->num_rows) {
	$pid = [];
	$updatePendingStatements = [];
	$deleteOrderStatements = [];

	while ($row = $result->fetch_assoc()) {
		$dateCreated = $row['date_created'];
		$orderExpiration = $row['order_expiration'];
		$product_id = $row['product_id'];
		$pid[] = $row['product_id'];
		$quantity = $row['quantity'];
		$order_id = $row['id'];
		$id_mp = $row['id_mp'];
		$payment_method = $row['payment_method'];
		$expirationTime = date('Y-m-d H:i:s', strtotime($dateCreated . ' + ' . $orderExpiration . ' minutes'));
		$currentDateTime = date('Y-m-d H:i:s');
		if (($expirationTime < $currentDateTime) && 0 < $orderExpiration) {
			if ($payment_method == 'MercadoPago') {
				if (check_order_mp($order_id, $id_mp) == 'failed') {
					$updatePendingStatements[] = 'UPDATE product_list SET pending_numbers = pending_numbers - \'' . $quantity . '\' WHERE id = \'' . $product_id . '\'';
					$updatePendingStatements[] = 'UPDATE order_list SET status = 3, date_updated = \'' . $currentDateTime . '\' WHERE id = \'' . $order_id . '\'';
					echo 'Pedido ' . $order_id . ' expirou e foi cancelado.<br>';
				}
				else {
					echo 'Pedido ' . $order_id . ' foi aprovado.<br>';
				}
			}
			else if ($payment_method == 'OpenPix') {
				if (check_order_op($order_id) == 'failed') {
					$updatePendingStatements[] = 'UPDATE product_list SET pending_numbers = pending_numbers - \'' . $quantity . '\' WHERE id = \'' . $product_id . '\'';
					$updatePendingStatements[] = 'UPDATE order_list SET status = 3, date_updated = \'' . $currentDateTime . '\' WHERE id = \'' . $order_id . '\'';
					echo 'Pedido ' . $order_id . ' expirou e foi cancelado.<br>';
				}
				else {
					echo 'Pedido ' . $order_id . ' foi aprovado.<br>';
				}
			}
			else if ($payment_method == 'Pay2m') {
				if (check_order_pay2m($order_id, $id_mp) == 'failed') {
					$updatePendingStatements[] = 'UPDATE product_list SET pending_numbers = pending_numbers - \'' . $quantity . '\' WHERE id = \'' . $product_id . '\'';
					$updatePendingStatements[] = 'UPDATE order_list SET status = 3, date_updated = \'' . $currentDateTime . '\' WHERE id = \'' . $order_id . '\'';
					echo 'Pedido ' . $order_id . ' expirou e foi cancelado.<br>';
				}
				else {
					echo 'Pedido ' . $order_id . ' foi aprovado.<br>';
				}
			}
			else {
				$updatePendingStatements[] = 'UPDATE product_list SET pending_numbers = pending_numbers - \'' . $quantity . '\' WHERE id = \'' . $product_id . '\'';
				$updatePendingStatements[] = 'UPDATE order_list SET status = 3, date_updated = \'' . $currentDateTime . '\' WHERE id = \'' . $order_id . '\'';
				echo 'Pedido ' . $order_id . ' expirou e foi cancelado.<br>';
			}

			continue;
		}

		echo 'Pedido ' . $order_id . ' ainda está no prazo de validade.<br>';
	}

	$conn->begin_transaction();

	try {
		foreach ($updatePendingStatements as $updateStatement) {
			$conn->query($updateStatement);
		}

		foreach ($deleteOrderStatements as $deleteStatement) {
			$conn->query($deleteStatement);
		}

		$conn->commit();

		if ($pid) {
			$pid = array_unique($pid);

			foreach ($pid as $id) {
				revert_product($id);
				correct_stock($id);
			}
		}

		echo 'Atualizações e exclusões realizadas com sucesso.<hr>';
	}
	catch (Exception $e) {
		$conn->rollback();
		echo 'Erro ao processar as atualizações e exclusões: ' . $e->getMessage();
		echo '<hr>';
	}
}
else {
	echo 'Não há pedidos a serem processados.';
	echo '<hr>';
}

$currentTime = date('H:i:s');
$startTime = date('04:00:00');
$endTime = date('04:15:00');
if (($startTime <= $currentTime) && $currentDateTime <= $endTime) {
	$license_key = $_settings->info('license');
	$url = 'https://license.dropestore.com/wp-json/licensor/license/view';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 0);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, 'api_key=225A632C-7B598C64-74403549-BDF93958&license_code=' . $license_key);
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
	$response = json_decode(curl_exec($curl));

	if (!$response->data == NULL) {
		$status = $response->data->status;
		$support = $response->data->support_end_time;
		$expire = $response->data->expiry_time;
		$today = date('Y-m-d H:i:s');
		curl_close($curl);
		if (($support < $today) || $expire < $today || $status == 'R' || $status == 'I') {
			$updateSQL = 'UPDATE system_info SET meta_value = \'\' WHERE meta_field = \'license\'';
			$conn->query($updateSQL);
			$insert = $conn->query('INSERT INTO `logs` (`origin`, `description`) VALUES (\'LICENSE\', \'Licença desativada via CRON\')');
		}
	}
}

?>