<?php
    include('includes/session.php');
    include("../dbConnect.php");
    include('includes/general.php');
    $id = decrypt($_GET["EID"]);
    $query = "SELECT * FROM tbl_category WHERE status = '1' and id = '$id'";
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
        <?php include("includes/links.php"); ?>
        <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.min.css">
        <style type="text/css">
          .fc-title{font-weight: bold}
        </style>
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
                        <li class="active">Project Calendar</li>
                    </ol>
                </section>
                <section class="content"> 
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-body" style="padding:20px !important">
                          <div id="calendar"></div>
                        </div>
                        <div id="calendarModal" class="modal ">
                          <div class="modal-dialog jackInTheBox animated" style="width:800px">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                                <h4 id="modalTitle" class="modal-title"></h4>
                              </div>
                              <div id="pdetail" class="modal-body">
                                <div class="progress" title="">
                                  <div class="progress-bar progress-bar-success progress-bar-striped active text-danger progress-val" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="border-radius:10px;font-size:14px;font-weight: bold"></div>
                                </div>
                                <table class="table table-striped table-bordered table-hover ">
                                  <tr>
                                    <td><b>Estimate No.</b></td>
                                    <td id="estimate_no"></td>
                                    <td><b>Customer</b></td>
                                    <td id="customer_name"></td>
                                  </tr>
                                  <tr>
                                    <td><b>Project Manager</b></td>
                                    <td id="project_manager"></td>
                                    <td><b>Status</b></td>
                                    <td id="project_status"></td>
                                  </tr>
                                  <tr>
                                    <td><b>Start Date</b></td>
                                    <td id="start_date"></td>
                                    <td><b>End Date</b></td>
                                    <td id="end_date"></td>
                                  </tr>
                                </table>
                                <h4 class="modal-title">Task Details</h4>
                                <table class="table table-hover table-bordered">
                                  <tr>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                  </tr>
                                  <tbody id="task_table"></tbody>
                                </table>

                                 <h4 class="modal-title">Incidents</h4>
                                <table class="table table-hover table-bordered">
                                 <tr>
                                     <th >No.</th>
                                     <th >Status</th>
                                     <th >Type</th>
                                     <th >Department</th>
                                     <th >Subject</th>
                                     <th >Notify To</th>
                                     <th >Created Date</th>                                      
                                 </tr> 
                                  <tbody id="incident_table"></tbody>
                                </table>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                              </div>
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
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="../bower_components/fastclick/lib/fastclick.js"></script> 
        <script src="../dist/js/adminlte.min.js"></script> 
        <script src="../dist/js/demo.js"></script>
        <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script>
          $(function () {
            $('#calendar').fullCalendar({
              header    : {
                left  : 'prev,next today',
                center: 'title',
                right : 'month,agendaWeek,agendaDay'
              },
              buttonText: {
                today: 'Today',
                month: 'Month',
                week : 'Week',
                day  : 'Day'
              },
              events    : {url: 'ajax/calendar.php?cmd=select'},
              eventRender: function(event, element) {
                  element.attr("project_id",event.project_id);
                  element.attr("encrypt_project_id",event.encrypt_project_id);
                  // alert(event.encrypt_project_id);
                  // element.attr("encrypt_project_id",event.encrypt_project_id);
              },
              eventClick:  function(event, jsEvent, view) {
                  $('#modalTitle').html(event.title+"<a href='project.php?EID="+event.encrypt_project_id+"'><button class='btn btn-primary pull-right' style='margin-right:15px'><i class='fa fa-edit'></i> &nbsp;&nbsp;Edit Project</button></a>");
                  $('#modalBody').html(event.description);
                  $.ajax({
                      url: "ajax/calendar.php",
                      type: "POST",
                      data: {project_id:event.project_id,cmd:"GetProjectDetails"},
                      dataType:"JSON",
                      success:function(data){
                          $("#estimate_no").html(data.estimate_no);
                          $("#customer_name").html(data.customer_name);
                          $("#project_manager").html(data.project_manager);
                          $("#project_status").html(data.project_status);
                          $("#start_date").html(data.start_date);
                          $("#end_date").html(data.end_date);
                          $("#task_table").html(data.task_table);
                          $("#incident_table").html(data.incidents);
                          //alert(data.progressbar_color);
                          if(data.progressbar != "0.00%"){
                            $(".progress-val").css("width",data.progressbar);
                            $(".progress-val").html(data.progressbar);                             
                            $('.progress-val').removeClass('progress-bar-danger progress-bar-warning progress-bar-success progress-bar-primary');
                            $(".progress-val").addClass(data.progressbar_color);
                          }
                          else{
                            $(".progress-val").css("width","0%");
                            $(".progress-val").html("0.00%").css("color","rgba(208, 87, 87, 0.91)");
                          }
                      }
                  });
                  $("#calendarModal").modal("show");
              },
            });
          });
        </script>
    </body>
</html>