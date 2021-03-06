<?php
	$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo (($row_user["user_image"] != "") ? "../uploads/customer/" . $row_user['user_image'] : "../uploads/noimage.png") ?>" height="45px" width="45px" />
			</div>
			<div class="pull-left info">
				<p><?php echo $user_name; ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="<?php echo ($activePage == 'index' || $activePage == '') ? 'active' : ''; ?>"> <a href="<?php echo $customer_url; ?>"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a> </li>

			<li class="<?php echo ($activePage == 'list_estimate' ) ? 'active' : ''; ?>"> <a href="list_estimate.php"> <i class="fa fa-file-text-o"></i> <span>Estimates</span> </a> </li>

			<li class="treeview <?php echo ($activePage == 'list_ticket' || $activePage == 'ticket') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-comments-o"></i> <span>Resolution Center</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
				<ul class="treeview-menu">
					<li class="<?php echo ($activePage == 'ticket') ? 'active':''; ?>"><a href="ticket.php"><i class="fa fa-circle-o"></i>Create New Incident</a></li>
					<li class="<?php echo ($activePage == 'list_ticket' || $activePage == 'view_ticket') ? 'active':''; ?>"><a href="list_ticket.php"><i class="fa fa-circle-o"></i>View All Incidents</a></li>
				</ul>
			</li>
			<!--
			<li class="treeview <?php echo ($activePage == 'list_ticket' || $activePage == 'ticket' || $activePage == 'view_ticket') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-comments-o"></i> <span>Resolution Center</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
				<ul class="treeview-menu">
					<li class="<?php echo ($activePage == 'ticket') ? 'active':''; ?>"><a href="ticket.php"><i class="fa fa-circle-o"></i>Create New Ticket</a></li>
					<li class="<?php echo ($activePage == 'list_ticket' || $activePage == 'view_ticket') ? 'active':''; ?>"><a href="list_ticket.php"><i class="fa fa-circle-o"></i>View All Tickets</a></li>
				</ul>
			</li>-->
		</ul>
	</section>
</aside>


