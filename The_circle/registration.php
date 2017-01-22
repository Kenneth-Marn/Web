<?php
	//connect to database
	include_once 'core/init.php';

	//retrieve values and write to the data base
	$firstname = trim ($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$options = [
    'cost' => 12,
	];
	//encrypt password for more security
	$password = password_hash($password, PASSWORD_BCRYPT, $options);
	$dob = trim($_POST["dob"]);
	$gender = trim ($_POST["gender"]);

	//register;
	$core->register($firstname, $lastname,$email, $password, $gender, $dob);
	
?>