<?php
	session_start();
	include("../../dbConnect.php");
	include("../includes/general.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if($cmd == "GenerateEstimate"){
		$customer_id = $_REQUEST["customer_id_value"];
		$work_order_id = $_REQUEST["work_order_id"];
		$estimate_date = $_REQUEST["estimate_date"];
		$estimate_due_date = $_REQUEST["estimate_due_date"];
		$notify_client = $_REQUEST["notify_client"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];
		
		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["product_detail"];
		$item_arr = $_REQUEST["item"];
		$description_arr = $_REQUEST["description"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "INSERT INTO tbl_estimate (customer_id,work_order_id,estimate_date,estimate_due_date,notify_client,notes,estimate_status,add_date,add_uid,status) VALUES ('".addslashes($customer_id)."','".addslashes($work_order_id)."','$estimate_date','".addslashes($estimate_due_date)."','".addslashes($notify_client)."','".addslashes($notes)."','0','$current_date','$add_uid','1')";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
		$last_insert_id = mysqli_insert_id($mysqli);
		

		for($i = 0;$i<count($item_arr);$i++){
			$product_id = $product_id_arr[$i];
			$product_detail = $product_detail_arr[$i];
			$item = $item_arr[$i];
			$description = $description_arr[$i];
			$qty = $qty_arr[$i];
			$taxrate_id = $taxrate_id_arr[$i];
			$unit_price = $unit_price_arr[$i];
			$total_tax = $total_tax_arr[$i];
			$total = $total_arr[$i];

			$query1 = "INSERT INTO tbl_estimate_item (estimate_id,product_id,product_detail,item,description,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($last_insert_id)."','$product_id','".addslashes($product_detail)."','".addslashes($item)."','".addslashes($description)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";
			$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

			if($product_id != "" && $product_id != "0"){
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
		
		if($res){
			$data['result'] = "true";
			$data['status'] = "success";
			$data['cid'] = encrypt($customer_id);
		}
		else{
			$data['result'] = "false";
			$data['status'] = "error";
		}
		echo json_encode($data);
	}
	
	
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
	
	if($cmd == "DeleteEstimate"){
		$id = $_REQUEST["id"];

		//UPDATE THE QUANTITY FROM PRODUCT
		$select = "SELECT * FROM tbl_estimate_item WHERE estimate_id = '$id' ";
		$query_sel = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		while($row = mysqli_fetch_assoc($query_sel)){
			$product_id = $row["product_id"];
			if($product_id != "0"){
				$qty = $row["qty"];
				$s1 = "SELECT quantity FROM tbl_product WHERE id = '$product_id'";
				$q1 = mysqli_query($mysqli,$select) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
				$r1 = mysqli_fetch_assoc($q1);
				$old_qty = $r1["quantity"];
				$up_qty = $old_qty + $qty;
				$update = "UPDATE tbl_product SET quantity = '$up_qty' WHERE id = '$product_id'";
				$q = mysqli_query($mysqli,$update) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
			}
		}
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
	if($cmd == "DeleteEstimateItem"){
		$id = $_REQUEST["id"];
		if($_REQUEST["idval"] != "0"){
			$sel_q = "SELECT tp.id as tpid, tp.quantity,tei.qty FROM tbl_product tp LEFT JOIN tbl_estimate_item tei ON tp.id = tei.product_id  WHERE tei.id = '$id'";
			$que_q = mysqli_query($mysqli,$sel_q) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
			$row_q = mysqli_fetch_assoc($que_q);
			$row_qty = $row_q["quantity"];
			$est_qty = $row_q["qty"];
			$tpid = $row_q["tpid"];
			$up_qty = $row_qty + $est_qty;
			$up = "UPDATE tbl_product SET quantity = '$up_qty' WHERE id = '$tpid'";
			$r = mysqli_query($mysqli,$up) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		}
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
		$work_order_id = $_REQUEST["work_order_id"];
		$estimate_date = $_REQUEST["estimate_date"];
		$estimate_due_date = $_REQUEST["estimate_due_date"];
		$notify_client = $_REQUEST["notify_client"];
		$notes = $_REQUEST["notes"];
		$add_uid = $_SESSION["user_id"];


		$edit_hidden_estimate_id_arr = $_REQUEST["edit_hidden_estimate_id"];
		$product_id_arr = $_REQUEST["product_id"];
		$product_detail_arr = $_REQUEST["product_detail"];
		$item_arr = $_REQUEST["item"];
		$description_arr = $_REQUEST["description"];
		$qty_arr = $_REQUEST["qty"];
		$taxrate_id_arr = $_REQUEST["taxrate_id"];
		$unit_price_arr = $_REQUEST["unit_price"];
		$total_tax_arr = $_REQUEST["total_tax"];
		$total_arr = $_REQUEST["total"];

		$query = "UPDATE tbl_estimate SET customer_id = '".addslashes($customer_id)."', work_order_id = '".addslashes($work_order_id)."', estimate_date = '".addslashes($estimate_date)."', estimate_due_date = '".addslashes($estimate_due_date)."', notify_client = '".addslashes($notify_client)."', notes = '".addslashes($notes)."' WHERE id = '$id'";
		$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

		// Insert Or Update in Estimate Item
		for($i = 0;$i<count($item_arr);$i++){
			$edit_hidden_estimate_id = $edit_hidden_estimate_id_arr[$i];
			$product_id = $product_id_arr[$i];
			$product_detail = $product_detail_arr[$i];
			$item = $item_arr[$i];
			$description = $description_arr[$i];
			$qty = $qty_arr[$i];
			$taxrate_id = $taxrate_id_arr[$i];
			$unit_price = $unit_price_arr[$i];
			$total_tax = $total_tax_arr[$i];
			$total = $total_arr[$i];

			if($edit_hidden_estimate_id != ""){
				if($product_id != "" && $product_id != "0"){
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
				}
				$query1 = "UPDATE tbl_estimate_item SET product_detail = '".addslashes($product_detail)."',item = '".addslashes($item)."',description = '".addslashes($description)."',qty = '".addslashes($qty)."', taxrate_id = '".addslashes($taxrate_id)."', unit_price = '".addslashes($unit_price)."', total_tax = '".addslashes($total_tax)."', total = '".addslashes($total)."' WHERE id = '$edit_hidden_estimate_id'";
				$res_upd = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli) );
			}
			else{
				$query1 = "INSERT INTO tbl_estimate_item (estimate_id,product_id,product_detail,item,description,qty,taxrate_id,unit_price,total_tax,total,add_date,add_uid,status) VALUES ('".addslashes($id)."','$product_id','".addslashes($product_detail)."','".addslashes($item)."','".addslashes($description)."','".addslashes($qty)."','".addslashes($taxrate_id)."','".addslashes($unit_price)."','".addslashes($total_tax)."','".addslashes($total)."','$current_date','$add_uid','1')";
				$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));

				if($product_id != "" && $product_id != "0"){
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
?>