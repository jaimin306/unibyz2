<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $uid_setting = $_SESSION["user_id"];
    $query_company = "SELECT * FROM tbl_company_detail tcd LEFT JOIN tbl_all_setting tas ON tas.user_id = tcd.user_id WHERE tcd.status = '1' and tcd.user_id = '$uid_setting'";
    $res_company = mysqli_query($mysqli,$query_company) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row_company = mysqli_fetch_assoc($res_company);
    if (!empty($_GET['status'])) {
        switch ($_GET['status']) {
            case 'usuccess':
                $statusMsgClass = 'alert-success';
                $statusMsg      = 'Settings Updated Successfully';
            break;
            case 'error':
                $statusMsgClass = 'alert-danger';
                $statusMsg      = 'Error In Settings... Please Try Again';
            break;
            default:
                $statusMsgClass = '';
                $statusMsg      = '';
        }
    }
    $date_format = $row_company["date_format"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include("includes/links.php"); ?>
        <link rel="stylesheet" type="text/css" href="../dist/css/jquery.fancybox.min.css">
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
                        <li class="active">Setting</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Setting<br><br></h3>
                                </div>
                                <div class="container">
                                    <?php if (!empty($statusMsg)) {
                                      echo '<div class="alert ' . $statusMsgClass . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $statusMsg . '</div>';
                                    }
                                    ?>
                                    <div class="nav-tabs-custom">
                                      <ul class="nav nav-tabs">
                                        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                                        <li><a href="#sms" data-toggle="tab">SMS</a></li>
                                        <li><a href="#email_template" data-toggle="tab">Email Templates</a></li>
                                        <li><a href="#sms_template" data-toggle="tab">SMS Templates</a></li>
                                        <li><a href="#system" data-toggle="tab">System</a></li>
                                        <li><a href="#payment" data-toggle="tab">Payments</a></li>
                                      </ul>
                                      <form role="form" method="post" enctype="multipart/form-data" class="form-horizontal" id="setting_form" onsubmit="return submitForm();">
                                      <div class="tab-content">
                                        <!-- General Tab Content -->
                                        <div class="tab-pane active" id="general">
                                          <div class="box-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="company_name">Company Name:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="company_name" placeholder="Enter Company Name" name="company_name" value="<?php echo $row_company['company_name']; ?>">
                                                </div>
                                                <label class="control-label col-sm-2" for="company_email">Company Email:</label>
                                                <div class="col-sm-4">
                                                    <input type="email" class="form-control" id="company_email" placeholder="Enter Company Email" name="company_email" value="<?php echo $row_company['company_email']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="control-label col-sm-2" for="company_address">Company Address:</label>
                                              <div class="col-sm-4">
                                                <textarea class=" form-control" name="company_address" placeholder="Enter Company Address Here" style="height: 70px; " ><?php echo $row_company['company_address']; ?></textarea>
                                              </div>
                                              <label class="control-label col-sm-2">Country :</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" id="country" placeholder="Enter Country Here" name="country" value="<?php echo $row_company['country']; ?>">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="control-label col-sm-2">Currency :</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" id="currency" placeholder="Enter Currency Here" name="currency" value="<?php echo $row_company['currency']; ?>">
                                              </div>
                                              <label class="control-label col-sm-2">Currency Symbol :</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" id="currency_symbol" placeholder="Enter Currency Symbol Here" name="currency_symbol" value="<?php echo $row_company['currency_symbol']; ?>">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="control-label col-sm-2">Portal Address :</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" id="portal_address" placeholder="Enter Portal Address Here" name="portal_address" value="<?php echo $row_company['portal_address']; ?>">
                                              </div>
                                              <label class="control-label col-sm-2" for="date_format">Date Format :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="date_format" name="date_format">
                                                        <option value="m-d-Y" <?php if($date_format == "m-d-Y"){ echo 'selected';} ?>>m-d-Y</option>
                                                        <option value="d-m-Y" <?php if($date_format == "d-m-Y"){ echo 'selected';} ?>>d-m-Y</option>
                                                        <option value="Y-m-d" <?php if($date_format == "Y-m-d"){ echo 'selected';} ?>>Y-m-d</option>
                                                        <option value="d/m/Y" <?php if($date_format == "d/m/Y"){ echo 'selected';} ?>>d/m/Y</option>
                                                        <option value="m/d/Y" <?php if($date_format == "m/d/Y"){ echo 'selected';} ?>>m/d/Y</option>
                                                        <option value="Y/m/d" <?php if($date_format == "Y/m/d"){ echo 'selected';} ?>>Y/m/d</option>
                                                        <option value="d.m.Y" <?php if($date_format == "d.m.Y"){ echo 'selected';} ?>>d.m.Y</option>
                                                        <option value="m.d.Y" <?php if($date_format == "m.d.Y"){ echo 'selected';} ?>>m.d.Y</option>
                                                        <option value="Y.m.d" <?php if($date_format == "Y.m.d"){ echo 'selected';} ?>>Y.m.d</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="control-label col-sm-2" for="company_logo">Company Logo:</label>
                                              <div class="col-sm-4">
                                                <img src="../uploads/logo/<?php echo $row_company['company_logo']; ?>" height="120px" width="120px">
                                                <input type="file" class="form-control" id="company_logo" name="company_logo" >
                                                <input type="hidden" name="company_logo_value" value="<?php echo $row_company['company_logo']; ?>">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- SMS Tab Content -->
                                        <div class="tab-pane" id="sms">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">SMS Enabled :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="sms_enabled" id="sms_enabled"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["sms_enabled"] == "Yes"){ echo 'selected';} ?> >Yes</option>
                                                                <option value="No" <?php if($row_company["sms_enabled"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>    
                                                        <label class="control-label col-sm-2">Active SMS Gateway :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="sms_gateway" id="sms_gateway"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["sms_gateway"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["sms_gateway"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">SMS Sender Name :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="sms_sender_name" id="sms_sender_name" class="form-control" placeholder="Enter SMS Sender Name Here" value="<?php echo $row_company['sms_sender_name']; ?>">
                                                        </div>    
                                                        <label class="control-label col-sm-2">Twilio SID :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="twilio_sid" id="twilio_sid" class="form-control" placeholder="Enter Twilio SID Here" value="<?php echo $row_company['twilio_sid']; ?>">
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Twilio Token :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="twilio_token" id="twilio_token" class="form-control" placeholder="Enter Twilio Token Here" value="<?php echo $row_company['twilio_token']; ?>">
                                                        </div>    
                                                        <label class="control-label col-sm-2">Twilio Phone Number :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="twilio_phone" id="twilio_phone" class="form-control" placeholder="Enter Twilio Phone Number Here" value="<?php echo $row_company['twilio_phone']; ?>"> 
                                                        </div>    
                                                    </div>
                                                </div>
                                            
                                        </div>
                                        <div class="tab-pane" id="email_template">
                                           
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email Payment Subject </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="email_payment_subject" id="email_payment_subject" class="form-control" placeholder="Enter Email Payment Subject Here" value="<?php echo $row_company['email_payment_subject']; ?>">
                                                        </div>     
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email Payment Template </label>
                                                        <div class="col-sm-10">
                                                            <textarea class="textarea" name="email_payment_template" placeholder="Enter Email Payment Template Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo $row_company['email_payment_template']; ?></textarea>
                                                        </div>     
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="sms_template">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">SMS Payment Subject :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="sms_payment_subject" id="sms_payment_subject" class="form-control" placeholder="Enter SMS Payment Subject Here" value="<?php echo $row_company['sms_payment_subject']; ?>">
                                                        </div>     
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">SMS Payment Template :</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="textarea" name="sms_payment_template" placeholder="Enter SMS Payment Template Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo $row_company['sms_payment_template']; ?></textarea>
                                                        </div>     
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="system">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Cron Job Enabled :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="cron_job" id="cron_job"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["cron_job"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["cron_job"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>     
                                                    </div>
                                                </div>
                                        </div>
                                        
                                        <div class="tab-pane" id="payment">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Enable Online Payment :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="online_payment" id="online_payment"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["online_payment"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["online_payment"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>
                                                        <label class="control-label col-sm-2">Paypal Enabled :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="paypal_enabled" id="paypal_enabled"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["paypal_enabled"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["paypal_enabled"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Paypal Email :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="paypal_email" id="paypal_email" class="form-control" value="<?php echo $row_company['paypal_email']; ?>">
                                                        </div>    
                                                        <label class="control-label col-sm-2">Paynow Enabled :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="paynow_enabled" id="paynow_enabled"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["paynow_enabled"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["paynow_enabled"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Paynow ID :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="paynow_id" id="paynow_id" class="form-control"  value="<?php echo $row_company['paynow_id']; ?>">
                                                        </div> 
                                                        <label class="control-label col-sm-2">Paynow Key :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="paynow_key" id="paynow_key" class="form-control" value="<?php echo $row_company['paynow_key']; ?>">
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Stripe Enabled :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="stripe_enabled" id="stripe_enabled"> 
                                                                <option value="">Please Select</option>
                                                                <option value="Yes" <?php if($row_company["stripe_enabled"] == "Yes"){ echo 'selected';} ?>>Yes</option>
                                                                <option value="No" <?php if($row_company["stripe_enabled"] == "No"){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                        </div> 
                                                        <label class="control-label col-sm-2">Stripe Key :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="stripe_key"  value="<?php echo $row_company['stripe_key']; ?>" id="stripe_key" class="form-control">
                                                        </div>    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Stripe Secret :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="stripe_secret" id="stripe_secret" class="form-control" value="<?php echo $row_company['stripe_secret']; ?>">
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>
                                      </div>
                                      <div class="form-group">        
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        </div>
                                      </form>
                                    </div>
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
        <script src="../dist/js/jquery.fancybox.min.js"></script>
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function () {
              $('.textarea').wysihtml5();
            });
            function submitForm() {   
                var form_data = new FormData(document.getElementById("setting_form"));
                form_data.append("cmd", "UpdateSetting");
                $.ajax({
                    url: "ajax/setting.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="setting.php?status="+data.status;
                        }
                        else{
                            window.location.href="setting.php?status="+data.error;
                        }
                    }   
                });
                return false; 
            }
        </script>
    </body>
</html> 