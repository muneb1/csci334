<?php

	//There are the codes that initialize the program
	require "root.php";
	require "person.php";

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

	ADTECH::addMenu($dashboard);
	ADTECH::addMenu($customerMenu);
	ADTECH::addMenu($staffMenu);
	

?>