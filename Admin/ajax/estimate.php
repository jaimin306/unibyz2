<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	
	function getMeasurementStr($mid) {		 
		//measurement data
		global $mysqli;		 
		$query_measu = "SELECT * FROM tbl_measurement WHERE status = '1' AND measurement_type_id='$mid' ORDER BY measurement_order";		 
        $res_measu = mysqli_query($mysqli,$query_measu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $str='<option value="">Select</option>';
        while($row_measu = mysqli_fetch_assoc($res_measu)){          
    		$str.='<option value="'.$row_measu['id'].'">'.$row_measu['measurement_name'].'</option>';
    	}
    	return $str;	
	}  

	$cmd = $_REQUEST['cmd']; 
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "GenerateEstimate"){ 
		$customer_id = $_REQUEST["customer_id_value"]?$_REQUEST["customer_id_value"]:0;				
		$department_id = $_REQUEST["department_id"]?$_REQUEST["department_id"]:0;;
		$customer_phone = $_REQUEST["customer_phone"]?$_REQUEST["customer_phone"]:'';
		$customer_email = $_REQUEST["customer_email"]?$_REQUEST["customer_email"]:'';
		$address_of_work = $_REQUEST["address_of_work"]?$_REQUEST["address_of_work"]:'';
		$technician_name = $_REQUEST["technician_name"]?$_REQUEST["technician_name"]:'';
		$technician_number = $_REQUEST["technician_number"];		
		$estimate_date = $_REQUEST["estimate_date"]?$_REQUEST["estimate_date"]:'';
		$estimate_due_date = $_REQUEST["estimate_due_date"]?$_REQUEST["estimate_due_date"]:'';
		$notify_department = $_REQUEST["notify_department"]?$_REQUEST["notify_department"]:'';
		$notes = $_REQUEST["notes"]?$_REQUEST["notes"]:'';
		$add_uid = $_SESSION["user_id"] ;

		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["sel"];
		$measurement_type_arr = $_REQUEST["measurement_type"];
		$measurement_arr = $_REQUEST["measurement"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "INSERT INTO tbl_estimate (customer_id,department_id,customer_phone,customer_email,address_of_work,technician_name,technician_number,estimate_date,estimate_due_date,notify_department,notes,estimate_status,add_date,add_uid,status) VALUES ('".addslashes($customer_id)."','".addslashes($department_id)."','".addslashes($customer_phone)."','".addslashes($customer_email)."','".addslashes($address_of_work)."','".addslashes($technician_name)."','".addslashes($technician_number)."','$estimate_date','".addslashes($estimate_due_date)."','".addslashes($notify_department)."','".addslashes($notes)."','0','$current_date','$add_uid','1')";		 

		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) ); 
		$last_insert_id = mysqli_insert_id($mysqli);
		//multiple entry 
		for($i = 0;$i<count($product_id_arr);$i++){
			$product_id = $product_id_arr[$i]?$product_id_arr[$i]:0;
			$product_detail = $product_detail_arr[$i]?$product_detail_arr[$i]:'';
			$measurement_type = $measurement_type_arr[$i]?$measurement_type_arr[$i]:0;
			$measurement = $measurement_arr[$i]?$measurement_arr[$i]:0;
			$qty = $qty_arr[$i]?$qty_arr[$i]:0;
			$taxrate_id = $taxrate_id_arr[$i]?$taxrate_id_arr[$i]:0;
			$unit_price = $unit_price_arr[$i]?$unit_price_arr[$i]:0;
			$total_tax = $total_tax_arr[$i]?$total_tax_arr[$i]:0;
			$total = $total_arr[$i]? $total_arr[$i]:0;

			$query1 = "INSERT INTO tbl_estimate_item (estimate_id,product_id,product_detail,measurement_type,measurement,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($last_insert_id)."','$product_id','".addslashes($product_detail)."','".addslashes($measurement_type)."','".addslashes($measurement)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";			 
			 
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		  
		if($res){
			$data['result'] = "true";
			$data['status'] = "success";
			// $data['cid'] = encrypt($customer_id);
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "UpdateEstimate"){ 
		$id = $_REQUEST["hidden_id"];
		$customer_id = $_REQUEST["customer_id_value"]?$_REQUEST["customer_id_value"]:0;				
		$department_id = $_REQUEST["department_id"]?$_REQUEST["department_id"]:0;;
		$customer_phone = $_REQUEST["customer_phone"]?$_REQUEST["customer_phone"]:'';
		$customer_email = $_REQUEST["customer_email"]?$_REQUEST["customer_email"]:'';
		$address_of_work = $_REQUEST["address_of_work"]?$_REQUEST["address_of_work"]:'';
		$technician_name = $_REQUEST["technician_name"]?$_REQUEST["technician_name"]:'';
		$technician_number = $_REQUEST["technician_number"];		
		$estimate_date = $_REQUEST["estimate_date"]?$_REQUEST["estimate_date"]:'';
		$estimate_due_date = $_REQUEST["estimate_due_date"]?$_REQUEST["estimate_due_date"]:'';
		$notify_department = $_REQUEST["notify_department"]?$_REQUEST["notify_department"]:'';
		$notes = $_REQUEST["notes"]?$_REQUEST["notes"]:'';
		$add_uid = $_SESSION["user_id"] ;

		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["sel"];
		$measurement_type_arr = $_REQUEST["measurement_type"];
		$measurement_arr = $_REQUEST["measurement"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "UPDATE tbl_estimate SET department_id = '".addslashes($department_id)."', customer_phone = '".addslashes($customer_phone)."', customer_email = '".addslashes($customer_email)."', address_of_work = '".addslashes($address_of_work)."', technician_name = '".addslashes($technician_name)."', technician_number = '".addslashes($technician_number)."', estimate_date = '".addslashes($estimate_date)."', estimate_due_date = '".addslashes($estimate_due_date)."', notify_department = '".addslashes($notify_department)."', notes = '".addslashes($notes)."' WHERE id = '$id'";		 
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) ); 
		
		//multiple entry 

		$del_est_item = "DELETE FROM tbl_estimate_item WHERE estimate_id = '$id'";
		$res_est_item = mysqli_query($mysqli,$del_est_item) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		for($i = 0;$i<count($product_id_arr);$i++){
			$product_id = $product_id_arr[$i]?$product_id_arr[$i]:0;
			$product_detail = $product_detail_arr[$i]?$product_detail_arr[$i]:'';
			$measurement_type = $measurement_type_arr[$i]?$measurement_type_arr[$i]:0;
			$measurement = $measurement_arr[$i]?$measurement_arr[$i]:0;
			$qty = $qty_arr[$i]?$qty_arr[$i]:0;
			$taxrate_id = $taxrate_id_arr[$i]?$taxrate_id_arr[$i]:0;
			$unit_price = $unit_price_arr[$i]?$unit_price_arr[$i]:0;
			$total_tax = $total_tax_arr[$i]?$total_tax_arr[$i]:0;
			$total = $total_arr[$i]? $total_arr[$i]:0;

			$query1 = "INSERT INTO tbl_estimate_item (estimate_id,product_id,product_detail,measurement_type,measurement,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($id)."','$product_id','".addslashes($product_detail)."','".addslashes($measurement_type)."','".addslashes($measurement)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";	
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
		  
		if($res){
			$data['result'] = "true";
			$data['status'] = "usuccess";
			// $data['cid'] = encrypt($customer_id);
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "GetServices"){  
		$uid = $_SESSION["user_id"] ;
		$query_service = "SELECT id,service_name FROM tbl_service WHERE status = '1' AND add_uid = '$uid'";
        $res_service = mysqli_query($mysqli,$query_service) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $str='<option value="">Select</option>';
        while($row_service = mysqli_fetch_assoc($res_service)){          
    		$str.='<option value="'.$row_service['id'].'">'.$row_service['service_name'].'</option>';
    	}
		echo $str;  
	}
	if($cmd == "GetProducts"){  
		$uid = $_SESSION["user_id"] ;
		$query_service = "SELECT id,product_name FROM tbl_product WHERE status = '1' AND add_uid = '$uid'";		 
        $res_service = mysqli_query($mysqli,$query_service) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $str='<option value="">Select</option>';
        while($row_service = mysqli_fetch_assoc($res_service)){          
    		$str.='<option value="'.$row_service['id'].'">'.$row_service['product_name'].'</option>';
    	}
		echo $str;   
	}

	if($cmd == "GetMeasurementType"){  
		$uid = $_SESSION["user_id"] ;
		$type= $_REQUEST['type'];
		$query_measu = "SELECT * FROM tbl_measurement_type WHERE status = '1' AND add_uid = '$uid' AND type='$type'";		 
        $res_measu = mysqli_query($mysqli,$query_measu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $str='<option value="">Select</option>';
        while($row_measu = mysqli_fetch_assoc($res_measu)){          
    		$str.='<option value="'.$row_measu['id'].'">'.$row_measu['measurement_type'].'</option>';
    	}
		echo $str;   
	}

	if($cmd == "GetMeasurement"){  
		$mid = $_REQUEST["mid"] ;		 
		echo getMeasurementStr($mid); 
	}

	if($cmd == "GetQuantity"){		
		$pid = $_REQUEST["pid"];

		if($pid != ""){
			$qs = "SELECT * FROM tbl_product WHERE id = '$pid'";
			$rs = mysqli_query($mysqli,$qs) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			$rows = mysqli_fetch_assoc($rs);			 
			$data["quantity"] = $rows["quantity"]; 
			$data["price"] = $rows["sales_price"]; 
			$data["measurement_type_id"] =$rows["measurement_type_id"]; 
	    	$data["measurement_str"]=getMeasurementStr($data["measurement_type_id"]);
	    	$data["measurement_id"]=$rows["measurement_id"]; ;
		}
		else{
			$data["quantity"] = "0";
			$data["price"] = "0.00";
		}
		echo json_encode($data);
		
	}
	if($cmd == "GetQuantityService"){
		$sid = $_REQUEST["sid"];
		if($sid != ""){
			$qs = "SELECT id,daily_rate,hourly_rate FROM tbl_service WHERE id = '$sid'";
			$rs = mysqli_query($mysqli,$qs) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			$rows = mysqli_fetch_assoc($rs);
			$daily_rate = $rows["daily_rate"]; 
			$hourly_rate = $rows["hourly_rate"]; 
			$data["daily_rate"] = $daily_rate;
			$data["hourly_rate"] = $hourly_rate;
		}
		else{
			$data["daily_rate"] = "0.00";
			$data["hourly_rate"] = "0.00";
		}
		echo json_encode($data);
		
	}
	
	if($cmd == "DeleteEstimate"){
		$id = $_REQUEST["id"];

		$query = "DELETE FROM tbl_estimate WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		$qs = "DELETE FROM tbl_estimate_item WHERE estimate_id = '$id'";
		$rs = mysqli_query($mysqli,$qs) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res && $rs){
			$data['result'] = "true";
			$data['status'] = "dsuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "GenerateWorkOrderStatus"){
		$id = $_REQUEST["id"];

		$query = "UPDATE tbl_estimate SET generate_work_order_status = '1' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		if($res){
			$data['result'] = "true";
			$data['status'] = "wosuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	if($cmd == "DeleteEstimateItem"){
		$id = $_REQUEST["id"];
		$qs = "DELETE FROM tbl_estimate_item WHERE id = '$id'";
		$rs = mysqli_query($mysqli,$qs) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		if($rs){
			$data['result'] = "true";
		}
		else{
			$data['result'] = "false";
		}
		echo json_encode($data);
	}
	if($cmd == "GenerateEstimateUpdate"){
		$id = $_REQUEST["hidden_id"];
		$customer_id = $_REQUEST["customer_id_value"];
		// $work_order_id = $_REQUEST["work_order_id"];
		$estimate_date = $_REQUEST["estimate_date"];
		$estimate_due_date = $_REQUEST["estimate_due_date"];
		$notify_client = $_REQUEST["notify_client"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];


		$edit_hidden_estimate_id_arr = $_REQUEST["edit_hidden_estimate_id"];
		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["product_detail"];
		$measurement_type_arr = $_REQUEST["measurement_type"];
		$measurement_arr = $_REQUEST["measurement"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "UPDATE tbl_estimate SET customer_id = '".addslashes($customer_id)."',  estimate_date = '".addslashes($estimate_date)."', estimate_due_date = '".addslashes($estimate_due_date)."', notify_client = '".addslashes($notify_client)."', notes = '".addslashes($notes)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		// Insert Or Update in Estimate Item
		for($i = 0;$i<count($item_arr);$i++){
			$edit_hidden_estimate_id = $edit_hidden_estimate_id_arr[$i];
			$product_id = $product_id_arr[$i];
			$product_detail = $product_detail_arr[$i];
			$measurement_type = $measurement_type_arr[$i];
			$measurement = $measurement_arr[$i];
			$qty = $qty_arr[$i];
			$taxrate_id = $taxrate_id_arr[$i];
			$unit_price = $unit_price_arr[$i];
			$total_tax = $total_tax_arr[$i];
			$total = $total_arr[$i];

			if($edit_hidden_estimate_id != ""){
				/*if($product_id != "" && $product_id != "0"){
					$sel_qu = "SELECT qty FROM tbl_estimate_item WHERE id = '$edit_hidden_estimate_id'";
					$res_qu = mysqli_query($mysqli,$sel_qu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
					$row_qu = mysqli_fetch_assoc($res_qu);
					$org_quantity = $row_qu["qty"];
					
					// SELECT ORIGIONAL PRODUCT QUANTITY
					// echo $product_id;
					$sel_qu1 = "SELECT quantity FROM tbl_product WHERE id = '$product_id'";
					$res_qu1 = mysqli_query($mysqli,$sel_qu1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
					$row_qu1 = mysqli_fetch_assoc($res_qu1);
					$org_quantity_product = $row_qu1["quantity"];
					// echo $qty." ".$org_quantity." ".$org_quantity_product;
					if($qty > $org_quantity){
						$qty1 = $qty - $org_quantity;
						$net_quanty = $org_quantity_product - $qty1;	
					}
					else if($qty == $org_quantity){
						$net_quanty = $org_quantity_product;		
					}
					else{
						$qty1 = $qty - $org_quantity;
						$net_quanty = $org_quantity_product + $qty1;
					}
					
					$up = "UPDATE tbl_product SET quantity = '$net_quanty' WHERE id = '$product_id'";
					$rp = mysqli_query($mysqli,$up) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
				}*/
				$query1 = "UPDATE tbl_estimate_item SET product_detail = '".addslashes($product_detail)."',measurement_type = '".addslashes($measurement_type)."',measurement = '".addslashes($measurement)."',qty = '".addslashes($qty)."', taxrate_id = '".addslashes($taxrate_id)."', unit_price = '".addslashes($unit_price)."', total_tax = '".addslashes($total_tax)."', total = '".addslashes($total)."' WHERE id = '$edit_hidden_estimate_id'";
				$res_upd = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			}
			else{
				$query1 = "INSERT INTO tbl_estimate_item (estimate_id,product_id,product_detail,measurement_type,measurement,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($id)."','$product_id','".addslashes($product_detail)."','".addslashes($measurement_type)."','".addslashes($measurement)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";
				$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

				/*if($product_id != "" && $product_id != "0"){
					$sel_qu = "SELECT quantity FROM tbl_product WHERE id = '$product_id'";
					$res_qu = mysqli_query($mysqli,$sel_qu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
					$row_qu = mysqli_fetch_assoc($res_qu);
					$org_quantity = $row_qu["quantity"];
					$net_quanty = $org_quantity - $qty;
					if($org_quantity >= $qty){
						$up = "UPDATE tbl_product SET quantity = '$net_quanty' WHERE id = '$product_id'";
						$rp = mysqli_query($mysqli,$up) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
					}
				}*/
			}
		}

		if($res){
			$data['result'] = "true";
			$data['status'] = "upsuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}

	if($cmd == "update_status"){
		$id = $_REQUEST["id"];
		$status_id = $_REQUEST["status_id"];

		$query = "UPDATE tbl_estimate SET estimate_status = '".addslashes($status_id)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "upsuccess";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	 
?>