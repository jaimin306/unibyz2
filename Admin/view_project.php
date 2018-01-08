<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["VID"]);
    $query = "SELECT tp.*,two.work_order_name,two.id as work_order_id FROM tbl_project tp LEFT JOIN tbl_work_order two ON two.project_id = tp.id WHERE tp.status = '1' and tp.id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);

    $select_task = "SELECT count(t1.id) as total_task,count(t2.id) as complete_task  FROM tbl_task t1 LEFT JOIN tbl_task t2 ON t1.id=t2.id AND t2.task_status='1' where t1.project_id='".$id."' GROUP BY t1.project_id";
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
    $uid_project = $_SESSION["user_id"];
    $data = GetRecord('tbl_all_setting','user_id',$uid_project);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include("includes/links.php"); ?>
        <style type="text/css">
            .tbl_width td {
                width: 25%;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include("includes/header.php"); ?>
            <?php include("includes/sidebar.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1> &nbsp;  </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Project</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-info" style="">
                            <div class="box-header with-border">
                              <h3 class="box-title" style="width: 100%"><b><?php echo "PJ".Series1000($id)." - ".$row["project_name"]; ?></b> <a href="project.php?EID=<?php echo encrypt($row['id']); ?>"> <button class="btn btn-sm btn-info pull-right"><i class="fa fa-edit"></i> &nbsp;Edit Project</button> </a><a href="list_project.php"><button style="margin-right: 10px" class="btn bg-olive btn-sm pull-right"><i class="fa fa-arrow-left"></i> &nbsp;Back</button></a><br></h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-stripped table-hover tbl_width" id="tbl_width">
                                    <tbody>
                                        <tr>
                                            <td colspan="4">
                                                <div class="progress progress-sm" title="<?php echo $percent."%"; ?>">
                                                  <div class="progress-bar <?php echo $progressColor; ?> progress-bar-striped active text-danger" role="progressbar" aria-valuenow="<?php echo $percent.'%' ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent."%"; ?>;border-radius:5px;line-height:10px"><?php if($percent == '0.00'){ echo '<span style="color:red;">0.00%</span>'; } ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Customer</strong></td>
                                            <td><a href="view_customer.php?VID=<?php echo encrypt($row["customer_id"]); ?>" target="_blank"><?php echo GetUser($row["customer_id"]); ?></a></td>
                                            <td><strong>Customer Number</strong></td>
                                            <td><?php echo GetSingleRecord('tbl_estimate','customer_phone',$row["estimate_id"]); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Estimate No.</strong></td>
                                            <td><?php echo "ES".Series1000($row["estimate_id"]); ?></a></td>
                                            <td><strong>Project Manager</strong></td>
                                            <td><?php echo GetUser($row["project_manager_id"]); ?></td>
                                        </tr>   
                                        <tr>
                                            <td><strong>Project Start Date </strong></td>
                                            <td><?php echo date($data["date_format"],strtotime($row["start_date"])); ?></a></td>
                                            <td><strong>Project End Date</strong></td>
                                            <td><?php echo date($data["date_format"],strtotime($row["end_date"])); ?></a></td>
                                        </tr>   
                                        <tr>
                                            <td><strong>Work Order </strong></td>
                                            <td><a href="view_work_order.php?WID=<?php echo encrypt($row["work_order_id"]); ?>" target="_blank"><?php echo $row["work_order_name"]; ?></a></td>
                                        </tr>                                  
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                        <!-- Col-md-12-complete -->
                        <div class="col-md-12 ">
                            <div class="col-md-6 no-padding">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><b>Project Description</b></h3>
                                    </div>
                                    <div class="box-body">
                                        <?php echo ($row["project_description"] != "" ? $row["project_description"] : '<b class="text-center">-</b>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 " style="padding-right: 0">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><b>Notes</b></h3>
                                    </div>
                                    <div class="box-body">
                                        <?php echo ($row["notes"] != "" ? $row["notes"] : '<b class="text-center">-</b>'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="box box-info" style="">
                                <div class="box-header with-border"><h3 class="box-title"><b>Task Details</b></h3></div>
                                <table class="table table-stripped table-hover" id="">
                                    <tbody>
                                        <tr>
                                            <th>Milestone</th>
                                            <th>Task Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Assigned To</th>
                                            <th>Task Status</th>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                            $select_task = "SELECT tt.*,tm.milestone_name as milestone_id,GROUP_CONCAT(CONCAT(tu.first_name, ' ', tu.last_name) SEPARATOR '<br>') as assignee FROM tbl_task tt LEFT JOIN tbl_milestone tm ON tm.id = tt.milestone_id LEFT JOIN tbl_task_assign tta ON tta.task_id = tt.id LEFT JOIN tbl_user tu ON tu.id = tta.assigned_to WHERE tt.project_id = '$id' GROUP BY tta.task_id";
                                            $res_task = mysqli_query($mysqli,$select_task) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            $num_task = mysqli_num_rows($res_task);
                                            if($num_task > 0){
                                                while($row_task = mysqli_fetch_assoc($res_task)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row_task["milestone_id"]; ?></td>
                                                        <td><?php echo $row_task["task_name"]; ?></td>
                                                        <td><?php echo date($data["date_format"],strtotime($row_task["start_date"])); ?></td>
                                                        <td><?php echo date($data["date_format"],strtotime($row_task["end_date"])); ?></td>
                                                        <td><?php echo $row_task["assignee"]; ?></td>
                                                        <td><?php echo ($row_task["task_status"] == "0" ? "<b style='color:green'>Open</b>" : "<b style='color:red'>Completed</b>"); ?></td>
                                                        <td>
                                                        <?php
                                                            if($row_task["attachment"] != ""){
                                                                echo '<a href="../uploads/task/'.$row_task["attachment"].'" download><i class="fa fa-upload" style="color:green;font-size:15px"></i></a>';
                                                            }
                                                            else{
                                                                echo '-';
                                                            }
                                                        ?>
                                                        </td>
                                                        <td><a href="task.php?EID=<?php echo encrypt($row_task['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></td>
                                                    </tr>                                  
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <td colspan="8" class="text-center">No Task Found..</td>
                                                <?php
                                            }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                       <div class="col-md-12 ">
                            <div class="box box-info" style="">
                                <div class="box-header with-border"><h3 class="box-title"><b>Incidents</b></h3></div>
                                <table class="table table-stripped table-hover" id="">
                                    <tbody>
                                        <tr>
                                             <th >No.</th>
                                             <th >Status</th>
                                             <th >Type</th>
                                             <th >Department</th>
                                             <th >Subject</th>
                                             <th >Notify To</th>
                                             <th >Created Date</th>
                                             <th >Action</th>
                                        </tr> 
                                            <?php
                                              $uid_ticket = $_SESSION["user_id"];
                                              $query = "SELECT tt.*,tp.project_name,ttd.department_name,ttt.type_name,tts.status_name FROM tbl_ticket tt LEFT JOIN tbl_project tp ON tp.id = tt.project_id LEFT JOIN tbl_ticket_department ttd ON ttd.id = tt.ticket_department_id LEFT JOIN tbl_ticket_status tts ON tts.id = tt.ticket_status_id LEFT JOIN tbl_ticket_type ttt ON ttt.id = tt.ticket_type_id WHERE tt.status = '1' AND tt.project_id=$id AND tt.add_uid = '$uid_ticket'";
                                              $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                              $num_rows = mysqli_num_rows($res);
                                              if($num_rows > 0){
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($res)){
                                                  ?>
                                                    <tr>
                                                      <td><?php echo $i; ?></td>
                                                      <td><?php echo $row["status_name"];?></td>
                                                      <td><?php echo $row["type_name"]; ?></td>
                                                      <td><?php echo $row["department_name"]; ?></td>
                                                      <td><?php echo $row["subject"]; ?></td>
                                                      <td>
                                                        <?php 
                                                          if($row["notify_to"] == '2'){
                                                            echo '<span class="label label-default">Customer</span>';
                                                          }
                                                          if($row["notify_to"] == '3'){
                                                            echo '<span class="label label-info">Project Manager</span>';
                                                          }
                                                          if($row["notify_to"] == '4'){
                                                            echo '<span class="label label-primary">Employee</span>';
                                                          }
                                                        ?>
                                                      </td>
                                                      <td><?php echo date($data["date_format"]." h:i A",strtotime($row["add_date"])); ?></td>
                                                      <td>                                                       
                                                         <a href="ticket.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a>                                                                                                                     
                                                      </td>
                                                    </tr>
                                                  <?php  
                                                  $i++;
                                                }                          
                                              }
                                              else{
                                                ?>
                                                <td colspan="8" class="text-center">No Records Found.</td>
                                                <?php

                                              }
                                              ?>
                                          </tbody>
                                </table>
                            </div>
                        </div>


                         

                        
                </section>
            </div>
            <?php include("includes/footer.php"); ?>
            <?php include("includes/nav-sidebar.php"); ?>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="../bower_components/jquery/dist/jquery.min.js"></script> 
        <script src="../bower_components/jquery-ui/jquery-ui.min.js"></script> 
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script> 
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
        <script src="../bower_components/raphael/raphael.min.js"></script> 
        <script src="../bower_components/morris.js/morris.min.js"></script> 
        <script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> 
        <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> 
        <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> 
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/jquery.fancybox.min.js"></script>
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
           
        </script>
    </body>
</html>