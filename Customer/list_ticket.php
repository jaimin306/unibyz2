<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
        case 'success':
          $statusMsgClass = 'alert-success';
          $statusMsg      = 'Incident Added Successfully';
          break;
        case 'usuccess':
          $statusMsgClass = 'alert-success';
          $statusMsg      = 'Incident Updated Successfully';
          break;
        case 'upsuccess':
          $statusMsgClass = 'alert-success';
          $statusMsg      = 'Incident Status Changed Successfully';
          break;
        case 'dsuccess':
          $statusMsgClass = 'alert-success';
          $statusMsg      = 'Incident Deleted Successfully';
          break;
        case 'error':
          $statusMsgClass = 'alert-danger';
          $statusMsg      = 'Error In Incident... Please Try Again';
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
                        <li class="active">Incident</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Incidents</h3>
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
                                      <th >Status</th>
                                      <th >Type</th>
                                      <th >Department</th>
                                      <th >Subject</th>
                                      <th >Notify To</th>
                                      <th >Created Date</th>
                                      <th >Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT tt.*,tp.project_name,ttd.department_name,ttt.type_name,tts.status_name FROM tbl_ticket tt LEFT JOIN tbl_project tp ON tp.id = tt.project_id LEFT JOIN tbl_ticket_department ttd ON ttd.id = tt.ticket_department_id LEFT JOIN tbl_ticket_status tts ON tts.id = tt.ticket_status_id LEFT JOIN tbl_ticket_type ttt ON ttt.id = tt.ticket_type_id WHERE tt.status = '1' AND tt.add_uid IN ((select add_uid from tbl_user where id = '$uid_ticket'),$uid_ticket) AND tt.notify_to IN (1,3,4)";
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
                                                  if($row["notify_to"] == '0'){
                                                    echo '<span class="label label-danger">SuperAdmin</span>';
                                                  }
                                                  if($row["notify_to"] == '1'){
                                                    echo '<span class="label label-success">Admin</span>';
                                                  }
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
                                              <td><?php echo date("Y-m-d h:i A",strtotime($row["add_date"])); ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#ticket"><i class="fa fa-search" ></i> &nbsp;Details</a></li>
                                                      <li><a href="ticket.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
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
                                <div class="modal fade" id="ticket" data-backdrop="static" data-keyboard="false">
                                  <div class="modal-dialog jackInTheBox animated">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"></h4>

                                      </div>
                                      <div class="modal-body" >
                                        <div id="Message"></div><br>
                                        <div id="imageAttach"></div>
                                        
                                      </div>

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
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
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '15%' },
                    { sWidth: '22%' },
                    { sWidth: '10%' },
                    { sWidth: '13%' },
                    { sWidth: '10%' }]
                });
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/ticket.php",
                          type: "POST",
                          data: {id:id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_ticket.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_ticket.php?status="+(data.status);
                              }
                          }   
                      });
                      } 
                  });
                  $('#ticket').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('hideid');
                    var modal = $(this);
                    $.ajax({
                        url: "ajax/ticket.php",
                        type: "POST",
                        data: {id:id, cmd:"GetMessage"},
                        dataType:"JSON",
                        success:function(data){
                            $(".modal-title").html(data.subject);
                            $("#Message").html(data.message);
                            if(data.attachment != ""){
                              $("#imageAttach").html('<a class="pull-left" href="../uploads/ticket/'+data.attachment+'" download><i class="fa fa-upload"></i> &nbsp;&nbsp;Attachment</a>');
                            }
                        }   
                    });
                  });
              });
              function confirmDelete() {
                return confirm("Are you sure to delete selected files?");
              }
        </script>
    </body>
</html>