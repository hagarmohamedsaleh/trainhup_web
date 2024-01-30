<?php 
	
    $hostname = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $database = "summer_training"; // Replace with your database name
	
	$conn = new mysqli($hostname, $username, $password, $database);
	if ($conn->connect_error) {
		echo die("Connection_failed " .$conn->connect_error);
	} 
 ?>