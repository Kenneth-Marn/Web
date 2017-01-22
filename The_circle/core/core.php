<?php
/*
	Comprises of methods for working with the databse
*/
class Core {
	protected $conn, $result;
	private $rows;
	public function __construct(){
		$servername = "localhost";
		$username = "root";
		$password = "root";	
		try {
		    $this->conn = new PDO("mysql:host=$servername;dbname=thecircle", $username, $password);
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }
	}

	/* Register a new user */
	public function register($firstname, $lastname,$email, $password, $gender, $dob){
		//prepare statement for better security
		$insert = $this->conn->prepare("INSERT INTO users (firstname, lastname, email,password,birthday, gender, preferedname) VALUES(:fname, :lname, :email, :pass,:birth, :gen, :preferedname)");

		header('Content-Type: application/json');
		try { 
			$preferedname = $firstname ." ". $lastname;
	    	$insert->execute(
			array(
				"fname" =>$firstname,
				"lname" =>$lastname,
				"email" => $email,
				"pass"  => $password,
				"gen" => $gender,
				"birth"  => $dob,
				":preferedname" =>$preferedname
			));
			//store logged in information to Session variables
			$_SESSION['email']=$email;
			$_SESSION["loggedin"] = true;
			
	    	//$result = ['success' => 'You now a member of The Circle'];
	    	echo json_encode(array('success' => 'You now a member of The Circle'));
			
		} catch (PDOException $e) {
			
		   if (strpos ($e->getMessage(),"Duplicate") !== false)
		    	echo json_encode(array('error' => 'This email has been taken'));
		} 
	}
	/* Login */
	public function login($email, $password){
		//from email --> get the record
		//prepare statement for better security
		$login = $this->conn->prepare("SELECT *  FROM users where email = :email");
		header('Content-Type: application/json');
		try { 
	    	$login->execute(
			array(
				":email" => $email
			));
	    	$count = $login->rowCount();
	    	if($count == 1){
	    		$row = $login->fetch();
	    		$password_hash = $row['password'];
	    		if (password_verify($password, $password_hash)){
	    			//get the password
	    			//write session information
	    			$_SESSION["email"] = $email;
	    			$_SESSION["loggedin"] = true;
	                $_SESSION["password"] = $password;
	                $_SESSION["bio"] = $row["bio"];
	                $_SESSION["dob"] = $row["birthday"];
	                $_SESSION["preferedName"] = $row["preferedname"];

	                //get the profile image
	    			echo json_encode(array('success' => 'Successfully logged in'));
	    		}
	    		else{
	    			echo json_encode(array('error' => 'Invalid password'));
	    		}
	    		
	    	}
	    	else{
	    		echo json_encode(array('error' => 'Invalid Email'));
	    	}
		} catch (PDOException $e) {
			echo json_encode(array('error' => $e->getMessage()));
			//echo json_encode(array('error' => 'Server error'));
			
		} 
	}
	/* Retrieve profile images corresponding with an email */
	public function getProfileImage($email){
		$getProfileImage = $this->conn->prepare("SELECT * from profilePictures WHERE userEmail = :email and isCurrent = :isCurrent");
		$pictureID = -1;
		try { 
	    	$getProfileImage->execute(
			array(
				":email" =>$email,
				":isCurrent" =>true
			));
			$result = $getProfileImage->fetch(PDO::FETCH_ASSOC);
			$pictureID = $result["pictureID"];

				
		} catch (PDOException $e) {
		    	echo ($e->getMessage() );
		} 

		//now get the picture id --> get the actual picture data
		if($pictureID !=-1){
			$obj = $this->getPicture($pictureID);

			if (array_key_exists("pictureID",$obj)) {
				//store values of profile image
				$_SESSION["pictureID"] = $obj["pictureID"];
				$_SESSION["name"] = $obj["name"];
				$_SESSION["caption"] = $obj["caption"];
				$_SESSION["likes"] = $obj["likes"];
				echo "Success: picture retrieved";
			}
			else
				echo "Error: cannot get the picture";
		}

	}
	/*get a picture object providing the pictureid*/
	public function getPicture($pictureID){
		$getPicture = $this->conn->prepare("SELECT * from picture WHERE pictureID = :id");
		try { 
	    	$getPicture->execute(
			array(
				":id" =>$pictureID
			));
			$result = $getPicture->fetch(PDO::FETCH_ASSOC);
			return $result;
			

		} catch (PDOException $e) {
		    	return $e->getMessage();
		} 
	}


