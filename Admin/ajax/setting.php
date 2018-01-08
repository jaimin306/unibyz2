<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "UpdateGeneralSetting"){
		$user_id = $_SESSION["user_id"];
		$company_name = $_REQUEST["company_name"];
		$company_email = $_REQUEST["company_email"];
		$company_address = $_REQUEST["company_address"];
		$company_logo = $_REQUEST["company_logo_value"];

		if ($_FILES["company_logo"]["name"] != "") {
			if(file_exists('../../uploads/logo/'.$company_logo)){
				unlink('../../uploads/logo/'.$company_logo);
			}
            $photo = $_FILES["company_logo"]["name"];
            $tmp_photo = $_FILES["company_logo"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/logo/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $company_logo;
        }

		$query = "UPDATE tbl_company_detail SET company_name = '".addslashes($company_name)."', company_email = '".addslashes($company_email)."', company_address = '".addslashes($company_address)."',company_logo = '".addslashes($img_name)."' WHERE user_id = '$user_id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		//General Settings
		$date_format = $_REQUEST["date_format"];

		$select = "SELECT user_id FROM tbl_all_setting WHERE user_id = '$user_id'";
		$res_select = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$num_rows = mysqli_num_rows($res_select);
		if($num_rows > 0){
			$query1 = "UPDATE tbl_all_setting SET date_format = '".addslashes($date_format)."' WHERE user_id = '$user_id'";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));	
		}
		else{
			$query1 = "INSERT INTO tbl_all_setting (user_id,date_format,add_date,add_uid,status) VALUES ('".addslashes($user_id)."','".addslashes($date_format)."','$current_date','$user_id','1')";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));	
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
	if($cmd == "UpdateSetting"){
		$user_id = $_SESSION["user_id"];
		$company_name = $_REQUEST["company_name"];
		$company_email = $_REQUEST["company_email"];
		$company_address = $_REQUEST["company_address"];
		$company_logo = $_REQUEST["company_logo_value"];

		if ($_FILES["company_logo"]["name"] != "") {
			if(file_exists('../../uploads/logo/'.$company_logo)){
				unlink('../../uploads/logo/'.$company_logo);
			}
            $photo = $_FILES["company_logo"]["name"];
            $tmp_photo = $_FILES["company_logo"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/logo/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $company_logo;
        }

		$query = "UPDATE tbl_company_detail SET company_name = '".addslashes($company_name)."', company_email = '".addslashes($company_email)."', company_address = '".addslashes($company_address)."',company_logo = '".addslashes($img_name)."' WHERE user_id = '$user_id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		//General Settings
		$country = $_REQUEST["country"];
		$currency = $_REQUEST["currency"];
		$currency_symbol = $_REQUEST["currency_symbol"];
		$portal_address = $_REQUEST["portal_address"];
		$date_format = $_REQUEST["date_format"];
		//SMS Settings
		$sms_enabled = $_REQUEST["sms_enabled"];
		$sms_gateway = $_REQUEST["sms_gateway"];
		$sms_sender_name = $_REQUEST["sms_sender_name"];
		$twilio_sid = $_REQUEST["twilio_sid"];
		$twilio_token = $_REQUEST["twilio_token"];
		$twilio_phone = $_REQUEST["twilio_phone"];
		//Email Template Settings
		$email_payment_subject = $_REQUEST["email_payment_subject"];
		$email_payment_template = $_REQUEST["email_payment_template"];
		//SMS Template Settings
		$sms_payment_subject = $_REQUEST["sms_payment_subject"];
		$sms_payment_template = $_REQUEST["sms_payment_template"];
		//System Settings
		$cron_job = $_REQUEST["cron_job"];
		//Payments Settings
		$online_payment = $_REQUEST["online_payment"];
		$paypal_enabled = $_REQUEST["paypal_enabled"];
		$paypal_email = $_REQUEST["paypal_email"];
		$paynow_enabled = $_REQUEST["paynow_enabled"];
		$paynow_id = $_REQUEST["paynow_id"];
		$paynow_key = $_REQUEST["paynow_key"];
		$stripe_enabled = $_REQUEST["stripe_enabled"];
		$stripe_key = $_REQUEST["stripe_key"];
		$stripe_secret = $_REQUEST["stripe_secret"];

		$form_data = array(
		'user_id' => $user_id,
		'country' => $country,
		'currency' => $currency,
		'currency_symbol' => $currency_symbol,
		'portal_address' => $portal_address,
		'date_format' => $date_format,
		'sms_enabled' => $sms_enabled,
		'sms_gateway' => $sms_gateway,
		'sms_sender_name' => $sms_sender_name,
		'twilio_sid' => $twilio_sid,
		'twilio_token' => $twilio_token,
		'twilio_phone' => $twilio_phone,
		'email_payment_subject' => $email_payment_subject,
		'email_payment_template' => $email_payment_template,
		'sms_payment_subject' => $sms_payment_subject,
		'sms_payment_template' => $sms_payment_template,
		'cron_job' => $cron_job,
		'online_payment' => $online_payment,
		'paypal_enabled' => $paypal_enabled,
		'paypal_email' => $paypal_email,
		'paynow_enabled' => $paynow_enabled,
		'paynow_id' => $paynow_id,
		'paynow_key' => $paynow_key,
		'stripe_enabled' => $stripe_enabled,
		'stripe_key' => $stripe_key,
		'stripe_secret' => $stripe_secret,
		'add_date' => $current_date,
		'add_uid' => $user_id,
		'status' => '1'
		);
		
		$select = "SELECT user_id FROM tbl_all_setting WHERE user_id = '$user_id'";
		$res_select = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$num_rows = mysqli_num_rows($res_select);
		if($num_rows > 0){
			$query1 = "UPDATE tbl_all_setting SET country = '".addslashes($country)."', currency = '".addslashes($currency)."', currency_symbol = '".addslashes($currency_symbol)."', portal_address = '".addslashes($portal_address)."', date_format = '".addslashes($date_format)."', sms_enabled = '".addslashes($sms_enabled)."', sms_gateway = '".addslashes($sms_gateway)."', sms_sender_name = '".addslashes($sms_sender_name)."', twilio_sid = '".addslashes($twilio_sid)."', twilio_token = '".addslashes($twilio_token)."', twilio_phone = '".addslashes($twilio_phone)."', email_payment_subject = '".addslashes($email_payment_subject)."', email_payment_template = '".addslashes($email_payment_template)."', sms_payment_subject = '".addslashes($sms_payment_subject)."', sms_payment_template = '".addslashes($sms_payment_template)."', cron_job = '".addslashes($cron_job)."', online_payment = '".addslashes($online_payment)."', paypal_enabled = '".addslashes($paypal_enabled)."', paypal_email = '".addslashes($paypal_email)."', paynow_enabled = '".addslashes($paynow_enabled)."', paynow_id = '".addslashes($paynow_id)."', paynow_key = '".addslashes($paynow_key)."', stripe_enabled = '".addslashes($stripe_enabled)."', stripe_key = '".addslashes($stripe_key)."', stripe_secret = '".addslashes($stripe_secret)."' WHERE user_id = '$user_id'";

			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));	
		}
		else{
			/*$query1 = "INSERT INTO tbl_all_setting (user_id,date_format,add_date,add_uid,status) VALUES ('".addslashes($user_id)."','".addslashes($date_format)."','$current_date','$user_id','1')";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));	*/
			$res1 = DBInsert('tbl_all_setting',$form_data);
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


?>