<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $reporter_id = $_REQUEST["reporter_id"];
        $department_id = $_REQUEST["department_id"];
        $subject = $_REQUEST["subject"];
        $priority = $_REQUEST["priority"];
        $ticket_message = $_REQUEST["ticket_message"];
        $add_uid = $_SESSION["user_id"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["photo_path"]["name"];
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/ticket/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */
        $query = "INSERT INTO tbl_ticket (reporter_id,department_id,subject,priority,ticket_message,photo_path,add_date,add_uid,status) VALUES ('".addslashes($reporter_id)."','".addslashes($department_id)."','".addslashes($subject)."','".addslashes($priority)."','".addslashes($ticket_message)."','".addslashes($img_name)."','$current_date','$add_uid','1')";
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
    if ($cmd == "InsertMessage") {
        $ticket_id = $_REQUEST["ticket_id"];
        $message = $_REQUEST["message"];
        $add_uid = $_SESSION["user_id"];
        $message_by_user_id = $_SESSION["user_id"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["attachment"]["name"];
            $tmp_photo = $_FILES["attachment"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/ticketMessage/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */
        $query = "INSERT INTO tbl_ticket_message (ticket_id,message_by_user_id,message,attachment,add_date,add_uid,status) VALUES ('".addslashes($ticket_id)."','".addslashes($message_by_user_id)."','".addslashes($message)."','".addslashes($img_name)."','$current_date','$add_uid','1')";
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
        $reporter_id = $_REQUEST["reporter_id"];
        $department_id = $_REQUEST["department_id"];
        $subject = $_REQUEST["subject"];
        $priority = $_REQUEST["priority"];
        $ticket_message = $_REQUEST["ticket_message"];
        $photo_path = $_REQUEST["hidden_photo_path"];


        if ($_FILES["photo_path"]["name"] != "") {
            $photo = $_FILES["photo_path"]["name"];
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/ticket/".$photo)) {
                $img_name = $photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $photo_path;
        }

        $query = "UPDATE tbl_ticket SET reporter_id = '".addslashes($reporter_id)."',department_id = '".addslashes($department_id)."',subject = '".addslashes($subject)."',priority = '".addslashes($priority)."',ticket_message = '".addslashes($ticket_message)."',photo_path = '".addslashes($img_name)."' WHERE id = '$id'";
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
    if ($cmd == "ChangeStatus") {
        $statusval = $_REQUEST["statusval"];
        $ticket_id = $_REQUEST["ticket_id"];


        $query = "UPDATE tbl_ticket SET ticket_status = '".addslashes($statusval)."' WHERE id = '$ticket_id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "upsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "delete") {
        $id = $_REQUEST["id"];

        $select = "SELECT photo_path FROM tbl_ticket WHERE status = '1' and id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["photo_path"];
        if($old_photo != ""){
            if(file_exists('../../uploads/ticket/'.$old_photo)){
                unlink("../../uploads/ticket/".$old_photo);    
            }
        }

        $query = "DELETE FROM tbl_ticket WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $query1 = "DELETE FROM tbl_ticket_message WHERE ticket_id = '$id'";
        $res1 = mysqli_query($mysqli, $query1) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "dsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "deleteMessage") {
        $id = $_REQUEST["id"];

        $select = "SELECT attachment FROM tbl_ticket_message WHERE status = '1' and id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["attachment"];
        if($old_photo != ""){
            if(file_exists('../../uploads/ticketMessage/'.$old_photo)){
                unlink("../../uploads/ticketMessage/".$old_photo);    
            }
        }

        $query = "DELETE FROM tbl_ticket_message WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "dsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if($cmd == "GetMessage"){
        $ticket_id = $_REQUEST["ticket_id"];
        $data['string'] = "";
        

        $select_message = "SELECT ttm.*,tu.first_name,tu.last_name FROM tbl_ticket_message ttm LEFT JOIN tbl_user tu ON tu.id = ttm.message_by_user_id WHERE ttm.ticket_id = '$ticket_id' AND ttm.status = '1' ORDER BY ttm.id DESC";
        $res_message = mysqli_query($mysqli,$select_message) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $num_rows = mysqli_num_rows($res_message);
        if($num_rows > 0){
            while($row_message = mysqli_fetch_assoc($res_message)){
                $data['string'] .='<div class="message-item" ><div class="message-inner"><div class="message-head clearfix"><div class="user-detail"><h5 class="handle">';
                $data['string'] .= $row_message["first_name"]." ".$row_message["last_name"];
                $data['string'] .= '</h5><div class="post-meta"><div class="asker-meta"><span class="qa-message-when-data muted">';
                $data['string'] .= EplapseTime($row_message["add_date"]);
                $data['string'] .= '</span>&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" value="'.$row_message['id'].'" class="btn btn-xs btn-danger btndeletemessageselected" data-original-title="Delete" title=""><i class="fa fa-trash"></i></a></div></div></div></div><div class="qa-message-content">';
                if($row_message["attachment"] != ""){
                    $data['string'] .='<a data-fancybox="gallery" data-toggle="tooltip" data-original-title="View Attachment" href="../uploads/ticketMessage/'.$row_message["attachment"].'"> View</a><br>';
                }
                $data['string'] .= $row_message["message"].'</div></div></div>';
            }
            echo json_encode($data);
        }
        else{
            $data['string'] = '<div class="message-item" style="min-height:100px" ><b>No Messages Yet</b> </div>';
            echo json_encode($data);
        }
        
    }

?>