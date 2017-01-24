<?php
ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();

	

	if (isset($_SESSION['newusername'])){
		echo "<footer><p style='color: black; font-size: 12px'>Created by Nyal Sadiq 2016 Heriot Watt University<p></footer>";
		echo "<h2>" . $_SESSION['newusername'] . "</h2>";
		
	} else {
		echo "Not found";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
		<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	</head>
	
	<body>
	
		<div class="wrap">
			<h1 style="text-align: center">Portal Log In</h1>
			<h2 style="text-align: center">Please enter your password</h2>
			<div class="avatar">
				<img src="https://chrisjbarker.files.wordpress.com/2011/08/ainsley-harriott-02.jpg" alt="ainsley">
			</div>
			
			<input class="wrap" id="password" type="password" placeholder="Password" required><br/>
			
			<button id="secondary"type="button" onclick="check();"><strong>Log In</strong></button>
			<div id="alert"></div>
			
			<button id="secondary" onclick="sessionKiller()" type="button"><strong>Go Back</strong></button>
		</div>

	<script>
		function sessionKiller(){
			$.ajax({url: "sessionKiller.php", success: function(result){
				window.location.replace("CWlogin.html");
			}});
		}
		
		function check(){
		var password = document.getElementById('password').value;
		
			$.post("passwordlogger.php",
			{
				newpassword: password
			},
			function(data, status){
				
				if (data == "true"){
						window.location.replace("CWloggedin.php");
				} else {
						$("#password").effect("shake");
						document.getElementById("password").value = "";
						alert("Invalid username/password");
						window.location.replace("CWlogin.html");
				}
			}, "json");
			
		}
		
		
	
	</script>	
	</body>
</html>

