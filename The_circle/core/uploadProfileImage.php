<?php
	include_once 'init.php';
	include_once 'funcs.php';
	//file path for profile pictures
	$target_dir = "../resources/images/profile/";
	$target_file = $target_dir . basename($_FILES["pictureInput"]["name"]);	
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	//check if the image satifies the conditions of image type and size
	if(checkImage($_FILES["pictureInput"]["name"], $imageFileType ,$_FILES["pictureInput"]["size"])){
		//upload profile picture 
		uploadImage($_FILES["pictureInput"]["tmp_name"], $target_dir,$imageFileType, "profilePhoto", $core);
	}
	else
		echo "error: The image is not in correct format, please try again";
?>