<body>

<?php
	//check all if logged, then check if register form is valid.

	session_start();
	if(isset($_POST['username']) && isset($_POST['password'])){
		if(isset($_POST['email']) && isset($_POST['validation-password']) ){

			$errors = $userController->register();
			echo $errors;
		}else{
			$error = $userController->login();
			if(!empty($error)){echo $error;};
		}
	}

	if(isset($_SESSION['loggedin'])){
		  header("Location:index.php?controller=dashboard");
	}

	echo $userController->getName();

?>
	<div class="container">
		<div class="row">
		    <div class="col col-xs-12">
		      <h1 class='login_head'> Dev Challenge </h1>
		    </div>
	  	</div>
	  	<input type='checkbox' id='form-switch'>
	  	<form id='login_form' action='' method='post'>
			<div class="form-row loginForm active" id='login'>
			    <div class="col-xs-12 offset-lg-2 col-lg-4 offset-xs-2 col-xs-10">
			      	<input type='text' class='form-control loginp' name='username' placeholder='Username' required> 
			    </div>
			    <div class="col-xs-12 col-lg-4">
			    	 <input type='password' class='form-control loginp' name='password' placeholder='password' required> 
			    </div>
			</div>
			<div class='form-row'>
				 <div class="col-xs-12 col-lg-12 fixbot">
	  				<button id="login-btn" type="submit"><img  width='240' src="images/Login_button.png"/></button>
	  				<p>New to the challenge?  <label for='form-switch'><span>Sign Up</span></label></p>
			    </div>
			</div>
		</form>
		<form id='register_form' action='' method='post' enctype="multipart/form-data">
			<div class="form-row loginForm" id='register'>
			    <div class="col-xs-12 offset-lg-2 col-lg-4">
			      	<input type='text' class='form-control loginp' name='username' placeholder='Username' required> 
			      	<input type='password' class='form-control loginp' name='password' placeholder='Password' required> 
			    </div>
			    <div class="col-xs-12 col-lg-4">
			    	 <input type='email' class='form-control loginp' name='email' placeholder='Email' required> 
			    	 <input type='password' class='form-control loginp' name='validation-password' placeholder='Confirm Password' required> 
			    </div>
			    
			    <div class="col-xs-12 offset-lg-4 col-lg-12">
						<div class="image-upload">
							<label for="image-input">
								<img id='pic-prev' src="images/Add_picture.png"/>
							</label>
							 <div id='addpc' class="pic-centered">Add picture</div>
								<input id="image-input" name='profile-pic'  onchange="readURL(this);" type="file"/ required>
						</div><br>
				</div>
				<div class="col-xs-12 offset-lg-4 col-lg-12">
	  				<button id="register-btn" type="submit"><img  width='240' src="images/Register_button.png"/></button>
	  			</div>


			</div>
		</form>


	</div>
</body>

<!-- function to show the preview of the thumbnail, for the uploaded picture -->
<script type="text/javascript">
	  function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#pic-prev')
                        .attr('src', e.target.result);
                };
                document.getElementById("addpc").style.display = "none";

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
</html>