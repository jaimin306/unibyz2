<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {

        $ticket_department_id = $_REQUEST["ticket_department_id"];
        $ticket_type_id = $_REQUEST["ticket_type_id"];
        $ticket_status_id = '';
        $subject = $_REQUEST["subject"];
        $notify_to = '1';
        $ticket_message = $_REQUEST["ticket_message"];
        $add_uid = $_SESSION["user_id"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $attachment = $_FILES["attachment"]["name"];
            $new_attachment = date('YmdHis')."_".uniqid()."_".$attachment;
            $tmp_attachment = $_FILES["attachment"]["tmp_name"];
            if (move_uploaded_file($tmp_attachment, "../../uploads/ticket/".$new_attachment)) {
                $attachment_name = $new_attachment;
            } else {
                $attachment_name = "";
            }
        } else {
            $attachment_name = "";
        }
        /* Upload Photo */

        $query = "INSERT INTO tbl_ticket (project_id,ticket_department_id,ticket_type_id,ticket_status_id,subject,notify_to,ticket_message,attachment,add_date,add_uid,status) VALUES ('".addslashes($project_id)."','".addslashes($ticket_department_id)."','".addslashes($ticket_type_id)."','".addslashes($ticket_status_id)."','".addslashes($subject)."','".addslashes($notify_to)."','".addslashes($ticket_message)."','".addslashes($attachment_name)."','$current_date','$add_uid','1')";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "success";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }

?>