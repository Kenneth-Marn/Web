<!-- sign up if a new user -->
<div class = "container">
    	<div class = "col-md-6 col-lg-6 col-xs-12 ">
    		<img src="img/Circle_of_Life.png" class="img-fluid left_img" >
    	</div>	
    	<div class= "col-md-6 col-xs-12">
    		<h1>Sign Up</h1>
    		<p>It's free and always will be.</p>
    		<form id = "registration_form" action="registration.php" method = "post">
    			<label >Name</label>	
    			<div class= "row">

	    		  <div class="form-group col-lg-6">
					<input type="text" class="form-control" id="firstname" placeholder="First name" data-toggle="tooltip" data-placement="top" title="Please enter first name">
				  </div>

				  <div class="form-group col-lg-6">
					<input type="text" class="form-control" id="surname" placeholder="Surname" data-toggle="tooltip" data-placement="top" title="Please enter Surname">
				  </div>
				</div>  	
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" id="email" placeholder="Email" data-toggle="tooltip" data-placement="top" title="Please enter a valid email address">

			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" placeholder="Password">
			    <p id ="password_error_msg" class = "text-danger">password length must be at least 5</p>
			  </div>
			  <label >Birthday</label>
			  <div class = "row">
			
					<div class="form-group col-lg-2 col-md-2 col-xs-4">
			    		<select class="form-control" id="date" data-toggle="tooltip" data-placement="top" title="Please choose a date">
			    			<option>Day</option>
			    			<?php 
								for ($x = 1; $x < 32; $x++) {
    								echo "<option value='". $x ."'>" .$x. "</option>";
								} 
							?>
						 </select>
					 </div>
					 <div class="form-group col-lg-3 col-md-2 col-xs-4">
					    <select class="form-control" id="month" data-toggle="tooltip" data-placement="top" title="Please choose a month" >
					    	<option value="0">Month</option>
						    <option value="1">Jan</option>
						    <option value="2">Feb</option>
						    <option value= "3">Mar</option>
						    <option value="4">Apr</option>
						    <option value="5">May</option>
						    <option value="6">Jun</option>
						    <option value="7">Jul</option>
						    <option value="8">Aug</option>
						    <option value="9">Sep</option>
						    <option value="10">Oct</option>
						    <option value="11">Nov</option>
						    <option value="12">Dec</option>
						    
						  </select>
					 </div>
					 <div class="form-group col-lg-2 col-md-2 col-xs-4">
					    <select class="form-control" id="year" data-toggle="tooltip" data-placement="top" title="Please choose a year" >
					    	<option>Year</option>
						    <?php 
						      	$currentyear = date("Y");
						      	$year = intval($currentyear);
						      	
								for ($x = $currentyear; $x > $currentyear -100; $x--) {
    								echo "<option value='". $x ."'>" .$x. "</option>";
								} 
							?>
						  </select>
					 </div>
				
			  </div>
			  <div class="form-group">
				  <div class="radio-inline">
				  	<label><input type="radio" name="gender" checked value = "m">Male</label>
				  </div>
				  <div class="radio-inline">
					  <label><input type="radio" name="gender" value = "f">Female</label>
				   </div>
				  </div> 
			  <button type="submit" class="btn btn-default btn-success btn-lg" id="signup">Sign Up</button>
			</form>
    	</div>

    </div>