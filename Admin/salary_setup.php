<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_salary_setup WHERE status = '1' and id = '$id'";
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
                        <li class="active">Salary Setup</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Salary Setup</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" class="form-horizontal" id="salary_setup_form" action="#" onsubmit="return submitForm();">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="employee_id" class="control-label col-md-2">Employee Name <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <select name="employee_id" id="employee_id" onchange="GetEmployee(this.value)" required="required" class="form-control" style="width: 100%;">
                                              <option value="">Please Select Employee</option>
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
                                          <label for="salary_duration" class="col-md-2 control-label">Wages <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="salary_duration" id="salary_duration" required="">
                                              <option value="">Please Select Wages</option>
                                              <option value="Annually" <?php if($row["salary_duration"] == 'Annually'){ echo 'selected'; } ?>>Annually</option>
                                              <option value="Monthly" <?php if($row["salary_duration"] == 'Monthly'){ echo 'selected'; } ?>>Monthly</option>
                                              <option value="Weekly" <?php if($row["salary_duration"] == 'Weekly'){ echo 'selected'; } ?>>Weekly</option>
                                              <option value="Hourly" <?php if($row["salary_duration"] == 'Hourly'){ echo 'selected'; } ?>>Hourly</option>
                                              <option value="Daily" <?php if($row["salary_duration"] == 'Daily'){ echo 'selected'; } ?>>Daily</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="compensation_type" class="col-md-2 control-label">Compensation Type <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="compensation_type" onchange="GetCompensation(this.value)" id="compensation_type" required="">
                                              <option value="">Please Select Compensation Type</option>
                                              <?php
                                                $query_compensation = "SELECT id,compensation_name FROM tbl_compensation_type WHERE status = '1' AND add_uid = '$uid_salary_setup' AND parent_id = 0";
                                                $res_compensation = mysqli_query($mysqli,$query_compensation) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_compensation = mysqli_fetch_assoc($res_compensation)){
                                                  ?>
                                                    <option value="<?php echo $row_compensation['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_compensation['id'] == $row["employee_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_compensation['compensation_name']; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                            <div id="hide_spin" style="display:none"><i class="fa fa-refresh fa-spin"></i></div>
                                          </div>
                                          <label for="compensation_sub_type" class="col-md-2 control-label">Type </label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="compensation_sub_type" id="compensation_sub_type" >
                                                <option value="">Please Select Type</option>    
                                              </select>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                          <label for="tax_id" class="col-md-2 control-label">Tax Name</label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="tax_id" id="tax_id" >
                                              <option value="">Please Select Tax</option>
                                              <?php
                                                $query_tax = "SELECT id,tax_name,tax_rate FROM  tbl_taxrate WHERE status = '1' AND add_uid = '$uid_salary_setup'";
                                                $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_tax = mysqli_fetch_assoc($res_tax)){
                                                  ?>
                                                    <option value="<?php echo $row_tax['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_tax['id'] == $row["tax_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_tax['tax_name']." - ".$row_tax["tax_rate"]; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <table style="width:98%" class="table table-striped" cellpadding="0" cellspacing="0">
                                            <tr class="header-table">
                                              <th>Addition</th>
                                              <th>Deduction</th>
                                            </tr>
                                            <tr>
                                              <td style="background-color:#cfd8d8">
                                                <table style="width:100%;background-color:#cfd8d8" class="table table-striped" cellpadding="0" cellspacing="0">
                                                  <?php
                                                    $select_add = "SELECT * FROM tbl_salary_type WHERE status = '1' and add_uid = '$uid_salary_setup' AND salary_type = '1'";
                                                    $res_add = mysqli_query($mysqli,$select_add) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_add = mysqli_fetch_assoc($res_add)){
                                                      ?>
                                                      <tr>
                                                        <td style="width: 30%;font-weight: bold"><?php echo $row_add["salary_name"]; ?></td>
                                                        <td style="width: 70%"><input type="text" class="form-control number" name="amount[]" id="amount" placeholder="<?php echo 'Enter '.$row_add["salary_name"].' Here'; ?>"></td>
                                                        <input type="hidden" value="<?php echo $row_add['id']; ?>" name="type_id[]">
                                                        <input type="hidden" value="1" name="amount_add_deduct[]">
                                                      </tr>  
                                                      <?php
                                                    }
                                                  ?>
                                                </table>
                                              </td>
                                              <td style="background-color:#cfd8d8">
                                                <table style="width:100%;background-color:#cfd8d8" class="table table-striped" cellpadding="0" cellspacing="0">
                                                  <?php
                                                    $select_deduct = "SELECT * FROM tbl_salary_type WHERE status = '1' and add_uid = '$uid_salary_setup' AND salary_type = '0'";
                                                    $res_deduct = mysqli_query($mysqli,$select_deduct) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_deduct = mysqli_fetch_assoc($res_deduct)){
                                                      ?>
                                                      <tr>
                                                        <td style="width: 30%;font-weight: bold"><?php echo $row_deduct["salary_name"]; ?></td>
                                                        <td style="width: 70%"><input type="text" class="form-control number" name="amount[]" id="amount" placeholder="<?php echo 'Enter '.$row_deduct["salary_name"].' Here'; ?>"></td>
                                                        <input type="hidden" value="<?php echo $row_deduct['id']; ?>" name="type_id[]">
                                                        <input type="hidden" value="0" name="amount_add_deduct[]">
                                                      </tr>  
                                                      <?php
                                                    }
                                                  ?>
                                                </table>
                                              </td>
                                            </tr>
                                          </table>
                                        </div>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if(isset($id) && $id != "" ){
                                          echo '<button type="submit" class="btn btn-primary pull-right">Update</button>';
                                        }
                                        else{
                                          echo '<button type="submit" class="btn btn-primary pull-right">Save</button>';
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
              $("#employee_id").select2();
              $("#salary_duration").select2();
              $("#compensation_type").select2();
              $("#compensation_sub_type").select2();
              $("#tax_id").select2();
            });
            function GetEmployee(eid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/salary_setup.php",
                  type: "POST",
                  data: {id:eid,cmd:"GetEmployee"},
                  dataType:"JSON",
                  success:function(data){
                      $("#employeeId").val(data.employeeId);
                      $("#hide_spin").hide();
                  }   
              });
            }
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("salary_setup_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/salary_setup.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_salary_setup.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_salary_setup.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("salary_setup_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/salary_setup.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_salary_setup.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_salary_setup.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function GetCompensation(id){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/salary_setup.php",
                  type: "POST",
                  data: {id:id,cmd:"GetCompensation"},
                  dataType:"JSON",
                  success:function(data){
                      $("#compensation_sub_type").html(data.string);
                      $("#hide_spin").hide();
                  }   
              });
            }
        </script>
    </body>
</html>