<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Project Added Successfully';
              break;
          case 'usuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Project Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Project Deleted Successfully';
              break;
          case 'upstatus':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Project Status Changed Successfully';
              break;
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Project... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
      }
  }
  $uid_project = $_SESSION["user_id"];
  $data = GetRecord('tbl_all_setting','user_id',$uid_project);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include "includes/links.php";?>
        <link rel="stylesheet" type="text/css" href="../dist/css/jquery.fancybox.min.css">
        <style type="text/css">
          .btnstatusselected .label{
            cursor:pointer
          }
        </style>
        
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include "includes/header.php";?>
            <?php include "includes/sidebar.php";?>
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
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Projects</h3>
                              <a href="project.php"><button class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp; Add Project</button></a>
                            </div>
                            <div class="container">
                              <?php if (!empty($statusMsg)) {
                                echo '<div class="alert ' . $statusMsgClass . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $statusMsg . '</div>';
                              }
                              ?>
                              <div class="box-body">
                                <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>Project</th>
                                      <th>Estimate</th>
                                      <th>Customer</th>
                                      <th>Project Manager</th>
                                      <th>Project Name</th>
                                      <th>Start Date</th>
                                      <th>End Date</th>
                                      <th>Progress</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT tp.*,tu.first_name,tu.last_name,tu1.first_name as fname,tu1.last_name as lname FROM tbl_project tp LEFT JOIN tbl_user tu ON tu.id = tp.customer_id LEFT JOIN tbl_user tu1 ON tu1.id = tp.project_manager_id WHERE tp.add_uid = '$uid_project'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td><?php echo "PJ".Series1000($row["id"]); ?></td>
                                              <td><?php echo "ES".Series1000($row["estimate_id"]); ?></td>
                                              <td><?php echo $row["first_name"]." ".$row["last_name"]; ?></td>
                                              <td><?php echo $row["fname"]." ".$row["lname"];?></td>
                                              <td><?php echo $row["project_name"]; ?></td>
                                              <td><?php echo date($data["date_format"],strtotime($row["start_date"])); ?></td>
                                              <td><?php echo date($data["date_format"],strtotime($row["end_date"])); ?></td>
                                              <td>
                                                <?php 
                                                  $select_task = "SELECT count(t1.id) as total_task,count(t2.id) as complete_task  FROM tbl_task t1 LEFT JOIN tbl_task t2 ON t1.id=t2.id AND t2.task_status='1' where t1.project_id='".$row["id"]."' GROUP BY t1.project_id";
                                                  // echo $select_task;
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
                                                ?>
                                                <div class="progress progress-sm" title="<?php echo $percent."%"; ?>">
                                                  <div class="progress-bar progress-bar-success progress-bar-striped active text-danger" role="progressbar" aria-valuenow="<?php echo $percent.'%' ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent."%"; ?>;border-radius:5px;line-height:10px"><?php if($percent == '0.00'){ echo '<span style="color:red;">0.00%</span>'; } ?></div>
                                                </div>
                                              </td>
                                              <td>
                                              <?php 
                                                if($row["project_status"] == "0"){ echo '<span class="label label-success">Completed</span>';} 
                                                if($row["project_status"] == "1"){ echo '<span class="label label-warning">In Progress</span>';} 
                                                if($row["project_status"] == "2"){ echo '<span class="label label-danger">Pending</span>';} 
                                              ?>
                                              </td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a href="view_project.php?VID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-search" ></i> &nbsp;Details</a></li>
                                                      <li><a data-status="<?php echo ($row['project_status']); ?>" data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#status"><i class="fa fa-sort-numeric-asc" ></i> &nbsp;Change Status</a></li>
                                                      <li><a href="project.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
                                                      <li><a href="javascript:void(0)" value="<?php echo $row['id']; ?>" class="btndeleteselected"><i class="fa fa-trash" ></i> &nbsp;Delete</a></li>
                                                      <?php if($row["project_status"] == "0") {?>
                                                        <li><a href="invoice.php?PID=<?php echo encrypt($row['id']);?>" value="<?php echo $row['id']; ?>"><i class="fa-files-o"  ></i> &nbsp;Generate Invoice</a></li>
                                                      <?php } ?>
                                                    </ul>
                                                </div>
                                              </td>
                                            </tr>
                                          <?php  
                                          $i++;
                                        }                          
                                      }
                                      ?>
                                  </tbody>
                                </table>
                                <div class="modal fade" id="status">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Change Project Status</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <p><b>Status</b></p>
                                          <select name="change_status" id="change_status" class="form-control">
                                            <option value="0">Completed</option>
                                            <option value="1">In Progress</option>
                                            <option value="2">Pending</option>
                                          </select>
                                          <input type="hidden" id="hidden_id_status" class="form-control" name="hidden_id_status" >
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary" id="up_status">Submit</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </section>
            </div>
            <?php include "includes/footer.php";?>
            <?php include "includes/nav-sidebar.php";?>
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
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/jquery.fancybox.min.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script >
            $(function () {
                $('#datatable').DataTable({
                  "bAutoWidth": false,
                  "aoColumns": [
                    { sWidth: '7%' },
                    { sWidth: '7%' },
                    { sWidth: '13%' },
                    { sWidth: '14%' },
                    { sWidth: '14%' },
                    { sWidth: '10%' },
                    { sWidth: '9%' },
                    { sWidth: '8%' },
                    { sWidth: '8%' },
                    { sWidth: '10%' }]
                });
                
                $(document).on('click','.btndeleteselected',function () {
                  if (confirmDelete()) {
                    var id = $(this).attr('value');
                    $.ajax({
                        url: "ajax/project.php",
                        type: "POST",
                        data: {id:id, cmd:"delete"},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_project.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_project.php?status="+(data.status);
                            }
                        }   
                    });
                  } 
                });
                $('#status').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var url = button.data('href'); 
                    var status = button.data('status');
                    var id = button.data('hideid');
                    var modal = $(this);
                    modal.find('#hidden_id_status').val(id);
                    modal.find('#change_status').val(status);
                });
                $( "#up_status" ).on( "click", function() {
                  var cs = $("#change_status").val(); 
                  var hide_id = $("#hidden_id_status").val(); 
                  if(cs != "" && hide_id != ""){
                    $.ajax({
                        url: "ajax/project.php",
                        type: "POST",
                        data: {id:hide_id, cmd:"update_status",status_id:cs},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_project.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_project.php?status="+(data.status);
                            }
                        }   
                    });
                  }
                  else{
                    alert("Please Enter Status");
                  }
                });
                });
                
              function confirmDelete() {
                return confirm("Are you sure to delete selected files?");
              }
              function confirmStatus() {
                return confirm("Are you sure to change status?");
              }
        </script>
    </body>
</html>