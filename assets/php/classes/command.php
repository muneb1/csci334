<?php
	// This is a class without implementing any pattern
	// This is a command list that store all the callable function, specially those need retrive data from db
	// This class needed to be amend later

	interface Command{
		public function execute();
		public function setParam($param);
	}

	class Login implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->sql = 'SELECT * FROM client WHERE (uid = "'.$param[0].'" OR u_email = "'.$param[0].'") AND u_pass = "'.$param[1].'" AND status = 1';
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);

			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()) {
					session_start();
					$_SESSION["u_name"] = $row["u_name"];
					return json_encode( (object) array("0"=> true));
				}
			}else{
				return json_encode( (object) array("0"=> false));
			}
		}
	}

	class Logout implements Command{
		private $path;

		public function __construct($path){
			$this->path = $path;
		}

		public function setParam($param){}

		public function execute(){
			session_start();
			session_destroy();
			header('Location: '. $this->path);
		}
	}

	class createRequest implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('INSERT INTO `request`(`rid`, `r_title`, `r_content`, `created_by`, `created_time`, `status`) VALUES (?,?,?,?,?,?)');
		}

		public function setParam($param){
			($this->stmt)->bind_param("isssssi", $param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return json_encode( (object) array("0"=> true));
			}else{
				($this->stmt)->close();
				return json_encode( (object) array("0"=> false));
			}
		}
	}


	function is_ajax() {
	  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
?>