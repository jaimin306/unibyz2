<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$type_name = $_REQUEST["type_name"];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_ticket_type (type_name,add_date,add_uid,status) VALUES ('".addslashes($type_name)."','$current_date','$add_uid','1')";
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
		$type_name = $_REQUEST["type_name"];

		$query = "UPDATE tbl_ticket_type SET type_name = '".addslashes($type_name)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_ticket_type WHERE id = '$id'";
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
	if($cmd == "ChangeStatus"){
		$id = $_REQUEST["id"];
		
		$query = "SELECT status FROM tbl_ticket_type  WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row = mysqli_fetch_assoc($res);
		if($row["status"] == "1"){
			$query1 = "UPDATE tbl_ticket_type SET status = '0' WHERE id = '$id'";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		else{
			$query1 = "UPDATE tbl_ticket_type SET status = '1' WHERE id = '$id'";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		if($res1){
			$data['result'] = "true";
			$data['status'] = "ussuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}

?>