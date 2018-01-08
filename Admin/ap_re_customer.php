<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Customer Added Successfully';
              break;
          case 'usuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Customer Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Customer Deleted Successfully';
              break;
          case 'upstatus':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Customer Status Changed Successfully';
              break;
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Customer... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
      }
  }
  $uid_user = $_SESSION["user_id"];
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
                        <li class="active">Customer</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Customers</h3>
                              <a href="customer.php"><button class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp; Add Customer</button></a>
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
                                      <th>Name</th>
                                      <th>Phone</th>
                                      <th>Email</th>
                                      <th>Address</th>
                                      <th>Login Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT * FROM tbl_user WHERE add_uid = '$uid_user' AND user_type = '2' AND user_status IN (0,2)";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row["first_name"]." ".$row["last_name"]; if($row["user_image"] != ""){echo '<br><a data-fancybox="gallery" href="../uploads/customer/'.$row["user_image"].'"><img src="../uploads/customer/'.$row["user_image"].'" height="65px" width="45%"/></a>';}?></td>
                                              <td><?php echo $row["phone"]; ?></td>
                                              <td><?php echo $row["email"]; ?></td>
                                              <td><?php echo $row["address"]; ?></td>
                                              <td>
                                              <?php 
                                                if($row["user_status"] == "0"){ echo '<span class="label label-success">Approve</span>';} 
                                                if($row["user_status"] == "1"){ echo '<span class="label label-warning">Pending</span>';} 
                                                if($row["user_status"] == "2"){ echo '<span class="label label-danger">Reject</span>';} 
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
                                                      <li><a href="view_customer.php?VID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-search" ></i> &nbsp;Details</a></li>
                                                      <li><a data-status="<?php echo ($row['user_status']); ?>" data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#status"><i class="fa fa-sort-numeric-asc" ></i> &nbsp;Change Status</a></li>
                                                      <li><a href="customer.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
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
                                        <h4 class="modal-title">Change Customer Status</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <p><b>Status</b></p>
                                          <select name="change_status" id="change_status" class="form-control">
                                            <option value="0">Approve</option>
                                            <option value="1">Pending</option>
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
                    { sWidth: '5%' },
                    { sWidth: '20%' },
                    
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '20%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' }]
                });
                $('.image-popup-no-margins').magnificPopup({
                  type: 'image',
                  closeOnContentClick: true,
                  closeBtnInside: false,
                  fixedContentPos: true,
                  mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                  image: {
                    verticalFit: true
                  },
                  zoom: {
                    enabled: true,
                    duration: 300 // don't foget to change the duration also in CSS
                  }
                });
                
                $(document).on('click','.btndeleteselected',function () {
                  if (confirmDelete()) {
                    var id = $(this).attr('value');
                    $.ajax({
                        url: "ajax/customer.php",
                        type: "POST",
                        data: {id:id, cmd:"delete"},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="ap_re_customer.php?status="+(data.status);
                            }
                            else{
                                window.location.href="ap_re_customer.php?status="+(data.status);
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
                        url: "ajax/customer.php",
                        type: "POST",
                        data: {id:hide_id, cmd:"update_status",status_id:cs},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="ap_re_customer.php?status="+(data.status);
                            }
                            else{
                                window.location.href="ap_re_customer.php?status="+(data.status);
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