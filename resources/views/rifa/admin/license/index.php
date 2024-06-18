<?php


class LicenseSystem
{
	public $key = 'D9E6FD32C2C4C9E5';
	private $product_id = '9';
	private $product_base = 'raffle-system';
	private $server_host = 'https://license.dropestore.com/wp-json/licensor/';
	private static $selfobj = null;

	public function __construct()
	{
		$this->initActionHandler();
	}

	public function initActionHandler()
	{
		$handler = hash('crc32b', $this->product_id . $this->key . $this->getDomain()) . '_handle';
		if (isset($_GET['action']) && $handler == $_GET['action']) {
			$this->handleServerRequest();
			exit();
		}
	}

	public function handleServerRequest()
	{
		$type = (isset($_GET['type']) ? strtolower($_GET['type']) : '');

		switch ($type) {
		case 'rl':
			$this->removeOldResponse();
			$obj = new stdClass();
			$obj->product = $this->product_id;
			$obj->status = true;
			echo $this->encryptObj($obj);
			return NULL;
		case 'dl':
			$obj = new stdClass();
			$obj->product = $this->product_id;
			$obj->status = true;
			$this->removeOldResponse();
			echo $this->encryptObj($obj);
			return NULL;
		}

		return NULL;
	}

	public function __plugin_updateInfo()
	{
		if (function_exists('file_get_contents')) {
			$body = file_get_contents($this->server_host . 'product/update/' . $this->product_id);
			$responseJson = json_decode($body);
			if (is_object($responseJson) && !empty($responseJson->status) && !empty($responseJson->data->new_version)) {
				$responseJson->data->new_version = (!empty($responseJson->data->new_version) ? $responseJson->data->new_version : '');
				$responseJson->data->version = $responseJson->data->new_version;
				$responseJson->data->url = (!empty($responseJson->data->url) ? $responseJson->data->url : '');
				$responseJson->data->package = (!empty($responseJson->data->download_link) ? $responseJson->data->download_link : '');
				$responseJson->data->sections = (array) $responseJson->data->sections;
				$responseJson->data->icons = (array) $responseJson->data->icons;
				$responseJson->data->banners = (array) $responseJson->data->banners;
				$responseJson->data->banners_rtl = (array) $responseJson->data->banners_rtl;
				return $responseJson->data;
			}
		}

		return NULL;
	}

	public static function GetPluginUpdateInfo()
	{
		$obj = static::getInstance();
		return $obj->__plugin_updateInfo();
	}

	public static function &getInstance()
	{
		if (empty(static::$selfobj)) {
			static::$selfobj = new static();
		}

		return static::$selfobj;
		return NULL;
	}

