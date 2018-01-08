-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2017 at 12:26 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_repair_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `sign_in` time NOT NULL,
  `sign_out` time DEFAULT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `employee_id`, `sign_in`, `sign_out`, `add_date`, `add_uid`, `status`) VALUES
(1, 8, '18:52:50', '19:20:12', '2017-12-05 18:52:50', 2, 1),
(2, 8, '10:45:50', NULL, '2017-12-06 10:45:50', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Perishable Goods', '2017-11-24 14:58:09', 2, 1),
(2, 'Reusable Goods', '2017-11-24 14:58:12', 2, 1),
(3, 'Perishable Goods', '2017-11-24 21:04:46', 12, 1),
(4, 'Reusable Goods', '2017-11-24 21:04:57', 12, 1),
(5, 'leave_type', '2017-12-04 18:07:36', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_company_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_address` text,
  `state` varchar(255) DEFAULT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_company_detail`
--

INSERT INTO `tbl_company_detail` (`id`, `user_id`, `company_name`, `company_logo`, `company_email`, `company_website`, `company_address`, `state`, `license_no`, `add_date`, `add_uid`, `status`) VALUES
(3, 2, 'Prodigy Solutions', '35_18b8a7bcab19bb1dabf97fd165beb33e.jpg', '', NULL, NULL, 'Gujarat', 'LICN00544RYT8', '2017-11-24 10:52:26', 1, 1),
(4, 10, 'Ironaid', 'logo1.png', '', NULL, NULL, NULL, NULL, '2017-11-24 18:12:23', 1, 1),
(5, 11, 'Unilyze Inc.', 'good_logo_unilyze_1_40_1_40.png', '', NULL, NULL, NULL, NULL, '2017-11-24 19:42:30', 1, 1),
(6, 12, 'R&S Hardwood Floors and Tile Inc.', '', 'jslater@unilyze.com', NULL, '10 Gideon Way\nBluffton\n29910 South Carolina\nLicense #RBS47896', NULL, NULL, '2017-11-24 19:55:28', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_compensation_type`
--

CREATE TABLE IF NOT EXISTS `tbl_compensation_type` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `compensation_name` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_compensation_type`
--

INSERT INTO `tbl_compensation_type` (`id`, `parent_id`, `compensation_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 0, 'Wages', '2017-12-06 16:00:06', 2, 1),
(2, 0, 'Overtime Pay', '2017-12-06 16:00:31', 2, 1),
(3, 0, 'Commissions', '2017-12-06 16:00:45', 2, 1),
(4, 3, 'Percentage', '2017-12-06 16:00:58', 2, 1),
(5, 3, 'Amount', '2017-12-06 16:01:12', 2, 1),
(6, 0, 'Bonus Pay', '2017-12-06 16:03:07', 2, 1),
(7, 6, 'Bonus', '2017-12-06 16:04:10', 2, 1),
(8, 6, 'Profit Share', '2017-12-06 16:04:24', 2, 1),
(9, 6, 'Merit Pay', '2017-12-06 16:04:37', 2, 1),
(10, 0, 'Company Stock', '2017-12-06 16:08:32', 2, 1),
(11, 10, 'Stock', '2017-12-06 16:45:44', 2, 1),
(12, 10, 'Shares', '2017-12-06 16:45:58', 2, 1),
(13, 0, 'Travel and Lodging', '2017-12-06 16:46:36', 2, 1),
(14, 13, 'Airfare', '2017-12-06 16:46:51', 2, 1),
(15, 13, 'Lodging', '2017-12-06 16:47:17', 2, 1),
(16, 13, 'Mileage', '2017-12-06 16:48:08', 2, 1),
(17, 13, 'Meals', '2017-12-06 16:48:23', 2, 1),
(18, 13, 'Per Diem', '2017-12-06 16:48:42', 2, 1),
(19, 0, 'Benefits', '2017-12-06 17:04:22', 2, 1),
(20, 19, 'Health Insurance', '2017-12-06 17:04:43', 2, 1),
(21, 19, 'Life', '2017-12-06 17:08:15', 2, 1),
(23, 19, '401k', '2017-12-06 17:09:32', 2, 1),
(24, 19, 'Retirement', '2017-12-06 17:09:57', 2, 1),
(25, 19, 'Vacation', '2017-12-06 17:10:10', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE IF NOT EXISTS `tbl_department` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) DEFAULT NULL,
  `department_code` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `department_name`, `department_code`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Sales', 'S1001', '2017-11-24 17:34:48', 2, 1),
(2, 'Project Management', 'PM3001', '2017-11-24 17:37:19', 2, 1),
(4, 'General Management', 'GM5001', '2017-11-24 17:37:56', 2, 1),
(5, 'Marketing & Media', 'SMC001', '2017-11-24 17:38:13', 2, 1),
(6, 'General Administration', 'GA1001', '2017-11-24 22:26:23', 12, 1),
(7, 'Sales', 'SL2001', '2017-11-24 22:26:48', 12, 1),
(8, 'Finance and Accounting', 'FA7001', '2017-11-24 22:27:53', 12, 1),
(9, 'Customer Service', 'CS4001', '2017-11-24 22:28:44', 12, 1),
(10, 'Marketing, Advertising and Social Media', 'MM5001', '2017-11-24 22:29:11', 12, 1),
(11, 'Inventory Control', 'IC6001', '2017-11-24 22:30:08', 12, 1),
(12, 'Human Resources', 'HR8001', '2017-11-24 22:31:28', 12, 1),
(13, 'Customer Projects', 'CP3001', '2017-11-24 22:31:50', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email`
--

CREATE TABLE IF NOT EXISTS `tbl_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_email`
--

INSERT INTO `tbl_email` (`id`, `send_user_id`, `to_user_id`, `subject`, `message`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 4, 'a', '<p>asd</p>', '2017-11-30 16:45:08', 2, 1),
(2, 2, 4, 'asd', '<p>qwe</p>', '2017-11-30 16:45:40', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `customer_phone` varchar(200) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `technician_name` varchar(255) DEFAULT NULL,
  `technician_number` varchar(255) DEFAULT NULL,
  `estimate_date` varchar(200) DEFAULT NULL,
  `estimate_due_date` varchar(200) DEFAULT NULL,
  `notify_department` varchar(200) DEFAULT NULL,
  `notify_email` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Mail Sent, 1= Not Mailed',
  `notify_email_date` datetime NOT NULL,
  `notes` text NOT NULL,
  `estimate_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Accept,2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_estimate`
--

INSERT INTO `tbl_estimate` (`id`, `customer_id`, `department_id`, `customer_phone`, `customer_email`, `technician_name`, `technician_number`, `estimate_date`, `estimate_due_date`, `notify_department`, `notify_email`, `notify_email_date`, `notes`, `estimate_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 5, 2, '814-542-6264', 'customer1@gmail.com', 'Levi S. Hilton', 'TN14557', '2017-11-24', '2017-11-30', 'No', 1, '2017-12-01 19:29:20', '', 0, '2017-11-24 17:41:08', 2, 1),
(2, 5, 4, '814-542-6264', 'customer1@gmail.com', 'Quincy R. Killion', 'TN123', '2017-11-29', '2017-11-30', 'No', 0, '0000-00-00 00:00:00', '', 0, '2017-11-24 17:46:22', 2, 1),
(3, 4, 5, '312-345-6865', 'customer@gmail.com', 'Ronald P. Hardy', '1500325', '2017-12-28', '2017-12-30', 'Yes', 0, '0000-00-00 00:00:00', '', 1, '2017-11-24 17:47:14', 2, 1),
(4, 13, 7, '+18433427664', 'jr@conquestins.com', 'Wosvaldo Servin', 'HR001', '2017-11-24', '2017-11-24', 'Yes', 0, '0000-00-00 00:00:00', '<p>Great Customer</p>', 0, '2017-11-25 00:52:29', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate_item`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `product_detail` varchar(255) DEFAULT NULL,
  `measurement_type` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  `unit_price` varchar(200) DEFAULT NULL,
  `total_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_generate_salary`
--

CREATE TABLE IF NOT EXISTS `tbl_generate_salary` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_generate_salary`
--

INSERT INTO `tbl_generate_salary` (`id`, `employee_id`, `name`, `start_date`, `end_date`, `add_date`, `add_uid`, `status`) VALUES
(1, 6, 'xyz', '2017-12-13', '0000-00-00', '2017-12-05 12:18:26', 2, 1),
(2, 7, 'xyz', '2017-12-13', '0000-00-00', '2017-12-05 12:18:26', 2, 1),
(3, 9, 'xyz', '2017-12-13', '0000-00-00', '2017-12-05 12:18:26', 2, 1),
(4, 9, 'qwe', '0000-00-00', '0000-00-00', '2017-12-05 12:18:54', 2, 1),
(5, 9, 'qqqq', '2017-12-20', '2017-12-22', '2017-12-05 12:22:53', 2, 1),
(6, 8, 'ewqrewqrqwr', '2017-12-06', '2017-12-28', '2017-12-05 12:41:02', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holiday`
--

CREATE TABLE IF NOT EXISTS `tbl_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(255) DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_holiday`
--

INSERT INTO `tbl_holiday` (`id`, `holiday_name`, `from_date`, `to_date`, `no_of_days`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Independence Day', '2017-08-15', '2017-08-16', 1, '2017-12-04 16:59:18', 2, 1),
(2, 'Eid al-Fitr', '2017-06-25', '2017-06-30', 5, '2017-12-04 17:00:52', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `work_order_id` int(11) NOT NULL,
  `invoice_date` varchar(200) DEFAULT NULL,
  `invoice_due_date` varchar(200) DEFAULT NULL,
  `notify_client` varchar(200) DEFAULT NULL,
  `notes` text NOT NULL,
  `invoice_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Accept,2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_item`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `product_detail` varchar(255) DEFAULT NULL,
  `measurement_type` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  `unit_price` varchar(200) DEFAULT NULL,
  `total_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE IF NOT EXISTS `tbl_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weekly_holiday` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_leave`
--

INSERT INTO `tbl_leave` (`id`, `weekly_holiday`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Saturday', '2017-12-04 16:17:48', 2, 1),
(2, 'Friday,Saturday,Sunday', '2017-12-04 16:17:55', 2, 1),
(3, 'Friday', '2017-12-04 16:18:03', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_type`
--

CREATE TABLE IF NOT EXISTS `tbl_leave_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_type` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_leave_type`
--

INSERT INTO `tbl_leave_type` (`id`, `leave_type`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Causal Leave', '2017-12-04 18:36:37', 2, 1),
(2, 'Annual Leave', '2017-12-04 18:36:44', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_milestone`
--

CREATE TABLE IF NOT EXISTS `tbl_milestone` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `milestone_name` varchar(255) DEFAULT NULL,
  `notes` text NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_milestone`
--

INSERT INTO `tbl_milestone` (`id`, `project_id`, `milestone_name`, `notes`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Project Review', '', '2017-12-07 17:04:40', 8, 1),
(2, 1, 'Audit', '', '2017-12-07 17:04:59', 8, 1),
(3, 3, ' Change Management', '', '2017-12-07 17:05:15', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permission`
--

CREATE TABLE IF NOT EXISTS `tbl_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `create_category` tinyint(4) DEFAULT NULL,
  `edit_category` tinyint(4) DEFAULT NULL,
  `delete_category` tinyint(4) DEFAULT NULL,
  `create_work_order` tinyint(4) DEFAULT NULL,
  `edit_work_order` tinyint(4) DEFAULT NULL,
  `delete_work_order` tinyint(4) DEFAULT NULL,
  `create_product` tinyint(4) DEFAULT NULL,
  `edit_product` tinyint(4) DEFAULT NULL,
  `delete_product` tinyint(4) DEFAULT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_permission`
--

INSERT INTO `tbl_permission` (`id`, `user_id`, `create_category`, `edit_category`, `delete_category`, `create_work_order`, `edit_work_order`, `delete_work_order`, `create_product`, `edit_product`, `delete_product`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2017-11-10 19:12:38', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) NOT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `purchase_price` float(10,2) DEFAULT NULL,
  `sales_price` float(10,2) NOT NULL,
  `description` text,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `product_type_id` (`product_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `product_type_id`, `product_name`, `code`, `brand`, `measurement`, `quantity`, `purchase_price`, `sales_price`, `description`, `notes`, `photo_path`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, 'Dulux Paints ', 'DP0054 ', 'Dulux ', 'ABC', '10', 1500.00, 1600.00, '<p></p><p>Dulux Weatherguard Decraflex is a premium quality, 100% acrylic, high-coverage paint that provides long-lasting protection against the elements. Its waterproof, breathable finish resists water intrusion and allows moisture to escape, avoiding blistering. This elastomeric coating helps to fill and seal surfaces, protecting against future cracking.&nbsp;</p><div><br></div><p></p>', '', '20171124143826_5a17e18ad54ba_Dulux-decraflex.png', '2017-11-24 14:22:56', 2, 1),
(2, 3, 7, 'Distressed Wood', 'ILD1001B', 'Bruce', 'Square Feet', '1', 8.50, 13.95, '<p>Top of the line Interior Laminated Flooring</p>', '', '', '2017-11-24 21:36:38', 12, 1),
(3, 3, 7, 'Hand-scraped Wood', 'ILH1002B', 'Bruce', 'Square Feet', '1', 8.75, 14.50, '<p>Top of the Line Hand-scraped Wood</p>', '', '', '2017-11-24 21:41:07', 12, 1),
(4, 3, 7, 'Traditional Wood', 'ILT1003B', 'Bruce', 'Square Feet', '1', 9.00, 15.75, '<p>Top of the Line Traditional Wood</p>', '', '', '2017-11-24 21:42:58', 12, 1),
(5, 3, 7, 'Specialty Wood', 'ILS1004B', 'Bruce', 'Square Feet', '1', 9.25, 16.00, '<p>Top of the Line Traditional Laminated Wood</p>', '', '', '2017-11-24 21:44:27', 12, 1),
(6, 3, 7, 'Stones and Natural', 'ILN1005B', 'Bruce', 'Square Feet', '1', 9.50, 17.95, '<p>Top of the Line Stones and Natural Laminated Wood</p>', '', '', '2017-11-24 21:45:48', 12, 1),
(7, 1, 8, 'Distressed Wood', 'DW00556', 'Bruce', 'Square Feet', '15', 12.00, 18.75, '<p>When reclaimed wood is cut, sanded or reshaped, the new surfaces lose the original patina. If the look and texture of the untouched material is desired, try distressing and weathering, using only natural materials and methods.<br></p>', '', '20171128153010_5a1d33aa7e790_A1MHzhUsAVL._SY355_.jpg', '2017-11-28 15:30:10', 2, 1),
(8, 1, 8, 'Traditional Wood', 'TW54504', 'Bruce', 'Square Feet', '13', 7.00, 9.00, '<p>The 1/2 in. Cross-grain Plywood planks have a 7-layer aluminum oxide finish, providing everyday wear and tear protection. This product has achieved GREENGUARD Indoor Air Quality Certification<br></p>', '', '20171128153238_5a1d343ecc7c1_russet-wood-parquet-with-a-low-gloss-finish-armstrong-luxury-vinyl-tile-a4225051-64_1000.jpg', '2017-11-28 15:32:38', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_type`
--

CREATE TABLE IF NOT EXISTS `tbl_product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_type_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_product_type`
--

INSERT INTO `tbl_product_type` (`id`, `category_id`, `product_type_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Paint Exterior', '2017-11-24 15:41:13', 2, 1),
(2, 3, 'Interior Hardwood Flooring', '2017-11-24 21:06:50', 12, 1),
(3, 3, 'Exterior Hardwood Flooring', '2017-11-24 21:07:04', 12, 1),
(4, 3, 'Interior Hardwood Lacquer', '2017-11-24 21:08:28', 12, 1),
(5, 3, 'Exterior Hardwood Lacquer', '2017-11-24 21:08:43', 12, 1),
(6, 3, 'Exterior Laminate Flooring', '2017-11-24 21:28:24', 12, 1),
(7, 3, 'Interior Laminate Flooring', '2017-11-24 21:28:39', 12, 1),
(8, 1, 'Interior Laminate Flooring', '2017-11-28 15:14:48', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE IF NOT EXISTS `tbl_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `project_manager_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `project_description` text,
  `notes` text,
  `project_status` int(11) DEFAULT '2' COMMENT '0=Completed, 1=In Progress, 2=Pending',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `estimate_id`, `customer_id`, `project_manager_id`, `project_name`, `start_date`, `end_date`, `project_description`, `notes`, `project_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 3, 4, 8, 'P1', '2017-11-24', '2017-12-29', '', '', 1, '2017-11-24 17:59:57', 2, 1),
(2, 4, 13, 14, 'Conquest Flooring', '2017-11-27', '2017-12-21', NULL, NULL, 1, '2017-11-25 01:01:02', 12, 1),
(3, 3, 4, 8, 'Changes In Module', '2017-11-29', '2017-12-22', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum<br></p>', '<p>asdqwe&nbsp;</p>', 2, '2017-11-29 14:27:14', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_generate`
--

CREATE TABLE IF NOT EXISTS `tbl_salary_generate` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_salary_generate`
--

INSERT INTO `tbl_salary_generate` (`id`, `employee_id`, `name`, `start_date`, `end_date`, `add_date`, `add_uid`, `status`) VALUES
(1, 6, 'November 2017', '2017-11-01', '2017-11-30', '2017-12-05 17:00:29', 2, 1),
(2, 8, 'November 2017', '2017-11-01', '2017-11-30', '2017-12-05 17:00:29', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_setup`
--

CREATE TABLE IF NOT EXISTS `tbl_salary_setup` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `salary_duration` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_salary_setup`
--

INSERT INTO `tbl_salary_setup` (`id`, `employee_id`, `salary_duration`, `add_date`, `add_uid`, `status`) VALUES
(1, 6, 'Monthly', '2017-12-05 16:58:30', 2, 1),
(2, 8, 'Monthly', '2017-12-05 16:59:08', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_setup_amount`
--

CREATE TABLE IF NOT EXISTS `tbl_salary_setup_amount` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `salary_setup_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `amount_add_deduct` int(11) NOT NULL COMMENT '0=Deduct, 1=Add',
  `amount` float(10,2) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_salary_setup_amount`
--

INSERT INTO `tbl_salary_setup_amount` (`id`, `salary_setup_id`, `type_id`, `amount_add_deduct`, `amount`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, 1, 15000.00, '2017-12-05 16:58:30', 2, 1),
(2, 1, 2, 1, 100.00, '2017-12-05 16:58:30', 2, 1),
(3, 1, 4, 1, 200.00, '2017-12-05 16:58:30', 2, 1),
(4, 1, 3, 0, 3000.00, '2017-12-05 16:58:30', 2, 1),
(5, 1, 5, 0, 200.00, '2017-12-05 16:58:30', 2, 1),
(6, 2, 1, 1, 13000.00, '2017-12-05 16:59:08', 2, 1),
(7, 2, 2, 1, 0.00, '2017-12-05 16:59:08', 2, 1),
(8, 2, 4, 1, 1500.00, '2017-12-05 16:59:08', 2, 1),
(9, 2, 3, 0, 500.00, '2017-12-05 16:59:08', 2, 1),
(10, 2, 5, 0, 350.00, '2017-12-05 16:59:08', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_type`
--

CREATE TABLE IF NOT EXISTS `tbl_salary_type` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `salary_name` varchar(255) DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL COMMENT '1=Add, 0=Deduct',
  `default_amount` float(10,2) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_salary_type`
--

INSERT INTO `tbl_salary_type` (`id`, `salary_name`, `salary_type`, `default_amount`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Basic', 1, 12000.00, '2017-12-05 16:55:45', 2, 1),
(2, 'Extra Hour', 1, 120.00, '2017-12-05 16:56:06', 2, 1),
(3, 'Bima', 0, 2000.00, '2017-12-05 16:56:18', 2, 1),
(4, 'House Rent', 1, 3000.00, '2017-12-05 16:56:56', 2, 1),
(5, 'Provident Fund', 0, 1500.00, '2017-12-05 16:57:25', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE IF NOT EXISTS `tbl_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `service_type_id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `hourly_rate` float(10,2) DEFAULT NULL,
  `daily_rate` float(10,2) DEFAULT NULL,
  `service_level` varchar(255) NOT NULL,
  `description` text,
  `notes` text,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`id`, `category_id`, `service_type_id`, `service_name`, `code`, `hourly_rate`, `daily_rate`, `service_level`, `description`, `notes`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 3, 'ABC', 'ABC001', 15.00, 120.00, 'Expert', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters,<br></p>', '', '2017-11-24 16:54:00', 2, 1),
(2, 3, 5, 'Project Manager', 'PM1001', 27.00, 200.00, 'Executive', '<p>Executive Project Manager</p>', '', '2017-11-24 21:49:52', 12, 1),
(3, 3, 5, 'Project Manager', 'PM1002', 23.00, 170.00, 'Senior', '<p>Senior Project Manager</p>', '', '2017-11-24 21:50:48', 12, 1),
(4, 3, 5, 'Project Manager', 'PM1003', 18.00, 130.00, 'Junior', '<p>Junior Project Manager</p>', '', '2017-11-24 21:51:40', 12, 1),
(5, 5, 8, 'Project Supervisor', 'PS1001', 21.00, 150.00, 'Senior', '<p>Supervises Client Installations</p>', '', '2017-11-24 21:54:26', 12, 1),
(6, 8, 7, 'Junior Installer', 'JI001', 17.00, 120.00, 'Junior', '<p>Junior Installer assists Master Installer</p>', '', '2017-11-24 23:54:13', 12, 1),
(7, 7, 6, 'Master Craftsman', 'MI001', 26.00, 190.00, 'Senior', '<p>Master Flooring Installer is a Master Craftsman of his trade.</p>', '', '2017-11-24 23:55:48', 12, 1),
(8, 15, 11, 'Junior Installer For Assist', 'JI001', 12.00, 144.00, 'Junior', '<p>Junior Installer assists Master Installer For Doing Their Work<br></p>', '', '2017-11-28 15:42:20', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_category`
--

CREATE TABLE IF NOT EXISTS `tbl_service_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_service_category`
--

INSERT INTO `tbl_service_category` (`id`, `category_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Paint Service', '2017-11-24 16:39:45', 2, 1),
(2, 'Wood Solution', '2017-11-24 16:39:50', 2, 1),
(3, 'Project Manager', '2017-11-24 20:33:45', 12, 1),
(4, 'Foreman', '2017-11-24 20:34:51', 12, 1),
(5, 'Supervisor', '2017-11-24 20:35:00', 12, 1),
(6, 'Estimator', '2017-11-24 20:35:27', 12, 1),
(7, 'Master Installer', '2017-11-24 20:35:42', 12, 1),
(8, 'Junior Installer', '2017-11-24 20:35:51', 12, 1),
(9, 'Owner / Operator', '2017-11-24 20:36:54', 12, 1),
(10, 'Office Manager', '2017-11-24 20:37:14', 12, 1),
(12, 'Customer Service Manager', '2017-11-24 20:37:47', 12, 1),
(13, 'Customer Service Agent', '2017-11-24 20:37:57', 12, 1),
(14, 'Administrative Assistant', '2017-11-24 20:38:17', 12, 1),
(15, 'Junior Installer', '2017-11-28 15:34:02', 2, 1),
(16, 'Owner / Operator', '2017-11-28 15:38:39', 2, 1),
(17, 'Office Manager', '2017-11-28 15:39:55', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_type`
--

CREATE TABLE IF NOT EXISTS `tbl_service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `service_type_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_service_type`
--

INSERT INTO `tbl_service_type` (`id`, `category_id`, `service_type_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Home Painting', '2017-11-24 16:40:47', 2, 1),
(2, 1, 'Furniture Painting', '2017-11-24 16:40:55', 2, 1),
(3, 2, 'Decor with wooden surfaces at home.', '2017-11-24 16:41:02', 2, 1),
(4, 6, 'Create Estimate', '2017-11-24 20:56:56', 12, 1),
(5, 3, 'Project Management', '2017-11-24 20:59:59', 12, 1),
(6, 7, 'Install Flooring', '2017-11-24 21:01:03', 12, 1),
(7, 8, 'Assist Master Installer', '2017-11-24 21:01:22', 12, 1),
(8, 5, 'Supervise Client Installations', '2017-11-24 21:02:05', 12, 1),
(9, 10, 'Manage Office Operations', '2017-11-24 21:02:54', 12, 1),
(10, 12, 'Manage Customer Relations', '2017-11-24 21:04:24', 12, 1),
(11, 15, 'Assist Master Installer', '2017-11-28 15:39:22', 2, 1),
(12, 17, 'Manage Office Operations', '2017-11-28 15:40:15', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parameter_name` varchar(255) DEFAULT NULL,
  `parameter_value` text,
  `parameter_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `parameter_name`, `parameter_value`, `parameter_type`) VALUES
(1, 'company_name', 'ABC Painting Co.', 'General'),
(2, 'company_email', 'admin@gmail.com', 'General'),
(3, 'company_logo', 'logo-placeholder.png', 'General'),
(4, 'company_address', '12-N Bunglows', 'General'),
(5, 'portal_address', 'http://www.', 'General'),
(6, 'currency_symbol', '$', 'General'),
(7, 'currency_position', 'Right', 'General'),
(8, 'email', 'abc@gmail.com', 'Email'),
(9, 'title_tag', 'UNIBYZ.COM', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task`
--

CREATE TABLE IF NOT EXISTS `tbl_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `milestone_id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `task_status` varchar(200) NOT NULL COMMENT '0=Open, 1=Completed',
  `notes` text,
  `attachment` varchar(255) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`id`, `project_id`, `milestone_id`, `task_name`, `start_date`, `end_date`, `task_status`, `notes`, `attachment`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 2, 'Task 1', '2017-11-22', '2017-11-30', '1', '<p>asdqwe</p>', '', '2017-11-28 11:19:18', 8, 1),
(2, 1, 1, 'Task 2', '2017-11-22', '2017-11-30', '0', '<p>asd</p>', '', '2017-11-28 11:33:41', 8, 1),
(3, 1, 3, 'Task 3', '2017-11-21', '2017-11-22', '1', '', '20171128154418_5a1d36fa98cdf_2_task.pdf', '2017-11-28 15:44:18', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_assign`
--

CREATE TABLE IF NOT EXISTS `tbl_task_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_task_assign`
--

INSERT INTO `tbl_task_assign` (`id`, `task_id`, `assigned_to`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 6, '2017-11-28 11:19:18', 8, 1),
(2, 1, 7, '2017-11-28 11:19:18', 8, 1),
(3, 2, 15, '2017-11-28 11:33:41', 8, 1),
(4, 3, 9, '2017-11-28 15:44:18', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_product`
--

CREATE TABLE IF NOT EXISTS `tbl_task_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_type_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_task_product`
--

INSERT INTO `tbl_task_product` (`id`, `task_id`, `type`, `category_id`, `category_type_id`, `product_id`, `qty`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Product', 1, 1, 1, '15', '2017-11-28 11:19:18', 8, 1),
(2, 1, 'Service', 2, 3, 1, '3', '2017-11-28 11:19:18', 8, 1),
(3, 2, 'Product', 1, 1, 1, '30', '2017-11-28 11:33:41', 8, 1),
(4, 3, 'Product', 1, 8, 8, '2', '2017-11-28 15:44:18', 8, 1),
(5, 3, 'Service', 15, 11, 8, '6', '2017-11-28 15:44:18', 8, 1),
(6, 3, 'Product', 1, 8, 7, '1', '2017-11-28 15:44:18', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taxrate`
--

CREATE TABLE IF NOT EXISTS `tbl_taxrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(255) DEFAULT NULL,
  `tax_rate` float(10,2) DEFAULT NULL,
  `notes` text NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_taxrate`
--

INSERT INTO `tbl_taxrate` (`id`, `tax_name`, `tax_rate`, `notes`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Sales Tax', 6.00, '<p>Beaufort County, SC Sales Tax</p>', '2017-11-25 00:31:32', 12, 1),
(2, 'SC Sales Tax', 6.00, '', '2017-12-06 17:29:24', 2, 1),
(3, 'SC State Withholding Tax', 1.23, '', '2017-12-06 17:29:42', 2, 1),
(4, 'SC State Income Tax', 5.00, '<p></p><p>Income $8,730 - $11,640</p><p></p>', '2017-12-06 17:32:37', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `ticket_department_id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `ticket_status_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `notify_to` int(11) NOT NULL COMMENT '0=SuperAdmin, 1=Admin, 2=Customer, 3=Project Manager, 4= Employee',
  `ticket_message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reporter_id` (`project_id`,`ticket_department_id`),
  KEY `project_id` (`project_id`),
  KEY `ticket_status_id` (`ticket_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_ticket`
--

INSERT INTO `tbl_ticket` (`id`, `project_id`, `ticket_department_id`, `ticket_type_id`, `ticket_status_id`, `subject`, `notify_to`, `ticket_message`, `attachment`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, 4, 4, 'Fix Bug Issue', 3, '<p><h2>Where does it come from?</h2><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><br></p>', '', '2017-12-01 10:15:36', 2, 1),
(2, 1, 3, 3, 1, 'Have You Any Other Organization', 2, '<p>Have You Any Other Organisation ?&nbsp;</p><p>For Connecting To Other Organisation</p>', '', '2017-12-01 10:17:44', 2, 1),
(3, 1, 1, 2, 3, 'Type Of Label', 1, '<p>Which are the types of custom labels to put in the current project ??</p>', '20171201145006_5a211ec687195_maxresdefault.jpg', '2017-12-01 14:50:06', 8, 1),
(4, 3, 1, 2, 3, 'Bug In Product Module', 4, '<p><b></b>ï»¿ï»¿Change The Product&nbsp;Module&nbsp;Name From Items To Item.<b></b></p><p><br></p>', '', '2017-12-01 15:24:07', 8, 1),
(5, 3, 1, 2, 5, 'Change Some Correction', 4, '<p>Change The Correction As Per Shown In Attachment/.</p>', '20171201162105_5a213419cfbf6_2_task.pdf', '2017-12-01 16:16:24', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_department`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_ticket_department`
--

INSERT INTO `tbl_ticket_department` (`id`, `department_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Project Management', '2017-11-30 11:35:05', 2, 1),
(2, 'Finance Department', '2017-11-30 11:35:23', 2, 1),
(3, 'Other', '2017-11-30 11:35:44', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_message`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `message_by_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reporter_id` (`ticket_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_ticket_message`
--

INSERT INTO `tbl_ticket_message` (`id`, `ticket_id`, `message_by_user_id`, `message`, `attachment`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 2, '<p>asd</p>', '', '2017-11-30 12:21:47', 2, 1),
(2, 1, 2, '<p>asd</p>', '', '2017-11-30 12:21:52', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_status`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_ticket_status`
--

INSERT INTO `tbl_ticket_status` (`id`, `status_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'New', '2017-11-30 17:38:50', 2, 1),
(2, 'Re-Opened', '2017-11-30 17:39:04', 2, 1),
(3, 'Open', '2017-11-30 17:40:00', 2, 1),
(4, 'Waiting Assessment', '2017-11-30 17:40:09', 2, 1),
(5, 'Resolved', '2017-11-30 17:40:15', 2, 1),
(6, 'Closed', '2017-11-30 17:40:22', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_type`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_ticket_type`
--

INSERT INTO `tbl_ticket_type` (`id`, `type_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Request a Change', '2017-11-30 12:02:46', 2, 1),
(2, 'Report a Bug', '2017-11-30 12:03:02', 2, 1),
(3, 'Ask a Question', '2017-11-30 12:03:15', 2, 1),
(4, 'Raise an Issue', '2017-11-30 12:03:28', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text,
  `notes` text,
  `gender` varchar(200) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `tax_id_no` varchar(200) NOT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL COMMENT '0=SuperAdmin, 1=Admin, 2=Customer, 3=Project Manager, 4=Employee',
  `user_status` int(11) DEFAULT '1' COMMENT '0=Approve, 1=Pending, 2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `address`, `notes`, `gender`, `user_image`, `tax_id_no`, `emp_id`, `user_type`, `user_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 'John', 'Slater', '804-272-3151', 'superadmin@gmail.com', 'superadmin', '1276 Coulter Lane\r\nRichmond, VA 23235', NULL, 'Male', NULL, '', NULL, 0, 0, '2017-11-24 09:31:15', 1, 1),
(2, 'Joel', 'Mueller', '231-344-2284', 'admin@gmail.com', 'admin', '<p>4697 Wetzel Lane<br>Grand Rapids, MI 49508<br></p>', '', NULL, NULL, '', NULL, 1, 0, '2017-11-24 10:52:26', 1, 1),
(4, 'Ellis', 'Forsyth', '312-345-6865', 'customer@gmail.com', 'customer', '<p>2078 Pringle Drive<br>Chicago, IL 60606</p>', '', NULL, 'ellis.jpg', 'SSN879', NULL, 2, 0, '2017-11-24 12:03:14', 2, 1),
(5, 'Jennifer', 'Collins', '814-542-6264', 'customer1@gmail.com', 'customer1', '<p>2620 Harley Brook Lane<br>Mount Union, PA 17066<br></p>', '', NULL, 'jennifer.png', '', NULL, 2, 2, '2017-11-24 12:05:59', 2, 1),
(6, 'John', 'Donnell', '218-535-3542', 'employee@gmail.com', 'employee', '<p>1501 Terra Cotta Street<br>Wadena, MN 56482<br></p>', '', NULL, '20171124171849_5a18072133cf0_emp.jpg', '', 'EMP001', 4, 1, '2017-11-24 17:18:49', 2, 1),
(7, 'Denise', 'Demaio', '660-278-2920', 'employee1@gmail.com', 'employee1', '<p>379 Fairmont Avenue<br>Steffenville, MO 63470<br></p>', '', NULL, '20171124172107_5a1807abb9c25_stock-photo-beautiful-young-female-employee-portrait-329243798.jpg', '', 'EMP002', 4, 1, '2017-11-24 17:21:07', 2, 1),
(8, 'Kathy', 'Wilson', '856-898-3693', 'projectmanager@gmail.com', 'projectmanager', '<p>1195 Valley Street<br>Camden, NJ 08102<br></p>', '', NULL, '20171124172303_5a18081f835b7_employee-glass.jpg', '', 'PJEMP003', 3, 0, '2017-11-24 17:23:03', 2, 1),
(9, 'James', 'McIntosh', '509-687-7465', 'employee2@gmail.com', 'employee2', '<p>1292 Calico Drive<br>Manson, WA 98831<br></p>', '', NULL, '20171124172916_5a180994b70eb_happy-young-businessman-9138670.jpg', '', 'EMP004', 4, 1, '2017-11-24 17:29:16', 2, 1),
(10, 'Damon', 'Black', ' 724-580-9388', 'admin1@gmail.com', 'admin1', '<p>1476 Shinn Avenue<br>Pittsburgh, PA 15212<br></p>', '', NULL, NULL, '', NULL, 1, 0, '2017-11-24 18:12:23', 1, 1),
(11, 'John', 'Slater', '+18433381105', 'jslater@unilyze.com', 'Coolcast1', '<p>25 Gum Tree Road</p><p>Hilton Head Island</p><p>29926 South Carolina</p>', '', NULL, NULL, '', NULL, 1, 0, '2017-11-24 19:42:30', 1, 1),
(12, 'Wosvaldo', 'Servin', '+18433381105', 'wosvaldo@unibyz.com', 'Wosvaldo01', '<p>18 Gideon Way</p><p>Bluffton</p><p>29910 South Carolina</p>', '', NULL, NULL, '', NULL, 1, 0, '2017-11-24 19:55:28', 1, 1),
(13, 'Javier', 'Restrepo', '+18433427664', 'jr@conquestins.com', 'Javier01', '<p>435 William Hilton Parkway</p><p>Hilton Head Island</p><p>29926 South Carolina</p>', '', NULL, '', '', NULL, 2, 0, '2017-11-24 20:15:24', 12, 1),
(14, 'Juan', 'Santillana', '+18436830929', 'juan@unibyz.com', 'Juan01', '<p>25 Bluffton Parkway</p><p>Bluffton</p><p>29910 South Carolina</p>', '', NULL, '', '222-444-9999', 'PJ002', 3, 0, '2017-11-24 23:58:47', 12, 1),
(15, 'Maria', 'Pardo', '+8437152099', 'maria@unibyz.com', 'Maria01', '<p>65 Beaufort Parkway</p><p>Beaufort</p><p>29843 South Carolina</p>', '', NULL, '', '333-111-6666', 'EMP005', 4, 0, '2017-11-25 00:00:16', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_order`
--

CREATE TABLE IF NOT EXISTS `tbl_work_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `category_type` varchar(200) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `work_order_name` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `problem` text,
  `expected_fix_date` varchar(255) DEFAULT NULL,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL COMMENT '0=Pending, 1=Active, 2=Reject',
  `send_sms` varchar(100) DEFAULT NULL,
  `send_email` varchar(100) DEFAULT NULL,
  `work_order_status` int(11) NOT NULL DEFAULT '0' COMMENT 'By Default 0, When Invoice Generate Then Status = 1',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
