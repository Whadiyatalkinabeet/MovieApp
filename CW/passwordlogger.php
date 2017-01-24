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
	
		$statement = $connection->prepare("SELECT * FROM cw_users WHERE username= (?) AND password= (?)");
		$statement->bind_param("ss", $user, $newpassword);
		$statement->execute();
		$statement->store_result();


		$count = $statement->num_rows;

		if($count==1){
			echo json_encode("true");
		} else {
			echo json_encode("false");
		}

	} else {
		echo json_encode("false");
	}
	
	$connection->close();

?>

