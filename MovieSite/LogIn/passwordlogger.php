<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();

	$user = $_SESSION['newusername'];
	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";

	$connection = new mysqli($servername, $username, $password, $databasename);

	if ($connection->connect_error) {
		die("Database connection failed: ".mysqli_connect_error());
	}
	
	$newpassword = mysqli_real_escape_string($connection, $_POST["newpassword"]);
	$pattern = "~^[0-9a-zA-Z]+$~";
	$success = preg_match($pattern, $newpassword);

	if ($success) {
	
		$statement = $connection->prepare("SELECT password FROM MovieUsers WHERE username= (?)");
		$statement->bind_param("s", $user);
		$statement->execute();
		$statement->store_result();
		
		$statement->bind_result($passwordfromDB);
		
		$options = ['cost' => 11,];
		
		$hash = password_hash($newpassword, PASSWORD_BCRYPT, $options);
			
		if(password_verify($newpassword, $hash)){
			echo json_encode("true");
		} else {
			echo json_encode("false");
		}


	} else {
		echo json_encode("false");
	}
	
	$connection->close();

?>

