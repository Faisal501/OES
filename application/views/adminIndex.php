
<!DOCTYPE html>
<html lang="en">
<head>
	<?php linkCSS("assets/css/bootstrap.min.css"); ?>
	<style media="screen">
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
	.loginA {
		padding:4%;
		background-image:linear-gradient(black, black);
		box-shadow: 5px 5px 5px gray;
		text-align: left;
		margin-top:50px;
		margin-left: 33%;
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
		<div class="row ">
			<div class="col-lg-9">
                <div class="loginA">
                	<img src="<?php echo BASEURL; ?>/assets/img/logo.png" height="100px" width="100px" style="margin-left: 40%;" />
	                <form id="loginFormAdmin" class="login-form">
	                    <h3 class="logo"><span>Admin Login</span></h3>
	                    <p id="adminMessage"></p>
                        <div class="form-group">
                    <input id="emailA" type="text" class="form-control" name="email" placeholder="Email"/>
                        </div>
                        <div class="form-group">
                    <input id="passwordA" type="password" class="form-control" name="password" placeholder="Password"/>
                        </div>
                        <input type="hidden" id="check" name="check" value="L" />
                        <input type="submit" class="btn btn-primary btn-block" id="loginA" value="Log in"/>
                    </form>
                </div>
            </div>
		</div>
    </div>
</div>
<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
<!-- ################################################ Scripts#######################################################-->
<?php linkJS("assets/js/jquery.min.js"); ?>
<?php linkJS("assets/js/bootstrap.min.js"); ?>
<?php linkJS("assets/js/parsley.js"); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#loginFormAdmin').parsley();
  	$('#loginFormAdmin').on('submit',function(e){
	e.preventDefault();

	$('#emailA').attr('required','required');
	$('#emailA').attr('data-parsley-type', 'email');
	$('#passwordA').attr('required','required');

	if($('#loginFormAdmin').parsley().validate())
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
        	if (data.success == 'admin')
			{
				window.location.replace("admin/admin?check=admin");
			}
			if (data.success == 'user')
			{
				$('#adminMessage').html('<div class="alert alert-danger">You are Student not Admin !</div>');
			}
			if (data.error == 'notVerified')
			{
				$('#adminMessage').html('<div class="alert alert-danger">Admin ! Please verify your account first</div>');
			}
			if (data.error == 'incorrect')
			{
				$('#adminMessage').html('<div class="alert alert-danger">Email or Password is incorrect</div>');
			}
        }
				})
	}
  		});
	});
</script>
</body>
</html>
