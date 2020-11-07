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
			if($param[2] == "staff"){
				$this->sql = 'SELECT * FROM `credential` JOIN `staff` on credential.uid = staff.sid WHERE (uid = "'.$param[0].'" OR u_email = "'.$param[0].'") AND u_pass = "'.$param[1].'" AND active = 1';
			}else{
				$this->sql = 'SELECT * FROM `credential` JOIN `client` on credential.uid = client.cid WHERE (uid = "'.$param[0].'" OR u_email = "'.$param[0].'") AND u_pass = "'.$param[1].'" AND active = 1';
			}
			
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);

			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()) {
					session_start();
					$_SESSION["uid"] = $row["uid"];
					$_SESSION["groupID"] = $row["user_group"];
					return json_encode( (object) array("0"=> true, "1"=>$row["position"]));
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
			($this->stmt)->bind_param("issssi", $param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);
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

	class RequestHistory implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->sql = 'SELECT rid, r_title, created_time, IFNULL(completed_time,\'-\') as comTime, updated_time, status FROM `request` WHERE created_by = \''.$param[0].'\' AND status > 0 ORDER BY updated_time DESC';
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"rid"=>$row["rid"],
						"subject"=>$row["r_title"],
						"createdDate"=>$row["created_time"],
						"updatedDate"=>$row["updated_time"],
						"completedDate"=>$row["comTime"],
						"status"=>$row["status"]
					));
				}
			}else{
				return json_encode( (object) array("0"=> false));
			}
			return json_encode( (object) array("0"=> true, "1"=>$result_arr));
		}
	}

	class getRequest implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			if($param[0] == ""){
				$this->sql = 'SELECT rid,r_title,r_content,created_time,assigned_time,completed_time,s_fname,s_lname,request.status,review,comment,reviewed_time FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` WHERE rid = \''.$param[1].'\'';
			}else{
				$this->sql = 'SELECT rid,r_title,r_content,created_time,assigned_time,completed_time,s_fname,s_lname,request.status,review,comment,reviewed_time FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` WHERE created_by = \''.$param[0].'\' AND rid = \''.$param[1].'\'';
			}
			
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"rid"=>$row["rid"],
						"subject"=>$row["r_title"],
						"description"=>$row["r_content"],
						"createdDate"=>$row["created_time"],
						"assignedDate"=>$row["assigned_time"],
						"assignedTo"=>$row["s_fname"],
						"completedDate"=>$row["completed_time"],
						"status"=>$row["status"],
						"review"=>$row["review"],
						"comment"=>$row["comment"],
						"reviewedDate"=>$row["reviewed_time"]
					));
				}
			}else{
				return json_encode( (object) array("0"=> false));
			}
			return json_encode( (object) array("0"=> true, "1"=>$result_arr));
		}
	}

	class filterRequest implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$filter = "";
			if(sizeof($param) > 1){
				$filter = ' AND assigned_to = \'' . $param[1] . '\'';
			}
			if($param[0] == "all"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status > 0' . $filter . ' ORDER BY updated_time DESC';
			}else if($param[0] == "new"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status >= 1 AND status <= 2' . $filter . ' ORDER BY updated_time DESC';
			}else if($param[0] == "ongoing"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status >= 3 AND status <= 4' . $filter . ' ORDER BY updated_time DESC';
			}else if($param[0] == "completed"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status = 5' . $filter . ' ORDER BY updated_time DESC';
			}else if($param[0] == "reviewed"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status = 6' . $filter . ' ORDER BY updated_time DESC';
			}else if($param[0] == "overdue"){
				$this->sql = 'SELECT * FROM `request` LEFT JOIN `staff` on `request`.`assigned_to` = `staff`.`sid` LEFT JOIN `client` on `client`.`cid` = `request`.`created_by` WHERE status >= 2 AND status <= 4' . $filter . ' ORDER BY updated_time DESC';
			}
			
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"rid"=>$row["rid"],
						"subject"=>$row["r_title"],
						"content"=>$row["r_content"],
						"createdDate"=>$row["created_time"],
						"createdBy"=>$row["c_company"],
						"assignedDate"=>$row["assigned_time"],
						"assignedTo"=>$row["s_fname"],
						"completedDate"=>$row["completed_time"],
						"updateDate"=>$row["updated_time"],
						"status"=>$row["status"],
						"review"=>$row["review"],
						"comment"=>$row["comment"],
						"reviewedDate"=>$row["reviewed_time"]
					));
				}
			}else{
				return $result_arr;
			}
			return $result_arr;
		}
	}

	class getReply implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->sql = 'SELECT * FROM `replies` left JOIN `credential` on `replies`.`created_by` = `credential`.`uid` WHERE replies.request_id = \''.$param[0].'\'';
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"creator"=>$row["created_by"],
						"content"=>$row["content"],
						"createdTime"=>$row["created_time"],
						"groupping"=>$row["user_group"]
					));
				}
			}else{
				return json_encode(  array("0"=> false));
			}
			return json_encode( array("0"=> true, "1"=>$result_arr));
		}
	}

	class getUser implements Command{
		private $sql;
		private $db;
		private $pos;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->pos = (int)$param[0];
			if($this->pos == 0){
				//staff
				$this->sql = 'SELECT * FROM `staff` join `credential` on staff.sid = credential.uid where credential.status = 1 AND credential.uid = \''.$param[1].'\'';
			}else{
				//client
				$this->sql = 'SELECT * FROM `client` join `credential` on client.cid = credential.uid where credential.status = 1 AND credential.uid = \''.$param[1].'\'';
			}
			
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()) {
					if($this->pos == 0){
						//staff
						array_push($result_arr, array(
							"id"=>$row["sid"],
							"fname"=>$row["s_fname"],
							"lname"=>$row["s_lname"],
							"email"=>$row["u_email"],
							"contact"=>$row["s_contact"],
							"pos"=>(int)$row["position"]
						));
					}else{
						//client
						array_push($result_arr, array(
							"id"=>$row["cid"],
							"name"=>$row["c_name"],
							"email"=>$row["u_email"],
							"contact"=>$row["c_contact"],
							"company"=>$row["c_company"],
							"pos"=>4
						));
					}
					
				}
			}

			return $result_arr;
		}
	}

	class assignStaff implements Command{
		private $sql;
		private $db;
		private $stmt;
		private $sstmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('UPDATE `request` SET `assigned_time`=?,`assigned_to`=?, `status`=2 WHERE `rid` = ?');
			$this->sstmt = ($this->db)->prepare('INSERT INTO `assignhistory`(`rid`, `sid`) VALUES (?,?)');
		}

		public function setParam($param){
			($this->sstmt)->bind_param("ss", $param[2], $param[1]);
			($this->stmt)->bind_param("sss", $param[0], $param[1], $param[2]);
		}

		public function execute(){
			($this->stmt)->execute();
			($this->sstmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

	class addReply implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('INSERT INTO `replies`(`request_id`, `content`, `created_by`) VALUES (?,?,?)');
		}

		public function setParam($param){
			($this->stmt)->bind_param("sss", $param[0], $param[1], $param[2]);
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

	class updateRequest implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			
		}

		public function setParam($param){
			if(gettype($param[0]) == "int" || gettype($param[0]) == "integer"){
				$this->stmt = ($this->db)->prepare('UPDATE `request` SET `status`=? WHERE `rid` = ?');
				($this->stmt)->bind_param("is", $param[0], $param[1]);
			}else{
				$this->stmt = ($this->db)->prepare('UPDATE `request` SET `updated_time`=? WHERE `rid` = ?');
				($this->stmt)->bind_param("ss", $param[0], $param[1]);
			}
			
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

	class completeRequest implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('UPDATE `request` SET `status`= 5, `completed_time` = ? WHERE `rid` = ?');
		}

		public function setParam($param){
			($this->stmt)->bind_param("ss", $param[0],$param[1]);
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

	class getStaffList implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "select sid, s_fname, s_lname, COALESCE(sub.feq,0) as feq from `staff` left JOIN (select assigned_to, COUNT(assigned_to) as feq from `request` JOIN `staff` ON `request`.`assigned_to` = `staff`.`sid` WHERE status >= 2 AND status <= 4 GROUP BY assigned_to) as sub ON `staff`.`sid` = sub.assigned_to WHERE position = 3 ORDER BY feq";
			$this->db = $mysqli;
		}

		public function setParam($param){}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"sid"=>$row["sid"],
						"name"=>$row["s_fname"]." ".$row["s_lname"],
						"freq"=>$row["feq"]
					));				
				}
			}else{
				return json_encode(  array("0"=> false));
			}
			return json_encode( array("0"=> true, "1"=>$result_arr));
		}
	}

	class staffClock implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			if(sizeof($param) == 2){
				$this->stmt = ($this->db)->prepare('INSERT INTO `service_session`(`requestID`, `staff_id`) VALUES (?,?)');
				($this->stmt)->bind_param("ss", $param[0], $param[1]);
			}else{
				$this->stmt = ($this->db)->prepare('UPDATE `service_session` SET `endTime`=? WHERE `requestID` = ? AND `session_id` = ?');
				($this->stmt)->bind_param("sss", $param[0], $param[1], $param[2]);
			}
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				$lastID = ($this->stmt)->insert_id;
				($this->stmt)->close();
				return json_encode( array("0"=> true, "1"=>$lastID));
			}else{
				($this->stmt)->close();
				return json_encode(array("0"=> false));
			}		
		}
	}

	class addStaff implements Command{
		private $sql;
		private $db;
		private $stmt;
		private $sstmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('INSERT INTO `credential`(`uid`, `u_email`, `u_pass`, `user_group`, `status`) VALUES (?,?,?,?,?)');
			$this->sstmt = ($this->db)->prepare('INSERT INTO `staff`(`sid`, `s_fname`, `s_lname`, `s_contact`, `position`, `active`) VALUES (?,?,?,?,?,?)');
		}

		public function setParam($param){
			$status = 1;
			$group = 0;
			($this->stmt)->bind_param("sssii", $param[0], $param[4], $param[5], $group, $status);
			($this->sstmt)->bind_param("ssssii", $param[0], $param[1], $param[2], $param[3], $param[6], $status);
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				($this->sstmt)->execute();
				if(($this->sstmt)->affected_rows == 1){
					($this->sstmt)->close();
					return json_encode( array("0"=> true));
				}else{
					($this->sstmt)->close();
					return json_encode(array("0"=> false));
				}	
			}else{
				($this->stmt)->close();
				return json_encode(array("0"=> false));
			}		
		}
	}

	class getOverTime implements Command{
		private $sql;
		private $db;
		private $calSum;
		private $sid;
		private $byDay;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
			$this->calSum = false;
			$this->byDay = false;
		}

		public function setParam($param){
			$this->sql = 'SELECT * FROM `service_session` WHERE staff_id = \''.$param[0].'\' ORDER BY `startTime`';
			if(sizeof($param) == 3){
				$this->byDay = $param[2];
				$this->calSum = $param[1];
				$this->sid = $param[0];
			}else if(sizeof($param) == 2){
				$this->calSum = $param[1];
				$this->sid = $param[0];
			} 
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();

			if ($result->num_rows >= 1) {
				$ttl = 0;
				$byday_arr = array();
				while($row = $result->fetch_assoc()) {

					$clockIn = $this->adjClockIn($row["startTime"]);
					$clockOut = $this->adjClockOut($row["endTime"]);

					
					$overtime = $this->getOverTime($clockIn,$clockOut);

					if($overtime > 0){
						$overtime -= $this->calDiff($row["startTime"],$row["endTime"]);

						if($this->calSum){
							$ttl += $overtime;
						}else if($this->byDay){
							$date = date("y-m-d",strtotime($row["startTime"]));

							//before
							$found;
							$this->checkexist($byday_arr,$date,$found);
							if($found){
								$byday_arr[$date] += (int) $overtime;
							}else{
								$byday_arr[$date] = (int) $overtime;
							}

							//after
							$found = $this->checkexist($byday_arr,$date);
							if($found){
								$byday_arr[$date] += (int) $overtime;
							}else{
								$byday_arr[$date] = (int) $overtime;
							}


						}else{
							array_push($result_arr, array(
								"sTime"=>$row["startTime"],
								"eTime"=>$row["endTime"],
								"seconds"=>$overtime,
								"hours"=>$this->secToHR($overtime)
							));
						}	
					}		
				}
				if($this->calSum){
					array_push($result_arr, array(
						"sid"=>$this->sid,
						"total"=>$ttl
					));
					return $result_arr;
				}

				if($this->byDay){
					foreach ($byday_arr as $key => $value) {
						array_push($result_arr, array(
							"date"=>$key,
							"second"=>$value,
							"hours"=>secToHR($overtime)
						));
					}
					return $result_arr;
				}
			}else{
				if($this->calSum){
					array_push($result_arr, array(
						"sid"=>$this->sid,
						"total"=>0
					));
					return $result_arr;
				}
			}

			return $result_arr;
		}

		//after
		private function checkexist($array,$key){
			foreach ($array as $arr_key => $value) {
				if($arr_key == $key){
					return true;
				}
			}
			return false;
		}

		//before
		private function checkexist($array,$key,&$found){
			$found = false;
			foreach ($array as $arr_key => $value) {
				if($arr_key == $key){
					$found = true;
				}
			}
		}

		private function adjClockIn($clockIn){
			$date_In = strtotime($clockIn);
			$dayClockIn = strtotime(date("Y-m-d", $date_In)."9am");
			$dayClockOut = strtotime(date("Y-m-d", $date_In)."6pm");
			if($date_In - $dayClockIn > 0 && $date_In - $dayClockOut < 0){
				return $dayClockOut;
			}else{
				return $date_In;
			}

		}

		private function adjClockOut($clockOut){
			$date_Out = strtotime($clockOut);
			$dayClockIn = strtotime(date("Y-m-d", $date_Out)."9am");
			$dayClockOut = strtotime(date("Y-m-d", $date_Out)."6pm");
			if($date_Out - $dayClockIn > 0 && $date_Out - $dayClockOut < 0){
				return $dayClockIn;
			}else{
				return $date_Out;
			}
		}

		private function getOverTime($clockIn,$clockOut){
			if(($clockOut - $clockIn) <= 0){
				return 0;
			}else{
				return $clockOut - $clockIn;
			}
		}

		private function calDiff($clockIn,$clockOut){

			$date_In = strtotime($clockIn);
			$date_Out = strtotime($clockOut);
			$dayClockIn = strtotime(date("Y-m-d", $date_In)."9am");
			$dayClockOut = strtotime(date("Y-m-d", $date_Out)."6pm");

			if($date_In - $dayClockIn < 0){
				$dateStart = date("Y-m-d", $date_In);
			}else{
				$dateStart = date("Y-m-d", strtotime("+1 day", $date_In));
			}

			if($date_Out - $dayClockOut > 0){
				$dateEnd = date("Y-m-d", strtotime("+1 day", $date_Out));
			}else{
				$dateEnd = date("Y-m-d", $date_Out);
			}

			$diff = strtotime($dateEnd) - strtotime($dateStart);
			return ceil($diff/86400) * 32400;
		}

		private function secToHR($seconds) {
		  $hours = floor($seconds / 3600);
		  $minutes = floor(($seconds / 60) % 60);

		  if($hours > 1){
		  	$hours = $hours . " hours";
		  }else if($hours <= 0){
		  	$hours = "";
		  }else{
		  	$hours = $hours;
		  }
		  if($minutes > 1){
		  	$minutes = $minutes . " minutes";
		  }else{
		  	$minutes = $minutes . " minute";
		  }
			return $hours . " " . $minutes;
		}
	}

	class getStaffDetails implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "SELECT staff.sid, staff.s_fname, staff.s_lname, staff.s_contact, credential.u_email, COALESCE(ttlAss.assigned,0) as assigned,COALESCE(ttlgo.ongoing,0) as ongoing,COALESCE(ttlCom.completed,0) as completed FROM `staff` JOIN `credential` on `staff`.`sid` = `credential`.`uid` LEFT JOIN (SELECT `assignhistory`.`sid`, COUNT(`assignhistory`.`sid`) as assigned FROM `assignhistory` GROUP BY `assignhistory`.`sid`) as ttlAss ON `staff`.`sid` = ttlAss.sid LEFT JOIN (SELECT assigned_to, COUNT(assigned_to) as ongoing FROM `request` WHERE status >= 2 AND status <= 4 GROUP BY assigned_to) as ttlgo ON `staff`.`sid` = ttlgo.assigned_to LEFT JOIN (SELECT assigned_to, COUNT(assigned_to) as completed FROM `request` WHERE status = 5 OR status = 6 GROUP BY assigned_to) as ttlCom ON `staff`.`sid` = ttlCom.assigned_to WHERE position = 3 AND active = 1";
			$this->db = $mysqli;
		}

		public function setParam($param){}

		public function execute(){
			$overtimeCal = new getOverTime(ADTECH::getDB());

			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					$param = array($row["sid"],true);
					$overtimeCal->setParam($param);
					$overtime = $overtimeCal->execute()[0]["total"];
					array_push($result_arr, array(
						"sid"=>$row["sid"],
						"fname"=>$row["s_fname"],
						"lname"=>$row["s_lname"],
						"contact"=>$row["s_contact"],
						"email"=>$row["u_email"],
						"assigned"=>$row["assigned"],
						"ongoing"=>$row["ongoing"],
						"completed"=>$row["completed"],
						"overtime"=>$overtime,
						"overtimehr"=>$this->secToHR($overtime)
					));				
				}
			}
			return $result_arr;
		}

		private function secToHR($seconds) {
		  $hours = floor($seconds / 3600);
		  $minutes = floor(($seconds / 60) % 60);
		  if($hours > 1){
		  	$hours = $hours . " hours";
		  }else if($hours <= 0){
		  	$hours = "";
		  }else{
		  	$hours = $hours . " hour";
		  }
		  if($minutes > 1){
		  	$minutes = $minutes . " minutes";
		  }else{
		  	$minutes = $minutes . " minute";
		  }
			return $hours . " " . $minutes;
		}
	}

	class submitReview implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('UPDATE `request` SET `status`=6,`review`=?,`comment`=?,`reviewed_time`=? WHERE `rid` = ?');
		}

		public function setParam($param){
			($this->stmt)->bind_param("isss", $param[0], $param[1], $param[2], $param[3]);
			
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

	class getSummary implements Command{
		private $sql;
		private $db;
		private $status;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->status = $param[0];
			if($param[0] == "new"){
				$this->sql = 'SELECT COALESCE(COUNT(rid),0) as count FROM `request` WHERE status = 1';
			}else if($param[0] == "ongoing"){
				$this->sql = 'SELECT COALESCE(COUNT(rid),0) as count FROM `request` WHERE status >= 2 AND status <= 4';
			}else if($param[0] == "completed"){
				$this->sql = 'SELECT COALESCE(COUNT(rid),0) as count FROM `request` WHERE status >= 5 AND status <= 6';
			}else if($param[0] == "avgTime"){
				$this->sql = 'SELECT rid,TIMESTAMPDIFF(second,created_time, completed_time) AS diff FROM `request` WHERE completed_time is not NULL';
			}
			
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			if ($result->num_rows == 1 && $this->status != "avgTime") {
				while($row = $result->fetch_assoc()) {
					array_push($result_arr, array(
						"status"=>$this->status,
						"count"=>$row["count"]
					));
				}
			}else if($result->num_rows >= 1 && $this->status == "avgTime"){
				$total = 0;
				while($row = $result->fetch_assoc()) {
					$total += (int) $row["diff"];
				}
				$total /= $result->num_rows;
				array_push($result_arr, array(
					"status"=>$this->status,
					"count"=> $this->secToHR(floor($total))
				));
			}
			return $result_arr;
		}

		private function secToHR($seconds) {
		  $hours = floor($seconds / 3600);
		  $minutes = floor(($seconds / 60) % 60);
		  if($hours > 1){
		  	$hours = $hours . " hours";
		  }else if($hours <= 0){
		  	$hours = "";
		  }else{
		  	$hours = $hours . " hour";
		  }
		  if($minutes > 1){
		  	$minutes = $minutes . " minutes";
		  }else{
		  	$minutes = $minutes . " minute";
		  }
			return $hours . " " . $minutes;
		}
	}

	class getNotification implements Command{
		private $sql;
		private $db;

		public function __construct($mysqli){
			$this->sql = "";
			$this->db = $mysqli;
		}

		public function setParam($param){
			$this->sql = 'SELECT * FROM `notification` WHERE `uid` = "'.$param[0].'" OR `pos` = "'.$param[1].'" ORDER BY `status`, `created_time` DESC';
		}

		public function execute(){
			$result = ($this->db)->query($this->sql);
			$result_arr = array();
			$unread = 0;
			if ($result->num_rows >= 1) {
				while($row = $result->fetch_assoc()) {
					$cdate = strtotime($row["created_time"]);
					$curDate = strtotime(date("y-m-d H:i:s"));
					$dur = "";
					if($curDate - $cdate <= 5){
						$dur = "Now";
					}else if($curDate - $cdate <= 60){
						$dur = $curDate - $cdate . " sec ago";
					}else if($curDate - $cdate <= 86400){
						$dur = $this->getMinutes($curDate - $cdate);
					}else{
						$dur = $this->getDays($curDate - $cdate);
					}

					if($row["status"] == 0){
						$unread += 1;
					}

					array_push($result_arr, array(
						"nid"=>$row["nid"],
						"title"=>$row["title"],
						"content"=>$row["content"],
						"date"=>$dur,
						"read"=>$row["status"]
					));
				}
			}else{
				return json_encode(  array("0"=> false));
			}
			return json_encode( array("0"=> true, "1"=>$result_arr, "2"=>$unread));
		}

		private function getMinutes($seconds){
			$hours = floor($seconds / 3600);
		  	$minutes = floor(($seconds / 60) % 60);

		  if($hours > 1){
		  	$hours = $hours . " hrs";
		  }else if($hours <= 0){
		  	$hours = "";
		  }else{
		  	$hours = $hours . " hr";
		  }
		  if($minutes > 1){
		  	$minutes = $minutes . " mins";
		  }else{
		  	$minutes = $minutes . " min";
		  }
			return $hours . " " . $minutes . " ago";
		}

		private function getDays($second){
			return floor($second/86400) . "day(s) ago";
		}
	}

	class readNotification implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			$this->stmt = ($this->db)->prepare('UPDATE `notification` SET `status`= 1 WHERE `nid` = ?');
		}

		public function setParam($param){
			($this->stmt)->bind_param("s", $param[0]);
			
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

	class createNotification implements Command{
		private $sql;
		private $db;
		private $stmt;

		public function __construct($mysqli){
			$this->db = $mysqli;
			
		}

		public function setParam($param){
			if(sizeof($param) == 5){
				$this->stmt = ($this->db)->prepare('INSERT INTO `notification`(`nid`, `uid`, `pos`, `title`, `content`) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE `status` = 0');
				($this->stmt)->bind_param("ssiss", $param[0],$param[1],$param[2],$param[3],$param[4]);
			}else{
				$this->stmt = ($this->db)->prepare('INSERT INTO `notification`(`nid`, `uid`, `pos`, `title`, `content`) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE `status` = 0, `created_time` = ?');
				$today = date("y-m-d H:i:s");
				($this->stmt)->bind_param("ssiss", $param[0],$param[1],$param[2],$param[3],$param[4],$today);
			}
			
			
		}

		public function execute(){
			($this->stmt)->execute();

			if(($this->stmt)->affected_rows == 1){
				($this->stmt)->close();
				return true;
			}else{
				($this->stmt)->close();
				return false;
			}
		}
	}

?>