	/*Upload profile image*/
	public function uploadProfileImage($email, $picName){
		//write to the picture table the picturename
		$addPicture = $this->conn->prepare("INSERT INTO picture (name,userEmail) VALUES(:name, :email)");
		$last_id = -1;
		try { 
	    	$addPicture->execute(
			array(
				":name" =>$picName,
				":email" =>$email
			));
			$last_id = $this->conn->lastInsertId();				
		} catch (PDOException $e) {
		    	echo ($e->getMessage());
		} 
		
		if($last_id !=-1){

			//before setting this image to be the profie picture
			//need to unset the current one
			$unset = $this->conn->prepare("UPDATE profilePictures SET isCurrent = :isCurrent WHERE userEmail = :userEmail");
			try { 
	    	$unset->execute(
			array(
				":userEmail" =>$email,
				":isCurrent" => false
			));
	    	} catch (PDOException $e) {
			    echo ($e->getMessage());
			}
			//now write to the profile picture table an entry that the user with this email has this profile picture
			$addProfilePic =  $this->conn->prepare("INSERT INTO profilePictures (userEmail, pictureID, isCurrent) VALUES(:email, :picID, :isCurrent)");

			try { 
	    	$addProfilePic->execute(
			array(
				":email" =>$email,
				":picID" =>$last_id,
				":isCurrent" => true
			));
				//update session variable
				$_SESSION["pictureID"] = $last_id;
				$_SESSION["name"] = $picName;
				echo "success";

			} catch (PDOException $e) {
			    echo ($e->getMessage());

			} 
		}
	}
	/*upload a status image */
	public function uploadStatusImage($email, $picName){
		//write to the picture table the picturename
		$addPicture = $this->conn->prepare("INSERT INTO picture (name,userEmail) VALUES(:name, :email)");
		$last_id = -1;
		try { 
	    	$addPicture->execute(
			array(
				":name" =>$picName,
				":email" =>$email
			));
			$last_id = $this->conn->lastInsertId();	
			return $last_id;			
		} catch (PDOException $e) {
		    	echo ($e->getMessage());
		} 

	}

	/*write status text to the database */
	public function postStatusText ($status){
		$addSatusText = $this->conn->prepare("INSERT INTO status (message,byUser,time) VALUES(:message, :user, :time)");
		try { 
	    	$addSatusText->execute(
			array(
				":message" =>$status,
				":user" =>$_SESSION["email"],
				":time"=>date("Y-m-d H:i:s")
			));
			$last_id = $this->conn->lastInsertId();
			return $last_id;				
		} catch (PDOException $e) {
		    	return ($e->getMessage());
		} 

	}
	/*update the status with a field and value providing id is known*/
	public function updateStatus($field, $value, $id){
		$sql = "UPDATE status SET " . $field . "=:value  WHERE id=:id ";
		$updateStatus = $this->conn->prepare($sql);
		try { 
	    	$updateStatus->execute(
			array(
				":value" =>$value,
				":id" =>$id
			));
			echo "success";			
		} catch (PDOException $e) {
		    	return ($e->getMessage());
		} 


	}
	/* get feeds from the users i follow with the start and limit */
	public function getFeeds($start, $limit, $userEmail){
		$getFeeds = "";
		$sql = "";
		//if getting global feeds
		if($userEmail == ""){
			$sql = "SELECT * FROM status where byUser in (SELECT followee from follow where follower =:userEmail) UNION ALL 
			SELECT * FROM status where byUser=:userEmail order by time DESC  limit ".$start.", ". $limit;
			
		}
		//getting user's feeds
		else{
			$sql = "SELECT * FROM status where byUser=:user  order by time DESC  limit ".$start.", ". $limit;
		}
			
		$getFlobalFeeds= $this->conn->prepare($sql);
		header('Content-Type: application/json');
		try { 
			if($userEmail == ""){
		    	$getFlobalFeeds->execute(
				array(
					":userEmail" =>$_SESSION["email"]
				));
			}
			else{
				$getFlobalFeeds->execute(
				array(
					":user" =>$userEmail
				));
			}
			$results = $getFlobalFeeds->fetchAll();
			
			//for each status, get the userEmail and get their profile image
			for ($i =0; $i<sizeof($results); $i++) {
				$feed = $results[$i];
				$userEmail = $feed["byUser"];
				$dataRow["userEmail"] = $userEmail;
				$sql = "SELECT preferedname,firstname,lastname,name from users, picture where users.email = :email and picture.pictureID = (SELECT pictureID from profilePictures WHERE profilePictures.userEmail = :email and profilePictures.isCurrent =1)";
				$getUserInfo = $this->conn->prepare($sql);
				$getUserInfo->execute(array(":email" =>$userEmail));
				$row = $getUserInfo->fetch();
				//consolidate into dataRow array
			    $feed["preferedName"] = $row["preferedname"];
			    $feed["firstname"] =$row["firstname"];
			    $feed["lastname"] = $row["lastname"];
			    $feed["pictureName"] = $row["name"];
			    $date =new DateTime($feed["time"]);
			    $date_format = $date->format('Y-m-d H:i:s');
			    $feed["time"] = $this->time_elapsed_string($date_format,false);
			    $results[$i] = $feed;
			}
			
			echo json_encode( $results);

		} catch (PDOException $e) {
			echo json_encode( array("error",$e->getMessage()));
		    	
		} 
	
	}
	//Return the feeds created by the user with userEmail
	public function getUserFeeds($start, $limit, $userEmail){

	}
	/*Create time_ago string from date_time */
	public function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    	return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
	}	
?>