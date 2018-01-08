<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["INVID"]);
    $query = "SELECT te.*,tu.first_name,tu.last_name,p.project_name,tu.address,tu.phone,tu.email,two.work_order_name FROM tbl_invoice te LEFT JOIN tbl_project p ON p.id = te.project_id LEFT JOIN tbl_user tu ON tu.id = p.customer_id LEFT JOIN tbl_work_order two ON two.project_id = p.id WHERE te.status = '1' and te.id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
     
    $client_name = $row["first_name"]." ".$row["last_name"];     
    $uid_inv = $_SESSION["user_id"];
    // Selecting The Company Logo 
    
    $data = GetRecord('tbl_all_setting','user_id',$uid_inv);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include("includes/links.php"); ?>
        <style type="text/css">
            hr.style-eight {
                overflow: visible;
                padding: 0;
                border: none;
                border-top: medium double #333;
                color: #333;
                text-align: center;
            }
            hr{
                margin: 15px 0 15px 0;
            }
            table.custom-border {
                border-width: 1px;
                border-style: solid;
                border-color: #ada8a8;
                width: 100%;
                background-color: white;
            }
            table.custom-border th {
                border-width: 1px;
                padding: 5px;
                border-style: solid;
                border-color: #ada8a8;
                background-color: white;
                -moz-border-radius: ;
            }
            table.custom-border td {
                border-width: 1px;
                padding: 5px;
                border-style: solid;
                border-color: #ada8a8;
                background-color: white;
                -moz-border-radius: ;
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Invoice</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <div class="container">
                                      <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                          <b style="font-size: 25px;">Invoice #<?php echo $id; ?> </b>

                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 invoice-col">
                                          Last Emailed : <?php if($row["notify_email_date"] != "" && $row["notify_email"] != "0"){ echo '<b>'.$row["notify_email_date"].'</b>';} else{ echo '<b>Never</b>';} ?>
                                          <br>
                                          Work Order : <?php echo '<b>'.$row["work_order_name"].'</b>' ?>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6 invoice-col text-right">
                                          <div class="btn-group pull-right">
                                            <a href="list_invoice.php"><button class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-left"></i> Back </button></a>

                                            <a href="Media/pdf_invoice.php?INVID=<?php echo encrypt($id); ?>" data-toggle="tooltip" class="btn btn-sm btn-success" data-original-title="Save PDF" style="margin-right:10px" ><i class="fa fa-file-pdf-o"></i></a>
                                            
                                            <a href="javascript:" data-toggle="tooltip" class="btn btn-sm btn-danger btndeleteselected" data-original-title="Delete" value=<?php echo $id; ?> style="margin-right:10px"><i class="fa fa-trash-o"></i></a>

                                            <a href="Media/print_invoice.php?INVID=<?php echo encrypt($id); ?>" data-toggle="tooltip" class="btn btn-sm btn-warning" data-original-title="Print" style="margin-right:10px" target="_blank"  ><i class="fa fa-print"></i></a>
                                            <div class="btn-group">
                                              <button class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right:10px"><b>More Actions <span class="caret"></span></b></button>
                                              <ul class="dropdown-menu">
                                                <li>
                                                  <a href="javascript:void(0)" title="Email Invoice" onclick="SendEstimateMail(<?php echo $id; ?>)"><i class="fa fa-envelope"></i> Email Invoice</a>
                                                </li>
                                                <li>
                                                  <a href="#" title="Payment"><i class="fa fa-money"></i> Payment </a>
                                                </li>
                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary" style="min-height:650px">
                                <?php
                                    if($row['invoice_status'] == "0"){
                                        echo '<div class="ribbon-warning"><span>Pending</span></div>';
                                    }
                                    if($row['invoice_status'] == "1"){
                                        echo '<div class="ribbon-green"><span>Accepted</span></div>'; 
                                    }
                                    if($row['invoice_status'] == "2"){
                                        echo '<div class="ribbon-danger"><span>Rejected</span></div>'; 
                                    }
                                ?>
                                <div class="box-header with-border">
                                    
                                </div>
                                <div class="container">
                                    <div class="row invoice-info">
                                        <?php
                                            $query2 = "SELECT company_name,company_logo,company_address,company_email,company_website FROM tbl_company_detail WHERE status = '1' and user_id = '$uid_inv'";
                                            $res2 = mysqli_query($mysqli,$query2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            $row2 = mysqli_fetch_assoc($res2);
                                            $logo_img =  $row2["company_logo"];
                                            if($logo_img != ""){
                                                $img = '../uploads/logo/'.$logo_img;
                                            }
                                            else{
                                                $img = '../uploads/logo-placeholder.png';
                                            }
                                            ?>
                                        <div class="col-sm-3 invoice-col">
                                            <img src="<?php echo ($img); ?>" style="max-height: 180px;max-width: 180px">
                                        </div>
                                        <div class="col-sm-5 invoice-col">
                                            <address>
                                                <strong><?php echo $row2["company_name"]; ?></strong><br>
                                                <?php 
                                                    if($row2["company_address"] != ""){
                                                        echo nl2br($row2["company_address"]).'<br>';
                                                    }
                                                    if($row2["company_email"] != ""){
                                                        echo '<strong>Email : </strong>'.$row2["company_email"].'<br>';
                                                    }
                                                    if($row2["company_website"] != ""){
                                                        echo '<strong>Website : </strong>'.$row2["company_website"].'<br>';
                                                    }
                                                ?>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col text-right">
                                            <b style="font-size:22px">Invoice</b>
                                        </div>
                                    </div>
                                </div>
                                <hr class="style-eight">
                                <div class="container">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <b style="font-size: 16px">Invoice To </b><br>
                                        </div>
                                        <div class="col-sm-5 invoice-col">
                                            <address>
                                                <strong><?php echo $client_name; ?></strong><br>
                                                <?php
                                                    echo rtrim($row["address"]);
                                                ?>
                                                <?php 
                                                    if($row["phone"] != ""){
                                                        echo '<strong>Phone : </strong>'.$row["phone"].'<br>';
                                                    }
                                                    if($row["email"] != ""){
                                                        echo '<strong>Email : </strong>'.$row["email"];
                                                    }
                                                ?>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col text-right" style="">
                                            <b style="font-size: 18px">Invoice No. :  #<?php echo $id; ?> </b><br>
                                            <b>Invoice Date : </b> <?php echo date($data["date_format"],strtotime($row["invoice_date"])); ?> <br>
                                            <b>Invoice Date: </b> <?php echo date($data["date_format"],strtotime($row["invoice_due_date"]));?><br>
                                        </div>
                                    </div>
                                    <div style="padding-bottom: 25px;padding-top: 20px">
                                        <table class=" table-stripped table-hover custom-border"  >
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Attribute</th>
                                                <th>Condition</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Tax Rate</th>
                                                <th>Tax</th>  
                                                <th>Total</th>
                                            </tr>
                                            <?php
                                            $final_total = "0.00";
                                            $select_ei = "SELECT tei.*,tp.product_name as pname,ts.service_name as sname,ttr.tax_rate as taxrate_id,type.measurement_type as t_measurement,m.measurement_name FROM tbl_invoice_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_measurement_type type ON type.id = tei.measurement_type LEFT JOIN tbl_measurement m ON m.id = tei.measurement LEFT JOIN tbl_service ts ON ts.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.invoice_id = '$id'";
                                            $query_ei = mysqli_query($mysqli,$select_ei) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            $num_ei = mysqli_num_rows($query_ei);
                                            if($num_ei > 0){
                                            while($row_ei = mysqli_fetch_assoc($query_ei)){
                                                ?>
                                                <tr>
                                                    <?php if($row_ei["product_detail"]=="Product"){ ?>
                                                        <td><?php echo ($row_ei["product_id"] != "0" ? $row_ei["pname"] : ''); ?></td>
                                                    <?php } ?>
                                                    <?php if($row_ei["product_detail"]=="Service"){ ?>
                                                        <td><?php echo ($row_ei["product_id"] != "0" ? $row_ei["sname"] : ''); ?></td>
                                                    <?php } ?>
                                                    <td><?php echo ($row_ei["product_detail"] != "" ? $row_ei["product_detail"] : "-"); ?></td>
                                                    <td><?php echo ($row_ei["t_measurement"] != "" ? $row_ei["t_measurement"] : "-"); ?></td>
                                                    <td><?php echo ($row_ei["measurement_name"] != "" ? $row_ei["measurement_name"] : "-"); ?></td>
                                                    <td><?php echo ($row_ei["qty"] != "" ? $row_ei["qty"] : "-"); ?></td>
                                                    <td><?php echo $row_ei["unit_price"]; ?></td>
                                                    <td><?php echo ($row_ei["taxrate_id"] != "0" ? ($row_ei["taxrate_id"]) : "0.00") ; ?></td>
                                                    <td><?php echo number_format($row_ei["total_tax"],2); ?></td>
                                                    <td><?php echo number_format($row_ei["total"],2); ?></td>
                                                </tr>
                                                <?php
                                                    $final_total += $row_ei["total"];
                                                }
                                            }
                                            else{
                                                ?>
                                                <td colspan="9" style="text-align: center">No Records Found</td>
                                                <?php 
                                            }
                                                ?>
                                                <tr>
                                                    <td colspan="8" style="text-align: right"><b>Total :</b></td>
                                                    <td colspan=""><?php echo "<b>".number_format($final_total,2)."</b>"; ?></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>



                                    <!--

                                  <h3 class="box-title" style="width: 100%">Invoice
                                  
                                  <div class="btn-group pull-right">
                                    <a href="list_invoice.php"><button class="btn btn-sm bg-blue"><i class="fa fa-arrow-left"></i> Back
                                    </button></a>
                                  </div>
                                  <br></h3>-->
                                
                                <!--
                                <div class="container">
                                    <table class="table table-stripped table-hover" >
                                      <tbody>
                                        <tr>
                                          <td><img src="<?php /*echo ($row2["company_logo"] != ''  ? '../uploads/logo/'.$row2["company_logo"] : '../uploads/logo-placeholder.png'); ?>" height="180px" width="180px"></td>
                                          <td style="text-align: right"><?php echo $row2["company_name"]; ?></td>
                                        </tr>
                                        
                                        <tr>
                                          <td colspan="2"><strong><h3>Invoice #<?php echo $id; ?></strong></h3></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="font-size:14px"><strong>Invoice Date : </strong><?php echo $row["invoice_date"]; ?></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2"><strong>Invoice Due Date : </strong><?php echo $row["invoice_due_date"]; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <br><br>
                                    <div><h4 style="font-size: 25px; font-weight: bold">&nbsp;Invoice to</h4></div>
                                    <div><h5>&nbsp;&nbsp;<?php echo $client_name; ?> </h5></div>
                                    <table class="table table-stripped table-hover">
                                      <tr>
                                        <th>Name</th>
                                        <th>Item</th>
                                        <th>Measurement Type</th>
                                        <th>Measurement</th>
                                        <th>Qty</th>
                                        <th>Tax Rate(%)</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                      </tr>
                                      <?php
                                        $final_total = "0.00";
                                        $select_ei = "SELECT tei.*,tp.product_name as pname,ts.service_name as sname,ttr.tax_rate as taxrate_id,type.measurement_type as t_measurement,m.measurement_name FROM tbl_invoice_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_measurement_type type ON type.id = tei.measurement_type LEFT JOIN tbl_measurement m ON m.id = tei.measurement LEFT JOIN tbl_service ts ON ts.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.invoice_id = '$id'";
                                        $query_ei = mysqli_query($mysqli,$select_ei) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                        while($row_ei = mysqli_fetch_assoc($query_ei)){
                                          ?>
                                          <tr>
                                            <?php if($row_ei["product_detail"]=="Product"){ ?>
                                              <td><?php echo ($row_ei["product_id"] != "0" ? $row_ei["pname"] : ''); ?></td>
                                            <?php } ?>
                                            <?php if($row_ei["product_detail"]=="Service"){ ?>
                                              <td><?php echo ($row_ei["product_id"] != "0" ? $row_ei["sname"] : ''); ?></td>
                                            <?php } ?>
                                            <td><?php echo ($row_ei["product_detail"] != "" ? $row_ei["product_detail"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["t_measurement"] != "" ? $row_ei["t_measurement"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["measurement_name"] != "" ? $row_ei["measurement_name"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["qty"] != "" ? $row_ei["qty"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["taxrate_id"] != "0" ? round($row_ei["taxrate_id"],0) : "0.00") ; ?></td>
                                            <td><?php echo $row_ei["unit_price"]; ?></td>
                                            <td><?php echo number_format($row_ei["total_tax"],2); ?></td>
                                            <td><?php echo number_format($row_ei["total"],2); ?></td>
                                          </tr>
                                          <?php
                                          $final_total += $row_ei["total"];
                                        }
                                        ?>
                                        <tr>
                                          <td colspan="8" style="text-align: right"><b>Total :</b></td>
                                          <td colspan=""><?php echo "<b>".number_format($final_total,2)."</b>"; */ ?></td>
                                        </tr>
                                    </table>
                                </div>-->
                              
            
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
            $(document).on('click','.btndeleteselected',function () {
                if (confirmDelete()) {
                    var id = $(this).attr('value');
                    $.ajax({
                        url: "ajax/invoice.php",
                        type: "POST",
                        data: {id:id, cmd:"DeleteInvoice"},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_invoice.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_invoice.php?status="+(data.status);
                            }
                        }   
                    });
                } 
            });
            function confirmDelete() {
                return confirm("Are you sure to delete selected invoice?");
            }
        </script>
    </body>
</html>