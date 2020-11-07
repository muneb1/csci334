<?php

	//There are the codes that initialize the program
	require_once "root.php";
	require_once "person.php";
	require_once 'command.php';

	//initialize menu
	$dashboard = new Main_Menu("Dashboard",ROOT_PATH."admin", [1,2]);
	$customerMenu = new Main_Menu("Customer Requests",ROOT_PATH."admin/customerRequest.php", [2,3]);
	$staffMenu = new Main_Menu("Staff", ROOT_PATH."admin/staff.php", [2]);
	$reportMenu = new Main_Menu("Reports", ROOT_PATH."admin/reports.php", [1]);
	$overtimeMenu = new Main_Menu("Overtime Reports", ROOT_PATH."admin/overtime.php", [3]);

	$allCus = new Sub_Menu("All Requests", ROOT_PATH."admin/customerRequest.php", [2,3]);
	$newCus = new Sub_Menu("New Requests", ROOT_PATH."admin/customerRequest.php?f=new", [2,3]);
	$ongoingCus = new Sub_Menu("On-Going Requests", ROOT_PATH."admin/customerRequest.php?f=ongoing", [2,3]);
	$comCus = new Sub_Menu("Completed Requests", ROOT_PATH."admin/customerRequest.php?f=completed", [2,3]);
	$staffRp = new Sub_Menu("Staffs Perfomance", ROOT_PATH."admin/staff.php", [1]);
	$cusReview = new Sub_Menu("Customer Reviews", ROOT_PATH."admin/customerReview.php", [1]);

	$customerMenu->addSubMenu($allCus);
	$customerMenu->addSubMenu($newCus);
	$customerMenu->addSubMenu($ongoingCus);
	$customerMenu->addSubMenu($comCus);

	$reportMenu->addSubMenu($staffRp);
	$reportMenu->addSubMenu($cusReview);

	ADTECH::addMenu($dashboard);
	ADTECH::addMenu($customerMenu);
	ADTECH::addMenu($staffMenu);
	ADTECH::addMenu($reportMenu);
	ADTECH::addMenu($overtimeMenu);
	

?>