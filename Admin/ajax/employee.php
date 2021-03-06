<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$first_name = $_REQUEST["first_name"];
		$last_name = $_REQUEST["last_name"];
		$phone = $_REQUEST["phone"];
		$email = $_REQUEST["email"];
		$password = $_REQUEST["password"];
		$address = $_REQUEST["address"];
		$tax_id_no = $_REQUEST["tax_id_no"];
		$notes = $_REQUEST["notes"];
		$user_type = $_REQUEST["user_type"]?$_REQUEST["user_type"]:0;
		$emp_id = $_REQUEST["emp_id"];
		$add_uid = $_SESSION["user_id"];

		/* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["user_image"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["user_image"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/employee/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */

		$query = "INSERT INTO tbl_user (first_name,last_name,phone,email,password,address,notes,tax_id_no,emp_id,user_image,user_type,add_date,add_uid,status) VALUES ('".addslashes($first_name)."','".addslashes($last_name)."','".addslashes($phone)."','".addslashes($email)."','".addslashes($password)."','".addslashes($address)."','".addslashes($notes)."','".addslashes($tax_id_no)."','".addslashes($emp_id)."','$img_name','$user_type','$current_date','$add_uid','1')";
		 
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
		$first_name = $_REQUEST["first_name"];
		$last_name = $_REQUEST["last_name"];
		$phone = $_REQUEST["phone"];
		$email = $_REQUEST["email"];
		$user_image = $_REQUEST["hidden_photo_path"];
		$address = $_REQUEST["address"];
		$tax_id_no = $_REQUEST["tax_id_no"];
		$user_type = $_REQUEST["user_type"];
		$emp_id = $_REQUEST["emp_id"];
		$notes = $_REQUEST["notes"];

		if ($_FILES["user_image"]["name"] != "") {
			$photo = $_FILES["user_image"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["user_image"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/employee/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $user_image;
        }

		$query = "UPDATE tbl_user SET first_name = '".addslashes($first_name)."',last_name = '".addslashes($last_name)."',phone = '".addslashes($phone)."',email = '".addslashes($email)."',user_image = '".addslashes($img_name)."',address = '".addslashes($address)."',tax_id_no = '".addslashes($tax_id_no)."',emp_id = '".addslashes($emp_id)."',notes = '".addslashes($notes)."',user_type = '".addslashes($user_type)."' WHERE id = '$id'";
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

		$select = "SELECT user_image FROM tbl_user WHERE id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["user_image"];
        if($old_photo != ""){
            unlink("../../uploads/employee/".$old_photo);
        }

		$query = "DELETE FROM tbl_user WHERE id = '$id'";
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

		$query = "UPDATE tbl_user SET user_status = '".addslashes($status_id)."' WHERE id = '$id'";
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
	
	if($cmd == "CheckEmail"){
		$email = $_REQUEST["email"];
		$query = "SELECT email FROM tbl_user WHERE email = '$email'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$num_rows = mysqli_num_rows($res);
		if($num_rows > 0){
			$data['result'] = "false";
			$data['msg'] = "Email Adress Already Taken. Please Use different Email.";
		}
		else{
			$data['result'] = "true";
			$data['msg'] = "";
		}
		echo json_encode($data);
	}
	 

?>