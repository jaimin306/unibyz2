<?php
	include("../../dbConnect.php");
	include("../includes/session.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	
	if($cmd == "update"){
		$id = $_REQUEST["id"];
		$add_uid = $_SESSION["user_id"];
		$create_category = (isset($_REQUEST["create_category"]) ? "1" : "0");
		$edit_category = (isset($_REQUEST["edit_category"]) ? "1" : "0");
		$delete_category = (isset($_REQUEST["delete_category"]) ? "1" : "0");
		$create_work_order = (isset($_REQUEST["create_work_order"]) ? "1" : "0");
		$edit_work_order = (isset($_REQUEST["edit_work_order"]) ? "1" : "0");
		$delete_work_order = (isset($_REQUEST["delete_work_order"]) ? "1" : "0");
		$create_product = (isset($_REQUEST["create_product"]) ? "1" : "0");
		$edit_product = (isset($_REQUEST["edit_product"]) ? "1" : "0");
		$delete_product = (isset($_REQUEST["delete_product"]) ? "1" : "0");

		$select = "SELECT id FROM tbl_permission WHERE status = '1'";
		$que = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$num_rows = mysqli_num_rows($que);
		if($num_rows > 0){
			$query = "UPDATE tbl_permission SET create_category = '".addslashes($create_category)."',edit_category = '".addslashes($edit_category)."',delete_category = '".addslashes($delete_category)."',create_work_order = '".addslashes($create_work_order)."',edit_work_order = '".addslashes($edit_work_order)."',delete_work_order = '".addslashes($delete_work_order)."',create_product = '".addslashes($create_product)."',edit_product = '".addslashes($edit_product)."',delete_product = '".addslashes($delete_product)."' WHERE user_id = '$id'";
			$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		else{
			$query = "INSERT INTO tbl_permission (user_id,create_category,edit_category,delete_category,create_work_order,edit_work_order,delete_work_order,create_product,edit_product,delete_product,add_date,add_uid,status) VALUES ('".addslashes($id)."','".addslashes($create_category)."','".addslashes($edit_category)."','".addslashes($delete_category)."','".addslashes($create_work_order)."','".addslashes($edit_work_order)."','".addslashes($delete_work_order)."','".addslashes($create_product)."','".addslashes($edit_product)."','".addslashes($delete_product)."','$current_date','$add_uid','1')";
			$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		if($res){
			$data['result'] = "true";
			$data['status'] = "upersuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "upererror";
		}
		echo json_encode($data);
	}

?>