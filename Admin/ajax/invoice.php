<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	 
	if($cmd == "GetQuantity"){
		$pid = $_REQUEST["pid"];
		if($pid != ""){
			$qs = "SELECT id,quantity,price FROM tbl_product WHERE id = '$pid'";
			$rs = mysqli_query($mysqli,$qs) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			$rows = mysqli_fetch_assoc($rs);
			$quantity = $rows["quantity"]; 
			$price = $rows["price"]; 
			$data["quantity"] = $quantity;
			$data["price"] = $price;
		}
		else{
			$data["quantity"] = "0";
			$data["price"] = "0.00";
		}
		echo json_encode($data);
	}
	if($cmd == "GenerateInvoice"){
		$project_id = $_REQUEST["project_id"]?$_REQUEST["project_id"]:0;		 		 
		$invoice_date = $_REQUEST["invoice_date"]?"'".$_REQUEST["invoice_date"]."'":'NULL';
		$invoice_due_date = $_REQUEST["invoice_due_date"]?"'".$_REQUEST["invoice_due_date"]."'":'NULL';
		$notify_client = $_REQUEST["notify_client"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];
		
		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["sel"];
		$measurement_type_arr = $_REQUEST["measurement_type"];
		$measurement_arr = $_REQUEST["measurement"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "INSERT INTO tbl_invoice (project_id,invoice_date,invoice_due_date,notify_client,notes,invoice_status,add_date,add_uid,status) VALUES ('".addslashes($project_id)."',$invoice_date,$invoice_due_date,'".addslashes($notify_client)."','".addslashes($notes)."','0','$current_date','$add_uid','1')";
		 
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$last_insert_id = mysqli_insert_id($mysqli);

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

			$query1 = "INSERT INTO tbl_invoice_item (invoice_id,product_id,product_detail,measurement_type,measurement,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($last_insert_id)."','$product_id','".addslashes($product_detail)."','".addslashes($measurement_type)."','".addslashes($measurement)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

			if($product_detail== "Product" && $product_id != "0"){
				$sel_qu = "SELECT quantity FROM tbl_product WHERE id = '$product_id'";
				$res_qu = mysqli_query($mysqli,$sel_qu) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
				$row_qu = mysqli_fetch_assoc($res_qu);
				$org_quantity = $row_qu["quantity"];
				$net_quanty = $org_quantity - $qty;
				if($org_quantity >= $qty){
					$up = "UPDATE tbl_product SET quantity = '$net_quanty' WHERE id = '$product_id'";
					$rp = mysqli_query($mysqli,$up) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
				}
			}
		}
		// UPDATE The Status Of Work Order  To full fil that invoice will generate for this work order
		$up_wo = "UPDATE tbl_work_order SET work_order_status = '1' WHERE id = '$work_order_id'";
		$re_wo = mysqli_query($mysqli,$up_wo) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		
		if($res){
			$data['result'] = "true";
			$data['status'] = "success";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}

	if($cmd == "DeleteInvoice"){
		$id = $_REQUEST["id"];

		$query = "DELETE FROM tbl_invoice WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );

		$qs = "DELETE FROM tbl_invoice_item WHERE invoice_id = '$id'";
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
	if($cmd == "update_status"){
		$id = $_REQUEST["id"];
		$status_id = $_REQUEST["status_id"];

		//Update Quantity If Invoice Status Is Accepted
		if($status_id == 1){
			$select_product = "SELECT tei.*,tp.quantity as stock FROM tbl_invoice_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id WHERE tei.status = '1' AND tei.invoice_id = '$id' AND tei.product_detail = 'Product'";
			$res_product = mysqli_query($mysqli,$select_product) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			while($row_product = mysqli_fetch_assoc($res_product)){
				$quantity = $row_product["qty"];
				$stock = $row_product["stock"];
				if($quantity > $stock){
					$data['result'] = "false";
					$data['status'] = "errorqty";
					echo json_encode($data);
					exit;
				}
			}
			$select_product1 = "SELECT tei.*,tp.quantity as stock FROM tbl_invoice_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id WHERE tei.status = '1' AND tei.invoice_id = '$id' AND tei.product_detail = 'Product'";
			$res_product1 = mysqli_query($mysqli,$select_product1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			while($row_product1 = mysqli_fetch_assoc($res_product1)){
				$quantity1 = $row_product1["qty"];
				$stock1 = $row_product1["stock"];
				$pid = $row_product1["product_id"];
				$final_qty = $stock1 - $quantity1;
				$update = "UPDATE tbl_product SET quantity = '$final_qty' WHERE id = '$pid'";
				$up_res = mysqli_query($mysqli,$update) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
			}	
		}
		
		
		$query = "UPDATE tbl_invoice SET invoice_status = '".addslashes($status_id)."' WHERE id = '$id'";	
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		if($res){
			$data['result'] = "true";
			$data['status'] = "upstatus";
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
?>