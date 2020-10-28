<?php
	//This is the notifier class that implement 
	class Notifier{
		private $subscribers;

		public function __construct() {
		   	$this->subscribers = array();
	  	}

	  	public function addSubscriber($person){
	  		array_push($this->subscribers, $person);
	  	}

	  	public function removeSubscriber($person){
	  		$tempID = ""
	  		foreach ($this->subscribers as $key => $user) {
	  			if($user->getID() == $person->getID()){
	  				unset($this->subscribers[$key]);
	  			}
	  		}
	  	}

		public function nofityAll(){
			//notify all user
		}

		public function nofityUser($person){
			//notify single user
		}
	}
?>