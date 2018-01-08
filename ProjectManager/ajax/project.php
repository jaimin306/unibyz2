<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
    $add_uid = $_SESSION["user_id"];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "update_status"){
        $id = $_REQUEST["id"];
        $status_id = $_REQUEST["status_id"];

        $query = "UPDATE tbl_project SET project_status = '".addslashes($status_id)."' WHERE id = '$id'";
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