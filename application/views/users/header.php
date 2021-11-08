<?php if(!isset($_SESSION['userID'])){
  $this->redirect('login');
} ?>
<!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
  <?php linkCSS("assets/css/bootstrap.min.css"); ?>
  <?php linkCSS("assets/css/dataTables.bootstrap4.min.css"); ?>
  <?php linkCSS("assets/css/font-awesome.min.css"); ?>
  <?php linkCSS("assets/css/flipclock.css"); ?>

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
			background: #ffffff;
			box-shadow: 5px 5px 5px #aab2bd;
			margin-top: 10px;
			margin-bottom: 10px;
	}

	.user {
	  overflow: hidden;
	  background-color: #333;
	  position: fixed;
	  bottom: 0;
	  width: 100%;
	}

	.user a {
	  float: left;
	  display: block;
	  color: #f2f2f2;
	  text-align: center;
	  padding: 4px 4px;
	  text-decoration: none;
	  font-size: 12px;
	}

	.user a:hover {
	  background-color: #ddd;
	  color: black;
	  border-radius: 25px;
	}

	.user a.active {
	  background-color: #4CAF50;
	  color: white;
	  border-radius: 25px;
	}
	.panel {
	  margin-top: 2%;
	  padding-left:5%;
	  padding-right:5%;
	  padding-bottom:5%;
	  padding-top:0%;
	}
	.question-panel {
		margin-top: 10px;
	  display: flex;
	}
	.question-panel img{
	  margin-left: 35%;
	  margin-bottom: 5%;
	  margin-top:5%;
	}

	</style>
<head>
	<title>Student Area</title>
</head>
<body>
<div class="header">
	  <!--logo start-->
    <b class="logo">online <span>Examination</span> System</b>
	  <!--logo end-->
</div>
	<div class="container-fluid">