	private function encrypt($plainText, $password = '')
	{
		if (empty($password)) {
			$password = $this->key;
		}

		$plainText = rand(10, 99) . $plainText . rand(10, 99);
		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $password, true), 0, 32);
		$iv = substr(strtoupper(md5($password)), 0, 16);
		return base64_encode(openssl_encrypt($plainText, $method, $key, OPENSSL_RAW_DATA, $iv));
	}

	private function decrypt($encrypted, $password = '')
	{
		if (empty($password)) {
			$password = $this->key;
		}

		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $password, true), 0, 32);
		$iv = substr(strtoupper(md5($password)), 0, 16);
		$plaintext = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);
		return substr($plaintext, 2, -2);
	}

	public function encryptObj($obj)
	{
		$text = serialize($obj);
		return $this->encrypt($text);
	}

	private function decryptObj($ciphertext)
	{
		$text = $this->decrypt($ciphertext);
		return unserialize($text);
	}

	private function getDomain()
	{
		$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http');
		$base_url .= '://' . $_SERVER['HTTP_HOST'];
		$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
		return $base_url;
	}

	private function getEmail()
	{
		return '';
	}

	private function processs_response($response)
	{
		$resbk = '';

		if (!empty($response)) {
			if (!empty($this->key)) {
				$resbk = $response;
				$response = $this->decrypt($response);
			}

			$response = json_decode($response);

			if (is_object($response)) {
				return $response;
			}
			else {
				$response = new stdClass();
				$response->status = false;
				$bkjson = @json_decode($resbk);

				if (!empty($bkjson->msg)) {
					$response->msg = $bkjson->msg;
				}
				else {
					$response->msg = 'Response Error, contact with the author or update the plugin or theme';
				}

				$response->data = NULL;
				return $response;
			}
		}

		$response = new stdClass();
		$response->msg = 'unknown response';
		$response->status = false;
		$response->data = NULL;
		return $response;
	}

	private function _request($relative_url, $data, &$error = '')
	{
		$response = new stdClass();
		$response->status = false;
		$response->msg = 'Empty Response';
		$curl = curl_init();
		$finalData = json_encode($data);

		if (!empty($this->key)) {
			$finalData = $this->encrypt($finalData);
		}

		$url = rtrim($this->server_host, '/') . '/' . ltrim($relative_url, '/');
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $finalData,
			CURLOPT_HTTPHEADER => ['Content-Type: text/plain', 'cache-control: no-cache']
		]);
		$serverResponse = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);

		if (!empty($serverResponse)) {
			return $this->processs_response($serverResponse);
		}

		$response->msg = 'unknown response';
		$response->status = false;
		$response->data = NULL;
		return $response;
	}

	private function getParam($purchase_key, $app_version, $admin_email = '')
	{
		$req = new stdClass();
		$req->license_key = $purchase_key;
		$req->email = (!empty($admin_email) ? $admin_email : $this->getEmail());
		$req->domain = $this->getDomain();
		$req->app_version = $app_version;
		$req->product_id = $this->product_id;
		$req->product_base = $this->product_base;
		return $req;
	}

	public function SaveResponse($response)
	{
		$key = hash('crc32b', $this->getDomain() . $this->product_id . 'LIC');
		$data = $this->encrypt(serialize($response), $this->getDomain());
		file_put_contents(dirname(__FILE__) . '/' . $key, $data);
	}

	public function getOldResponse()
	{
		$key = hash('crc32b', $this->getDomain() . $this->product_id . 'LIC');

		if (file_exists(dirname(__FILE__) . '/' . $key)) {
			$response = file_get_contents(dirname(__FILE__) . '/' . $key);

			if (!empty($response)) {
				return unserialize($this->decrypt($response, $this->getDomain()));
			}
		}

		return NULL;
	}

	private function removeOldResponse()
	{
		$key = hash('crc32b', $this->getDomain() . $this->product_id . 'LIC');

		if (file_exists(dirname(__FILE__) . '/' . $key)) {
			unlink(dirname(__FILE__) . '/' . $key);
		}

		return true;
	}

	public static function RemoveLicenseKey(&$message = '', $version = '')
	{
		$obj = self::getInstance();
		return $obj->_removePluginLicense($message, $version);
	}

	public static function CheckLicense($purchase_key, &$error = '', &$responseObj = NULL, $app_version = '', $admin_email = '')
	{
		$obj = self::getInstance();
		return $obj->_CheckLicense($purchase_key, $error, $responseObj, $app_version, $admin_email);
	}

	public final function _CheckLicense($purchase_key, &$error = '', &$responseObj = NULL, $app_version = '', $admin_email = '')
	{
		if (empty($purchase_key)) {
			$this->removeOldResponse();
			$error = '';
			return false;
		}

		$oldRespons = $this->getOldResponse();
		$isForce = false;

		if (!empty($oldRespons)) {
			if (!empty($oldRespons->expire_date) && strtolower($oldRespons->expire_date) != 'no expiry' && strtotime($oldRespons->expire_date) < time()) {
				$isForce = true;
			}
			if (!$isForce && !empty($oldRespons->is_valid) && time() < $oldRespons->next_request && !empty($oldRespons->license_key) && $purchase_key == $oldRespons->license_key) {
				$responseObj = clone $oldRespons;
				unset($responseObj->next_request);
				return true;
			}
		}

		$param = $this->getParam($purchase_key, $app_version, $admin_email);
		$response = $this->_request('product/active/' . $this->product_id, $param, $error);

		if (empty($response->code)) {
			if (!empty($response->status)) {
				if (!empty($response->data)) {
					$serialObj = $this->decrypt($response->data, $param->domain);
					$licenseObj = unserialize($serialObj);

					if ($licenseObj->is_valid) {
						$responseObj = new stdClass();
						$responseObj->is_valid = $licenseObj->is_valid;

						if (0 < $licenseObj->request_duration) {
							$responseObj->next_request = strtotime('+ ' . $licenseObj->request_duration . ' hour');
						}
						else {
							$responseObj->next_request = time();
						}

						$responseObj->expire_date = $licenseObj->expire_date;
						$responseObj->support_end = $licenseObj->support_end;
						$responseObj->license_title = $licenseObj->license_title;
						$responseObj->license_key = $purchase_key;
						$responseObj->msg = $response->msg;
						unset($responseObj->next_request);
						return true;
					}
					else {
						$this->removeOldResponse();
						$error = (!empty($response->msg) ? $response->msg : '');
					}
				}
				else {
					$error = 'Invalid data';
				}
			}
			else {
				$error = $response->msg;
			}
		}
		else {
			$error = $response->message;
		}

		return false;
	}

	public final function _removePluginLicense(&$message = '', $version = '')
	{
		$oldRespons = $this->getOldResponse();

		if (!empty($oldRespons->is_valid)) {
			if (!empty($oldRespons->license_key)) {
				$param = $this->getParam($oldRespons->license_key, $version);
				$response = $this->_request('product/deactive/' . $this->product_id, $param, $message);

				if (empty($response->code)) {
					if (!empty($response->status)) {
						$message = $response->msg;
						$this->removeOldResponse();
						return true;
					}
					else {
						$message = $response->msg;
					}
				}
				else {
					$message = $response->message;
				}
			}
		}

		return false;
	}

	public static function GetRegisterInfo()
	{
		if (!empty(static::$selfobj)) {
			return static::$selfobj->getOldResponse();
		}

		return NULL;
	}
}

