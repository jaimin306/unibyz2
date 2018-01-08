<?php
	include("dbConnect.php");
	session_start();
	$_SESSION['user_id'] ="";
	$_SESSION['user_type'] = "";
	session_destroy();
	session_unset();
	header("Location: login.php");
?>