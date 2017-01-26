<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";
	$tablename= "users";

	$connection = new mysqli($servername, $username, $password, $databasename);

	if ($connection->connect_error) {
		die("Database connection failed: ".mysqli_connect_error());
	}
		
		
	$newusername = mysqli_real_escape_string($connection, $_POST["newusername"]);


	$pattern = "~^[0-9a-zA-Z]+$~";
	$success = preg_match($pattern, $newusername);

	if ($success) {


		$statement = $connection->prepare("SELECT * FROM MovieUsers WHERE username= (?)");
		$statement->bind_param("s", $newusername);
		$statement->execute();
		$statement->store_result();


		$count = $statement->num_rows;



		if($count==1){
			session_start();
			$_SESSION['newusername'] = $newusername;
			echo json_encode("true");	
		} else {
			echo json_encode("false");
		}

		} else {
			echo json_encode("false");
		}	

	$connection->close();

?>

