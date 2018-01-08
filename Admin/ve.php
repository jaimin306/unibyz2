<?php
    //include('includes/session.php');
    session_start();
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["ESTID"]);
    $query = "SELECT * FROM tbl_estimate WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $customer_id = $row["customer_id"];
    $query1 = "SELECT first_name,last_name,address,phone,email FROM tbl_user WHERE status = '1' and id = '$customer_id'";
    $res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row1 = mysqli_fetch_assoc($res1);
    $client_name = $row1["first_name"]." ".$row1["last_name"];
    $uid_est = $_SESSION["user_id"];
    // Selecting The Company Logo 
    $query2 = "SELECT company_name,company_logo,company_address,company_email,company_website FROM tbl_company_detail WHERE status = '1' and user_id = '$uid_est'";
    $res2 = mysqli_query($mysqli,$query2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row2 = mysqli_fetch_assoc($res2);
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
            /*border-spacing: 5px;*/
            border-style: solid;
            border-color: #ada8a8;
            width: 100%;
            /*border-collapse: separate;*/
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
        <div id="loadingDivFull" style="display: none;"></div>
        <div class="wrapper">
            <?php include("includes/header.php"); ?>
            <?php include("includes/sidebar.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1> &nbsp;  </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Estimate</li>
                    </ol>
                </section>
                <section class="content" > 
                    <div class="row">
                        <div class="col-md-12" >
                            <div id="result_mail"></div>
                            <div class="box box-info">
                              <div class="box-header with-border">
                                <div class="container">
                                  <div class="row invoice-info">
                                    <div class="col-sm-3 invoice-col">
                                      <b style="font-size: 25px;">Estimate #<?php echo $id; ?> </b>

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-3 invoice-col">
                                      Last Emailed : <?php if($row["notify_email"] != "" && $row["notify_email"] != "0"){ echo '<b>'.$row["notify_email_date"].'</b>';} else{ echo '<b>Never</b>';} ?>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6 invoice-col text-right">
                                      <div class="btn-group pull-right">
                                        <a href="list_estimate.php"><button class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-left"></i> Back </button></a>

                                        <a href="#" data-toggle="tooltip" class="btn btn-sm btn-success" data-original-title="Save PDF" style="margin-right:10px" download><i class="fa fa-file-pdf-o"></i></a>

                                        <a href="#" data-toggle="tooltip" class="btn btn-sm btn-primary" data-original-title="Edit" style="margin-right:10px"><i class="fa fa-edit"></i></a>

                                        <a href="javascript:" data-toggle="tooltip" class="btn btn-sm btn-danger btndeleteselected" data-original-title="Delete" value=<?php echo $id; ?> style="margin-right:10px"><i class="fa fa-trash-o"></i></a>

                                        <a href="#" data-toggle="tooltip" class="btn btn-sm btn-warning" data-original-title="Print" style="margin-right:10px" id="btn"><i class="fa fa-print"></i></a>
                                        <div class="btn-group">
                                          <button class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right:10px"><b>More Actions <span class="caret"></span></b></button>
                                          <ul class="dropdown-menu">
                                            <li>
                                              <a href="javascript:void(0)" title="Email Estimate" onclick="SendEstimateMail(<?php echo $id; ?>)"><i class="fa fa-envelope"></i> Email Estimate</a>
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
                                  if($row['estimate_status'] == "0"){
                                    echo '<div class="ribbon-warning"><span>Pending</span></div>';
                                  }
                                  if($row['estimate_status'] == "1"){
                                   echo '<div class="ribbon-green"><span>Accepted</span></div>'; 
                                  }
                                  if($row['estimate_status'] == "2"){
                                   echo '<div class="ribbon-danger"><span>Rejected</span></div>'; 
                                  }
                                  ?>
                                <div class="box-header with-border"  >
                                  <!--<h3 class="box-title" style="width: 100%;font-weight: bold;text-align: center;">Estimate-->
                                  <!--
                                  <div class="btn-group pull-right">
                                    <a href="list_estimate.php"><button class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-left"></i> Back </button></a>

                                    <a href="#" data-toggle="tooltip" class="btn btn-sm btn-success" data-original-title="Save PDF" style="margin-right:10px" download><i class="fa fa-file-pdf-o"></i></a>

                                    <a href="#" data-toggle="tooltip" class="btn btn-sm btn-primary" data-original-title="Edit" style="margin-right:10px"><i class="fa fa-edit"></i></a>

                                    <a href="javascript:" data-toggle="tooltip" class="btn btn-sm btn-danger btndeleteselected" data-original-title="Delete" value=<?php echo $id; ?> style="margin-right:10px"><i class="fa fa-trash-o"></i></a>

                                    <a href="#" data-toggle="tooltip" class="btn btn-sm btn-warning" data-original-title="Print" style="margin-right:10px" id="btn"><i class="fa fa-print"></i></a>
                                    <div class="btn-group">
                                      <button class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right:10px"><b>More Actions <span class="caret"></span></b></button>
                                      <ul class="dropdown-menu">
                                        <li>
                                          <a href="javascript:void(0)" title="Email Estimate" onclick="SendEstimateMail(<?php echo $id; ?>)"><i class="fa fa-envelope"></i> Email Estimate</a>
                                        </li>
                                        <li>
                                          <a href="#" title="Payment"><i class="fa fa-money"></i> Payment </a>
                                        </li>
                                      </ul>
                                  </div>
                                  </div>-->
                                  <br></h3>
                                </div>
                                <div class="container">
                                  <div class="row invoice-info">
                                    <div class="col-sm-3 invoice-col">
                                      <img src="<?php echo ($row2["company_logo"] != ''  ? '../uploads/logo/'.$row2["company_logo"] : '../uploads/logo-placeholder.png'); ?>" style="max-height: 180px;max-width: 180px">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-5 invoice-col">
                                      <address>
                                        <strong><?php echo $row2["company_name"]; ?></strong><br>
                                        <?php
                                        //echo rtrim($row2["company_address"]);
                                        ?>
                                        <?php 
                                        if($row2["company_address"] != ""){
                                          echo $row2["company_address"].'<br>';
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
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col text-right">
                                      <b style="font-size:22px">Estimate</b>
                                    </div>
                                  </div>
                                </div>
                                <hr class="style-eight">
                                <div class="container">
                                  <div class="row invoice-info">
                                    <div class="col-sm-3 invoice-col">
                                      <b style="font-size: 16px">Estimate To </b><br>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-5 invoice-col">
                                      <address>
                                        <strong><?php echo $client_name; ?></strong><br>
                                        <?php
                                        echo rtrim($row1["address"]);
                                        ?>
                                        <?php 
                                        if($row1["phone"] != ""){
                                          echo '<strong>Phone : </strong>'.$row1["phone"].'<br>';
                                        }
                                        if($row1["email"] != ""){
                                          echo '<strong>Email : </strong>'.$row1["email"];
                                        }
                                        ?>
                                      </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col text-right" style="">
                                      <b style="font-size: 18px">Estimate No. :  #<?php echo $id; ?> </b><br>
                                      <b>Estimate Date : </b> <?php echo $row["estimate_date"]; ?> <br>
                                      <b>Due Date: </b> <?php echo $row["estimate_due_date"]; ?><br>
                                    </div>
                                  </div>
                                  <div style="padding-bottom: 25px;padding-top: 20px">
                                  <table class=" table-stripped table-hover custom-border"  >
                                      <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Measurement Type</th>
                                        <th>Measurement</th>
                                        <th>Qty</th>
                                        <th>Tax Rate</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>  
                                        <th>Total</th>
                                      </tr>
                                      <?php
                                        $final_total = "0.00";
                                        $select_ei = "SELECT tei.*,tp.product_name as pname,ts.service_name as sname,ttr.tax_rate as taxrate_id,type.measurement_type as type_nm,m.measurement_name as measure FROM tbl_estimate_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_measurement_type type ON type.id = tei.measurement_type LEFT JOIN tbl_measurement m ON m.id = tei.measurement LEFT JOIN tbl_service ts ON ts.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.estimate_id = '$id'";
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
                                            <td><?php echo ($row_ei["type_nm"] != "" ? $row_ei["type_nm"] : "-"); ?></td>                                            
                                            <td><?php echo ($row_ei["measure"] != "" ? $row_ei["measure"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["qty"] != "" ? $row_ei["qty"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["taxrate_id"] != "0" ? $row_ei["taxrate_id"] : "0.00") ; ?></td>
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
                                          <td colspan=""><?php echo "<b>".number_format($final_total,2)."</b>"; ?></td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                                <!--
                                <div class="container" id="DivIdToPrint">
                                    <table class="table table-stripped table-hover"  >
                                      <tbody>
                                        <tr>
                                          <td><img src="<?php /* echo ($row2["company_logo"] != ''  ? '../uploads/logo/'.$row2["company_logo"] : '../uploads/logo-placeholder.png'); ?>" height="180px" width="180px"></td>
                                          <td style="text-align: right"><?php echo $row2["company_name"]; ?></td>
                                        </tr>
                                        
                                        <tr>
                                          <td colspan="2"><strong><h3>Estimate #<?php echo $id; ?></strong></h3></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="font-size:14px"><strong>Estimate Date : </strong><?php echo $row["estimate_date"]; ?></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2"><strong>Estimate Due Date : </strong><?php echo $row["estimate_due_date"]; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <br><br>
                                    <div><h4 style="font-size: 25px; font-weight: bold">&nbsp;Estimate to</h4></div>
                                    <div><h5>&nbsp;&nbsp;<?php echo $client_name; ?> </h5></div>
                                    <table class="table table-stripped table-hover">
                                      <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Measurement Type</th>
                                        <th>Measurement</th>
                                        <th>Qty</th>
                                        <th>Tax Rate</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>  
                                        <th>Total</th>
                                      </tr>
                                      <?php
                                        $final_total = "0.00";
                                        $select_ei = "SELECT tei.*,tp.product_name as pname,ts.service_name as sname,ttr.tax_rate as taxrate_id,type.measurement_type as type_nm,m.measurement_name as measure FROM tbl_estimate_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_measurement_type type ON type.id = tei.measurement_type LEFT JOIN tbl_measurement m ON m.id = tei.measurement LEFT JOIN tbl_service ts ON ts.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.estimate_id = '$id'";
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
                                            <td><?php echo ($row_ei["type_nm"] != "" ? $row_ei["type_nm"] : "-"); ?></td>                                            
                                            <td><?php echo ($row_ei["measure"] != "" ? $row_ei["measure"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["qty"] != "" ? $row_ei["qty"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["taxrate_id"] != "0" ? $row_ei["taxrate_id"] : "0.00") ; ?></td>
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
                                          <td colspan=""><?php echo "<b>".number_format($final_total,2)."</b>"; */?></td>
                                        </tr>
                                    </table>
                                </div>-->
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
          $(function () {
            $("#btn").on('click',function () {
                var divContents = $("#DivIdToPrint").html();
                var printWindow = window.open('', '', 'height=800,width=800');
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
            });
            $(document).on('click','.btndeleteselected',function () {
                if (confirmDelete()) {
                  var id = $(this).attr('value');
                  $.ajax({
                      url: "ajax/estimate.php",
                      type: "POST",
                      data: {id:id, cmd:"DeleteEstimate"},
                      dataType:"JSON",
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_estimate.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_estimate.php?status="+(data.status);
                          }
                      }   
                  });
                  } 
              });
          });

          function confirmDelete() {
              return confirm("Are you sure to delete selected files?");
          }
          function SendEstimateMail(estimate_id){
            $("#loadingDivFull").fadeIn( "slow" );
            $.ajax({
                url: "ajax/sendmail.php",
                type: "POST",
                data: {estimate_id:estimate_id, cmd:"SendEstimateCustomer"},
                dataType:"JSON",
                success:function(data){
                    $("#loadingDivFull").fadeOut( "slow" );
                    if(data.result == "true"){
                      $("#result_mail").html('<div class="alert alert-info alert-dismissible"><b><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+(data.msg)+'</b></div>')
                    }
                    else{
                      $("#result_mail").html('<div class="alert alert-danger alert-dismissible"><b><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+(data.msg)+'</b></div>')
                    }
                    
                    $("")
                }   
              });
          }
        </script>
    </body>
</html>