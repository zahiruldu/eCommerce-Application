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