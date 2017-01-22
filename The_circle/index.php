<?php
	//start session and include core.php
    include_once 'core/init.php';
?>


<body >
	<?php include 'templates/header.php' ?>
	<?php include 'templates/nav_logout.php' ?>

	<?php 

        if(!isset($_SESSION["loggedin"]) || ($_SESSION['loggedin'] ===false)){
            include 'templates/signupform.php' ;
        }
        else{
            include 'templates/mainPage.php';
        }     
    ?>
	<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
   
    <script src = "js/functions.js"></script>
    <script src = "js/registration.js"></script>
    <script src = "js/login.js"></script>
    <script src = "js/main.js"></script>
</body>

</html>