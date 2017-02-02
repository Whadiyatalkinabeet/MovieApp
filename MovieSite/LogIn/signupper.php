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
		$postusername = mysqli_real_escape_string($connection, $_POST["username"]);
		$postpassword = mysqli_real_escape_string($connection, $_POST["password"]);
	
		
		$pattern = "~^[0-9a-zA-Z]+$~";
		$success1 = preg_match($pattern, $postusername);
		$success2 = preg_match($pattern, $postpassword);
		
		
	
	
	
		$statement = $connection->prepare("SELECT username FROM MovieUsers WHERE username = (?)");
		$statement->bind_Param("s", $postusername);
		$statement->execute();
		
		mysqli_stmt_store_result($statement);
		$num_rows = mysqli_stmt_num_rows($statement);
		
		
		
	

	if ($success1 && $success2 && ($num_rows == 0)) {
		
		$options = ['cost' => 11,];
		$hash = password_hash($postpassword, PASSWORD_BCRYPT, $options);

		$statement = $connection->prepare("INSERT INTO MovieUsers (username, password) values (?, ?)");
		$statement->bind_Param("ss", $postusername, $hash);

		$statement->execute();

		echo json_encode(true);

	} elseif (!$success1 || !$success2){
		
		echo json_encode("illegal");
		
	} elseif ($num_rows != 0){
		
		echo json_encode("exists");
		
	} else {
		
		echo json_encode(false);
	}
	

	$connection->close();
?>


