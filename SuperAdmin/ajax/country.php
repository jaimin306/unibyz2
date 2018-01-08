<?php
	include("../../dbConnect.php");
	include("../includes/session.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "insert"){
		$country_name = $_REQUEST["country_name"];
		$currency = $_REQUEST["currency"];
		$currency_symbol = $_REQUEST["currency_symbol"];
		$add_uid = $_SESSION["user_id"];

		/* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["company_logo"]["name"];
            $tmp_photo = $_FILES["company_logo"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/logo/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */

		$query = "INSERT INTO tbl_user (first_name,last_name,phone,email,password,address,notes,user_type,user_status,add_date,add_uid,status) VALUES ('".addslashes($first_name)."','".addslashes($last_name)."','".addslashes($phone)."','".addslashes($email)."','".addslashes($password)."','".addslashes($address)."','".addslashes($notes)."','1','1','$current_date','$add_uid','1')";

		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$last_insert_id = mysqli_insert_id($mysqli);

		$query1 = "INSERT INTO tbl_company_detail (user_id,company_name,company_logo,state,license_no,add_date,add_uid,status) VALUES ('".addslashes($last_insert_id)."','".addslashes($company_name)."','".addslashes($img_name)."','".addslashes($state)."','".addslashes($license_no)."','$current_date','$add_uid','1')";
			 
		$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		// Insert Default Date Format In Setting Table
		$query2 = "INSERT INTO tbl_all_setting (user_id,date_format,add_date,add_uid,status) VALUES ('".addslashes($last_insert_id)."','m-d-Y','$current_date','$add_uid','1')";
		$res2 = mysqli_query($mysqli,$query2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));	

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
		$first_name = $_REQUEST["first_name"];
		$last_name = $_REQUEST["last_name"];
		$phone = $_REQUEST["phone"];
		$company_name = $_REQUEST["company_name"];
		$hidden_photo_path = $_REQUEST["hidden_photo_path"];
		$email = $_REQUEST["email"];
		$address = $_REQUEST["address"];
		$state = $_REQUEST["state"];
		$license_no = $_REQUEST["license_no"];
		$notes = $_REQUEST["notes"];
		/* Upload Photo */
        if (($_FILES["company_logo"]["name"] != "")) {
        	$photo = $_FILES["company_logo"]["name"];
            $tmp_photo = $_FILES["company_logo"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/logo/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $hidden_photo_path;
        }
        /* Upload Photo */


		$query = "UPDATE tbl_user SET first_name = '".addslashes($first_name)."',last_name = '".addslashes($last_name)."',phone = '".addslashes($phone)."',email = '".addslashes($email)."',address = '".addslashes($address)."',notes = '".addslashes($notes)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		
		$query1 = "UPDATE tbl_company_detail SET company_name = '".addslashes($company_name)."',state = '".addslashes($state)."',license_no = '".addslashes($license_no)."',company_logo = '$img_name' WHERE user_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));


		if($res && $res1){
			$data['result'] = "true";
			$data['status'] = "usuccess";
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
			$data['status'] = "upsuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}

	if($cmd == "delete"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_user WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		$query1 = "DELETE FROM tbl_company_detail WHERE user_id = '$id'";
		$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		if($res && $res1){
			$data['result'] = "true";
			$data['status'] = "dsuccess";
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