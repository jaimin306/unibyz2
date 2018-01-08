<?php

    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    if (!empty($_GET['status'])) {
        switch ($_GET['status']) {
            case 'success':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Task Added Successfully';
                break;
            case 'usuccess':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Task Updated Successfully';
                break;
            case 'upsuccess':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Task Status Updated Successfully';
                break;
            case 'dsuccess':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Task Deleted Successfully';
                break;
            case 'upstatus':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Project Status Changed Successfully';
                break;
            case 'error':
                $statusMsgClass = 'alert-danger';
                $statusMsg      = 'Error In Task... Please Try Again';
                break;
            default:
                $statusMsgClass = '';
                $statusMsg      = '';
        }
    }
    $uid_task = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include("includes/links.php"); ?>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include("includes/header.php"); ?>
            <?php include("includes/sidebar.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1> &nbsp;  </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $projectmanager_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Tasks</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Tasks</h3>
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
                                      <th>No.</th>
                                      <th>Project No. / Name</th>
                                      <th>Milestone</th>
                                      <th>Task Name</th>
                                      <th>Start Date</th>
                                      <th>End Date</th>
                                      <th>Assigned To</th>                                       
                                      <th>Task Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT tt.*,tm.milestone_name,tp.project_name,tp.id as pid FROM tbl_task tt LEFT JOIN tbl_project tp ON tp.id = tt.project_id LEFT JOIN tbl_milestone tm ON tm.id = tt.milestone_id WHERE tt.status = '1' AND tt.add_uid = '$uid_task'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td ><?php echo $i; ?></td>
                                              <td ><?php echo "PJ".Series1000($row["pid"])." / ".$row["project_name"]; ?></td>
                                              <td ><?php echo $row["milestone_name"]; ?></td>
                                              <td ><?php echo $row["task_name"]; ?></td>
                                              <td ><?php echo $row["start_date"]; ?></td>
                                              <td ><?php echo $row["end_date"]; ?></td>
                                              <td >
                                                <?php 
                                                  $task_id = $row["id"];
                                                  $s = "SELECT GROUP_CONCAT(CONCAT_WS(' ', tu.first_name, tu.last_name) SEPARATOR ', ') as assignee FROM tbl_task_assign tta LEFT JOIN tbl_user tu ON tu.id = tta.assigned_to WHERE tta.task_id = '$task_id' GROUP BY tta.task_id";
                                                  // echo 
                                                  $q = mysqli_query($mysqli,$s) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  $r = mysqli_fetch_assoc($q);
                                                  echo $r["assignee"]; ?>
                                              </td> 
                                              <td ><?php if($row["task_status"] == "0"){ echo '<span class="label label-danger">Open</span>';}else{ echo '<span class="label label-success">Completed</span>';} ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a data-task-id="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#product"><i class="fa fa-search" ></i> &nbsp;Details</a></li>
                                                      <li><a data-status="<?php echo ($row['task_status']); ?>" data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#status"><i class="fa fa-sort-numeric-asc" ></i> &nbsp;Change Status</a></li>
                                                      <li><a href="task.php?EID=<?php echo encrypt($row['id']); ?>" ><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
                                                      <li><a href="javascript:void(0)" value="<?php echo $row['id']; ?>" class="btndeleteselected"><i class="fa fa-trash" ></i> &nbsp;Delete</a></li>
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
                                <!-- start status popup -->
                                <div class="modal fade" id="status">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Change Task Status</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <p><b>Status</b></p>
                                          <select name="change_status" id="change_status" class="form-control">
                                            <option value="0">Open</option>
                                            <option value="1">Completed</option>
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
                                <!-- end status popup -->
                                <div class="modal fade" id="product" data-backdrop="static" data-keyboard="false" >
                                  <div class="modal-dialog" style="min-width:800px;">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">View Task Details</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                        <div id="attach_div" class="pull-right text-primary"></div>
                                          <table class="table table-striped table-hover table-bordered ">
                                            <tr>
                                                <th>Type</th>
                                                <th>Category</th>
                                                <th>Product / Service Type</th>
                                                <th>Product / Service</th>
                                                <th>Quantity</th>
                                              </tr> 
                                            <tbody id="product-task">
                                              
                                            </tbody>
                                          </table>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#datatable').DataTable({
                  "bAutoWidth": false,
                  "aoColumns": [
                    { sWidth: '5%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' }]
                });
                $(document).on('click','.btndeleteselected',function () {
                  if (confirmDelete()) {
                    var id = $(this).attr('value');
                    $.ajax({
                        url: "ajax/task.php",
                        type: "POST",
                        data: {id:id, cmd:"delete"},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_task.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_task.php?status="+(data.status);
                            }
                        }   
                    });
                    } 
                });
                $('#product').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var taskid = button.data('task-id');
                    var modal = $(this);
                    $("#product-task").html('<i class="fa fa-refresh fa-spin"></i>');
                    $.ajax({
                        url: "ajax/task.php",
                        type: "POST",
                        data: {taskid:taskid,cmd:"GetTaskProduct"},
                        dataType:"JSON",
                        success:function(data){
                            $("#product-task").html(data.table);
                            $("#attach_div").html(data.attachment);
                        }   
                    });
                });

                $('#status').on('show.bs.modal', function (event) {                  
                    var button = $(event.relatedTarget);                     
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
                        url: "ajax/task.php",
                        type: "POST",
                        data: {id:hide_id, cmd:"update_status",status_id:cs},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_task.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_task.php?status="+(data.status);
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
        </script>
    </body>
</html>