<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_salary_generate WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_salary_setup = $_SESSION["user_id"];
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
        <style type="text/css">
          .header-table{
            background-color: rgba(93, 84, 220, 0.89) !important;
            color: white;
            font-size: 13px;
            text-align: center;
          }
          table tr td{
            border-collapse: collapse;
          }
        </style>
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
                        <li class="active">Salary Generate</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Generate Salary</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" class="form-horizontal" id="salary_generate_form" action="#" onsubmit="return submitForm();">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="employee_id" class="control-label col-md-2">Employee Name <span class="text-danger">*</span></label>
                                          <?php if(isset($id) && $id != "0"){
                                            ?>
                                            <div class="col-md-4">
                                              <select name="employee_id" id="employee_id" required="required" class="form-control" style="width: 100%;" >
                                                
                                                <?php
                                                  $query_employee = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_salary_setup' AND user_type IN (3,4)";
                                                  $res_employee = mysqli_query($mysqli,$query_employee) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_employee = mysqli_fetch_assoc($res_employee)){
                                                    ?>
                                                      <option value="<?php echo $row_employee['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_employee['id'] == $row["employee_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_employee['first_name']." ".$row_employee["last_name"]; ?></option>
                                                    <?php
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                            <?php
                                          }
                                          else{
                                            ?>
                                            <div class="col-md-3">
                                              <select name="employee_id[]" id="employee_id" onchange="AllSel()" required="required" class="form-control" style="width: 100%;" multiple>
                                                <?php
                                                  $query_employee = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND add_uid = '$uid_salary_setup' AND user_type IN (3,4)";
                                                  $res_employee = mysqli_query($mysqli,$query_employee) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_employee = mysqli_fetch_assoc($res_employee)){
                                                    ?>
                                                      <option value="<?php echo $row_employee['id']; ?>" ><?php echo $row_employee['first_name']." ".$row_employee["last_name"]; ?></option>
                                                    <?php
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="col-md-1">
                                                <input type="checkbox" class="flat-red" id="select_all" onclick="SelectAll()"> <b>All</b>
                                            </div>
                                            <?php
                                          }
                                          ?>
                                          
                                          <label for="name" class="col-md-2 control-label">Name <span class="text-danger">*</span> </label>
                                          <div class="col-md-4">
                                            <input type="text" id="name" name="name" value="<?php echo (isset($id) ? $row['name'] : ''); ?>" placeholder="Enter Name Here" class="form-control" required="required">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="start_date" class="control-label col-md-2">Start Date <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="text" name="start_date" id="start_date" value="<?php echo (isset($id) ? $row['start_date'] : ''); ?>" class="form-control readonly" placeholder="Enter Start Date Here" required="">
                                          </div>
                                          <label for="end_date" class="control-label col-md-2">End Date <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="text" name="end_date" id="end_date" value="<?php echo (isset($id) ? $row['end_date'] : ''); ?>" class="form-control readonly" placeholder="Enter End Date Here" required>
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
        <script src="../plugins/iCheck/icheck.min.js"></script>
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
              $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass   : 'iradio_flat-red'
              });
              $("#select_all").on("ifChanged", SelectAll);
              $("#employee_id").select2({placeholder:"Please Select Employee"});
              $('#start_date').datepicker({
                  autoclose: true,
                  //startDate: new Date(),
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
                  //startDate: new Date(),
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
                  var form_data = new FormData(document.getElementById("salary_generate_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/salary_generate.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_salary_generate.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_salary_generate.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("salary_generate_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/salary_generate.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_salary_generate.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_salary_generate.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function SelectAll(){
              if($("#select_all").is(':checked') ){
                  $("#employee_id > option").prop("selected","selected");
                  $("#employee_id").trigger("change");
              }else{
                  $("#employee_id > option").prop("selected",false);
                  $("#employee_id").trigger("change");
              }
            }
            function AllSel(){
              var total_checked = $('#employee_id > option').length;
              var checked = $('#employee_id option:selected').length;
              if(total_checked == checked){
                $('#select_all').iCheck('check');
              }
              else if(checked > 0){
                //Nothing
              }
              else{
               $('#select_all').iCheck('uncheck'); 
              }
            }
        </script>
    </body>
</html>