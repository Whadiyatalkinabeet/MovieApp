<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();

	if (isset($_SESSION['newusername'])){
		echo "";
	} else {
		echo "Not found";
	}
	
	$user = $_SESSION['newusername'];
	echo "<footer><p style='color: black; font-size: 12px'>Created by Nyal Sadiq 2016 Heriot Watt University<p></footer>";
	echo "<h1 style='text-align: center;'><strong>Welcome back " . "<span id='username'>" . $user . "</span>!</strong></h1><br/>";

	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";

	$connection = new mysqli($servername, $username, $password, $databasename);

	$statement2 = $connection->prepare("SELECT size, textcolor, bgcolor FROM cw_users WHERE username= (?)");
	$statement2->bind_param("s", $user);
	$statement2->execute();
	$statement2->bind_result($getsize, $gettextcolor, $getbgcolor);
	
	while ($statement2->fetch()){
			$size = $getsize;
			$textcolor = $gettextcolor;
			$bgcolor = $getbgcolor;
	}
	
	$connection->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Portal</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	
	<body>
		<div class="mainbutton">
		<button type="button" onclick="window.location.replace('changecolor.php')">Edit Color Scheme</button>
		<button type="button" onclick="window.location.replace('edit.php')">Edit Account Details</button>
		<button type="button" onclick="window.location.replace('about.php')">About</button>
		<button type="button" onclick="logout()">Log Out</button>
		</div>
		<br>
		
		<div id="movie">
		<h2>Today's News</h2>
		<p>Students in protest over £3.29 meal deal cost</p>
		<img src="http://indianapublicmedia.org/stateimpact/files/2011/10/Loan-Protest1.jpg" alt="Protest" align="middle"/>
		<p>Students at universities across the globe are in outraged over the price of a meal deal.</p>
		</div>	
		

		<script type="text/javascript">
		
			
			function logout() {
				if (confirm("Are you sure you wish to log out and be taken back to the homepage?") == true) {
						window.location.replace("logout.php");
				}
			}
		
			function changeColor(BGColor){
				document.body.style.backgroundColor = BGColor;
			}

			function changeTextColor(TextColor){
				document.body.style.color = TextColor;
			}

			
			function setsize(size){
					document.body.style.fontSize = size;
			}
		</script>
	</body>
</html>

<?php
	echo '<script> changeColor("' . $bgcolor . '"); </script>';
	echo '<script> changeTextColor("' . $textcolor . '"); </script>';
	echo '<script> setsize("' . $size . '"); </script>';
?>


