<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_compensation_type WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_compensation_type = $_SESSION["user_id"];
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
                        <li class="active">Compensation Type</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Compensation Type</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" class="form-horizontal" id="compensation_type_form" action="#" onsubmit="return submitForm();">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="parent_id" class="control-label col-md-2">Compensation Type <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                          <select name="parent_id" id="parent_id" required="required" class="form-control" style="width: 100%;" <?php if(isset($id) && $id != ""){ echo 'disabled';}?>>
                                            <option value="">Please Select Category</option>
                                            <option value="0" <?php if($row["parent_id"] == 0){echo 'selected';} ?>>Main Category</option>
                                            <?php
                                              $query_category = "SELECT id,compensation_name FROM tbl_compensation_type WHERE status = '1' AND add_uid = '$uid_compensation_type' AND parent_id = '0'";
                                              $res_category = mysqli_query($mysqli,$query_category) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                              while($row_category = mysqli_fetch_assoc($res_category)){
                                                ?>
                                                  <option value="<?php echo $row_category['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_category['id'] == $row["parent_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_category['compensation_name']; ?></option>
                                                <?php
                                              }
                                            ?>
                                          </select>
                                          </div>
                                          <label for="compensation_name" class="control-label col-md-2">Compensation Name <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="compensation_name" value="<?php echo (isset($id) ? $row['compensation_name'] : ''); ?>" name="compensation_name" placeholder="Enter Compensation Name Here" required="required">
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
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function(){
              DecimalOnly();
              $("#parent_id").select2();
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("compensation_type_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/compensation_type.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_compensation_type.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_compensation_type.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("compensation_type_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/compensation_type.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_compensation_type.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_compensation_type.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
        </script>
    </body>
</html>