<?php

define("ROOT_PATH", "csci334/", FALSE);
require "menu.php";
require "config.php";

//This is a Singleton class
class ADTECH{
	private static $instance = null;
	private static $mysqli;
	private static $mainMenu;

	private function __construct() {

		//create db connection
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		try {
			self::$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			self::$mysqli->set_charset("utf8mb4");
		} catch(Exception $e) {
			error_log($e->getMessage());
			exit('Error connecting to database'); //Should be a message a typical user could understand
		}

		//initialize menu
		$dashboard = new Main_Menu("Dashboard",ROOT_PATH);
		$customerMenu = new Main_Menu("Customer Requests",ROOT_PATH."customers");
		$staffMenu = new Main_Menu("Staff", ROOT_PATH."staffs");

		$newCus = new Sub_Menu("New Requests", ROOT_PATH."customers?f=new");
		$ongoingCus = new Sub_Menu("On-Going Requests", ROOT_PATH."customers?f=ongoing");
		$comCus = new Sub_Menu("Completed Requests", ROOT_PATH."customers?f=completed");
		$customerMenu->addSubMenu($newCus);
		$customerMenu->addSubMenu($ongoingCus);
		$customerMenu->addSubMenu($comCus);

		self::$mainMenu = array();
		array_push(self::$mainMenu, $dashboard );
		array_push(self::$mainMenu, $customerMenu );
		array_push(self::$mainMenu, $staffMenu );
	}

	public static function getMenu(){
		if (self::$instance == null)
	    {
	      self::$instance = new ADTECH();
	    }

	    $tempArray = array();
	    foreach (self::$mainMenu as &$value) {
	    	array_push($tempArray, $value->print());
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