<?php
	session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	$uid_product = $_SESSION["user_id"];
	if($cmd == "GetInvoiceTable"){
		$project_id = $_REQUEST["project_id"];            
        
        //tax calculation
        $query_tax = "SELECT id,tax_name,tax_rate FROM tbl_taxrate WHERE status = '1' AND add_uid = '$uid_product'";
        $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $tax_atr='';
        while($row_tax = mysqli_fetch_assoc($res_tax)){ 
            $tax_atr.='<option value="'.$row_tax['id'].'">'.$row_tax['tax_name']."-".$row_tax['tax_rate'].'</option>';
        } 
 
        if($project_id == ""){		 
			?>
			<table class="table table-stripped table-hover" id="tbl_est">
	            <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Condition</th>
                    <th>Qty</th>
                    <th>Tax Rate</th>
                    <th>Unit Price</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <tr id="main_0">
                    <td style="width:100px">
                        <select name="sel[]" id="type_0" onchange="SetProduct(this.value,0)" class="form-control" required>
                            <option value="">Please Select</option>
                            <option value="Product">Product</option>
                            <option value="Service">Service</option>
                        </select>
                    </td>
                    <td style="width: 150px">     
                        <select class="form-control" name="product_id[]" id="product_id_0" onchange="SetQuantity(this.value,0)">
                            <option value="">Please Select</option> 
                        </select>
                    </td>
                    <td>                                                        
                       <select name="measurement_type[]" id="measurement_type_0" class="form-control" onchange="GetMeasurement(this.value,0)"> 
                            <option value="">Select</option> 
                       </select>                                                         
                    </td> 
                    <td> 
                        <select class="form-control" name="measurement[]" id="measurement_0" onchange="SetServicePriceValue(this.value,0)"> 
                            <option value="">Select</option> 
                        </select> 
                    </td>
                    <td>
                        <input type="number" class="form-control" name="qty[]" id="qty_0" placeholder="Enter Item Quantity" required="required" autocomplete="off" onkeyup="ChangePrice(0)"><span class="qty_check_0"></span> 
                        <input type="hidden" id="hidden_qty_0" readonly >
                    </td>
                    <td>
                        <select class="form-control changeprice" name="taxrate_id[]" id="taxrate_id_0" onchange="ChangePrice(0)" >
                            <option value="">None</option>
                            <?php
                                echo $tax_atr;
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control " name="unit_price[]" id="unit_price_0" placeholder="Enter Unit Price" onkeyup="ChangePrice(0)" required>
                        <input type="hidden" name="daily_rate[]" id="daily_rate_0" readonly>
                        <input type="hidden" name="hourly_rate[]" id="hourly_rate_0" readonly>
                    </td>
                    <td style="width:100px">
                        <input type="text" class="form-control" id="total_tax_0" name="total_tax[]" placeholder="Enter Tax"  readonly>
                    </td>
                    <td style="width:150px">
                        <input type="text" class="form-control"  id="total_t_0" name="total[]" placeholder="Enter Total">
                    </td>
                    <td style="width:50px">
                        <button class="btn btn-success" type="button" onclick="AddBtn()">+</button>
                    </td>
                </tr>
	        </table>
		<?php
	}
	else{
		?>
		<table class="table table-stripped table-hover" id="tbl_est">
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
                <th>Action</th>
            </tr>
            <?php
            $i = 0;
            $sel = "SELECT tp.*,sum(qty) as total_qty FROM tbl_task t LEFT JOIN  tbl_task_product tp on tp.task_id=t.id WHERE t.project_id=$project_id group by tp.type,tp.product_id";
            $res_sel = mysqli_query($mysqli,$sel) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                while($row_sel = mysqli_fetch_assoc($res_sel)){ 
                    ?>
                    <tr id="main_<?php echo $i; ?>">                    
                    <td style="width:100px">
                        <select name="sel[]" id="type_<?php echo $i; ?>" onchange="SetProduct(this.value,<?php echo $i; ?>)" class="form-control" required>
                            <option value="">Please Select</option>
                            <option value="Product" <?php if($row_sel['type']=="Product"){ echo "selected"; } ?>>Product</option>
                            <option value="Service" <?php if($row_sel['type']=="Service"){ echo "selected"; } ?>>Service</option>
                        </select>
                    </td>
                   <?php
                   $product_detail=$row_sel['type'];
                   //Product Or Service
                    $str_option='<option value="">Select</option>'; 
                    $p_stock=0;
                    $daily_price=0;
                    $hourly_price=0;
                    $unit_price=0;
                    $measurement_type=0;
                    $measurement=0;

                    if($product_detail == "Product"){                          
                        $query_service = "SELECT * FROM tbl_product WHERE status = '1' AND add_uid = '$uid_product'";      
                        $res_service = mysqli_query($mysqli,$query_service) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));                        
                        while($row_service = mysqli_fetch_assoc($res_service)){ 
                            $selected="";                           
                            if($row_service['id']==$row_sel['product_id']){ 
                                $selected="selected"; 
                                $p_stock=$row_service['quantity'];
                                $unit_price=$row_service['sales_price'];
                                $measurement_type=$row_service['measurement_type_id'];
                                $measurement=$row_service['measurement_id'];
                            }
                            $str_option.='<option value="'.$row_service['id'].'"'.$selected.'>'.$row_service['product_name'].'</option>';
                        } 
                    }
                    if($product_detail == "Service"){                           
                        $query_service = "SELECT id,service_name,hourly_rate,daily_rate FROM tbl_service WHERE status = '1' AND add_uid = '$uid_product'";
                        $res_service = mysqli_query($mysqli,$query_service) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));                         
                        while($row_service = mysqli_fetch_assoc($res_service)){ 
                            $selected="";                                      
                            if($row_service['id']==$row_sel['product_id']){
                                $selected="selected";
                                $daily_price=$row_service['hourly_rate'];
                                $hourly_price=$row_service['daily_rate'];
                            }
                            $str_option.='<option value="'.$row_service['id'].'"'.$selected.'>'.$row_service['service_name'].'</option>';
                        }                        
                    }
                    ?>
                    <td style="width: 150px">     
                        <select class="form-control" name="product_id[]" id="product_id_<?php echo $i; ?>" onchange="SetQuantity(this.value,<?php echo $i; ?>)">                            
                            <?php echo $str_option; ?>
                        </select>
                    </td> 
                    <td> 
                        <select name="measurement_type[]" id="measurement_type_<?php echo $i; ?>" onchange="GetMeasurement(this.value,<?php echo $i; ?>)" class="form-control">
                            <option value="">Select</option>
                            <?php  
                                $query_measu = "SELECT * FROM tbl_measurement_type WHERE status = '1' AND add_uid = '$uid_product' AND type='$product_detail'";        
                                $res_measu = mysqli_query($mysqli,$query_measu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));                                 
                                while($row_measu = mysqli_fetch_assoc($res_measu)){    ?>       
                                     <option value="<?php echo $row_measu['id']; ?>" <?php if($row_measu['id']==$measurement_type){echo "selected";} ?>><?php echo $row_measu['measurement_type']; ?></option>
                            <?php } ?>                             
                        </select> 
                    </td>
                    <td>   
                        <select class="form-control" name="measurement[]" id="measurement_<?php echo $i; ?>" onchange="SetServicePriceValue(this.value,<?php echo $i; ?>)" required>
                            <option value="">Select</option>
                             <?php 
                                if($measurement_type!=0){
                                    $query_measu = "SELECT * FROM tbl_measurement WHERE status = '1' AND measurement_type_id='$measurement_type'";        
                                    $res_measu = mysqli_query($mysqli,$query_measu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));                                     
                                    while($row_measu = mysqli_fetch_assoc($res_measu)){  ?>         
                                        <option value="<?php echo $row_measu['id']; ?>" <?php if($row_measu['id']==$measurement){echo "selected";} ?>><?php echo $row_measu['measurement_name']; ?></option> 
                             <?php  } } ?>
                        </select>  
                    </td>
                    <td>
                        <input type="number" class="form-control" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Enter Item Quantity" value="<?php echo $row_sel['total_qty']; ?>" required="required" autocomplete="off" onkeyup="ChangePrice(<?php echo $i; ?>)"><span class="qty_check_<?php echo $i; ?>"></span> 
                        <input type="hidden" id="hidden_qty_<?php echo $i; ?>" value="<?php echo $p_stock; ?>" readonly >
                    </td>
                    <td>                     
                        <input type="text" class="form-control " name="unit_price[]" id="unit_price_<?php echo $i; ?>" value="<?php echo $unit_price; ?>" placeholder="Enter Unit Price" onkeyup="ChangePrice(<?php echo $i; ?>)" required>
                        <input type="hidden" name="daily_rate[]" value="<?php echo $daily_price; ?>" id="daily_rate_<?php echo $i; ?>" readonly>
                        <input type="hidden" name="hourly_rate[]" value="<?php echo $hourly_price; ?>" id="hourly_rate_<?php echo $i; ?>" readonly>
                    </td>
                    <td>
                        <select class="form-control changeprice" name="taxrate_id[]" id="taxrate_id_<?php echo $i; ?>" onchange="ChangePrice(<?php echo $i; ?>)" >
                            <option value="">None</option>
                           <?php 
                                //tax calculation
                                $query_tax = "SELECT id,tax_name,tax_rate FROM tbl_taxrate WHERE status = '1' AND add_uid = '$uid_product'";
                                $res_tax = mysqli_query($mysqli,$query_tax) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));                                 
                                while($row_tax = mysqli_fetch_assoc($res_tax)){ ?>
                                    <option value="<?php echo $row_tax['id']; ?>" <?php //if($row_sel['taxrate_id']==$row_tax['id']){ echo "selected"; } ?>><?php echo $row_tax['tax_name']."-".$row_tax['tax_rate']; ?></option>';
                            <?php } ?>
                        </select>
                    </td>
                    <td style="width:100px">
                        <input type="text" class="form-control" id="total_tax_<?php echo $i; ?>" value="" name="total_tax[]" placeholder="Enter Tax"  readonly>
                    </td>
                    <td style="width:150px">
                        <input type="text" class="form-control"  id="total_t_<?php echo $i; ?>" name="total[]" value="<?php echo ($unit_price*$row_sel['total_qty']); ?>" placeholder="Enter Total">
                    </td>
                    <td style="width:50px">
                        <?php if($i==0){ ?>
                        <button class="btn btn-success" type="button" onclick="AddBtn()">+</button>
                        <?php } else { ?>
                        <button class="btn btn-danger" type="button" onclick="RemoveBtn(<?php echo $i; ?>)">-</button>
                        <?php } ?>
                    </td>
                </tr>
                    <?php
                    $i++;
                }
            ?>
            <input type="hidden" id="i_counter" name="i_counter" value="<?php echo $i; ?>" readonly>
        </table> 
		<?php
	}
}
?>