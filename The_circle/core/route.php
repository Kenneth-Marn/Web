<?php
    /* Handing requests from client and call responsible methods/functions 
    */
 	
    //start session and include core.php
    include_once 'init.php';
    include_once 'funcs.php';
    $target_dir = "../resources/images/timeline/";
    $method = $_POST['method'];
    //if use wants to login
    if($method === "login"){
		$email = trim ($_POST['email']);
		$password = trim($_POST['password']);
	    $core->login($email, $password);

    }
    //if profile image is requested
    else if($method === "getProfileImage"){
    	$core->getProfileImage( trim ($_POST['email']));
    }
    //if user logs out
    else if($method ==="logout"){
    	$_SESSION["loggedin"] = false;
		$_SESSION["email"] = "";
		$_SESSION["password"] = "";
		echo "success";
    }
    //if user send a post status request
    else if($method =="post_status"){
       // print_r($_POST);
       // print_r($_FILES);
        $status = $_POST["stat"];
        if($status!= ""){
            $result = $core->postStatusText($status);
            if(is_numeric($result)){
                 //upload images
                $imagesStr = postStatusImages($_FILES,$target_dir,$core);
                if(!strpos($imagesStr, "error")){
                //update status with images string;
                    $updateStatusRes = $core->updateStatus("images", $imagesStr,$result);
                    return $updateStatusRes;
                }
                else
                    return $imagesStr;
            }
            else{
                return $result;
            }      
        }
    }
    else if($method == "updateStatusImages"){
        print_r($_POST);
    }
    //get all feeds from the people that the user is following
    else if($method == "getGlobalFeeds" || $method == "getUserFeeds"){
        $core->getFeeds($_POST["start"],$_POST["limit"], $_POST["userEmail"]);  
    }
  
?>