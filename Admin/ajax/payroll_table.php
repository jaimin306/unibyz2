
<?php
    // session_start();
    error_reporting(0);
    include('../includes/session.php');
    include("../../dbConnect.php");
    include('../includes/general.php');
    $cmd = $_REQUEST['cmd'];    
    $eid = $_REQUEST['employee_id'];    
    $uid_user = $_SESSION["user_id"];  
     // Selecting The Company Logo 
    $query2 = "SELECT company_name,company_logo FROM tbl_company_detail WHERE status = '1' and user_id = '$uid_user'"; 
    $res2 = mysqli_query($mysqli,$query2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $company = mysqli_fetch_assoc($res2); 
    $flag=0;

    if($eid!=''){
        $query = "SELECT * FROM tbl_user WHERE id = '$eid'";
        $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
        $emp_row= mysqli_fetch_assoc($res);

        $query = "SELECT p.*,u.first_name,u.last_name FROM tbl_payroll p LEFT JOIN tbl_user u on u.id=p.employee_id WHERE p.status = '1' AND p.add_uid = '$uid_user' AND p.employee_id=$eid AND DATE(p.recur_starts) <= CURDATE() AND DATE(p.recur_end) >= CURDATE() AND p.recurring='yes' AND p.id IN (SELECT MAX(tp.id) FROM tbl_payroll tp GROUP BY tp.employee_id)";     
        // echo $query; die;
        $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $row = mysqli_fetch_assoc($res);        
        if(isset($row['id'])){
            $flag=1;
        }
    }    

    if($cmd == "GetPayrollTable" && $flag==0){
    ?>
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
                                                        <td width="50%" class="cell_format">Employee Name</td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="employee_name" name="employee_name" value="<?php echo (isset($emp_row['id'])?$emp_row['first_name'].' '.$emp_row['last_name']:''); ?>" type="text">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_user' and direction='left'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){                                            
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" placeholder="" name="<?php echo $row['id']; ?>" type="text">
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
                                                            <div class="margin"><b>Payroll Date</b></div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="payroll-date" name="payroll_date" type="text" value="<?php echo date('Y-m-d'); ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="cell_format">Business Name</td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="business_name"   name="business_name" type="text" value="<?php echo (isset($company['company_name'])?$company['company_name']:'');?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_user' and direction='right'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){                                            
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" placeholder="" name="<?php echo $row['id']; ?>" type="text">
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
                                                        <td width="50%" class="bg-navy" style="padding-left: 7px; "><b>Description</b></td>
                                                        <td width="50%" class="bg-navy" style="padding-left: 7px; "><b>Amount</b></td>
                                                    </tr>
                                                    <?php 
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_user' and direction='addition'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){      
                                                        $i=1;                                      
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format" style="padding-left: 7px; "><?php echo $row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control touchspin number bottom_left"  onkeyup="refresh_totals()" id="bottom_left_<?php echo $i; ?>" name="<?php echo $row['id']; ?>" type="text">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                     <?php $i++; } }  ?>
                                                     <input type="hidden" name="total_addition" id="total_addition" value="<?php echo --$i; ?>">
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
                                                      $query = "SELECT * FROM tbl_payroll_template WHERE status = '1' and add_uid = '$uid_user' and direction='deduction'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){      
                                                        $i=1;                                      
                                                        while($row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control touchspin number bottom_right" onkeyup="refresh_totals()" id="bottom_right_<?php echo $i; ?>" name="<?php echo $row['id']; ?>" type="text">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; } } ?>   
                                                    <input type="hidden" name="total_deduction" id="total_deduction" value="<?php echo --$i; ?>">                                                  
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
                                                                <input class="form-control" readonly="" id="total_pay" name="total_pay" type="text">
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
                                                                <input class="form-control" readonly="" id="total_deductions" name="total_deductions" type="text">
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
                                                                <input class="form-control" readonly="" id="net_pay" name="net_pay" type="text">
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
                                        <td colspan="5" class="bg-navy" style="padding-left: 7px; ">
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
                                                <input class="form-control" name="payment_method" type="text">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control" name="bank_name" type="text">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control number" name="account_no" type="text">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control" name="description" type="text">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control number" id="paid_amount" name="paid_amount" type="text">
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
                                                <textarea class="form-control" name="comments" cols="50" rows="10"></textarea>
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
            <div class="form-group" style="margin-left: 15px;">
                <label for="Recurring" class="active">Recurring</label>
                <select class="form-control" id="recurring" name="recurring">
                  <option value="no">No</option>
                  <option value="yes">Yes</option>
                </select>
            </div>
            <div id="recur" style="display:none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left: 15px;">
                            <div class="form-line">
                                <label for="Recur Frequency" class="">Recur Frequency</label>
                                <input class="form-control" id="recurF" name="recur_frequency" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Type" class="active">Recur Type</label>
                                <select class="form-control" id="recurT" name="recur_type">
                                  <option value="">-Select-</option>
                                  <option value="day">Day(s)</option>
                                  <option value="week">Week(s)</option>
                                  <option value="month">Month(s)</option>
                                  <option value="year">Year(s)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left: 15px;">
                            <div class="form-line">
                                <label for="Recur Starts" class="">Recur Starts</label>
                                <input class="form-control date-picker" id="recur_start_date" name="recur_start_date" type="text" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Ends" class="">Recur Ends</label>
                                <input class="form-control date-picker" id="recur_end_date" name="recur_end_date" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>

 <!-- edit data -->
<?php
if($cmd == "GetPayrollTable" && $flag==1){
 ?>
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
                                                        <td width="50%" class="cell_format">Employee Name</td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="employee_name" name="employee_name" value="<?php echo (isset($emp_row['id'])?$emp_row['first_name'].' '.$emp_row['last_name']:''); ?>" type="text">
                                                            </div>
                                                        </td>
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
                                                                <input class="form-control" name="<?php echo $l_row['id']; ?>" type="text" value="<?php echo $l_row['value']; ?>">
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
                                                            <div class="margin"><b>Payroll Date</b></div>
                                                        </td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="payroll-date" name="payroll_date" type="text" value="<?php echo date('Y-m-d'); ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="cell_format">Business Name</td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control" id="business_name" name="business_name" type="text" value="<?php echo (isset($company['company_name'])?$company['company_name']:'');?>">
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
                                                                <input class="form-control" name="<?php echo $r_row['id']; ?>" type="text" value="<?php echo $r_row['value']; ?>">
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
                                                        <td width="50%" class="bg-navy" style="padding-left: 7px;"><b>Amount</b></td>
                                                    </tr>
                                                    <?php 
                                                      $query = "SELECT t.*,d.value FROM tbl_payroll_template t LEFT JOIN  tbl_payroll_detail d on d.template_id=t.id and d.payroll_id='$row[id]' WHERE t.status = '1' and t.add_uid = '$uid_user' and t.direction='addition'";                                                      
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      $num_rows = mysqli_num_rows($res);                                                      
                                                      if($num_rows > 0){      
                                                        $i=1;                                      
                                                        while($a_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format" style="padding-left: 7px;"><?php echo $a_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control touchspin number bottom_left"  onkeyup="refresh_totals()" id="bottom_left_<?php echo $i; ?>" name="<?php echo $a_row['id']; ?>" type="text" value="<?php echo $a_row['value']; ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                     <?php $i++; } }  ?>
                                                     <input type="hidden" name="total_addition" id="total_addition" value="<?php echo --$i; ?>">
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
                                                        $i=1;                                      
                                                        while($d_row = mysqli_fetch_assoc($res)){
                                                    ?> 
                                                    <tr>
                                                        <td width="50%" class="cell_format"><?php echo $d_row['column_nm']; ?></td>
                                                        <td width="50%" class="cell_format">
                                                            <div class="margin text-bold">
                                                                <input class="form-control touchspin number bottom_right" onkeyup="refresh_totals()" id="bottom_right_<?php echo $i; ?>" name="<?php echo $d_row['id']; ?>" type="text" value="<?php echo $d_row['value']; ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; } } ?>   
                                                    <input type="hidden" name="total_deduction" id="total_deduction" value="<?php echo --$i; ?>">                                                  
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
                                                                <input class="form-control" readonly="" id="total_pay" name="total_pay" type="text" value="<?php echo $row['total_pay']; ?>">
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
                                                                <input class="form-control" readonly="" id="total_deductions" name="total_deductions" type="text" value="<?php echo $row['total_deduction']; ?>">
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
                                                                <input class="form-control" readonly="" id="net_pay" name="net_pay" type="text" value="<?php echo $row['net_pay']; ?>">
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
                                                <input class="form-control" name="payment_method" type="text" value="<?php echo $row['payment_method']; ?>">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control" name="bank_name" type="text" value="<?php echo $row['bank_name']; ?>">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control number" name="account_no" type="text" value="<?php echo $row['account_no']; ?>">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control" name="description" type="text" value="<?php echo $row['description']; ?>">
                                            </div>
                                        </td>
                                        <td width="20%" class="cell_format">
                                            <div class="margin text-bold">
                                                <input class="form-control number" id="paid_amount" name="paid_amount" type="text" value="<?php echo $row['paid_amount']; ?>">
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
                                                <textarea class="form-control" name="comments" cols="50" rows="10"><?php echo $row['comments']; ?></textarea>
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
            <div class="form-group" style="margin-left:15px;">
                <label for="Recurring" class="active">Recurring</label>
                <select class="form-control" id="recurring" name="recurring">
                  <option value="no" <?php if($row['recurring']=='no'){ echo "selected";} ?>>No</option>
                  <option value="yes" <?php if($row['recurring']=='yes'){ echo "selected";} ?>>Yes</option>
                </select>
            </div>
            <div id="recur" style="display:block;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left:15px;">
                            <div class="form-line">
                                <label for="Recur Frequency" class="">Recur Frequency</label>
                                <input class="form-control" id="recurF" name="recur_frequency" type="number" value="<?php echo $row['recur_frequency']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Type" class="active">Recur Type</label>
                                <select class="form-control" id="recurT" name="recur_type">
                                  <option value="">-Select-</option>
                                  <option value="day" <?php if($row['recur_type']=='day'){ echo "selected";} ?>>Day(s)</option>
                                  <option value="week" <?php if($row['recur_type']=='week'){ echo "selected";} ?>>Week(s)</option>
                                  <option value="month" <?php if($row['recur_type']=='month'){ echo "selected";} ?>>Month(s)</option>
                                  <option value="year" <?php if($row['recur_type']=='year'){ echo "selected";} ?>>Year(s)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left:15px;">
                            <div class="form-line">
                                <label for="Recur Starts" class="">Recur Starts</label>
                                <input class="form-control date-picker" id="recur_start_date" name="recur_start_date" type="text" value="<?php echo date('Y-m-d',strtotime($row['recur_starts'])); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="Recur Ends" class="">Recur Ends</label>
                                <input class="form-control date-picker" id="recur_end_date" name="recur_end_date" type="text" value="<?php echo date('Y-m-d',strtotime($row['recur_end'])); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 <?php } ?>


 <script type="text/javascript">
    $(function () {
          $('#payroll-date').datepicker({                                                 
              autoclose: true,  
              format: 'yyyy-mm-dd',
              todayHighlight: true,
              changeMonth: true,
              changeYear: true,              
          }); 
          $('#recur_start_date').datepicker({                                                 
              autoclose: true,  
              format: 'yyyy-mm-dd',
              todayHighlight: true,
              changeMonth: true,
              changeYear: true,              
          }); 
          $('#recur_end_date').datepicker({                                                 
              autoclose: true,  
              format: 'yyyy-mm-dd',
              todayHighlight: true,
              changeMonth: true,
              changeYear: true,              
          }); 
          $('.textarea').wysihtml5();
          $('#recurring').on('change', function () {
              var recurring = $("#recurring").val();                   
              if(recurring=='yes'){
                  $("#recur").css("display","block");
              }else{
                  $("#recur").css("display","none");
              } 
        });               
    });
</script>