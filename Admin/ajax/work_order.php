<?php
    session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;
        $category_type = $_REQUEST["category_type"];
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $customer_id = $_REQUEST["customer_id_val"]?$_REQUEST["customer_id_val"]:0;
        $work_order_name = $_REQUEST["work_order_name"];
        $employee_name = $_REQUEST["employee_name"];
        $start_date = $_REQUEST["start_date"];
        $comments = $_REQUEST["comments"];
        $expected_fix_date = $_REQUEST["expected_fix_date"];
        $notes = $_REQUEST["notes"];
        $resource_id = $_REQUEST["resource_id"]?$_REQUEST["resource_id"]:0;
        $send_sms = $_REQUEST["send_sms"];
        $send_email = $_REQUEST["send_email"];
        $add_uid = $_SESSION["user_id"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["photo_path"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/WorkOrder/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */

        $query = "INSERT INTO tbl_work_order (project_id,category_type,category_id,customer_id,work_order_name,employee_name,start_date,comments,expected_fix_date,notes,photo_path,resource_id,send_sms,send_email,add_date,add_uid,status) VALUES ('".addslashes($project_id)."','".addslashes($category_type)."','".addslashes($category_id)."','".addslashes($customer_id)."','".addslashes($work_order_name)."','".addslashes($employee_name)."','".addslashes($start_date)."','".addslashes($comments)."','".addslashes($expected_fix_date)."','".addslashes($notes)."','".addslashes($img_name)."','".addslashes($resource_id)."','".addslashes($send_sms)."','".addslashes($send_email)."','$current_date','$add_uid','1')";         
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
        $category_type = $_REQUEST["category_type"];
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $customer_id = $_REQUEST["customer_id_val"]?$_REQUEST["customer_id_val"]:0;
        $work_order_name = $_REQUEST["work_order_name"];
        $employee_name = $_REQUEST["employee_name"];
        $start_date = $_REQUEST["start_date"];
        $comments = $_REQUEST["comments"];
        $expected_fix_date = $_REQUEST["expected_fix_date"];
        $notes = $_REQUEST["notes"];
        $resource_id = $_REQUEST["resource_id"]?$_REQUEST["resource_id"]:0;
        $send_sms = $_REQUEST["send_sms"];
        $send_email = $_REQUEST["send_email"];
        $photo_path = $_REQUEST["hidden_photo_path"];


        if ($_FILES["photo_path"]["name"] != "") {
            $photo = $_FILES["photo_path"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/WorkOrder/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $photo_path;
        }
        
        $query = "UPDATE tbl_work_order SET project_id = '".addslashes($project_id)."',category_type = '".addslashes($category_type)."',category_id = '".addslashes($category_id)."',customer_id = '".addslashes($customer_id)."',work_order_name = '".addslashes($work_order_name)."',employee_name = '".addslashes($employee_name)."',start_date = '".addslashes($start_date)."',comments = '".addslashes($comments)."',expected_fix_date = '".addslashes($expected_fix_date)."',notes = '".addslashes($notes)."',photo_path = '".addslashes($img_name)."',resource_id = '".addslashes($resource_id)."',send_sms = '".addslashes($send_sms)."',send_email = '".addslashes($send_email)."' WHERE id = '$id'";
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
        $select = "SELECT photo_path FROM tbl_work_order WHERE status = '1' and id = '$id'";
        $q = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["photo_path"];
        if($old_photo != ""){
            if(file_exists("../../uploads/WorkOrder/".$old_photo)){
                unlink("../../uploads/WorkOrder/".$old_photo);    
            }
        }

        $query = "DELETE FROM tbl_work_order WHERE id = '$id'";
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
    if($cmd == "GetProjectCustomer"){
        $eid = $_REQUEST["eid"];
        $query = "SELECT tu.first_name,tu.last_name,tu.id as customer_id FROM tbl_project tp LEFT JOIN tbl_user tu ON tp.customer_id = tu.id WHERE tp.id = '$eid'";       
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $row = mysqli_fetch_assoc($res);
        $customer_name = $row["first_name"]." ".$row["last_name"];
        $customer_id = $row["customer_id"];
        $data["customer_name"] = $customer_name;
        $data["customer_id"] = $customer_id;
        echo json_encode($data);
    }
    if($cmd == "GetCategory"){
        $tid = $_REQUEST["tid"];
        $uid = $_SESSION["user_id"];
        if($tid == "Product"){
            $data['string'] = '<option value="">Please Select Type</option>';
            $query = "SELECT id,category_name FROM tbl_category WHERE add_uid = '$uid' AND status = '1'";
            $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
            while($row = mysqli_fetch_assoc($res)){
                $data['string'] .= '<option value="'.$row["id"].'">'.$row["category_name"].'</option>';
            }
        }
        else if($tid == "Service"){
            $data['string'] = '<option value="">Please Select Type</option>';
            $query = "SELECT id,category_name FROM tbl_service_category WHERE add_uid = '$uid' AND status = '1'";
            $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
            while($row = mysqli_fetch_assoc($res)){
                $data['string'] .= '<option value="'.$row["id"].'">'.$row["category_name"].'</option>';
            }
        }
        else{
            $data['string'] = '<option value="">Please Select Type</option>';
        }
        echo json_encode($data);
        
    }

?>