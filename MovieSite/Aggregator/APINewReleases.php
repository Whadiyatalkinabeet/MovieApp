<?php
//Callback for the NewReleases page
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	include'API.php';
    $fcon = fopen($APINewReleases, "r"); //APINewReleases from included API.php
    if ($fcon) {
        while (!feof($fcon)) $data_json .= fgets($fcon, 4096);
        fclose($fcon);
    }
    echo $data_json;
?>