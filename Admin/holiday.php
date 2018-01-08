<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_holiday WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_project = $_SESSION["user_id"];
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
                        <li class="active">Holiday</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Holiday</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="holiday_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="from_date" class="control-label col-md-2">From Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="from_date" value="<?php echo (isset($id) ? $row["from_date"] : ''); ?>" id="from_date" class="form-control" required="required">
                                            </div>
                                            <label for="to_date" class="control-label col-md-2">To Date <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="to_date" value="<?php echo (isset($id) ? $row["to_date"] : ''); ?>" id="to_date" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="holiday_name" class="control-label col-md-2">No. Of Days <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="no_of_days" value="<?php echo (isset($id) ? $row["no_of_days"] : ''); ?>" id="no_of_days" class="form-control" required="required" readonly>
                                            </div>
                                            <label for="holiday_name" class="control-label col-md-2">Holiday Name <span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="holiday_name" value="<?php echo (isset($id) ? $row["holiday_name"] : ''); ?>" id="holiday_name" class="form-control" required="required">
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
            $('#from_date').datepicker({
                autoclose: true,
                //startDate: new Date(),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var minDate = new Date(selected.date.valueOf());
              $('#to_date').datepicker('setStartDate', minDate);
              var start = $("#from_date").datepicker("getDate");
              var end = $("#to_date").datepicker("getDate");
              if(start != null && end != null){
                var days = (end - start) / (1000 * 60 * 60 * 24);
                $("#no_of_days").val(days);
              }
            });

            $('#to_date').datepicker({
                autoclose: true,
                //startDate: new Date(),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
            }).on("changeDate", function (selected) {
              var maxDate = new Date(selected.date.valueOf());
              $('#from_date').datepicker('setEndDate', maxDate);

              var start = $("#from_date").datepicker("getDate");
              var end = $("#to_date").datepicker("getDate");
              if(start != null && end != null){
                var days = (end - start) / (1000 * 60 * 60 * 24);
                $("#no_of_days").val(days);
              }
            });           
          });
          function submitForm() {    
              var formid = $("#hidden_id").val();        
              if(formid != "" && formid != "0"){
                var form_data = new FormData(document.getElementById("holiday_form"));
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
                            window.location.href="list_holiday.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_holiday.php?status="+(data.status);
                        }
                    }   
                });
                return false; 
              }
              else{
                var form_data = new FormData(document.getElementById("holiday_form"));
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
                            window.location.href="list_holiday.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_holiday.php?status="+(data.status);
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