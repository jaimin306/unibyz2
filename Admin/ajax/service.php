<?php
    session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $service_type_id = $_REQUEST["service_type_id"]? $_REQUEST["service_type_id"]:0;
        $service_name = $_REQUEST["service_name"];
        $code = $_REQUEST["code"];
        $hourly_rate = $_REQUEST["hourly_rate"]?$_REQUEST["hourly_rate"]:0;
        $daily_rate = $_REQUEST["daily_rate"]?$_REQUEST["daily_rate"]:0;
        $service_level = $_REQUEST["service_level"];
        $description = $_REQUEST["description"];
        $notes = $_REQUEST["notes"];
        $add_uid = $_SESSION["user_id"];
        
        $query = "INSERT INTO tbl_service (category_id,service_type_id,service_name,code,hourly_rate,daily_rate,service_level,description,notes,add_date,add_uid,status) VALUES ('".addslashes($category_id)."','".addslashes($service_type_id)."','".addslashes($service_name)."','".addslashes($code)."','".addslashes($hourly_rate)."','".addslashes($daily_rate)."','".addslashes($service_level)."','".addslashes($description)."','".addslashes($notes)."','$current_date','$add_uid','1')";

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
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $service_type_id = $_REQUEST["service_type_id"]? $_REQUEST["service_type_id"]:0;
        $service_name = $_REQUEST["service_name"];
        $code = $_REQUEST["code"];
        $hourly_rate = $_REQUEST["hourly_rate"]?$_REQUEST["hourly_rate"]:0;
        $daily_rate = $_REQUEST["daily_rate"]?$_REQUEST["daily_rate"]:0;
        $service_level = $_REQUEST["service_level"];
        $description = $_REQUEST["description"];
        $notes = $_REQUEST["notes"];

        $query = "UPDATE tbl_service SET category_id = '".addslashes($category_id)."',service_type_id = '".addslashes($service_type_id)."',service_name = '".addslashes($service_name)."',code = '".addslashes($code)."',hourly_rate = '".addslashes($hourly_rate)."',daily_rate = '".addslashes($daily_rate)."',service_level = '".addslashes($service_level)."',description = '".addslashes($description)."',notes = '".addslashes($notes)."' WHERE id = '$id'";
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
      
        $query = "DELETE FROM tbl_service WHERE id = '$id'";
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
    if ($cmd == "GetServiceType") {
        $cid = $_REQUEST["cid"];
        $data['string'] = '<option value="">Please Select Service Type</option>';
        $query = "SELECT id,service_type_name FROM tbl_service_type WHERE status = '1' and category_id = '$cid'";
        $res = mysqli_query($mysqli, $query);
        while($row = mysqli_fetch_assoc($res)){
            $data['string'] .= '<option value="'.$row["id"].'">'.$row["service_type_name"].'</option>';
        }
        echo json_encode($data);
    }
?>