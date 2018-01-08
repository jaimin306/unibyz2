<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
          <div class="pull-left image">
              <i class="fa fa-user" style="font-size: 60px"></i>
          </div>
          <div class="pull-left info">
              <p><?php echo $user_name; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
      </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="treeview <?php echo ($activePage == 'list_entity' || $activePage == 'entity' || $activePage == 'list_pending_entity' || $activePage == 'list_approve_entity' || $activePage == 'list_reject_entity' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-stethoscope"></i> <span>Entities</span> <span class="pull-right-container"> <span class="label label-primary pull-right">5</span> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_entity') ? 'active':''; ?>"><a href="list_entity.php"><i class="fa fa-circle-o"></i>All Entities</a></li>
          <li class="<?php echo ($activePage == 'entity') ? 'active':''; ?>"><a href="entity.php"><i class="fa fa-circle-o"></i>Create New Entity</a></li>
          <li class="<?php echo ($activePage == 'list_pending_entity') ? 'active':''; ?>"><a href="list_pending_entity.php"><i class="fa fa-circle-o"></i>Entities Pending Approval</a></li>
          <li class="<?php echo ($activePage == 'list_approve_entity') ? 'active':''; ?>"><a href="list_approve_entity.php"><i class="fa fa-circle-o"></i>Approved Entities</a></li>
          <li class="<?php echo ($activePage == 'list_reject_entity') ? 'active':''; ?>"><a href="list_reject_entity.php"><i class="fa fa-circle-o"></i>Rejected Entities</a></li>
        </ul>
      </li>
      <!--
      <li class="treeview <?php /* echo ($activePage == 'list_country' || $activePage == 'country') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-stethoscope"></i> <span>Country</span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'country') ? 'active':''; ?>"><a href="country.php"><i class="fa fa-circle-o"></i>Create New Country</a></li>
          <li class="<?php echo ($activePage == 'list_country') ? 'active':''; */?>"><a href="list_country.php"><i class="fa fa-circle-o"></i>All Countries</a></li>
        </ul>
      </li>-->
      <!--
      <li class="treeview "> <a href="javascript:void(0)"> <i class="fa fa-cog"></i> <span class=""> Settings</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="setting.php"><i class="fa fa-circle-o"></i> General </a></li>
          <li> <a href="list_taxrate.php"><i class="fa fa-circle-o"></i> Tax Rates </a> </li>
        </ul>
      </li>-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

