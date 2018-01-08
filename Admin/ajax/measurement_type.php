<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");

	// Measurement Type
	if($cmd == "insert_type"){
		$measurement_type = $_REQUEST["measurement_type"];
		$type = $_REQUEST["type"];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_measurement_type (measurement_type,type,add_date,add_uid,status) VALUES ('".addslashes($measurement_type)."','".addslashes($type)."','$current_date','$add_uid','1')";
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
	if($cmd == "update_type"){
		$id = $_REQUEST["id"];
		$measurement_type = $_REQUEST["measurement_type"]; 
		$query = "UPDATE tbl_measurement_type SET measurement_type = '".addslashes($measurement_type)."' WHERE id = '$id'";
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
	if($cmd == "delete_type"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_measurement_type WHERE id = '$id'";
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


	// Measurement 
	if($cmd == "insert_measurement"){
		$measurement_type_id = $_REQUEST["measurement_type_id"];
		$measurement_name = $_REQUEST["measurement_name"];
		$measurement_order = $_REQUEST["measurement_order"];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_measurement(measurement_type_id,measurement_order,measurement_name,add_date,add_uid,status) VALUES ('".addslashes($measurement_type_id)."','".addslashes($measurement_order)."','".addslashes($measurement_name)."','$current_date','$add_uid','1')";
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

	if($cmd == "update_measurement"){
		$id = $_REQUEST["id"];
		$measurement_type_id = $_REQUEST["measurement_type_id"];
		$measurement_name = $_REQUEST["measurement_name"];
		$measurement_order = $_REQUEST["measurement_order"];
		$query = "UPDATE tbl_measurement SET measurement_type_id = '".addslashes($measurement_type_id)."',measurement_order = '".addslashes($measurement_order)."',measurement_name = '".addslashes($measurement_name)."' WHERE id = '$id'";
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
	
	if($cmd == "delete_mesurement"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_measurement WHERE id = '$id'";
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