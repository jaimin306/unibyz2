<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_work_order WHERE id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $send_sms = isset($id) ? $row["send_sms"] : '';
    $send_email = isset($id) ? $row["send_email"] : '';
    $uid_wo = $_SESSION["user_id"];
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
                        <li class="active">Work Order</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Work Order</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="work_order_form" class="form-horizontal" action="#" onsubmit="return submitForm();">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="project_id" class="control-label col-md-2">Select Project No.</label>
                                          <div class="col-md-4">
                                            <select class="form-control" id="project_id" name="project_id" onchange="GetProjectCustomer(this.value)">
                                              <option value="">Please Select Project No.</option>
                                              <?php
                                                // $query_estimate = "SELECT id FROM tbl_estimate WHERE status = '1' AND add_uid = '$uid_wo' AND generate_work_order_status = '1'";
                                                if(isset($id) && $id != ""){
                                                  $query_project = "SELECT tp.id,tp.project_name FROM tbl_project tp WHERE tp.status = '1' AND tp.add_uid = '$uid_wo'";
                                                  $res_project = mysqli_query($mysqli,$query_project) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_project = mysqli_fetch_assoc($res_project)){
                                                    ?>
                                                      <option value="<?php echo $row_project['id']; ?>" <?php echo ($row_project["id"] == $row["project_id"] ? 'selected' : ''); ?>><?php echo ("PJ".Series1000($row_project['id'])." - ".$row_project["project_name"]); ?></option>
                                                    <?php
                                                  }
                                                }
                                                else{
                                                  $query_project = "SELECT tp.id,tp.project_name FROM tbl_project tp WHERE tp.status = '1' AND tp.add_uid = '$uid_wo' AND tp.id NOT IN (SELECT project_id from tbl_work_order)";
                                                  $res_project = mysqli_query($mysqli,$query_project) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_project = mysqli_fetch_assoc($res_project)){
                                                    ?>
                                                      <option value="<?php echo $row_project['id']; ?>"><?php echo ("PJ".Series1000($row_project['id'])." - ".$row_project["project_name"]); ?></option>
                                                    <?php
                                                  }
                                                }
                                              ?>
                                            </select>
                                          </div>
                                          <label for="customer_id" class="control-label col-md-2">Customer</label>
                                          <div class="col-md-4">
                                          <!-- IF edit Perform -->
                                          <?php
                                            if(isset($id) && $id != ""){
                                              $sc = "SELECT id,first_name,last_name FROM tbl_user WHERE id = '".$row["customer_id"]."'";
                                              $qc = mysqli_query($mysqli,$sc) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                              $rc = mysqli_fetch_assoc($qc);
                                              $name = $rc["first_name"]." ".$rc["last_name"];
                                              echo '<input type="text" class="form-control" value="'.$name.'" name="customer_id" id="customer_id" readonly="readonly">';    
                                              echo '<input type="hidden" id="customer_id_val" value="'.$rc["id"].'" name="customer_id_val">';
                                            }
                                            else{
                                              echo '<input type="text" class="form-control" name="customer_id" id="customer_id" readonly="readonly">';    
                                              echo '<input type="hidden" id="customer_id_val" name="customer_id_val">';
                                            }
                                          ?>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="category_type" class="col-md-2 control-label">Category</label>
                                          <div class="col-md-4">
                                            <select name="category_type" id="category_type" onchange="GetCategory(this.value)"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Category </option>
                                              <option value="Product" <?php if($row["category_type"] == "Product"){ echo 'selected';} ?>>Product</option>
                                              <option value="Service" <?php if($row["category_type"] == "Service"){ echo 'selected';} ?>>Service</option>
                                            </select>
                                            <div id="hide_spin" style="display: none" ><i class="fa fa-refresh fa-spin"></i></div>
                                          </div>
                                          <label for="category_id" class="col-md-2 control-label">Type </label>
                                            <div class="col-md-4">
                                              <select name="category_id" id="category_id"   class="form-control" style="width: 100%;">
                                                <option value="">Please Select Type</option>
                                                <?php
                                                  if(isset($id) && $id != "0"){
                                                    if($row["category_type"] == "Product"){
                                                      $query_category = "SELECT id,category_name FROM tbl_category WHERE status = '1' AND add_uid = '$uid_wo'";
                                                    }
                                                    else{
                                                      $query_category = "SELECT id,category_name FROM tbl_service_category WHERE status = '1' AND add_uid = '$uid_wo'";
                                                    }
                                                    $res_category = mysqli_query($mysqli,$query_category) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_category = mysqli_fetch_assoc($res_category)){
                                                      ?>
                                                        <option value="<?php echo $row_category['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_category['id'] == $row["category_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_category['category_name']; ?></option>
                                                      <?php
                                                    }
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="work_order_name" class="col-md-2 control-label">Name  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="work_order_name" value="<?php echo (isset($id) ? $row['work_order_name'] : ''); ?>" name="work_order_name" placeholder="Enter Name Here">
                                          </div>
                                          <label for="employee_name" class="col-md-2 control-label">Employee Name</label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="employee_name" value="<?php echo (isset($id) ? $row['employee_name'] : ''); ?>" name="employee_name" placeholder="Enter Employee Name Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="start_date" class="col-md-2 control-label">Start Date </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Enter Start Date Here"  value="<?php echo (isset($id) ? $row['start_date'] : ''); ?>" >
                                          </div>
                                          <label for="expected_fix_date" class="col-md-2 control-label">End Date  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="expected_fix_date" name="expected_fix_date" placeholder="Enter End Date Here"  value="<?php echo (isset($id) ? $row['expected_fix_date'] : ''); ?>" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="send_sms" class="col-md-2 control-label">Status </label>
                                          <div class="col-md-4">
                                            <select name="send_sms" id="send_sms" class="form-control"  >
                                              <option value="">Please Select </option>
                                              <option value="Yes" <?php echo ($send_sms == "Yes" ? "selected='selected'" : ''); ?>>Yes</option>
                                              <option value="No" <?php echo ($send_sms == "No" ? "selected='selected'" : ''); ?>>No</option>
                                            </select>
                                          </div>
                                          <label for="send_email" class="col-md-2 control-label">Send Email Automatically On Status Change?  </label>
                                          <div class="col-md-4">
                                            <select name="send_email" id="send_email" class="form-control" >
                                              <option value="">Please Select </option>
                                              <option value="Yes" <?php echo ($send_email == "Yes" ? "selected='selected'" : ''); ?>>Yes</option>
                                              <option value="No" <?php echo ($send_email == "No" ? "selected='selected'" : ''); ?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="resource_id" class="col-md-2 control-label">Add Resources  </label>
                                          <div class="col-md-4">
                                            <select name="resource_id" id="resource_id"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Resources</option>
                                              <?php
                                                $sel_resource = "SELECT * FROM tbl_user WHERE status = '1' AND user_type IN (3,4) AND add_uid = '$uid_wo'";
                                                $res_resource = mysqli_query($mysqli,$sel_resource) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_resource = mysqli_fetch_assoc($res_resource)){
                                                  ?>
                                                    <option value="<?php echo $row_resource['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_resource['id'] == $row["resource_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_resource['first_name']." ".$row_resource['last_name']; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                          </div>
                                        <!--
                                        <div class="form-group">
                                          <label for="order_status" class="col-md-2 control-label">Add Resources  </label>
                                          <div class="col-md-4">
                                            <select name="order_status" id="order_status"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Resources</option>
                                              <option value="0" <?php /*if(isset($id) && $id != ""){ echo ($row['order_status'] == "0") ? "selected='selected'" : "";} ?>>Pending</option>
                                              <option value="1" <?php if(isset($id) && $id != ""){ echo ($row['order_status'] == "1") ? "selected='selected'" : "";} ?>>Accept</option>
                                              <option value="2" <?php if(isset($id) && $id != ""){ echo ($row['order_status'] == "2") ? "selected='selected'" : "";} */?>>Reject</option>
                                            </select>
                                          </div>
                                          -->
                                          <label for="photo_path" class="col-md-2 control-label">Image </label>
                                          <div class="col-md-4">
                                            <input type="file" class="form-control"  id="photo_path" name="photo_path" >
                                            <input type="hidden" name="hidden_photo_path" value="<?php echo (isset($id) ? $row['photo_path'] : ''); ?>">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="comments" class="col-md-2 control-label">Comments </label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="comments"  placeholder="Enter Comments Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['comments'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="notes" class="col-md-2 control-label">Notes</label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
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
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script> 
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
              $('.textarea').wysihtml5();
              $('#category_id').select2();
              $('#category_type').select2();
              $('#project_id').select2();
              $('#expected_fix_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
              });
              $('#start_date').datepicker({
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
                  var form_data = new FormData(document.getElementById("work_order_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/work_order.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_work_order.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_work_order.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("work_order_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/work_order.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_work_order.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_work_order.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function GetProjectCustomer(eid){              
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/work_order.php",
                  type: "POST",
                  data: {eid:eid,cmd:"GetProjectCustomer"},
                  dataType:"JSON",
                  success:function(data){
                      $("#customer_id_val").val(data.customer_id);
                      $("#customer_id").val(data.customer_name);
                      $("#hide_spin").hide();
                  }   
              });
            }
            function GetCategory(tid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/work_order.php",
                  type: "POST",
                  data: {tid:tid,cmd:"GetCategory"},
                  dataType:"JSON",
                  success:function(data){
                      $("#category_id").html(data.string);
                      $("#hide_spin").hide();
                  }   
              }); 
            }
        </script>
    </body>
</html>