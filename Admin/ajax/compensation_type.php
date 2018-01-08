<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$parent_id = $_REQUEST["parent_id"];
		$compensation_name = $_REQUEST["compensation_name"];
		$add_uid = $_SESSION["user_id"];

		$query = "INSERT INTO tbl_compensation_type(parent_id,compensation_name,add_date,add_uid,status) VALUES ('".addslashes($parent_id)."','".addslashes($compensation_name)."','$current_date','$add_uid','1')";
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
		$parent_id = $_REQUEST["parent_id"];
		$compensation_name = $_REQUEST["compensation_name"];

		$query = "UPDATE tbl_compensation_type SET parent_id = '".addslashes($parent_id)."', compensation_name = '".addslashes($compensation_name)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_compensation_type WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		$query1 = "DELETE FROM tbl_compensation_type WHERE parent_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res && $res1){
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