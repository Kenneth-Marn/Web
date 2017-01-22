<?php

    include_once 'core/init.php';
    //if user is not logged in --> redirect
    if(!($_SESSION["loggedin"] ===true)){ 
    	header('Location: index.php');
     }
?>
<body >
	<?php include 'templates/header.php' ?>
	<?php include 'templates/nav_logout.php' ?>
	<div class="container">
		<?php include 'templates/addProfilePicModal.php' ?>
	</div>
	<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
   
    <script src = "js/functions.js"></script>
    <script src = "js/registration.js"></script>
    <script src = "js/login.js"></script>
    <script src = "js/addProfilePic.js"></script>
    <script src = "js/main.js"></script>
</body>

</html>