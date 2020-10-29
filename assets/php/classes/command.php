<?php
	// This is a class without implementing any pattern
	// This is a command list that store all the callable function, specially those need retrive data from db
	// This class needed to be amend later
	require_once "build.php";
	$action = "";
	if(isset($_GET["a"])){
		$action = $_GET["a"];
	}

	switch($action){
		case "login":
			$username = $_POST["username"];
			$password = $_POST["password"];

			$sql = 'SELECT * FROM client WHERE (uid = "'.$username.'" OR u_email = "'.$username.'") AND u_pass = "'.$password.'" AND status = 1';
			$result = ADTECH::getDB()->query($sql);

			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()) {
					session_start();
					$_SESSION["u_name"] = $row["u_name"];
					echo json_encode( (object) array("0"=> true));
				}
			}else{
				echo json_encode( (object) array("0"=> false));
			}

			break;
		case "logout":
			session_start();
			session_destroy();
			header('Location: /csci334');
			break;
	}


	function is_ajax() {
	  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
?>