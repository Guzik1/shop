<?php
	class User {
		const STATUS_USER = 1;
		const STATUS_ADMIN = 2;
		
		protected $userName;
		protected $passwd;
		protected $email;
		protected $date;
		protected $status;
		
		function __construct($userName, $email, $passwd){
			include "config.php";

			$this->status = User::STATUS_USER;
			$this->userName = $userName;
			$this->email = $email;
			$this->date = new DateTime();
			$this->passwd = hash_hmac('sha256', $passwd , $hash_key);
		}

		function show() {
			echo "Użytkownik: " . $this->userName . ", email: " . $this->email . ", status: " . ($this->status == User::STATUS_USER ? "użytkownik" : "admin") . "<br />";
		}
		
		function toArray(){
			$array = array(
				"userName" => $this->userName,
				"passwd" => $this->passwd,
				"email" => $this->email,
				"date" => $this->date->format("Y-m-d"),
				"status" => $this->status
			);
			
			return $array;
		}

		function saveToDB($db){
			$sql = "SELECT EXISTS(SELECT * FROM users WHERE userName='" . $this->userName . "') AS exist";
			
			$result = $db->select($sql);
			if($result["exist"]){
				echo "Używtkownik jest już zarejestrowany!<br />";
				return;
			}
			
			$data = $this->toArray();

			$sql = "INSERT INTO `users` (`userName`, `email`, `passwd`, `status`, `date`) VALUES ('";
			$sql .= $data["userName"] . "', '" . $data["email"] . "', '" 
					. $data["passwd"] . "', '" . $data["status"] . "', '" . $data["date"] . "')";
			
			if($db->insert($sql))
				echo "Rejestracja powiodła się<br />";
			else
				echo "Rejestracja nie powiodła się!<br />";
		}

		/*static function getAllUserFromDB($db){
			return $db->selectAndFormat('SELECT userName, fullName, DATE_FORMAT(date, "%Y-%m-%d") AS "date"  FROM users', 
							array("userName", "fullName", "date"));
		}*/
	}
?>