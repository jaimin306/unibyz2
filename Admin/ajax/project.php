<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$estimate_id = $_REQUEST["estimate_id"]?$_REQUEST["estimate_id"]:0;
		$customer_id = $_REQUEST["customer_id"]?$_REQUEST["customer_id"]:0;
		$project_manager_id = $_REQUEST["project_manager_id"]?$_REQUEST["project_manager_id"]:0;
		$project_name = $_REQUEST["project_name"];
		$start_date = $_REQUEST["start_date"]?"'".$_REQUEST["start_date"]."'":'NULL';
		$end_date = $_REQUEST["end_date"]?"'".$_REQUEST["end_date"]."'":'NULL';
		$project_description = $_REQUEST["project_description"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];
 
		$query = "INSERT INTO tbl_project (estimate_id,customer_id,project_manager_id,project_name,start_date,end_date,project_description,notes,add_date,add_uid,status) VALUES ('".addslashes($estimate_id)."','".addslashes($customer_id)."','".addslashes($project_manager_id)."','".addslashes($project_name)."',$start_date,$end_date,'".addslashes($project_description)."','".addslashes($notes)."','$current_date','$add_uid','1')";
		 
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

		$query = "DELETE FROM tbl_project WHERE id = '$id'";
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
	if($cmd == "update_status"){
		$id = $_REQUEST["id"];
		$status_id = $_REQUEST["status_id"];

		$query = "UPDATE tbl_project SET project_status = '".addslashes($status_id)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "upstatus";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "update"){
		$id = $_REQUEST["id"];
		
		$estimate_id = $_REQUEST["estimate_id"]?$_REQUEST["estimate_id"]:0;
		$customer_id = $_REQUEST["customer_id"]?$_REQUEST["customer_id"]:0;
		$project_manager_id = $_REQUEST["project_manager_id"]?$_REQUEST["project_manager_id"]:0;
		$project_name = $_REQUEST["project_name"];
		$start_date = $_REQUEST["start_date"]?"'".$_REQUEST["start_date"]."'":'NULL';
		$end_date = $_REQUEST["end_date"]?"'".$_REQUEST["end_date"]."'":'NULL';
		$project_description = $_REQUEST["project_description"];
		$notes = $_REQUEST["notes"];
		
		$query = "UPDATE tbl_project SET estimate_id = '".addslashes($estimate_id)."', customer_id = '".addslashes($customer_id)."' , project_manager_id = '".addslashes($project_manager_id)."' , project_name = '".addslashes($project_name)."' , start_date = $start_date, end_date =$end_date, project_description = '".addslashes($project_description)."', notes = '".addslashes($notes)."' WHERE id = '$id'";
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
	
	if($cmd == "GetCustomer"){
		$id = $_REQUEST["id"];
		$query = "SELECT tu.first_name,tu.last_name, est.customer_id FROM tbl_estimate est LEFT JOIN tbl_user tu ON tu.id = est.customer_id WHERE est.id = '$id'";
		
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$row = mysqli_fetch_assoc($res);
		$customer_id = $row["customer_id"];
		$customer_id_val = $row["first_name"]." ".$row["last_name"];
		$data["customer_id"] = $customer_id;
		$data["customer_id_val"] = $customer_id_val;
		// $data["customer_no"] = "CU".Series1000($customer_id);
		echo json_encode($data);
	}

?>