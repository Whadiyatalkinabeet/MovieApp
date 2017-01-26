<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	session_start();

	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";
	$tablename= "MovieUsers";

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
		
		$options = ['cost' => 11,];
		$hash = password_hash($password, PASSWORD_BCRYPT, $options);

		$statement = $connection->prepare("INSERT INTO MovieUsers (username, password) values (?, ?)");
		$statement->bind_Param("ss", $username, $hash);

		$statement->execute();

		echo json_encode(true);

	} else {
		echo json_encode("illegal");
	}

	$connection->close();
	
?>


