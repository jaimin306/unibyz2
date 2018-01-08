<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");

	if($cmd == "insert"){
		$weekly_holiday = implode(',', $_REQUEST['weekly_holiday']);
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_leave (weekly_holiday,add_date,add_uid,status) VALUES ('".addslashes($weekly_holiday)."','$current_date','$add_uid','1')";
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
	if($cmd == "update"){
		$id = $_REQUEST["id"];

		$del = "DELETE FROM tbl_leave WHERE id = '$id'";
		$res_del = mysqli_query($mysqli,$del) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res_del){
			$add_uid = $_SESSION["user_id"];
			$weekly_holiday = implode(',', $_REQUEST['weekly_holiday']);	
			$query = "INSERT INTO tbl_leave (weekly_holiday,add_date,add_uid,status) VALUES ('".addslashes($weekly_holiday)."','$current_date','$add_uid','1')";
			$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			if($res){
				$data['result'] = "true";
				$data['status'] = "success";
			}
			else{
				$data['result'] = "false";
				$data['status'] = "error";
			}
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}

	
	
	if($cmd == "delete"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_leave WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query);
		
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

?>