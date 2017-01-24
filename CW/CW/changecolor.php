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
	echo "<h1 style='text-align: center;'><strong>Change Colour Preferences</strong></h1><br/>";


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
		<title>Edit Colors</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="settings">
			<p style="text-align: center"><strong>Choose your background colour</strong><p>
			<div class="mainbutton">
				<button id="mainbutton" type="button" onclick="changeColor('#FF6961')">Red</button>
				<button id="mainbutton" type="button" onclick="changeColor('#448ed3')">Blue</button>
				<button id="mainbutton" type="button" onclick="changeColor('#77DD77')">Green</button>
				<button id="mainbutton" type="button" onclick="changeColor('white')">White</button>
				<br/>
				<p><strong>Choose your prefered text colour</strong></p>
				<button id="mainbutton" type="button" onclick="changeTextColor('#FF6961')">Red</button>
				<button id="mainbutton" type="button" onclick="changeTextColor('white')">White</button>	
				<button id="mainbutton" type="button" onclick="changeTextColor('#FDFD96')">Yellow</button>
				<button id="mainbutton" type="button" onclick="changeTextColor('#448ed3')">Blue</button>
				<br/>
				<p><strong>Choose your prefered font size (Be Sensible)</strong></p>
				<button id="mainbutton" type="button" onclick="resize(1)">Bigger</button>
				<button id="mainbutton" type="button" onclick="resize(-1)">Smaller</button>
				<br/>
				<p><strong>Click Save to save your details</strong><p>
				<button id="mainbutton" type="button" id="save" onclick="save()">Save</button>
				<button id="mainbutton" type="button" onclick="window.location.replace('Main.php')">Go Back</button>
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
			if (confirm("Are you sure you wish to change your colour settings?") == true) {
				if (document.body.style.fontSize == ""){
					var size = "1.0em";
				} else {
					var size = document.body.style.fontSize;
				}
				
				var bgcolor = document.body.style.backgroundColor;
				var textcolor = document.body.style.color;
				
				$.post("save.php",
				{
					bgcolor: bgcolor,
					textcolor: textcolor,
					size: size,
					newuser: 0
				},
				function(data, status){
					window.location.replace("Main.php");
				});
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
