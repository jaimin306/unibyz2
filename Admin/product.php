<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_product WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_product = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Product</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Product</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="product_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="category_id" class="col-md-2 control-label">Category </label>
                                          <div class="col-md-4">
                                            <select name="category_id" id="category_id" onchange="GetProductType(this.value)" class="form-control" style="width: 100%;">
                                              <option value="">Please Select Category</option>
                                              <?php
                                                $query_category = "SELECT id,category_name FROM tbl_category WHERE status = '1' AND add_uid = '$uid_product'";
                                                $res_category = mysqli_query($mysqli,$query_category) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_category = mysqli_fetch_assoc($res_category)){
                                                  ?>
                                                    <option value="<?php echo $row_category['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_category['id'] == $row["category_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_category['category_name']; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                            <div id="hide_spin" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
                                          </div>
                                          <label for="product_type_id" class="col-md-2 control-label">Product Type </label>
                                          <div class="col-md-4">
                                            <select name="product_type_id" id="product_type_id" class="form-control" style="width: 100%;">
                                              <option value="">Please Select Product Type</option>
                                              <?php
                                                if(isset($id) && $id != ""){
                                                  $cid = $row["category_id"];
                                                  $query_product_type = "SELECT id,product_type_name FROM tbl_product_type WHERE status = '1' AND add_uid = '$uid_product' AND category_id = '$cid' ";
                                                  $res_product_type = mysqli_query($mysqli,$query_product_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_product_type = mysqli_fetch_assoc($res_product_type)){
                                                    ?>
                                                      <option value="<?php echo $row_product_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_product_type['id'] == $row["product_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_product_type['product_type_name']; ?></option>
                                                    <?php
                                                  }  
                                                }
                                                
                                              ?>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="product_name" class="control-label col-md-2">Product Name </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="product_name" value="<?php echo (isset($id) ? $row['product_name'] : ''); ?>" name="product_name" placeholder="Enter Product Name Here" >
                                          </div>
                                          <label for="code" class="col-md-2 control-label">Product Code</label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="code" value="<?php echo (isset($id) ? $row['code'] : ''); ?>" name="code" placeholder="Enter Code Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="brand_id" class="col-md-2 control-label">Manufacturer</label>
                                          <div class="col-md-4">
                                           <select name="brand_id" id="brand_id"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Manufacturer</option>
                                              <?php                                                    
                                                  $query_product_brand = "SELECT id,brand_name FROM tbl_brand WHERE status = '1' AND add_uid = '$uid_product'";
                                                  $res_product_brand = mysqli_query($mysqli,$query_product_brand) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_product_brand = mysqli_fetch_assoc($res_product_brand)){
                                                    ?>
                                                      <option value="<?php echo $row_product_brand['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_product_brand['id'] == $row["brand_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_product_brand['brand_name']; ?></option>
                                                    <?php
                                                  } 
                                              ?>
                                            </select> 
                                          </div>

                                          <label for="vendor_id" class="col-md-2 control-label">Vendor</label>
                                          <div class="col-md-4">
                                           <select name="vendor_id" id="vendor_id"  class="form-control" style="width: 100%;">
                                              <option value="">Please Select Vendor</option>
                                              <?php                                                    
                                                  $query_product_vendor = "SELECT id,first_name,last_name FROM tbl_vendor WHERE user_status = '1' AND add_uid = '$uid_product'";
                                                  $res_product_vendor = mysqli_query($mysqli,$query_product_vendor) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_product_vendor = mysqli_fetch_assoc($res_product_vendor)){
                                                    ?>
                                                      <option value="<?php echo $row_product_vendor['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_product_vendor['id'] == $row["vendor_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_product_vendor['first_name'].' '.$row_product_vendor['last_name']; ?></option>
                                                    <?php
                                                  } 
                                              ?>
                                            </select> 
                                          </div>
                                          
                                        </div>
                                        <div class="form-group">
                                          <label for="purchase_price" class="col-md-2 control-label">Purchase Price </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control number" id="purchase_price" value="<?php echo (isset($id) ? $row['purchase_price'] : ''); ?>" name="purchase_price" placeholder="Enter Purchase Price Here" >
                                          </div>
                                          <label for="sales_price" class="col-md-2 control-label">Sales Price </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control number" id="sales_price" value="<?php echo (isset($id) ? $row['sales_price'] : ''); ?>" name="sales_price" placeholder="Enter Sales Price Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="measurement" class="col-md-2 control-label">Attribute</label>
                                          <div class="col-md-4">
                                             <select name="measurement_type_id" id="measurement_type"  class="form-control" style="width: 100%;" onchange="GetProductMeasurement(this.value)">
                                              <option value="">Select Attribute </option>
                                              <?php                                                    
                                                  $query_m_type = "SELECT * FROM tbl_measurement_type WHERE status = '1' AND add_uid = '$uid_product' AND type='Product'";
                                                  $res_m_type = mysqli_query($mysqli,$query_m_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_m_type = mysqli_fetch_assoc($res_m_type)){
                                                    ?>
                                                      <option value="<?php echo $row_m_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_m_type['id'] == $row["measurement_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_m_type['measurement_type']; ?></option>
                                                    <?php
                                                  } 
                                              ?>
                                            </select> 
                                          </div>   
                                          <label for="measurement" class="col-md-2 control-label">Condition</label>
                                          <div class="col-md-4">                                            
                                            <select name="measurement_id" id="measurement"  class="form-control" style="width: 100%;">
                                              <option value="">Select Condition</option>    
                                              <?php   
                                                if(isset($row["measurement_type_id"]) && $row["measurement_type_id"] != 0){                                                 
                                                  $query_m_type = "SELECT * FROM tbl_measurement WHERE status = '1' AND add_uid = '$uid_product' AND measurement_type_id='$row[measurement_type_id]'";
                                                  $res_m_type = mysqli_query($mysqli,$query_m_type) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($row_m_type = mysqli_fetch_assoc($res_m_type)){
                                                    ?>
                                                      <option value="<?php echo $row_m_type['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_m_type['id'] == $row["measurement_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_m_type['measurement_name']; ?></option>
                                                    <?php
                                                  } 
                                                }
                                              ?>                                           
                                            </select> 
                                          </div>                                
                                        </div>
                                        <div class="form-group">
                                          <label for="quantity" class="col-md-2 control-label">In Stock</label>
                                          <div class="col-md-4">
                                            <input type="number" class="form-control" id="quantity" value="<?php echo (isset($id) ? $row['quantity'] : ''); ?>" name="quantity" placeholder="Enter Stock Here"  >  
                                          </div> 
                                          <label for="classification" class="col-md-2 control-label">Classification </label>
                                          <div class="col-md-4">
                                            <select name="classification" id="classification"  class="form-control" style="width: 100%;">
                                              <option value="">Select Classification</option>    
                                              <option value="Reusable" <?php if(isset($id) && $id != ""){ echo ($row['classification'] == "Reusable" ) ? "selected='selected'" : "";} ?>>Reusable</option>
                                              <option value="Perishable" <?php if(isset($id) && $id != ""){ echo ($row['classification'] == "Perishable") ? "selected='selected'" : "";} ?>>Perishable</option>
                                            </select> 
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="photo_path" class="col-md-2 control-label">Photo </label>
                                          <div class="col-md-4">

                                            <input type="file" class="form-control"  id="photo_path" name="photo_path" >
                                            <input type="hidden" name="hidden_photo_path" value="<?php echo (isset($id) ? $row['photo_path'] : ''); ?>">
                                          </div>
                                          
                                        </div>
                                        <div class="form-group">
                                          <label for="description" class="col-md-2 control-label">Description </label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="description"  placeholder="Enter Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['description'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="notes" class="col-md-2 control-label">Notes</label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if(isset($id) && $id != "" ){
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Update</button>';
                                        }
                                        else{
                                          echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Save</button>';
                                        }
                                        ?>
                                      </div>
                                    </form>
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
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function () {
              $('.textarea').wysihtml5();
              $('#category_id').select2();
              $('#product_type_id').select2();
              DecimalOnly();
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("product_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/product.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_product.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_product.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("product_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/product.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_product.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_product.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function GetProductType(cid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/product.php",
                  type: "POST",
                  data: {cid:cid,cmd:"GetProductType"},
                  dataType:"JSON",
                  success:function(data){
                      $("#product_type_id").html(data.string);
                      $("#hide_spin").hide();
                  }   
              });
            }

            function GetProductMeasurement(mid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/product.php",
                  type: "POST",
                  data: {mid:mid,cmd:"GetProductMeasurement"},
                  dataType:"JSON",
                  success:function(data){
                      $("#measurement").html(data.string);
                      $("#hide_spin").hide();
                  }   
              });
            }
            
        </script>
    </body>
</html>