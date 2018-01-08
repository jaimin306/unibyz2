<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$department_name = $_REQUEST["department_name"];
		$department_code = $_REQUEST["department_code"];
		$add_uid = $_SESSION["user_id"];

		$query = "INSERT INTO tbl_department (department_name,department_code,add_date,add_uid,status) VALUES ('".addslashes($department_name)."','".addslashes($department_code)."','$current_date','$add_uid','1')";
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
		$department_name = $_REQUEST["department_name"];
		$department_code = $_REQUEST["department_code"];

		$query = "UPDATE tbl_department SET department_name = '".addslashes($department_name)."', department_code = '".addslashes($department_code)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_department WHERE id = '$id'";
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