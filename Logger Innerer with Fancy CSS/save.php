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
	$size = mysqli_real_escape_string($connection, $_POST["size"]);
	$bgcolor = mysqli_real_escape_string($connection, $_POST["bgcolor"]);
	$textcolor = mysqli_real_escape_string($connection, $_POST["textcolor"]);
	$newuser = mysqli_real_escape_string($connection, $_POST["newuser"]);
	$username = $_SESSION['newusername'];
	
		$statement = $connection->prepare("UPDATE cw_users SET size= (?) WHERE username= (?)");
		$statement->bind_param("ss", $size, $username);
		$statement->execute();
		
		$statement1 = $connection->prepare("UPDATE cw_users SET bgcolor= (?) WHERE username= (?)");
		$statement1->bind_param("ss", $bgcolor, $username);
		$statement1->execute();
		
		$statement2 = $connection->prepare("UPDATE cw_users SET textcolor= (?) WHERE username= (?)");
		$statement2->bind_param("ss", $textcolor, $username);
		$statement2->execute();

		$statement3 = $connection->prepare("UPDATE cw_users SET new= (?) WHERE username= (?)");
		$statement3->bind_param("is", $newuser, $username);
		$statement3->execute();
		
	$connection->close();
		
?>
