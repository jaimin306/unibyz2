<?php
  $activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
          <div class="pull-left image">
              <!--<i class="fa fa-user" style="font-size: 60px"></i>-->
              <img src="<?php echo (($row_user["user_image"] != "") ? "../uploads/user/".$row_user['user_image'] : "../uploads/noimage.png" )?>" height="45px" width="45px" />
          </div>
          <div class="pull-left info">
              <p><?php echo $user_name; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
      </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="<?php echo ($activePage == 'index' || $activePage == '') ? 'active':''; ?>"> <a href="index.php"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a> </li>
      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-file-text"></i> <span>Audit Reports</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Report</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'list_customer' || $activePage == 'customer' || $activePage == 'ap_re_customer') ? 'active':''; ?>"> <a href="#"> <i class="fa fa-users"></i> <span>Customers</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'customer') ? 'active':''; ?>"><a href="customer.php"><i class="fa fa-circle-o"></i> Create New Customer</a></li>
          <li class="<?php echo ($activePage == 'ap_re_customer') ? 'active':''; ?>"><a href="ap_re_customer.php"><i class="fa fa-circle-o"></i> Approve / Rejected Customer</a></li>
          <li class="<?php echo ($activePage == 'list_customer') ? 'active':''; ?>"><a href="list_customer.php"><i class="fa fa-circle-o"></i>View All Customer</a></li>
        </ul>
      </li>
      
      <li class="treeview <?php echo ($activePage == 'list_estimate' || $activePage == 'new_estimate' || $activePage == 'pending_estimate' || $activePage == 'view_estimate' || $activePage == 'estimate' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-file-text-o"></i> <span>Estimates</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'new_estimate') ? 'active':''; ?>"><a href="new_estimate.php"><i class="fa fa-circle-o"></i>Create New Estimates</a></li>
          <li class="<?php echo ($activePage == 'pending_estimate') ? 'active':''; ?>"><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Estimate</a></li>
          <li class="<?php echo ($activePage == 'list_estimate') ? 'active':''; ?>"><a href="list_estimate.php"><i class="fa fa-circle-o"></i>View All Estimates</a></li>
        </ul>
      </li>
      <li class="treeview <?php echo ($activePage == 'list_work_order' || $activePage == 'work_order') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-stethoscope"></i> <span>Work Order</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_work_order') ? 'active':''; ?>"><a href="list_work_order.php"><i class="fa fa-circle-o"></i>All Work Order</a></li>
          <li class="<?php echo ($activePage == 'work_order') ? 'active':''; ?>"><a href="work_order.php"><i class="fa fa-circle-o"></i>New Work Order</a></li>
        </ul>
      </li>
      
      <li class="treeview <?php echo ($activePage == 'view_project' || $activePage == 'list_project' || $activePage == 'project' || $activePage == 'project_calendar' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-bookmark-o"></i> <span>Projects</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'project') ? 'active':''; ?>"><a href="project.php" ><i class="fa fa-circle-o"></i>Create New Project</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Project</a></li>
          <li class="<?php echo ($activePage == 'list_project') ? 'active':''; ?>"><a href="list_project.php"><i class="fa fa-circle-o"></i>View All Projects</a></li>
          <li class="<?php echo ($activePage == 'project_calendar') ? 'active':''; ?>""><a href="project_calendar.php"><i class="fa fa-circle-o"></i>View Calendar</a></li>
        </ul>
      </li>
      <li class="treeview <?php echo ($activePage == 'list_ticket' || $activePage == 'ticket' || $activePage == 'view_ticket') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-comments-o"></i> <span>Resolution Center</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'ticket') ? 'active':''; ?>"><a href="ticket.php"><i class="fa fa-circle-o"></i>Create New Incident</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject Incident</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Close Incident</a></li>
          <li class="<?php echo ($activePage == 'list_ticket' || $activePage == 'view_ticket') ? 'active':''; ?>"><a href="list_ticket.php"><i class="fa fa-circle-o"></i>View All Incident</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'list_department' || $activePage == 'department') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-building"></i> <span>Departments</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'department') ? 'active':''; ?>"><a href="department.php"><i class="fa fa-circle-o"></i>Create New Department</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject Department</a></li>
          <li class="<?php echo ($activePage == 'list_department') ? 'active':''; ?>"><a href="list_department.php"><i class="fa fa-circle-o"></i>View All Departments</a></li>
        </ul>
      </li>

      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-user"></i> <span>Users</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Manage User Profiles</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Create New User</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New User</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Users</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'list_employee' || $activePage == 'employee') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-user-md"></i> <span>Employees</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Manage Employee Profiles</a></li>
          <li class="<?php echo ($activePage == 'employee') ? 'active':''; ?>""><a href="employee.php"><i class="fa fa-circle-o"></i>Create New Employee</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Employee</a></li>
          <li class="<?php echo ($activePage == 'list_employee') ? 'active':''; ?>"><a href="list_employee.php"><i class="fa fa-circle-o"></i>View All Employees</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'new_invoice' || $activePage == 'invoice' || $activePage == 'list_invoice' || $activePage == 'view_invoice') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-file"></i> <span>Invoices</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <!-- <li class="<?php //echo ($activePage == 'new_invoice' || $activePage == 'invoice') ? 'active':''; ?>"><a href="new_invoice.php"><i class="fa fa-circle-o"></i>Create New Invoice</a></li> -->
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Invoice</a></li>
          <li  class="<?php echo ($activePage == 'list_invoice' ) ? 'active':''; ?>"><a href="list_invoice.php"><i class="fa fa-circle-o"></i>View All Invoices</a></li>
        </ul>
      </li>

      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-money"></i> <span>Other Income</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Manage Other Income Types</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Add Other Income</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Other Income</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'list_expense_type' || $activePage == 'list_expense' || $activePage == 'expense') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-calculator"></i> <span>Expenses</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_expense_type') ? 'active':''; ?>"><a href="list_expense_type.php"><i class="fa fa-circle-o"></i>Expense Type</a></li>
          <li class="<?php echo ($activePage == 'expense') ? 'active':''; ?>"><a href="expense.php"><i class="fa fa-circle-o"></i>Create New Expense</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Expense</a></li>
          <li class="<?php echo ($activePage == 'list_expense') ? 'active':''; ?>"><a href="list_expense.php"><i class="fa fa-circle-o"></i>View All Expenses</a></li>
        </ul>
      </li>
      <li class="treeview <?php echo ($activePage == 'list_leave' || $activePage == 'leave' || $activePage == 'list_holiday' || $activePage == 'holiday' || $activePage == 'list_leave_application' || $activePage == 'leave_application' || $activePage == 'list_leave_type' || $activePage == 'leave_type' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-plane"></i> <span>Leave</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li  class="<?php echo ($activePage == 'list_leave' || $activePage == 'leave') ? 'active':''; ?>"><a href="list_leave.php"><i class="fa fa-circle-o"></i>Leave</a></li>
          <li  class="<?php echo ($activePage == 'list_holiday' || $activePage == 'holiday') ? 'active':''; ?>"><a href="list_holiday.php"><i class="fa fa-circle-o"></i>Holiday</a></li>
          <li  class="<?php echo ($activePage == 'list_leave_type' || $activePage == 'leave_type') ? 'active':''; ?>"><a href="list_leave_type.php"><i class="fa fa-circle-o"></i>Leave Types</a></li>
          <li  class="<?php /*echo ($activePage == 'list_leave_application' || $activePage == 'leave_application') ? 'active':''; */?>"><a href="#"><i class="fa fa-circle-o"></i>Leave Application</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'list_salary_type' || $activePage == 'payroll' || $activePage == 'list_payroll' || $activePage == 'payroll_template' || $activePage == 'salary_type' || $activePage == 'list_salary_setup' || $activePage == 'salary_setup' || $activePage == 'edit_salary_setup' || $activePage == 'list_salary_generate' || $activePage == 'salary_generate' || $activePage == 'list_compensation_type' || $activePage == 'compensation_type') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-file-o"></i> <span>Payroll</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li  class="<?php echo ($activePage == 'list_salary_type' || $activePage == 'salary_type') ? 'active':''; ?>"><a href="list_salary_type.php"><i class="fa fa-circle-o"></i>Salary Type</a></li>
          <li  class="<?php echo ($activePage == 'list_compensation_type' || $activePage == 'compensation_type') ? 'active':''; ?>"><a href="list_compensation_type.php"><i class="fa fa-circle-o"></i>Compensation Type</a></li>
          <li  class="<?php echo ($activePage == 'list_salary_setup' || $activePage == 'salary_setup' || $activePage == 'edit_salary_setup') ? 'active':''; ?>"><a href="list_salary_setup.php"><i class="fa fa-circle-o"></i>Salary Setup</a></li>
          <li  class="<?php echo ($activePage == 'list_salary_generate' || $activePage == 'salary_generate') ? 'active':''; ?>"><a href="list_salary_generate.php"><i class="fa fa-circle-o"></i>Salary Generate</a></li>
          <li class="<?php echo ($activePage == 'list_payroll') ? 'active':''; ?>"><a href="list_payroll.php"><i class="fa fa-circle-o"></i>View Payroll</a></li>
          <li class="<?php echo ($activePage == 'payroll') ? 'active':''; ?>"><a href="payroll.php"><i class="fa fa-circle-o"></i>Add Payroll</a></li>
          <li class="<?php echo ($activePage == 'payroll_template') ? 'active':''; ?>"><a href="payroll_template.php"><i class="fa fa-circle-o"></i>Manage Payroll Templates</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'vendor' || $activePage == 'list_vendor') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-user-md"></i> <span>Vendors</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'vendor') ? 'active':''; ?>"><a href="vendor.php"><i class="fa fa-circle-o"></i>Create New Vendor</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Vendor</a></li>
          <li class="<?php echo ($activePage == 'list_vendor') ? 'active':''; ?>"><a href="list_vendor.php"><i class="fa fa-circle-o"></i>View All Vendors</a></li>
        </ul>
      </li>
      
      <li class="treeview <?php echo ($activePage == 'list_category' || $activePage == 'product' || $activePage == 'list_product' ||  $activePage == 'product_type' || $activePage == 'list_product_type' || $activePage == 'list_brand' || $activePage == 'brand') ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-product-hunt"></i> <span>Products</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_category') ? 'active':''; ?>"><a href="list_category.php"><i class="fa fa-circle-o"></i>Product Categories</a></li>
          <li class="<?php echo ($activePage == 'list_product_type') ? 'active':''; ?>"><a href="list_product_type.php"><i class="fa fa-circle-o"></i>Product Types</a></li>
          <li class="<?php echo ($activePage == 'list_brand') ? 'active':''; ?>"><a href="list_brand.php"><i class="fa fa-circle-o"></i>Product Manufacturer</a></li>          
          <li><a href="list_measurement_type.php?type=<?php echo encrypt(1); ?>"><i class="fa fa-circle-o"></i>Product Attribute</a></li>          
          <li><a href="list_measurement.php?type=<?php echo encrypt(1); ?>"><i class="fa fa-circle-o"></i>Product Condition</a></li>          
          <li class="<?php echo ($activePage == 'product') ? 'active':''; ?>"><a href="product.php"><i class="fa fa-circle-o"></i>Create New Product</a></li>
          <li class="<?php echo ($activePage == 'list_product') ? 'active':''; ?>"><a href="list_product.php"><i class="fa fa-circle-o"></i>View All Products</a></li>
        </ul>
      </li>
      <li class="treeview <?php echo ($activePage == 'list_service_category' || $activePage == 'service_category' || $activePage == 'service' || $activePage == 'list_service' || $activePage == 'list_service_type' || $activePage == 'service_type' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-wrench"></i> <span>Services</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_service_category' || $activePage == 'service_category') ? 'active':''; ?>"><a href="list_service_category.php"><i class="fa fa-circle-o"></i>Service Categories</a></li>
          <li class="<?php echo ($activePage == 'list_service_type') ? 'active':''; ?>"><a href="list_service_type.php"><i class="fa fa-circle-o"></i>Service Types</a></li>
          <li><a href="list_measurement_type.php?type=<?php echo encrypt(2); ?>"><i class="fa fa-circle-o"></i>Service Attribute</a></li>          
          <li><a href="list_measurement.php?type=<?php echo encrypt(2); ?>"><i class="fa fa-circle-o"></i>Service Condition</a></li>          
          <li class="<?php echo ($activePage == 'service') ? 'active':''; ?>"><a href="service.php"><i class="fa fa-circle-o"></i> Create New Service</a></li>
          <li class="<?php echo ($activePage == 'list_service') ? 'active':''; ?>"><a href="list_service.php"><i class="fa fa-circle-o"></i>View All Services</a></li>
        </ul>
      </li>

      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-dropbox"></i> <span>Inventory Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Create Reusable Good</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Reusable Goods</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Create Perishable Good</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Perishable Goods</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Import / Scan New Inventory</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Inventory</a></li>
        </ul>
      </li>

      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-tag"></i> <span>Assets</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Create Asset Category</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Create New Asset</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Approve / Reject New Asset</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>View All Assets</a></li>
        </ul>
      </li>

      <li class="treeview"> <a href="javascript:void(0)"> <i class="fa fa-file-text-o"></i> <span>Reports</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Revenue Summary</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Expense Summary</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Cash Flow</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Income Statement</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Balance Sheet</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>Collections</a></li>
        </ul>
      </li>

      <li> <a href="javascript:void(0)"> <i class="fa fa-dashboard"></i> <span>Custom Fields</span> </a> </li>

      <li class="treeview <?php echo ($activePage == 'list_email' || $activePage == 'email' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-envelope"></i> <span>Communications</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($activePage == 'list_email' || $activePage == 'email') ? 'active':''; ?>"><a href="list_email.php"><i class="fa fa-circle-o"></i>Email</a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i>SMS</a></li>
        </ul>
      </li>
      
      <li class="treeview <?php echo ($activePage == 'list_ticket_department' || $activePage == 'ticket_department' || $activePage == 'list_ticket_status' || $activePage == 'ticket_status' || $activePage == 'ticket_type' || $activePage == 'list_ticket_type' ) ? 'active':''; ?>">
        <a href="javascript:void(0)"><i class="fa fa-cog"></i> <span>System Configuration</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview <?php echo ($activePage == 'list_ticket_department' || $activePage == 'ticket_department' || $activePage == 'list_ticket_status' || $activePage == 'ticket_status' || $activePage == 'ticket_type' || $activePage == 'list_ticket_type' ) ? 'active':''; ?>">
            <a href="#"><i class="fa fa-circle-o"></i>Incidents<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php echo ($activePage == 'list_ticket_department' || $activePage == 'ticket_department' ) ? 'active':''; ?>"><a href="list_ticket_department.php"><i class="fa fa-circle-o"></i>Departments</a></li>
              <li class="<?php echo ($activePage == 'list_ticket_status' || $activePage == 'ticket_status' ) ? 'active':''; ?>"><a href="list_ticket_status.php"><i class="fa fa-circle-o"></i>Status</a></li>
              <li class="<?php echo ($activePage == 'list_ticket_type' || $activePage == 'ticket_type' ) ? 'active':''; ?>"><a href="list_ticket_type.php"><i class="fa fa-circle-o"></i>Types</a></li>
            </ul>
          </li>
        </ul>
      </li>

      <li class="treeview <?php echo ($activePage == 'setting' || $activePage == 'list_taxrate' ) ? 'active':''; ?>"> <a href="javascript:void(0)"> <i class="fa fa-cogs"></i> <span class=""> Settings</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <!-- <li><a href="setting.php"><i class="fa fa-circle-o"></i> General </a></li> -->
          <li class="<?php echo ($activePage == 'setting' ) ? 'active':''; ?>"> <a href="setting.php"><i class="fa fa-circle-o"></i> General </a> </li>
          <li class="<?php echo ($activePage == 'list_taxrate' ) ? 'active':''; ?>"> <a href="list_taxrate.php"><i class="fa fa-circle-o"></i> Tax Rates </a> </li>
        </ul>
      </li>
      
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>


