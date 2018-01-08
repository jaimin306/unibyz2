<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Column Added Successfully';
              break;
          case 'usuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Column Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Column Deleted Successfully';
              break;
          case 'upstatus':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Column Status Changed Successfully';
              break;
          case 'no_update':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'No Update';
              break;
              
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Column... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
      }
    }
      $uid_product = $_SESSION["user_id"];
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Edit PayrollTemplate</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Edit Payroll Template</h3>
                                </div>

                                <?php if (!empty($statusMsg)) {
                                echo '<div class="alert ' . $statusMsgClass . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $statusMsg . '</div>';
                                }
                                ?> 

                                <!-- start -->
                                <form method="POST" action="#" id="template_form" onsubmit="return submitForm();" class="form-horizontal">
                                <div class="box-body">
                                    <p>You can edit the template by changing the fields and adding or deleting rows.</p>
                                  <div class="row">
                                  <!-- left start -->
                                    <div class="col-md-6"> 
                                        <?php 
                                          $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_product' and direction='left'";
                                          $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                          $num_rows = mysqli_num_rows($res);
                                          if($num_rows > 0){                                            
                                            while($row = mysqli_fetch_assoc($res)){
                                        ?> 
                                        <div class="form-group">
                                          <div class="col-sm-10">
                                            <input class="form-control" name="<?php echo $row['id']; ?>" type="text" value="<?php echo $row['column_nm']; ?>" required>
                                          </div>
                                          <div class="col-sm-2">
                                            <a href="#" class="deleteMeta" div-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> </a>
                                          </div>
                                        </div>                                        
                                        <?php } } ?>
                                      <div class="form-group ">
                                          <button type="button" id="left" data-toggle="modal" data-target="#status"  class="btn btn-info margin">Add Row </button>
                                      </div>
                                    </div>
                                    <!-- Left end --> 
                                   <!-- right start -->
                                    <div class="col-md-6"> 
                                          <div class="form-group" id="">
                                              <div class="col-sm-10">
                                                  <label>Payroll Date</label>
                                              </div>
                                          </div>
                                        <?php 
                                          $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_product' and direction='right'";
                                          $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                          $num_rows = mysqli_num_rows($res);
                                          if($num_rows > 0){                                            
                                            while($row = mysqli_fetch_assoc($res)){
                                        ?> 
                                        <div class="form-group">
                                          <div class="col-sm-10">
                                            <input class="form-control" name="<?php echo $row['id']; ?>" type="text" value="<?php echo $row['column_nm']; ?>" required>
                                          </div>
                                          <div class="col-sm-2">
                                            <a href="#" class="deleteMeta" div-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> </a>
                                          </div>
                                        </div>                                        
                                        <?php } } ?>
                                      <div class="form-group ">
                                          <button type="button" id="right" data-toggle="modal" data-target="#status"  class="btn btn-info margin">Add Row </button>
                                      </div>
                                    </div>
                                    <!-- right end -->
                                  </div>

                                    <div class="row">
                                    <!-- Addition start -->
                                        <div class="col-md-6">
                                            <div class="box box-solid box-primary">
                                                <div class="box-header">
                                                    <h3 class="box-title">Additions</h3>
                                                </div>
                                                <div class="box-body">
                                                    <?php 
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_product' and direction='addition'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);
                                                      if($num_rows > 0){                                            
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <div class="form-group">
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="<?php echo $row['id']; ?>" type="text" value="<?php echo $row['column_nm']; ?>" required>
                                                        </div>
                                                        <div class="col-sm-2">
                                                          <a href="#" class="deleteMeta" div-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> </a>
                                                        </div>
                                                    </div> 
                                                    <?php } } ?>
                                                     <div class="form-group ">
                                                        <button type="button" id="addition" data-toggle="modal" data-target="#status"  class="btn btn-info margin">Add Row </button>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    <!-- addition end -->
                                    <!-- deduction start -->
                                     
                                        <div class="col-md-6">
                                            <div class="box box-solid box-danger">
                                                <div class="box-header">
                                                    <h3 class="box-title">Deductions</h3>
                                                </div>
                                                <div class="box-body">
                                                    <?php 
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_product' and direction='deduction'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);
                                                      if($num_rows > 0){                                            
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <div class="form-group">
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="<?php echo $row['id']; ?>" type="text" value="<?php echo $row['column_nm']; ?>" required>
                                                        </div>
                                                        <div class="col-sm-2">
                                                          <a href="#" class="deleteMeta" div-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> </a>
                                                        </div>
                                                    </div> 
                                                    <?php } } ?>
                                                     <div class="form-group ">
                                                        <button type="button" id="deduction" data-toggle="modal" data-target="#status"  class="btn btn-info margin">Add Row </button>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                  
                                    <!-- deduction end -->
                                      </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>

                                    </form>
                                 <!-- end -->

                                 <!-- start popup -->
                                  <div class="modal fade" id="status">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Add Row</h4>
                                      </div>
                                      <form method="post">
                                        <div class="modal-body">
                                          <p><b>Name</b></p>
                                          <input type="text" name="column_nm" id="column_nm" class="form-control"> 
                                          <input type="hidden" id="direction" class="form-control" name="direction" >
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary" id="up_status">Submit</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                 <!-- end popup -->
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
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
             
            function submitForm() {  
                var form_data = new FormData(document.getElementById("template_form"));
                form_data.append("cmd", "update"); 
                $.ajax({
                    url: "ajax/payroll_template.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="payroll_template.php?status="+(data.status);
                        }
                        else{
                            window.location.href="payroll_template.php?status="+(data.status);
                        }
                    }   
                }); 
                return false;
            }
             
        </script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('.deleteMeta').on('click', function (e) {
                e.preventDefault();                 
                var div_id = $(this).attr('div-id');
                var conf=confirm("Are you sure to delete?");
                if(conf){
                  if(div_id != ""){
                      $.ajax({
                          url: "ajax/payroll_template.php",
                          type: "POST",
                          data: {div_id:div_id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="payroll_template.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="payroll_template.php?status="+(data.status);
                              }
                          }   
                      });
                  } 
                }                
            });
            $( ".margin").on( "click", function() {
                $('#direction').val(this.id);
            });
            $( "#up_status").on( "click", function() {
                  var direction = $("#direction").val(); 
                  var column_nm = $("#column_nm").val(); 
                  if(direction != "" && column_nm != ""){
                    $.ajax({
                        url: "ajax/payroll_template.php",
                        type: "POST",
                        data: {direction:direction, cmd:"insert",column_nm:column_nm},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="payroll_template.php?status="+(data.status);
                            }
                            else{
                                window.location.href="payroll_template.php?status="+(data.status);
                            }
                        }   
                    });
                  }
                  else{
                    alert("Please Enter Status");
                  }
            });
        });
       
    </script>

    </body>
</html>