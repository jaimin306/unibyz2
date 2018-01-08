<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$category_id = $_REQUEST["category_id"];
		$service_type_name = $_REQUEST["service_type_name"];
		$add_uid = $_SESSION["user_id"];
		
		$query = "INSERT INTO tbl_service_type (category_id,service_type_name,add_date,add_uid,status) VALUES ('".addslashes($category_id)."','".addslashes($service_type_name)."','$current_date','$add_uid','1')";
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
		$service_type_name = $_REQUEST["service_type_name"];
		$category_id = $_REQUEST["category_id"];

		$query = "UPDATE tbl_service_type SET category_id = '".addslashes($category_id)."',service_type_name = '".addslashes($service_type_name)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_service_type WHERE id = '$id'";
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