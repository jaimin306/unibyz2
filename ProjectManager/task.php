<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT tt.*,GROUP_CONCAT(tta.assigned_to) as assignee FROM tbl_task tt LEFT JOIN tbl_task_assign tta ON tta.task_id = tt.id WHERE tt.status = '1' and tt.id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_task = $_SESSION["user_id"];
    $employee = $row["assignee"];
    $employee_arr = explode(",", $employee); 
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
                        <li><a href="<?php echo $projectmanager_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Tasks</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Tasks</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="task_form" class="form-horizontal"  action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                            <label for="project_id" class="control-label col-md-2">Project </label>
                                            <div class="col-md-4">
                                              <select class="form-control" name="project_id" onchange="GetMilestone(this.value)" id="project_id"  >
                                                  <option value="">Please Select Project</option>
                                                  <?php 
                                                      $query_project = "SELECT * FROM tbl_project WHERE status = '1' AND project_manager_id = '$uid_task'";
                                                      $res_project = mysqli_query($mysqli,$query_project) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      while($row_project = mysqli_fetch_assoc($res_project)){
                                                        ?>
                                                          <option value="<?php echo $row_project['id']; ?>" <?php echo ($row["project_id"] == $row_project["id"] ? 'selected=selected' : '') ?>><?php echo $row_project['project_name']; ?></option>
                                                         <?php
                                                      } 
                                                  ?>
                                              </select>
                                              <div id="hide_spin" style="display:none"><i class="fa fa-refresh fa-spin"></i></div>
                                            </div>
                                            <label for="task_name" class="control-label col-md-2">Task Name </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo (isset($id) ? $row['task_name'] : ''); ?>"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date" class="control-label col-md-2">Start Date </label>
                                            <div class="col-md-4">
                                              <input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo (isset($id) ? $row['start_date'] : ''); ?>" readonly="">
                                            </div>
                                            <label for="end_date" class="control-label col-md-2">End Date </label>
                                            <div class="col-md-4">
                                              <input type="text" name="end_date" id="end_date" value="<?php echo (isset($id) ? $row['end_date'] : ''); ?>" class="form-control" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="assigned_to" class="control-label col-md-2">Assigned To </label>
                                            <div class="col-md-4">
                                              <select name="assigned_to[]" id="assigned_to" class="form-control" multiple="multiple" data-placeholder="Please Select Employee">
                                                <?php 
                                                    $query_employee = "SELECT id,first_name,last_name FROM tbl_user WHERE status = '1' AND user_type = '4'";
                                                    $res_employee = mysqli_query($mysqli,$query_employee) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_employee = mysqli_fetch_assoc($res_employee)){
                                                      ?>
                                                        <option value="<?php echo $row_employee['id']; ?>" <?php if(in_array($row_employee["id"],$employee_arr)){ echo 'selected';}?>><?php echo $row_employee['first_name']." ".$row_employee['last_name']; ?></option>
                                                       <?php
                                                    } 
                                                ?>
                                              </select>                                              
                                            </div>
                                            <label for="task_status" class="control-label col-md-2"> Task Status </label>
                                            <div class="col-md-4">
                                              <select name="task_status" id="task_status" class="form-control">
                                                <option value="">Please Select Status</option>
                                                <option value="0" <?php if($row["task_status"] == "0"){ echo 'selected';}?>>Open</option>
                                                <option value="1" <?php if($row["task_status"] == "1"){ echo 'selected';} ?>>Completed</option>
                                              </select>                                              
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="milestone_id" class="control-label col-md-2">Milestone </label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="milestone_id" id="milestone_id" >
                                                <option value="">Please Select Milestone</option>
                                                <?php 
                                                    $query_milestone = "SELECT * FROM tbl_milestone WHERE status = '1' AND add_uid = '$uid_task'";
                                                    $res_milestone = mysqli_query($mysqli,$query_milestone) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                    while($row_milestone = mysqli_fetch_assoc($res_milestone)){
                                                      ?>
                                                        <option value="<?php echo $row_milestone['id']; ?>" <?php echo ($row["milestone_id"] == $row_milestone["id"] ? 'selected=selected' : '') ?>><?php echo $row_milestone['milestone_name']; ?></option>
                                                       <?php
                                                    } 
                                                ?>
                                            </select>
                                          </div>
                                          <label for="attachment" class="col-md-2 control-label">Attachment </label>
                                          <div class="col-md-4">
                                            <input type="file" class="form-control"  id="attachment" name="attachment" >
                                            <input type="hidden" name="hidden_attachment" value="<?php echo (isset($id) ? $row['attachment'] : ''); ?>">
                                          </div>
                                        </div>
                                        <div class="form-group" style="min-height: 250px;background-color: #d0cee27a">
                                          <table class="table table-striped table-hover text-center" style="width:100%;border-collapse: collapse;table-layout: fixed" cellspacing="0" cellpadding="0" id="myTable">
                                            <tbody>
                                              <tr style="background-color: #b1b1b1">
                                                <th style="width:3%"></th>
                                                <th style="width:20%">Select</th>
                                                <th style="width:20%">Category</th>
                                                <th style="width:20%">Type</th>
                                                <th style="width:20%">Product</th>
                                                <th style="width:10%">Qty</th>
                                                <th style="width:7%">Action</th>
                                              </tr>
                                              <?php
                                                if(isset($row['id'])){ 
                                                  $i=0;
                                                  $query_task_product = "SELECT * FROM tbl_task_product WHERE task_id = $row[id] AND add_uid = '$uid_task' ORDER BY id";
                                                  $res_products = mysqli_query($mysqli,$query_task_product) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                  while($res_product = mysqli_fetch_assoc($res_products)){                                                
                                              ?>
                                              <tr style="background-color: #bed6d652">
                                                <td>
                                                  <div class="hide_spin_<?php echo $i; ?>" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
                                                </td>
                                                <td>
                                                  <select onchange="GetCategory(this.value,<?php echo $i;?>)" name="type[]" id="type_<?php echo $i; ?>" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <option value="Product" <?php if($res_product['type']=='Product'){ echo "selected"; } ?>>Product</option>
                                                    <option value="Service" <?php if($res_product['type']=='Service'){ echo "selected"; } ?>>Service</option>
                                                  </select>
                                                </td>
                                                <td>
                                                  <?php
                                                    $sid =$res_product['type'];                                                    
                                                    if($sid != ""){
                                                        $c_str = '<option value="">Please Select</option>';
                                                        if($sid == "Product") {                                                              
                                                            $query = "SELECT tc.id,tc.category_name FROM tbl_category tc LEFT JOIN tbl_user tu ON tu.add_uid = tc.add_uid WHERE tu.id = '$uid_task' AND tc.status = '1'";
                                                        } else {
                                                            $query = "SELECT tc.id,tc.category_name FROM tbl_service_category tc LEFT JOIN tbl_user tu ON tu.add_uid = tc.add_uid WHERE tc.status = '1' AND tu.id = '$uid_task'"; 
                                                        }                                                          
                                                        $t_res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
                                                        while ($c_row = mysqli_fetch_assoc($t_res)){
                                                          if($res_product['category_id']==$c_row["id"]){ // for selected
                                                            $c_str .= '<option value="'.$c_row["id"].'" selected>'.$c_row["category_name"].'</option>';
                                                          } else{
                                                            $c_str .= '<option value="'.$c_row["id"].'">'.$c_row["category_name"].'</option>';                                                            
                                                          }
                                                        }
                                                    }
                                                    else{
                                                        $c_str = '<option value="">Please Select</option>';
                                                    }

                                                  ?>
                                                  <select name="category_id[]" id="category_id_<?php echo $i; ?>" onchange="GetCategoryType(this.value,<?php echo $i;?>)" class="form-control">
                                                    <?php echo $c_str; ?>
                                                  </select>
                                                </td>
                                                <td>
                                                  <?php 
                                                    $type = $res_product['type'];
                                                    $cid = $res_product['category_id'];
                                                    if($cid != ""){
                                                        $c_type = '<option value="">Please Select</option>';
                                                        if($type == "Product") {
                                                            $query = "SELECT tpt.id,tpt.product_type_name as type_name FROM tbl_product_type tpt LEFT JOIN tbl_user tu ON tu.add_uid = tpt.add_uid WHERE tpt.status = '1' AND tpt.category_id = '$cid' AND tu.id = '$uid_task'";
                                                        } else {
                                                            $query = "SELECT tst.id,tst.service_type_name as type_name FROM tbl_service_type tst LEFT JOIN tbl_user tu ON tu.add_uid = tst.add_uid WHERE tst.status = '1' AND tst.category_id = '$cid' AND  tu.id = '$uid_task'";
                                                        }    
                                                        $t_res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
                                                        while ($t_row = mysqli_fetch_assoc($t_res)){
                                                            if($res_product['category_type_id']==$t_row["id"]){
                                                              $c_type .= '<option value="'.$t_row["id"].'" selected>'.$t_row["type_name"].'</option>';
                                                            }else {
                                                              $c_type .= '<option value="'.$t_row["id"].'">'.$t_row["type_name"].'</option>';
                                                            } 
                                                        }
                                                    }
                                                    else{
                                                        $c_type = '<option value="">Please Select</option>';
                                                    }
                                                  ?>
                                                  <select name="category_type_id[]" id="category_type_id_<?php echo $i; ?>" onchange="GetProductService(this.value,<?php echo $i;?>)" class="form-control">
                                                    <?php echo $c_type; ?>
                                                  </select>
                                                </td>
                                                <td>
                                                  <?php 
                                                    $tid = $res_product['category_type_id'];
                                                    $type = $res_product['type'];
                                                    if($tid != ""){
                                                        $p_str = '<option value="">Please Select</option>';
                                                        if($type == "Product"){
                                                            $query = "SELECT tp.id,tp.product_name as pname FROM tbl_product tp LEFT JOIN tbl_user tu ON tu.add_uid = tp.add_uid WHERE tp.product_type_id = '$tid' AND tp.status = '1' AND tu.id = '$uid_task'";
                                                        } else{
                                                            $query = "SELECT ts.id,ts.service_name as pname FROM tbl_service ts LEFT JOIN tbl_user tu ON tu.add_uid = ts.add_uid WHERE ts.service_type_id = '$tid' AND ts.status = '1' AND tu.id = '$uid_task'";    
                                                        }
                                                        $p_res = mysqli_query($mysqli, $query) or fatal_error('MySQL Error: ' . mysqli_errno($mysqli));
                                                        while ($p_row = mysqli_fetch_assoc($p_res)){
                                                          if($res_product['product_id']==$p_row["id"]){
                                                            $p_str .= '<option value="'.$p_row["id"].'" selected>'.$p_row["pname"].'</option>';
                                                          } else{
                                                            $p_str .= '<option value="'.$p_row["id"].'">'.$p_row["pname"].'</option>';
                                                          }
                                                        }
                                                    }
                                                    else{
                                                        $p_str = '<option value="">Please Select</option>';
                                                    }
                                                  ?>
                                                  <select  name="product_id[]" id="product_id_<?php echo $i; ?>" class="form-control">
                                                    <?php echo $p_str; ?>
                                                  </select>
                                                </td>
                                                <td>
                                                  <input type="text" id="qty_<?php echo $i; ?>" name="qty[]" value="<?php echo $res_product['qty']; ?>" class="form-control number" placeholder="Enter Here">
                                                </td>
                                                <td>
                                                  <button type="button" class="btn btn-success" onclick="add()">+</button>
                                                </td>
                                              </tr>
                                              <?php $i++; } } else{ ?>
                                              <tr style="background-color: #bed6d652">
                                                <td>
                                                  <div class="hide_spin_0" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
                                                </td>
                                                <td>
                                                  <select onchange="GetCategory(this.value,0)" name="type[]" id="type_0" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <option value="Product">Product</option>
                                                    <option value="Service">Service</option>
                                                  </select>                                                  
                                                </td>
                                                <td>
                                                  <select name="category_id[]" id="category_id_0" onchange="GetCategoryType(this.value,0)" class="form-control">
                                                    <option value="">Please Select</option>
                                                  </select>
                                                </td>
                                                <td>
                                                  <select name="category_type_id[]" id="category_type_id_0" onchange="GetProductService(this.value,0)" class="form-control">
                                                    <option value="">Please Select</option>
                                                  </select>
                                                </td>
                                                <td>
                                                  <select  name="product_id[]" id="product_id_0" class="form-control">
                                                    <option value="">Please Select</option>
                                                  </select>
                                                </td>
                                                <td>
                                                  <input type="text" id="qty_0" name="qty[]" class="form-control number" placeholder="Enter Here">
                                                </td>
                                                <td>
                                                  <button type="button" class="btn btn-success" onclick="add()">+</button>
                                                </td>
                                              </tr>
                                              <?php } ?>
                                            </tbody>
                                          </table>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes" class="control-label col-md-2">Notes </label>
                                            <div class="col-md-10">
                                              <textarea class="textarea" id="notes" name="notes" placeholder="Enter Notes  Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
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
        <script src="../bower_components/moment/min/moment.min.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.textarea').wysihtml5();
                $('#project_id').select2();
                $('#assigned_to').select2();
                $('#milestone_id').select2();
                $('#start_date').datepicker({
                    autoclose: true,
                    //startDate: new Date(),
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                }).on("changeDate", function (selected) {
                  var minDate = new Date(selected.date.valueOf());
                  $('#end_date').datepicker('setStartDate', minDate);
                });
                $('#end_date').datepicker({
                    autoclose: true,
                    //startDate: new Date(),
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    changeMonth: true,
                    changeYear: true,
                }).on("changeDate", function (selected) {
                  var maxDate = new Date(selected.date.valueOf());
                  $('#start_date').datepicker('setEndDate', maxDate);
                });  
                DecimalOnly();
              });
              function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("task_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/task.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_task.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_task.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("task_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/task.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_task.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_task.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function GetCategory(sid,divid){
              $(".hide_spin_"+divid).show();
              if(sid != ""){
                $.ajax({
                    url: "ajax/task.php",
                    type: "POST",
                    data: {sid:sid,cmd:"GetCategory"},
                    dataType:"JSON",
                    success:function(data){
                        $("#category_id_"+divid).html(data.string);
                        $(".hide_spin_"+divid).hide();
                    }   
                });  
              }
              else{
                $("#category_type_id_"+divid).html('<option value="">Please Select</option>');
                $("#product_id_"+divid).html('<option value="">Please Select</option>');
                $("#category_id_"+divid).html('<option value="">Please Select</option>');
                $("#qty_"+divid).val('');
                $(".hide_spin_"+divid).hide();
              }
              
            }
            function GetCategoryType(cid,divid){
              $(".hide_spin_"+divid).show();
              var type = $("#type_"+divid).val();
              if(cid != ""){
                $.ajax({
                    url: "ajax/task.php",
                    type: "POST",
                    data: {cid:cid,type:type,cmd:"GetCategoryType"},
                    dataType:"JSON",
                    success:function(data){
                        $("#category_type_id_"+divid).html(data.string);
                        $(".hide_spin_"+divid).hide();
                    }   
                });
              }
              else{
                  $("#category_type_id_"+divid).html('<option value="">Please Select</option>');
                  $("#product_id_"+divid).html('<option value="">Please Select</option>');
                  $("#qty_"+divid).val('');
                  $(".hide_spin_"+divid).hide();
              }
              
            }
            function GetMilestone(pid){
              $("#hide_spin").show();
              $.ajax({
                  url: "ajax/task.php",
                  type: "POST",
                  data: {pid:pid,cmd:"GetMilestone"},
                  dataType:"JSON",
                  success:function(data){
                      $("#milestone_id").html(data.string);
                      $("#hide_spin").hide();
                  }   
              });
            }
            function GetProductService(tid,divid){
              $(".hide_spin_"+divid).show();
              var type = $("#type_"+divid).val();
              if(tid != ""){
                $.ajax({
                    url: "ajax/task.php",
                    type: "POST",
                    data: {tid:tid,type:type,cmd:"GetProductService"},
                    dataType:"JSON",
                    success:function(data){
                        $("#product_id_"+divid).html(data.string);
                        $(".hide_spin_"+divid).hide();
                    }   
                });
              }
              else{
                $("#product_id_"+divid).html('<option value="">Please Select</option>');
                $("#qty_"+divid).val('');
                $(".hide_spin_"+divid).hide();
              }
              
            }
            var i = 1;
            function add(){
              if(i%2 == 0){ colour = '#bed6d652'; } else{ colour = '#bed6d685'; }
              var string = '';
              string = '<tr style="background-color: '+colour+'" id="main_'+i+'">';

              string += '<td><div class="hide_spin_'+i+'" style="display: none"><i class="fa fa-refresh fa-spin"></i></div></td>';

              string += '<td><select onchange="GetCategory(this.value,'+i+')" name="type[]" id="type_'+i+'" class="form-control"><option value="">Please Select</option><option value="Product">Product</option><option value="Service">Service</option></select></td>';

              string += '<td><select name="category_id[]" id="category_id_'+i+'" onchange="GetCategoryType(this.value,'+i+')" class="form-control"><option value="">Please Select</option></select></td>';

              string += '<td><select name="category_type_id[]" id="category_type_id_'+i+'" onchange="GetProductService(this.value,'+i+')" class="form-control"><option value="">Please Select</option></select></td>';

              string += '<td><select name="product_id[]" id="product_id_'+i+'"  class="form-control"><option value="">Please Select</option></select></td>';

              string += '<td><input type="text" id="qty_'+i+'" name="qty[]" class="form-control number" placeholder="Enter Here"></td>';

              string += '<td><button type="button" class="btn btn-danger" onclick="remove('+i+')">-</button></td>';

              string += '</tr>';      
              $("#myTable tr:last").after(string);
              i++;
            }
            function remove(divid){
              $("#main_"+divid).remove();
            }
        </script>
    </body>
</html>