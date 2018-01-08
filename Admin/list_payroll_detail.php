<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Payroll Added Successfully';
            break;
        case 'usuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Payroll Updated Successfully';
            break;
        case 'dsuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Payroll Deleted Successfully';
            break;
        case 'error':
            $statusMsgClass = 'alert-danger';
            $statusMsg      = 'Error In Payroll... Please Try Again';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg      = '';
    }
}
$uid_payroll = $_SESSION["user_id"];
$eid = decrypt($_GET["EID"]); 
$query = "SELECT * FROM tbl_user WHERE status = '1' and id = '$eid'";
$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
$row = mysqli_fetch_assoc($res); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include "includes/links.php";?>
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
                        <li class="active"><?php echo $row['first_name'].' '.$row['last_name']; ?> -Payroll</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title"><?php echo $row['first_name'].' '.$row['last_name']; ?> -Payroll</h3>
                               <a href="payroll.php"><button class="btn btn-primary pull-right btn-sm" ><i class="fa fa-plus"></i>&nbsp; Add Payroll </button></a>
                               <a href="" onclick="window.history.go(-1);"><button class="btn btn-success pull-right btn-sm" style="margin-right: 10px;">Back</button></a>
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
                                      <th>Pay Date</th>
                                      <th>Gross Amount</th>
                                      <th>Total Deduction</th>
                                      <th>Paid Amount</th>
                                      <th>Payslip</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT p.*,u.first_name,u.last_name FROM tbl_payroll p LEFT JOIN tbl_user u on u.id=p.employee_id WHERE p.status = '1' AND p.employee_id=$eid";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td ><?php echo $i; ?></td> 
                                              <td><?php echo ($row["payroll_date"]?date('d-m-Y',strtotime($row["payroll_date"])):''); ?></td>
                                              <td><?php echo $row["total_pay"]; ?></td>
                                              <td><?php echo $row["total_deduction"]; ?></td>
                                              <td><?php echo $row["net_pay"]; ?></td>
                                              <td><?php echo $row["paid_amount"]; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>                                                    
                                                    <ul class="dropdown-menu" role="menu">
                                                    <li><a href="edit_payroll.php?PID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
                                                      <li><a href="view_payroll_detail.php?PID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-search" ></i> &nbsp;View</a></li>
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
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </section>
            </div>

            <input type="hidden" name="employee_id" id="employee_id" value="<?php echo encrypt($eid); ?>" readonly>
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
                    { sWidth: '10%' },
                    { sWidth: '20%' },
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' }]
                });
                
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      var eid=$('#employee_id').val();
                      $.ajax({
                          url: "ajax/payroll.php",
                          type: "POST",
                          data: {id:id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_payroll_detail.php?status="+(data.status)+'&EID='+eid;
                              }
                              else{
                                  window.location.href="list_payroll_detail.php?status="+(data.status)+'&EID='+eid;
                              }
                          }   
                      });
                      } 
                  });
                  
                });
           
            function confirmDelete() {
                return confirm("Are you sure to delete selected files?");
            }
        </script>
    </body>
</html>