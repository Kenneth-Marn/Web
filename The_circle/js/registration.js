$(function(){
	//errors in the input fields 
	var error_firstname = true;
	var error_lastname  = true;
	var error_email = true;
	var error_password = true;

	var date = 0;
	var month = 0;
	var year = 0;
	var firstname;
	var lastname;
	var email;
	var password;
	$("#password_error_msg").hide();
	//When user leave firstname field check if it's empty
	$("#firstname").focusout(function(){
		firstname = $("#firstname").val();
		if (!check_name(firstname)){
			//a little warning 
			$("#firstname").tooltip('show');
		}
		else
			error_firstname = false;
	});
	//hide any error message if user start typing again
	$("#firstname").focus(function(){
		$("#firstname").tooltip('hide');
	});
	//check lastname
	$("#surname").focusout(function(){
		lastname = $("#surname").val();

		if (!check_name(lastname)){
			//a little warning 
			$("#surname").tooltip('show');
			
		}
		else
			error_lastname = false;
	});
	$("#surname").focus(function(){
		$("#surname").tooltip('hide');
	});
	//check email
	$("#email").focusout(function(){
		email = $("#email").val();
		if(!check_email(email)){
			
			$("#email").tooltip('show');
		
		}
		else
			error_email = false;
	});
	//hide any tooltip if the email is focused again
	$("#email").focus(function(){
		$("#email").tooltip('hide');
	});

	//check password
	$("#password").focusout(function(){
		password = $("#password").val();
		if (!check_password(password)){
		
			$("#password_error_msg").show();
		}
		else
			error_password =false;
	});
	$("#password").focus(function(){
		$("#password_error_msg").hide();
	});

	$("#date").change(function(){
		date = this.value;
		if(date>0)
			$("#date").tooltip('hide');	
	
	});
	$("#month").change(function(){
		month = $("#month").val();
		if(month >0)
			$("#month").tooltip('hide');
	});
	$("#year").change(function(){
		year = this.value;
		if(year>0)
			$("#year").tooltip('hide');

	});
	
	$("#registration_form").submit(function(event){
	
		event.preventDefault();
		//check if they chose a birthday

		if (date == 0 || month ==0 || year ==0 ||
			error_firstname || error_email || error_lastname || error_password){
			if (date == 0)
				//tooltip on date
				$("#date").tooltip('show');
			//check month
			if (month == 0)
				//tooltip on date
				$("#month").tooltip('show');
			//check year
			if (year == 0)
				//tooltip on year
				$("#year").tooltip('show');
			if(error_firstname){
				$("#firstname").tooltip('show');
				console.log("meo hieu");
			}
			if(error_lastname)
				$("#surname").tooltip('show');
			if(error_email)
				$("#email").tooltip('show');
			if(error_password)
				$("#password_error_msg").show();

			return;

		}
		var birthday = year + "-" + month+"-" + date; 
		//if no error --> submit
		//get the gender
		var gender = $('input[name=gender]:checked').val();
		//create a ajax object and send to the server
		reg_info = {firstname: firstname, lastname: lastname,
			email: email, password: password,
			dob: birthday, gender: gender
		}	

		//send to sever
		$.ajax({
			url:'registration.php',
			type:'post',
			data: reg_info,
			success:function(data){
				
				//successfully registered
				if (data.hasOwnProperty('success')){
					//moved to another page to import a profile image
					location.href = "ProfilePicture.php";
				}
				//duplicate email
				else{
					alert("This email has already been registered, please choose another one!");
				}
			}
		});
	});


});