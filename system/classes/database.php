<?php

class Database {


    public $host     = HOST;
    public $user     = USER;
    public $database = DATABASE;
    public $password = PASSWORD;


    protected function connect()
		{
			$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
			$pdo = new PDO($dsn, $this->user, $this->password);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $pdo;
		}

		public function conn()
		{
			$conn = mysqli_connect($this->host, $this->user, $this->password,$this->database);

			if (!$conn)
			{
			  die("Connection failed: " . mysqli_connect_error());
			}

			return $conn;
		}

}


?>