if ($_settings->userdata('type') != '1') {
	echo 'Você não tem permissão para acessar essa página.';
	exit();
}

$errorMessage = '';
$responseObj = NULL;
$version = APP_VERSION;
$licenseKey = '';
$adminEmail = '';
$license_key = $_settings->info('license');
require_once 'license.php';
echo '<style>' . "\r\n" . '.active-tab{border-bottom:none!important}.can-toggle{position:relative;margin-bottom:20px}.can-toggle *,.can-toggle :after,.can-toggle :before{box-sizing:border-box}.can-toggle input[type=checkbox]{opacity:0;position:absolute;top:0;left:0}.can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before{content:attr(data-unchecked);left:0}.can-toggle label{cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;position:relative;display:flex;align-items:center;font-size:14px}.can-toggle label .can-toggle__switch{position:relative;transition:background-color .3s cubic-bezier(0, 1, .5, 1);background:#848484;height:36px;flex:0 0 134px;border-radius:4px}.can-toggle label .can-toggle__switch:before{content:attr(data-checked);position:absolute;top:0;text-transform:uppercase;text-align:center;color:rgba(255,255,255,.5);left:67px;font-size:12px;line-height:36px;width:67px;padding:0 12px}.can-toggle label .can-toggle__switch:after{content:attr(data-unchecked);position:absolute;z-index:5;text-transform:uppercase;text-align:center;background:#fff;transform:translate3d(0,0,0);transition:transform .3s cubic-bezier(0, 1, .5, 1);color:#777;top:2px;left:2px;border-radius:2px;width:65px;line-height:32px;font-size:12px}.can-toggle input[type=checkbox]:focus~label .can-toggle__switch,.can-toggle input[type=checkbox]:hover~label .can-toggle__switch{background-color:#777}.can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,.can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after{color:#5e5e5e;box-shadow:0 3px 3px rgba(0,0,0,.4)}.can-toggle input[type=checkbox]:hover~label{color:#6a6a6a}.can-toggle input[type=checkbox]:checked~label:hover{color:#55bc49}.can-toggle input[type=checkbox]:checked~label .can-toggle__switch{background-color:#70c767}.can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after{content:attr(data-checked);color:#4fb743;transform:translate3d(65px,0,0)}.can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,.can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch{background-color:#5fc054}.can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,.can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after{color:#47a43d;box-shadow:0 3px 3px rgba(0,0,0,.4)}.can-toggle label .can-toggle__switch:hover:after{box-shadow:0 3px 3px rgba(0,0,0,.4)}@media all and (max-width:40em){#tabs{flex-wrap:wrap}#tabs .mr-1{margin-bottom:15px}}#cimg{max-width:100%;max-height:25em;object-fit:scale-down;object-position:center center}h2.social-rodape{font-weight:700;margin-top:20px}.alert-success{color:#155724;background-color:#d4edda;border-color:#c3e6cb}.alert-danger{color:#721c24;background-color:#f8d7da;border-color:#f5c6cb}.alert-heading{color:inherit}.alert{margin-top:20px;position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}' . "\r\n" . '.alert-warning {color:#856404;background-color:#fff3cd;border-color:#ffeeba;}' . "\r\n" . '.alert-primary {color:#004085;background-color:#cce5ff;border-color:#b8daff;}' . "\r\n" . '</style>' . "\r\n\r\n";
new LicenseSystem();
echo "\r\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\r\n\t" . '<div class="container px-6 mx-auto grid">' . "\r\n\t\t" . '<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Licença</h2>' . "\r\n\t\t" . '<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">' . "\r\n\t\t\t" . '<div class="flex">' . "\r\n\t\t\t\t" . '<ul class="flex" id="tabs">' . "\r\n\t\t\t\t\t" . '<li class="mr-1">' . "\r\n\t\t\t\t\t\t" . '<a href="#tab1" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">Configurações</a>' . "\r\n\t\t\t\t\t" . '</li>' . "\r\n\t\t\t\t" . '</ul>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<form action="" id="manage-system">' . "\r\n\t\t\t\t" . '<div class="mt-4">' . "\r\n\t\t\t\t\t" . '<div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">' . "\r\n\t\t\t\t\t\t" . '<label class="block text-sm">' . "\r\n\t\t\t\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Código da licença</span>' . "\r\n\t\t\t\t\t\t\t" . '<input name="license" id="license"' . "\r\n\t\t\t\t\t\t\t\t" . 'class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t\t\t\t\t" . 'placeholder="Digite o código da sua licença"' . "\r\n\t\t\t\t\t\t\t\t" . 'value="';
echo $_settings->info('license');
echo '" />' . "\r\n\t\t\t\t\t\t" . '</label>' . "\r\n\r\n\t\t\t\t\t" . '</div>' . "\r\n\r\n\t\t\t\t\t";

