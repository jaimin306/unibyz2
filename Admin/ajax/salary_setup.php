<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$employee_id = $_REQUEST["employee_id"];
		$salary_duration = $_REQUEST["salary_duration"];
		$add_uid = $_SESSION["user_id"];
		
		$query = "INSERT INTO tbl_salary_setup (employee_id,salary_duration,add_date,add_uid,status) VALUES ('".addslashes($employee_id)."','".addslashes($salary_duration)."','$current_date','$add_uid','1')";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$last_id = mysqli_insert_id($mysqli);

		$type_id_arr = $_REQUEST["type_id"];
		$amount_add_deduct_arr = $_REQUEST["amount_add_deduct"];
		$amount_arr = $_REQUEST["amount"];
		for ($i=0; $i<count($type_id_arr) ;$i++) { 
			$type_id = $type_id_arr[$i];
			$amount_add_deduct = $amount_add_deduct_arr[$i];
			$amount = $amount_arr[$i];
			$insert = "INSERT INTO tbl_salary_setup_amount (salary_setup_id,type_id,amount_add_deduct,amount,add_date,add_uid,status) VALUES ('".addslashes($last_id)."','".addslashes($type_id)."','".addslashes($amount_add_deduct)."','".addslashes($amount)."','$current_date','$add_uid','1')";
			$res1 = mysqli_query($mysqli,$insert) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		}
		if($res && $res1){
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
		$employee_id = $_REQUEST["employee_id"];
		$salary_duration = $_REQUEST["salary_duration"];
		$add_uid = $_SESSION["user_id"];

		$query = "UPDATE tbl_salary_setup SET employee_id = '".addslashes($employee_id)."',salary_duration = '".addslashes($salary_duration)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		$del = "DELETE FROM tbl_salary_setup_amount WHERE salary_setup_id = '$id'";
		$del_res = mysqli_query($mysqli,$del);

		if($del_res){
			$type_id_arr = $_REQUEST["type_id"];
			$amount_add_deduct_arr = $_REQUEST["amount_add_deduct"];
			$amount_arr = $_REQUEST["amount"];
			for ($i=0; $i<count($type_id_arr) ;$i++) { 
				$type_id = $type_id_arr[$i];
				$amount_add_deduct = $amount_add_deduct_arr[$i];
				$amount = $amount_arr[$i];
				$insert = "INSERT INTO tbl_salary_setup_amount (salary_setup_id,type_id,amount_add_deduct,amount,add_date,add_uid,status) VALUES ('".addslashes($id)."','".addslashes($type_id)."','".addslashes($amount_add_deduct)."','".addslashes($amount)."','$current_date','$add_uid','1')";
				$res1 = mysqli_query($mysqli,$insert) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			}
		}

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
		$query = "DELETE FROM tbl_salary_setup WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query);

		$query1 = "DELETE FROM tbl_salary_setup_amount WHERE salary_setup_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1);
		
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
	if($cmd == "GetEmployee"){
		$id = $_REQUEST["id"];
		$query = "SELECT emp_id FROM tbl_user WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query);
		$row=mysqli_fetch_assoc($res);
		$data["employeeId"] = $row["emp_id"];
		echo json_encode($data);
	}
	if($cmd == "GetCompensation"){
		$id = $_REQUEST["id"];
		$query = "SELECT id,compensation_name FROM tbl_compensation_type WHERE parent_id = '$id'";
		$res = mysqli_query($mysqli,$query);
		$num_rows = mysqli_num_rows($res);
		if($num_rows > 0){
			$data['string'] = '<option value="">Please Select Type</option>';
			while($row=mysqli_fetch_assoc($res)){
				$data['string'] .='<option value="'.$row["id"].'">'.$row["compensation_name"].'</option>';
			}	
		}
		else{
			$data['string'] .='<option value="">Please Select Type</option>';
		}
		

		echo json_encode($data);
	}

?>