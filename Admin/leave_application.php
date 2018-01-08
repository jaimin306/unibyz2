<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    /*$query = "SELECT * FROM tbl_holiday WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);*/
    $uid_leave_application = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
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
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Application</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Application</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="leave_application_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="employee_id" class="control-label col-md-2">Employee <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <select name="employee_id" id="employee_id" required="required" class="form-control" style="width: 100%;">
                                                  <option value="">Please Select Employee</option>
                                                  <?php
                                                    $query_employee = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_leave_application' AND user_type IN (3,4)";
                                                    $res_employee = mysqli_query($mysqli,$query_employee) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_employee = mysqli_fetch_assoc($res_employee)){
                                                      ?>
                                                        <option value="<?php echo $row_employee['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_employee['id'] == $row["employee_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_employee['first_name']." ".$row_employee["last_name"]; ?></option>
                                                      <?php
                                                    }
                                                  ?>
                                                </select>
                                            </div>
                                            <label for="apply_date" class="control-label col-md-2">Apply Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="apply_date" value="<?php echo (isset($id) ? $row["apply_date"] : ''); ?>" id="apply_date" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="app_start_date" class="control-label col-md-2">Application Start Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="app_start_date" value="<?php echo (isset($id) ? $row["app_start_date"] : ''); ?>" id="app_start_date" class="form-control" required="required">
                                            </div>
                                            <label for="app_end_date" class="control-label col-md-2">Application End Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="app_end_date" value="<?php echo (isset($id) ? $row["app_end_date"] : ''); ?>" id="app_end_date" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="approve_start_date" class="control-label col-md-2">Approve Start Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="approve_start_date" value="<?php echo (isset($id) ? $row["approve_start_date"] : ''); ?>" id="approve_start_date" class="form-control" required="required">
                                            </div>
                                            <label for="approve_end_date" class="control-label col-md-2">Approve End Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="approve_end_date" value="<?php echo (isset($id) ? $row["approve_end_date"] : ''); ?>" id="approve_end_date" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="approved_day" class="control-label col-md-2">Approved Day <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="approved_day" value="<?php echo (isset($id) ? $row["approved_day"] : ''); ?>" id="approved_day" class="form-control" required="required">
                                            </div>
                                            <label for="reason" class="control-label col-md-2">Reason <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="reason" value="<?php echo (isset($id) ? $row["reason"] : ''); ?>" id="reason" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            
                                            <label for="leave_type_id" class="control-label col-md-2">Leave Type <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <select name="leave_type_id" id="leave_type_id" required="required" class="form-control" style="width: 100%;">
                                                  <option value="">Please Select Leave Type</option>
                                                  <?php
                                                    $query_leave_type = "SELECT id,leave_type FROM tbl_leave_type WHERE status = '1' AND add_uid = '$uid_leave_application'";
                                                    $res_leave_type = mysqli_query($mysqli,$query_leave_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_leave_type = mysqli_fetch_assoc($res_leave_type)){
                                                      ?>
                                                        <option value="<?php echo $row_leave_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_leave_type['id'] == $row["leave_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_leave_type['leave_type']; ?></option>
                                                      <?php
                                                    }
                                                  ?>
                                                </select>
                                            </div>
                                            <label for="approved_date" class="control-label col-md-2">Approved Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="approved_date" value="<?php echo (isset($id) ? $row["approved_date"] : ''); ?>" id="approved_date" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hard_copy" class="control-label col-md-2">Application Hard Copy</label>
                                            <div class="col-md-4">
                                                <input type="file" name="hard_copy" id="hard_copy" class="form-control">
                                                <input type="hidden" name="hard_copy_val" value="<?php echo (isset($id) ? $row["hard_copy"] : ''); ?>" >
                                            </div>
                                        </div>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if(isset($id) && $id != "" ){
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Update</button>';
                                        }
                                        else{
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Save</button>';
                                        }
                                        ?>
                                      </div>
                                    </form>
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
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
          $(function(){
            $("#employee_id").select2();
            ////////////////
            $('#app_start_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var minDate = new Date(selected.date.valueOf());
              $('#app_end_date').datepicker('setStartDate', minDate);
            });
            $('#app_end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var maxDate = new Date(selected.date.valueOf());
              $('#app_start_date').datepicker('setEndDate', maxDate);
            });    
            
            /////////////
            $('#approve_start_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var minDate = new Date(selected.date.valueOf());
              $('#approve_end_date').datepicker('setStartDate', minDate);
            });
            $('#approve_end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var maxDate = new Date(selected.date.valueOf());
              $('#approve_start_date').datepicker('setEndDate', maxDate);
            });

            ///////////
            $('#approved_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            });    
          });
          function submitForm() {    
              var formid = $("#hidden_id").val();        
              if(formid != "" && formid != "0"){
                var form_data = new FormData(document.getElementById("leave_application_form"));
                form_data.append("cmd", "update");
                form_data.append("id", formid);
                $.ajax({
                    url: "ajax/holiday.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_leave_application.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_leave_application.php?status="+(data.status);
                        }
                    }   
                });
                return false; 
              }
              else{
                var form_data = new FormData(document.getElementById("leave_application_form"));
                form_data.append("cmd", "insert");
                $.ajax({
                    url: "ajax/holiday.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_leave_application.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_leave_application.php?status="+(data.status);
                        }
                    }   
                });
                return false;       
              }
          }
          
        </script>
    </body>
</html>