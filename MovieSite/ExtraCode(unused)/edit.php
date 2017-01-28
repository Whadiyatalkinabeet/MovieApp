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
	echo "<footer><p style='color: black; font-size: 12px; text-align: left;'>Created by Nyal Sadiq 2016 Heriot Watt University<p></footer>";
	echo "<h1 style='text-align: center;'><strong>Edit Account Details</strong></h1><br/>";


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
		<title>Edit Account Details</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
		<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
		
	<style>
		body {
			font-size: 120%;
			text-align: center;
		}
		button{font-size: 100%;}
	</style>
	
	</head>
	
	<body>
	
		<div class="mainbutton">
			<div class="wrap">
				<p>Change Username</p>
				<input class="wrap" id="getusername" type="text" placeholder="New Username" required></br>
			</div>
			<button type="button" id="username" class="mainbutton" onclick="updateusername()">Update Username</button>
			<div id="alert1"></div>
			<div class="wrap">	
				<p>Change Password</p>
				<input class="wrap" id="getpassword" type="password" placeholder="New Password" required><br>
				<input class="wrap" id="getpasswordrepeat" type="password" placeholder="Repeat Password" required></br>
			</div>
			<button type="button" id="password" class="mainbutton" onclick="updatepassword()">Update Password</button>
			<div id="alert2"></div>
				<button type="button" class="mainbutton" onclick="window.location.replace('Main.php')">Go Back</button>
			</div>
		
		<script type="text/javascript">
		
			function updateusername() {
				var newdetail = document.getElementById("getusername").value;
				if (newdetail == ""){
					$("#getusername").effect("shake");
					document.getElementById("getusername").value = "";
					document.getElementById("alert1").innerHTML = "The username field must not be empty";
					return;
				}
			
				if (confirm ("Are you sure you wish to change your username to: " + newdetail + "?") == true) {
					$.post("update.php",
					{
						newdetail: newdetail
					},
					function(data, status){
						if (data == true) {
							document.getElementById("alert1").innerHTML = "Username changed to " + newdetail;
							document.getElementById("getusername").value = "";
					
						} else if (data == false){
							$("#getusername").effect("shake");
							document.getElementById("getusername").value = "";
							document.getElementById("alert1").innerHTML = "The username entered is the same as the current one";
						} else {
							$("#getusername").effect("shake");
							document.getElementById("getusername").value = "";
							document.getElementById("alert1").innerHTML = "Only letters and numbers please!";
						}
					}, "json");

				}
			
			}
			
			
			function updatepassword() {
				var newdetail = document.getElementById("getpassword").value;
				var newdetailcheck = document.getElementById("getpasswordrepeat").value;
				
				if (newdetail == "" || newdetailcheck == ""){
					$("#getpassword").effect("shake");
					$("#getpasswordrepeat").effect("shake");	
					document.getElementById("getpassword").value = "";
					document.getElementById("getpasswordrepeat").value = "";
					document.getElementById("alert2").innerHTML = "The password fields must not be empty";
					return;
				}
				
				if (newdetail != newdetailcheck){
					$("#getpassword").effect("shake");
					$("#getpasswordrepeat").effect("shake");
					document.getElementById("getpassword").value = "";
					document.getElementById("getpasswordrepeat").value = "";
					document.getElementById("alert2").innerHTML = "The passwords that you entered do not match";	
					return;
				} 
				
				if (confirm("Are you sure you wish to change your password?") == true) {
				
					$.post("updatepassword.php",
					{
						newdetail: newdetail
					},
					function(data, status){
						if (data == true){
							document.getElementById("alert2").innerHTML = "Password change successful";
							document.getElementById("getpassword").value = "";
							document.getElementById("getpasswordrepeat").value = "";
						} else if (data == false){
							$("#getpassword").effect("shake");
							$("#getpasswordrepeat").effect("shake");
							document.getElementById("getpassword").value = "";
							document.getElementById("getpasswordrepeat").value = "";
							document.getElementById("alert2").innerHTML = "The password entered is the same as the current one";
						} else {
							$("#getpassword").effect("shake");
							$("#getpasswordrepeat").effect("shake");
							document.getElementById("getpassword").value = "";
							document.getElementById("getpasswordrepeat").value = "";
							document.getElementById("alert2").innerHTML = "Only letters and numbers please!";
						}
					}, "json");
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
