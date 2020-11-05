<?php
	require_once "root.php";
	require_once "person.php";
	
	$user = new IT_Tech("Dexter","Sia");
	//echo $user->homeDir();
	//print_r($user->getData());

	//echo ROOT_PATH;
	
	//print_r(ADTECH::getMenu());

	$user1 = new IT_Tech("Dexter1","Sia");
	$user2 = new IT_Tech("Dexter2","Sia");
	$user3 = new IT_Tech("Dexter3","Sia");
	$test = array();
	array_push($test, $user1);
	array_push($test, $user2);
	array_push($test, $user3);

	print_r($test);
	echo "<br>";
	echo "<br>";
	unset($test[1]);

	print_r($test);
	echo "<br>";
	echo "<br>";

	foreach ($test as $key => $value) {
		echo $key . ", " . $value->getPermissionID() . "<br>";
	}

?>