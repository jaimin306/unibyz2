<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');     
    $uid_user = $_SESSION["user_id"]; 
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
          .bigdrop {
              width: 500px !important;
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
                        <li class="active">Payroll</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title"><?php if(isset($id) && $id != ""){ echo 'Edit Payroll'; } else{ echo 'Add Payroll';} ?></h3>
                                </div>
                                   <!-- start -->
                                  <!-- <form method="POST" action="#" accept-charset="UTF-8" name="form" enctype="multipart/form-data"><input name="_token" type="hidden" value="ITk2pqCdRsRvdFL9hhDvVA9lot6d8YhNTch6uxnJ"> -->
                                  <form role="form" method="post" id="payroll_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                          <div class="form-group">
                                              <label for="user_id" class="">Staff</label>
                                              <select class="form-control" id="employee_id" name="employee_id" class="bigdrop">
                                                  <option selected="selected" value="">Select</option>
                                                   <?php
                                                      $query = "SELECT * FROM tbl_user WHERE add_uid = '$uid_user' AND user_type IN (3,4)";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);
                                                      if($num_rows > 0){
                                                        $i = 1;
                                                        while($row = mysqli_fetch_assoc($res)){
                                                   ?>
                                                   <option value="<?php echo $row['id']; ?>"><?php echo $row["first_name"]." ".$row["last_name"];?></option>
                                                   <?php } } ?>
                                              </select>
                                          </div>

                                          <div id="replace_div"> 
                                          </div> 
                                      </div>
                                      <div class="box-footer">
                                          <button type="submit" class="btn btn-primary pull-right">Save</button>
                                      </div>
                                  </form>

                                  <!-- /.box-body -->

                                  <!-- end -->
                               
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
              GetPayrollTable();
              DecimalOnly();
              
              //$('#employee_id').select2();
              $("#employee_id").select2({dropdownCssClass : 'bigdrop'});  
              $('#employee_id').on('change', function () {
                  GetPayrollTable();
              });
              
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("payroll_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/customer.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_customer.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_customer.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("payroll_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/payroll.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_payroll.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_payroll.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
 
            function refresh_totals(){
                var count_addition=parseInt($('#total_addition').val());
                var count_deduction=parseInt($('#total_deduction').val()); 
                var total_add=0;
                var total_deduct=0;
                for(i=1;i<=count_addition;i++){
                    x=$('#bottom_left_'+i).val();
                    if(x!=''){
                        total_add+=parseInt(x);
                    }
                } 
                $('#total_pay').val(total_add);
                for(i=1;i<=count_deduction;i++){
                    x=$('#bottom_right_'+i).val();
                    if(x!=''){
                        total_deduct+=parseInt(x);
                    }
                } 
                $('#total_deductions').val(total_deduct);
                var net_pay=total_add-total_deduct;
                $('#net_pay').val(net_pay); 
                $('#paid_amount').val(net_pay);  
            }
            function GetPayrollTable(){
                //$("#hidden_spinner").show();
                var employee_id = $("#employee_id").val(); 
                $.ajax({
                    url: "ajax/payroll_table.php",
                    type: "POST",
                    data: {employee_id:employee_id,cmd:"GetPayrollTable"},
                    success:function(data){                        
                        $("#replace_div").html(data);                        
                    }   
                });
            }
        </script>
    </body>
</html>