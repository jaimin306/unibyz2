<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_ticket_department WHERE id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
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
                        <li class="active">Incident Department</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Department</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="ticket_department_form" class="form-horizontal" action="#" onsubmit="return submitForm();">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="department_name" class="control-label col-md-2">Department Name <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="department_name" value="<?php echo (isset($id) ? $row['department_name'] : ''); ?>" name="department_name" placeholder="Enter Department Name Here" required="required">
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
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("ticket_department_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/ticket_department.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_ticket_department.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_ticket_department.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("ticket_department_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/ticket_department.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_ticket_department.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_ticket_department.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            
        </script>
    </body>
</html>