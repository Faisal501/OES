
</div> <!-- container div-->

  <div class="navbar user">
    <a href="<?php echo BASEURL; ?>/user/users?check=index" class="tab">
        <i class="fa fa-home"></i>
              <span>Exams</span></a>
    <a href="<?php echo BASEURL; ?>/user/users?check=myexam" class="tab">
        <i class="fa fa-tasks"></i>
              <span>My Exams</span></a>
    <a href="<?php echo BASEURL; ?>/user/users?check=result" class="tab">
        <i class="fa fa-book"></i>
              <span>Result</span></a>
    <a href="<?php echo BASEURL; ?>/user/users?check=profile" class="tab" id="profile">
        <i class="fa fa-user"></i>
              <span>Profile</span></a>
    <a href="<?php echo BASEURL ?>/user/logout" class="tab">
        <i class="fa fa-sign-out"></i>
              <span>Logout</span></a>
  </div>


<!-- ################################################ Scripts#######################################################-->
<?php linkJS("assets/js/jquery.min.js"); ?>
<?php linkJS("assets/js/bootstrap.min.js"); ?>
<?php linkJS("assets/js/parsley.js"); ?>
<?php linkJS("assets/js/popper.min.js"); ?>
<?php linkJS("assets/js/jquery.dataTables.min.js"); ?>
<?php linkJS("assets/js/dataTables.bootstrap4.min.js"); ?>
<?php linkJS("assets/js/userView.js"); ?>

</body>
</html>
