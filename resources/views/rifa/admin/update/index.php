<?php


require '../../includes/auto-update/autoload.php';
require '../../settings.php';
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
$status = $response->data->status;
$support = $response->data->support_end_time;
$today = date('Y-m-d H:i:s');
curl_close($curl);
if (($support < $today) || $status == 'R' || $status == 'I' || $status == NULL) {
	$updateSQL = 'UPDATE system_info SET meta_value = \'\' WHERE meta_field = \'license\'';
	$conn->query($updateSQL);
	$insert = $conn->query('INSERT INTO `logs` (`origin`, `description`) VALUES (\'LICENSE\', \'Licença desativada [AL03]\')');
	exit('Sua licença não é válida.');
}
else {
	$update = new VisualAppeal\AutoUpdate(__DIR__ . '/temp', __DIR__ . '/../', 60);
	$update->setInstallDir($_SERVER['DOCUMENT_ROOT']);
	$update->setCurrentVersion(APP_VERSION);
	$update->setUpdateUrl('https://license.dropestore.com/update');
	$logger = new Monolog\Logger('default');
	$logger->pushHandler(new Monolog\Handler\StreamHandler(__DIR__ . '/update.log'));
	$update->setLogger($logger);
	$cache = new Desarrolla2\Cache\File(__DIR__ . '/cache');
	$update->setCache($cache, 3600);

	if ($update->checkUpdate() === false) {
		exit('Não foi possível verificar se há atualizações! Consulte o arquivo de log para obter detalhes.');
	}

	if ($update->newVersionAvailable()) {
		echo 'Nova versão: ' . $update->getLatestVersion() . '<br>';
		echo 'Instalando atualizações: <br>';
		echo '<pre>';
		var_dump(array_map(function($version) {
			return (string) $version;
		}, $update->getVersionsToUpdate()));
		echo '</pre>';
		$f = @fopen(__DIR__ . '/update.log', 'rb+');

		if ($f !== false) {
			ftruncate($f, 0);
			fclose($f);
		}

		function eachUpdateFinishCallback($updatedVersion)
		{
			echo '<h3>CALLBACK para versão ' . $updatedVersion . '</h3>';
		}

		function onAllUpdateFinishCallbacks($updatedVersions)
		{
			echo '<h3>CALLBACK para todas as versões atualizadas:</h3>';
			echo '<ul>';

			foreach ($updatedVersions as $v) {
				echo '<li>' . $v . '</li>';
			}

			echo '</ul>';
		}

		$update->onEachUpdateFinish('eachUpdateFinishCallback');
		$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');
		$result = $update->update(false);

		if ($result === true) {
			echo 'Atualização bem sucedida<br>';
			echo 'Clique <a href="' . BASE_URL . 'admin">aqui</a> para retornar ao painel de administração.';
		}
		else {
			echo 'Falha na atualização: ' . $result . '!<br>';

			if ($result = VisualAppeal\AutoUpdate::ERROR_SIMULATE) {
				echo '<pre>';
				var_dump($update->getSimulationResults());
				echo '</pre>';
			}
		}
	}
	else {
		echo 'A versão atual está atualizada.<br>';
	}
}

?>