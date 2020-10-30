<?php
	date_default_timezone_set("Asia/Kuala_Lumpur");
	require "root.php";
	require "command.php";	
	// This is a class without implementing any pattern
	// This is a command list that store all the callable function, specially those need retrive data from db
	// This class needed to be amend later

	$action = "";
	if(isset($_GET["a"])){
		$action = $_GET["a"];
	}

	switch($action){
		case "login":
			$username = $_POST["username"];
			$password = $_POST["password"];
			$param = array($username,$password);

			$login_fn = new Login(ADTECH::getDB());
			$login_fn->setParam($param);
			echo $login_fn->execute();

			break;
		case "logout":
			$logout_fn = new Logout("/csci334");
			$logout_fn->execute();
			break;
		case "createRequest":
			if(isset($_SESSION["u_name"])){
				$title = $_POST["title"];
				$content = $_POST["content"];
				$cTime = date("Y-m-d H:i:s");

				$param = array(generateKey(3),$title,$content,$_SESSION["u_name"],$cTime,1);
				
				$create_fn = new createRequest(ADTECH::getDB());
				$create_fn->setParam($param);
				echo $create_fn->execute();
			}else{
				echo false;
			}
				
		case "test":
			echo generateKey(3);
	}

	function generateKey($size){
		
		$last_update = date("Ymd");

        $ramdomPool = "0123456789";
        $output = "";
        for($i = 0; $i < $size; $i++){
            $index = floor(rand(0,100) * strlen($ramdomPool) / 100);
            $output .= substr($ramdomPool,$index,1);
        }
        return (int)($last_update.$output);
    }

?>