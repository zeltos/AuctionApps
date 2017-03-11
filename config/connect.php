<?php
class DBconnect {
	public $user_name;
	public $password;
	public $database;
	public $host_name;

	public function connect() {
		$this->user_name = "root";
		$this->password = "";
		$this->database = "auction_db";
		$this->host_name = "localhost";

		$connect_db=mysql_connect($this->host_name, $this->user_name, $this->password);

		$find_db=mysql_select_db($this->database);

		if (!$find_db) {
		 echo "Cannot connect to Database";
		} else {
			echo "<script>console.log('Successfuly Connect to Database');</script>";
		}

	}
}

$DBconnect = new DBconnect();
$DBconnect->connect();


?>
