<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {

        $project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;
        $ticket_department_id = $_REQUEST["ticket_department_id"]?$_REQUEST["ticket_department_id"]:0;
        $ticket_type_id = $_REQUEST["ticket_type_id"]?$_REQUEST["ticket_type_id"]:0;
        $ticket_status_id = $_REQUEST["ticket_status_id"]?$_REQUEST["ticket_status_id"]:0;
        $subject = $_REQUEST["subject"];
        $notify_to = $_REQUEST["notify_to"]?$_REQUEST["notify_to"]:0;
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
   
    if ($cmd == "update") {
        $id = $_REQUEST["id"];
        $project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;
        $ticket_department_id = $_REQUEST["ticket_department_id"]?$_REQUEST["ticket_department_id"]:0;
        $ticket_type_id = $_REQUEST["ticket_type_id"]?$_REQUEST["ticket_type_id"]:0;
        $ticket_status_id = $_REQUEST["ticket_status_id"]?$_REQUEST["ticket_status_id"]:0;
        $subject = $_REQUEST["subject"];
        $notify_to = $_REQUEST["notify_to"]?$_REQUEST["notify_to"]:0;
        $ticket_message = $_REQUEST["ticket_message"];
        $hidden_attachment = $_REQUEST["hidden_attachment"];

        if ($_FILES["attachment"]["name"] != "") {
            $attachment = $_FILES["attachment"]["name"];
            $new_attachment = date('YmdHis')."_".uniqid()."_".$attachment;
            $tmp_attachment = $_FILES["attachment"]["tmp_name"];
            if (move_uploaded_file($tmp_attachment, "../../uploads/ticket/".$new_attachment)) {
                $attachment_name = $new_attachment;
            } else {
                $attachment_name = "";
            }
        } else {
            $attachment_name = $hidden_attachment;
        }

        $query = "UPDATE tbl_ticket SET project_id = '".addslashes($project_id)."',ticket_department_id = '".addslashes($ticket_department_id)."',ticket_type_id = '".addslashes($ticket_type_id)."',ticket_status_id = '".addslashes($ticket_status_id)."',subject = '".addslashes($subject)."',notify_to = '".addslashes($notify_to)."',ticket_message = '".addslashes($ticket_message)."',attachment = '".addslashes($attachment_name)."' WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "usuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    
    if ($cmd == "delete") {
        $id = $_REQUEST["id"];
        $select = "SELECT attachment FROM tbl_ticket WHERE status = '1' and id = '$id'";
        $q = mysqli_query($mysqli, $select);
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["attachment"];
        if($old_photo != ""){
            if(file_exists("../../uploads/ticket/".$old_photo)){
                unlink("../../uploads/ticket/".$old_photo);    
            }
        }

        $query = "DELETE FROM tbl_ticket WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query);
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "dsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }

    if ($cmd == "GetMessage") {
        $id = $_REQUEST["id"];
        $query = "SELECT subject,ticket_message,attachment FROM tbl_ticket WHERE status = '1' and id = '$id'";
        $res = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($res);
        $data['subject'] = $row["subject"];
        $data['message'] = $row["ticket_message"];
        $data['attachment'] = $row["attachment"];
        echo json_encode($data);
    }
?>