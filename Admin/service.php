<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_service WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_service = $_SESSION["user_id"];
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
                        <li class="active">Service</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Service</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="service_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="category_id" class="control-label col-md-2">Category </label>
                                          <div class="col-md-4">
                                            <select name="category_id" id="category_id" onchange="GetServiceType(this.value)" class="form-control" style="width: 100%;">
                                              <option value="">Please Select Category</option>
                                              <?php
                                                $query_category = "SELECT id,category_name FROM tbl_service_category WHERE status = '1' AND add_uid = '$uid_service'";
                                                $res_category = mysqli_query($mysqli,$query_category) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_category = mysqli_fetch_assoc($res_category)){
                                                  ?>
                                                    <option value="<?php echo $row_category['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_category['id'] == $row["category_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_category['category_name']; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                            <div id="hide_spin" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
                                          </div>
                                          <label for="service_type_id" class="control-label col-md-2">Service Type </label>
                                          <div class="col-md-4">
                                            <select name="service_type_id" id="service_type_id"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Service Type</option>
                                              <?php
                                                if(isset($id) && $id != ""){
                                                  $cid = $row["category_id"];
                                                  $query_service_type = "SELECT id,service_type_name FROM tbl_service_type WHERE status = '1' AND add_uid = '$uid_service' AND category_id = '$cid' ";
                                                  $res_service_type = mysqli_query($mysqli,$query_service_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_service_type = mysqli_fetch_assoc($res_service_type)){
                                                    ?>
                                                      <option value="<?php echo $row_service_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_service_type['id'] == $row["service_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_service_type['service_type_name']; ?></option>
                                                    <?php
                                                  }  
                                                }
                                                
                                              ?>
                                            </select>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="service_name" class="control-label col-md-2">Service Name </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="service_name" value="<?php echo (isset($id) ? $row['service_name'] : ''); ?>" name="service_name" placeholder="Enter Service Name Here" >
                                          </div>
                                          <label for="code" class="control-label col-md-2">Service Code</label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="code" value="<?php echo (isset($id) ? $row['code'] : ''); ?>" name="code" placeholder="Enter Service Code Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">                                          
                                          <label for="hourly_rate" class="control-label col-md-2">Hourly Rate </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control number" id="hourly_rate" value="<?php echo (isset($id) ? $row['hourly_rate'] : ''); ?>" name="hourly_rate" placeholder="Enter Hourly Rate Here"  >
                                          </div>
                                          <label for="daily_rate" class="control-label col-md-2">Daily Rate </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control number" id="daily_rate" value="<?php echo (isset($id) ? $row['daily_rate'] : ''); ?>" name="daily_rate" placeholder="Enter Daily Rate Here"  >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="service_level" class="control-label col-md-2">Service Level </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="service_level" value="<?php echo (isset($id) ? $row['service_level'] : ''); ?>" name="service_level" placeholder="Enter Service Level Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="description" class="col-md-2 control-label">Description </label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="description" id="description" placeholder="Enter Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (isset($id) ? $row['description'] : ''); ?></textarea>
                                            <span class="text-danger errorMessage" style="display:none" >Please Enter Description</span>
                                          </div>
                                        </div>
                                        <div class="form-group">

                                          <label for="notes" class="control-label col-md-2">Notes</label>
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
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function () {
              $('.textarea').wysihtml5();
              $('#category_id').select2();
              $('#service_type_id').select2();
              DecimalOnly();
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                var desc = $("#description").val();
                if(formid != "" && formid != "0"){
                  if(desc != ""){
                    var form_data = new FormData(document.getElementById("service_form"));
                    form_data.append("cmd", "update");
                    form_data.append("id", formid);
                    $.ajax({
                        url: "ajax/service.php",
                        type: "POST",
                        data: form_data,
                        dataType:"JSON",
                        processData: false,
                        contentType: false,
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_service.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_service.php?status="+(data.status);
                            }
                        }   
                    });
                    return false;
                  }
                  else{
                    $(".errorMessage").show();
                    return false;
                  }
                }
                else{
                  if(desc != ""){
                    var form_data = new FormData(document.getElementById("service_form"));
                    form_data.append("cmd", "insert");
                    $.ajax({
                        url: "ajax/service.php",
                        type: "POST",
                        data: form_data,
                        dataType:"JSON",
                        processData: false,
                        contentType: false,
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_service.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_service.php?status="+(data.status);
                            }
                        }   
                    });
                    return false; 
                  }
                  else{
                    $(".errorMessage").show();
                    return false;
                  }     
                }
            }
            function GetServiceType(cid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/service.php",
                  type: "POST",
                  data: {cid:cid,cmd:"GetServiceType"},
                  dataType:"JSON",
                  success:function(data){
                      $("#service_type_id").html(data.string);
                      $("#hide_spin").hide();
                  }   
              });
            }
            
        </script>
    </body>
</html>