<?php
	if(isset($_GET['check']))
	{
		$verify = $_GET['check'];
?>
	<input type="hidden" id="verify" value="<?php echo $verify; ?>">
<?php } ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php linkCSS("assets/css/bootstrap.min.css"); ?>
	<style media="screen">
	body{
		color: #797979;
		background-size: cover;

	}
	.header{
			background-color:black;
			text-align: center;
			margin-bottom: 0px;
			height: 60px;
		 padding: 5px;
	}
	.logo {
			font-size: 24px;
			color: white;
			text-align: center;
			padding: 3%;
			text-transform: uppercase;
	}
	.logo b {
			font-weight: 900;
	}
	.logo span {
			color: #4ECDC4;
	}

	.wrapper {
			display: inline-block;
			padding-bottom: 2%;
			padding-left: 2%;
			padding-right: 2%;
			width: 100%;
			background: black;
			box-shadow: 5px 5px 5px #aab2bd;
			margin-top: 10px;
			margin-bottom: 10px;
	}

	.login {
		padding:5%;
		background-image:linear-gradient(black, black);
		text-align: left;
		box-shadow:0px 0px 1px 1px gray;
		margin-left:10px;
		margin-top:20%;

	}

	.middle-border img{
		display: block;
		margin-left: 33%;
		margin-right: 33%;
	}
	.register {
		padding:5%;
		background-image:linear-gradient(black, black);
		text-align: left;
		box-shadow:0px 0px 1px 1px gray;
		margin-right: 10px;
		margin-top:20%;



	}

	.parsley-required , .parsley-pattern , .parsley-type , .parsley-equalto
	{
		color:red;
	}


	</style>

	<meta charset="UTF-8">
	<title>OES</title>
</head>
<body>
	<div class="header">
    <b class="logo">online <span>Examination</span> System</b>
	</div>
	<div class="container">
		<section class="wrapper">
			<p id="message" class="text-center"></p>
			<div class="row">
				<div class="col-lg-5">
                	<div class="login">
	                    <form id="loginForm" class="login-form">
	                    	<h3 class="logo"><span>Login into Account</span></h3>
	                    	<p id="loginMessage" class="text-danger"></p>
	                    	<div class="form-group">
						    <input id="email" type="text" class="form-control" name="email" placeholder="Email" autocomplete="off"/>
						  	</div>
						  	<div class="form-group">
						  	<input id="password" type="password" class="form-control" name="password" placeholder="Password" autocomplete="off"/>
						  	</div>
						  	<input type="hidden" id="check" name="check" value="L">
	                        <input type="submit" class="btn btn-primary btn-block" id="login" value="Log in"/>
	                    </form>
                    </div>
                </div>

           <div class="col-sm-1 middle-border"><img src="<?php echo BASEURL; ?>/assets/img/logo.png" height="100px" width="100px" /></div>
                        <div class="col-sm-1"></div>

    <div class="col-lg-5">
        <div class="register">
            <form id="user_registeration_form" class="registration-form">
            	<h3 class="logo"><span>Registration Form</span></h3>
            	<p id="userReg" class="text-danger"></p>
            	<div class="form-group">
        		<label class="sr-only" for="full-name">Full name</label>
                <input type="text" name="full-name" placeholder="Full name..."
                autocomplete="on" class="form-control" id="full-name"/>
                </div>
                <div class="form-group">
            	<label class="sr-only" for="email">Email</label>
            	<input type="email" name="emailR" placeholder="Email..."
            	autocomplete="on" class="form-control" id="emailR"/>
                </div>
                <div class="form-group">
            	<label class="sr-only" for="mobile">Mobile</label>
            	<input type="text" name="mobile" placeholder="Mobile..."
            	autocomplete="on" class="form-control" id="mobile"/>
           		</div>
           		<div class="form-group">
			  	<input id="password1" type="password" class="form-control" name="password1" minlength="6" placeholder="Password.."/>
			  	</div>
			  	<div class="form-group">
			  	<input id="password2" type="password" class="form-control" name="password2" placeholder="Repeat pass"/>
			  	</div>
				<input type="hidden" id="category" name="category" value="user">
				<input type="hidden" id="check" name="check" value="R">
                <input type="submit" class="btn btn-primary btn-block" id="register" value="Register"/>
            </form>
        </div>
    </div>
			</div>
		</section>
	</div>













