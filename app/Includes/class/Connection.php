<?php


class DBConnection
{
	private $host = DB_SERVER;
	private $username = DB_USERNAME;
	private $password = DB_PASSWORD;
	private $database = DB_NAME;
	public $conn = null;

	public function __construct()
	{
		if (!isset($this->conn)) {
			$this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
			$this->conn->set_charset('utf8mb4');

			if (!$this->conn) {
				echo 'Cannot connect to database server';
				exit();
			}
		}
	}

	public function __destruct()
	{
		$this->conn->close();
	}
}

if (!defined('DB_SERVER')) {
	include app_path('Includes/initialize.php');
}

?>