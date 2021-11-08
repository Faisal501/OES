<?php require_once 'header.php';

?>

<section class="wrapper">
  <p id="message" class="text-center"></p>
	<div class="container">
		<div class="col-lg-12">
			<div class="panel">
			<img src="<?php echo BASEURL; ?>/assets/img/logo.png" alt="<?php echo $this->getSession('name');  ?>" height="100px" width="100px"/>
			<h3 class="logo" style="margin-top: -70px; padding-bottom: 20px;"><span><?php echo $this->getSession('name'); ?></span></h3>
			<form id="user_profile_form" class="profile-form">
			<fieldset>
        	<div class="form-group">
        	<div class="row">
    		<h4 class="col-lg-4 text-right">Full name :</h4>
    		<div class="col-lg-6">
            <input type="text" name="full-name" class="form-control" id="full-name" value="<?php echo $this->getSession('name');  ?>" />
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row">
        	<h4 class="col-lg-4 text-right">Email :</h4>
        	<div class="col-lg-6">
       <input type="email" name="email" class="form-control" id="email" value="<?php echo $this->getSession('email');  ?>"/>
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row">
        	<h4 class="col-lg-4 text-right">Mobile :</h4>
        	<div class="col-lg-6">
    <input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $this->getSession('mobile');  ?>"/>
       		</div>
       		</div>
            </div>
       		<div class="form-group">
            <div class="row">
        	<h4 class="col-lg-4 text-right">New Password :</h4>
        	<div class="col-lg-6">
        	<input type="password" name="password" class="form-control" id="password" placeholder="Enter new Password.." required/>
       		</div>
       		</div>
       		</div>
       		<div class="form-group">
            <div class="row">
       		<h4 class="col-lg-4 text-right"></h4>
       		<div class="col-lg-6">
       		<input type="submit" class="btn btn-outline-success form-control " id="update" value="Update"/>
       		</div>
       		</div>
       		</div>
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['userID']; ?>"  />
            <input type="hidden" id="category" name="category" value="user"/>
			<input type="hidden" id="check" name="check" value="updateProfile"/>
			</fieldset>
        	</form>
			</div>
		</div>
	</div>

  <input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />

</section>
<?php require_once 'footer.php' ?>
