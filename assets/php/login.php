<?php
	if(is_ajax()){
		include "root/config.php";

		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = 'SELECT * FROM user WHERE (uid = "'.$username.'" OR u_email = "'.$username.'") AND u_pass = "'.$password.'" AND status = 1';
		$result = $mysqli->query($sql);

		if ($result->num_rows == 1) {
			while($row = $result->fetch_assoc()) {
				session_start();
				$_SESSION["u_name"] = $row["u_name"];
				echo json_encode( (object) array("0"=> true));
			}
		}else{
			echo json_encode( (object) array("0"=> false));
		}
	}

	function is_ajax() {
	  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
?>