<!-- ################################################ Scripts#######################################################-->
	<?php linkJS("assets/js/jquery.min.js"); ?>
	<?php linkJS("assets/js/bootstrap.min.js"); ?>
	<?php linkJS("assets/js/parsley.js"); ?>
	<script type="text/javascript">


		$(document).ready(function(){

		$('#user_registeration_form').parsley();

			$('#user_registeration_form').on('submit', function(e){
			e.preventDefault();

			$('#full-name').attr('required', 'required');

			$('#full-name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

			$('#emailR').attr('required', 'required');

			$('#emailR').attr('data-parsley-type', 'email');

			$('#password1').attr('required', 'required');

			$('#password2').attr('required', 'required');

			$('#password2').attr('data-parsley-equalto', '#password1');

			$('#mobile').attr('required', 'required');

			$('#mobile').attr('data-parsley-pattern', '[0-9]{4}[0-9]{7}');


			if($('#user_registeration_form').parsley().validate())
			{
				$.ajax({
					url:"<?php echo BASEURL; ?>/login/register",
					method:"POST",
					data:$(this).serialize(),
					dataType:"json",
					cache:false,
					processData:false,
					beforeSend:function()
					{
						$("#userReg").html('<div class="alert alert-danger">Processing Request</div>');
						$('#register').attr('disabled', 'disabled');
						$('#register').val('please wait...');
					},
					success:function(data)
					{
						if(data.success)
						{
							$('#userReg').html('<div class="alert alert-success">'+data.success+'</div>');
							$('#user_registeration_form')[0].reset();
							$('#user_registeration_form').parsley().reset();
						}
						if(data.error)
						{
							$('#userReg').html('<div class="alert alert-danger">'+data.error+'</div>');
							$('#user_registeration_form')[0].reset();
							$('#user_registeration_form').parsley().reset();
						}
						$('#register').attr('disabled', false);

						$('#register').val('Register');
					}
				})
			}

		});


			$('#loginForm').parsley();
			$('#loginForm').on('submit',function(e){
				 e.preventDefault();

		$('#email').attr('required','required');
		$('#email').attr('data-parsley-type', 'email');
		$('#password').attr('required','required');

		if($('#loginForm').parsley().validate())
		{
			$.ajax({

				url:"<?php echo BASEURL; ?>/login/login",
					method:"POST",
					data:$(this).serialize(),
					dataType:"json",
					cache:false,
					processData:false,

					success:function(data)
				{
						if (data.success == 'user')
				{
					window.location.replace("user/users?check=index");
				}
				if (data.success == 'admin')
				{
					$('#loginMessage').html('<div class="alert alert-danger">Admin ! Please log into Admin panel</div>');
				}
				if (data.error == 'notVerified')
				{
					$('#loginMessage').html('<div class="alert alert-danger">User ! Please verify your account first</div>');
				}
				if (data.error == 'incorrect')
				{
					$('#loginMessage').html('<div class="alert alert-danger">Email or Password is incorrect</div>');
				}
					}
					})
		}
				});


			var account_Verification = $('#verify').val();

			if(account_Verification == 'v')
			{
				$('#message').html('<div class="alert alert-success">Thank you for Verification you can Log in now</div>');
			}
			if(account_Verification == 'ad')
			{
				$('#message').html('<div class="alert alert-danger">Account Already verifired</div>');
			}
			if(account_Verification == 'ia')
			{
				$('#message').html('<div class="alert alert-danger">Invalid Account</div>');
			}

	});

	</script>

</body>
</html>
