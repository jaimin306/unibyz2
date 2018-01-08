<?php

    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    if (!empty($_GET['status'])) {
        switch ($_GET['status']) {
            case 'success':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Ticket Added Successfully';
                break;
            case 'error':
                $statusMsgClass = 'alert-danger';
                $statusMsg      = 'Error In Ticket... Please Try Again';
                break;
            default:
                $statusMsgClass = '';
                $statusMsg      = '';
        }
    }
    $uid_ticket = $_SESSION["user_id"];
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
                        <li><a href="<?php echo $customer_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Tickets</h3>
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
                                      <th>Estimate No.</th>
                                      <th>Subject</th>
                                      <th>Department</th>
                                      <th>Priority</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      //$query = "SELECT te.*,tu.first_name,tu.last_name FROM tbl_estimate te LEFT JOIN tbl_user tu ON tu.id = te.customer_id WHERE te.status = '1' AND te.customer_id = '$uid_estimate'";
                                      $query = "SELECT tt.*,td.department_name as department_id FROM tbl_ticket tt LEFT JOIN tbl_department td ON td.id = tt.department_id WHERE tt.status = '1' AND tt.add_uid = '$uid_ticket'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td ><?php echo $i; ?></td>
                                              <td ><?php echo "ES".Series1000($row["estimate_id"]); ?></td>
                                              <td ><?php echo $row["subject"]; ?></td>
                                              <td ><?php echo $row["department_id"]; ?></td>
                                              <td>
                                                <?php 
                                                  if($row["priority"] == 'High'){
                                                    echo '<span class="label label-danger">High</span>';
                                                  }
                                                  if($row["priority"] == 'Low'){
                                                    echo '<span class="label label-primary">Low</span>';
                                                  }
                                                  if($row["priority"] == 'Medium'){
                                                    echo '<span class="label label-warning">Medium</span>';
                                                  }
                                                ?>
                                              </td>
                                              <td>
                                                <?php 
                                                  if($row["ticket_status"] == '0'){
                                                    echo '<span class="label label-primary">Open</span>';
                                                  }
                                                  if($row["ticket_status"] == '1'){
                                                    echo '<span class="label label-danger">Close</span>';
                                                  }
                                                  if($row["ticket_status"] == '2'){
                                                    echo '<span class="label label-warning">In Progress</span>';
                                                  }
                                                  if($row["ticket_status"] == '3'){
                                                    echo '<span class="label label-success">Answered</span>';
                                                  }
                                                ?>
                                              </td>
                                              <td><?php echo date("Y-m-d",strtotime($row["add_date"])); ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a href="#"><i class="fa fa-search" ></i> &nbsp;View</a></li>
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
                    { sWidth: '12%' },
                    { sWidth: '23%' },
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' }]
                });
            });
        </script>
    </body>
</html>