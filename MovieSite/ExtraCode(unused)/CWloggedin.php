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
	$servername = "mysql-server-1";
	$username = "ns53";
	$password = "abcns53354";
	$databasename = "ns53";

	$connection = new mysqli($servername, $username, $password, $databasename);

	if ($connection->connect_error) {
		die("Database connection failed: ".mysqli_connect_error());
	}
	
	$statement1 = $connection->prepare("SELECT new FROM cw_users WHERE username= (?)");
	$statement1->bind_param("s", $user);
	$statement1->execute();
	$statement1->bind_result($getnew);
	
	while ($statement1->fetch()){
			$newuser = $getnew;
	}
	
		if ($newuser == 1) {
			echo "<footer><p style='color: black; font-size: 12px'>Created by Nyal Sadiq 2016 Heriot Watt University<p></footer>";
			echo "<h2 style='text-align: center;'><strong>" . "First Log In " . "<span id='username'>" . $user . "</span>!</strong></h2>";
			echo "<h2 style='text-align: center;'><strong> Let's set up your account!</strong></h2>";
		} else {
			header("Location: Main.php") ;
		}
		
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
		<style>
			body {
				font-size: 120%;
				text-align: center;
			}
			button{font-size: 100%;}
	</style>
	</head>
	
	<body>
		<div class="settings">
			<div class="mainbutton">
				<p><strong>Choose your background colour</strong><p>
				<button type="button" onclick="changeColor('#FF6961')">Red</button>
				<button type="button" onclick="changeColor('#448ed3')">Blue</button>
				<button type="button" onclick="changeColor('#77DD77')">Green</button>
				<button type="button" onclick="changeColor('white')">White</button>
				<br/>
				<p><strong>Choose your prefered text colour</strong></p>
				<button type="button" onclick="changeTextColor('#FF6961')">Red</button>
				<button type="button" onclick="changeTextColor('white')">White</button>	
				<button type="button" onclick="changeTextColor('#FDFD96')">Yellow</button>
				<button type="button" onclick="changeTextColor('#448ed3')">Blue</button>
				<br/>
				<p><strong>Choose your prefered font size (Be Sensible)</strong></p>
				<button type="button" onclick="resize(1)">Bigger</button>
				<button type="button" onclick="resize(-1)">Smaller</button>
				<br/>
				<p><strong>Click Save to save your details</strong><p>
				<button type="button" id="save" onclick="save()">Save</button>
				<button type="button" onclick="window.location.replace('logout.php')">Log Out</button>
			</div>
		</div>
		
		<script type="text/javascript">
	
	
		function changeColor(BGColor){
			document.body.style.backgroundColor = BGColor;
		}

		function changeTextColor(TextColor){
			document.body.style.color = TextColor;
		}

		function resize(multiplier){
			if (document.body.style.fontSize == "") {
				document.body.style.fontSize = "1.0em";
			}
			document.body.style.fontSize = parseFloat(document.body.style.fontSize) + (multiplier * 0.2) + "em";
		}
		
		function setsize(size){
				document.body.style.fontSize = size;
		}
		
		function save(){
			if (confirm("Are you sure you wish to change your colour setting to this?") == true) {
			if (document.body.style.fontSize == ""){
				var size = "&size=1.0em";
			} else {
				var size = "&size=" + document.body.style.fontSize;
			}
			
			var bgcolor = "&bgcolor=" + document.body.style.backgroundColor;
			
			var textcolor = "&textcolor=" + document.body.style.color;
			
			var newuser = "&newuser=0";
			
			var params = size + bgcolor + textcolor + newuser;
				var oReq = new XMLHttpRequest();
				oReq.onload = function() {
					var saved = this.responseText;
					window.location.replace("Main.php");
				}
					oReq.open("POST", "save.php", true);
					oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					oReq.setRequestHeader("Content-length", params.length);
					oReq.setRequestHeader("Connection", "close");
  					oReq.send(params);
			}
		}

		
		</script>
	</body>
</html>

<?php
	echo '<script> changeColor("' . $bgcolor . '"); </script>';
	echo '<script> changeTextColor("' . $textcolor . '"); </script>';
	echo '<script> setsize("' . $size . '"); </script>';
	
?>


