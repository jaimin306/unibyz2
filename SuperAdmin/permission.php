<?php
  include ("includes/session.php");
  include ("../dbConnect.php");
  include ("includes/general.php");
  $id = decrypt($_GET["EID"]);
  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ABC Painting Co.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include ("includes/links.php");?>
        <style type="text/css">
        .tbl-permit td:first-child { 
          width: 50%;
          vertical-align: middle;
          font-weight: bold;
        }
        .tbl-permit{
          border:1px solid black;
        }
        .checkbox, .radio{
          margin: 1px;
        }
        .icheckbox_square-blue, .iradio_square-blue{
          border: 0.5px solid #b5acac;
        }
        .icheckbox_square-blue .custom-box{
          border: 1px solid black;
        }
        </style>
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
                        <li class="active">Permission</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Manage Permission</h3>
                                </div>
                                <div class="container">
                                    <form role="form" method="post" id="permission_form" action="#" onsubmit="return submitForm();" enctype="multipart/form-data">
                                      <input type="hidden" name="id" id="hidden_id" value="<?php echo (isset($id) ? $id : ''); ?>" />
                                      <div class="box-body">
                                        <table class="table table-striped table-bordered table-hover tbl-permit">
                                          <tr>
                                            <td class="text-danger">Select All</td>
                                            <td><div class="checkbox icheck">
                                              <input type="checkbox" id="selectAll" class="all"></div>
                                            </td>
                                          </tr>
                                          <?php
                                            $query = "SELECT * FROM tbl_menu";
                                            $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                            while($row = mysqli_fetch_assoc($res)){
                                              ?>
                                              <tr>
                                                <td><?php echo $row["menu_name"]; ?></td>
                                                <td><div class="checkbox icheck">
                                                  <input type="checkbox" id="<?php echo $row['id']; ?>" name="menu_id[]" ></div>
                                                </td>
                                              </tr>
                                              <?php
                                            }
                                          ?>
                                        </table>
                                      </div>
                                      <div class="box-footer">
                                        <?php
                                        if (isset($id) && $id != "") {
                                            echo '<button type="submit" class="btn btn-primary">Update</button>';
                                        } else {
                                            echo '<button type="submit" class="btn btn-primary">Save</button>';
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
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../dist/js/demo.js"></script>
        <script type="text/javascript">
            $(function () {
                $('input').iCheck({
                  checkboxClass: 'icheckbox_square-blue',
                  radioClass: 'iradio_square-blue',
                  increaseArea: '10%' // optional
                });
                var checkAll = $('input.all');
                var checkboxes = $('input.check');
                checkAll.on('ifChecked ifUnchecked', function(event) {        
                    if (event.type == 'ifChecked') {
                        checkboxes.iCheck('check');
                    } else {
                        checkboxes.iCheck('uncheck');
                    }
                });

                checkboxes.on('ifChanged', function(event){
                    if(checkboxes.filter(':checked').length == checkboxes.length) {
                        checkAll.prop('checked', 'checked');
                    } else {
                        checkAll.removeProp('checked');
                    }
                    checkAll.iCheck('update');
                });
            });
           
            
            function submitForm() {    
                var formid = $("#hidden_id").val();        
                if(formid != "" && formid != "0"){
                  var form_data = new FormData(document.getElementById("permission_form"));
                  form_data.append("cmd", "update");
                  form_data.append("id", formid);
                  $.ajax({
                      url: "ajax/permission.php",
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