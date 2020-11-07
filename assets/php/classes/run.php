<?php
	date_default_timezone_set("Asia/Kuala_Lumpur");
	require_once "root.php";
	require_once "command.php";	
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
			$pos = $_POST["position"];
			$param = array($username,$password,$pos);

			$login_fn = new Login(ADTECH::getDB());
			$login_fn->setParam($param);
			echo $login_fn->execute();

			break;
		case "logout":
			if(isset($_GET["p"]) && $_GET["p"] == "admin"){
				$logout_fn = new Logout("/csci334/admin/login.php");
			}else{
				$logout_fn = new Logout("/csci334");
			}
			$logout_fn->execute();
			break;
		case "createRequest":
			session_start();
			if(isset($_SESSION["uid"])){
				$title = $_POST["subject"];
				$content = $_POST["content"];
				$cTime = date("Y-m-d H:i:s");
				$rid = generateKey(3);

				$param = array($rid,$title,$content,$_SESSION["uid"],$cTime,1);
				
				$create_fn = new createRequest(ADTECH::getDB());
				$create_fn->setParam($param);
				$result = $create_fn->execute();
				echo $result;

				$getClient = new getUser(ADTECH::getDB());
				$param_temp = array(1,$_SESSION["uid"]);
				$getClient->setParam($param_temp);
				$clientDetails = $getClient->execute();

				if(sizeof($clientDetails) > 0){
					//create notification
					$createNoti = new createNotification(ADTECH::getDB());
					$nofi_param = array($rid."create",null,2,"New Request",$clientDetails[0]['company']." submit a new request");
					$createNoti->setParam($nofi_param);
					$createNoti->execute();
				}

				
			}else{
				echo false;
			}
			break;
		case "getResHistory":
			session_start();
			if(isset($_SESSION["uid"])){
				$resHis = new RequestHistory(ADTECH::getDB());
				$resHis->setParam([$_SESSION["uid"]]);
				echo $resHis->execute();
			}else{
				echo false;
			}
			break;
		case "getReplies":
			$getReply = new getReply(ADTECH::getDB());
			$getReply->setParam([$_POST["rid"]]);
			echo $getReply->execute();

			break;
		case "assignStaff":
			$sid = $_POST["sid"];
			$rid = $_POST["rid"];

			$aTime = date("Y-m-d H:i:s");
			$assign = new assignStaff(ADTECH::getDB());
			$param = array($aTime,$sid, $rid);
			$assign->setParam($param);

			if($assign->execute() == true){
				//get Staff Details
				$getUser = new getUser(ADTECH::getDB());
				$user_param = array(0,$sid);
				$getUser->setParam($user_param);
				$userDetails = $getUser->execute();

				$content = $userDetails[0]["fname"]." had assigned to help you";
				$addReply = new addReply(ADTECH::getDB());
				$reply_param = array($rid,$content,NULL);
				$addReply->setParam($reply_param);
				echo $addReply->execute();

				//create notification
				$createNoti = new createNotification(ADTECH::getDB());
				$nofi_param = array($rid."assign",$sid,null,"New Request","Request (".$rid.") assigned to you");
				$createNoti->setParam($nofi_param);
				$createNoti->execute();
			}else{
				echo json_encode( (object) array("0"=> false));
			}
			break;
		case "getStaffList":
			$getStaff = new getStaffList(ADTECH::getDB());
			echo $getStaff->execute();
			break;
		case "addReply":
			$rid = $_POST["rid"];
			$content = $_POST["content"];
			$uid = $_POST["uid"];

			$addReply = new addReply(ADTECH::getDB());
			$reply_param = array($rid,$content,$uid);
			$addReply->setParam($reply_param);
			$result = $addReply->execute();
			echo $result;

			if(json_decode($result)->{"0"} == true){
				$uTime = date("Y-m-d H:i:s");
				$requestUpdate = new updateRequest(ADTECH::getDB());
				$update_param = array($uTime,$rid);
				$requestUpdate->setParam($update_param);
				$requestUpdate->execute();
			}
			break;
		case "updateStatus":
			$rid = $_POST["rid"];
			$sid = $_POST["sid"];
			$clock = $_POST["clock"];
			
			$staffClock = new staffClock(ADTECH::getDB());
			if($clock == "in"){
				$param = array($rid,$sid);
			}else{
				$sessid = $_POST["sessid"];
				$clockOut = date("Y-m-d H:i:s");
				$param = array($clockOut,$rid,$sessid);
			}
			$staffClock->setParam($param);
			$result = $staffClock->execute();
			echo $result;

			if(json_decode($result)[0] == true){
				$uTime = date("Y-m-d H:i:s");
				$requestUpdate = new updateRequest(ADTECH::getDB());
				if($clock == "in")
					$update_param = array(3,$rid);
				else if($clock == "out")
					$update_param = array(4,$rid);
				else if($clock == "done")
					$update_param = array(5,$rid);
				$requestUpdate->setParam($update_param);
				$requestUpdate->execute();
			}
			break;
		case "completeStatus":
			$rid = $_POST["rid"];
			$cTime = date("Y-m-d H:i:s");

			$comStatus = new completeRequest(ADTECH::getDB());
			$param = array($cTime,$rid);
			$comStatus->setParam($param);
			echo $comStatus->execute();

			$getReq = new getRequest(ADTECH::getDB());
			$param_temp = array("",$rid);
			$getReq->setParam($param_temp);
			$reqDatails = $getReq->execute();

			$reqData = json_decode($reqDatails)->{"1"}[0];

			//create notification
			$createNoti = new createNotification(ADTECH::getDB());
			$nofi_param = array($rid."complete",null,2,"Request Completed","Request (".$reqData->{"rid"}.") completed by ".$reqData->{"assignedTo"});
			$createNoti->setParam($nofi_param);
			$createNoti->execute();
			break;
		case "addStaff":
			$rid = $_POST["rid"];
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$contact = $_POST["contact"];
			$email = $_POST["email"];
			$pass = $_POST["pass"];
			$pos = $_POST["pos"];

			$addStaff = new addStaff(ADTECH::getDB());
			$param = array($rid,$fname,$lname,$contact,$email,$pass,$pos);
			$addStaff->setParam($param);
			echo $addStaff->execute();
			break;
		case "submitReview":
			$rid = $_POST["rid"];
			$star = $_POST["star"];
			$comment = $_POST["comment"];
			$rTime = date("Y-m-d H:i:s");

			$submitReview = new submitReview(ADTECH::getDB());
			$param = array($star,$comment,$rTime,$rid);
			$submitReview->setParam($param);
			echo $submitReview->execute();
			break;
		case "getStaffDetails":
			$getDetails = new getStaffDetails(ADTECH::getDB());
			echo json_encode($getDetails->execute()) ;
			break;
		case "reviewedRequset":
			$status = $_POST["status"];
			$filterReq = new filterRequest(ADTECH::getDB());
			$param = array($status);
			$filterReq->setParam($param);
			echo json_encode($filterReq->execute()) ;
			break;
		case "getNotification":
			$getNoti = new getNotification(ADTECH::getDB());
			$param = array($_POST["uid"],$_POST["pos"]);
			$getNoti->setParam($param);
			echo $getNoti->execute();
			break;
		case "readNoti":
			$readNoti = new readNotification(ADTECH::getDB());
			$param = array($_POST["nid"]);
			$readNoti->setParam($param);
			echo $readNoti->execute();
			break;
		case "createNoti":
			$createNoti = new readNotification(ADTECH::getDB());
			$param = array($_POST["nid"],$_POST["uid"],$_POST["pos"],$_POST["title"],$_POST["content"]);
			$createNoti->setParam($param);
			echo $createNoti->execute();
			break;
		case "getOvertime":
			$overtimeCal = new getOverTime(ADTECH::getDB());
			//$param = array($_POST["sid"],false,true);
			$param = array('dexter',false,true);
			$overtimeCal->setParam($param);
			echo json_encode($overtimeCal->execute());
			break;
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