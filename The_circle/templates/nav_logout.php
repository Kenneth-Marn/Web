<nav class="navbar">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	       <a class="navbar-brand" href="#" id="logo"><img src="resources/images/icons/logo.png"></a>
	       <form class="navbar-form navbar-left">	       
		        <div class="input-group">
					  <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
					  <span id = "search_icon" class="input-group-addon" ><img  src="resources/images/icons/search.png"></span>
				</div>
		       
     		</form>
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	     
	    </div>
	   
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	
	    <?php
	     if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] ===false ){ ?>
	     	<form class="navbar-form navbar-right" id = "login_form" action="login.php" method = "post">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Email" data-toggle="tooltip" data-placement="bottom" id = "login_email" title="Email missing">
		        </div>
		        <div class="form-group">
		          <input type="password" class="form-control" placeholder="password" data-toggle="tooltip" data-placement="bottom" title="Password missing" id= "login_password">
		        </div>
		        <button type="submit" class="btn btn-primary" id = "login">Login</button>
	      	</form>

	     <?php } else if($_SESSION['loggedin'] === true){ ?>
	     	<ul class="nav navbar-nav navbar-right-loggedin navbar-right">
	    			<li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
	    			<li><a href="#"><i class="glyphicon glyphicon-envelope"></i></a></li>
			        <li><a href="#"><i class= "glyphicon glyphicon-globe"></i></a></li>
			        <li class="dropdown">

			          <?php 
			          	if(isset($_SESSION["name"])){
			          ?>
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id = "defaultAvatar"  src="<?php echo( $profileBaseURL . $_SESSION['name']); ?>"></a>
			          <?php } else{ ?>

			          	 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id = "defaultAvatar"  src="resources/images/defaultAvatar.png"></a>
			      	<?php } ?>
			          <ul class="dropdown-menu">
			            <li><a href="#" id = "logout">Log out</a></li>
			            <li><a href="#">Settings</a></li>
			            <li><a href="#">Help</a></li>
			            <li role="separator" class="divider"></li>
			            <li><a href="#">Separated link</a></li>
			          </ul>
			        </li>
    		    </ul>
    	<?php }?>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
</nav>