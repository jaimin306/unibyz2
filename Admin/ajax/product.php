<?php
    session_start();
	include("../../dbConnect.php");
	$cmd = $_REQUEST['cmd'];
	$current_date = date("Y-m-d H:i:s");
	if ($cmd == "insert") {
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $product_type_id = $_REQUEST["product_type_id"]?$_REQUEST["product_type_id"]:0;
        $product_name = $_REQUEST["product_name"];
        $code = $_REQUEST["code"];
        $brand_id = $_REQUEST["brand_id"]!=''?$_REQUEST["brand_id"]:0;       
        $vendor_id = $_REQUEST["vendor_id"]!=''?$_REQUEST["vendor_id"]:0;
        $quantity = $_REQUEST["quantity"];
        $purchase_price = $_REQUEST["purchase_price"]?$_REQUEST["purchase_price"]:0;
        $sales_price = $_REQUEST["sales_price"]?$_REQUEST["sales_price"]:0;
        $measurement_type_id = $_REQUEST["measurement_type_id"]?$_REQUEST["measurement_type_id"]:0;
        $measurement_id = $_REQUEST["measurement_id"]?$_REQUEST["measurement_id"]:0;
        $description = $_REQUEST["description"];
        $classification = $_REQUEST["classification"];
        $notes = $_REQUEST["notes"];
        $add_uid = $_SESSION["user_id"];
        
        /* Upload Photo */
        if (!empty($_FILES)) {
            $photo = $_FILES["photo_path"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/product/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = "";
        }
        /* Upload Photo */
        $query = "INSERT INTO tbl_product (category_id,product_type_id,product_name,code,brand_id,vendor_id,measurement_type_id,measurement_id,quantity,purchase_price,sales_price,description,notes,photo_path,classification,add_date,add_uid,status) VALUES ('".addslashes($category_id)."','".addslashes($product_type_id)."','".addslashes($product_name)."','".addslashes($code)."','".addslashes($brand_id)."','".addslashes($vendor_id)."','".addslashes($measurement_type_id)."','".addslashes($measurement_id)."','".addslashes($quantity)."','".addslashes($purchase_price)."','".addslashes($sales_price)."','".addslashes($description)."','".addslashes($notes)."','".addslashes($img_name)."','".addslashes($classification)."','$current_date','$add_uid','1')";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "success";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }

    if ($cmd == "update") {
        $id = $_REQUEST["id"];
        $category_id = $_REQUEST["category_id"]?$_REQUEST["category_id"]:0;
        $product_type_id = $_REQUEST["product_type_id"]?$_REQUEST["product_type_id"]:0;
        $product_name = $_REQUEST["product_name"];
        $code = $_REQUEST["code"];
        $brand_id = $_REQUEST["brand_id"]?$_REQUEST["brand_id"]:0;
        $vendor_id = $_REQUEST["vendor_id"]?$_REQUEST["vendor_id"]:0;
        $quantity = $_REQUEST["quantity"];
        $purchase_price = $_REQUEST["purchase_price"]?$_REQUEST["purchase_price"]:0;
        $sales_price = $_REQUEST["sales_price"]?$_REQUEST["sales_price"]:0;
        $measurement_type_id = $_REQUEST["measurement_type_id"]?$_REQUEST["measurement_type_id"]:0;
        $measurement_id = $_REQUEST["measurement_id"]?$_REQUEST["measurement_id"]:0;
        $description = $_REQUEST["description"];
        $notes = $_REQUEST["notes"];
        $photo_path = $_REQUEST["hidden_photo_path"];
        $classification = $_REQUEST["classification"];

        if ($_FILES["photo_path"]["name"] != "") {
            $photo = $_FILES["photo_path"]["name"];
            $new_photo = date('YmdHis')."_".uniqid()."_".$photo;
            $tmp_photo = $_FILES["photo_path"]["tmp_name"];
            if (move_uploaded_file($tmp_photo, "../../uploads/product/".$new_photo)) {
                $img_name = $new_photo;
            } else {
                $img_name = "";
            }
        } else {
            $img_name = $photo_path;
        }

        $query = "UPDATE tbl_product SET category_id = '".addslashes($category_id)."',product_type_id = '".addslashes($product_type_id)."',product_name = '".addslashes($product_name)."',code = '".addslashes($code)."',brand_id = '".addslashes($brand_id)."',vendor_id = '".addslashes($vendor_id)."',quantity = '".addslashes($quantity)."',purchase_price = '".addslashes($purchase_price)."',sales_price = '".addslashes($sales_price)."',measurement_type_id = '".addslashes($measurement_type_id)."',measurement_id = '".addslashes($measurement_id)."',description = '".addslashes($description)."',notes = '".addslashes($notes)."',photo_path = '".addslashes($img_name)."',classification = '".addslashes($classification)."' WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "usuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "update_qty") {
        $id = $_REQUEST["id"];
        $update_quanty = $_REQUEST["update_quanty"];

        $query = "UPDATE tbl_product SET quantity = '".addslashes($update_quanty)."' WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "uqsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }

    if ($cmd == "delete") {
        $id = $_REQUEST["id"];
        $select = "SELECT photo_path FROM tbl_product WHERE status = '1' and id = '$id'";
        $q = mysqli_query($mysqli, $select);
        $r = mysqli_fetch_assoc($q);
        $old_photo = $r["photo_path"];
        if($old_photo != ""){
            unlink("../../uploads/product/".$old_photo);
        }

        $query = "DELETE FROM tbl_product WHERE id = '$id'";
        $res = mysqli_query($mysqli, $query);
        if ($res) {
            $data['result'] = "true";
            $data['status'] = "dsuccess";
        } else {
            $data['result'] = "false";
            $data['status'] = "error";
        }
        echo json_encode($data);
    }
    if ($cmd == "GetProductType") {
        $cid = $_REQUEST["cid"];
        $data['string'] = '<option value="">Please Select Product Type</option>';
        $query = "SELECT id,product_type_name FROM tbl_product_type WHERE status = '1' and category_id = '$cid'";
        $res = mysqli_query($mysqli, $query);
        while($row = mysqli_fetch_assoc($res)){
            $data['string'] .= '<option value="'.$row["id"].'">'.$row["product_type_name"].'</option>';
        }
        echo json_encode($data);
    }

    if ($cmd == "GetProductMeasurement") {
        $mid = $_REQUEST["mid"];
        $data['string'] = '<option value="">Select Condition</option>';
        $query = "SELECT id,measurement_name FROM tbl_measurement WHERE status = '1' and measurement_type_id = '$mid'";
        $res = mysqli_query($mysqli, $query);
        while($row = mysqli_fetch_assoc($res)){
            $data['string'] .= '<option value="'.$row["id"].'">'.$row["measurement_name"].'</option>';
        }
        echo json_encode($data);
    }

?>