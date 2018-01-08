<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $uid_email = $_SESSION["user_id"];
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
      <div id="loadingDivFull" style="display: none;"></div>
        <div class="wrapper">
            <?php include("includes/header.php"); ?>
            <?php include("includes/sidebar.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1> &nbsp;  </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $admin_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo $admin_url.'list_email.php'; ?>"><i class="fa fa-envelope"></i> All Email</a></li>
                        <li class="active">Email</li>
                    </ol>
                </section>
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                          <div id="result_mail"></div>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Send Email</h3>
                                </div>
                                <div class="container">
                                  <div class="col-md-12">
                                    <div class="col-md-8">
                                      <form role="form" method="post" enctype="multipart/form-data" class="form-horizontal" id="email_form" onsubmit="return submitForm();">
                                        <div class="box-body">
                                          <div class="form-group">
                                              <label for="to_user_id" class="control-label col-md-2" >To <span class="text-danger">*</span></label>
                                              <div class="col-md-10">
                                                  <select class="form-control" required="required" name="to_user_id" id="to_user_id">
                                                    <option value="">Please Select Name</option>
                                                    <?php 
                                                      $query = "SELECT id,first_name,last_name FROM tbl_user WHERE add_uid = '$uid_email' AND user_type = '2'";
                                                      $res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
                                                      while($row=mysqli_fetch_assoc($res)){
                                                        echo '<option value="'.$row["id"].'">'.$row["first_name"]." ".$row["last_name"].'</option>';
                                                      }
                                                    ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="subject" class="control-label col-md-2 ">Subject <span class="text-danger">*</span></label>
                                              <div class="col-md-10">
                                                  <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject Here" required="required">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="message" class="control-label col-md-2 ">Message </label>
                                              <div class="col-md-10">
                                                  <textarea name="message" class="textarea" placeholder="Enter Address Here" style="border: 1px solid #dddddd; padding: 10px;width: 100%" ></textarea>
                                              </div>
                                          </div>
                                          <div class="form-group">        
                                            <div class="col-sm-offset-2 col-md-10">
                                              <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                    <div class="col-md-4">
                                      <table class="table table-hover table-bordered table-striped">
                                        <tr>
                                          <td colspan="2">In your email you can use any of the following :</td>
                                        </tr>
                                        <tr>
                                          <th>Tag</th>
                                          <th>Description</th>
                                        </tr>
                                        
                                        <tr>
                                          <td>{first_name}</td>
                                          <td>Write First Name</td>
                                        </tr>
                                        <tr>
                                          <td>{last_name}</td>
                                          <td>Write Last Name</td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
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
        <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../dist/js/custom.js"></script>
        <script type="text/javascript">
            $(function () {
              $('.textarea').wysihtml5();
              $('#to_user_id').select2();
            });
            function submitForm() {   
              $("#loadingDivFull").fadeIn( "slow" );
                var form_data = new FormData(document.getElementById("email_form"));
                form_data.append("cmd", "InsertAndMail");
                $.ajax({
                    url: "ajax/email.php",
                    type: "POST",
                    data: form_data,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.result == "true"){
                          $("#result_mail").html('<div class="alert alert-info alert-dismissible"><b><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+(data.msg)+'</b></div>');
                          $('#email_form')[0].reset();
                          $("#loadingDivFull").fadeOut( "slow" );
                          $("#to_user_id").select2("destroy");
                          $("#to_user_id").select2();
                        }
                        else{
                          $("#result_mail").html('<div class="alert alert-danger alert-dismissible"><b><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+(data.msg)+'</b></div>');
                          $("#loadingDivFull").fadeOut( "slow" );
                        }
                    }   
                });
                return false; 
            }
            
        </script>
    </body>
</html>