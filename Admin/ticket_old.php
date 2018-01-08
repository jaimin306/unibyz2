<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_ticket WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
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
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Ticket</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Ticket</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="ticket_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="reporter_id" class="control-label col-md-2">Reporter <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="reporter_id" id="reporter_id" required="">
                                                  <option value="">Please Select Reporter</option>
                                                  <?php 
                                                      $query_reporter = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_ticket' AND user_type = '2'";
                                                      $res_reporter = mysqli_query($mysqli,$query_reporter) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      while($row_reporter = mysqli_fetch_assoc($res_reporter)){
                                                        ?>
                                                          <option value="<?php echo $row_reporter['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_reporter['id'] == $row["reporter_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_reporter['first_name']." ".$row_reporter["last_name"]; ?></option>
                                                         <?php
                                                      } 
                                                  ?>
                                              </select>
                                            </div>
                                            <label for="subject" class="control-label col-md-2">Subject <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo (isset($id) ? $row['subject'] : ''); ?>" required="required" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority" class="control-label col-md-2">Priority <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="priority" id="priority" required="required">
                                                  <option value="">Please Select Priority</option>
                                                  <option value="Low" <?php if(isset($id) && $id != ""){ echo (($row["priority"] == "Low") ?  "selected='selected'" : "");} ?>>Low</option>
                                                  <option value="Medium" <?php if(isset($id) && $id != ""){ echo (($row["priority"] == "Medium") ?  "selected='selected'" : "");} ?>>Medium</option>
                                                  <option value="High" <?php if(isset($id) && $id != ""){ echo (($row["priority"] == "High") ?  "selected='selected'" : "");} ?>>High</option>
                                              </select>
                                            </div>
                                            <label for="department_id" class="control-label col-md-2">Department <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="department_id" id="department_id" required="">
                                                    <option value="">Please Select Department</option>
                                                    <?php 
                                                        $query_dept = "SELECT id,department_name FROM tbl_department WHERE status = '1' AND add_uid = '$uid_ticket'";
                                                        $res_dept = mysqli_query($mysqli,$query_dept) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                        while($row_dept = mysqli_fetch_assoc($res_dept)){
                                                          ?>
                                                            <option value="<?php echo $row_dept['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_dept['id'] == $row["department_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_dept['department_name']; ?></option>
                                                           <?php
                                                        } 
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo_path" class="control-label col-md-2">Attachment </label>
                                            <div class="col-md-4">
                                              <input type="file" name="photo_path" id="photo_path" class="form-control" accept="image/*">
                                              <input type="hidden" name="hidden_photo_path" value="<?php echo (isset($id) ? $row['photo_path'] : ''); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket_message" class="control-label col-md-2">Ticket Message <span class="text-danger">*</span></label>
                                            <div class="col-md-10">
                                              <textarea class="textarea" name="ticket_message" placeholder="Enter Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (isset($id) ? $row['ticket_message'] : ''); ?></textarea>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if(isset($id) && $id != "" ){
                                          echo '<button type="submit" class="btn btn-primary">Update</button>';
                                        }
                                        else{
                                          echo '<button type="submit" class="btn btn-primary">Save</button>';
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
            $('#reporter_id').select2();
          });
          function submitForm() {    
              var formid = $("#hidden_id").val();        
              if(formid != "" && formid != "0"){
                var form_data = new FormData(document.getElementById("ticket_form"));
                form_data.append("cmd", "update");
                form_data.append("id", formid);
                $.ajax({
                    url: "ajax/ticket.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_ticket.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_ticket.php?status="+(data.status);
                        }
                    }   
                });
                return false; 
              }
              else{
                var form_data = new FormData(document.getElementById("ticket_form"));
                form_data.append("cmd", "insert");
                $.ajax({
                    url: "ajax/ticket.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_ticket.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_ticket.php?status="+(data.status);
                        }
                    }   
                });
                return false;       
              }
          }
        </script>
    </body>
</html>