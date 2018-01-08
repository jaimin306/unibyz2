-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2017 at 07:49 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_repair`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Paint', '2017-11-10 19:14:49', 2, 1),
(2, 'Paint Service', '2017-11-10 19:14:58', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_company_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_company_detail`
--

INSERT INTO `tbl_company_detail` (`id`, `user_id`, `company_name`, `company_logo`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 'SW Solution Pvt. Ltd.', 'sw.jpg', '2017-11-10 19:12:20', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `department_name`, `department_code`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Business Management', '1000', '2017-11-10 19:33:39', 2, 1),
(2, 'Finance & Planning', '2000', '2017-11-10 19:33:51', 2, 1),
(3, 'Sales & Marketing', '3000', '2017-11-10 19:34:01', 2, 1),
(4, 'Project Management', '4000', '2017-11-10 19:34:10', 2, 1),
(5, 'Customer Service', '5000', '2017-11-10 19:34:22', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `work_order_id` int(11) NOT NULL,
  `estimate_date` varchar(200) DEFAULT NULL,
  `estimate_due_date` varchar(200) DEFAULT NULL,
  `notify_client` varchar(200) DEFAULT NULL,
  `notes` text NOT NULL,
  `estimate_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Accept,2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_estimate`
--

INSERT INTO `tbl_estimate` (`id`, `customer_id`, `work_order_id`, `estimate_date`, `estimate_due_date`, `notify_client`, `notes`, `estimate_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 3, 1, '2017-11-10', '2017-11-15', 'No', '', 0, '2017-11-10 19:32:54', 2, 1),
(2, 4, 2, '2017-11-10', '2017-11-18', 'No', '', 0, '2017-11-10 19:47:47', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate_item`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `product_detail` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  `unit_price` varchar(200) DEFAULT NULL,
  `total_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_estimate_item`
--

INSERT INTO `tbl_estimate_item` (`id`, `estimate_id`, `product_id`, `product_detail`, `item`, `description`, `qty`, `taxrate_id`, `unit_price`, `total_tax`, `total`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, '', 'Asian Paint', 'Test', '2', 1, '1200.00', '144.00', '2544.00', '2017-11-10 19:32:54', 2, 1),
(2, 1, 0, 'Labour Charge', '', '', '', 2, '200', '2.46', '202.46', '2017-11-10 19:32:54', 2, 1),
(3, 2, 1, '', 'Asian Paint', 'Tes', '2', 4, '1200.00', '144.00', '2544.00', '2017-11-10 19:47:47', 2, 1);

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
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `description` text,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `product_name`, `code`, `brand`, `quantity`, `price`, `description`, `notes`, `photo_path`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'White Paint', 'WP005', 'AsianPaint', '12', 1200.00, '<p>When your home looks great, you feel great. Give your walls a silky glowing appearance with Asian Paint<br></p>', '', '1.jpg', '2017-11-10 19:19:06', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE IF NOT EXISTS `tbl_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `description` text,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`id`, `category_id`, `service_name`, `code`, `brand`, `price`, `description`, `notes`, `photo_path`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 'Home Painting Service', 'HPS002', 'AsianPaint', 200.00, '<p>If youâ€™re looking for a hassle free painting experience, you will love this. With Home Painting Services include wall paint ( Tax ).<br></p>', '', '', '2017-11-10 19:20:44', 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

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
(8, 'email', 'abc@gmail.com', 'Email');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_taxrate`
--

INSERT INTO `tbl_taxrate` (`id`, `tax_name`, `tax_rate`, `notes`, `add_date`, `add_uid`, `status`) VALUES
(1, 'SC Sales Tax', 6.00, '<p>SC State Sales Tax<br></p>', '2017-11-10 19:29:03', 2, 1),
(2, 'SC State Withholding Tax', 1.23, '<p>SC Withholding Tax<br></p>', '2017-11-10 19:29:30', 2, 1),
(3, 'SC State Income Tax', 5.00, '<p>Income $8,730 - $11,640<br></p>', '2017-11-10 19:29:46', 2, 1),
(4, 'SC State Income Tax', 6.00, '<p><p>Income $11,640 - $14,550</p></p>', '2017-11-10 19:30:48', 2, 1),
(5, 'SC State Income Tax', 7.00, '<p>Income $14,550 +<br></p>', '2017-11-10 19:31:08', 2, 1),
(6, 'Federal Withholding Tax', 15.00, '', '2017-11-10 19:31:23', 2, 1);

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
  `user_type` int(11) DEFAULT NULL COMMENT '0=SuperAdmin, 1=Admin, 2=Customer',
  `user_status` int(11) DEFAULT '1' COMMENT '0=Approve, 1=Pending, 2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `address`, `notes`, `gender`, `user_image`, `user_type`, `user_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Rickey', 'Allen', '701-480-8024', 'superadmin@gmail.com', 'superadmin', '221 Courtright Street\r\nBottineau, ND 58318', NULL, 'Male', NULL, 0, 0, '2017-11-10 08:16:31', 1, 1),
(2, 'Hershel', 'Rivera', '915-691-9108', 'admin@gmail.com', 'admin', '<p>2904 Chipmunk Lane<br>Seattle, WA 98101<br></p>', '', NULL, NULL, 1, 0, '2017-11-10 19:12:20', 1, 1),
(3, 'Jerry', 'Lyons', '912-546-4788', 'jerry@gmail.com', 'jerry123', '<p>4061 Modoc Alley<br>Boise, ID 83702<br></p>', '', 'Male', 'peter.jpg', 2, 1, '2017-11-10 19:23:03', 2, 1),
(4, 'Brian', 'Miller', '154-456-8978', 'brian@gmail.com', 'brian', '<p>2515 Glen Street<br>Paducah, KY 42003<br></p>', '', 'Male', 'brian.jpg', 2, 1, '2017-11-10 19:25:18', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_order`
--

CREATE TABLE IF NOT EXISTS `tbl_work_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_work_order`
--

INSERT INTO `tbl_work_order` (`id`, `category_id`, `customer_id`, `work_order_name`, `model`, `serial_no`, `problem`, `expected_fix_date`, `notes`, `photo_path`, `order_status`, `send_sms`, `send_email`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 3, 'ABC Electric', 'ABC005', 'SER2202', '<p>Paint the wall in ABC Electric With White Color</p>', '2017-11-14', '', 'electric.jpg', 0, 'Yes', 'No', '2017-11-10 19:27:13', 2, 1),
(2, 1, 4, 'XYZ Computer SShop', 'MOD002', 'SHE123', '<p>Whole Computer Shop With 3 Room &amp; 1 Extra Hall</p>', '2017-11-17', '', '', 0, 'No', 'No', '2017-11-10 19:44:43', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
