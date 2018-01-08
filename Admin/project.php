<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);    
    $query = "SELECT * FROM tbl_project WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_project = $_SESSION["user_id"];
    $select_cust = "SELECT first_name,last_name FROM tbl_user WHERE id = '".$row["customer_id"]."'";
    $res_cust = mysqli_query($mysqli,$select_cust) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row_cust = mysqli_fetch_assoc($res_cust);
    $customer_name = $row_cust['first_name']." ".$row_cust["last_name"];
 
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
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Project</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php if(isset($id) && $id != ""){ echo 'Edit Project'; } else{ echo 'Add Project';} ?></h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="project_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="estimate_id" class="control-label col-md-2">Estimate </label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="estimate_id" id="estimate_id" onchange="GetCustomer(this.value)" >
                                                  <option value="">Please Select Estimate</option>
                                                  <?php 
                                                      if(isset($id) && $id != "0"){
                                                        $query_est = "SELECT id FROM tbl_estimate WHERE status = '1' AND add_uid = '$uid_project' AND estimate_status = '1'";
                                                      }
                                                      else{                                                         
                                                        $query_est = "SELECT id FROM tbl_estimate WHERE status = '1' AND add_uid = '$uid_project' AND estimate_status = '1' AND id NOT IN (select estimate_id from tbl_project )";
                                                      }
                                                      
                                                      $res_est = mysqli_query($mysqli,$query_est) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      while($row_est = mysqli_fetch_assoc($res_est)){
                                                        ?>
                                                          <option value="<?php echo $row_est['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_est['id'] == $row["estimate_id"]) ? "selected='selected'" : "";} ?>><?php echo "ES".Series1000($row_est['id']); ?></option>
                                                         <?php
                                                        } 
                                                  ?>
                                              </select>
                                              <div id="hide_spin" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
                                            </div>
                                            <label for="subject" class="control-label col-md-2">Customer </label>
                                            <div class="col-md-4">
                                                <input type="text" name="customer_id_val" value="<?php echo (isset($id) ? $customer_name : ''); ?>" id="customer_id_val" class="form-control"  readonly>
                                                <input type="hidden" class="form-control" value="<?php echo (isset($id) ? $row['customer_id'] : ''); ?>" id="customer_id" name="customer_id" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_manager_id" class="control-label col-md-2">Project Manager </label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="project_manager_id" id="project_manager_id" >
                                                    <option value="">Please Select Project Manager</option>
                                                    <?php 
                                                        $query_pm = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_project' AND user_type = '3'";
                                                        $res_pm = mysqli_query($mysqli,$query_pm) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                        while($row_pm = mysqli_fetch_assoc($res_pm)){
                                                          ?>
                                                            <option value="<?php echo $row_pm['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_pm['id'] == $row["project_manager_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_pm['first_name']." ".$row_pm["last_name"]; ?></option>
                                                           <?php
                                                        } 
                                                    ?>
                                                </select>
                                            </div>
                                            <label for="project_name" class="control-label col-md-2">Project Name </label>
                                            <div class="col-md-4">
                                              <input type="text" name="project_name" id="project_name" value="<?php echo (isset($id) ? $row['project_name'] : ''); ?>" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date" class="control-label col-md-2">Start Date </label>
                                            <div class="col-md-4">
                                                <input type="text" value="<?php echo (isset($id) ? $row['start_date'] : ''); ?>" class="form-control readonly" name="start_date" id="start_date" >
                                            </div>
                                            <label for="end_date" class="control-label col-md-2">End Date </label>
                                            <div class="col-md-4">
                                                <input type="text" value="<?php echo (isset($id) ? $row['end_date'] : ''); ?>" class="form-control readonly" name="end_date" id="end_date" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_description" class="control-label col-md-2">Project Description </label>
                                            <div class="col-md-10">
                                                <textarea class="textarea" name="project_description" placeholder="Enter Project Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['project_description'] : ''); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes" class="control-label col-md-2">Notes </label>
                                            <div class="col-md-10">
                                                <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if(isset($id) && $id != "" ){
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Update Project</button>';
                                        }
                                        else{
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Generate Project</button>';
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
            $('.textarea').wysihtml5();
            $('#estimate_id').select2();
            $('#project_manager_id').select2();
            $('#start_date').datepicker({
                autoclose: true,
                startDate: new Date(),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var minDate = new Date(selected.date.valueOf());
              $('#end_date').datepicker('setStartDate', minDate);
            });
            $('#end_date').datepicker({
                autoclose: true,
                startDate: new Date(),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var maxDate = new Date(selected.date.valueOf());
              $('#start_date').datepicker('setEndDate', maxDate);
            });           
          });
          function submitForm() {    
              var formid = $("#hidden_id").val();        
              if(formid != "" && formid != "0"){
                var form_data = new FormData(document.getElementById("project_form"));
                form_data.append("cmd", "update");
                form_data.append("id", formid);
                $.ajax({
                    url: "ajax/project.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_project.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_project.php?status="+(data.status);
                        }
                    }   
                });
                return false; 
              }
              else{
                var form_data = new FormData(document.getElementById("project_form"));
                form_data.append("cmd", "insert");
                $.ajax({
                    url: "ajax/project.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_project.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_project.php?status="+(data.status);
                        }
                    }   
                });
                return false;       
              }
          }
          function GetCustomer(estid){
            $("#hide_spin").show();
            $.ajax({
                url: "ajax/project.php",
                type: "POST",
                data: {id:estid,cmd:"GetCustomer"},
                dataType:"JSON",
                success:function(data){
                    $("#customer_id").val(data.customer_id);
                    $("#customer_id_val").val(data.customer_id_val);
                    $("#hide_spin").hide();
                }   
            });
          }
        </script>
    </body>
</html>