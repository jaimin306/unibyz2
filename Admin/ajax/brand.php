<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$brand_name = $_REQUEST["brand_name"];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_brand (brand_name,add_date,add_uid,status) VALUES ('".addslashes($brand_name)."','$current_date','$add_uid','1')";
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
		$brand_name = $_REQUEST["brand_name"];

		$query = "UPDATE tbl_brand SET brand_name = '".addslashes($brand_name)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_brand WHERE id = '$id'";
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