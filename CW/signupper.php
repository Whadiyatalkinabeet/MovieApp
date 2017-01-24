<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	session_start();

	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";
	$tablename= "my_users";

	$connection = new mysqli($servername, $username, $password, $databasename);

	if ($connection->connect_error) {
		die("Database connection failed: ".mysqli_connect_error());
	}

	$username = mysqli_real_escape_string($connection, $_POST["username"]);
	$password = mysqli_real_escape_string($connection, $_POST["password"]);


	$pattern = "~^[0-9a-zA-Z]+$~";
	$success1 = preg_match($pattern, $username);
	$success2 = preg_match($pattern, $password);

	if ($success1 && $success2) {

		$statement = $connection->prepare("INSERT INTO cw_users (username, password, new) values (?, ?, 1)");
		$statement->bind_Param("ss", $username, $password);

		$statement->execute();

		echo json_encode(true);

	} else {
		echo json_encode("illegal");
	}

	$connection->close();
	
?>


