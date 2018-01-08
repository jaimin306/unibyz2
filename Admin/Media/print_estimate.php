<?php 
include('../includes/session.php');
include("../../dbConnect.php"); 
function encrypt($sData){
	$id=(double)$sData*52532511.24;
	return base64_encode($id);
}
function decrypt($sData){
	$url_id=base64_decode($sData);
	$id=(double)$url_id/52532511.24;
	return $id;
}
function GetRecord($tbl_name,$field_name,$id){
	global $mysqli;
	$sel2 = "SELECT * FROM $tbl_name WHERE $field_name = '$id'";
	$que2 = mysqli_query($mysqli,$sel2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
	$row2 = mysqli_fetch_assoc($que2);
	return $row2;
}
//External Functions End

$id = decrypt($_GET["ESTID"]);
$uid_est = $_SESSION["user_id"];
$query = "SELECT te.*,tu.first_name,tu.last_name,tu.address,tu.phone,tu.email FROM tbl_estimate te LEFT JOIN tbl_user tu ON tu.id = te.customer_id WHERE te.status = '1' and te.id = '$id'";
$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
$row = mysqli_fetch_assoc($res);
$client_name = $row["first_name"]." ".$row["last_name"];

$query1 = "SELECT company_name,company_logo,company_address,company_email,company_website FROM tbl_company_detail WHERE status = '1' and user_id = '$uid_est'";
$res1 = mysqli_query($mysqli,$query1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
$row1 = mysqli_fetch_assoc($res1);
$data = GetRecord('tbl_all_setting','user_id',$uid_est);
$style = '<style type="text/css">
			td {
				padding : 4px 4px;
			}
			hr.style-eight {
              overflow: visible;
              padding: 0;
              border: none;
              border-top: medium double #333;
              color: #333;
              text-align: center;
	        }
	        hr{
	          margin: 10px 0 10px 0;
	        }
			table.custom-border {
				border-width: 1px;
				/*border-spacing: 5px;*/
				border-style: solid;
				border-color: #ada8a8;
				width: 100%;
				/*border-collapse: separate;*/
				background-color: white;
			}
			table.custom-border th {
				border-width: 1px;
				padding: 5px;
				text-align:left;
				border-style: solid;
				border-color: #ada8a8;
				background-color: white;
				-moz-border-radius: ;
			}
			table.custom-border td {
				border-width: 1px;
				padding: 5px;
				border-style: solid;
				border-color: #ada8a8;
				background-color: white;
				-moz-border-radius: ;
			}

			</style>';
			$content = '<body onload="window.print()" ><div style="min-height: 21cm;width: 21cm; font-family:Verdana, Geneva, sans-serif; font-size:13px; ">
				<div style="border:1px solid black;min-height:20cm;">
				<table width="99%"  style="font-family:Verdana, Geneva, sans-serif;font-size:12.5px;" cellpadding="0" cellspacing="0">
					<tr>
						<td rowspan="4" style="width:30%"><img src="'.($row1["company_logo"] != ''  ? '../../uploads/logo/'.$row1["company_logo"] : '../../uploads/logo-placeholder.png').'" height="100px" width="190px"></td>	
						<td style="width:50%"><b>'.$row1["company_name"].'</b><br></td>
						<td rowspan="2" style="font-size:20px;text-align:right;width:20%"><b>Estimate</b></td>
					</tr>
					<tr>	
						<td>'.($row1["company_address"] != "" ? nl2br($row1["company_address"]) : "").'</td>
					</tr>
					<tr>	
						<td>'.($row1["company_email"] != "" ? '<b>Email : </b>'.$row1["company_email"].'</b><br>' : "").'</td>
					</tr>
					<tr>	
						<td>'.($row1["company_website"] != "" ? '<b>Website : </b>'.$row1["company_website"].'</b><br>' : "").'</td>
					</tr>
				</table>
				<hr class="style-eight">
				<table width="100%" style="font-family:Verdana, Geneva, sans-serif;font-size:12.5px;padding-bottom:30px" cellpadding="0" cellspacing="0">
					<tr>	
						<td style="width:15%"><b>Estimate To</b></td>
						<td style="width:45%">'.$client_name.'</td>
						<td style="width:20%;text-align:right"><b>Estimate Number </td>
						<td style="width:20%">&nbsp;&nbsp;#'.$id.'</td>
					</tr>
					<tr>	
						<td style="width:15%;vertical-align:top"><b>Address</b></td>
						<td style="width:45%">'.($row["address"] != "" ? nl2br($row["address"]) : "").'</td>
						<td style="width:20%;text-align:right;vertical-align:top"><b>Estimate Date </td>
						<td style="width:20%;vertical-align:top">&nbsp;&nbsp;'.date($data["date_format"],strtotime($row["estimate_date"])).'</td>
					</tr>
					<tr>	
						<td style="width:15%"><b>Phone</b></td>
						<td style="width:45%">'.($row["phone"] != "" ? $row["phone"].'<br>' : "-").'</td>
						<td style="width:20%;text-align:right"><b>Due Date </td>
						<td style="width:20%">&nbsp;&nbsp;'.date($data["date_format"],strtotime($row["estimate_due_date"])).'</td>
					</tr>
					<tr>	
						<td style="width:15%"><b>Email</b></td>
						<td style="width:45%">'.($row["email"] != "" ? $row["email"].'<br>' : "-").'</td>
						<td style="width:20%;text-align:right">&nbsp;</td>
						<td style="width:20%">&nbsp;</td>
					</tr>
				</table>
				<table width="100%"  style="font-family:Verdana, Geneva, sans-serif;border-collapse: collapse;font-size:12.5px;border:1px solid #ada8a8" cellpadding="0" cellspacing="0" class="custom-border">
					<tr>
						<th style="border:1px solid #ada8a8;padding:5px">Name</th>
						<th style="border:1px solid #ada8a8;padding:5px">Type</th>
						<th style="border:1px solid #ada8a8;padding:5px">Attribute</th>
						<th style="border:1px solid #ada8a8;padding:5px">Condition</th>
						<th style="border:1px solid #ada8a8;padding:5px">Qty</th>
						<th style="border:1px solid #ada8a8;padding:5px">Unit Price</th>
						<th style="border:1px solid #ada8a8;padding:5px">Tax Rate</th>
						<th style="border:1px solid #ada8a8;padding:5px">Tax</th>  
						<th style="border:1px solid #ada8a8;padding:5px">Total</th>
					</tr>';
					$final_total = "0.00";
                    $select_ei = "SELECT tei.*,tp.product_name as pname,ts.service_name as sname,ttr.tax_rate as taxrate_id,type.measurement_type as type_nm,m.measurement_name as measure FROM tbl_estimate_item tei LEFT JOIN tbl_product tp ON tp.id = tei.product_id LEFT JOIN tbl_measurement_type type ON type.id = tei.measurement_type LEFT JOIN tbl_measurement m ON m.id = tei.measurement LEFT JOIN tbl_service ts ON ts.id = tei.product_id LEFT JOIN tbl_taxrate ttr ON ttr.id = tei.taxrate_id WHERE tei.status = '1' AND tei.estimate_id = '$id'";
                    $query_ei = mysqli_query($mysqli,$select_ei) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                    
                    $table_row = '';
                    $num_ei = mysqli_num_rows($query_ei);
                    if($num_ei > 0){
                    while($row_ei = mysqli_fetch_assoc($query_ei)){
                    	$str = '';
                    	if($row_ei["product_detail"]=="Product"){
                    		$str .= '<tr><td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["product_id"] != "0" ? $row_ei["pname"] : '').'</td>';
                    	}
                    	if($row_ei["product_detail"]=="Service"){
                    		$str .= '<tr><td>'.($row_ei["product_id"] != "0" ? $row_ei["sname"] : '').'</td>';
                    	}
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["product_detail"] != "" ? $row_ei["product_detail"] : "-").'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["type_nm"] != "" ? $row_ei["type_nm"] : "-").'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["measure"] != "" ? $row_ei["measure"] : "-").'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["qty"] != "" ? $row_ei["qty"] : "-").'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.$row_ei["unit_price"].'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.($row_ei["taxrate_id"] != "0" ? $row_ei["taxrate_id"] : "0.00").'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.number_format($row_ei["total_tax"],2).'</td>';
                    	$str .= '<td style="border:1px solid #ada8a8;padding:5px">'.number_format($row_ei["total"],2).'</td></tr>';
                    	$final_total += $row_ei["total"]; 
                    	// $tbl_row_end .= '</tr>';
                    	$table_row .= $str;
					}
					}
					else{
						$table_row .= '<td style="text-align:center;" colspan="9">No Records Found</td>';
					}
					$content .= $table_row;
				$tbl_end = '<tr><td colspan="8" style="text-align: right; border:1px solid #ada8a8;padding:5px"><b>Total :</b></td><td colspan=""><b>'.number_format($final_total,2).'</b></td></tr></table>
			</div></div></body>';
			$content .= $tbl_end;
			$html = $style.$content;
	echo $html;
?>