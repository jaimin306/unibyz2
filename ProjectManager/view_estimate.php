<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["ESTID"]);
    $uid_estimate = $_SESSION["user_id"];
    $query = "SELECT * FROM tbl_estimate WHERE status = '1' and id = '$id' and customer_id = '$uid_estimate'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $customer_id = $row["customer_id"];
    $query1 = "SELECT first_name,last_name,add_uid FROM tbl_user WHERE status = '1' and id = '$customer_id'";
    $res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row1 = mysqli_fetch_assoc($res1);
    $client_name = $row1["first_name"]." ".$row1["last_name"];
    $admin_id = $row1["add_uid"];
    $uid_est = $_SESSION["user_id"];
    // Selecting The Company Logo 
    $query2 = "SELECT company_name,company_logo FROM tbl_company_detail WHERE status = '1' and user_id = '$admin_id'";
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
                        <li class="active">Estimate</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
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
                              
                                <div class="box-header with-border">
                                  <h3 class="box-title" style="width: 100%;text-align: center;font-weight: bold">Estimate
                                  <div class="btn-group pull-right">
                                    <a href="list_estimate.php"><button class="btn btn-sm bg-blue"><i class="fa fa-arrow-left"></i> Back
                                    </button></a>
                                  </div>
                                  <br></h3>
                                </div>
                                <div class="container">
                                    <table class="table table-stripped table-hover" >
                                      <tbody>
                                        <tr>
                                          <td><img src="<?php echo ($row2["company_logo"] != ''  ? '../uploads/logo/'.$row2["company_logo"] : '../uploads/logo-placeholder.png'); ?>" height="180px" width="180px"></td>
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
                                        $select_ei = "SELECT tei.*,tp.product_name as pname,ttr.tax_rate as taxrate_id FROM tbl_estimate_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.estimate_id = '$id'";
                                        $query_ei = mysqli_query($mysqli,$select_ei) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                        while($row_ei = mysqli_fetch_assoc($query_ei)){
                                          ?>
                                          <tr>
                                            <td><?php echo ($row_ei["product_id"] != "0" ? $row_ei["pname"] : $row_ei["product_detail"]); ?></td>
                                            <td><?php echo ($row_ei["measurement_type"] != "" ? $row_ei["measurement_type"] : "-"); ?></td>
                                            <td><?php echo ($row_ei["measurement"] != "" ? $row_ei["measurement"] : "-"); ?></td>
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
                                          <td colspan="7" style="text-align: right"><b>Total :</b></td>
                                          <td colspan=""><?php echo "<b>".number_format($final_total,2)."</b>"; ?></td>
                                        </tr>
                                    </table>
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
                  var form_data = new FormData(document.getElementById("category_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/category.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_category.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_category.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("category_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/category.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_category.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_category.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            
        </script>
    </body>
</html>