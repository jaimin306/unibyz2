<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Estimate Added Successfully';
            break;
        case 'usuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Estimate Updated Successfully';
            break;
        case 'upsuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Estimate Updated Successfully';
            break;
        case 'dsuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Estimate Deleted Successfully';
            break;
        case 'wosuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'Work Order Generated Successfully';
            break;
        case 'error':
            $statusMsgClass = 'alert-danger';
            $statusMsg      = 'Error In Estimate... Please Try Again';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg      = '';
    }
}
$uid_estimate = $_SESSION["user_id"];
$data = GetRecord('tbl_all_setting','user_id',$uid_estimate);
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
                        <li class="active">Estimate</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Estimates</h3>
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
                                      <th>Customer</th>
                                      <th>Amount</th>
                                      <th>Date</th>
                                      <th>Due On</th>
                                      <th>Status</th>
                                      <th>Last Emailed On</th>
                                      <th>Create On</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT te.*,tu.first_name,tu.last_name,tu.id as cust_id FROM tbl_estimate te LEFT JOIN tbl_user tu ON tu.id = te.customer_id WHERE te.status = '1' AND te.add_uid = '$uid_estimate'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td ><?php echo $i; ?></td>
                                              <td ><?php echo "ES".Series1000($row["id"]); ?></td>
                                              <td><a href="view_customer.php?VID=<?php echo encrypt($row['cust_id']); ?>"><?php echo $row["first_name"]." ".$row["last_name"]; ?></a></td>
                                              <td>
                                                <?php 
                                                  //Calculate Total Amount
                                                  $estimate_id = $row["id"];
                                                  $que_tot = "SELECT SUM(total) as tot_est_amount FROM tbl_estimate_item WHERE estimate_id = '$estimate_id'";
                                                  $res_tot = mysqli_query($mysqli,$que_tot) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  $row_tot = mysqli_fetch_assoc($res_tot);
                                                  if($row_tot["tot_est_amount"] != ""){
                                                    echo "".number_format($row_tot["tot_est_amount"],2);
                                                  }
                                                  else{
                                                    echo '0.00';
                                                  }
                                                ?>
                                              </td>
                                              <td><?php echo date($data["date_format"],strtotime($row["estimate_date"])); ?></td>
                                              <td><?php echo date($data["date_format"],strtotime($row["estimate_due_date"])); ?></td>
                                              <td>
                                                <?php 
                                                  if($row["estimate_status"] == "0"){ echo '<label class="label label-warning">Pending</label>';} 
                                                  if($row["estimate_status"] == "1"){ echo '<label class="label label-success">Accepted</label>';} 
                                                  if($row["estimate_status"] == "2"){ echo '<label class="label label-danger">Rejected</label>';} 
                                                ?>
                                                </td>

                                              <td><?php echo ($row["notify_email"] == "1" && $row["notify_email_date"] != "" ? date($data["date_format"].' H:i:s',strtotime($row["notify_email_date"])) : '<label class="label label-danger">No</label>') ?></td>
                                              <td><?php echo date($data["date_format"],strtotime($row["estimate_date"])); ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <?php
                                                        /*if($row['estimate_status'] == '1'){
                                                          ?>
                                                          <li><a href="javascript:void(0)" value="<?php echo $row['id']; ?>" class="btngenerateorderselected"><i class="fa fa-plus" ></i> &nbsp;Generate Work Order</a></li>
                                                          <?php
                                                        }*/
                                                      ?>
                                                      <li><a href="view_estimate.php?ESTID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-search" ></i> &nbsp;View</a></li>
                                                      <?php
                                                      if($row["estimate_status"] != 1){
                                                        ?>
                                                        <li><a data-status="<?php echo ($row['estimate_status']); ?>" data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#status"><i class="fa fa-sort-numeric-asc" ></i> &nbsp;Change Status</a></li>
                                                        <li><a href="edit_estimate.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
                                                        <?php
                                                      }
                                                      ?>
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
                                <div class="modal fade" id="status">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Change Estimate Status</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <p><b>Status</b></p>
                                          <select name="change_status" id="change_status" class="form-control">
                                            <option value="0">Pending</option>
                                            <option value="1">Accept</option>
                                            <option value="2">Reject</option>
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
                    { sWidth: '4%' },
                    { sWidth: '11%' },
                    { sWidth: '14%' },
                    { sWidth: '9%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '13%' },
                    { sWidth: '9%' },
                    { sWidth: '10%' }]
                });
                
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/estimate.php",
                          type: "POST",
                          data: {id:id, cmd:"DeleteEstimate"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_estimate.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_estimate.php?status="+(data.status);
                              }
                          }   
                      });
                      } 
                  });
                  $(document).on('click','.btngenerateorderselected',function () {
                      if (confirmGenerate()) {
                        var id = $(this).attr('value');
                        $.ajax({
                            url: "ajax/estimate.php",
                            type: "POST",
                            data: {id:id, cmd:"GenerateWorkOrderStatus"},
                            dataType:"JSON",
                            success:function(data){
                                if(data.result == "true"){
                                    window.location.href="list_estimate.php?status="+(data.status);
                                }
                                else{
                                    window.location.href="list_estimate.php?status="+(data.status);
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
                          url: "ajax/estimate.php",
                          type: "POST",
                          data: {id:hide_id, cmd:"update_status",status_id:cs},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_estimate.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_estimate.php?status="+(data.status);
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
            function confirmGenerate() {
                return confirm("Are you sure to generate work order for selected estimate ?");
            }

        </script>
    </body>
</html>