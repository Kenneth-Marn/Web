$(function(){

	//VARIABLES
	var statusImages = $("#statusImages");
	var imgFiles = [];
	var profile_image_basedir = "resources/images/profile/";
	var timeline_image_basedir = "resources/images/timeline/";
	var feed_content ='<div class="status">'+
				'<div class="status_header clearfix">'+
					'<img src="" class="followee_profile_img">'+
					'<p class="followee_prefName"></p>'+
					'<p class="time_ago"></p>'+
				'</div>'+
				'<div class="status_content">'+
					'<p class="content_text"></p>'+
					'<div class="content_images">'+
					'</div>'+
				'</div>'+
				'<div class="status_actions">'+
					'<a href=""><i class="fa fa-reply"></i></a>'+
					'<a href=""><i class="fa fa-heart"></i></a>'+
					'<a href=""><i class="fa fa-ellipsis-h"></i></a>'+
				'</div>'+

			'</div>';
	var $start = 0;
	var $limit =5;
	/********************************** WHEN PAGE LOADS *************************/

	//check if homepage --> get the feeds
	var url = window.location.href;
	//if only user is logged in
	if(localStorage.loggedIn == "true"){
		//used as a container for information about the feed
		if(url.indexOf("index.php") !=-1){
			getFeedsAndRender("getGlobalFeeds");
		}
		//if profile page --> get the feeds for this user
		else if(url.indexOf("profileUser.php") !=-1){
			getFeedsAndRender("getUserFeeds");
		}
	}
	/*----------------------------------***-----------------------------------*/

	// INSTALL EVENTS
	//loading spinner

	$body = $("body");

	$(document).on({
	    ajaxStart: function() { $body.addClass("loading");    },
	     ajaxStop: function() { $body.removeClass("loading"); }    
	});


	//events for log out button
	$("#logout").click(function(){
		logout_info = {method: "logout"};
			//send to sever
		$.ajax({
			url:'core/route.php',
			type:'post',
			data: logout_info,
			success:function(data){
				if(data === "success")
					location.reload();
			}

		});
	})
	//upload profile picture
	$("#choosePicture").click(function(){
		$("#pictureInput").trigger("click");
	});
	//when a photo is chosen 
	$("#pictureInput").change(function(){
		//preview the file
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		//check if the imange chosen is valid and the size is within the limit
		if (checkValidImageFile(file))
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}

	});
	//submit button clicked
	$("#uploadimage").on('submit',function(e){
		e.preventDefault();

		$.ajax({
			url: "core/uploadProfileImage.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				//if successfully added the profile picture --> move to home page
				if (data =="success"){
					location.href = "index.php";
				}
				
			}
		});
	});
	//clicking close icon in the "visiting people" notification 
	$("#notif a").click(function(){
		$("#visiting_people").remove();
	})

	//upload images in a status
	$("#add_photo").on("click",function(){
		$("#statusImages").trigger("click");
	});
	//display the thumbnails
	$("#statusImages").change(function(){
		var file ;
		var temp = [];
		//copy image objects to temp for easy manipulation
		for(i=0;i< $(this)[0].files.length;i++){
			temp[i] = $(this)[0].files[i];
		}
		//check if the image chosen is valid and the size is within the limit
		for(i=0;i< temp.length;i++){
			file = temp[i];
			if (checkValidImageFile(file))
			{
				var reader = new FileReader();
				reader.onload = imageIsLoadedStatus;
				reader.readAsDataURL(file);
			}
			//remove this file from the collections
			else{
				temp.splice(i,1);
				i--;
			}
		}
		//add the input file to oldfiles;
		$.merge(imgFiles,temp);

	});

	//post button
	$("#create_a_post").click(function(e){
		 $("#create_post").trigger("submit");
	});
	
	//post status images to server
	$("#create_post").on("submit",function(e){
		e.preventDefault();
		//create a post with status text first
		var status = $("#create_post span").text();
		if(status ==""){
			alert("Please write something");
			return false;
		}
		var form_data = new FormData();  
		for(var i=0; i< imgFiles.length; i++){
			form_data.append("statusImages[]", imgFiles[i]);
		}
		form_data.append("stat",status );
		form_data.append("method","post_status");

		$.ajax({
			url: "core/route.php",
			type: "POST", 
			data: form_data, 
			contentType: false , 
			processData: false,
			cache: false,  
			success: function(data)  
			{
			 	if(data.indexOf("success") !=-1){
			 		alert ("Your post has been successfully added");
			 		location.reload();
			 	}

			}
		});

	});	


	//more button. when user clicks on the more button --> load more feeds
	$("#more_data").click(function(){
		//if at home page --> get flobal feeds
		if(url.indexOf("index.php") !=-1){
			
			getFeedsAndRender("getGlobalFeeds");
			return false;
		}
		//if visiting profile user
		else if(url.indexOf("profileUser.php") !=-1){
			getFeedsAndRender("getUserFeeds");
			return false;
		}
	});



	/*---------------------------------------***-------------------------------*/

	//FUNCTIONS

	//load image from file
	function imageIsLoaded(e) {
		$('#choosePicture img').attr('src', e.target.result);
	};
	/*after the images are chosen(when creating a new post)*/
	function imageIsLoadedStatus(e){
		//create an image tag to store the image
		var new_photo = "<div class='status_photo_thumnail'><img  src='" + e.target.result + "'>";
		new_photo += "<span class='overlay'><i class='fa fa-close'></i></span> </div>";
		$("#photos_thumbnails").append(new_photo);
		//add event listener for this element
		$("#photos_thumbnails span").hover(
		  	function() {
		    	$( this ).addClass( "blurred" );
		    	$(this).find("i").css("display","inherit");
		    	$(this).find("i").click(function(event){
		    		//stop this event so that it would not bubble up
		    		 event.stopImmediatePropagation();
		    		//get the index of this element
		    		var siblingsCount  = $(this).parent().parent().siblings().length;
		    		var nextAllCount = $(this).parent().parent().nextAll().length;
		    		//get the index of current image
		    		var index = siblingsCount -nextAllCount;	
		    		//remove the corresponding element in the imgFiles array
		    		imgFiles.splice(index,1);
		    		console.log(imgFiles);

		    		//remove from the page
		    		$(this).parent().parent().remove();
		    		return;
		    	});
		  	}, function() {
		   	 	$( this ).removeClass( "blurred	" );
		   	 	$(this).find("i").css("display","none");	
		  	}
		);	
	}
	/* check the size and type of the image */
	function checkValidImageFile(file){
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg","image/gif"];
		var filesize = ((file.size/1024)/1024).toFixed(4); //to MB
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile ==match(3))))
		{
			alert ("Please choose an image file");
			return false;
		}
		//check the file size
		else if(filesize >3){
			alert("Please choose a file which is smaller than 3MB");
			return false;
		}
		else
			return true;
	}
	/* Create a feed using the data object*/
	function createFeed(a_feed){
		var new_feed = $.parseHTML(feed_content);
		$(new_feed).find(".followee_profile_img").attr("src",profile_image_basedir +a_feed["pictureName"]);
		$(new_feed).find(".followee_profile_img").attr("email",a_feed["byUser"]);
		
		$(new_feed).find(".followee_prefName").text(a_feed["preferedName"]);
		$(new_feed).find(".content_text").text(a_feed["message"]);
		$(new_feed).find(".time_ago").text(a_feed["time"]);
		//add images to the status
		//depend on the number of images --> different layout
		var images = a_feed["images"].split(",");
		if(images[0] == "")
			images.splice(0,1);
		switch(images.length){
			case 0:
				break;
			case 1: 
					var row = "<div class='row'>";		
					row += "<div class='row1 col-lg-12 col-md-12'></div></di>";
					$(new_feed).find(".content_images").append(row);
					$(new_feed).find(".row1").css("background-image",'url(' +timeline_image_basedir +images[0]+')');
					break;
			case 2:	
					var row = "<div class='row row2_1 clearfix'>";	
					//row += "<img class=' pic1 col-md-6 col-lg-6' src=''/>" ;
					//row += "<img class=' pic2 col-md-6 col-lg-6' src=''/></div>" ;
					row +="<div class=' pic1 col-md-6 col-lg-6' ></div>";
					row += "<div class=' pic2 col-md-6 col-lg-6'></div></div>";
					$(new_feed).find(".content_images").append(row);
					$(new_feed).find(".content_images .pic1").css("background-image",'url(' +timeline_image_basedir +images[0] + ')');
					$(new_feed).find(" .content_images .pic2").css("background-image",'url(' +timeline_image_basedir +images[1] + ')');
					break;

			case 3:
					var row = "<div class='row row1' >";	
					row += "<div class=' pic1 col-md-12 col-lg-12'></div></div>" ;
					row += "<div class='row row2'>";	
					row += "<div class='pic1 col-md-6 col-lg-6' ></div>" ;
					row += "<div class='pic2 col-md-6 col-lg-6' ></div></div>" ;
					$(new_feed).find(".content_images").append(row);
					$(new_feed).find(".row1  .pic1").css("background-image",'url(' +timeline_image_basedir +images[0] +')');
					$(new_feed).find(".row2  .pic1").css("background-image",'url(' +timeline_image_basedir +images[1] + ')');
					$(new_feed).find(".row2 .pic2").css("background-image",'url(' +timeline_image_basedir +images[2] +')');
					break;
				break;
			case 4:
				break;
			case 5:
				break;
			default:
			break;
		}
		$(new_feed).insertBefore("#more_data");

	}
	/* Get feed and render the page */
	function getFeedsAndRender($method){
		var userEmailPost="";
		//Only when getting user's feeds, the userEmail is needed
		if ($method == "getUserFeeds")
			userEmailPost = localStorage.userEmail;
		$.ajax({
				url: "core/route.php",
				type: "POST",
				data: {method: $method,userEmail: userEmailPost,start: $start, limit: $limit},
				success: function(data){
					//parse the data and construct the feed
					for(var i=0;i<data.length; i++){
						createFeed(data[i]);
					}
					$start += $limit;
						//clicking on the profile image of a owner of a feed will direct to their 
					//main page
					$(".status_header .followee_profile_img").click(function(){

						//get the userEmail of this profile picture
						localStorage.userEmail = $(this).attr("email");
						location.href = "profileUser.php";
					});
				}
		});

	}
});













