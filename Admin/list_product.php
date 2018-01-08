<?php
include ("includes/session.php");
include ("../dbConnect.php");
include ("includes/general.php");
if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Product Added Successfully';
              break;
          case 'usuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Product Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Product Deleted Successfully';
              break;
          case 'uqsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Product Stock Updated Successfully';
              break;
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Adding Product... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
      }
  }
  $uid_product = $_SESSION["user_id"];
  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include "includes/links.php";?>
        <link rel="stylesheet" type="text/css" href="../dist/css/jquery.fancybox.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include "includes/header.php";?>
            <?php include "includes/sidebar.php";?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1> &nbsp;  </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Product</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">All Product</h3>
                              <a href="product.php"><button class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp; Add Product</button></a>
                            </div>
                            <div class="container">
                              <?php if (!empty($statusMsg)) {
                                echo '<div class="alert ' . $statusMsgClass . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $statusMsg . '</div>';
                              }
                              ?>
                              <div class="box-body">
                                <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th >No.</th>
                                      <th >Category</th>
                                      <th >Product Type</th>
                                      <th >Name</th>
                                      <th >Code</th>
                                      <th >Manufacturer</th>
                                      <th >Vendor</th>
                                      <th >Purchase Price</th>
                                      <th >Sale Price</th>
                                      <th >In Stock</th>
                                      <!-- <th >Description</th> -->
                                      <th >Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $query = "SELECT tp.*,tc.category_name as category_id,tpt.product_type_name as product_type_id,tb.brand_name,tv.first_name,tv.last_name FROM tbl_product tp LEFT JOIN tbl_category tc ON tc.id = tp.category_id LEFT JOIN tbl_product_type tpt ON tpt.id = tp.product_type_id LEFT JOIN tbl_brand as tb on tb.id=tp.brand_id LEFT JOIN tbl_vendor as tv on tv.id=tp.vendor_id WHERE tp.status = '1' AND tp.add_uid = '$uid_product'";
                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                      $num_rows = mysqli_num_rows($res);
                                      if($num_rows > 0){
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($res)){
                                          ?>
                                            <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row["category_id"]; ?></td>
                                              <td><?php echo $row["product_type_id"]; ?></td>
                                              <td><?php echo $row["product_name"]; if($row["photo_path"] != ""){echo '<br><a data-fancybox="gallery" href="../uploads/product/'.$row["photo_path"].'"><img src="../uploads/product/'.$row["photo_path"].'" height="70px" width="85%"/></a>';}?></td>
                                              <td><?php echo $row["code"]; ?></td>
                                              <td><?php echo $row["brand_name"]; ?></td>
                                              <td><?php echo $row["first_name"].' '.$row["last_name"]; ?></td>
                                              <td><?php echo $row["purchase_price"]; ?></td>
                                              <td><?php echo $row["sales_price"]; ?></td>
                                              <td><?php echo '<span class="label label-success" style="font-size:12px">'.$row["quantity"].'</span>'; ?></td>
                                              <!-- <td><?php echo $row["description"]; ?></td>-->
                                              <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info btn-sm"><b>Choose</b></button>
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a data-qty="<?php echo ($row['quantity']); ?>" data-hideid="<?php echo ($row['id']); ?>" data-toggle="modal" data-target="#qty"><i class="fa fa-sort-numeric-asc" ></i> &nbsp;Update Stock</a></li>
                                                      <li><a href="product.php?EID=<?php echo encrypt($row['id']); ?>"><i class="fa fa-edit" ></i> &nbsp;Edit</a></li>
                                                      <li><a href="javascript:void(0)" value="<?php echo $row['id']; ?>" class="btndeleteselected"><i class="fa fa-trash" ></i> &nbsp;Delete</a></li>
                                                    </ul>
                                                </div>
                                              </td>
                                            </tr>
                                          <?php  
                                          $i++;
                                        }                          
                                      }
                                      ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="qty" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Update Stock</h4>
                            </div>
                            <form method="post">
                            <div class="modal-body">
                              <p><b>Stock</b></p>
                              <input type="text" id="update_quantity" class="form-control" name="update_quantity" required="required">
                              <input type="hidden" id="hidden_id_qty" class="form-control" name="hidden_id_qty" >
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="up_qty">Submit</button>
                            </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include "includes/footer.php";?>
            <?php include "includes/nav-sidebar.php";?>
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
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script> 
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/jquery.fancybox.min.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script >
            $(function () {
                $('#datatable').DataTable({
                  "bAutoWidth": false,
                  "aoColumns": [
                    { sWidth: '4%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '9%' },
                    { sWidth: '9%' },
                    { sWidth: '9%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' },
                    { sWidth: '9%' },
                    { sWidth: '10%' }]
                });
                $('.image-popup-no-margins').magnificPopup({
                  type: 'image',
                  closeOnContentClick: true,
                  closeBtnInside: false,
                  fixedContentPos: true,
                  mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                  image: {
                    verticalFit: true
                  },
                  zoom: {
                    enabled: true,
                    duration: 300 // don't foget to change the duration also in CSS
                  }
                });
                $('#qty').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget);
                  var url = button.data('href');
                  var qty = button.data('qty');
                  var id = button.data('hideid');
                  var modal = $(this);
                  modal.find('#update_quantity').val(qty);
                  modal.find('#hidden_id_qty').val(id);
                });
                $( "#up_qty" ).on( "click", function() {
                  var uq = $("#update_quantity").val(); 
                  var hide_id = $("#hidden_id_qty").val(); 
                  if(uq != "" && hide_id != ""){
                    $.ajax({
                        url: "ajax/product.php",
                        type: "POST",
                        data: {id:hide_id, cmd:"update_qty",update_quanty:uq},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                window.location.href="list_product.php?status="+(data.status);
                            }
                            else{
                                window.location.href="list_product.php?status="+(data.status);
                            }
                        }   
                    });
                  }
                  else{
                    alert("Please Enter Quantity");
                  }
                });
                $(document).on('click','.btndeleteselected',function () {
                    if (confirmDelete()) {
                      var id = $(this).attr('value');
                      $.ajax({
                          url: "ajax/product.php",
                          type: "POST",
                          data: {id:id, cmd:"delete"},
                          dataType:"JSON",
                          success:function(data){
                              if(data.result == "true"){
                                  window.location.href="list_product.php?status="+(data.status);
                              }
                              else{
                                  window.location.href="list_product.php?status="+(data.status);
                              }
                          }   
                      });
                      } 
                  });
              });
              function confirmDelete() {
                return confirm("Are you sure to delete selected files?");
              }
        </script>
    </body>
</html>