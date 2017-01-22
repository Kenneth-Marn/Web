<?php
	
	//check if the photo is in the correct format and size
	function checkImage($name, $type,$size){
		$uploadOk = 1;
		$imageOK = 1;
		if ($size > 3*1024*1024) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		    return false;
		}
		// Allow certain file formats
		if($type != "jpg" && $type != "png" && $type != "jpeg"
		&& $type != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		    return false;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		    return false;
		// if everything is ok, try to upload file
		} else {
			return true;
		}
	}
	//upload a photo to the database
	function uploadImage($tmp_file, $target_dir,$type, $method, $db){
		//using hash to avoid duplicated file in the database
		$hashStr = md5_file($tmp_file);
	    $renamed = $target_dir . $hashStr. ".". $type;
	    if (move_uploaded_file($tmp_file, $renamed)) {
	    	//upload profile image
	    	if($method=="profilePhoto"){
	    		$db->uploadProfileImage($_SESSION['email'],$hashStr.".".$type);
	    		return 0;
	    	}	
	    	//upload this image to the database
	    	else{
	    		$image_id = $db->uploadStatusImage($_SESSION['email'],$hashStr.".".$type);
	    		//if images are posted successfully --> return image name
	    		if($image_id !=0){
	    			return ($hashStr.".".$type);
	    		}
	    		
	    	}	
	    }
	    else{
	    	echo "error: There is a problem uploading the image";
	    }
	}
	//add images to a status in the database
	function postStatusImages($files,$target_dir,$core){
		//Get the status id so that after finish uploading the images
		//we can add those id to the images field of the status
		$imagesOfStatus = "";
		//for every image --> check and upload to the database
		$numImages  = count($files["statusImages"]["name"]);
		for($i=0; $i< $numImages;$i++){
			$target_file = $target_dir . basename($files["statusImages"]["name"][$i]);	
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			if(checkImage($files["statusImages"]["name"][$i], $imageFileType ,$files["statusImages"]["size"][$i])){
				//upload this image to the database
				//get back the image id uploaded
				$image_name = uploadImage($files["statusImages"]["tmp_name"][$i], $target_dir,$imageFileType, "statusPhoto", $core);
				if(strpos($image_name, "error")==false && $i<$numImages-1)
				{

					$imagesOfStatus .= $image_name . ",";
				}
				else{
					$imagesOfStatus .= $image_name ;
				}
			}
			else
				echo "error: The image is not in correct format, please try again";
		}
		return $imagesOfStatus;
	}
?>