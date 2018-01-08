<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["WID"]);
    //echo $id; die;
    $query = "SELECT two.*,tu.first_name,tu.last_name FROM tbl_work_order two LEFT JOIN tbl_user tu ON tu.id = two.customer_id WHERE two.id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_wo = $_SESSION["user_id"];
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
                        <li class="active">Work Order Detail</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-6">
                          <div class="box box-info" style="min-height: 550px">
                            <div class="box-header with-border">
                              <h3 class="box-title" style="width: 100%"><?php echo $row["work_order_name"]; ?> <a href=work_order.php?EID=<?php echo encrypt($row['id']); ?>"> <button class="btn btn-sm btn-info pull-right"><i class="fa fa-edit"></i> &nbsp;Edit Work Order</button> </a><a href="view_project.php?VID=<?php echo encrypt($row['project_id']); ?>"><button style="margin-right: 10px" class="btn bg-olive btn-sm pull-right"><i class="fa fa-arrow-left"></i> &nbsp;Back</button></a><br><?php if($row["photo_path"] != ""){echo '<br><center><a data-fancybox="gallery" href="../uploads/WorkOrder/'.$row["photo_path"].'"><img src="../uploads/WorkOrder/'.$row["photo_path"].'" /></a></center>';}?></h3>
                            </div>
                            <div class="box-body">
                              <table class="table table-stripped table-hover">
                                <tbody>
                                  <tr>
                                    <th>Project No.</th>
                                    <td><?php echo "PJ".Series1000($row["project_id"]); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Customer</th>
                                    <td><?php echo $row["first_name"]." ".$row["last_name"]; ?></td>
                                  </tr>
                                  <tr>
                                    <th>Type</th>
                                    <td>
                                        <?php echo $row["category_type"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Category</th>
                                    <td>
                                        <?php 
                                          if($row["category_type"] == "Product"){
                                            $query_cat = "SELECT id,category_name FROM tbl_category WHERE add_uid = '$uid_wo' AND status = '1' AND id = '".$row["category_id"]."'";
                                          }
                                          else{
                                            $query_cat = "SELECT id,category_name FROM tbl_service_category WHERE add_uid = '$uid_wo' AND status = '1' AND id = '".$row["category_id"]."'";
                                          }
                                          $res_cat = mysqli_query($mysqli,$query_cat) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                          $row_cat = mysqli_fetch_assoc($res_cat);
                                          echo $row_cat["category_name"];
                                        ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Model</th>
                                    <td>
                                        <?php echo $row["model"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Serial Number</th>
                                    <td>
                                        <?php echo $row["serial_no"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Expected Fix Date </th>
                                    <td>
                                        <?php echo $row["expected_fix_date"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>SMS Status </th>
                                    <td>
                                        <?php echo $row["send_sms"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Mail Status</th>
                                    <td>
                                        <?php echo $row["send_email"]; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php 
                                          if($row["order_status"] == "0"){ echo '<label class="label label-warning">Pending</label>';}
                                          if($row["order_status"] == "1"){ echo '<label class="label label-success">Accept</label>';}
                                          if($row["order_status"] == "2"){ echo '<label class="label label-danger">Reject</label>';}
                                        ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- Col-md-6-complete -->
                        <div class="col-md-6">
                          <div class="box box-info" style="min-height: 150px">
                            <div class="box-body">
                              <table class="table table-stripped table-hover">
                                <tbody>
                                  <tr>
                                    <td><strong>Problems</strong></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo ($row["problem"] != "" ? $row["problem"] : " - "); ?></td>
                                  </tr>                                   
                                </tbody>
                              </table>                              
                            </div>
                          </div>
                        </div>
                         <!-- Col-md-6-complete -->
                         <!-- Col-md-6-complete -->
                        <div class="col-md-6">
                          <div class="box box-info" style="min-height: 150px">
                            <div class="box-body">
                              <table class="table table-stripped table-hover">
                                <tbody>                                   
                                   <tr>
                                    <td><strong>Notes</strong></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo ($row["notes"] != "" ? $row["notes"] : " - "); ?></td>
                                  </tr>
                                </tbody>
                              </table>                              
                            </div>
                          </div>
                        </div>
                         <!-- Col-md-6-complete -->
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
           
        </script>
    </body>
</html>