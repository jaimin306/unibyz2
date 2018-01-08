-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2018 at 05:43 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_repairshop_nw`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_all_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_all_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_symbol` varchar(255) NOT NULL,
  `portal_address` text NOT NULL,
  `date_format` varchar(255) DEFAULT 'm-d-Y',
  `sms_enabled` varchar(255) NOT NULL,
  `sms_gateway` varchar(255) NOT NULL,
  `sms_sender_name` varchar(255) NOT NULL,
  `twilio_sid` varchar(255) NOT NULL,
  `twilio_token` varchar(255) NOT NULL,
  `twilio_phone` varchar(255) NOT NULL,
  `email_payment_subject` varchar(255) NOT NULL,
  `email_payment_template` text NOT NULL,
  `sms_payment_subject` varchar(255) NOT NULL,
  `sms_payment_template` text NOT NULL,
  `cron_job` varchar(255) NOT NULL,
  `online_payment` varchar(255) NOT NULL,
  `paypal_enabled` varchar(255) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `paynow_enabled` varchar(255) NOT NULL,
  `paynow_id` varchar(255) NOT NULL,
  `paynow_key` varchar(255) NOT NULL,
  `stripe_enabled` varchar(255) NOT NULL,
  `stripe_key` varchar(255) NOT NULL,
  `stripe_secret` varchar(255) NOT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_all_setting`
--

INSERT INTO `tbl_all_setting` (`id`, `user_id`, `country`, `currency`, `currency_symbol`, `portal_address`, `date_format`, `sms_enabled`, `sms_gateway`, `sms_sender_name`, `twilio_sid`, `twilio_token`, `twilio_phone`, `email_payment_subject`, `email_payment_template`, `sms_payment_subject`, `sms_payment_template`, `cron_job`, `online_payment`, `paypal_enabled`, `paypal_email`, `paynow_enabled`, `paynow_id`, `paynow_key`, `stripe_enabled`, `stripe_key`, `stripe_secret`, `add_uid`, `add_date`, `status`) VALUES
(1, 2, 'India', 'INR', '$', 'https://www.evoluted.net/thinktank/web-development/time-saving-database-functions', 'd.m.Y', 'Yes', 'Yes', 'S1', 'f2hPWsv_B5GGX7XMhPgD', '7XMhPgD', '97257887989', 'Payment Subject', '<p>No....</p>', 'SMDS', '<p>ABC</p>', 'No', 'Yes', 'No', 'abc@gmail.com', 'No', 'HIJUASDYHI', 'hjtqwe786123hkjasd', 'Yes', 'ghjagshdjqwe', 'q123asd', 2, '2018-01-05 17:27:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE IF NOT EXISTS `tbl_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`id`, `brand_name`, `add_date`, `add_uid`, `status`) VALUES
(1, 'brand1', '2017-12-15 16:46:09', 2, 1),
(2, 'brand2', '2017-12-15 16:46:18', 2, 1);

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
(5, 'Interceptor Vehicle', '2017-12-14 05:53:26', 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_company_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_address` text,
  `state` varchar(255) NOT NULL,
  `license_no` varchar(255) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_company_detail`
--

INSERT INTO `tbl_company_detail` (`id`, `user_id`, `company_name`, `company_logo`, `company_email`, `company_website`, `company_address`, `state`, `license_no`, `add_date`, `add_uid`, `status`) VALUES
(3, 2, 'Prodigy Solutions ', 'imgpsh_fullsize.png', 'prodigysolutions@gmail.com', 'http://www.prodigysolutions.com', '3670 Limer Street\r\nAtlanta, GA 30303', '', '', '2017-11-24 10:52:26', 1, 1),
(4, 10, 'Ironaid', 'logo1.png', '', NULL, NULL, '', '', '2017-11-24 18:12:23', 1, 1),
(5, 11, 'Unilyze Inc.', 'good_logo_unilyze_1_40_1_40.png', '', NULL, NULL, '', '', '2017-11-24 19:42:30', 1, 1),
(6, 12, 'R&S Hardwood Floors and Tile Inc.', 'cooltext269318142880584.png', 'jslater@unilyze.com', NULL, '10 Gideon Way\nBluffton\n29910 South Carolina\nLicense #RBS47896', 'South Carolina', 'RBS.47896', '2017-11-24 19:55:28', 1, 1),
(7, 16, 'Skyline Services', '', '', NULL, NULL, 'South Carolina', '123.456', '2017-12-01 09:57:10', 1, 1),
(8, 18, 'PFS Interceptor NFP', 'CoolText Logo PFS Interceptor.png', '', NULL, NULL, 'South Carolina', '123456-Z', '2017-12-14 05:26:55', 1, 1),
(9, 19, 'Vogel Marketing Solutions LLC', 'logo sq.jpg', 'mark@vogelmarketing.net', NULL, '255 Butler Avenue\r\nSuite 201-B', 'Pennsylvania', '', '2017-12-28 00:53:51', 1, 1);

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
(3, 'Finance & Accounting', 'AC4001', '2017-11-24 17:37:37', 2, 1),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `customer_phone` varchar(200) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `address_of_work` text NOT NULL,
  `technician_name` varchar(255) DEFAULT NULL,
  `technician_number` varchar(255) DEFAULT NULL,
  `estimate_date` varchar(200) DEFAULT NULL,
  `estimate_due_date` varchar(200) DEFAULT NULL,
  `notify_department` varchar(200) DEFAULT NULL,
  `notify_email` int(11) DEFAULT '1' COMMENT '0 = Mail Sent, 1= Not Mailed',
  `notify_email_date` datetime DEFAULT NULL,
  `notes` text,
  `estimate_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Accept,2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_estimate`
--

INSERT INTO `tbl_estimate` (`id`, `customer_id`, `department_id`, `customer_phone`, `customer_email`, `address_of_work`, `technician_name`, `technician_number`, `estimate_date`, `estimate_due_date`, `notify_department`, `notify_email`, `notify_email_date`, `notes`, `estimate_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 5, 2, '814-542-6264', 'customer1@gmail.com', '', 'Levi S. Hilton', 'TN14557', '2017-11-24', '2017-11-30', 'No', 0, '0000-00-00 00:00:00', '', 0, '2017-11-24 17:41:08', 2, 1),
(2, 5, 4, '814-542-6264', 'customer1@gmail.com', '', 'Quincy R. Killion', 'TN123', '2017-11-29', '2017-11-30', 'No', 0, '0000-00-00 00:00:00', '', 0, '2017-11-24 17:46:22', 2, 1),
(3, 4, 5, '312-345-6865', 'customer@gmail.com', '', 'Ronald P. Hardy', '1500325', '2017-12-28', '2017-12-30', 'Yes', 0, '0000-00-00 00:00:00', '', 1, '2017-11-24 17:47:14', 2, 1),
(4, 13, 7, '+18433427664', 'jr@conquestins.com', '', 'Wosvaldo Servin', 'HR001', '2017-11-24', '2017-11-24', 'Yes', 0, '0000-00-00 00:00:00', '<p>Great Customer</p>', 1, '2017-11-25 00:52:29', 12, 1),
(5, 17, 2, '9979999985', 'jack@gmail.com', '', 'Apal', '9968989874', '2017-12-08', '2017-12-14', 'Yes', 0, '0000-00-00 00:00:00', '', 0, '2017-12-07 12:24:20', 2, 1),
(6, 17, 2, '9979999985', 'jack@gmail.com', '', 'Apal', '9968989874', '2017-12-14', '2017-12-21', 'Yes', 0, '0000-00-00 00:00:00', '', 0, '2017-12-07 12:57:46', 2, 1),
(7, 5, 2, '814-542-6264', 'customer1@gmail.com', '', 'Apalkumar', '1010101020', '2017-12-08', '2017-12-12', 'Yes', 0, '0000-00-00 00:00:00', '', 2, '2017-12-07 14:56:10', 2, 1),
(11, 5, 4, '814-542-6264', 'customer1@gmail.com', '', 'technical1', 'tech123', '2017-12-15', '2017-12-30', 'No', 1, '2018-01-23 08:34:21', '<p>comment1</p>', 0, '2017-12-15 10:35:27', 2, 1),
(12, 5, 1, '814-542-6264', 'customer1@gmail.com', '', 'te6', 'no6', '2017-12-15', '2017-12-30', 'No', 1, '2017-12-05 06:14:20', '<p>comment2</p>', 1, '2017-12-15 15:13:32', 2, 1),
(14, 5, 2, '814-542-6264', 'customer1@gmail.com', '', 'tech', 'tech no', '2017-12-15', '2018-01-05', 'No', 1, '2017-12-06 08:42:26', '<p>comment1</p>', 1, '2017-12-18 15:01:42', 2, 1),
(15, 5, 2, '814-542-6264', 'customer1@gmail.com', '', '', '', '2017-12-18', '2018-01-06', 'No', 0, '0000-00-00 00:00:00', '', 1, '2017-12-18 18:46:22', 2, 1),
(16, 5, 1, '843-338-1105', 'jslater@agentapp24.com', '', 'Kevin Palacio', '10023', '2017-12-27', '2017-12-28', 'Yes', 1, '2017-12-13 09:37:35', '', 0, '2017-12-27 18:17:43', 2, 1),
(17, 5, 0, '814-542-6264', 'customer1@gmail.com', '', '', '', '', '', 'Yes', 1, '2017-12-06 10:32:20', '', 0, '2017-12-30 02:18:43', 2, 1),
(18, 4, 2, '312-345-6865', 'customer@gmail.com', '', 'TN1', 'TN1111', '2018-01-02', '2018-01-04', 'Yes', 1, '2017-12-05 07:31:18', '<p>4</p>', 1, '2018-01-01 10:43:22', 2, 1),
(19, 4, 3, '312-345-6865', 'customer@gmail.com', '', 'Betty A. Ambrose', 'TN0015458', '2018-01-03', '2018-01-17', 'No', 1, NULL, '<p>asd</p>', 1, '2018-01-02 10:47:02', 2, 1),
(20, 17, 3, '9979999985', 'jack@gmail.com', 'asdqwe', 'James E. Kawakami', 'TN1122', '2018-01-03', '2018-01-05', 'Yes', 1, NULL, '', 1, '2018-01-02 17:39:05', 2, 1),
(21, 17, 3, '9979999985', 'jack@gmail.com', 'EST 1', 'TRE23', 'Roy', '2018-01-04', '2018-01-08', 'Yes', 1, NULL, '', 1, '2018-01-05 13:24:19', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estimate_item`
--

CREATE TABLE IF NOT EXISTS `tbl_estimate_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `product_detail` varchar(255) DEFAULT NULL,
  `measurement_type` int(11) DEFAULT NULL,
  `measurement` int(11) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  `unit_price` varchar(200) DEFAULT NULL,
  `total_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_estimate_item`
--

INSERT INTO `tbl_estimate_item` (`id`, `estimate_id`, `product_id`, `product_detail`, `measurement_type`, `measurement`, `qty`, `taxrate_id`, `unit_price`, `total_tax`, `total`, `add_date`, `add_uid`, `status`) VALUES
(2, 11, 1, 'Product', 0, 0, '1', 2, '1600.00', '160.00', '1760.00', '2017-12-15 10:35:27', 2, 1),
(3, 11, 1, 'Service', 0, 0, '2', 0, '15.00', '0', '30.00', '2017-12-15 10:35:27', 2, 1),
(4, 12, 1, 'Product', 0, 0, '1', 2, '1600.00', '160.00', '1760.00', '2017-12-15 15:13:32', 2, 1),
(6, 14, 1, 'Product', 0, 0, '1', 2, '1600.00', '160.00', '1760.00', '2017-12-18 15:01:42', 2, 1),
(7, 14, 1, 'Service', 0, 0, '5', 0, '15.00', '0', '75.00', '2017-12-18 15:01:42', 2, 1),
(8, 15, 1, 'Product', 0, 0, '1', 0, '1600.00', '0', '1600.00', '2017-12-18 18:46:22', 2, 1),
(9, 16, 1, 'Product', 0, 0, '10', 4, '11.50', '6.90', '121.90', '2017-12-27 18:17:43', 2, 1),
(10, 17, 1, 'Product', 5, 14, '1', 4, '11.50', '0.69', '12.19', '2017-12-30 02:18:43', 2, 1),
(11, 17, 1, 'Service', 11, 19, '1', 4, '15.00', '0.90', '15.90', '2017-12-30 02:18:43', 2, 1),
(12, 17, 1, 'Service', 11, 19, '10', 4, '15.00', '9.00', '159.00', '2017-12-30 02:18:43', 2, 1),
(13, 18, 1, 'Service', 11, 18, '8', 4, '0.25', '0.12', '2.12', '2018-01-01 10:43:22', 2, 1),
(14, 18, 1, 'Product', 5, 15, '1', 4, '11.50', '0.69', '12.19', '2018-01-01 10:43:22', 2, 1),
(15, 19, 1, 'Product', 5, 15, '22', 4, '11.50', '15.18', '268.18', '2018-01-02 10:47:02', 2, 1),
(16, 19, 1, 'Service', 11, 19, '12', 4, '15.00', '10.80', '190.80', '2018-01-02 10:47:02', 2, 1),
(19, 20, 1, 'Product', 5, 15, '3', 4, '11.50', '0', '34.5', '2018-01-04 18:08:47', 2, 1),
(20, 21, 1, 'Product', 2, 4, '1', 4, '11.50', '0.69', '12.19', '2018-01-05 13:24:19', 2, 1),
(21, 21, 1, 'Service', 11, 19, '3', 0, '15.00', '0', '45.00', '2018-01-05 13:24:19', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense`
--

CREATE TABLE IF NOT EXISTS `tbl_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_type_id` int(11) NOT NULL,
  `expense_amount` float NOT NULL,
  `e_date` date DEFAULT NULL,
  `recurring` enum('yes','no') NOT NULL,
  `description` text NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_uid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_expense`
--

INSERT INTO `tbl_expense` (`id`, `expense_type_id`, `expense_amount`, `e_date`, `recurring`, `description`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1200, '2017-12-16', 'no', '<p>description....</p><p><br></p>', '2017-12-16 12:34:48', 2, 1),
(2, 4, 560, '2017-12-25', 'no', '<p>description1</p>', '2017-12-16 12:35:47', 2, 1),
(4, 2, 890, '2017-12-21', 'yes', '', '2017-12-16 13:26:34', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_file`
--

CREATE TABLE IF NOT EXISTS `tbl_expense_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_id` int(11) DEFAULT NULL,
  `file_path` text,
  `add_uid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_expense_file`
--

INSERT INTO `tbl_expense_file` (`id`, `expense_id`, `file_path`, `add_uid`, `status`) VALUES
(1, 1, '6.jpg', 2, 1),
(2, 1, '7.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_type`
--

CREATE TABLE IF NOT EXISTS `tbl_expense_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_type` varchar(255) DEFAULT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_expense_type`
--

INSERT INTO `tbl_expense_type` (`id`, `expense_type`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Comensation/Salaries/Wages', '2017-12-16 16:03:30', 2, 1),
(2, 'Administration Expense', '2017-12-16 16:03:40', 2, 1),
(3, 'Marketing and Sales Expense', '2017-12-16 16:03:48', 2, 1),
(4, 'Miscellaneous Expense', '2017-12-16 16:04:01', 2, 1),
(6, 'Rent', '2017-12-17 21:26:00', 12, 1),
(7, 'Utilities', '2017-12-17 21:26:37', 12, 1),
(8, 'Insurance', '2017-12-17 21:26:50', 12, 1),
(9, 'Fees', '2017-12-17 21:27:02', 12, 1),
(10, 'Wages', '2017-12-17 21:27:09', 12, 1),
(11, 'Taxes', '2017-12-17 21:27:26', 12, 1),
(12, 'Interest', '2017-12-17 21:27:36', 12, 1),
(13, 'Supplies', '2017-12-17 21:27:51', 12, 1),
(14, 'Depreciation', '2017-12-17 21:28:04', 12, 1),
(15, 'Maintenance', '2017-12-17 21:28:14', 12, 1),
(16, 'Travel', '2017-12-17 21:36:53', 12, 1),
(17, 'Meals and Entertainment', '2017-12-17 21:37:30', 12, 1),
(18, 'Training', '2017-12-17 21:38:10', 12, 1);

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
(1, 'Independence Day', '2017-08-15', '2017-08-17', 2, '2017-12-04 16:59:18', 2, 1),
(2, 'Eid al-Fitr', '2017-06-25', '2017-06-30', 5, '2017-12-04 17:00:52', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `notify_client` varchar(200) DEFAULT NULL,
  `notify_client_date` datetime DEFAULT NULL,
  `notes` text,
  `invoice_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Accept,2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`id`, `project_id`, `invoice_date`, `invoice_due_date`, `notify_client`, `notify_client_date`, `notes`, `invoice_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 5, '2017-12-14', '2017-12-14', 'Yes', NULL, '', 0, '2017-12-13 20:57:42', 2, 1),
(3, 5, '2017-12-16', '2017-12-26', 'No', NULL, '<p>note12</p>', 0, '2017-12-15 15:17:10', 2, 1),
(6, 15, '2017-12-15', '2018-01-05', 'No', NULL, '', 0, '2017-12-18 14:49:15', 2, 1),
(7, 15, '2018-01-05', '2018-01-06', 'No', NULL, '', 0, '2017-12-18 15:11:40', 2, 1),
(8, 16, '2017-12-18', '2017-12-28', 'No', NULL, '<p>ddfgdf</p>', 1, '2017-12-18 18:56:42', 2, 1),
(9, 16, '2017-12-29', '2018-01-03', 'Yes', NULL, '<p>dfgdfg</p>', 0, '2017-12-30 18:37:32', 2, 1),
(10, 17, '2018-01-02', '2018-01-10', 'Yes', NULL, '<p>f</p>', 1, '2018-01-01 10:50:14', 2, 1),
(11, 18, '2018-01-11', '2018-01-26', 'Yes', NULL, '', 0, '2018-01-02 17:25:07', 2, 1),
(12, 19, '2018-01-10', '2018-01-17', 'Yes', NULL, '', 0, '2018-01-02 18:02:59', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_item`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `product_detail` varchar(255) DEFAULT NULL,
  `measurement_type` int(11) DEFAULT NULL,
  `measurement` int(11) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  `unit_price` varchar(200) DEFAULT NULL,
  `total_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_invoice_item`
--

INSERT INTO `tbl_invoice_item` (`id`, `invoice_id`, `product_id`, `product_detail`, `measurement_type`, `measurement`, `qty`, `taxrate_id`, `unit_price`, `total_tax`, `total`, `add_date`, `add_uid`, `status`) VALUES
(1, 9, 7, 'Product', 2, 6, '1', 4, '9.00', '0.54', '9.54', '2017-12-30 18:37:32', 2, 1),
(2, 9, 1, 'Product', 5, 15, '1', 4, '11.50', '0.69', '12.19', '2017-12-30 18:37:32', 2, 1),
(3, 9, 1, 'Service', 11, 19, '2', 0, '120.00', '0', '240.00', '2017-12-30 18:37:32', 2, 1),
(4, 10, 1, 'Product', 5, 15, '2', 0, '11.50', '0', '23', '2018-01-01 10:50:14', 2, 1),
(5, 10, 1, 'Service', 11, 19, '33', 0, '120.00', '0', '3960.00', '2018-01-01 10:50:14', 2, 1),
(6, 11, 1, 'Product', 5, 15, '1', 0, '11.50', '0', '11.50', '2018-01-02 17:25:07', 2, 1),
(7, 11, 1, 'Service', 11, 19, '13', 0, '120.00', '0', '1560.00', '2018-01-02 17:25:07', 2, 1),
(8, 12, 7, 'Product', 1, 2, '2', 4, '9.00', '1.08', '19.08', '2018-01-02 18:02:59', 2, 1),
(9, 12, 1, 'Service', 11, 20, '3', 4, '15.00', '2.70', '47.70', '2018-01-02 18:02:59', 2, 1);

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
-- Table structure for table `tbl_measurement`
--

CREATE TABLE IF NOT EXISTS `tbl_measurement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measurement_type_id` int(11) NOT NULL,
  `measurement_name` varchar(255) DEFAULT NULL,
  `measurement_order` int(11) NOT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_measurement`
--

INSERT INTO `tbl_measurement` (`id`, `measurement_type_id`, `measurement_name`, `measurement_order`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Cubic Inches', 1, '2017-12-28 12:27:11', 2, 1),
(2, 1, 'Cubic Feet', 10, '2017-12-28 12:27:19', 2, 1),
(3, 1, 'Cubic ', 11, '2017-12-28 12:27:29', 2, 1),
(4, 2, 'Inches', 12, '2017-12-28 12:27:52', 2, 1),
(5, 2, 'Feet', 13, '2017-12-28 12:28:04', 2, 1),
(6, 2, 'Yards', 9, '2017-12-28 12:28:15', 2, 1),
(7, 2, 'Miles', 15, '2017-12-28 12:28:27', 2, 1),
(8, 3, 'Square Inches', 14, '2017-12-28 12:28:48', 2, 1),
(9, 3, 'Feet', 3, '2017-12-28 12:28:56', 2, 1),
(10, 3, 'Yards', 2, '2017-12-28 12:29:06', 2, 1),
(11, 4, 'Ounce(oz)', 8, '2017-12-28 12:29:32', 2, 1),
(12, 4, 'Pound(lb)', 7, '2017-12-28 12:29:45', 2, 1),
(13, 5, 'Pint', 6, '2017-12-28 12:30:06', 2, 1),
(14, 5, 'Quart', 5, '2017-12-28 12:30:14', 2, 1),
(15, 5, 'Gallon', 4, '2017-12-28 12:30:26', 2, 1),
(18, 11, 'Month', 4, '2017-12-28 13:18:53', 2, 1),
(19, 11, 'Hours', 1, '2017-12-28 13:19:04', 2, 1),
(20, 11, 'Days', 2, '2017-12-28 13:19:13', 2, 1),
(21, 11, 'Weeks', 3, '2017-12-28 13:19:24', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_measurement_type`
--

CREATE TABLE IF NOT EXISTS `tbl_measurement_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measurement_type` varchar(255) DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_measurement_type`
--

INSERT INTO `tbl_measurement_type` (`id`, `measurement_type`, `type`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Volume', 'Product', '2017-12-28 11:34:52', 2, 1),
(2, 'Length', 'Product', '2017-12-28 11:35:03', 2, 1),
(3, 'Area', 'Product', '2017-12-28 11:35:10', 2, 1),
(4, 'Weight', 'Product', '2017-12-28 11:35:18', 2, 1),
(5, 'Liquids', 'Product', '2017-12-28 11:35:26', 2, 1),
(6, 'Pieces', 'Product', '2017-12-28 11:37:25', 2, 1),
(7, 'Units', 'Product', '2017-12-28 11:37:33', 2, 1),
(11, 'Billing Frequency', 'Service', '2017-12-28 13:16:15', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'left_sidebar',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `menu_name`, `slug`, `type`) VALUES
(1, 'Audit Reports', 'audit_report', 'left_sidebar'),
(2, 'Customers', 'customers', 'left_sidebar'),
(3, 'Estimates', 'estimates', 'left_sidebar'),
(4, 'Work Order', 'work_order', 'left_sidebar'),
(5, 'Projects', 'project', 'left_sidebar'),
(6, 'Resolution Center', 'resolution_center', 'left_sidebar'),
(7, 'Departments', 'departments', 'left_sidebar'),
(8, 'Users', 'users', 'left_sidebar'),
(9, 'Employees', 'employees', 'left_sidebar'),
(10, 'Invoices', 'invoices', 'left_sidebar'),
(11, 'Other Income', 'other_income', 'left_sidebar'),
(12, 'Expenses', 'expenses', 'left_sidebar'),
(13, 'Leave', 'leave', 'left_sidebar'),
(14, 'Payroll', 'payroll', 'left_sidebar'),
(15, 'Vendors', 'vendors', 'left_sidebar'),
(16, 'Products', 'products', 'left_sidebar'),
(17, 'Services', 'services', 'left_sidebar'),
(18, 'Inventory Management', 'inventory_management', 'left_sidebar'),
(19, 'Assets', 'assets', 'left_sidebar'),
(20, 'Reports', 'reports', 'left_sidebar'),
(21, 'Custom Fields', 'custom_fields', 'left_sidebar'),
(22, 'Communications', 'communications', 'left_sidebar');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_permission`
--

CREATE TABLE IF NOT EXISTS `tbl_menu_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_menu_permission`
--

INSERT INTO `tbl_menu_permission` (`id`, `user_id`, `menu_id`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 12, '2017-11-24 14:22:56', 2, 1),
(2, 3, 14, '2017-11-24 21:36:38', 12, 1),
(3, 3, 14, '2017-11-24 21:41:07', 12, 1),
(4, 3, 16, '2017-11-24 21:42:58', 12, 1),
(5, 3, 16, '2017-11-24 21:44:27', 12, 1),
(6, 3, 18, '2017-11-24 21:45:48', 12, 1),
(7, 1, 9, '2017-12-07 12:19:17', 2, 1),
(8, 5, 36000, '2017-12-14 06:02:34', 18, 1),
(9, 5, 32000, '2017-12-14 06:04:00', 18, 1),
(10, 5, 23500, '2017-12-14 06:07:47', 18, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_milestone`
--

INSERT INTO `tbl_milestone` (`id`, `project_id`, `milestone_name`, `notes`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Project Review', '', '2017-12-07 17:04:40', 8, 1),
(2, 1, 'Audit', '', '2017-12-07 17:04:59', 8, 1),
(3, 1, ' Change Management', '', '2017-12-07 17:05:15', 8, 1),
(4, 1, 'Testing complete', '<p>Testing complete<br></p>', '2017-12-07 18:35:10', 8, 1),
(5, 1, 'final delivery', '<p>final del</p>', '2017-12-11 17:57:51', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll`
--

CREATE TABLE IF NOT EXISTS `tbl_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `payroll_date` date DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `total_pay` float DEFAULT NULL,
  `total_deduction` float DEFAULT NULL,
  `net_pay` float DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_no` varchar(100) DEFAULT NULL,
  `description` text,
  `paid_amount` float DEFAULT NULL,
  `comments` text,
  `recurring` enum('yes','no') DEFAULT NULL,
  `recur_frequency` int(11) DEFAULT NULL,
  `recur_type` varchar(15) DEFAULT NULL,
  `recur_starts` date DEFAULT NULL,
  `recur_end` date DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_payroll`
--

INSERT INTO `tbl_payroll` (`id`, `employee_id`, `payroll_date`, `business_name`, `total_pay`, `total_deduction`, `net_pay`, `payment_method`, `bank_name`, `account_no`, `description`, `paid_amount`, `comments`, `recurring`, `recur_frequency`, `recur_type`, `recur_starts`, `recur_end`, `add_date`, `add_uid`, `status`) VALUES
(4, 6, '2017-12-27', 'Prodigy Solutions', 10100, 205, 9895, 'cache', 'HDFC', 'no123', '', 9895, '', 'yes', 1, 'month', '2017-12-01', '2018-03-31', '2017-12-27 12:24:23', 2, 1),
(5, 6, '2018-01-01', 'Prodigy Solutions', 10100, 300, 9800, 'cache', 'HDFC', 'no123', '', 9800, '', 'yes', 1, 'month', '2017-12-01', '2018-03-31', '2017-12-27 12:25:00', 2, 1),
(8, 7, '2018-01-01', 'Prodigy Solutions', 10100, 200, 9900, 'cache', 'HDFC', '32569856321', '', 9900, '', 'yes', 1, 'month', '2017-12-01', '2018-02-28', '2017-12-27 12:30:45', 2, 1),
(9, 6, '2018-01-01', 'Prodigy Solutions', 10100, 300, 9800, 'cache', 'HDFC', 'no123', '', 9800, '', 'no', 1, 'month', '2017-12-01', '2018-03-31', '2018-01-01 05:24:13', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_payroll_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=210 ;

--
-- Dumping data for table `tbl_payroll_detail`
--

INSERT INTO `tbl_payroll_detail` (`id`, `payroll_id`, `template_id`, `value`, `add_date`, `add_uid`, `status`) VALUES
(77, 5, 1, 'address1', '2017-12-27 12:25:00', 2, 1),
(78, 5, 2, 'asds', '2017-12-27 12:25:00', 2, 1),
(79, 5, 3, 'df', '2017-12-27 12:25:00', 2, 1),
(80, 5, 4, 'dsf', '2017-12-27 12:25:00', 2, 1),
(81, 5, 5, 'dsf', '2017-12-27 12:25:00', 2, 1),
(82, 5, 6, 'dffd', '2017-12-27 12:25:00', 2, 1),
(83, 5, 7, 'dsf', '2017-12-27 12:25:00', 2, 1),
(84, 5, 8, 'dsf', '2017-12-27 12:25:00', 2, 1),
(85, 5, 9, 'dsf', '2017-12-27 12:25:00', 2, 1),
(86, 5, 10, 'dfd', '2017-12-27 12:25:00', 2, 1),
(87, 5, 11, '10000', '2017-12-27 12:25:00', 2, 1),
(88, 5, 12, '100', '2017-12-27 12:25:00', 2, 1),
(89, 5, 13, '', '2017-12-27 12:25:00', 2, 1),
(90, 5, 14, '', '2017-12-27 12:25:00', 2, 1),
(91, 5, 15, '100', '2017-12-27 12:25:00', 2, 1),
(92, 5, 16, '100', '2017-12-27 12:25:00', 2, 1),
(93, 5, 17, '100', '2017-12-27 12:25:00', 2, 1),
(94, 5, 18, '', '2017-12-27 12:25:00', 2, 1),
(95, 5, 19, '', '2017-12-27 12:25:00', 2, 1),
(96, 4, 1, 'address1', '2017-12-27 12:25:31', 2, 1),
(97, 4, 2, 'asds', '2017-12-27 12:25:31', 2, 1),
(98, 4, 3, 'df', '2017-12-27 12:25:31', 2, 1),
(99, 4, 4, 'dsf', '2017-12-27 12:25:31', 2, 1),
(100, 4, 5, 'dsf', '2017-12-27 12:25:31', 2, 1),
(101, 4, 6, 'dffd', '2017-12-27 12:25:31', 2, 1),
(102, 4, 7, 'dsf', '2017-12-27 12:25:31', 2, 1),
(103, 4, 8, 'dsf', '2017-12-27 12:25:31', 2, 1),
(104, 4, 9, 'dsf', '2017-12-27 12:25:31', 2, 1),
(105, 4, 10, 'dfd', '2017-12-27 12:25:31', 2, 1),
(106, 4, 11, '10000', '2017-12-27 12:25:31', 2, 1),
(107, 4, 12, '100', '2017-12-27 12:25:31', 2, 1),
(108, 4, 13, '', '2017-12-27 12:25:31', 2, 1),
(109, 4, 14, '', '2017-12-27 12:25:31', 2, 1),
(110, 4, 15, '5', '2017-12-27 12:25:31', 2, 1),
(111, 4, 16, '100', '2017-12-27 12:25:31', 2, 1),
(112, 4, 17, '100', '2017-12-27 12:25:31', 2, 1),
(113, 4, 18, '', '2017-12-27 12:25:31', 2, 1),
(114, 4, 19, '', '2017-12-27 12:25:31', 2, 1),
(153, 8, 1, 'dfdsf', '2017-12-27 12:30:45', 2, 1),
(154, 8, 2, 'fsdsf', '2017-12-27 12:30:45', 2, 1),
(155, 8, 3, 'sdf', '2017-12-27 12:30:45', 2, 1),
(156, 8, 4, 'dsfds', '2017-12-27 12:30:45', 2, 1),
(157, 8, 5, '', '2017-12-27 12:30:45', 2, 1),
(158, 8, 6, 'dsfds', '2017-12-27 12:30:45', 2, 1),
(159, 8, 7, 'dsf', '2017-12-27 12:30:45', 2, 1),
(160, 8, 8, 'dsf', '2017-12-27 12:30:45', 2, 1),
(161, 8, 9, 'dsf', '2017-12-27 12:30:45', 2, 1),
(162, 8, 10, 'sdfdsf', '2017-12-27 12:30:45', 2, 1),
(163, 8, 11, '10000', '2017-12-27 12:30:45', 2, 1),
(164, 8, 12, '100', '2017-12-27 12:30:45', 2, 1),
(165, 8, 13, '', '2017-12-27 12:30:45', 2, 1),
(166, 8, 14, '', '2017-12-27 12:30:45', 2, 1),
(167, 8, 15, '100', '2017-12-27 12:30:45', 2, 1),
(168, 8, 16, '100', '2017-12-27 12:30:45', 2, 1),
(169, 8, 17, '', '2017-12-27 12:30:45', 2, 1),
(170, 8, 18, '', '2017-12-27 12:30:45', 2, 1),
(171, 8, 19, '', '2017-12-27 12:30:45', 2, 1),
(191, 9, 1, 'address1', '2018-01-01 05:24:14', 2, 1),
(192, 9, 2, 'asds', '2018-01-01 05:24:14', 2, 1),
(193, 9, 3, 'df', '2018-01-01 05:24:14', 2, 1),
(194, 9, 4, 'dsf', '2018-01-01 05:24:14', 2, 1),
(195, 9, 5, 'dsf', '2018-01-01 05:24:14', 2, 1),
(196, 9, 6, 'dffd', '2018-01-01 05:24:14', 2, 1),
(197, 9, 7, 'dsf', '2018-01-01 05:24:14', 2, 1),
(198, 9, 8, 'dsf', '2018-01-01 05:24:14', 2, 1),
(199, 9, 9, 'dsf', '2018-01-01 05:24:14', 2, 1),
(200, 9, 10, 'dfd', '2018-01-01 05:24:14', 2, 1),
(201, 9, 11, '10000', '2018-01-01 05:24:14', 2, 1),
(202, 9, 12, '100', '2018-01-01 05:24:14', 2, 1),
(203, 9, 13, '', '2018-01-01 05:24:14', 2, 1),
(204, 9, 14, '', '2018-01-01 05:24:14', 2, 1),
(205, 9, 15, '100', '2018-01-01 05:24:14', 2, 1),
(206, 9, 16, '100', '2018-01-01 05:24:14', 2, 1),
(207, 9, 17, '100', '2018-01-01 05:24:14', 2, 1),
(208, 9, 18, '', '2018-01-01 05:24:14', 2, 1),
(209, 9, 19, '', '2018-01-01 05:24:14', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_template`
--

CREATE TABLE IF NOT EXISTS `tbl_payroll_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `column_nm` varchar(255) DEFAULT NULL,
  `direction` varchar(255) NOT NULL,
  `add_date` varchar(255) DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_payroll_template`
--

INSERT INTO `tbl_payroll_template` (`id`, `column_nm`, `direction`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Address (1)', 'left', '2017-12-20 16:57:15', 2, 1),
(2, 'Address (2)', 'left', '2017-12-20 16:57:22', 2, 1),
(3, 'City', 'left', '2017-12-20 16:57:30', 2, 1),
(4, 'Zip Code', 'left', '2017-12-20 16:57:39', 2, 1),
(5, 'State', 'left', '2017-12-20 16:57:47', 2, 1),
(6, 'SSN / Tax ID', 'left', '2017-12-20 16:58:01', 2, 1),
(7, 'Pay Period', 'right', '2017-12-20 16:58:57', 2, 1),
(8, 'Marital Status', 'right', '2017-12-20 16:59:05', 2, 1),
(9, 'SSN / Tax ID', 'right', '2017-12-20 16:59:13', 2, 1),
(10, 'Allowances / Extra', 'right', '2017-12-20 16:59:48', 2, 1),
(11, 'Salary / Wages', 'addition', '2017-12-20 17:01:06', 2, 1),
(12, 'Holiday Hours', 'addition', '2017-12-20 17:01:14', 2, 1),
(13, 'Overtime', 'addition', '2017-12-20 17:01:23', 2, 1),
(14, 'Vacation Hours', 'addition', '2017-12-20 17:01:33', 2, 1),
(15, 'Social Security Tax', 'deduction', '2017-12-20 17:01:48', 2, 1),
(16, 'State Tax', 'deduction', '2017-12-20 17:01:56', 2, 1),
(17, 'Federal Tax', 'deduction', '2017-12-20 17:02:05', 2, 1),
(18, 'Medicare Employee Addl Tax', 'deduction', '2017-12-20 17:02:14', 2, 1),
(19, 'State Withholding', 'deduction', '2017-12-20 17:02:23', 2, 1);

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
  `vendor_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `measurement_type_id` int(11) DEFAULT NULL,
  `measurement_id` int(11) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `purchase_price` float(10,2) DEFAULT NULL,
  `sales_price` float(10,2) NOT NULL,
  `description` text,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `classification` varchar(255) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `product_type_id` (`product_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `product_type_id`, `product_name`, `code`, `vendor_id`, `brand_id`, `measurement_type_id`, `measurement_id`, `quantity`, `purchase_price`, `sales_price`, `description`, `notes`, `photo_path`, `classification`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, 'Dulux Paints ', 'DP0054 ', 0, 1, 5, 15, '10', 8.00, 11.50, '<p></p><p>Dulux Weatherguard Decraflex is a premium quality, 100% acrylic, high-coverage paint that provides long-lasting protection against the elements. Its waterproof, breathable finish resists water intrusion and allows moisture to escape, avoiding blistering. This elastomeric coating helps to fill and seal surfaces, protecting against future cracking.&nbsp;</p><div><br></div><p></p>', '', '20171124143826_5a17e18ad54ba_Dulux-decraflex.png', 'Perishable', '2017-11-24 14:22:56', 2, 1),
(2, 3, 7, 'Distressed Wood', 'ILD1001B', 0, 1, NULL, 0, '1', 8.50, 13.95, '<p>Top of the line Interior Laminated Flooring</p>', '', '', '', '2017-11-24 21:36:38', 12, 1),
(3, 3, 7, 'Hand-scraped Wood', 'ILH1002B', 0, 1, NULL, 0, '1', 8.75, 14.50, '<p>Top of the Line Hand-scraped Wood</p>', '', '', '', '2017-11-24 21:41:07', 12, 1),
(4, 3, 7, 'Traditional Wood', 'ILT1003B', 0, 1, NULL, 0, '1', 9.00, 15.75, '<p>Top of the Line Traditional Wood</p>', '', '', '', '2017-11-24 21:42:58', 12, 1),
(5, 3, 7, 'Specialty Wood', 'ILS1004B', 0, 1, NULL, 0, '1', 9.25, 16.00, '<p>Top of the Line Traditional Laminated Wood</p>', '', '', '', '2017-11-24 21:44:27', 12, 1),
(6, 3, 7, 'Stones and Natural', 'ILN1005B', 0, 1, NULL, 0, '1', 9.50, 17.95, '<p>Top of the Line Stones and Natural Laminated Wood</p>', '', '', '', '2017-11-24 21:45:48', 12, 1),
(7, 1, 1, 'Exterior Gloss Supreme', '10001', 3, 2, 0, 0, '493', 6.00, 9.00, '<p>Sherwin Williams Exterior Gloss Supreme<br></p>', '<p>Best Exterior Paint<br></p>', '', 'Perishable', '2017-12-07 12:19:17', 2, 1),
(8, 5, 8, 'Explorer', 'V-EX1001', 0, 1, NULL, 0, '1', 25000.00, 36000.00, '<p>Ford Explorer PFS Interceptor<br></p>', '', '20171214060234_5a31c6a2891c9_Ford-Police_Interceptor_Utility-2016-hd.jpg', '', '2017-12-14 06:02:34', 18, 1),
(9, 5, 9, 'Taurus', 'V-TR1002', 0, 1, NULL, 0, '1', 19000.00, 32000.00, '<p>Ford Taurus PFS Interceptor Police Cruiser<br></p>', '', '20171214060400_5a31c6f8ceb2c_Webp.net-resizeimage (1).png', '', '2017-12-14 06:04:00', 18, 1),
(10, 5, 10, 'PFS Motorcycle', 'V-HDM1003', 0, 1, NULL, 0, '1', 14000.00, 23500.00, '<p>Harley Davidson PFS Interceptor Motorcycle<br></p>', '', '20171214060747_5a31c7dbe24ea_Harley Davidson PFS Interceptor Motorcycle.jpg', '', '2017-12-14 06:07:47', 18, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(8, 5, 'SUV', '2017-12-14 05:54:01', 18, 1),
(9, 5, 'Cruiser', '2017-12-14 05:54:13', 18, 1),
(10, 5, 'Motorcycle', '2017-12-14 06:00:22', 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE IF NOT EXISTS `tbl_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_manager_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `estimate_id`, `customer_id`, `project_manager_id`, `project_name`, `start_date`, `end_date`, `project_description`, `notes`, `project_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 2, 5, 8, 'Project 1', '2017-11-24', '2017-11-30', '', '', 1, '2017-11-24 17:59:57', 2, 1),
(2, 4, 13, 14, 'Conquest Flooring', '2017-11-27', '2017-12-21', '', '', 1, '2017-11-25 01:01:02', 12, 1),
(3, 3, 4, 8, 'newp', '2017-12-13', '2017-12-27', '<p>new p</p>', '<p>notess</p>', 1, '2017-12-12 16:56:46', 2, 1),
(5, 11, 5, 8, 'J_project', '2017-12-15', '2018-01-05', '<p>description1â€ƒ</p>', '<p>note1</p>', 1, '2017-12-15 10:39:12', 2, 1),
(6, 12, 5, 8, 'project_12', '2017-12-15', '2018-01-01', '<p>description12</p>', '<p>note12</p>', 0, '2017-12-15 15:15:03', 2, 1),
(14, 13, 5, 0, '', NULL, NULL, '', '', 0, '2017-12-16 12:35:40', 2, 1),
(15, 14, 5, 8, 'project_new', '2017-12-18', '2018-01-05', '<p>description1</p>', '<p>note1</p><p><br></p>', 0, '2017-12-18 15:04:01', 2, 1),
(16, 15, 5, 8, 'project15', '2017-12-18', '2018-01-06', '', '', 0, '2017-12-18 18:49:40', 2, 1),
(17, 18, 4, 8, 'asd', '2018-01-02', '2018-01-09', '<p>asd</p>', '<p>asd</p>', 0, '2018-01-01 10:44:43', 2, 1),
(18, 19, 4, 8, 'Project Demo', '2018-01-17', '2018-01-24', '<p>DDD</p>', '<p>S</p>', 0, '2018-01-02 17:00:42', 2, 1),
(19, 20, 17, 8, 'PD', '2018-01-03', '2018-01-12', '<p>PD 1 Description</p>', '', 0, '2018-01-02 17:59:29', 2, 1),
(20, 21, 17, 8, 'P21', '2018-01-05', '2018-01-07', '<p>P21</p>', '', 0, '2018-01-05 13:25:18', 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_salary_setup`
--

INSERT INTO `tbl_salary_setup` (`id`, `employee_id`, `salary_duration`, `add_date`, `add_uid`, `status`) VALUES
(1, 8, 'Weekly', '2017-12-02 11:48:17', 2, 1),
(3, 7, 'Weekly', '2017-12-04 14:07:51', 2, 1),
(4, 15, 'Weekly', '2017-12-05 18:43:06', 12, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tbl_salary_setup_amount`
--

INSERT INTO `tbl_salary_setup_amount` (`id`, `salary_setup_id`, `type_id`, `amount_add_deduct`, `amount`, `add_date`, `add_uid`, `status`) VALUES
(13, 1, 1, 1, 500.00, '2017-12-04 11:50:12', 2, 1),
(14, 1, 2, 1, 0.00, '2017-12-04 11:50:12', 2, 1),
(15, 1, 3, 0, 300.00, '2017-12-04 11:50:12', 2, 1),
(22, 3, 1, 1, 22.00, '2017-12-04 14:07:51', 2, 1),
(23, 3, 3, 0, 1.00, '2017-12-04 14:07:51', 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_salary_type`
--

INSERT INTO `tbl_salary_type` (`id`, `salary_name`, `salary_type`, `default_amount`, `add_date`, `add_uid`, `status`) VALUES
(1, 'Extra Hour', 1, 1000.00, '2017-12-01 18:36:19', 2, 1),
(3, 'Bima', 0, 50.00, '2017-12-01 18:37:12', 2, 1),
(4, 'House Rent', 1, 300.00, '2017-12-06 11:09:53', 11, 1),
(5, 'PF', 0, 100.00, '2017-12-06 11:11:13', 11, 1),
(6, 'Wages', 1, 0.00, '2017-12-22 20:27:34', 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
(7, 7, 6, 'Master Craftsman', 'MI001', 26.00, 190.00, 'Senior', '<p>Master Flooring Installer is a Master Craftsman of his trade.</p>', '', '2017-11-24 23:55:48', 12, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

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
(14, 'Administrative Assistant', '2017-11-24 20:38:17', 12, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(10, 12, 'Manage Customer Relations', '2017-11-24 21:04:24', 12, 1);

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
(1, 'company_name', 'ABC Painting Co. ', 'General'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`id`, `project_id`, `milestone_id`, `task_name`, `start_date`, `end_date`, `task_status`, `notes`, `attachment`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 1, 'Task 1', '2017-11-22', '2017-11-29', '1', '', '20171128163822_5a1d43a60a7f1_2_task.pdf', '2017-11-28 16:38:22', 8, 1),
(2, 1, 2, 'my login', '2017-12-07', '2017-12-08', '0', '', '', '2017-12-06 19:39:16', 8, 1),
(3, 3, 0, 'first task', '2017-12-13', '2017-12-13', '1', '', '', '2017-12-12 16:58:36', 8, 1),
(6, 3, 0, 'second task', '2017-12-20', '2017-12-21', '0', '', '', '2017-12-12 17:00:06', 8, 1),
(7, 3, 0, '3rd task', '2017-12-14', '2017-12-28', '0', '', '', '2017-12-12 17:01:24', 8, 1),
(8, 3, 0, '4th task', '2017-12-15', '2017-12-27', '0', '', '20171213104752_5a30b800ed31c_destination_homepage.jpg', '2017-12-12 17:02:23', 8, 1),
(13, 0, 3, 'task1', '2017-12-19', '2017-12-22', '0', '', '', '2017-12-18 15:07:21', 8, 1),
(14, 15, 0, 'task_new1', '2017-12-19', '2017-12-22', '1', '', '', '2017-12-18 15:08:57', 8, 1),
(15, 15, 0, 'task_new2', '2017-12-27', '2017-12-31', '1', '', '', '2017-12-18 15:10:00', 8, 1),
(16, 16, 0, 'task15_1_1', '2017-12-18', '2017-12-22', '1', '', '', '2017-12-18 18:51:44', 8, 1),
(17, 16, 0, 'task15_2', '2017-12-27', '2017-12-30', '1', '', '', '2017-12-18 18:52:41', 8, 1),
(18, 17, 0, 'asd 1 2 3', '2018-01-04', '2018-01-19', '1', '<p>adads&nbsp;</p>', '', '2018-01-01 10:46:51', 8, 1),
(19, 18, 0, 'Tast Demo 1', '2018-01-05', '2018-01-06', '1', '<p>q</p>', '', '2018-01-02 17:09:08', 8, 1),
(20, 18, 0, 'Task Demo 2', '2018-01-07', '2018-01-07', '1', '', '', '2018-01-02 17:10:22', 8, 1),
(21, 19, 0, 'T1', '2018-01-03', '2018-01-03', '1', '', '', '2018-01-02 18:00:24', 8, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `tbl_task_assign`
--

INSERT INTO `tbl_task_assign` (`id`, `task_id`, `assigned_to`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 7, '2017-11-28 16:38:22', 8, 1),
(2, 2, 7, '2017-12-06 19:39:16', 8, 1),
(3, 3, 7, '2017-12-12 16:58:36', 8, 1),
(6, 6, 7, '2017-12-12 17:00:06', 8, 1),
(14, 7, 15, '2017-12-13 10:48:49', 8, 1),
(13, 8, 7, '2017-12-13 10:48:35', 8, 1),
(15, 13, 7, '2017-12-18 15:07:21', 8, 1),
(16, 14, 9, '2017-12-18 15:08:57', 8, 1),
(17, 15, 9, '2017-12-18 15:10:00', 8, 1),
(18, 17, 9, '2017-12-18 18:52:41', 8, 1),
(34, 18, 9, '2018-01-01 16:50:52', 2, 1),
(33, 18, 7, '2018-01-01 16:50:52', 2, 1),
(32, 18, 6, '2018-01-01 16:50:52', 2, 1),
(35, 19, 7, '2018-01-02 17:09:08', 8, 1),
(36, 20, 15, '2018-01-02 17:10:22', 8, 1),
(38, 21, 15, '2018-01-02 18:00:48', 8, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `tbl_task_product`
--

INSERT INTO `tbl_task_product` (`id`, `task_id`, `type`, `category_id`, `category_type_id`, `product_id`, `qty`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Product', 1, 1, 1, '15', '2017-11-28 16:38:22', 8, 1),
(2, 1, 'Service', 2, 3, 1, '2', '2017-11-28 16:38:22', 8, 1),
(3, 2, '', 0, 0, 0, '', '2017-12-06 19:39:16', 8, 1),
(4, 3, '', 0, 0, 0, '', '2017-12-12 16:58:36', 8, 1),
(7, 6, '', 0, 0, 0, '', '2017-12-12 17:00:06', 8, 1),
(14, 7, '', 0, 0, 0, '', '2017-12-13 10:48:49', 8, 1),
(13, 8, 'Product', 1, 1, 1, '1', '2017-12-13 10:48:35', 8, 1),
(19, 13, 'Product', 1, 1, 1, '1', '2017-12-18 15:07:21', 8, 1),
(20, 13, 'Product', 1, 1, 7, '2', '2017-12-18 15:07:21', 8, 1),
(21, 14, 'Product', 1, 1, 1, '1', '2017-12-18 15:08:57', 8, 1),
(22, 14, 'Product', 1, 1, 7, '2', '2017-12-18 15:08:57', 8, 1),
(23, 15, 'Service', 2, 3, 1, '3', '2017-12-18 15:10:00', 8, 1),
(48, 16, 'Product', 1, 1, 7, '22', '2018-01-01 16:54:39', 2, 1),
(47, 16, 'Product', 1, 1, 1, '1', '2018-01-01 16:54:39', 2, 1),
(26, 17, 'Service', 2, 3, 1, '2', '2017-12-18 18:52:41', 8, 1),
(27, 17, 'Product', 1, 1, 1, '3', '2017-12-18 18:52:41', 8, 1),
(45, 18, 'Service', 2, 3, 1, '332222', '2018-01-01 16:50:52', 2, 1),
(44, 18, 'Product', 1, 1, 1, '222', '2018-01-01 16:50:52', 2, 1),
(46, 18, 'Product', 1, 1, 7, '1', '2018-01-01 16:50:52', 2, 1),
(49, 19, 'Product', 1, 1, 1, '3', '2018-01-02 17:09:08', 8, 1),
(50, 19, 'Service', 2, 3, 1, '6', '2018-01-02 17:09:08', 8, 1),
(51, 20, 'Service', 2, 3, 1, '7', '2018-01-02 17:10:22', 8, 1),
(55, 21, 'Service', 2, 3, 1, '3', '2018-01-02 18:00:48', 8, 1),
(54, 21, 'Product', 1, 1, 7, '2', '2018-01-02 18:00:48', 8, 1);

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
(3, 'SC State Sales Tax', 6.00, '<p>This is the base State Sales Tax of the State of South Carolina. Some Counties include additional taxes in the Sales Tax, which increases the amount of total tax for purchases.<br></p>', '2017-12-14 05:33:31', 18, 1),
(4, 'SC State Sales Tax', 6.00, '', '2017-12-27 18:08:12', 2, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `tax_id_no` varchar(200) DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL COMMENT '0=SuperAdmin, 1=Admin, 2=Customer, 3=Project Manager, 4=Employee',
  `user_status` int(11) DEFAULT '1' COMMENT '0=Approve, 1=Pending, 2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `address`, `notes`, `gender`, `user_image`, `tax_id_no`, `emp_id`, `user_type`, `user_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 'John', 'Slater', '804-272-3151', 'superadmin@gmail.com', 'superadmin', '1276 Coulter Lane\r\nRichmond, VA 23235', NULL, 'Male', NULL, '', '', 0, 0, '2017-11-24 09:31:15', 1, 1),
(2, 'Joel', 'Mueller', '231-344-2284', 'admin@gmail.com', 'admin', '<p>4697 Wetzel Lane<br>Grand Rapids, MI 49508<br></p>', '', NULL, NULL, '', '', 1, 0, '2017-11-24 10:52:26', 1, 1),
(4, 'Ellis', 'Forsyth', '312-345-6865', 'customer@gmail.com', 'customer', '<p>2078 Pringle Drive<br>Chicago, IL 60606</p>', '', NULL, 'ellis.jpg', 'SSN879', '', 2, 0, '2017-11-24 12:03:14', 2, 1),
(5, 'Jennifer', 'Collins', '814-542-6264', 'customer1@gmail.com', 'customer1', '<p>2620 Harley Brook Lane<br>Mount Union, PA 17066<br></p>', '', NULL, 'jennifer.png', '', '', 2, 0, '2017-11-24 12:05:59', 2, 1),
(6, 'John', 'Donnell', '218-535-3542', 'employee@gmail.com', 'employee', '<p>1501 Terra Cotta Street<br>Wadena, MN 56482<br></p>', '', NULL, '20171124171849_5a18072133cf0_emp.jpg', '', 'EMP001', 4, 0, '2017-11-24 17:18:49', 2, 1),
(7, 'Denise', 'Demaio', '660-278-2920', 'employee1@gmail.com', 'employee1', '<p>379 Fairmont Avenue<br>Steffenville, MO 63470<br></p>', '', NULL, '20171124172107_5a1807abb9c25_stock-photo-beautiful-young-female-employee-portrait-329243798.jpg', '', 'EMP002', 4, 0, '2017-11-24 17:21:07', 2, 1),
(8, 'Kathy', 'Wilson', '856-898-3693', 'projectmanager@gmail.com', 'projectmanager', '<p>1195 Valley Street<br>Camden, NJ 08102<br></p>', '', NULL, '20171124172303_5a18081f835b7_employee-glass.jpg', '', 'PJEMP001', 3, 0, '2017-11-24 17:23:03', 2, 1),
(9, 'James', 'McIntosh', '509-687-7465', 'employee2@gmail.com', 'employee2', '<p>1292 Calico Drive<br>Manson, WA 98831<br></p>', '', NULL, '20171124172916_5a180994b70eb_happy-young-businessman-9138670.jpg', '', 'EMP003', 4, 0, '2017-11-24 17:29:16', 2, 1),
(10, 'Damon', 'Black', ' 724-580-9388', 'admin1@gmail.com', 'admin1', '<p>1476 Shinn Avenue<br>Pittsburgh, PA 15212<br></p>', '', NULL, NULL, '', '', 1, 0, '2017-11-24 18:12:23', 1, 1),
(11, 'John', 'Slater', '+18433381105', 'jslater@unilyze.com', 'Coolcast1', '<p>25 Gum Tree Road</p><p>Hilton Head Island</p><p>29926 South Carolina</p>', '', NULL, NULL, '', '', 1, 0, '2017-11-24 19:42:30', 1, 1),
(12, 'Wosvaldo', 'Servin', '+18433381105', 'wosvaldo@unibyz.com', 'Wosvaldo01', '<p>18 Gideon Way</p><p>Bluffton</p><p>29910 South Carolina</p>', '', NULL, NULL, '', '', 1, 0, '2017-11-24 19:55:28', 1, 1),
(13, 'Javier', 'Restrepo', '+18433427664', 'jr@conquestins.com', 'Javier01', '<p>435 William Hilton Parkway</p><p>Hilton Head Island</p><p>29926 South Carolina</p>', '', NULL, '', '', '', 2, 0, '2017-11-24 20:15:24', 12, 1),
(14, 'Juan', 'Santillana', '+18436830929', 'juan@unibyz.com', 'Juan01', '<p>25 Bluffton Parkway</p><p>Bluffton</p><p>29910 South Carolina</p>', '', NULL, '', '222-444-9999', 'PJEMP002', 3, 0, '2017-11-24 23:58:47', 12, 1),
(15, 'Maria', 'Pardo', '+8437152099', 'maria@unibyz.com', 'Maria01', '<p>65 Beaufort Parkway</p><p>Beaufort</p><p>29843 South Carolina</p>', '', NULL, '', '333-111-6666', 'EMP004', 4, 0, '2017-11-25 00:00:16', 12, 1),
(16, 'Carlos', 'Lopez', '+18434229013', 'koalabagscol@gmail.com', 'Carlos01', '<p>7 Lakeside Drive</p><p>Bluffton</p><p>29910 South Carolina<br></p>', '', NULL, NULL, '', '', 1, 0, '2017-12-01 09:57:10', 1, 1),
(17, 'jack', 'patel', '9979999985', 'jack@gmail.com', 'iwant$100', '<p>jack address</p>', '<p>jack notes<br></p>', NULL, '', '12345', '', 2, 1, '2017-12-07 12:22:53', 2, 1),
(18, 'William', 'Danzell', '8432903423', 'jslater@pfsinterceptor.org', 'Coolcast1', '<p>19 Salt Wind Way</p><p>Hilton Head Island</p><p>29926 South Carolina<br></p>', '', NULL, NULL, '', '', 1, 0, '2017-12-14 05:26:55', 1, 1),
(19, 'Mark', 'Vogel', '+17173685143', 'mark@vogelmarketing.net', 'Vogel212$mark', '<p>255 Butler Avenue</p><p>Suite 201B</p><p>Lancaster</p><p>17601 Pennsylvania<br></p>', '', NULL, NULL, NULL, NULL, 1, 0, '2017-12-28 00:53:51', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `notes` text,
  `gender` varchar(200) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `tax_id_no` varchar(200) NOT NULL,
  `user_status` int(11) DEFAULT '1' COMMENT '0=Approve, 1=Pending, 2=Reject',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_vendor`
--

INSERT INTO `tbl_vendor` (`id`, `first_name`, `last_name`, `phone`, `email`, `address`, `notes`, `gender`, `user_image`, `tax_id_no`, `user_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 'jalpa', 'buha', '5632569856', 'jalpa@gmail.com', '<p>sdfdsf</p>', '<p>dsfdsf</p>', NULL, 'honeymoon-slide-5.jpg', 'sfds', 1, '2017-12-15 16:08:36', 2, 1),
(3, 'vendor1', '', '9856325698', 'vendor1@gmail.com', '', '', NULL, '', '', 1, '2017-12-15 16:13:27', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_order`
--

CREATE TABLE IF NOT EXISTS `tbl_work_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `category_type` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `work_order_name` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `comments` text,
  `expected_fix_date` varchar(255) DEFAULT NULL,
  `notes` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL COMMENT 'That Is UserID And It Is Employee/ProjectManager',
  `send_sms` varchar(100) DEFAULT NULL,
  `send_email` varchar(100) DEFAULT NULL,
  `work_order_status` int(11) NOT NULL DEFAULT '0' COMMENT 'By Default 0, When Invoice Generate Then Status = 1',
  `add_date` datetime DEFAULT NULL,
  `add_uid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_work_order`
--

INSERT INTO `tbl_work_order` (`id`, `project_id`, `category_type`, `category_id`, `customer_id`, `work_order_name`, `employee_name`, `start_date`, `comments`, `expected_fix_date`, `notes`, `photo_path`, `resource_id`, `send_sms`, `send_email`, `work_order_status`, `add_date`, `add_uid`, `status`) VALUES
(1, 1, 'Product', 1, 5, 'goods and serv', 'xyz', '10001', '<p>problem not found<br></p>', '2017-12-14', '<p>notes ...<br></p>', '', 7, 'No', 'No', 1, '2017-12-07 12:56:01', 2, 1),
(2, 3, 'Product', 1, 5, 'wrork555', 'model1', 's12', '<p>proble,12â€ƒ</p>', '2017-12-15', '', '', 7, 'No', 'No', 0, '2017-12-14 17:15:19', 2, 1),
(4, 5, 'Product', 1, 5, 'J_order1', 'J_model_1', 'Ser123', '<p>Problem1â€ƒ</p>', '2018-01-03', '<p>Problem2</p>', '', 1, 'No', 'No', 1, '2017-12-15 10:55:52', 2, 1),
(5, 6, 'Product', 1, 5, 'Ordet_12', 'model_12', '12', '<p>problem12</p>', '2017-12-28', '<p>note12</p>', '', 1, 'No', 'No', 1, '2017-12-15 15:16:16', 2, 1),
(10, 14, '', 0, 5, 'sss', '', '', '', '', '', '', 0, '', '', 1, '2017-12-16 12:35:58', 2, 1),
(11, 15, 'Product', 1, 5, 'new_order', 'model1', '', '', '2018-01-04', '', '', 1, 'No', 'No', 0, '2017-12-18 15:04:45', 2, 1),
(14, 16, 'Product', 1, 5, 'order15', '', '', '', '', '', '', 0, '', '', 0, '2017-12-18 18:50:13', 2, 1),
(15, 17, 'Product', 1, 4, 'qwe', 'qwe', 'asd', '<p>asd</p>', '2018-01-11', '<p>qwe</p>', '', 1, 'Yes', 'No', 0, '2018-01-01 10:45:25', 2, 1),
(16, 18, 'Product', 1, 4, 'Order Demo', 'DFG', 'SN1273', '<p>SSWRRS</p>', '2018-01-31', '', '', 1, 'Yes', 'Yes', 0, '2018-01-02 17:01:40', 2, 1),
(17, 19, 'Product', 2, 17, 'OD1', 'MD', 'SN12', '<p>qqq</p>', '2018-01-10', '<p>ee</p>', '', 1, 'Yes', 'No', 0, '2018-01-02 18:01:52', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