if (!empty($license_key)) {
	if (LicenseSystem::CheckLicense($license_key, $errorMessage, $responseObj, $version, $adminEmail)) {
		echo "\t\t\t\t\t\t\t" . '<div class="alert alert-success" role="alert">' . "\r\n\t\t\t\t\t\t\t\t" . '<h4 style="font-size:18px;font-weight:600" class="alert-heading">Tudo pronto!</h4>' . "\r\n\t\t\t\t\t\t\t\t" . '<p class="mb-2">Sua licença foi ativada e você já pode começar a utilizar o sistema. Logo abaixo você poderá ver algumas informações da sua licença.</p>' . "\r\n\t\t\t\t\t\t\t\t" . '<hr>' . "\r\n\t\t\t\t\t\t\t\t" . '<p class="mt-2 mb-0">Expira em: ';
		echo $responseObj->expire_date;
		echo '</p>' . "\r\n\t\t\t\t\t\t\t\t" . '<p class="mb-0">Suporte até: ';
		echo $responseObj->support_end;
		echo '</p>' . "\r\n\t\t\t\t\t\t\t\t" . '<p class="mb-0">Tipo: ';
		echo $responseObj->license_title;
		echo '</p>' . "\r\n\t\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t\t" . '<div class="alert alert-warning" role="alert">' . "\r\n\t\t\t\t\t\t\t\t" . '<p>Fique atento ao prazo de expiração da licença! Renove o quanto antes para não ter problemas com o site  indisponível.</p>' . "\r\n" . '                                <p>Para renovar sua licença clique <a href="https://dropestore.com/downloads/renovacao-de-licenca-sistema-de-rifa/" target="_blank">aqui</a>.</p>' . "\r\n\t\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t\t";
	}
	else {
		$updateSQL = 'UPDATE system_info SET meta_value = \'\' WHERE meta_field = \'license\'';
		$conn->query($updateSQL);
		$insert = $conn->query('INSERT INTO `logs` (`origin`, `description`) VALUES (\'LICENSE\', \'Licença desativada [AL02]\')');
		echo "\t\t\t\t\t\t\t" . '<div class="alert alert-danger" role="alert">' . "\r\n\t\t\t\t\t\t\t\t";
		echo $errorMessage;
		echo "\t\t\t\t\t\t\t" . '</div>' . "\r\n" . '                            <div class="alert alert-warning" role="alert">' . "\r\n" . '                                <p>Para renovar sua licença clique <a href="https://dropestore.com/downloads/renovacao-de-licenca-sistema-de-rifa/" target="_blank">aqui</a>.</p>' . "\r\n\t\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t\t";
	}

	$updateInformation = LicenseSystem::GetPluginUpdateInfo();
	if (!empty($updateInformation) && is_object($updateInformation)) {
		if (APP_VERSION < $updateInformation->new_version) {
			echo '                                <div class="alert alert-primary" role="alert">' . "\r\n" . '                                    <p>Versão <strong>';
			echo $updateInformation->new_version;
			echo '</strong> disponível para download.</p>' . "\r\n" . '                                    <p>Você pode baixar essa nova versão através do seu painel de usuário no site da Drope.</p>' . "\r\n" . '                                    <hr class="mt-2 mb-2" style="color: #000;">' . "\r\n" . '                                    <h4 style="font-size:18px;font-weight:600">Changelog</h4>' . "\r\n" . '                                    <p>';
			echo $updateInformation->sections['changelog'];
			echo '</p>' . "\r\n" . '                                </div>' . "\r\n" . '                                <div>' . "\r\n" . '                                    <a href="/admin/update" class="mt-4 px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">' . "\r\n" . '                                            Atualizar' . "\r\n" . '                                    </a>' . "\r\n" . '                                </div>' . "\r\n" . '                                ';
		}
		else {
			echo '                                <div class="alert alert-primary" role="alert">' . "\r\n" . '                                    <p>Você está utilizando a versão mais recente do sistema.</p>' . "\r\n" . '                                </div>' . "\r\n" . '                                ' . "\r\n" . '                           ';
		}
	}
}

