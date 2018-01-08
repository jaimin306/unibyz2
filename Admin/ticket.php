<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_ticket WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_ticket = $_SESSION["user_id"];
    // $select_cust = "SELECT first_name,last_name FROM tbl_user WHERE id = '".$row["customer_id"]."'";
    // $res_cust = mysqli_query($mysqli,$select_cust) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    // $row_cust = mysqli_fetch_assoc($res_cust);
    // $customer_name = $row_cust['first_name']." ".$row_cust["last_name"];
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
                        <li class="active">Incident</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Incident</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="ticket_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="project_id" class="control-label col-md-2">Project Name </label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="project_id" id="project_id" >
                                                <option value="">Please Select Project</option>
                                                <?php 
                                                    $query_project = "SELECT id,project_name FROM tbl_project WHERE status = '1' AND add_uid = '$uid_ticket'";
                                                    $res_project = mysqli_query($mysqli,$query_project) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_project = mysqli_fetch_assoc($res_project)){
                                                        ?>
                                                        <option value="<?php echo $row_project['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_project['id'] == $row["project_id"]) ? "selected='selected'" : "";} ?>><?php echo ("PJ".Series1000($row_project['id'])." - ".$row_project["project_name"]); ?>
                                                        </option>
                                                    <?php
                                                } 
                                                ?>
                                              </select>
                                            </div>
                                            <label for="ticket_department_id" class="control-label col-md-2">Department </label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="ticket_department_id" id="ticket_department_id" >
                                                    <option value="">Please Select Department</option>
                                                    <?php 
                                                        $query_department = "SELECT id,department_name FROM tbl_ticket_department WHERE status = '1' AND add_uid = '$uid_ticket'";
                                                        $res_department = mysqli_query($mysqli,$query_department) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                        while($row_department = mysqli_fetch_assoc($res_department)){
                                                            ?>
                                                            <option value="<?php echo $row_department['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_department['id'] == $row["ticket_department_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_department["department_name"]; ?>
                                                            </option>
                                                        <?php
                                                        } 
                                                    ?>
                                                  </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket_type_id" class="control-label col-md-2">Type </label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="ticket_type_id" id="ticket_type_id" >
                                                    <option value="">Please Select Type</option>
                                                    <?php 
                                                        $query_type = "SELECT id,type_name FROM tbl_ticket_type WHERE status = '1' AND add_uid = '$uid_ticket'";
                                                        $res_type = mysqli_query($mysqli,$query_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                        while($row_type = mysqli_fetch_assoc($res_type)){
                                                            ?>
                                                            <option value="<?php echo $row_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_type['id'] == $row["ticket_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_type["type_name"]; ?>
                                                            </option>
                                                        <?php
                                                        } 
                                                    ?>
                                                  </select>
                                            </div>
                                            <label for="ticket_status_id" class="control-label col-md-2">Status </label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="ticket_status_id" id="ticket_status_id" >
                                                    <option value="">Please Select Status</option>
                                                    <?php 
                                                        $query_status = "SELECT id,status_name FROM tbl_ticket_status WHERE status = '1' AND add_uid = '$uid_ticket'";
                                                        $res_status = mysqli_query($mysqli,$query_status) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                        while($row_status = mysqli_fetch_assoc($res_status)){
                                                            ?>
                                                            <option value="<?php echo $row_status['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_status['id'] == $row["ticket_status_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_status["status_name"]; ?>
                                                            </option>
                                                        <?php
                                                        } 
                                                    ?>
                                                  </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject" class="control-label col-md-2">Subject </label>
                                            <div class="col-md-4">
                                                <input type="text" value="<?php echo (isset($id) ? $row['subject'] : ''); ?>" class="form-control" name="subject" id="subject" >
                                            </div>
                                            <label for="notify_to" class="control-label col-md-2">Notify To </label>
                                            <div class="col-md-4">
                                                <select name="notify_to" id="notify_to" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <option value="2" <?php echo ($row["notify_to"] == "2" ? 'selected' : '') ?>>Customer</option>
                                                    <option value="3" <?php echo ($row["notify_to"] == "3" ? 'selected' : '') ?>>Project Manager</option>
                                                    <option value="4" <?php echo ($row["notify_to"] == "4" ? 'selected' : '') ?>>Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="attachment" class="control-label col-md-2">Attachment </label>
                                            <div class="col-md-4">
                                                <input type="file" class="form-control"  id="attachment" name="attachment" >
                                                <input type="hidden" name="hidden_attachment" value="<?php echo (isset($id) ? $row['attachment'] : ''); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket_message" class="control-label col-md-2">Message </label>
                                            <div class="col-md-10">
                                                <textarea class="textarea" name="ticket_message" id="ticket_message" placeholder="Enter Incident Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['ticket_message'] : ''); ?></textarea>
                                                <span class="text-danger" style="display: none" id="ErrorMessage">Please Enter Incident Message</span>
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
            $('.textarea').wysihtml5();
            $('#project_id').select2();
            $('#ticket_department_id').select2();
            $('#ticket_type_id').select2();
            $('#ticket_status_id').select2();
            $('#notify_to').select2();
          });
          function submitForm() {    
              var formid = $("#hidden_id").val();        
              var tm = $("#ticket_message").val();
              if(tm != ""){        
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
              else{
                $("#ErrorMessage").show();
                return false;
              }
          }
        </script>
    </body>
</html>