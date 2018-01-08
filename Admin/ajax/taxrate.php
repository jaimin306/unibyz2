<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$tax_name = $_REQUEST["tax_name"];
		$tax_rate = $_REQUEST["tax_rate"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];

		$query = "INSERT INTO tbl_taxrate (tax_name,tax_rate,notes,add_date,add_uid,status) VALUES ('".addslashes($tax_name)."','".addslashes($tax_rate)."','".addslashes($notes)."','$current_date','$add_uid','1')";
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
		$tax_name = $_REQUEST["tax_name"];
		$tax_rate = $_REQUEST["tax_rate"];
		$notes = $_REQUEST["notes"];

		$query = "UPDATE tbl_taxrate SET tax_name = '".addslashes($tax_name)."', tax_rate = '".addslashes($tax_rate)."', notes = '".addslashes($notes)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_taxrate WHERE id = '$id'";
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