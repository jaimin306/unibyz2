<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $pid= decrypt($_GET["PID"]);         
    $query = "SELECT p.*,u.first_name,u.last_name,w.work_order_name FROM tbl_project p LEFT JOIN tbl_user u on u.id=p.customer_id LEFT JOIN tbl_work_order w on w.project_id=p.id WHERE p.project_status = '0' and p.id = '$pid'";
   // echo $query; die;
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $project_row = mysqli_fetch_assoc($res);   
    $cid = $project_row['customer_id'];
    $uid_invoice = $_SESSION["user_id"]; 

    // $id = decrypt($_GET["EID"]);
    // $query = "SELECT * FROM tbl_invoice WHERE status = '1' and id = '$id'";
    // $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    // $row = mysqli_fetch_assoc($res);
    // $uid_invoice = $_SESSION["user_id"];
    // $notify_client = isset($id) ? $row["notify_client"] : ''; 
     
    $cust_name = $project_row["first_name"]." ".$project_row["last_name"];

    //tax calculation
    $query_tax = "SELECT id,tax_name,tax_rate FROM tbl_taxrate WHERE status = '1' AND add_uid = '$uid_invoice'";
    $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $tax_atr='';
    while($row_tax = mysqli_fetch_assoc($res_tax)){ 
        $tax_atr.='<option value="'.$row_tax['id'].'">'.$row_tax['tax_name']."-".$row_tax['tax_rate'].'</option>';
    } 
 
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo GetSettingGeneral('title_tag'); ?></title>
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
                        <li class="active">Invoice</li>
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
                                    <h3 class="box-title">Add Invoice</h3>
                                    <a href="list_invoice.php"><button class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                                <div class="container">
                                    <form method="POST" id="invoice_form" action="#" onsubmit="return submitForm();" >
                                        <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="project_id" id="project_id" value="<?php echo $pid; ?>" readonly>
                                        <div class="form-group">
                                            <label for="customer_id">Project</label>
                                            <input type="text" class="form-control" id="project_nm" value="<?php echo $project_row["project_name"]; ?>" name="project_nm" readonly>                                             
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_id">Customer </label>
                                            <input type="text" class="form-control" id="customer_nm" value="<?php echo $project_row["first_name"]." ".$project_row["last_name"]; ?>" name="customer_nm" readonly>                                             
                                        </div>
                                        <div class="form-group">
                                            <label for="work_order_id">Work Order </label>
                                            <input type="text" class="form-control" id="work_order_nm" value="<?php echo $project_row["work_order_name"]; ?>" name="work_order_nm" readonly>                                                                                          
                                        </div>                                         
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date </label>
                                            <input type="text" class="form-control" id="invoice_date" value="<?php echo (isset($id) ? $row['invoice_date'] : ''); ?>" name="invoice_date" placeholder="Enter Invoice Date Here" >
                                        </div>
                                        <div class="form-group">
                                            <label for="invoice_due_date">Invoice Due Date </label>
                                            <input type="text" class="form-control" id="invoice_due_date" value="<?php echo (isset($id) ? $row['invoice_due_date'] : ''); ?>" name="invoice_due_date" placeholder="Enter Invoice Due Date Here" >
                                        </div>
                                        <div class="form-group">
                                            <label for="notify_client">Notify Client </label>
                                            <select name="notify_client" id="notify_client" class="form-control">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes">Notes </label>
                                            <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                        <div id="replace_div"></div>
                                        </div>
                                        <div class="box-footer">
                                            <?php
                                                if(isset($id) && $id != "" ){
                                                  echo '<button type="submit" class="btn btn-primary">Update</button>';
                                                }
                                                else{
                                                  echo '<button type="submit" class="btn btn-primary" id="btn_submit">Save</button>';
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
                GetInvoiceTable();
                $('.textarea').wysihtml5();
                $('#invoice_date').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                });
                $('#invoice_due_date').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                });
                $('#work_order_id').select2();
            });
            var i = 1;
            function AddBtn(){
                // var str = '';
                str='    <tr id="main_'+i+'">';
                str+='        <td style="width:100px">';
                str+='            <select name="sel[]" id="type_'+i+'" onchange="SetProduct(this.value,'+i+')" class="form-control" required>';
                str+='                <option value="">Please Select</option>';
                str+='                <option value="Product">Product</option>';
                str+='                <option value="Service">Service</option>';
                str+='            </select>';
                str+='        </td>';
                str+='        <td style="width: 150px">';     
                str+='            <select class="form-control" name="product_id[]" id="product_id_'+i+'" onchange="SetQuantity(this.value,'+i+')">';
                str+='                <option value="">Please Select</option>'; 
                str+='            </select>';
                str+='        </td>';
                str+='        <td>';                                                           
                str+='          <select name="measurement_type[]" id="measurement_type_'+i+'" class="form-control" onchange="GetMeasurement(this.value,'+i+')">';
                str+='               <option value="">Select</option>';
                str+='          </select>';                                                           
                str+='        </td>';
                str+='        <td>';   
                str+='           <select class="form-control" name="measurement[]" id="measurement_'+i+'" onchange="SetServicePriceValue(this.value,'+i+')">';
                str+='              <option value="">Select</option>';
                str+='           </select>';  
                str+='        </td>';
                str+='        <td>';
                str+='            <input type="number" class="form-control" name="qty[]" id="qty_'+i+'" placeholder="Enter Item Quantity" required="required" autocomplete="off" onkeyup="ChangePrice('+i+')"><span class="qty_check_'+i+'"></span> ';
                str+='            <input type="hidden" id="hidden_qty_'+i+'" readonly >';
                str+='        </td>';
                str+='        <td>';
                str+='            <select class="form-control changeprice" name="taxrate_id[]" id="taxrate_id_'+i+'" onchange="ChangePrice('+i+')" >';
                str+='                <option value="">None</option>';   
                str+='                 <?php echo $tax_atr; ?> ';
                str+='            </select>';
                str+='            </td>';
                str+='            <td>';
                str+='                <input type="text" class="form-control " name="unit_price[]" id="unit_price_'+i+'" placeholder="Enter Unit Price" onkeyup="ChangePrice('+i+')" required>';
                str+='                <input type="hidden" name="daily_rate[]" id="daily_rate_'+i+'" readonly>';
                str+='                <input type="hidden" name="hourly_rate[]" id="hourly_rate_'+i+'" readonly>';
                str+='            </td>';
                str+='            <td style="width:100px">';
                str+='                <input type="text" class="form-control" id="total_tax_'+i+'" name="total_tax[]" placeholder="Enter Tax"  readonly>';
                str+='            </td>';
                str+='            <td style="width:150px">';
                str+='                <input type="text" class="form-control"  id="total_t_'+i+'" name="total[]" placeholder="Enter Total">';
                str+='            </td>';
                str+='            <td style="width:50px">';
                str+='                <button class="btn btn-danger" type="button" onclick="RemoveBtn('+i+')">-</button>';
                str+='            </td>';
                str+='        </tr>';
                $("#tbl_est tr:last").after(str);
                i++;
            }
            
            function RemoveBtn(divid){
                $("#main_"+divid).remove();
            }
            function SetProduct(val,did){
                $("#qty_"+did).val(""); 
                $("#taxrate_id_"+did).val("");
                $("#qty_check_"+did).val("");  
                $("#unit_price_"+did).val("");
                $("#total_t_"+did).val("");
                $("#total_tax_"+did).val("");
                $("#hidden_qty_"+did).val("");
                $(".qty_check_"+did).html("");
                $("#measurement_type_"+did).html('<option value="">Select</option>');
                $("#measurement_"+did).html('<option value="">Select</option>'); 

                if(val == "Product"){                              
                  $("#qty_"+did).removeAttr("readonly");                  
                }                

                if(val == "Service"){                   
                  $("#qty_"+did).removeAttr("readonly");                   
                   
                }
               
                $.ajax({
                    url: "ajax/estimate.php",
                    type: "POST",
                    data: {cmd:"Get"+val+"s"},   
                    success:function(data){                                           
                        $("#product_id_"+did).html(data);                       
                    }  
                });
                $.ajax({
                    url: "ajax/estimate.php",
                    type: "POST",
                    data: {cmd:"GetMeasurementType",type:val},   
                    success:function(data){                                           
                        $("#measurement_type_"+did).html(data);                       
                    }  
                });
            }
            function ChangePrice(id){
                var qty1 = $("#qty_"+id).val();                
                var hidden_qty1 = $("#hidden_qty_"+id).val();
                var qty = parseInt(qty1);
                var hidden_qty = parseInt(hidden_qty1);
                var type = $("#type_"+id).val();;

                var unit_price = $("#unit_price_"+id).val();
                var total_tax = 0;
                if(type!= "" && unit_price!="" && qty>0){                     
                    var str = $("#taxrate_id_"+id+" option:selected").html();  
                    if(str!='None'){
                        var arr = str.split("-");
                        total_tax = arr[1];
                    } 
                    //for product
                    if(type == "Product"){
                        if(qty > hidden_qty){
                            $("#btn_submit").attr("disabled","disabled");
                            $(".qty_check_"+id).html("Available : "+hidden_qty);
                            $(".qty_check_"+id).css("color","red");
                            $("#qty_"+id).val(0);  
                            return false;; 
                        }
                        else{
                            $("#btn_submit").removeAttr("disabled");
                            $(".qty_check_"+id).html(""); 
                        }
                    }

                    if(qty > 0 && unit_price > 0){
                        var t = (parseFloat(qty) * parseFloat(unit_price)).toFixed(2);
                        var total_tax_value=0;
                        if(str!='None'){
                            total_tax_value = ((parseFloat(t) * parseFloat(total_tax)) / 100).toFixed(2);
                        } 
                        $("#total_tax_"+id).val(total_tax_value);                            
                        var tot = ((parseFloat(qty) * parseFloat(unit_price) )).toFixed(2);
                        $("#total_t_"+id).val(parseFloat(parseFloat(tot) + parseFloat(total_tax_value)).toFixed(2));
                    }
                    else{
                        $("#total_t_"+id).val("0.00");
                        $("#total_tax_"+id).val("0.00");
                    } 
                }               
            }
            function SetQuantity(pid,diid){
                type = $("#type_"+diid).val();
                if(type == "Product"){     
                    GetQuantity(pid,diid);
                }
                if(type == "Service"){   
                    GetQuantityService(pid,diid);
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
                           $("#qty_"+diid).val(1);
                            $("#unit_price_"+diid).val(data.price);
                            $("#hidden_qty_"+diid).val(data.quantity);
                            $("#measurement_type_"+diid).val(data.measurement_type_id);
                            $("#measurement_"+diid).html(data.measurement_str);
                            $("#measurement_"+diid).val(data.measurement_id);                             
                            //ChangePrice(diid); 
                            $("#total_t_"+diid).val(data.price);
                        }   
                    });
                }
                else{
                    $("#qty_"+diid).val("0");
                    $("#unit_price_"+diid).val("0.00");
                }
            }
            function GetQuantityService(sid,diid1){
                if(sid != ""){
                    $.ajax({
                        url: "ajax/estimate.php",
                        type: "POST",
                        data: {sid:sid, cmd:"GetQuantityService"},
                        dataType:"JSON",
                        success:function(data){                             
                            $("#daily_rate_"+diid1).val(data.daily_rate);
                            $("#hourly_rate_"+diid1).val(data.hourly_rate);
                        }   
                    });
                } 
            }

            function SetServicePriceValue(sid,did){                
                hval=$("#hourly_rate_"+did).val();
                dval=$("#daily_rate_"+did).val();
                type=$("#type_"+did).val(); 
                // alert(sid);
                if(type=="Service"){
                    if(sid==19){ // hours
                       $("#unit_price_"+did).val(hval); 
                    } else if(sid==20){ // days
                       $("#unit_price_"+did).val(dval); 
                    } else if(sid==18){ // minute
                        hval=parseFloat(hval);
                        val=hval/60;
                        $("#unit_price_"+did).val(val.toFixed(2)); 
                    } else if(sid==21){ //weeks
                        dval=parseFloat(dval);
                        val=dval*7;
                        $("#unit_price_"+did).val(val.toFixed(2));
                    }  else{
                        $("#unit_price_"+did).val("0.00");
                    } 
                    ChangePrice(did);
                }
            }
            
            function GetMeasurement(mval,did){
                $.ajax({
                    url: "ajax/estimate.php",
                    type: "POST",
                    data: {cmd:"GetMeasurement",mid:mval},   
                    success:function(data){                                           
                        $("#measurement_"+did).html(data);                       
                    }  
                });
            }

            function submitForm() {    
                var formid = $("#hidden_id").val();     
                var form_data = new FormData(document.getElementById("invoice_form"));
                form_data.append("cmd", "GenerateInvoice");
                $.ajax({
                    url: "ajax/invoice.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                            window.location.href="list_invoice.php?status="+(data.status);
                        }
                        else{
                            window.location.href="list_invoice.php?status="+(data.status);
                        }
                    }   
                });
                return false;
            }
             
            function GetInvoiceTable(){
                //$("#hidden_spinner").show();
                var project_id = $("#project_id").val(); 
                $.ajax({
                    url: "ajax/invoice_table.php",
                    type: "POST",
                    data: {project_id:project_id,cmd:"GetInvoiceTable"},
                    success:function(data){                        
                        $("#replace_div").html(data);
                        //$("#hidden_spinner").hide(); 
                        if(project_id!=''){
                            i=parseInt($("#i_counter").val());
                        }
                    }   
                });
            }
        </script>
    </body>
</html>