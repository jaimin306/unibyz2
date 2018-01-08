<?php
	session_start();
	if(!isset($_SESSION["user_id"]) && empty($_SESSION)){
		header('location: ../login.php');
		exit();
	}

?>