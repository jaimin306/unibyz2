<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_expense WHERE status = '1' and id = '$id'";
    $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
    $row = mysqli_fetch_assoc($res);
    $uid_expense = $_SESSION["user_id"];
    // $gender = isset($id) ? $row["gender"] : '';
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
                        <li class="active">Expense</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Expense</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="expense_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="expense_type_id" class="control-label col-md-2">First Name</label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="expense_type_id" id="expense_type_id">
                                            <option value="">Select</option>
                                             <?php
                                                $query_expense = "SELECT id,expense_type FROM tbl_expense_type WHERE status = '1' AND add_uid = '$uid_expense'";
                                                $res_expense = mysqli_query($mysqli,$query_expense) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                while($row_expense = mysqli_fetch_assoc($res_expense)){
                                                  ?>
                                                    <option value="<?php echo $row_expense['id']; ?>" <?php if(isset($id) && $id != ""){ echo ($row_expense['id'] == $row["expense_type_id"]) ? "selected='selected'" : "";} ?>><?php echo $row_expense['expense_type']; ?></option>
                                                  <?php
                                                }
                                              ?>
                                            </select>
                                          </div>
                                          <label for="expense_amount" class="control-label col-md-2">Expense Amount</label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control number" id="expense_amount" value="<?php echo (isset($id) ? $row['expense_amount'] : ''); ?>" name="expense_amount" placeholder="Enter Expense Amount Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="e_date" class="control-label col-md-2">Date</label>
                                          <div class="col-md-4">
                                            <input type="text" value="<?php echo (isset($id) ? $row['e_date'] : ''); ?>" class="form-control readonly" name="e_date" id="e_date" >
                                          </div>
                                          <label for="recurring" class="control-label col-md-2">Is Expense Recurring? </label>
                                          <div class="col-md-4">
                                            <select class="form-control" name="recurring" id="recurring">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>                                             
                                            </select>
                                          </div>
                                        </div>                                        
                                        <div class="form-group">
                                          <label for="description" class="col-md-2 control-label" >Desription</label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="description" placeholder="Enter Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['description'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                         <div class="form-group">                                             
                                          <label for="user_image" class="col-md-2 control-label">Files(doc, pdf, image) </label>
                                          <div class="col-md-10">
                                            <input type="file" class="form-control"  id="user_image" name="user_image[]" multiple>
                                            <div style="color:red;" id="img-msg"></div>
                                            <input type="hidden" name="hidden_image" id="hidden_image" value="0" readonly>
                                            <div>You can select up to 30 files. Please click Browse button and then hold Ctrl button on your keyboard to select multiple files.</div>
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
              DecimalOnly(); 
              $('#e_date').datepicker({
                autoclose: true,
                // startDate: new Date(),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                changeMonth: true,
                changeYear: true,
              }).on("changeDate", function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#end_date').datepicker('setStartDate', minDate);
              });                           
            });
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("expense_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/expense.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_expense.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_expense.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("expense_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/expense.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_expense.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_expense.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            } 
        </script>

      <script type="text/javascript">
        $(document).ready(function(){
            $('#user_image').change(function(){
              $('#img-msg').html('');
              $('#hidden_image').val('0');
              
               var fp = $("#user_image");
               var lg = fp[0].files.length; // get length
               var items = fp[0].files;
              var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp','doc','docx','pdf'];
               if(lg>30){
                $('#img-msg').html('only 30 files allowed..');   
                $('#hidden_image').val('1');              
                return false;
               }
               for (var i = 0; i < lg; i++) {
                  fileName =  items[i].name; // get file name
                  extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
                  if($.inArray(extension, fileExtension) == -1) {
                      $('#img-msg').html('File type is not allowed...');
                      $('#hidden_image').val('1');          
                      return false;
                  }
               } 
               
            });
        });
    </script>

    </body>
</html>