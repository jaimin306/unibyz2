<?php
include('includes/session.php');
include("../dbConnect.php");
include('includes/general.php');
$id = decrypt($_GET["VID"]);
$query = "SELECT tt.*,tu.first_name, tu.last_name,td.department_name as department_id FROM tbl_ticket tt LEFT JOIN tbl_user tu ON tu.id = tt.reporter_id LEFT JOIN tbl_department td ON td.id = tt.department_id WHERE tt.status = '1' AND tt.id = '$id'";
$res = mysqli_query($mysqli,$query) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
$row = mysqli_fetch_assoc($res);
$Priority = $row["priority"];
$TicketStatus = $row["ticket_status"];
if (!empty($_GET['status'])) {
  switch ($_GET['status']) {
    case 'success':
    $statusMsgClass = 'alert-success';
    $statusMsg      = 'Ticket Message Added Successfully';
    break;
    case 'error':
    $statusMsgClass = 'alert-danger';
    $statusMsg      = 'Error In Adding Ticket Message... Please Try Again';
    break;
    default:
    $statusMsgClass = '';
    $statusMsg      = '';
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ABC Painting Co.</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include("includes/links.php"); ?>
  <link rel="stylesheet" type="text/css" href="../dist/css/jquery.fancybox.min.css">

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
          <li><a href="<?php echo $admin_url.'list_ticket.php'; ?>"><i class="fa fa-dashboard"></i> All Tickets</a></li>
          <li class="active">Ticket</li>
        </ol>
      </section>
      <section class="content" > 
        <div class="row">
          <div class="col-md-12" >
            <div class="box box-primary">
              <?php
                if($TicketStatus == "0"){
                  echo '<div class="ribbon-primary"><span>Open</span></div>';
                }
                if($TicketStatus == "1"){
                 echo '<div class="ribbon-danger"><span>Closed</span></div>'; 
                }
                if($TicketStatus == "2"){
                 echo '<div class="ribbon-warning"><span>Progress</span></div>'; 
                }
                if($TicketStatus == "3"){
                 echo '<div class="ribbon-green"><span>Answered</span></div>'; 
                }
              ?>
              <div class="container">
                <div class="box-header with-border">
                  <h2 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ticket | Tickets - #<?php echo $row["id"]; ?></h2>
                  <div class="box-tools pull-right" >
                    <a href="ticket.php?EID=<?php echo encrypt($id); ?>" data-toggle="tooltip" class="btn btn-sm bg-blue" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-sm bg-red btndeleteselected" data-toggle="tooltip" value="<?php echo $id; ?>" title="" data-original-title="Delete"><i class="fa fa-trash"></i> </a>
                    <div class="btn-group">
                      <button class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">Change Status <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <?php if($TicketStatus != "0"){ ?>
                        <li>
                          <a href="javascript:" class="btnstatuschange" value="0" title="">Open </a>
                        </li> <?php } ?>
                        <?php if($TicketStatus != "1"){ ?>
                        <li>
                          <a href="javascript:" class="btnstatuschange" value="1">Close </a>
                        </li>
                        <?php } ?> 
                        <?php if($TicketStatus != "2"){ ?>
                        <li>
                          <a href="javascript:" class="btnstatuschange" value="2"> In Progress </a>
                        </li> <?php } ?>
                        <?php if($TicketStatus != "3"){ ?>
                        <li>
                          <a href="javascript:" class="btnstatuschange" value="3"> Answered </a>
                        </li><?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4">
                      <ul class="list-group no-radius">
                        <li class="list-group-item">
                          <span class="pull-right">#<?php echo $id; ?></span><b>Ticket Code</b>
                        </li>
                        <li class="list-group-item">
                          <span class="pull-right"><?php echo $row["first_name"]." ".$row["last_name"]; ?></span><b>Reporter</b></li>
                        <li class="list-group-item">
                          <span class="pull-right"><?php echo $row["department_id"]; ?></span><b>Department</b>
                        </li>
                        
                        <li class="list-group-item">
                          <span class="pull-right">
                              <?php 
                                  if($Priority == "High"){ echo '<span class="label label-danger" style="font-size:11px">'.$Priority.'</span>';}
                                  if($Priority == "Medium"){ echo '<span class="label label-warning" style="font-size:11px">'.$Priority.'</span>';}
                                  if($Priority == "Low"){ echo '<span class="label label-info" style="font-size:11px">'.$Priority.'</span>';}
                                ?>
                          </span><b>Priority</b>
                        </li>
                        <li class="list-group-item">
                          <span class="pull-right"><?php echo EplapseTime($row["add_date"]); ?></span><b>Created</b>
                        </li>
                        <li class="list-group-item">
                          <span class="pull-right"><?php echo date("Y-m-d / H:i:s", strtotime($row["add_date"])); ?></span><b>Date / Time</b>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-12">
                          <blockquote style="font-size:14.5px">
                            <?php echo "<b>".$row["subject"]."</b>"; ?><br>
                            <?php echo $row["ticket_message"]; ?>
                          </blockquote>
                          <br> <?php if($row["photo_path"] != ""){ echo $row["photo_path"];} ?> &nbsp;
                          <?php
                          if($row["photo_path"] != ""){
                            echo '<a data-fancybox="gallery" data-toggle="tooltip" data-original-title="View File" href="../uploads/ticket/'.$row["photo_path"].'"><i class="fa fa-eye"></i> View</a> &nbsp;&nbsp;<a href="../uploads/ticket/'.$row["photo_path"].'" data-toggle="tooltip" data-original-title="Download File" download><i class="fa fa-download"></i> Download </a><br><br>';}
                          ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div style="display:none" id="loading_spin"><i class="fa fa-refresh fa-spin"></i></div>
                          <div id="result_message"></div>
                          
                        </div>
                      </div>
                      <form method="POST" id="reply_form" onsubmit="return submitForm();" enctype="multipart/form-data">
                        <input name="hidden_id" id="hidden_id" type="hidden" value="<?php echo $id; ?>">
                        <div class="row">
                          <input class="form-control" name="ticket_id" id="ticket_id" type="hidden" value="<?php echo $id; ?>">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-line">
                                <textarea class="textarea" name="message" id="message" placeholder="Enter Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-line">
                                <label for="Attachment" class="">Attachment</label>
                                <input type="file" name="attachment" id="attachment" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-sm-12">
                              <div class="pull-right">
                                <button type="submit" id="" class="btn btn-primary" name="">Reply</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
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
  <script src="../dist/js/jquery.fancybox.min.js"></script>
  <script src="../dist/js/adminlte.min.js"></script> 
  <script src="../dist/js/demo.js"></script>
  <script type="text/javascript">
    $(function () {
      GetMessage();
      $(".textarea").wysihtml5();
      $(document).on('click','.btndeleteselected',function () {
        if (confirmDelete()) {
          var id = $(this).attr('value');
          $.ajax({
            url: "ajax/ticket.php",
            type: "POST",
            data: {id:id, cmd:"delete"},
            dataType:"JSON",
            success:function(data){
              if(data.result == "true"){
                window.location.href="list_ticket.php?status="+(data.status);
              }
              else{
                window.location.href="list_ticket.php?status="+(data.status);
              }
            }   
          });
        } 
      });
      $(document).on('click','.btnstatuschange',function () {
        if (confirmChangeStatus()) {
          var statusval = $(this).attr('value');
          var id = $("#ticket_id").val();
          $.ajax({
            url: "ajax/ticket.php",
            type: "POST",
            data: {statusval:statusval,ticket_id:id, cmd:"ChangeStatus"},
            dataType:"JSON",
            success:function(data){
              if(data.result == "true"){
                window.location.href="list_ticket.php?status="+(data.status);
              }
              else{
                window.location.href="list_ticket.php?status="+(data.status);
              }
            }   
          });
        } 
      });
      $(document).on('click','.btndeletemessageselected',function () {
        if (confirmDeleteMessage()) {
          $("#loading_spin").show();
          var id = $(this).attr('value');
          $.ajax({
            url: "ajax/ticket.php",
            type: "POST",
            data: {id:id, cmd:"deleteMessage"},
            dataType:"JSON",
            success:function(data){
              if(data.result == "true"){
                $("#loading_spin").hide();
                GetMessage();
              }
              else{
                $("#loading_spin").hide();
              }
            }   
          });
        } 
      });
    });
    function submitForm() {    
      var formid = $("#hidden_id").val();     
      var ticket_message = $("#message").val();     
      if(ticket_message != ""){
         $("#loading_spin").show();
         $("#result_message").css("opacity","0.5");
        var form_data = new FormData(document.getElementById("reply_form"));
        form_data.append("cmd", "InsertMessage");
        $.ajax({
            url: "ajax/ticket.php",
            type: "POST",
            data: form_data,
            dataType:"JSON",
            processData: false,
            contentType: false,
            success:function(data){
                if(data.result == "true"){
                  setTimeout(function(){ $("#loading_spin").hide(); $("#result_message").css("opacity","1"); GetMessage(); $('#reply_form')[0].reset(); }, 1000);
                }
                else{
                  setTimeout(function(){ $("#loading_spin").hide(); $("#result_message").css("opacity","1"); GetMessage(); }, 1000);
                }
            }   
        });
        return false;
      }
      else{
        alert("Please Enter Ticket Message");
        return false;
      }
    }
    function GetMessage(){
      $("#loading_spin").show();
      $("#result_message").css("opacity","0.5");
      var ticket_id = $("#ticket_id").val();
      $.ajax({
          url: "ajax/ticket.php",
          type: "POST",
          data: {cmd:"GetMessage",ticket_id:ticket_id},
          dataType:"JSON",
          success:function(data){
              $("#result_message").html(data.string);
              $("#result_message").css("opacity","1");
              $("#loading_spin").hide();
          }   
      });
    }
    function confirmDelete() {
      return confirm("Are you sure to delete selected ticket?");
    }
    function confirmDeleteMessage() {
      return confirm("Are you sure to delete selected ticket message?");
    }
    function confirmChangeStatus() {
      return confirm("Are you sure to change ticket status ?");
    }
    
  </script>
</body>
</html>