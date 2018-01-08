<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_leave WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    //$weekly_holiday = explode($row["weekly_holiday"],',');
    $weekly_holiday = explode(",",$row["weekly_holiday"]);

    $uid_leave = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include("includes/links.php"); ?>
        <link rel="stylesheet" href="../plugins/iCheck/all.css">
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
                        <li class="active">Leave</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Leave</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="leave_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <?php if(isset($id) && $id != "0"){
                                          /*$week_array = array("Friday","Saturday");
                                          echo '<input type="checkbox" id="fruit_id[]" name="fruit_id[]" value="' 
. $fruit_id . '"' . (in_array($week_array,$weekly_holiday) ? ' checked="checked"' : '') 
. '"/>' . $fruit_name . "\n"; */        ?> 
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Friday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Friday" name="weekly_holiday[]" class="flat-red" <?php if(in_array("Friday",$weekly_holiday)){ echo 'checked'; }?>>
                                            </label>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Saturday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Saturday" name="weekly_holiday[]" class="flat-red" <?php if(in_array("Saturday",$weekly_holiday)){ echo 'checked'; }?>>
                                            </label>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Sunday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Sunday" name="weekly_holiday[]" class="flat-red" <?php if(in_array("Sunday",$weekly_holiday)){ echo 'checked'; }?>>
                                            </label>
                                          </div>
                                        <?php
                                        }
                                        else{
                                          ?>
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Friday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Friday" name="weekly_holiday[]" class="flat-red" checked>
                                            </label>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Saturday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Saturday" name="weekly_holiday[]" class="flat-red" checked>
                                            </label>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-2">Sunday</label>
                                            <label class="col-md-1">
                                              <input type="checkbox" value="Sunday" name="weekly_holiday[]" class="flat-red" checked>
                                            </label>
                                          </div>
                                          <?php
                                        }
                                        ?>
                                        
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
        <script src="../plugins/iCheck/icheck.min.js"></script>
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
              $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass   : 'iradio_flat-red'
              });
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("leave_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                    url: "ajax/leave.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                      if(data.result == "true"){
                        window.location.href="list_leave.php?status="+(data.status);
                      }
                      else{
                        window.location.href="list_leave.php?status="+(data.status);
                      }
                    }   
                  });
                  return false;
                }
                else{
                  var form_data = new FormData(document.getElementById("leave_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                    url: "ajax/leave.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_leave.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_leave.php?status="+(data.status);
                        }
                    }   
                  });
                }
              }
        </script>
    </body>
</html>