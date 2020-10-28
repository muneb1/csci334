<?php
	//These are the classes that implement Factory Pattern
	//system user interface class
	interface User {
	  public function getPermissionID():string;
	}

	//A person have the ability that system user can do
	abstract class Person implements User{
	  protected $userID;
	  protected $first_name;
	  protected $last_name;
	  protected $position;

	  public function __construct($fname, $lname) {
	    $this->first_name = $fname;
	    $this->last_name = $lname;
	  }

	  public function getID(){
	  	return $this->userID;
	  }

	  abstract public function getPermissionID():string;
	  abstract public function getData():array;

	}

	//IT technician
	class CEO extends Person{
		
		public function __construct($fname, $lname) {
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		    $this->position = "CEO";
		}

		public function getPermissionID():string{
			return 1;
		}

		public function getData():array{
			return array(
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"position"=>$this->position,
			);
		}
	}

	//IT technician
	class Manager extends Person{
		
		public function __construct($fname, $lname) {
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		    $this->position = "Manager";
		}

		public function getPermissionID():string{
			return 2;
		}

		public function getData():array{
			return array(
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"position"=>$this->position,
			);
		}
	}

	//IT technician
	class IT_Tech extends Person{
		
		public function __construct($fname, $lname) {
		    $this->first_name = $fname;
		    $this->last_name = $lname;
		    $this->position = "IT Technician";
		}

		public function getPermissionID():string{
			return 3;
		}

		public function getData():array{
			return array(
				"fname"=>$this->first_name,
				"lname"=>$this->last_name,
				"position"=>$this->position,
			);
		}
	}

?>