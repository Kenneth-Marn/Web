<div class ="container">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 myprofile">
		<div class="statistic">
			<div class="profile_pic">
				<p class="preferedName"><?php echo $_SESSION["preferedName"]; ?></p>
				<a href="#"><img src="<?php echo( $profileBaseURL . $_SESSION['name']); ?>" class="profilePicture"></a>
			</div>
			<div class="personalInfo">
				<p class="birthday"><i class="fa fa-birthday-cake"></i><?php $date=date_create($_SESSION["dob"]); echo date_format($date,"F d, Y" ) ?></p>
				<p class="bio"><i class="fa fa-asterisk"></i><?php echo $_SESSION["bio"]?></p>
			</div>
		</div>
		<div class="interests">
			<p> Interests</p>

		</div>
		

		<div class="group_event_photo">

		</div>
		<div class="visting_people" id="visiting_people">
			<div class="notif" id = "notif">
				<a href="#"><i class="fa fa-remove"></i></a>
				<p>Hey!</p>
				<p>People are looking at your profile. Find out who.</p>
			</div>

		</div>

	</div>
	<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 main_content">
		<div class="create_post_dialog">
			<p class="create_a_post"><i class="fa  fa-pencil"></i>Create a Post</p>
			<form method="POST" id = "create_post" action="core/route.php" enctype="multipart/form-data">
				<div class="form-group">
					<!--<textarea placeholder="What's on your mind"></textarea> -->
					<span contentEditable=true></span>
				</div>
				<div class="form-group">
					<input id="statusImages" name="statusImages[]" type="file" class="hidden" multiple>
				</div>
				<div id="photos_thumbnails">
				</div>
				<div class="form-group" id = "add_photo_fg">
					<a href="#" class="form-group" id ="add_photo"><i class="fa fa-camera"></i>Add photo</a>
				</div>

			</form>	
			<p class="create_a_post clearfix" id ="create_a_post"><a href="#" class="post_btn">Post</a></p>
			
		</div> <!-- End create post dialog>
		<!-- display only 20 posts from friends, ordered by time stamp -->
		<a href= "#" class= "btn btn-primary" id = "more_data">More</a>

		
	</div>
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

	</div>
	<div class="modal"></div>
</div>

