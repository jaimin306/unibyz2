<?php
    //session_start();
	error_reporting(E_ALL ^ E_NOTICE);
    date_default_timezone_set('Asia/Kolkata');
    
    /*
    $db_host = 'localhost'; //hostname
    $db_user = 'repairshop_admin'; // username
    $db_password = 'iwant$100'; // password
    $db_name = 'repairshop_nw'; //database name
    $base_url = 'http://unibyz.com/';
    $superadmin_url = 'http://unibyz.com/SuperAdmin/';
    $admin_url = 'http://unibyz.com/Admin/';
    $customer_url = 'http://unibyz.com/Customer/';
    $projectmanager_url = 'http://unibyz.com/ProjectManager/';
    $employee_url = 'http://unibyz.com/Employee/';
    $hostmail_url = 'ssl://smtp.gmail.com'; // For Gmail
    */
    
    $db_host = 'localhost'; //hostname
    $db_user = 'root'; // username
    $db_password = 'redhat'; // password
    $db_name = 'db_repairshop_nw'; //database name
    $base_url = 'http://localhost/sachin/repairshop/';
    $superadmin_url = 'http://localhost/sachin/repairshop/SuperAdmin/';
    $admin_url = 'http://localhost/sachin/repairshop/Admin/';
    $customer_url = 'http://localhost/sachin/repairshop/Customer/';
    $projectmanager_url = 'http://localhost/sachin/repairshop/ProjectManager/';
    $employee_url = 'http://localhost/sachin/repairshop/Employee/';
    $hostmail_url = 'ssl://smtp.gmail.com'; // For Gmail
    
    @$mysqli = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$mysqli) {
        header("Location:login.php");
        exit();
    }
?>