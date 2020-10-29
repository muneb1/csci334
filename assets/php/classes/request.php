<?php
	// This is a class without implementing any pattern
	// This is Request class that store the requests from client
	// This class is 99% completed
	class Request{
		private $rid;
		private $subject;
		private $description;
		private $replies;
		private $status;
		private $createdBy;
		private $createdTime;
		private $assignedTo;
		private $assignedTime;
		private $completedTime;
		private $review;
		private $comment;
		private $reviewedTime;

		public function __construct($rid, $sub, $des, $cTime, $cBy, $stat, $aTime = null, $aTo = null, $comTime = null, $review = null, $com = null, $rTime = null) {
		   	$this->rid = $rid;
		   	$this->subject = $sub;
			$this->description = $des;
			$this->replies = array();
			$this->status = $stat;
			$this->createdBy = $cBy;
			$this->createdTime = $cTime;
			$this->assignedTo = $aTo;
			$this->assignedTime = $aTime;
			$this->review = $review;
			$this->comment = $com;
			$this->completedTime = $comTime;
			$this->reviewedTime = $rTime;
	  	}

	  	public function addReply($content, $time, $sentBy){
	  		$tempArr = array(
	  			"content"=>$content,
	  			"time"=>$time,
	  			"sentBy"=>$sentBy
	  		);
	  		array_push($this->replies, $tempArr);
	  	}
	}
?>