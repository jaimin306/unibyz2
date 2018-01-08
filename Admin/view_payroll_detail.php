<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');     
    $uid_user = $_SESSION["user_id"]; 
    $pid= decrypt($_GET["PID"]);         
    $query = "SELECT p.*,u.first_name,u.last_name FROM tbl_payroll p LEFT JOIN tbl_user u on u.id=p.employee_id WHERE p.status = '1' AND p.add_uid = '$uid_user' AND p.id='$pid'";         
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);  
     
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
                        <li class="active">Payroll</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">View Payroll</h3>
                                </div>
                                   <!-- start -->
        <button type="button" onclick="window.history.go(-1);" class="btn btn-success pull-right" style="margin-right: 10px;
    margin-top: 10px;">Back</button>


<form role="form" method="post" id="payroll_form" class="form-horizontal" action="#">    
    <div class="box-body">
        <div class="form-group">
            <label for="user_id" class="" style="margin-left: 15px;" >Staff: <?php echo $row['first_name'].' '.$row['last_name']; ?></label>             
        </div> 
        <div id="replace_div"> 
        <!-- start -->
        <table width="100%">
                <tbody>
                    <tr>
                        <td style="padding-bottom:10px;">
                            <table width="100%" class="borderOk" style="border: 1px solid #000;">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: top;" width="50%">

                                            <table width="100%" id="payslip_employee_header" style="margin-left:7px; ">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="cell_format">Employee Name: </td>
                                                        <td width="50%" class="cell_format">
                                                          <div class="margin text-bold"><?php echo (isset($row['id'])?$row['first_name'].' '.$row['last_name']:''); ?></div></td>
                                                    </tr>
                                                    <?php                                                       
                                                      $query = "SELECT t.*,d.value FROM tbl_payroll_template t LEFT JOIN  tbl_payroll_detail d on d.template_id=t.id and d.payroll_id='$row[id]' WHERE t.status = '1' and t.add_uid = '$uid_user' and t.direction='left'";                                                      
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){                                            
                                                        while($l_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $l_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                 <?php echo ($l_row['value']?$l_row['value']:'-'); ?> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                     
                                                </tbody>
                                            </table>
                                        </td>

                                        <td style="vertical-align: top" width="50%">

                                            <table width="100%" id="pay_period_and_salary" style="margin-left:7px; ">

                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin" style="margin-left: 0px !important;">Payroll Date</div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo date('Y-m-d',strtotime($row['payroll_date'])); ?> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="cell_format">Business Name</td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo  $row['business_name'];?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php                                                       
                                                      $query = "SELECT t.*,d.value FROM tbl_payroll_template t LEFT JOIN  tbl_payroll_detail d on d.template_id=t.id and d.payroll_id='$row[id]' WHERE t.status = '1' and t.add_uid = '$uid_user' and t.direction='right'";                                                      
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){                                            
                                                        while($r_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $r_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">                                                                
                                                                <?php echo ($r_row['value']?$r_row['value']:'-'); ?> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                            <!--Pay Period and Salary-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" class="borderOk" style="border:1px solid #000;">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: top;" width="50%" class="borderRight">

                                            <table width="100%" id="hours_and_earnings">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="bg-navy" style="padding-left: 7px;"><b>Description</b></td>
                                                        <td width="50%" class="bg-navy"><b>Amount</b></td>
                                                    </tr>
                                                    <?php 
                                                      $query = "SELECT t.*,d.value FROM tbl_payroll_template t LEFT JOIN  tbl_payroll_detail d on d.template_id=t.id and d.payroll_id='$row[id]' WHERE t.status = '1' and t.add_uid = '$uid_user' and t.direction='addition'";                                                      
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){                                       
                                                       while($a_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format" style="padding-left: 7px;"><?php echo $a_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                               <?php echo ($a_row['value']?$a_row['value']:0); ?>
                                                        </td>
                                                    </tr>
                                                     <?php } }  ?> 
                                                </tbody>
                                            </table>
                                            <!--Hours and Earnings-->
                                        </td>

                                        <td width="50%" valign="top">
                                            <table width="100%" id="pre_tax_deductions">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="bg-navy"><b>Description</b></td>
                                                        <td width="50%" class="bg-navy"><b>Amount</b></td>
                                                    </tr>
                                                    <?php                                                       
                                                      $query = "SELECT t.*,d.value FROM tbl_payroll_template t LEFT JOIN  tbl_payroll_detail d on d.template_id=t.id and d.payroll_id='$row[id]' WHERE t.status = '1' and t.add_uid = '$uid_user' and t.direction='deduction'";                                                      
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){      
                                                        while($d_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $d_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo ($d_row['value']?$d_row['value']:0); ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php  } } ?>                                                       
                                                </tbody>
                                            </table>
                                            <!--Pre-Tax Deductions-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%" class="bg-gray">
                                            <table width="100%" id="gross_pay" style="margin-left:7px; ">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin"><b>Total Pay</b></div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo $row['total_pay']; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                        <td width="50%" class="bg-gray">

                                            <table width="100%" id="gross_pay" style="margin-left:7px; ">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin"><b>Total Deductions</b></div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo $row['total_deduction']; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <br>
                                        </td>
                                        <td width="50%" class="bg-gray">
                                            <table width="100%" id="gross_pay" style="margin-left:7px; ">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin"><b>Net Pay</b></div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <?php echo $row['net_pay']; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px;">
                            <table width="100%" class="borderOk" id="net_pay_distribution" style="border:1px solid #000;">
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="bg-navy" style="padding-left: 7px;">
                                            <b>Net Pay Distribution</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%" class="cell_format">
                                            <div class="margin">
                                                <b>Payment Method</b>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin">
                                                <b>Bank Name</b>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin">
                                                <b>Account Number</b>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin">
                                                <b>Description</b>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin">
                                                <b>Paid Amount</b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <?php echo $row['payment_method']; ?>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <?php echo $row['bank_name']; ?>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <?php echo $row['account_no']; ?>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <?php echo $row['description']; ?>
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <?php echo $row['paid_amount']; ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--Net Pay Distribution-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" class="borderOk" style="margin-top:10px; border:1px solid #000;" id="messages">
                                <tbody>
                                    <tr>
                                        <td width="100%" class="cell_format">
                                            <div class="margin"><b>Comments</b></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" class="cell_format">
                                            <div class="margin text-bold">
                                                <textarea class="form-control" name="comments" cols="50" rows="10" readonly><?php echo $row['comments']; ?></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--Messages-->
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="form-group">
                <label for="Recurring" class="active" style="margin-left: 15px;">Recurring :</label> <?php echo $row['recurring'] ?> 
            </div>
            <div id="recur" style="display:block;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Frequency" class="" style="margin-left: 15px;">Recur Frequency</label> : <?php echo $row['recur_frequency']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Type" class="active">Recur Type</label> : <?php echo $row['recur_type']; ?>                                 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Starts" class="" style="margin-left: 15px;">Recur Starts</label> : <?php echo ($row['recur_starts']?date('Y-m-d',strtotime($row['recur_starts'])):''); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Ends" class="">Recur Ends</label> : <?php echo ($row['recur_end']?date('Y-m-d',strtotime($row['recur_end'])):''); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end -->
        </div> 
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
    </body>
</html>