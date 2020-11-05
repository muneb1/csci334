<?php

define("ROOT_PATH", "/csci334/", FALSE);
require_once "menu.php";
require_once "config.php";

// This is a class without implementing Singleton Pattern
// This is root class from the whole program, is like the engine from the program, the program stucture and core stored here
// This class is 80% completed
class ADTECH{
	private static $instance = null;
	private static $mysqli;
	private static $mainMenu;
	private static $notifier;

	private function __construct() {

		//initialize variable
		self::$mainMenu = array();

		//create db connection
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		try {
			self::$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			self::$mysqli->set_charset("utf8mb4");
		} catch(Exception $e) {
			error_log($e->getMessage());
			exit('Error connecting to database'); //Should be a message a typical user could understand
		}	
	}

	public function addMenu($menu){
		if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }

		array_push(self::$mainMenu, $menu);
	}

	public static function getMenu(){
		if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }

	    $tempArray = array();
	    foreach (self::$mainMenu as &$value) {
	    	array_push($tempArray, $value);
	    }

		return $tempArray;
	}

	public static function getDB(){
		if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }

		return self::$mysqli;
	}

	public static function getNotifier(){
		if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }

		return self::$notifier;
	}

	public static function getInstance()
	{
	    if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }
	 
	    return self::$instance;
	}
}

?>