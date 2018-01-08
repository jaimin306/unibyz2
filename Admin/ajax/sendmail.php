<?php
	session_start();
	include("../../dbConnect.php");
	include("../../PHPMailer-master//PHPMailerAutoload.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");

	if($cmd == "SendEstimateCustomer"){
		$estimate_id = $_REQUEST["estimate_id"];
		// $query = "SELECT te.* FROM tbl_estimate te  WHERE te.id = '$estimate_id' ";
		$query = "SELECT te.*,tcd.company_name FROM tbl_estimate te LEFT JOIN tbl_company_detail tcd ON tcd.user_id = te.add_uid WHERE te.id = '$estimate_id' ";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row = mysqli_fetch_assoc($res);
		$company_name = $row["company_name"];
		$customer_id = $row["customer_id"];

		// Get Client Name 
		$select_email = "SELECT email FROM tbl_user WHERE id = '$customer_id'";
		$res_email = mysqli_query($mysqli,$select_email) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row_email = mysqli_fetch_assoc($res_email);
		$email = $row_email["email"];
		$username = "ajayjadeja4494@gmail.com";
		$password = "iwant$100";
		$from_name = $company_name;
		$to = $email;
		$subject = "Estimate By Company: ".$company_name;
		$current = date("Y-m-d");
		$msg = "Please Find The Attachment To Download The Project Quotation..";

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = $username;
		$mail->Password = $password;
		$mail->setFrom($username, $from_name);
		$mail->addReplyTo($username, $from_name);
		$mail->addAddress($to, $from_name);
		$mail->Subject = $subject;
		$mail->msgHTML($msg);
		$mail->addAttachment('../../GeneratePDF/Estimate.pdf', 'Estimate.pdf');
		if (!$mail->send()) {
			$data['result'] = "false";
			$data['msg'] = $mail->ErrorInfo;
		} else {
			$data['result'] = "true";
			$data['msg'] = "Email Sent Successfully";
			$update = "UPDATE tbl_estimate SET notify_email = '1', notify_email_date = '$current_date' WHERE id = '$estimate_id'";
			$update_res = mysqli_query($mysqli,$update) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
			// unlink('../GeneratePDF/Project_Quotation_'.$row["invoice_id"].'.pdf');
		}
		echo json_encode($data);
	}


?>