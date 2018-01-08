<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
    $add_uid = $_SESSION["user_id"];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;
        $task_name = $_REQUEST["task_name"];
        $start_date = $_REQUEST["start_date"]?"'".$_REQUEST["start_date"]."'":'NULL';
        $end_date = $_REQUEST["end_date"]?"'".$_REQUEST["end_date"]."'":'NULL';
        $task_status = $_REQUEST["task_status"]?$_REQUEST["task_status"]:0;
        $milestone_id = $_REQUEST["milestone_id"]?$_REQUEST["milestone_id"]:0;
        $notes = $_REQUEST["notes"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $attachment = $_FILES["attachment"]["name"];
            $new_attachment = date('YmdHis')."_".uniqid()."_".$attachment;
            $tmp_attachment = $_FILES["attachment"]["tmp_name"];
            if (move_uploaded_file($tmp_attachment, "../../uploads/task/".$new_attachment)) {
                $attachment_name = $new_attachment;
            } else {
                $attachment_name = "";
            }
        } else {
            $attachment_name = "";
        }
        /* Upload Photo */
        $query = "INSERT INTO tbl_task (project_id,milestone_id,task_name,start_date,end_date,task_status,notes,attachment,add_date,add_uid,status) VALUES ('".addslashes($project_id)."','".addslashes($milestone_id)."','".addslashes($task_name)."',$start_date,$end_date,'".addslashes($task_status)."','".addslashes($notes)."','".addslashes($attachment_name)."','$current_date','$add_uid','1')";

        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $last_id = mysqli_insert_id($mysqli);
        
        $assigned_to_arr = $_REQUEST["assigned_to"];
        for($i=0;$i<count($assigned_to_arr);$i++){
            $assigned_to = $assigned_to_arr[$i]?$assigned_to_arr[$i]:0;
            $insert = "INSERT INTO tbl_task_assign (task_id,assigned_to,add_date,add_uid,status) VALUES ('$last_id','$assigned_to','$current_date','$add_uid','1')";
            $res1 = mysqli_query($mysqli, $insert) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        }

        $type_arr = $_REQUEST["type"];
        $category_id_arr = $_REQUEST["category_id"];
        $category_type_id_arr = $_REQUEST["category_type_id"];
        $product_id_arr = $_REQUEST["product_id"];
        $qty_arr = $_REQUEST["qty"];
        for($i=0;$i<count($type_arr);$i++){
            $type = $type_arr[$i];
            $category_id = $category_id_arr[$i]?$category_id_arr[$i]:0;
            $category_type_id = $category_type_id_arr[$i]?$category_type_id_arr[$i]:0;
            $product_id = $product_id_arr[$i]?$product_id_arr[$i]:0;
            $qty = $qty_arr[$i]?$qty_arr[$i]:0;

            $insert_p = "INSERT INTO tbl_task_product (task_id,type,category_id,category_type_id,product_id,qty,add_date,add_uid,status) VALUES ('$last_id','$type','$category_id','$category_type_id','$product_id','$qty','$current_date','$add_uid','1')";
            $res_p = mysqli_query($mysqli, $insert_p) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        }

        if ($res) {
            $data['result'] = "true";
            $data['status'] = "success";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "delete") {
        $id = $_REQUEST["id"];

        $query = "DELETE FROM tbl_task WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        $query1 = "DELETE FROM tbl_task_assign WHERE task_id = '$id'";
        $res1 = mysqli_query($mysqli, $query1) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        $query2 = "DELETE FROM tbl_task_product WHERE task_id = '$id'";
        $res2 = mysqli_query($mysqli, $query2) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        if ($res && $res1 && $res2) {
            $data['result'] = "true";
            $data['status'] = "dsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "update") {
        $id = $_REQUEST["id"];
        $project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;
        $milestone_id = $_REQUEST["milestone_id"]?$_REQUEST["milestone_id"]:0;
        $task_name = $_REQUEST["task_name"];
        $start_date = $_REQUEST["start_date"]?"'".$_REQUEST["start_date"]."'":'NULL';
        $end_date = $_REQUEST["end_date"]?"'".$_REQUEST["end_date"]."'":'NULL';
        $notes = $_REQUEST["notes"];
        $attachment = $_REQUEST["hidden_attachment"];
        $add_uid = $_SESSION["user_id"];
        $current_date = date("Y-m-d H:i:s");

        if ($_FILES["attachment"]["name"] != "") {
            $attachment = $_FILES["attachment"]["name"];
            $new_attachment = date('YmdHis')."_".uniqid()."_".$attachment;
            $tmp_attachment = $_FILES["attachment"]["tmp_name"];
            if (move_uploaded_file($tmp_attachment, "../../uploads/task/".$new_attachment)) {
                $attachment_name = $new_attachment;
            } else {
                $attachment_name = "";
            }
        } else {
            $attachment_name = $attachment;
        }
        
        $delete = "DELETE FROM tbl_task_assign WHERE task_id = '$id'";
        $res_delete = mysqli_query($mysqli, $delete) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        $query = "UPDATE tbl_task SET project_id = '".addslashes($project_id)."',milestone_id = '".addslashes($milestone_id)."',task_name = '".addslashes($task_name)."',start_date = $start_date,end_date = $end_date,notes = '".addslashes($notes)."',attachment = '".addslashes($attachment_name)."' WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        $assigned_to_arr = $_REQUEST["assigned_to"];

        for($i=0;$i<count($assigned_to_arr);$i++){
            $assigned_to = $assigned_to_arr[$i]?$assigned_to_arr[$i]:0;
            $insert = "INSERT INTO tbl_task_assign (task_id,assigned_to,add_date,add_uid,status) VALUES ('$id','$assigned_to','$current_date','$add_uid','1')";
            $res1 = mysqli_query($mysqli, $insert) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        }

        //task_product
        $delete = "DELETE FROM tbl_task_product WHERE task_id = '$id'";
        $res_delete = mysqli_query($mysqli, $delete) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));

        $type_arr = $_REQUEST["type"];
        $category_id_arr = $_REQUEST["category_id"];
        $category_type_id_arr = $_REQUEST["category_type_id"];
        $product_id_arr = $_REQUEST["product_id"];
        $qty_arr = $_REQUEST["qty"];
        for($i=0;$i<count($type_arr);$i++){
            $type = $type_arr[$i]?$type_arr[$i]:0;
            $category_id = $category_id_arr[$i]?$category_id_arr[$i]:0;
            $category_type_id = $category_type_id_arr[$i]?$category_type_id_arr[$i]:0;
            $product_id = $product_id_arr[$i]?$product_id_arr[$i]:0;
            $qty = $qty_arr[$i]?$qty_arr[$i]:0;

            $insert_p = "INSERT INTO tbl_task_product (task_id,type,category_id,category_type_id,product_id,qty,add_date,add_uid,status) VALUES ('$id','$type','$category_id','$category_type_id','$product_id','$qty','$current_date','$add_uid','1')";
            $res_p = mysqli_query($mysqli, $insert_p) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        }

        if ($res) {
            $data['result'] = "true";
            $data['status'] = "usuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "GetCategory") {
        $sid = $_REQUEST["sid"];
        if($sid != ""){
            $data['string'] = '<option value="">Please Select</option>';
            if($sid == "Product")
            {
                //$query = "SELECT tc.id,tc.category_name FROM tbl_category tc LEFT JOIN tbl_user tu ON tu.add_uid = tc.add_uid WHERE tc.status = '1' GROUP BY tc.id";
                $query = "SELECT tc.id,tc.category_name FROM tbl_category tc LEFT JOIN tbl_user tu ON tu.add_uid = tc.add_uid WHERE tu.id = '$add_uid' AND tc.status = '1'";
            }
            else{
                $query = "SELECT tc.id,tc.category_name FROM tbl_service_category tc LEFT JOIN tbl_user tu ON tu.add_uid = tc.add_uid WHERE tc.status = '1' AND tu.id = '$add_uid'"; 
            }    
            // echo $query;
            $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
            while ($row = mysqli_fetch_assoc($res)){
                $data['string'] .= '<option value="'.$row["id"].'">'.$row["category_name"].'</option>';
            }
        }
        else{
            $data['string'] = '<option value="">Please Select</option>';
        }
        echo json_encode($data);
    }
    if ($cmd == "GetCategoryType") {
        $type = $_REQUEST["type"];
        $cid = $_REQUEST["cid"];
        if($cid != ""){
            $data['string'] = '<option value="">Please Select</option>';
            if($type == "Product")
            {
                $query = "SELECT tpt.id,tpt.product_type_name as type_name FROM tbl_product_type tpt LEFT JOIN tbl_user tu ON tu.add_uid = tpt.add_uid WHERE tpt.status = '1' AND tpt.category_id = '$cid' AND tu.id = '$add_uid'";
            }
            else{
                $query = "SELECT tst.id,tst.service_type_name as type_name FROM tbl_service_type tst LEFT JOIN tbl_user tu ON tu.add_uid = tst.add_uid WHERE tst.status = '1' AND tst.category_id = '$cid' AND  tu.id = '$add_uid'";
            }    
            $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
            while ($row = mysqli_fetch_assoc($res)){
                $data['string'] .= '<option value="'.$row["id"].'">'.$row["type_name"].'</option>';
            }
        }
        else{
            $data['string'] = '<option value="">Please Select</option>';
        }
        echo json_encode($data);
    }
    if ($cmd == "GetProductService") {
        $tid = $_REQUEST["tid"];
        $type = $_REQUEST["type"];
        if($tid != ""){
            $data['string'] = '<option value="">Please Select</option>';
            if($type == "Product"){
                $query = "SELECT tp.id,tp.product_name as pname FROM tbl_product tp LEFT JOIN tbl_user tu ON tu.add_uid = tp.add_uid WHERE tp.product_type_id = '$tid' AND tp.status = '1' AND tu.id = '$add_uid'";
            }
            else{
                $query = "SELECT ts.id,ts.service_name as pname FROM tbl_service ts LEFT JOIN tbl_user tu ON tu.add_uid = ts.add_uid WHERE ts.service_type_id = '$tid' AND ts.status = '1' AND tu.id = '$add_uid'";    
            }
            $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
            while ($row = mysqli_fetch_assoc($res)){
                $data['string'] .= '<option value="'.$row["id"].'">'.$row["pname"].'</option>';
            }
        }
        else{
            $data['string'] = '<option value="">Please Select</option>';
        }
        echo json_encode($data);
    }
    if ($cmd == "GetMilestone") {
        $pid = $_REQUEST["pid"];
        $data['string'] = '<option value="">Please Select Milestone</option>';
        $query = "SELECT * FROM tbl_milestone WHERE status = '1' AND add_uid = '$add_uid' AND project_id = '$pid'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        while ($row = mysqli_fetch_assoc($res)){
            $data['string'] .= '<option value="'.$row["id"].'">'.$row["milestone_name"].'</option>';
        }
        echo json_encode($data);
    }
    if($cmd == "GetTaskProduct"){
        $taskid = $_REQUEST["taskid"];
        $table_row = '';
        
        $query = "SELECT * FROM tbl_task_product ttp WHERE ttp.task_id = '$taskid'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        while($row = mysqli_fetch_assoc($res)){
            $type = $row["type"];
            
            $table_row .= '<tr>';

            $table_row .= '<td>'.$row["type"].'</td>';

            $table_row .= '<td>'.GetCategory($type,$row["category_id"]).'</td>';

            $table_row .= '<td>'.GetCategoryType($type,$row["category_type_id"]).'</td>';

            $table_row .= '<td>'.GetProductService($type,$row["product_id"]).'</td>';

            $table_row .= '<td>'.$row["qty"].'</td>';

            $table_row .= '</tr>';
        }
        $data['table'] = $table_row;

        ///// Get Attachment
        $select = "SELECT attachment FROM tbl_task WHERE id = '$taskid'";
        $res_select = mysqli_query($mysqli, $select) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $row_select = mysqli_fetch_assoc($res_select);
        if($row_select["attachment"] != ""){
            $data['attachment'] = '<a href="../uploads/task/'.$row_select["attachment"].'" download><i class="fa fa-upload" style="font-size:14px"></i> &nbsp;&nbsp;Download Attachment </a>';
        }
        else{
            $data['attachment'] = '';
        }
        
        echo json_encode($data);
    }
    function GetCategory($type,$id){
        global $mysqli;
        $table = ($type == "Product") ? 'tbl_service_category' : 'tbl_service_category';        
        $query = "SELECT category_name FROM $table WHERE id = $id";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $row = mysqli_fetch_assoc($res);
        $category_name = $row["category_name"];
        return $category_name;
    }

    function GetCategoryType($type,$id){
        global $mysqli;
        $table = ($type == "Product") ? 'tbl_product_type' : 'tbl_service_type';
        $field = ($type == "Product") ? 'product_type_name' : 'service_type_name';
        
        $query = "SELECT $field as cat_type_id FROM $table WHERE id = $id";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $row = mysqli_fetch_assoc($res);
        $category_type = $row["cat_type_id"];
        return $category_type;
    }
    function GetProductService($type,$id){
        global $mysqli;
        $table = ($type == "Product") ? 'tbl_product' : 'tbl_service';
        $field = ($type == "Product") ? 'product_name' : 'service_name';
        
        $query = "SELECT $field as name FROM $table WHERE id = $id";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        $row = mysqli_fetch_assoc($res);
        $name = $row["name"];
        return $name;
    }

    if($cmd == "update_status"){
        $id = $_REQUEST["id"];
        $status_id = $_REQUEST["status_id"];

        $query = "UPDATE tbl_task SET task_status = '".addslashes($status_id)."' WHERE id = '$id'";
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
?>