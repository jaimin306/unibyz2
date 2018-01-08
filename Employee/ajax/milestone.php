<?php
    session_start();
    include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
    $add_uid = $_SESSION["user_id"];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $project_id = $_REQUEST["project_id"];
        $milestone_name = $_REQUEST["milestone_name"];
        $notes = $_REQUEST["notes"];
        
        $query = "INSERT INTO tbl_milestone (project_id,milestone_name,notes,add_date,add_uid,status) VALUES ('".addslashes($project_id)."','".addslashes($milestone_name)."','".addslashes($notes)."','$current_date','$add_uid','1')";
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
    if ($cmd == "delete") {
        $id = $_REQUEST["id"];

        $query = "DELETE FROM tbl_milestone WHERE id = '$id'";
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
    if ($cmd == "update") {
        $id = $_REQUEST["id"];
        $project_id = $_REQUEST["project_id"];
        $milestone_name = $_REQUEST["milestone_name"];
        $notes = $_REQUEST["notes"];

        $query = "UPDATE tbl_milestone SET project_id = '".addslashes($project_id)."',milestone_name = '".addslashes($milestone_name)."', notes = '".addslashes($notes)."' WHERE id = '$id'";
        $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

        if ($res) {
            $data['result'] = "true";
            $data['status'] = "usuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
?>