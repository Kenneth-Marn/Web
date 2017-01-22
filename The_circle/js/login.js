$(function(){
	var login_email_error = true;
	var login_password_error = true;
	var login_email;
	var login_password;
	//login email
	$("#login_email").focusout(function(){
		login_email  = $(this).val();
		if(!check_name(login_email)){
			$(this).tooltip('show');
		}
		else
			login_email_error = false;
	});
	$("#login_email").focus(function(){
		$(this).tooltip('hide');
	});

	//login password
	$("#login_password").focusout(function(){
		login_password = $(this).val();
		if(!check_name(login_password))
			$(this).tooltip('show');
		else
			login_password_error = false;
	});
	$("#login_password").focus(function(){
		$(this).tooltip('hide');
	});

	//submission
	$("#login_form").submit(function(event){
		event.preventDefault();
		//check if any error with email and password
		if(login_password_error || login_email_error){
			if(login_password_error)
				$("#login_password").tooltip('show');
			if(login_email_error)
				$("#login_email").tooltip('show');
			return;
		}
		
		//valid email and password, send login info to server
		else{
			login_info = {method: "login", email: login_email, password: login_password};
				//send to sever
			$.ajax({
				url:'core/route.php',
				type:'post',
				data: login_info,
				success:function(data){
					//successfully registered
					if (data.hasOwnProperty('success')){
						//get the profile image
						$.ajax({
							url:'core/route.php',
							type:'post',
							data: {method:"getProfileImage", email: login_email},
							success:function(data){
								localStorage.loggedIn = true;
								location.href = "index.php";
								localStorage.loggedIn_userEmail = login_email;
							},
							error: function(data){
								location.href = "index.php";
							}
						});
					}
					//wrong email or password
					else{
						alert(data);
					}
				}

			});
		}
	});



});










