<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$holiday_name = $_REQUEST["holiday_name"];
		$from_date = $_REQUEST["from_date"];
		$to_date = $_REQUEST["to_date"];
		$no_of_days = $_REQUEST["no_of_days"];
		$add_uid = $_SESSION["user_id"];

		$query = "INSERT INTO tbl_holiday (holiday_name,from_date,to_date,no_of_days,add_date,add_uid,status) VALUES ('".addslashes($holiday_name)."','".addslashes($from_date)."','".addslashes($to_date)."','".addslashes($no_of_days)."','$current_date','$add_uid','1')";

		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "success";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "delete"){
		$id = $_REQUEST["id"];

		$query = "DELETE FROM tbl_holiday WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "dsuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "update"){
		$id = $_REQUEST["id"];
		$holiday_name = $_REQUEST["holiday_name"];
		$from_date = $_REQUEST["from_date"];
		$to_date = $_REQUEST["to_date"];
		$no_of_days = $_REQUEST["no_of_days"];

		$query = "UPDATE tbl_holiday SET holiday_name = '".addslashes($holiday_name)."', from_date = '".addslashes($from_date)."' , to_date = '".addslashes($to_date)."' , no_of_days = '".addslashes($no_of_days)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "usuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
?>