echo '                    ';

if (empty($license_key)) {
	echo "\t\t\t\t\t" . '<div style="margin-top:20px;">' . "\r\n\t\t\t\t\t\t" . '<button form="manage-system"' . "\r\n\t\t\t\t\t\t\t" . 'class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\r\n\t\t\t\t\t\t\t" . 'Salvar' . "\r\n\t\t\t\t\t\t" . '</button>' . "\r\n\t\t\t\t\t" . '</div>' . "\r\n" . '                    ';
}

echo "\t\t\t\t" . '</div>' . "\r\n\t\t\t" . '</form>' . "\r\n" . '            ';

if (!empty($license_key)) {
	echo '            <a class="deactive_license" style="margin-top:20px;">' . "\r\n" . '                <button class="mt-4 px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">' . "\r\n" . '                    Desativar licença' . "\r\n" . '                </button>' . "\r\n" . '            </a>' . "\r\n" . '            ';
}

echo "\t\t" . '</div>' . "\r\n\t" . '</div>' . "\r\n" . '</main>' . "\r\n\r\n" . '<script>' . "\r\n\r\n\t" . 'var pageToken = \'system_info\'; ' . "\r\n\r\n\t" . '$("#tabs a").click(function() {' . "\r\n\t\t" . 'var selectedTab = $(this).attr("href");' . "\r\n\t\t" . '$("#tabs a").removeClass("active-tab");' . "\r\n\t\t" . '$(this).addClass("active-tab");' . "\r\n\t\t" . '$(".tabcontent").hide();' . "\r\n\t\t" . '$(selectedTab).show();' . "\r\n\t\t" . 'localStorage.setItem(\'selectedTab_\' + pageToken, pageToken + \'_\' + selectedTab);' . "\r\n\t\t" . 'return false;' . "\r\n\t" . '});' . "\r\n\t\r\n\t" . '$(document).ready(function(){' . "\r\n\r\n" . '        $(\'.deactive_license\').click(function(){' . "\r\n\t\t\t" . 'deactive_license()' . "\t\r\n\t\t" . '})' . "\r\n\r\n\t" . 'var storedTab = localStorage.getItem(\'system_info\' + pageToken);' . "\r\n\t" . 'if (storedTab) {' . "\r\n\t\t" . 'var selectedTab = storedTab.substring(pageToken.length + 1);' . "\r\n\t\t" . '$("#tabs a").removeClass("active-tab");' . "\r\n\t\t" . '$(selectedTab).addClass("active-tab");' . "\r\n\t\t" . '$(".tabcontent").hide();' . "\r\n\t\t" . '$(selectedTab).show();' . "\r\n\t" . '}' . "\r\n\r\n\r\n\t" . '$(\'#manage-system\').submit(function(e){' . "\r\n\t\t" . 'e.preventDefault();' . "\r\n\t\t" . '$.ajax({' . "\r\n\t\t\t" . 'url:_base_url_+\'class/System.php?action=update_system\',' . "\r\n\t\t\t" . 'data: new FormData($(this)[0]),' . "\r\n\t\t\t" . 'cache: false,' . "\r\n\t\t\t" . 'contentType: false,' . "\r\n\t\t\t" . 'processData: false,' . "\r\n\t\t\t" . 'method: \'POST\',' . "\r\n\t\t\t" . 'type: \'POST\',' . "\r\n\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t" . 'var returnedData = JSON.parse(resp);' . "\r\n\t\t\t\t" . 'if(returnedData.status == \'success\'){' . "\r\n\t\t\t\t\t" . 'alert(\'Configurações salvas com sucesso!\');' . "\r\n" . '                    location.replace(_base_url_ + \'admin/?page=license\');' . "\r\n\t\t\t\t" . '}else{' . "\r\n\t\t\t\t\t" . 'alert(\'Ops\');' . "\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '})' . "\r\n\t" . '})' . "\r\n\r\n\t" . '});' . "\r\n\r\n" . '    function deactive_license($id){' . "\r\n\t\t" . '$.ajax({' . "\r\n\t\t\t" . 'url:_base_url_+"class/Main.php?action=deactive_license",' . "\r\n\t\t\t" . 'method:"POST",' . "\r\n\t\t\t" . 'dataType:"json",' . "\r\n\t\t\t" . 'error:err=>{' . "\r\n\t\t\t\t" . 'console.log(err)' . "\r\n\t\t\t\t" . 'alert("[AO03] - An error occured.");' . "\r\n\t\t\t\t\r\n\t\t\t" . '},' . "\r\n\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t" . 'if(typeof resp== \'object\' && resp.status == \'success\'){' . "\r\n\t\t\t\t\t" . 'location.reload();' . "\r\n\t\t\t\t" . '}else{' . "\r\n\t\t\t\t\t" . 'alert("[AO04] - An error occured.");' . "\r\n\t\t\t\t\t\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '})' . "\r\n\t" . '}' . "\r\n\r\n" . '</script>';

?>