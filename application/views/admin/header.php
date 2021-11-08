<?php if(!isset($_SESSION['userID'])){
  $this->redirect('admin');
} ?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<?php linkCSS("assets/css/bootstrap.min.css"); ?>
<?php linkCSS("assets/css/dataTables.bootstrap4.min.css"); ?>
<?php linkCSS("assets/css/font-awesome.min.css"); ?>
<?php linkCSS("assets/css/bootstrap-datetimepicker.css"); ?>
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
.wrapper {
    display: inline-block;
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
    width: 100%;
    background: white;
    box-shadow: 5px 5px 5px #aab2bd;
    margin-top: 10px;
    margin-bottom: 10px;
}
.admin {
  overflow: hidden;
  background-color: #333;
  width: 100%;
}

.admin a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 4px 4px;
  text-decoration: none;
  font-size: 12px;
}

.admin a:hover {
  background-color: #ddd;
  color: black;
  border-radius: 25px;
}
</style>
<head>
	<title>Admin Area</title>
</head>
<body>
<div class="header">
	  <!--logo start-->
    <b class="logo">online <span>Examination</span> System</b>
	  <!--logo end-->
</div>

  <div class="navbar admin">

    <a href="<?php echo BASEURL; ?>/admin/admin?check=admin" id="admin" class="tab">
              <i class="fa fa-tasks"></i>
              <span>Exams</span>
              </a>
    <a href="<?php echo BASEURL; ?>/admin/admin?check=questionBank" id="quizBankData" class="tab">
           <i class="fa fa-edit"></i>
           <span>Question Bank</span>
           </a>
    <a href="<?php echo BASEURL; ?>/admin/admin?check=viewUser" id="viewUser" class="tab">
              <i class="fa fa-users"></i>
              <span>Registered Users</span>
              </a>
    <a href="<?php echo BASEURL; ?>/admin/admin?check=prepareResult" id="prepareResult" class="tab">
              <i class="fa fa-bar-chart-o"></i>
              <span>Prepare Result</span>
              </a>

		<a href="<?php echo BASEURL; ?>/admin/admin?check=viewResult" id="viewResult" class="tab">
              <i class="fa fa-users"></i>
              <span>View Result</span>
              </a>
    <a href="<?php echo BASEURL; ?>/admin/logout" id="logout" class="tab">
          <i class="fa fa-sign-out"></i>
          <span>Log Out</span>
          </a>

  </div>

  <div class="container-fluid">
