<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	$add_uid = $_SESSION["user_id"];
	if($cmd == "select"){
		$i = 1;
		$j = 0;
		$json = array();
		$color_array = array("#0073b7","#f39c12","#00a65a","#9ca600","#a6008a","#8567e0","#a6005c6b","##095e73","#53096b","#ab3700");
		$color = array_fill(0,9,$color_array);
		$query = "SELECT * FROM tbl_project WHERE add_uid = '$add_uid' ORDER BY id ";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		while($row = mysqli_fetch_assoc($res)){
			$data['project_id'] = $row["id"];
			$data['encrypt_project_id'] = encrypt($row["id"]);
			$data['backgroundColor'] = $color[$j][$i];
			$data['borderColor'] = $data['backgroundColor'];
			$data['title'] = "PJ".Series1000($row["id"])." : ".$row['project_name'];
			$data['start'] = $row['start_date'];
			$data['end'] = $row['end_date'];	
			$json[] = $data;
			$i++;
			if($i%10 == '0'){$j++;};
		}
		echo json_encode($json);
	}
	if($cmd == "GetProjectDetails"){
		$table_row = '';
		$project_id = $_REQUEST["project_id"];
		$query = "SELECT tp.*,tu.first_name,tu.last_name,tu1.first_name as fname,tu1.last_name as lname FROM tbl_project tp LEFT JOIN tbl_user tu ON tu.id = tp.customer_id LEFT JOIN tbl_user tu1 ON tu1.id = tp.project_manager_id WHERE tp.id = '$project_id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row = mysqli_fetch_assoc($res);
		if($row["project_status"] == '0'){	$project_status = "Completed"; }
		if($row["project_status"] == '1'){	$project_status = "In Progress"; }
		if($row["project_status"] == '2'){	$project_status = "Pending"; }

		$data['estimate_no'] = "ES".Series1000($row["estimate_id"]);
		$data['customer_name'] = $row["first_name"]." ".$row["last_name"];
		$data['project_manager'] = $row["fname"]." ".$row["lname"];
		$data['project_status'] = $project_status;
		$data['start_date'] = $row["start_date"];
		$data['end_date'] = $row["end_date"];
		// Task Details
		$select_task = "SELECT tt.*,GROUP_CONCAT(CONCAT_WS(' ', tu.first_name, tu.last_name) SEPARATOR ',') as assignee FROM tbl_task tt LEFT JOIN tbl_task_assign tta ON tta.task_id = tt.id LEFT JOIN tbl_user tu ON tu.id = tta.assigned_to WHERE tt.project_id = '$project_id' GROUP BY tt.id";
		$res_task = mysqli_query($mysqli,$select_task) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$num_rows = mysqli_num_rows($res_task);
		if($num_rows > 0){
			while($row_task = mysqli_fetch_assoc($res_task)){
				$table_row .= '<tr>';	

				$table_row .= '<td>'.$row_task["task_name"].'</td>';
				$table_row .= '<td>'.$row_task["start_date"].'</td>';
				$table_row .= '<td>'.$row_task["end_date"].'</td>';
				$table_row .= '<td>'.str_replace(",", ',<br>', $row_task["assignee"]).'</td>';
				$table_row .= '<td>'.($row_task["task_status"] == '0' ? 'Open' : 'Completed').'</td>';

				$table_row .= '<tr>';
			}
			$data["task_table"] = $table_row;	
		}
		else{
			$data["task_table"] = '<tr><td colspan="5" class="text-center">No Records Found</tr>';		
		}

		// Incidents Details
		$query = "SELECT tt.*,tp.project_name,ttd.department_name,ttt.type_name,tts.status_name FROM tbl_ticket tt LEFT JOIN tbl_project tp ON tp.id = tt.project_id LEFT JOIN tbl_ticket_department ttd ON ttd.id = tt.ticket_department_id LEFT JOIN tbl_ticket_status tts ON tts.id = tt.ticket_status_id LEFT JOIN tbl_ticket_type ttt ON ttt.id = tt.ticket_type_id WHERE tt.status = '1' AND tt.project_id=$project_id AND tt.add_uid = '$add_uid'";
          $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
          $num_rows = mysqli_num_rows($res);
           
          if($num_rows > 0){
            $i = 1;
            $table_row='';
            while($row = mysqli_fetch_assoc($res)){ 
                $table_row.='<tr>';
                $table_row.='<td>'.$i.'</td>';
                $table_row.='<td>'.$row["status_name"].'</td>';
                $table_row.='<td>'.$row["type_name"].'</td>';
                $table_row.='<td>'.$row["department_name"].'</td>';
                $table_row.='<td>'.$row["subject"].'</td>';
                $table_row.='<td>'; 
	              if($row["notify_to"] == '2'){
	                $table_row.='<span class="label label-default">Customer</span>';
	              }
	              if($row["notify_to"] == '3'){
	                $table_row.='<span class="label label-info">Project Manager</span>';
	              }
	              if($row["notify_to"] == '4'){
	                $table_row.='<span class="label label-primary">Employee</span>';
	              }
                $table_row.='</td>';
                $table_row.='<td>'.date("Y-m-d h:i A",strtotime($row["add_date"])).'</td>';
                $table_row.='</tr>';
               
              $i++;
            } 
            $data["incidents"] = $table_row;	                         
          }
          
		else{
			$data["incidents"] = '<tr><td colspan="7" class="text-center">No Records Found</tr>';		
		}


		// Get Project Progress 
		$select_task = "SELECT count(t1.id) as total_task,count(t2.id) as complete_task  FROM tbl_task t1 LEFT JOIN tbl_task t2 ON t1.id=t2.id AND t2.task_status='1' where t1.project_id='".$project_id."' GROUP BY t1.project_id";
		$res_task = mysqli_query($mysqli,$select_task) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$num_rows = mysqli_num_rows($res_task);
		if($num_rows > 0){
			$row_task = mysqli_fetch_assoc($res_task);
			$CompleteTask = ($row_task["complete_task"] != "" ? $row_task["complete_task"] : '0');
			$TotalTask = ($row_task["total_task"] != "" ? $row_task["total_task"] : '0');
			$percent = GetProjectProgress($CompleteTask,$TotalTask);
		}
		else{
			$percent = "0.00";
		}
		// progress color
		if($percent <= 30){
        $progressColor = 'progress-bar-danger';
	    }
	    else if($percent > 30 && $percent <= 70){
	        $progressColor = 'progress-bar-warning';
	    }
	    else if($percent > 70){
	        $progressColor = 'progress-bar-success';
	    }
	    else{
	        $progressColor = 'progress-bar-primary';
	    }
		$data['progressbar'] = $percent."%";
		$data['progressbar_color'] = $progressColor;
		echo json_encode($data);
	}
?>