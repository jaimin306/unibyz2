<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_estimate WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_estimate = $_SESSION["user_id"];
    $notify_client = isset($id) ? $row["notify_client"] : '';

    $edit_cid = $row["customer_id"]; 
    $query_customer = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' and id = '$cid' || id = '$edit_cid'";
    $res_customer = mysqli_query($mysqli,$query_customer) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row_customer = mysqli_fetch_assoc($res_customer);
    $cust_name = $row_customer["first_name"]." ".$row_customer["last_name"];
    

    if (!empty($_GET['status'])) {
      switch ($_GET['status']) {
          case 'success':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Estimate Added Successfully';
              break;
          case 'upsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Estimate Updated Successfully';
              break;
          case 'dsuccess':
              $statusMsgClass = 'alert-success';
              $statusMsg      = 'Estimate  Deleted Successfully';
              break;
          case 'error':
              $statusMsgClass = 'alert-danger';
              $statusMsg      = 'Error In Estimate ... Please Try Again';
              break;
          default:
              $statusMsgClass = '';
              $statusMsg      = '';
        }
    }
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
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Estimate</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!empty($statusMsg)) {
                                echo '<div class="alert ' . $statusMsgClass . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $statusMsg . '</div>';
                            }
                            ?>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Estimate</h3>
                                </div>
                                <div class="container">
                                    <form method="POST" id="estimate_form" action="#" onsubmit="return submitForm();" >
                                        <div class="form-group">
                                            <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="customer_id" value="<?php echo (isset($id) ? $cust_name : ''); ?>" name="customer_id" placeholder="Enter Customer Name Here" required="required" readonly>
                                            <input type="hidden" name="customer_id_value" value="<?php echo $row["customer_id"]; ?>">
                                            <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="work_order_id">Work Order <span class="text-danger">*</span></label>
                                            <select class="form-control" name="work_order_id" id="work_order_id">
                                                <option value="">Please Select Work Order</option>
                                                <?php 
                                                    $query_wo = "SELECT id,work_order_name FROM tbl_work_order WHERE status = '1' AND customer_id = '$cid' || customer_id = '$edit_cid'";
                                                    $res_wo = mysqli_query($mysqli,$query_wo) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_wo = mysqli_fetch_assoc($res_wo)){
                                                      ?>
                                                        <option value="<?php echo $row_wo['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_wo['id'] == $row["work_order_id"]) ? "selected='selected'" : "";} ?> ><?php echo $row_wo['work_order_name']; ?></option>
                                                       <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="estimate_date">Estimate Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="estimate_date" value="<?php echo (isset($id) ? $row['estimate_date'] : ''); ?>" name="estimate_date" placeholder="Enter Estimate Date Here" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="estimate_due_date">Estimate Due Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="estimate_due_date" value="<?php echo (isset($id) ? $row['estimate_due_date'] : ''); ?>" name="estimate_due_date" placeholder="Enter Quotation Due Date Here" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="notify_client">Notify Client <span class="text-danger">*</span></label>
                                            <select name="notify_client" id="notify_client" class="form-control">
                                                <option value="Yes" <?php echo ($notify_client == "Yes" ? "selected='selected'" : ''); ?>>Yes</option>
                                                <option value="No" <?php echo ($notify_client == "No" ? "selected='selected'" : ''); ?>>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes">Notes </label>
                                            <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                        <div id="replace_div">
                                            <table class="table table-stripped table-hover" id="tbl_est">
                                                <tr>
                                                    <th>Select</th>
                                                    <th>Product</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Tax Rate</th>
                                                    <th>Unit Price</th>
                                                    <th>Tax</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php
                                                $i = 0;
                                                $sel = "SELECT * FROM tbl_estimate_item WHERE status = '1' AND estimate_id = '$id'";
                                                $res_sel = mysqli_query($mysqli,$sel) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_sel = mysqli_fetch_assoc($res_sel)){
                                                        
                                                        ?>
                                                        <tr id="main_<?php echo $i; ?>">
                                                            <td style="width:100px">
                                                                <input type="hidden" id="edit_hidden_estimate_id" value="<?php echo $row_sel["id"]?>" name="edit_hidden_estimate_id[]">
                                                                <select name="sel" onchange="SetProduct(this.value,<?php echo $i ?>)" class="form-control">
                                                                    <option value="">Please Select</option>
                                                                    <option value="Product" <?php echo ($row_sel["product_id"] != "0" ? 'selected=selected' : ''); ?>>Product</option>
                                                                    <option value="Service" <?php echo ($row_sel["product_detail"] != "" ? 'selected=selected' : ''); ?>>Service</option>
                                                                </select>
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input type="text" class="form-control pdetail_<?php echo $i ?>" id="product_detail" name="product_detail[]" value="<?php echo $row_sel['product_detail']; ?>" placeholder="Enter Name" <?php if($row_sel["product_detail"] == ""){ echo 'style="display: none"';}?>>
                                                                <select class="form-control pid_<?php echo $i; ?>" name="product_id[]" id="product_id_<?php echo $i ?>" onchange="GetQuantity(this.value,<?php echo $i ?>)"  <?php if($row_sel["product_detail"] != ""){ echo 'style="display: none"';}?>>
                                                                    <option value="">Please Select</option>
                                                                    <?php 
                                                                        $query_product = "SELECT id,product_name FROM tbl_product WHERE status = '1' AND add_uid = '$uid_estimate'";
                                                                        $res_product = mysqli_query($mysqli,$query_product) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                                        while($row_product = mysqli_fetch_assoc($res_product)){
                                                                          ?>
                                                                    <option value="<?php echo $row_product['id']; ?>" <?php echo ($row_sel["product_id"] == $row_product["id"] ? 'selected=selected' : ''); ?> ><?php echo $row_product['product_name']; ?></option>
                                                                    <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="item[]" placeholder="Enter Item Name" value="<?php echo $row_sel["item"]; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="description[]" placeholder="Enter Item Description" value="<?php echo $row_sel["description"]; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" value="<?php echo $row_sel['qty']; ?>" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Enter Item Quantity" required="required" autocomplete="off" onkeyup="ChangePrice(<?php echo $i; ?>)"  <?php if($row_sel["qty"] == ""){ echo 'readonly';}; ?>><span class="qty_check_<?php echo $i; ?>"></span>
                                                                <?php
                                                                // SELECT Origional Product Quantity
                                                                $p = $row_sel["product_id"];
                                                                if($p != "" && $p != "0"){
                                                                    $s = "SELECT quantity FROm tbl_product WHERE id = '$p'";
                                                                    $q = mysqli_query($mysqli,$s);
                                                                    $r = mysqli_fetch_assoc($q);
                                                                    $rqty = $r["quantity"];
                                                                }
                                                                ?>
                                                                <input type="hidden" id="hidden_qty_<?php echo $i; ?>" value="<?php echo ($rqty + $row_sel['qty']); ?>";  >
                                                            </td>
                                                            <td>
                                                                <select class="form-control changeprice" name="taxrate_id[]" id="taxrate_id_<?php echo $i ?>" onchange="ChangePrice(<?php echo $i ?>)" >
                                                                    <option value="">None</option>
                                                                    <?php 
                                                                        $query_tax = "SELECT id,tax_name,tax_rate FROM tbl_taxrate WHERE status = '1' AND add_uid = '$uid_estimate'";
                                                                        $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                                        while($row_tax = mysqli_fetch_assoc($res_tax)){
                                                                          ?>
                                                                        <option value="<?php echo $row_tax['id']; ?>" <?php echo ($row_sel["taxrate_id"] == $row_tax["id"] ? 'selected=selected' : ''); ?> ><?php echo $row_tax['tax_name']."-".$row_tax['tax_rate']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control " name="unit_price[]" id="unit_price_<?php echo $i ?>" placeholder="Enter Unit Price" required="required" onkeyup="ChangePrice(<?php echo $i ?>)" value="<?php echo $row_sel["unit_price"]; ?>">
                                                            </td>
                                                            <td style="width:100px">
                                                                <input type="text" class="form-control" id="total_tax_<?php echo $i ?>" name="total_tax[]" placeholder="Enter Tax" required="required" value="<?php echo $row_sel["total_tax"]; ?>" readonly>
                                                            </td>
                                                            <td style="width:150px">
                                                                <input type="text" class="form-control"  id="total_t_<?php echo $i ?>" name="total[]" value="<?php echo $row_sel["total"]; ?>" placeholder="Enter Total" required="required" readonly>
                                                            </td>
                                                            <td style="width:50px">
                                                                <?php
                                                                if($i == 0){
                                                                    echo '<button class="btn btn-success" type="button" onclick="AddBtn()">+</button>';
                                                                }
                                                                else{
                                                                    echo '<button class="btn btn-danger" type="button" onclick="RemoveBtn('.$i.')">-</button>';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                ?>
                                                
                                            </table>
                                        </div>
                                        </div>
                                        <div class="box-footer">
                                            <?php
                                                if(isset($id) && $id != "" ){
                                                  echo '<button type="submit" id="btn_submit" class="btn btn-primary">Update</button>';
                                                }
                                                else{
                                                  echo '<button type="submit" class="btn btn-primary" id="btn_submit">Save</button>';
                                                }
                                                ?>
                                        </div>
                                        <?php
                                            $TaxString = "";
                                              $query_tax = "SELECT id,tax_name,tax_rate FROM tbl_taxrate WHERE status = '1' AND add_uid = '$uid_estimate'";
                                              $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                              while($row_tax = mysqli_fetch_assoc($res_tax)){
                                                $TaxString .= '<option value="'.$row_tax["id"].'">'.$row_tax["tax_name"]."-".$row_tax['tax_rate'].'</option>';
                                              }
                                            ?>
                                        <?php 
                                            $query_product = "SELECT id,product_name FROM tbl_product WHERE status = '1' AND add_uid = '$uid_estimate'";
                                            $res_product = mysqli_query($mysqli,$query_product) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            while($row_product = mysqli_fetch_assoc($res_product)){
                                                $PSTring .= '<option value="'.$row_product["id"].'">'.$row_product["product_name"].'</option>';
                                            }
                                            ?>
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
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.textarea').wysihtml5();
                $('#estimate_date').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                });
                $('#estimate_due_date').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                });
                $('#work_order_id').select2();
            });
            var i = <?php echo $i; ?>;
            function AddBtn(){
            var str = '<tr id="main_'+i+'"><td style="width:100px"><input type="hidden" value="" name="edit_hidden_estimate_id[]"><select name="sel" onchange="SetProduct(this.value,'+i+')" class="form-control"><option value="">Please Select</option><option value="Product">Product</option><option value="Service">Service</option></select></td><td><input type="text" class="form-control pdetail_'+i+'" id="product_detail" name="product_detail[]" placeholder="Enter Name"><select class="form-control pid_'+i+'" name="product_id[]" id="product_id" onchange="GetQuantity(this.value,'+i+')" style="display: none"><option value="">Please Select</option><?php echo $PSTring; ?></select></td><td><input type="text" class="form-control" name="item[]" placeholder="Enter Item Name" ></td><td><input type="text" class="form-control" name="description[]" placeholder="Enter Item Description"></td><td><input type="number" class="form-control" onkeyup="ChangePrice('+i+')" name="qty[]" id="qty_'+i+'" placeholder="Enter Item Quantity" required="required" autocomplete="off"><span class="qty_check_'+i+'"></span><input type="hidden" id="hidden_qty_'+i+'" ></td><td><select class="form-control" name="taxrate_id[]" id="taxrate_id_'+i+'" onchange="ChangePrice('+i+')" ><option value="">None</option><?php echo $TaxString; ?></select></td><td><input type="text" class="form-control" name="unit_price[]" onkeyup="ChangePrice('+i+')" id="unit_price_'+i+'" placeholder="Enter Unit Price" required="required"></td><td style="width:100px"><input type="text" class="form-control" placeholder="Enter Tax" name="total_tax[]" id="total_tax_'+i+'" required="required" readonly></td><td style="width:150px"><input type="text" class="form-control"  id="total_t_'+i+'" placeholder="Enter Total" name="total[]" required="required" readonly></td><td style="width:50px"><button class="btn btn-danger" type="button" onclick="RemoveBtn('+i+')">-</button></td></tr>';
                $("#tbl_est tr:last").after(str);
                i++;
            }
            function RemoveBtn(divid){
                $("#main_"+divid).remove();
            }
            function SetProduct(val,did){
                if(val == "Product"){
                  $(".pdetail_"+did).css("display","none");
                  $(".pid_"+did).css("display","block");
                  $("#qty_"+did).removeAttr("readonly");
                }
                else{
                  // $("#check_qty_filed").val("");
                  $(".pdetail_"+did).css("display","block");
                  $(".pid_"+did).css("display","none");
                  $("#qty_"+did).attr("readonly","readonly");
                  $("#qty_"+did).val("");
                  $(".pid_"+did).val("");
                  $(".qty_check_"+did).text("");
                  $("#taxrate_id_"+did).val("");
                  $("#unit_price_"+did).val("");
                  $("#total_t_"+did).val("");
                  $("#total_tax_"+did).val("");
                  $("#hidden_qty_"+did).val("");
                }
            }
            function ChangePrice(id){
                var qty1 = $("#qty_"+id).val();
                var hidden_qty1 = $("#hidden_qty_"+id).val();
                var qty = parseInt(qty1);
                var hidden_qty = parseInt(hidden_qty1);
                // Call When Select Product From List
                if(hidden_qty1 != ""){
                    if(qty > hidden_qty){
                        $("#btn_submit").attr("disabled","disabled");
                        $(".qty_check_"+id).html("Available : "+hidden_qty);
                        $(".qty_check_"+id).css("color","red");
                    }
                    else{
                        $("#btn_submit").removeAttr("disabled");
                        $(".qty_check_"+id).html("");
                        var unit_price = $("#unit_price_"+id).val();
                        if($("#taxrate_id_"+id).val() != ""){
                            var str = $("#taxrate_id_"+id+" option:selected").html();
                            var arr = str.split("-");
                            total_tax = arr[1];  
                        }
                        else{
                            total_tax = "0.00";
                        }
                        if(qty > 0 && unit_price > 0){
                            var t = (parseFloat(qty) * parseFloat(unit_price)).toFixed(2);
                            total_tax_value = ((parseFloat(t) * parseFloat(total_tax)) / 100).toFixed(2);

                            $("#total_tax_"+id).val(total_tax_value);
                            var tot = ((parseFloat(qty) * parseFloat(unit_price))).toFixed(2);
                            $("#total_t_"+id).val(parseFloat(parseFloat(tot) + parseFloat(total_tax_value)).toFixed(2));
                        }
                        else{
                            $("#total_t_"+id).val("0.00");
                            $("#total_tax_"+id).val("0.00");
                        }
                    }
                }
                // Call When Serice Call
                else{
                    var unit_price = $("#unit_price_"+id).val();
                    if($("#taxrate_id_"+id).val() != ""){
                        var str = $("#taxrate_id_"+id+" option:selected").html();
                        var arr = str.split("-");
                        total_tax = arr[1];  
                    }
                    else{
                        total_tax = "0.00";
                    }
                    if(unit_price > 0){
                        var t = (parseFloat(unit_price)).toFixed(2);
                        total_tax_value = ((parseFloat(t) * parseFloat(total_tax)) / 100).toFixed(2);
                        $("#total_tax_"+id).val(total_tax_value);
                        var tot = ((parseFloat(qty) * parseFloat(unit_price))).toFixed(2);
                        $("#total_t_"+id).val(parseFloat(parseFloat(t) + parseFloat(total_tax_value)).toFixed(2));
                    }
                    else{
                        $("#total_t_"+id).val("0.00");
                        $("#total_tax_"+id).val("0.00");
                    }
                }
                

            }
            function GetQuantity(pid,diid){
                if(pid != ""){
                    $.ajax({
                        url: "ajax/estimate.php",
                        type: "POST",
                        data: {pid:pid, cmd:"GetQuantity"},
                        dataType:"JSON",
                        success:function(data){
                            $("#qty_"+diid).val(data.quantity);
                            $("#unit_price_"+diid).val(data.price);
                            if($("#edit_hidden_estimate_id").val() != ""){
                                var oldq = $("#old_q_"+diid).val();
                                if(oldq != ""){
                                    oldq = oldq;
                                }
                                else{
                                    oldq = "0";
                                }
                                alert(oldq);
                                $("#hidden_qty_"+diid).val(parseInt(data.quantity) + parseInt(oldq));    
                            }
                            else{
                                $("#hidden_qty_"+diid).val(data.quantity);    
                            }
                            ChangePrice(diid);
                        }   
                    });
                }
                else{
                    $("#qty_"+diid).val("0");
                    $("#unit_price_"+diid).val("0.00");
                }
            }
            function submitForm() {    
                var formid = $("#hidden_id").val();     
                var form_data = new FormData(document.getElementById("estimate_form"));
                form_data.append("cmd", "GenerateEstimateUpdate");
                $.ajax({
                    url: "ajax/estimate.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_estimate.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_estimate.php?status="+(data.status);
                        }
                    }   
                });
                return false;
            }
        </script>
    </body>
</html>