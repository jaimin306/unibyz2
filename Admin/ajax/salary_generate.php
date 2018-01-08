<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		// Generate Salary Insert Into Table
		$employee_id_arr = $_REQUEST["employee_id"];
		$name = $_REQUEST["name"];
		$start_date = $_REQUEST["start_date"];
		$end_date = $_REQUEST["end_date"];
		$add_uid = $_SESSION["user_id"];
		
		for ($i=0; $i<count($employee_id_arr) ;$i++) { 
			$employee_id = $employee_id_arr[$i];

			$query = "INSERT INTO tbl_salary_generate (employee_id,name,start_date,end_date,add_date,add_uid,status) VALUES ('".addslashes($employee_id)."','".addslashes($name)."','".addslashes($start_date)."','".addslashes($end_date)."','$current_date','$add_uid','1')";
			$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		/////////// Calculate Total Salary 
		/*$query1 = "SELECT SUM(tssa.amount) as add_amount FROM tbl_salary_setup_amount tssa LEFT JOIN tbl_salary_setup tss ON tss.id = salary_setup_id WHERE amount_add_deduct = '1' AND tss.employee_id = '$employee_id'";
		$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row1 = mysqli_fetch_assoc($res1);
		$add_amount = $row1["add_amount"];

		$query2 = "SELECT SUM(tssa.amount) as deduct_amount FROM tbl_salary_setup_amount tssa LEFT JOIN tbl_salary_setup tss ON tss.id = salary_setup_id WHERE amount_add_deduct = '0' AND tss.employee_id = '$employee_id'";
		$res2 = mysqli_query($mysqli,$query2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row2 = mysqli_fetch_assoc($res2);
		$deduct_amount = $row1["deduct_amount"];
		$total_salary = $add_amount - $deduct_amount;
		Later On
		*/

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
		$employee_id = $_REQUEST["employee_id"];
		$name = $_REQUEST["name"];
		$start_date = $_REQUEST["start_date"];
		$end_date = $_REQUEST["end_date"];

		$query = "UPDATE tbl_salary_generate SET employee_id = '".addslashes($employee_id)."',name = '".addslashes($name)."',start_date = '".addslashes($start_date)."',end_date = '".addslashes($end_date)."' WHERE id = '$id'";
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
		$query = "DELETE FROM tbl_salary_generate WHERE id = '$id'";
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