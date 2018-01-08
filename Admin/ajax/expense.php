<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$expense_type_id = $_REQUEST["expense_type_id"]?$_REQUEST["expense_type_id"]:0;
		$expense_amount = $_REQUEST["expense_amount"]?$_REQUEST["expense_amount"]:0;
		$e_date = $_REQUEST["e_date"]?"'".$_REQUEST["e_date"]."'":'NULL';
		$recurring = $_REQUEST["recurring"];		 
		$description = $_REQUEST["description"]?$_REQUEST["description"]:'';		 
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_expense (expense_type_id,expense_amount,e_date,recurring,description,add_uid,status) VALUES ('".addslashes($expense_type_id)."','".addslashes($expense_amount)."',$e_date,'".addslashes($recurring)."','".addslashes($description)."','$add_uid','1')";		 		 
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$last_insert_id = mysqli_insert_id($mysqli); 

		/* Upload Photo */		 
		$count=count($_FILES['user_image']['name']); 
		$hidden_image=$_REQUEST["hidden_image"];	
    	if($count>0 && $hidden_image==0){    		
    		for($i=0; $i<$count; $i++) { 
	            $photo = $_FILES["user_image"]["name"][$i];
	            $tmp_photo = $_FILES["user_image"]["tmp_name"][$i];
	            if (move_uploaded_file($tmp_photo, "../../uploads/expense/".$photo)) {
	                $img_name = $photo;
	                $query = "INSERT INTO tbl_expense_file (expense_id,file_path,add_uid,status) VALUES ('".addslashes($last_insert_id)."','".addslashes($img_name)."','$add_uid','1')";		 		 
					$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
	               // echo $img_name."<br>";
	            }
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
		$expense_type_id = $_REQUEST["expense_type_id"]?$_REQUEST["expense_type_id"]:0;
		$expense_amount = $_REQUEST["expense_amount"]?$_REQUEST["expense_amount"]:0;
		$e_date = $_REQUEST["e_date"]?"'".$_REQUEST["e_date"]."'":'NULL';
		$recurring = $_REQUEST["recurring"];		 
		$description = $_REQUEST["description"]?$_REQUEST["description"]:'';	

		/* file code  start*/
		 
		$count=count($_FILES['user_image']['name']); 
		$hidden_image=$_REQUEST["hidden_image"];	

    	if($count>0 && $hidden_image==0){    	

    		for($i=0; $i<$count; $i++) { 
	            $photo = $_FILES["user_image"]["name"][$i];
	            $tmp_photo = $_FILES["user_image"]["tmp_name"][$i];
	            if (move_uploaded_file($tmp_photo, "../../uploads/expense/".$photo)) {
	                $img_name = $photo; 
	                $query = "INSERT INTO tbl_expense_file (expense_id,file_path,add_uid,status) VALUES ('".addslashes($id)."','".addslashes($img_name)."','$add_uid','1')";		 		 
					$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
	            }
	        } 
        }
		/* file code  end*/
	
		$query = "UPDATE tbl_expense SET expense_type_id = '".addslashes($expense_type_id)."',expense_amount = '".addslashes($expense_amount)."',e_date = $e_date,recurring = '".addslashes($recurring)."',description = '".addslashes($description)."' WHERE id = '$id'";
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

		$select = "SELECT file_path FROM tbl_expense_file WHERE expense_id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $num_rows = mysqli_num_rows($q);
        if($num_rows > 0){                                         
            while($row = mysqli_fetch_assoc($q)){
		        $old_photo = $row["file_path"];
		        if($old_photo != ""){
		            unlink("../../uploads/expense/".$old_photo);
		        }
		    }
		}

		$query = "DELETE FROM tbl_expense_file WHERE expense_id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		$query = "DELETE FROM tbl_expense WHERE id = '$id'";
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
	 
	 if($cmd == "deleteImage"){
		$id = $_REQUEST["id"];  
		$query = "DELETE FROM tbl_expense_file WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		 
		if($res){
			$data['result'] = "true";
			$data['status'] = "disuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "get_files"){
		$id = $_REQUEST["eid"];		 
		$select = "SELECT id,file_path FROM tbl_expense_file WHERE expense_id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $num_rows = mysqli_num_rows($q);
        $data['string']='';
        if($num_rows > 0){                                         
            while($row = mysqli_fetch_assoc($q)){
		        $photo = $row["file_path"];
		         $data['string'].='<tr><td>'.$photo.'</td><td><a href="javascript:void(0)" value="'.$row['id'].'" class="btndeleteimage"><i class="fa fa-trash"></i>Delete</a></td></tr>';
		    }
		}
		echo json_encode($data);
	}


?>