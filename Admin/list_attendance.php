<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Attendance Added Successfully';
              break;
          case 'usuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Attendance Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Attendance Deleted Successfully';
              break;
          case 'upsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'ClockOut Successfully';
              break;
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Attendance... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
      }
  }
  $uid_attendance = $_SESSION["user_id"];
  
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
                        <li class="active">Attendance</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Attendance</h3>
                              <a data-toggle="modal" data-target="#attendance" ><button class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp; Add Attendance</button></a>
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
                                      <th >No.</th>
                                      <th >Employee Name</th>
                                      <th >Employee ID</th>
                                      <th >Date</th>
                                      <th >Sign In</th>
                                      <th >Sign Out</th>
                                      <th >Stay</th>
                                      <th ></th>
                                      <th >Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT ta.*,tu.first_name,tu.last_name,tu.emp_id FROM tbl_attendance ta LEFT JOIN tbl_user tu ON tu.id = ta.employee_id WHERE ta.status = '1' AND ta.add_uid = '$uid_attendance'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row["first_name"]." ".$row["last_name"]; ?></td>
                                              <td><?php echo $row["emp_id"]; ?></td>
                                              <td><?php echo date("Y-m-d",strtotime($row["add_date"])); ?></td>
                                              <td><?php echo $row["sign_in"]; ?></td>
                                              <td><?php echo $row["sign_out"]; ?></td>
                                              <td><?php if($row["sign_in"] != "" && $row["sign_out"] != ""){ echo TimeDiff($row["sign_in"],$row["sign_out"]);} ?></td>
                                              <td><a href="javascript:void(0)" value="<?php echo $row['id']; ?>" class="btnclockoutselected"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-clock-o"></i> <b>ClockOut</b></button></a></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a href="attendance.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
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
                                <div class="modal fade" id="attendance" data-backdrop="static" data-keyboard="false">
                                  <div class="modal-dialog jackInTheBox animated">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Attendance</h4>
                                      </div>
                                      <form role="form" method="post" id="attendance_form" action="#" onsubmit="return submitFormAtt();">
                                      <div class="modal-body">
                                        <p><b>Select Employee <span class="text-danger">*</span></b></p>
                                        <select class="form-control" name="employee_id" id="employee_id" style="width: 100%">
                                          <?php
                                            $query_employee = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_attendance' AND user_type IN (3,4)";
                                            $res_employee = mysqli_query($mysqli,$query_employee) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            while($row_employee = mysqli_fetch_assoc($res_employee)){
                                            ?>
                                              <option value="<?php echo $row_employee['id']; ?>" ><?php echo $row_employee['first_name']." ".$row_employee["last_name"]; ?></option>
                                            <?php
                                          }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Sign In</button>
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
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/jquery.fancybox.min.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script >
            $(function () {
                $("#employee_id").select2();
                $('#datatable').DataTable({
                  "bAutoWidth": false,
                  "aoColumns": [
                    { sWidth: '5%' },
                    { sWidth: '15%' },
                    { sWidth: '20%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' }]
                });
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/attandance.php",
                          type: "POST",
                          data: {id:id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_attandance.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_attandance.php?status="+(data.status);
                              }
                          }   
                      });
                      } 
                  });
                  $(document).on('click','.btnclockoutselected',function () {
                    if (confirmClockOut()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/attandance.php",
                          type: "POST",
                          data: {id:id, cmd:"clockOut"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_attandance.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_attandance.php?status="+(data.status);
                              }
                          }   
                      });
                      } 
                  });
              });
              function confirmDelete() {
                return confirm("Are you sure to delete selected files?");
              }
              function confirmClockOut() {
                return confirm("Are you sure to ClockOut ?");
              }
              function submitFormAtt() {    
                var form_data = new FormData(document.getElementById("attendance_form"));
                form_data.append("cmd", "insert");
                $.ajax({
                    url: "ajax/attendance.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_attendance.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_attendance.php?status="+(data.status);
                        }
                    }   
                });
                return false; 
              }
        </script>
    </body>
</html>