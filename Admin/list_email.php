<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'EMail Sent Successfully';
            break;
        case 'dsuccess':
            $statusMsgClass = 'alert-success';
            $statusMsg      = 'EMail Deleted Successfully';
            break;
        case 'error':
            $statusMsgClass = 'alert-danger';
            $statusMsg      = 'Error In EMail... Please Try Again';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg      = '';
    }
}
$uid_email = $_SESSION["user_id"];
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
                        <li class="active">Email</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Sent Mail</h3>
                              <a href="email.php"><button class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp; Send Email</button></a>
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
                                      <th>Send By</th>
                                      <th>To</th>
                                      <th>Subject</th>
                                      <th>Date</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT te.*,tu.first_name,tu.last_name,tu1.first_name as fname,tu1.last_name as lname FROM  tbl_email te LEFT JOIN tbl_user tu ON tu.id = te.send_user_id LEFT JOIN tbl_user tu1 ON tu1.id = te.to_user_id WHERE te.status = '1' AND te.add_uid = '$uid_email'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td ><?php echo $i; ?></td>
                                              <td><?php echo $row["first_name"]." ".$row["last_name"]; ?></td>
                                              <td><?php echo $row["fname"]." ".$row["lname"]; ?></td>
                                              <td><?php echo $row["subject"]; ?></td>
                                              <td><?php echo $row["add_date"]; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a data-hideid="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#view-message"><i class="fa fa-search"></i> &nbsp;View Message</a></li>
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
                                <div class="modal fade" id="view-message">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Message</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <div id="message"></div>
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
                    { sWidth: '15%' },
                    { sWidth: '15%' },
                    { sWidth: '40%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' }]
                });
                $('#view-message').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('hideid');
                    var modal = $(this);
                    $.ajax({
                        url: "ajax/email.php",
                        type: "POST",
                        data: {id:id, cmd:"ViewMessage"},
                        dataType:"JSON",
                        success:function(data){
                            $("#message").html(data.msg);
                        }   
                    });
                });
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/email.php",
                          type: "POST",
                          data: {id:id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_email.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_email.php?status="+(data.status);
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