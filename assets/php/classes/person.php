<?php
	require_once 'root.php';
	require_once 'command.php';
	//These are the classes that implement Factory Pattern
	//This class needed to be amend later

	//system user interface class
	abstract class User {
		protected $userID;
		protected $email;
		protected $contact;

		abstract function getPermissionID():string;
		abstract function getData():array;		
	}

	abstract class Staff extends User{
		private $fname;
		private $lname;
		private $position;
	}

	abstract class Client extends User{
		private $name;
		private $company;
	}

	//IT technician
	class CEO extends Staff{

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->fname = $fname;
		    $this->lname = $lname;
		    $this->position = "CEO";
		 }

		public function getPermissionID():string{
			return 1;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->fname,
				"lname"=>$this->lname,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>$this->position
			);
		}
	}

	//IT technician
	class Manager extends Staff{

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->fname = $fname;
		    $this->lname = $lname;
		    $this->position = "Manager";
		    
		 }

		public function getPermissionID():string{
			return 2;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->fname,
				"lname"=>$this->lname,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>$this->position
			);
		}
	}

	//IT technician
	class IT_Tech extends Staff{

		public function __construct($userID, $email, $contact, $fname, $lname) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->fname = $fname;
		    $this->lname = $lname;
		    $this->position = "IT Technician";
		 }

		public function getPermissionID():string{
			return 3;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"fname"=>$this->fname,
				"lname"=>$this->lname,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"position"=>$this->position
			);
		}
	}

	class Customer extends Client{
		public function __construct($userID, $email, $contact, $name, $company) {
		    $this->userID = $userID;
		    $this->email = $email;
		    $this->contact = $contact;
		    $this->name = $name;
		    $this->company = $company;
		 }

		public function getPermissionID():string{
			return 4;
		}

		public function getData():array{
			return array(
				"id"=>$this->userID,
				"name"=>$this->name,
				"email"=>$this->email,
				"contact"=>$this->contact,
				"company"=>$this->company
			);
		}
	}

	//A person have the ability that system user can do
	class UserFactory{

	  public function getUser($pos, $uid):User{
	  	$getUser_com = new getUser(ADTECH::getDB());
	  	$getUser_com->setParam([(int)$pos, $uid]);
	  	$result = $getUser_com->execute()[0];
	  	$pos = (int) $result["pos"];
	  	if($pos == 1){
	  		return new CEO($result["id"], $result["email"], $result["contact"], $result["fname"], $result["lname"]);
	  	}else if($pos == 2){
	  		return new Manager($result["id"], $result["email"], $result["contact"], $result["fname"], $result["lname"]);
	  	}else if($pos == 3){
	  		return new IT_Tech($result["id"], $result["email"], $result["contact"], $result["fname"], $result["lname"]);
	  	}else if($pos == 4){
	  		return new Customer($result["id"], $result["email"], $result["contact"], $result["name"], $result["company"]);
	  	}
	  }

	}

?>