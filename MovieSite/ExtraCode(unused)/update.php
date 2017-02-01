<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();

	$servername = "mysql-server-1";
	$adminusername = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";
	
	$connection = new mysqli($servername, $adminusername, $password, $databasename);

	if ($connection->connect_error) {
		die("Database connection failed: ".mysqli_connect_error());
	}	
	
	$newdetail = mysqli_real_escape_string($connection, $_POST["newdetail"]);
	$pattern = "~^[0-9a-zA-Z]+$~";
	$success = preg_match($pattern, $newdetail);

	if ($success) {
	
	$username = $_SESSION['newusername'];
	
	if ($newdetail == $username){
			echo json_encode(false);
			exit();
	}
	
		$statement = $connection->prepare("UPDATE cw_users SET username= (?) WHERE username= (?)");
		$statement->bind_param("ss", $newdetail, $username);
		$statement->execute();
		
		$_SESSION['newusername'] = $newdetail;
		echo json_encode(true);
		
	} else {
		echo json_encode("illegal");
	}
	
	
	$connection->close();
		
?>
