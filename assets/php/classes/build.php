<?php

	//There are the codes that initialize the program
	require_once "root.php";
	require_once "person.php";
	require_once 'command.php';

	//initialize menu
	$dashboard = new Main_Menu("Dashboard",ROOT_PATH."admin", [1,2]);
	$customerMenu = new Main_Menu("Customer Requests",ROOT_PATH."admin/customerRequest.php", [2,3]);
	$staffMenu = new Main_Menu("Staff", ROOT_PATH."admin/staff.php", [1,2]);

	$allCus = new Sub_Menu("All Requests", ROOT_PATH."admin/customerRequest.php", [2,3]);
	$newCus = new Sub_Menu("New Requests", ROOT_PATH."admin/customerRequest.php?f=new", [2,3]);
	$ongoingCus = new Sub_Menu("On-Going Requests", ROOT_PATH."admin/customerRequest.php?f=ongoing", [2,3]);
	$comCus = new Sub_Menu("Completed Requests", ROOT_PATH."admin/customerRequest.php?f=completed", [2,3]);
	$customerMenu->addSubMenu($allCus);
	$customerMenu->addSubMenu($newCus);
	$customerMenu->addSubMenu($ongoingCus);
	$customerMenu->addSubMenu($comCus);

	ADTECH::addMenu($dashboard);
	ADTECH::addMenu($customerMenu);
	ADTECH::addMenu($staffMenu);
	

?>