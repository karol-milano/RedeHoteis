<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$str = getenv("JAWSDB_URL");
			if ($str == false) {
				$str = "mysql://root:@localhost:3306/redehoteis";
			}

			$url = parse_url($str);

			$host = $url["host"];
			$username = $url["user"];
			$password = $url["pass"];
			$database = substr($url["path"], 1);


			$conn = new \PDO(
				"mysql:host=" . $host . ";dbname=" . $database . ";charset=utf8",
				$username,
				$password 
			);

			$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );  
			$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );  

			return $conn;

		} catch (\PDOException $e) {
			
			echo 'Não ocorreu a conexão com o banco';
			print_r($e->getTrace());
		}
	}
}