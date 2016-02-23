<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$db = "ecommerce";



$upload_dir = "uploads/";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


function upload_location(){
	global $upload_dir;
	return $upload_dir;
}
