<?php
   session_start();
   include("dbConnect.php");
   $cmd = $_REQUEST['cmd'];
   $current_date = date("Y-m-d H:i:s");
   if(isset($_POST["btn_login"])){
   	$email = mysqli_real_escape_string($mysqli,$_REQUEST["email"]);
	   $password = mysqli_real_escape_string($mysqli,$_REQUEST["password"]);
	   $msg="";
	   if($email == ""){
	      $msg = '<div class="alert alert-danger"><ul><li>Please Enter Email Address</li></ul></div>';
	   }
	   else if($password == ""){
	   	$msg = '<div class="alert alert-danger"><ul><li>Please Enter Password</li></ul></div>';
	   }
	   else{
	      $query = "SELECT id,email,user_type  FROM tbl_user WHERE email = '$email' AND password = '$password' AND status = '1' AND user_status = '0'";
	      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
	      $num_rows = mysqli_num_rows($res);
	      if($num_rows > 0){
	         $row = mysqli_fetch_assoc($res);
	         $user_type = $row["user_type"];
	         if($user_type == "0"){
	         	$_SESSION["email"] = $row["email"];
		         $_SESSION["user_type"] = $user_type;
		         $_SESSION["user_id"] = $row["id"];
		         header("Location:".$superadmin_url);
		         exit();
	         }
	         if($user_type == "1"){
	         	$_SESSION["email"] = $row["email"];
		         $_SESSION["user_type"] = $user_type;
		         $_SESSION["user_id"] = $row["id"];
	         	header("Location:".$admin_url);
	         	exit();
	         }
	         if($user_type == "2"){
	         	$_SESSION["email"] = $row["email"];
		         $_SESSION["user_type"] = $user_type;
		         $_SESSION["user_id"] = $row["id"];
	         	header("Location:".$customer_url);
	         	exit();
	         }
	         if($user_type == "3"){
	         	$_SESSION["email"] = $row["email"];
		         $_SESSION["user_type"] = $user_type;
		         $_SESSION["user_id"] = $row["id"];
	         	header("Location:".$projectmanager_url);
	         	exit();
	         }
	         if($user_type == "4"){
	         	$_SESSION["email"] = $row["email"];
		         $_SESSION["user_type"] = $user_type;
		         $_SESSION["user_id"] = $row["id"];
	         	header("Location:".$employee_url);
	         	exit();
	         }
	      }
	      else{
	         $msg = '<div class="alert alert-danger"><ul><li>Invalid Email Or Password</li></ul></div>';
	      }
	   }
   }
   
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Unibyz.com.</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
  	.back-image{
		background: url(dist/img/bg.jpeg) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
  	}
  </style>
</head>
<body class="hold-transition login-page back-image" style="">
<div class="login-box">
  <div class="login-logo">
	 <a href="javascript:void(0)"><img src="uploads/logo/imgpsh_fullsize.png" style="width:300px;height:150px;"></a>
  </div>
  <div class="login-box-body">
	 <?php echo (isset($msg) ? $msg : '<p class="login-box-msg">Sign in to start your session</p>');?>
		<form action="login.php" method="post" id="login_form">
			<div class="form-group has-feedback">
			  <input type="email" name="email" class="form-control" placeholder="Email" id="email" required="required" autocomplete="off">
			  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
			  <input type="password" id="password" class="form-control" placeholder="Password" name="password" required="required" autocomplete="off">
			  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
			  <div class="col-xs-8">
				 <div class="checkbox icheck">
				 </div>
			  </div>
			  <div class="col-xs-4">
				 <button type="submit" name="btn_login" class="btn btn-primary btn-block btn-flat">Login</button>
			  </div>
			</div>
	 	</form>
	 	<div class="social-auth-links text-left">
			<a href="#" class=""><h5>I Forgot My Password ?</h5></a>
	 	</div>
  	</div>
</div>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
</body>
</html>
