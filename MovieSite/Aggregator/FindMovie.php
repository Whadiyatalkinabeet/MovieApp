<?php
/*
* I get the URL and send it back
*/	$baseURL = "https://api.themoviedb.org/3/search/movie?api_key=6d64a72486b47e66eaf157cafc5a0860&query=";
	if (!empty($_GET['movieTitle']))
	        $myTitle = trim(strip_tags($_GET['movieTitle']));
	    	$URL = $baseURL . $myTitle;
	    	echo $URL;

?>