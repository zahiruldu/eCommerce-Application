<?php
require_once('config.php');

// Functions for image deleting
function checkAndDeleteItem($image_link){
	if (file_exists($image_link)) {
		unlink($image_link);
	}
}


// Image upload and manking new url link
function uploadAndNewLink($image){

	$upload_dir = upload_location();

		if (!empty($image["name"])) {
			$temp = explode(".", $image["name"]);
	        $newfilename = microtime(true) . '.' . end($temp);
	        move_uploaded_file($image["tmp_name"], $upload_dir.$newfilename);
			$imglink = $upload_dir .$newfilename;

			return $imglink;
		}else{
			return false;
		}
}

// Get cart item amount

function getCart($user_id){
	require_once('config.php');
	
	$sql = "SELECT COUNT(id) FROM cart WHERE user_id='$user_id' AND status='cart'";
	$result= $conn->query($sql);
	if ($result) {
		while($row = $result->fetch_array()){
			return $row["COUNT(id)"];
		}
	}else{
		return "0";
	}
}
