<?php
  include("../dbConnect.php");
?>
<?php
  $user_id = $_SESSION["user_id"];
  $select_user = "SELECT tu.*,tci.company_name FROM tbl_user tu LEFT JOIN tbl_company_detail tci ON tci.user_id = tu.id WHERE tu.id = '$user_id'";
  $query_user = mysqli_query($mysqli,$select_user) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
  $row_user = mysqli_fetch_assoc($query_user);
  $user_name = $row_user["first_name"]. " ".$row_user["last_name"];
?>
<header class="main-header"> 
    <a href="javascript:void(0)" class="logo"> 
    <span class="logo-mini"><b><?php echo substr($user_name, 0, 3); ?></b></span> 
    <span class="logo-lg"><b><?php echo $user_name; ?></b></span> </a> 
    <nav class="navbar navbar-static-top"> 
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i> <span class="hidden-xs"><?php echo $user_name; ?></span> </a>
            <ul class="dropdown-menu">
              <li class="user-header"> <img src="<?php echo (($row_user["user_image"] != "") ? "../uploads/customer/".$row_user['user_image'] : "../uploads/noimage.png" )?>" class="img-circle" alt="User Image">
                <p> <?php echo $user_name; ?> <small>Member Since <?php echo $row_user["add_date"]; ?></small> </p>
              </li>
              <li class="user-footer">
                <div class="pull-left"> <a href="javascript:void(0)" class="btn btn-default btn-flat">Profile</a> </div>
                <div class="pull-right"> <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a> </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>