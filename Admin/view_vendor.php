<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["VID"]);
    $query = "SELECT * FROM tbl_vendor WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
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
        <style type="text/css">
            img {
                height: 232px;
                width: 205px;
                min-height: 40px;
                vertical-align: middle;
                border: 0;
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
                        <li class="active">Vendor</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-6">
                          <div class="box box-info" style="min-height: 550px">
                            <div class="box-header with-border">
                              <h3 class="box-title" style="width: 100%"><?php echo $row["first_name"]." ".$row["last_name"] ; ?> <a href="vendor.php?VID=<?php echo encrypt($row['id']); ?>"> <button class="btn btn-sm btn-info pull-right"><i class="fa fa-edit"></i> &nbsp;Edit Vendor</button> </a><a href="list_vendor.php"><button style="margin-right: 10px" class="btn bg-olive btn-sm pull-right"><i class="fa fa-arrow-left"></i> &nbsp;Back</button></a><br>
                              <?php if($row["user_image"] != ""){echo '<br><center><a data-fancybox="gallery" href="../uploads/vendor/'.$row["user_image"].'"><img src="../uploads/vendor/'.$row["user_image"].'" /></a></center>';}?></h3>
                            </div>
                            <div class="box-body">
                              <table class="table table-stripped table-hover">
                                <tbody>
                                  <tr>
                                    <td><strong>Phone</strong></td>
                                    <td><?php echo $row["phone"]; ?></td>
                                  </tr>
                                  <tr>
                                    <td><strong>SSN/Tax ID</strong></td>
                                    <td><?php echo $row["tax_id_no"]; ?></td>
                                  </tr>
                                  <tr>
                                    <td><strong>Email</strong></td>
                                    <td><?php echo $row["email"];?></span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><strong>Address</strong></td>
                                    <td><?php echo $row["address"];?></td>
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