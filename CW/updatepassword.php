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
	
		$statement = $connection->prepare("SELECT password FROM cw_users WHERE username= (?)");
		$statement->bind_param("s", $username);
		$statement->execute();	
		$statement->bind_result($getuserpassword);
		
		while ($statement->fetch()){
			$userpassword = $getuserpassword;
		}	
		
		if ($newdetail == $userpassword) {
			echo json_encode(false);
			exit();
	}

		$statement1 = $connection->prepare("UPDATE cw_users SET password= (?) WHERE username= (?)");
		$statement1->bind_param("ss", $newdetail, $username);
		$statement1->execute();
		
		echo json_encode(true);
		
	} else {
		echo json_encode("illegal");
	}
	
	$connection->close();
		
?>
