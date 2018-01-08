<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){		 
		$add_uid = $_SESSION["user_id"];
		$employee_id = $_REQUEST["employee_id"]?$_REQUEST["employee_id"]:0;
		$payroll_date = $_REQUEST["payroll_date"]?"'".$_REQUEST["payroll_date"]."'":'NULL';
		$business_name = $_REQUEST["business_name"];
		$total_pay = $_REQUEST["total_pay"]?$_REQUEST["total_pay"]:0;
		$total_deduction = $_REQUEST["total_deductions"]?$_REQUEST["total_deductions"]:0;
		$net_pay = $_REQUEST["net_pay"]?$_REQUEST["net_pay"]:0;
		$payment_method = $_REQUEST["payment_method"];
		$bank_name = $_REQUEST["bank_name"];
		$account_no = $_REQUEST["account_no"];
		$description = $_REQUEST["description"];
		$paid_amount = $_REQUEST["paid_amount"]?$_REQUEST["paid_amount"]:0;
		$comments = $_REQUEST["comments"];		
		$recurring = $_REQUEST["recurring"];		
		$recur_frequency = $_REQUEST["recur_frequency"]?$_REQUEST["recur_frequency"]:0;		
		$recur_type = $_REQUEST["recur_type"]?$_REQUEST["recur_type"]:'';		
		$recur_start_date = $_REQUEST["recur_start_date"]?"'".$_REQUEST["recur_start_date"]."'":'NULL';
		$recur_end_date = $_REQUEST["recur_end_date"]?"'".$_REQUEST["recur_end_date"]."'":'NULL';	

		$query = "INSERT INTO tbl_payroll (employee_id,payroll_date,business_name,total_pay,total_deduction,net_pay,payment_method,bank_name,account_no,description,paid_amount,comments,recurring,recur_frequency,recur_type,recur_starts,recur_end,add_uid,status) VALUES ('".addslashes($employee_id)."',$payroll_date,'".addslashes($business_name)."','".addslashes($total_pay)."','".addslashes($total_deduction)."','".addslashes($net_pay)."','".addslashes($payment_method)."','".addslashes($bank_name)."','".addslashes($account_no)."','".addslashes($description)."','".addslashes($paid_amount)."','".addslashes($comments)."','".addslashes($recurring)."','".addslashes($recur_frequency)."','".addslashes($recur_type)."',$recur_start_date,$recur_end_date,'$add_uid','1')";		  
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		
		$last_insert_id = mysqli_insert_id($mysqli);		
		$query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$add_uid'";
	    $result = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
	    $num_rows = mysqli_num_rows($result);                                                      
	    if($num_rows > 0){                                            
	      while($row = mysqli_fetch_assoc($result)){
	      	$col_val=$row['id'];
	      	$val= $_REQUEST[""+$col_val]?$_REQUEST[""+$col_val]:'';	
	      	$query = "INSERT INTO tbl_payroll_detail (payroll_id,template_id,value,add_uid,status) VALUES ('".addslashes($last_insert_id)."','".addslashes($col_val)."','".addslashes($val)."','$add_uid','1')";		 	      	 
			$res1 = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
	      }
	    }
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
		$add_uid = $_SESSION["user_id"];
		$payroll_date = $_REQUEST["payroll_date"]?"'".$_REQUEST["payroll_date"]."'":'NULL';
		$business_name = $_REQUEST["business_name"];
		$total_pay = $_REQUEST["total_pay"]?$_REQUEST["total_pay"]:0;
		$total_deduction = $_REQUEST["total_deductions"]?$_REQUEST["total_deductions"]:0;
		$net_pay = $_REQUEST["net_pay"]?$_REQUEST["net_pay"]:0;
		$payment_method = $_REQUEST["payment_method"];
		$bank_name = $_REQUEST["bank_name"];
		$account_no = $_REQUEST["account_no"];
		$description = $_REQUEST["description"];
		$paid_amount = $_REQUEST["paid_amount"]?$_REQUEST["paid_amount"]:0;
		$comments = $_REQUEST["comments"];		
		$recurring = $_REQUEST["recurring"];		
		$recur_frequency = $_REQUEST["recur_frequency"]?$_REQUEST["recur_frequency"]:0;		
		$recur_type = $_REQUEST["recur_type"]?$_REQUEST["recur_type"]:'';		
		$recur_start_date = $_REQUEST["recur_start_date"]?"'".$_REQUEST["recur_start_date"]."'":'NULL';
		$recur_end_date = $_REQUEST["recur_end_date"]?"'".$_REQUEST["recur_end_date"]."'":'NULL';	

		$query = "UPDATE tbl_payroll SET payroll_date =".$payroll_date.",business_name ='".addslashes($business_name)."',total_pay='".addslashes($total_pay)."',total_deduction='".addslashes($total_deduction)."',net_pay='".addslashes($net_pay)."',payment_method='".addslashes($payment_method)."',bank_name='".addslashes($bank_name)."',account_no='".addslashes($account_no)."',description='".addslashes($description)."',paid_amount='".addslashes($paid_amount)."',comments='".addslashes($comments)."',recurring='".addslashes($recurring)."',recur_frequency='".addslashes($recur_frequency)."',recur_type='".addslashes($recur_type)."',recur_starts=".$recur_start_date.",recur_end=".$recur_end_date." WHERE id = '$id'";		 
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		// delete payroll entry
		$query1 = "DELETE FROM tbl_payroll_detail WHERE payroll_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1); 
		//new entry
		$last_insert_id = $id;		
		$query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$add_uid'";
	    $result = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
	    $num_rows = mysqli_num_rows($result);                                                      
	    if($num_rows > 0){                                            
	      while($row = mysqli_fetch_assoc($result)){
	      	$col_val=$row['id'];
	      	$val= $_REQUEST[""+$col_val]?$_REQUEST[""+$col_val]:'';	
	      	$query = "INSERT INTO tbl_payroll_detail (payroll_id,template_id,value,add_uid,status) VALUES ('".addslashes($last_insert_id)."','".addslashes($col_val)."','".addslashes($val)."','$add_uid','1')";		 	      	 
			$res1 = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
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
		$query1 = "DELETE FROM tbl_payroll_detail WHERE payroll_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1); 
		$query = "DELETE FROM tbl_payroll WHERE id = '$id'";
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

	// if($cmd=="getEmployee"){
	// 	$eid = $_REQUEST["employee_id"];
	// 	$add_uid = $_SESSION["user_id"];
	// 	$query = "SELECT p.*,u.first_name,u.last_name FROM tbl_payroll p LEFT JOIN tbl_user u on u.id=p.employee_id WHERE p.status = '1' AND p.add_uid = '$add_uid' AND p.employee_id=$eid AND DATE(p.recur_starts) <= CURDATE() AND DATE(p.recur_end) >= CURDATE() AND p.recurring='yes' AND p.id IN (SELECT MAX(tp.id) FROM tbl_payroll tp GROUP BY tp.employee_id)";		
	//     $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
 //    	$row = mysqli_fetch_assoc($res);
	//     if(isset($row['id'])){
	//       	$data['result']="true";
	//     } else {
	//     	$data['result']="false";
	//     }
	//     echo json_encode($data);
	// }
?>