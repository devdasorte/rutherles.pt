<?php
include app_path('Includes/settings.php');

class Login extends DBConnection
{
	private $settings = null;

	public function __construct()
	{global $_settings;
		if (!isset($_settings)) {
			$_settings = new System();
		}
		parent::__construct();
		ini_set('display_error', 1);
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	public function index()
	{
		echo '<h1>Access Denied</h1> <a href=\'' . BASE_URL . '\'>Go Back.</a>';
	}
	









public function logout(){
		if($this->settings->sess_des()){
			redirect('./admin/login.php');
		}
	}

	public function login_customer()
	{
		global $_settings;
		$this->settings = $_settings;

		$enable_password = $_settings->info('enable_password');
		$_POST['phone'] = preg_replace('/[^0-9]/', '', $_POST['phone']);
		extract($_POST);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		$stmt = $this->conn->prepare('SELECT * from customer_list where phone = ?');
		$stmt->bind_param('s', $phone);
		$stmt->execute();
		$result = $stmt->get_result();

		if (0 < $result->num_rows) {
			$res = $result->fetch_assoc();

			if ($enable_password == 1) {
				if (md5($password) !== $res['password']) {
					$resp['status'] = 'failed';
					$resp['msg'] = 'Incorrect Password';
				}
				else {
					foreach ($res as $k => $v) {
						$this->settings->set_userdata($k, $v);
					}

					$this->settings->set_userdata('login_type', 2);
					$resp['status'] = 'success';
				}
			}
			else if ($enable_password == 2) {
				foreach ($res as $k => $v) {
					$this->settings->set_userdata($k, $v);
				}

				$this->settings->set_userdata('login_type', 2);
				$resp['status'] = 'success';
			}
			else {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Invalid Login Configuration';
			}
		}
		else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Phone Number';
		}

		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}

		return json_encode($resp);
	}
	public function logout_customer()
	{
		global $_settings;
		if ($_settings->sess_des()) {
			$currentPath = $_SERVER['REQUEST_URI'];
			$redirect_url = '/';

			if ($currentPath == '/') {
				header('Location: /');
				exit();
			} else {
				header('Location: ' . $redirect_url);
				exit();
			}
		}
	}
}

$action = (!isset($_GET['action']) ? 'none' : strtolower($_GET['action']));
$auth = new Login();

switch ($action) {
case 'login':
	echo $auth->login();
	break;
case 'logout':
	echo $auth->logout();
	break;
case 'login_customer':
	echo $auth->login_customer();
	break;
case 'logout_customer':
	echo $auth->logout_customer();
	break;
	
	case 'chek_session':
	echo $auth->chek_session();
	break;
default:
	echo $auth->index();
	break;
}

?>