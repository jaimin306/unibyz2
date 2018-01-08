<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$column_nm = $_REQUEST['column_nm'];
		$direction=$_REQUEST['direction'];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_payroll_template (column_nm,direction,add_date,add_uid,status) VALUES ('".addslashes($column_nm)."','".addslashes($direction)."','$current_date','$add_uid','1')";
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
		$add_uid = $_SESSION["user_id"];
		$query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$add_uid'";
	    $res1 = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
	    $num_rows = mysqli_num_rows($res1);	 
	    if($num_rows > 0){                                            
	      while($row = mysqli_fetch_assoc($res1)){ 
	      	$id=$row['id'];
	      	$column_nm=$_REQUEST[''+$id];	      	 
	      	if($column_nm!=$row['column_nm']){
		      	$query = "UPDATE tbl_payroll_template SET column_nm = '".addslashes($column_nm)."' WHERE id = '$id'";
				$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			}
	      }
	    }
		
		if(isset($res)){
			$data['result'] = "true";
			$data['status'] = "usuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "no_update";
		}
		echo json_encode($data);
	} 
	if($cmd == "delete"){
		$id = $_REQUEST["div_id"];
		$query = "DELETE FROM tbl_payroll_template WHERE id = '$id'";
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