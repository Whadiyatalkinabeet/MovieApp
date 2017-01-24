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
		<title>About</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	
	<body>
		<div class="mainbutton">
			<button type="button" onclick="window.location.replace('Main.php')">Go Back</button>
		</div>
		<br>
		
		<div id="movie">
			<h2>Technologies Used</h2>
			<p>AJAX</p>
			<p>SQL</p>
			<p>PHP</p>
			<p>jQuery libraries</p>
			<p>JavaScript</p>
			<p>HTML5</p>
			<p>I used a css template for the login screen from the following source:</p>
			<p>https://www.template.net/web-templates/htmlcss-templates/html-login-form-templates/</p>
			<a href="https://images.template.net/wp-content/uploads/2014/12/login.zip">Template Download Link</a>
		</div>	
		
		<script type="text/javascript">
		
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
