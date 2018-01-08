<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$salary_name = $_REQUEST["salary_name"];
		$salary_type = $_REQUEST["salary_type"];
		$default_amount = $_REQUEST["default_amount"];
		$add_uid = $_SESSION["user_id"];

		$query = "INSERT INTO tbl_salary_type(salary_name,salary_type,default_amount,add_date,add_uid,status) VALUES ('".addslashes($salary_name)."','".addslashes($salary_type)."','".addslashes($default_amount)."','$current_date','$add_uid','1')";
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
		$salary_name = $_REQUEST["salary_name"];
		$salary_type = $_REQUEST["salary_type"];
		$default_amount = $_REQUEST["default_amount"];

		$query = "UPDATE tbl_salary_type SET salary_name = '".addslashes($salary_name)."', salary_name = '".addslashes($salary_name)."', default_amount = '".addslashes($default_amount)."' WHERE id = '$id'";
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

	if($cmd == "delete"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_salary_type WHERE id = '$id'";
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

?>