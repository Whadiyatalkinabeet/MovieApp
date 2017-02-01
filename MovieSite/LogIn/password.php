<?php
ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();

	

	if (isset($_SESSION['newusername'])){
		echo "<footer><p style='color: white; font-size: 12px'>Created by Nyal Sadiq 2016 Heriot Watt University<p></footer>";
		echo "<h1 style='text-align: center'>Movies.</h1>";
		echo "<h2 style='text-align: center'>Please enter your password, " . $_SESSION['newusername'] . "</h2>";
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
		<link href="../Design/assets/css/main.css" rel="stylesheet"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
		<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	</head>
	
	<body>
	
		<div class="wrap">
		
			<div style="text-align: center; width: 30%; margin: auto;">
				<input class="wrap" id="password" type="password" placeholder="Password" required><br/>
			</div>
			
			<div style="text-align: center; margin-bottom: 1%">
				<input type="button" id="secondary" onclick="check();" value="Log In"/>
				<input type="button" id="secondary" onclick="sessionKiller()" value="Go Back"/>
			</div>
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
						window.location.replace("../Aggregator/index.php");
				} else if (data == "false"){
						$("#password").effect("shake");
						document.getElementById("password").value = "";
						alert("Invalid username/password");
						window.location.replace("CWlogin.html");
				} else {
					alert(data);
				}
			}, "json");
			
		}
		
		
	
	</script>	
	</body>
</html>

