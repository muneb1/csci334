<?php
	//These are the classes that implement Factory Pattern
	//This class needed to be amend later

	//system user interface class
	interface User {
	  public function getPermissionID():string;
	}

	//A person have the ability that system user can do
	abstract class Person implements User{
	  protected $userID;
	  protected $email;
	  protected $contact;
	  protected $position;

	  public function __construct($userID, $email, $contact) {
	    $this->userID = $userID;
	    $this->email = $email;
	    $this->contact = $contact;
	  }

	  public function getID(){
	  	return $this->userID;
	  }

	  abstract public function getPermissionID():string;
	  abstract public function getData():array;

	}

	//IT technician
	class CEO extends Person{
		private $first_name;
		private $last_name;

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		 }

		public function getPermissionID():string{
			return 1;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>"CEO"
			);
		}
	}

	//IT technician
	class Manager extends Person{
		
		private $first_name;
		private $last_name;

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		 }

		public function getPermissionID():string{
			return 2;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>"Manager"
			);
		}
	}

	//IT technician
	class IT_Tech extends Person{
		
		private $first_name;
		private $last_name;

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		 }

		public function getPermissionID():string{
			return 3;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>"IT Technician"
			);
		}
	}

?>