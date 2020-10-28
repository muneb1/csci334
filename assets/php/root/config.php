<?php 
	$dbHost = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "csci334";

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	try {
		$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
		$mysqli->set_charset("utf8mb4");
	} catch(Exception $e) {
		error_log($e->getMessage());
		exit('Error connecting to database'); //Should be a message a typical user could understand
	}
	
	/*$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}*/

	
?>