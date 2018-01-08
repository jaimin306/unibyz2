<?php
  include ("includes/session.php");
  include ("../dbConnect.php");
  include ("includes/general.php");
  $id = decrypt($_GET["EID"]);
  $query = "SELECT tu.*,tu.id,tc.company_name,tc.company_logo,tc.state,tc.license_no FROM tbl_user tu LEFT JOIN tbl_company_detail tc ON tc.user_id = tu.id WHERE tu.status = '1' AND tu.id = '$id'";
  $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
  $row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include "includes/links.php";?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include "includes/header.php";?>
            <?php include "includes/sidebar.php";?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>&nbsp;</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Entity</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Add Entity</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="entity_form" class="form-horizontal" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="first_name" class="control-label col-md-2">First Name  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="first_name" value="<?php echo (isset($id) ? $row['first_name'] : ''); ?>" name="first_name" placeholder="Enter First Name Here" >
                                          </div>
                                          <label for="last_name" class="control-label col-md-2">Last Name  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="last_name" value="<?php echo (isset($id) ? $row['last_name'] : ''); ?>" name="last_name" placeholder="Enter Last Name Here" >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="company_name" class="control-label col-md-2">Company Name  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="company_name" value="<?php echo (isset($id) ? $row['company_name'] : ''); ?>" name="company_name" placeholder="Enter Company Name Here"  >
                                          </div>
                                          <label for="phone" class="control-label col-md-2">Phone  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="phone" value="<?php echo (isset($id) ? $row['phone'] : ''); ?>" name="phone" placeholder="Enter Phone Here"  >
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="password" class="control-label col-md-2">Password <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="password" class="form-control" id="password" value="" name="password" placeholder="Enter Password Here" <?php echo (isset($id) && ($id != 0) ? 'readonly' : '&nbsp;'); ?> <?php echo (isset($id) && ($id != 0) ? '' : 'required="required"'); ?>>
                                          </div>
                                          <label for="repeat_password" class="control-label col-md-2">Repeat Password <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="password" class="form-control" id="repeat_password" value="<?php echo (isset($id) ? $row['repeat_password'] : ''); ?>" name="repeat_password" placeholder="Enter Repeat Password Here" <?php echo (isset($id) && ($id != 0) ? 'readonly' : ''); ?> <?php echo (isset($id) && ($id != 0) ? '' : 'required="required"'); ?>><span id="message"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">                                          
                                          <label for="email" class="control-label col-md-2">Email <span class="text-danger">*</span></label>
                                          <div class="col-md-4">
                                            <input type="email" class="form-control" id="email" value="<?php echo (isset($id) ? $row['email'] : ''); ?>" name="email" placeholder="Enter Email Here" required="required" autocomplete="off"><span id="EmailMessage"></span>
                                          </div>
                                          <label for="company_logo" class="control-label col-md-2">Company Logo</label>
                                          <div class="col-md-4">
                                            <input type="file" name="company_logo" id="company_logo" class="form-control" >
                                            <input type="hidden" name="hidden_photo_path" value="<?php echo (isset($id) ? $row['company_logo'] : ''); ?>">
                                          </div>
                                        </div>
                                        <div class="form-group">                                          
                                          <label for="state" class="control-label col-md-2">State  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="state" value="<?php echo (isset($id) ? $row['state'] : ''); ?>" name="state" placeholder="Enter State Here"  autocomplete="off">
                                          </div>
                                          <label for="license_no" class="control-label col-md-2">License Number  </label>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="license_no" value="<?php echo (isset($id) ? $row['license_no'] : ''); ?>" name="license_no" placeholder="Enter License Number Here"   autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="address" class="control-label col-md-2">Address</label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="address" placeholder="Enter Address Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['address'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="notes" class="control-label col-md-2">Notes</label>
                                          <div class="col-md-10">
                                            <textarea class="textarea" name="notes" placeholder="Enter Notes Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo (isset($id) ? $row['notes'] : ''); ?></textarea>
                                          </div>
                                        </div>
                                        
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if (isset($id) && $id != "") {
                                            echo '<button type="submit" class="btn btn-primary col-sm-offset-2">Update</button>';
                                        } else {
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
            <?php include ("includes/footer.php");?>
            <?php include ("includes/nav-sidebar.php");?>
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
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.textarea').wysihtml5();
                $('#password, #repeat_password').on('keyup', function () {
                    if ($('#password').val() == $('#repeat_password').val()) {
                        $('#message').html('Password Matched.').css('color', 'green');
                    } else {
                        $('#message').html('Password Not Matched.. Please re-enter correct password.').css('color', 'red');
                    }
                });
                $('#email').on('keyup', function () {
                    var email = $("#email").val();
                    $.ajax({
                        url: "ajax/entity.php",
                        type: "POST",
                        data: {email:email,cmd:"CheckEmail"},
                        dataType:"JSON",
                        success:function(data){
                            if(data.result == "true"){
                                $('#EmailMessage').html(data.msg);
                            }
                            else{
                                $('#EmailMessage').html(data.msg).css('color', 'red');
                            }
                        }   
                    });
                });
                
            });
            
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("entity_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/entity.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_entity.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_entity.php?status="+(data.status);
                          }
                      }   
                  });
                  return false; 
                }
                else{
                  var form_data = new FormData(document.getElementById("entity_form"));
                  form_data.append("cmd", "insert");
                  $.ajax({
                      url: "ajax/entity.php",
                      type: "POST",
                      data: form_data,
                      dataType:"JSON",
                      processData: false,
                      contentType: false,
                      success:function(data){
                          if(data.result == "true"){
                              window.location.href="list_entity.php?status="+(data.status);
                          }
                          else{
                              window.location.href="list_entity.php?status="+(data.status);
                          }
                      }   
                  });
                  return false;       
                }
            }
            function confirmDelete() {
                return confirm("Are You Sure To Delete Selected Record ?");
            }
        </script>
    </body>
</html>