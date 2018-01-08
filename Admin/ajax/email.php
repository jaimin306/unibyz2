<?php
	session_start();
	include("../../dbConnect.php");
	include("../../PHPMailer-master//PHPMailerAutoload.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	/*if($cmd == "insert"){
		$category_name = $_REQUEST["category_name"];
		$add_uid = $_SESSION["user_id"];
		$query = "INSERT INTO tbl_category (category_name,add_date,add_uid,status) VALUES ('".addslashes($category_name)."','$current_date','$add_uid','1')";
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
	}*/
	if($cmd == "InsertAndMail"){
		$send_user_id = $_SESSION["user_id"];
		$to_user_id = $_REQUEST["to_user_id"];
		$get_subject = $_REQUEST["subject"];
		$message = $_REQUEST["message"];
		//Select User Name
		$select = "SELECT id,first_name,last_name FROM tbl_user WHERE id = '$to_user_id'";
		$que_select = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row_select = mysqli_fetch_assoc($que_select);
		$message = str_replace('{first_name}', $row_select["first_name"], $message);
		$message = str_replace('{last_name}', $row_select["last_name"], $message);
		$s = "SELECT company_name FROM tbl_company_detail WHERE user_id = '$send_user_id'";
		$q = mysqli_query($mysqli,$s) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$r = mysqli_fetch_assoc($q);
		$cname = $r["company_name"];
		//Send Email To User
		$username = "ajayjadeja4494@gmail.com";
		$password = "iwant$100";
		$from_name = $company_name;
		$to = "sachin.sanchaniya@gmail.com";
		$subject = $get_subject;
		$msg = $message;

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = $hostmail_url;
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = $username;
		$mail->Password = $password;
		$mail->setFrom($username, $cname);
		$mail->addReplyTo($username, $from_name);
		$mail->addAddress($to, $from_name);
		$mail->Subject = $subject;
		$mail->msgHTML($msg);
		if (!$mail->send()) {
			$data['result'] = "false";
			$data['msg'] = $mail->ErrorInfo;
		} else {
			$data['result'] = "true";
			$data['msg'] = "Email Sent Successfully";
			$query = "INSERT INTO tbl_email (send_user_id,to_user_id,subject,message,add_date,add_uid,status) VALUES ('".addslashes($send_user_id)."','".addslashes($to_user_id)."','".addslashes($get_subject)."','".addslashes($msg)."','$current_date','$send_user_id','1')";
			$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		echo json_encode($data);
	}

	if($cmd == "delete"){
		$id = $_REQUEST["id"];
		$query = "DELETE FROM tbl_email WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
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
	if($cmd == "ViewMessage"){
		$id = $_REQUEST["id"];
		$query = "SELECT message FROM tbl_email WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row = mysqli_fetch_assoc($res);
		$data["msg"] = $row["message"];
		echo json_encode($data);

	}

?>