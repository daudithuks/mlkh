-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2012 at 04:33 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ospos`
--
CREATE DATABASE `ospos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ospos`;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_app_config`
--

CREATE TABLE IF NOT EXISTS `ospos_app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_app_config`
--

INSERT INTO `ospos_app_config` (`key`, `value`) VALUES
('address', 'Nairobi'),
('company', 'Mama Lucy Kibaki Hospital'),
('currency_symbol', 'KES'),
('default_tax_1_name', '0'),
('default_tax_1_rate', '0'),
('default_tax_2_name', '0'),
('default_tax_2_rate', '0'),
('default_tax_rate', '8'),
('email', ''),
('fax', ''),
('language', 'english'),
('phone', ''),
('print_after_sale', '0'),
('return_policy', '0'),
('timezone', 'Africa/Nairobi'),
('website', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_customers`
--

CREATE TABLE IF NOT EXISTS `ospos_customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_customers`
--

INSERT INTO `ospos_customers` (`person_id`, `account_number`, `taxable`, `deleted`) VALUES
(2, NULL, 1, 0),
(4, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_employees`
--

CREATE TABLE IF NOT EXISTS `ospos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_employees`
--

INSERT INTO `ospos_employees` (`username`, `password`, `person_id`, `deleted`) VALUES
('admin', '439a6de57d475c1a0ba9bcb1c39f0af6', 1, 0),
('dee_ene_gee', '0f8fb86b066a1592a0417ba9f966bdf0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_giftcards`
--

CREATE TABLE IF NOT EXISTS `ospos_giftcards` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `value` double(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ospos_giftcards`
--

INSERT INTO `ospos_giftcards` (`giftcard_id`, `giftcard_number`, `value`, `deleted`) VALUES
(1, '1234', 1200.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_inventory`
--

CREATE TABLE IF NOT EXISTS `ospos_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_inventory` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`),
  KEY `ospos_inventory_ibfk_1` (`trans_items`),
  KEY `ospos_inventory_ibfk_2` (`trans_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `ospos_inventory`
--

INSERT INTO `ospos_inventory` (`trans_id`, `trans_items`, `trans_user`, `trans_date`, `trans_comment`, `trans_inventory`) VALUES
(1, 548, 1, '2012-09-09 13:29:39', 'Manual Edit of Quantity', 10),
(2, 549, 1, '2012-09-09 13:29:41', 'Manual Edit of Quantity', 10),
(3, 550, 1, '2012-09-09 13:29:52', 'Manual Edit of Quantity', 10),
(4, 551, 1, '2012-09-09 13:29:54', 'Manual Edit of Quantity', 10),
(5, 552, 1, '2012-09-09 13:30:04', 'Manual Edit of Quantity', 10),
(6, 553, 1, '2012-09-09 13:30:26', 'Manual Edit of Quantity', 10),
(7, 555, 1, '2012-09-09 13:37:36', 'Manual Edit of Quantity', 0),
(8, 77, 1, '2012-09-09 14:12:17', 'POS 1', -1),
(9, 79, 1, '2012-09-09 14:12:17', 'POS 1', -1),
(10, 70, 1, '2012-09-09 14:17:31', 'POS 2', -1),
(11, 77, 1, '2012-09-09 14:17:31', 'POS 2', -1),
(12, 79, 1, '2012-09-09 14:17:31', 'POS 2', -1),
(13, 77, 1, '2012-09-09 14:20:49', 'POS 3', -1),
(14, 79, 1, '2012-09-09 14:20:49', 'POS 3', -1),
(15, 556, 1, '2012-09-09 14:51:42', 'Manual Edit of Quantity', 1),
(16, 556, 1, '2012-09-09 14:51:48', 'POS 4', -1),
(17, 77, 1, '2012-09-09 17:24:09', 'POS 5', -1),
(18, 79, 1, '2012-09-09 17:24:09', 'POS 5', -1),
(19, 184, 3, '2012-09-09 18:54:14', 'POS 6', -1),
(20, 10, 3, '2012-09-09 18:54:14', 'POS 6', -1),
(21, 10, 3, '2012-09-09 19:19:19', 'POS 7', -1),
(22, 485, 1, '2012-09-23 08:01:27', 'POS 9', -1),
(23, 41, 1, '2012-09-23 08:02:04', 'POS 10', -1),
(24, 183, 1, '2012-09-23 08:02:04', 'POS 10', -1),
(25, 406, 1, '2012-09-23 08:02:04', 'POS 10', -2),
(26, 262, 1, '2012-09-23 08:03:06', 'POS 11', -1),
(27, 390, 1, '2012-09-23 08:03:06', 'POS 11', -1),
(28, 448, 1, '2012-09-23 08:40:04', 'POS 12', -1),
(29, 413, 1, '2012-09-23 13:12:02', 'POS 13', -1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_invoices`
--

CREATE TABLE IF NOT EXISTS `ospos_invoices` (
  `invoice_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `invoice_id` int(10) NOT NULL AUTO_INCREMENT,
  `amount` double DEFAULT NULL,
  `processed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ospos_invoices`
--

INSERT INTO `ospos_invoices` (`invoice_time`, `customer_id`, `employee_id`, `comment`, `invoice_id`, `amount`, `processed`) VALUES
('2012-09-23 07:38:21', 2, 1, '', 1, 3100, 1),
('2012-09-23 07:50:07', 4, 1, '', 2, 1500, 1),
('2012-09-23 08:02:46', 2, 1, '', 3, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_invoices_items`
--

CREATE TABLE IF NOT EXISTS `ospos_invoices_items` (
  `invoice_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_invoices_items`
--

INSERT INTO `ospos_invoices_items` (`invoice_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`) VALUES
(1, 41, '', '', 3, 1.00, '100.00', 100.00, 0),
(1, 183, '', '', 1, 1.00, '2000.00', 2000.00, 0),
(1, 406, '0', '', 2, 2.00, '500.00', 500.00, 0),
(2, 485, '', '', 1, 1.00, '1500.00', 1500.00, 0),
(3, 262, '', '', 1, 1.00, '200.00', 200.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kit_items`
--

CREATE TABLE IF NOT EXISTS `ospos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(15,2) NOT NULL,
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `ospos_item_kit_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_item_kit_items`
--

INSERT INTO `ospos_item_kit_items` (`item_kit_id`, `item_id`, `quantity`) VALUES
(1, 77, 1.00),
(1, 79, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kits`
--

CREATE TABLE IF NOT EXISTS `ospos_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`item_kit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ospos_item_kits`
--

INSERT INTO `ospos_item_kits` (`item_kit_id`, `name`, `description`) VALUES
(1, 'Maternity', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items`
--

CREATE TABLE IF NOT EXISTS `ospos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` double(15,2) DEFAULT NULL,
  `unit_price` double(15,2) NOT NULL,
  `quantity` double(15,2) NOT NULL DEFAULT '1.00',
  `reorder_level` double(15,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) DEFAULT NULL,
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `allow_alt_description` tinyint(1) DEFAULT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  KEY `ospos_items_ibfk_1` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=557 ;

--
-- Dumping data for table `ospos_items`
--

INSERT INTO `ospos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `quantity`, `reorder_level`, `location`, `item_id`, `allow_alt_description`, `is_serialized`, `deleted`) VALUES
('Registration', 'HS', 0, 'HS006', '', 100.00, 100.00, 999999967.00, 0.00, '', 10, 0, 1, 0),
('Ward Deposit (Pediatric)', 'HS', 0, 'PED00', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 13, 0, 0, 0),
('Ward Deposit (Adult)', 'HS', 0, 'HS001', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 14, 0, 0, 0),
('Ward Deposit (ICU)', 'HS', 0, 'ICU00', '', 50000.00, 50000.00, 1000000000.00, 0.00, '', 15, 0, 0, 0),
('Inpatient (Bed)', 'HS', 0, 'HS002', '', 300.00, 300.00, 1000000000.00, 0.00, '', 16, 0, 0, 0),
('Inpatient (File)', 'HS', 0, 'HS003', '', 300.00, 300.00, 1000000000.00, 0.00, '', 17, 0, 0, 0),
('Inpatient (Caretaker)', 'HS', 0, 'HS004', '', 300.00, 300.00, 1000000000.00, 0.00, '', 18, 0, 0, 0),
('Internship/Attachment (non-go)', 'HS', 0, 'ADMIN', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 19, 0, 0, 0),
('Surgery', 'HS', 0, 'HS005', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 20, 0, 0, 0),
('GOPC', 'HS', 0, 'CONS0', '', 300.00, 300.00, 1000000000.00, 0.00, '', 21, 0, 0, 0),
('MOPC', 'HS', 0, 'CONS002', '', 300.00, 300.00, 1000000000.00, 0.00, '', 22, 0, 0, 0),
('SOPC', 'HS', 0, 'CONS003', '', 300.00, 300.00, 1000000000.00, 0.00, '', 23, 0, 0, 0),
('DOPC', 'HS', 0, 'CONS004', '', 400.00, 400.00, 1000000000.00, 0.00, '', 24, 0, 0, 0),
('OBS/GYN High Risk', 'HS', 0, 'CONS005', '', 300.00, 300.00, 1000000000.00, 0.00, '', 25, 0, 0, 0),
('Orthopaedic Clinic', 'HS', 0, 'CONS006', '', 300.00, 300.00, 1000000000.00, 0.00, '', 26, 0, 0, 0),
('Maxillofacial', 'HS', 0, 'CONS007', '', 300.00, 300.00, 1000000000.00, 0.00, '', 27, 0, 0, 0),
('ENT', 'HS', 0, 'CONS008', '', 300.00, 300.00, 1000000000.00, 0.00, '', 28, 0, 0, 0),
('Psychiatry', 'HS', 0, 'CONS009', '', 300.00, 300.00, 1000000000.00, 0.00, '', 29, 0, 0, 0),
('Opthalmology', 'HS', 0, 'CONS010', '', 300.00, 300.00, 1000000000.00, 0.00, '', 30, 0, 0, 0),
('POPC', 'HS', 0, 'CONS011', '', 300.00, 300.00, 1000000000.00, 0.00, '', 31, 0, 0, 0),
('Counselling', 'HS', 0, 'CLINIC001', '', 100.00, 100.00, 1000000000.00, 0.00, '', 32, 0, 0, 0),
('Physiotherapy', 'HS', 0, 'CLINIC002', '', 100.00, 100.00, 1000000000.00, 0.00, '', 33, 0, 0, 0),
('Occupational Therapy', 'HS', 0, 'CLINIC003', '', 100.00, 100.00, 1000000000.00, 0.00, '', 34, 0, 0, 0),
('Plaster', 'HS', 0, 'CLINIC004', '', 100.00, 100.00, 1000000000.00, 0.00, '', 35, 0, 0, 0),
('Dental', 'HS', 0, 'CLINIC005', '', 100.00, 100.00, 1000000000.00, 0.00, '', 36, 0, 0, 0),
('Diabetic', 'HS', 0, 'CLINIC006', '', 100.00, 100.00, 1000000000.00, 0.00, '', 37, 0, 0, 0),
('Tooth Extraction', 'HS', 0, 'DEN001', '', 200.00, 200.00, 1000000000.00, 0.00, '', 38, 0, 0, 0),
('Closed Disipaction', 'HS', 0, 'DEN002', '', 500.00, 500.00, 1000000000.00, 0.00, '', 39, 0, 0, 0),
('Open Disempaction', 'HS', 0, 'DEN003', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 40, 0, 0, 0),
('Dry Socket Management', 'HS', 0, 'DEN004', '', 100.00, 100.00, 999999999.00, 0.00, '', 41, 0, 0, 0),
('Age Assessment', 'HS', 0, 'DEN005', '', 200.00, 200.00, 1000000000.00, 0.00, '', 42, 0, 0, 0),
('Excisional Biopsy Outpatient ', 'HS', 0, 'DEN006', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 43, 0, 0, 0),
('Opeculactomy', 'HS', 0, 'DEN007', '', 500.00, 500.00, 1000000000.00, 0.00, '', 44, 0, 0, 0),
('Incision and Drainage (I/D)', 'HS', 0, 'DEN008', '', 500.00, 500.00, 1000000000.00, 0.00, '', 45, 0, 0, 0),
('Dental MOS Outpatient', 'HS', 0, 'DEN009', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 46, 0, 0, 0),
('Frenectomy', 'HS', 0, 'DEN010', '', 200.00, 200.00, 1000000000.00, 0.00, '', 47, 0, 0, 0),
('Change of Dressing', 'HS', 0, 'DEN011', '', 150.00, 150.00, 1000000000.00, 0.00, '', 48, 0, 0, 0),
('Temporary Filling', 'HS', 0, 'DEN012', '', 300.00, 300.00, 1000000000.00, 0.00, '', 49, 0, 0, 0),
('Silver Filling ', 'HS', 0, 'DEN013', '', 800.00, 800.00, 1000000000.00, 0.00, '', 50, 0, 0, 0),
('Composite Filling', 'HS', 0, 'DEN014', '', 800.00, 800.00, 999999999.00, 0.00, '', 51, 0, 0, 0),
('Anterior Root Canal', 'HS', 0, 'DEN015', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 52, 0, 0, 0),
('Premolar Root Canal', 'HS', 0, 'DEN016', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 53, 0, 0, 0),
('Molar Root Canal', 'HS', 0, 'DEN017', '', 2500.00, 2500.00, 1000000000.00, 0.00, '', 54, 0, 0, 0),
('Apicectomy', 'HS', 0, 'DEN018', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 55, 0, 0, 0),
('Mental Porcelain Crown', 'HS', 0, 'DEN019', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 56, 0, 0, 0),
('Splinting (per Arc)', 'HS', 0, 'DEN020', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 57, 0, 0, 0),
('Intermaxillary Fixation (IMF)', 'HS', 0, 'DEN021', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 58, 0, 0, 0),
('Removal of IMF/Splint/Stitch', 'HS', 0, 'DEN022', '', 200.00, 200.00, 1000000000.00, 0.00, '', 59, 0, 0, 0),
('Prophylaxis Dental', 'HS', 0, 'DEN023', '', 600.00, 600.00, 1000000000.00, 0.00, '', 60, 0, 0, 0),
('Full Mouth Scaling', 'HS', 0, 'DEN024', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 61, 0, 0, 0),
('1st Tooth', 'HS', 0, 'DEN025', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 62, 0, 0, 0),
('Any Addition (Dental)', 'HS', 0, 'DEN026', '', 200.00, 200.00, 1000000000.00, 0.00, '', 63, 0, 0, 0),
('Complete Dentures', 'HS', 0, 'DEN027', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 64, 0, 0, 0),
('Single Complete Denture', 'HS', 0, 'DEN028', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 65, 0, 0, 0),
('Denture Repair', 'HS', 0, 'DEN029', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 66, 0, 0, 0),
('Braces Cron Cutting', 'HS', 0, 'DEN030', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 67, 0, 0, 0),
('Braces Orthodontic Appliances', 'HS', 0, 'DEN031', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 68, 0, 0, 0),
('Orthodontic Appliance Adjust', 'HS', 0, 'DEN032', '', 200.00, 200.00, 1000000000.00, 0.00, '', 69, 0, 0, 0),
('Urinalysis (Maternity)', 'HS', 0, 'MAT001', '', 100.00, 100.00, 999999999.00, 0.00, '', 70, 0, 0, 0),
('Episitiomy/Tear Repair', 'HS', 0, 'MAT002', '', 500.00, 500.00, 1000000000.00, 0.00, '', 71, 0, 0, 0),
('Vaginal Examination', 'HS', 0, 'MAT003', '', 100.00, 100.00, 1000000000.00, 0.00, '', 72, 0, 0, 0),
('Speculum Examination', 'HS', 0, 'MAT004', '', 200.00, 200.00, 1000000000.00, 0.00, '', 73, 0, 0, 0),
('Normal Delivery', 'HS', 0, 'MAT005', '', 3500.00, 3500.00, 1000000000.00, 0.00, '', 74, 0, 0, 0),
('Vacuum Extraction ', 'HS', 0, 'MAT006', '', 3500.00, 3500.00, 1000000000.00, 0.00, '', 75, 0, 0, 0),
('Caeserian Section', 'HS', 0, 'MAT007', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 76, 0, 0, 0),
('Maternity Bed Charges', 'HS', 0, 'MAT008', '', 250.00, 250.00, 999999996.00, 0.00, '', 77, 0, 0, 0),
('BBA (Born Before Arrival)', 'HS', 0, 'MAT009', '', 500.00, 500.00, 1000000000.00, 0.00, '', 78, 0, 0, 0),
('MVA (Maternity)', 'HS', 0, 'MAT010', '', 1500.00, 1500.00, 999999996.00, 0.00, '', 79, 0, 0, 0),
('C/S Package', 'HS', 0, 'MAT011', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 80, 0, 0, 0),
('Normal Delivery Package', 'HS', 0, 'MAT012', '', 4500.00, 4500.00, 1000000000.00, 0.00, '', 81, 0, 0, 0),
('Hysterectomy (TAH,TVA, LAVH)', 'HS', 0, 'GYNAE001', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 82, 0, 0, 0),
('Radical Hysterectomy', 'HS', 0, 'GYNAE002', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 83, 0, 0, 0),
('Tuboplasty', 'HS', 0, 'GYNAE003', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 84, 0, 0, 0),
('Myomectomy', 'HS', 0, 'GYNAE004', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 85, 0, 0, 0),
('TAH /BSO', 'HS', 0, 'GYNAE005', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 86, 0, 0, 0),
('Vulvectomy', 'HS', 0, 'GYNAE006', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 87, 0, 0, 0),
('Explorative Laparatomy', 'HS', 0, 'GYNAE007', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 88, 0, 0, 0),
('Ovarian Cystectomy', 'HS', 0, 'GYNAE008', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 89, 0, 0, 0),
('Ovarian Drilling', 'HS', 0, 'GYNAE009', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 90, 0, 0, 0),
('Colporrhapy', 'HS', 0, 'GYNAE010', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 91, 0, 0, 0),
('Perineorrhapy', 'HS', 0, 'GYNAE011', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 92, 0, 0, 0),
('VVF Repair', 'HS', 0, 'GYNAE012', '', 0.00, 0.00, 1000000000.00, 0.00, '', 93, 0, 0, 0),
('BTL under GA', 'HS', 0, 'GYNAE013', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 94, 0, 0, 0),
('Cryotherapy/LEEP/LLETZ', 'HS', 0, 'GYNAE014', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 95, 0, 0, 0),
('Dilation & Curattage', 'HS', 0, 'GYNAE015', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 96, 0, 0, 0),
('Examination Under Anasth (EUA)', 'HS', 0, 'GYNAE016', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 97, 0, 0, 0),
('MVA (Gynae)', 'HS', 0, 'GYNAE017', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 98, 0, 0, 0),
('Mursupialization', 'HS', 0, 'GYNAE018', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 99, 0, 0, 0),
('BTL under LA', 'HS', 0, 'GYNAE019', '', 500.00, 500.00, 1000000000.00, 0.00, '', 100, 0, 0, 0),
('Mac Donalds Stitch', 'HS', 0, 'GYNAE020', '', 500.00, 500.00, 1000000000.00, 0.00, '', 101, 0, 0, 0),
('Viideostrobosopy', 'HS', 0, 'ENT001', '', 500.00, 500.00, 1000000000.00, 0.00, '', 102, 0, 0, 0),
('Rigid Nasal Endosiopy', 'HS', 0, 'ENT002', '', 500.00, 500.00, 1000000000.00, 0.00, '', 103, 0, 0, 0),
('Aural Toilet', 'HS', 0, 'ENT003', '', 500.00, 500.00, 1000000000.00, 0.00, '', 104, 0, 0, 0),
('Foreign Body (Ear, Nose)', 'HS', 0, 'ENT004', '', 500.00, 500.00, 1000000000.00, 0.00, '', 105, 0, 0, 0),
('Chemical Cautery', 'HS', 0, 'ENT005', '', 500.00, 500.00, 1000000000.00, 0.00, '', 106, 0, 0, 0),
('Packaging of the Nose', 'HS', 0, 'ENT006', '', 300.00, 300.00, 1000000000.00, 0.00, '', 107, 0, 0, 0),
('Pure Tone Audiometry', 'HS', 0, 'ENT007', '', 400.00, 400.00, 1000000000.00, 0.00, '', 108, 0, 0, 0),
('Tympanometry', 'HS', 0, 'ENT008', '', 400.00, 400.00, 1000000000.00, 0.00, '', 109, 0, 0, 0),
('Punch Biopsy', 'HS', 0, 'ENT009', '', 500.00, 500.00, 1000000000.00, 0.00, '', 110, 0, 0, 0),
('Exam Under Microscope (ENT)', 'HS', 0, 'ENT010', '', 400.00, 400.00, 1000000000.00, 0.00, '', 111, 0, 0, 0),
('Ear Syringing', 'HS', 0, 'ENT011', '', 200.00, 200.00, 1000000000.00, 0.00, '', 112, 0, 0, 0),
('Functional Endoscopic Sinus Sergus', 'HS', 0, 'ENT012', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 113, 0, 0, 0),
('Superfual Parotidectomy', 'HS', 0, 'ENT013', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 114, 0, 0, 0),
('Glossectomy', 'HS', 0, 'ENT014', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 115, 0, 0, 0),
('Neck Dissecions', 'HS', 0, 'ENT015', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 116, 0, 0, 0),
('Maxillectomy', 'HS', 0, 'ENT016', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 117, 0, 0, 0),
('Total Paotidectomy', 'HS', 0, 'ENT017', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 118, 0, 0, 0),
('Tonsilectomy (Adults)', 'HS', 0, 'ENT018', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 119, 0, 0, 0),
('Turbinoplasty', 'HS', 0, 'ENT019', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 120, 0, 0, 0),
('Tymplanoplasty', 'HS', 0, 'ENT020', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 121, 0, 0, 0),
('Excision of Submalibular Gland', 'HS', 0, 'ENT021', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 122, 0, 0, 0),
('Thyroglosal Duct Cyst Excision', 'HS', 0, 'ENT022', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 123, 0, 0, 0),
('Microlaryngeal Excision of Polyp/Nodule', 'HS', 0, 'ENT023', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 124, 0, 0, 0),
('Lateralization of Vocal Chords', 'HS', 0, 'ENT024', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 125, 0, 0, 0),
('Mastoidectomy', 'HS', 0, 'ENT025', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 126, 0, 0, 0),
('Adenotonsillectomy', 'HS', 0, 'ENT026', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 127, 0, 0, 0),
('Adenotonlectomy', 'HS', 0, 'ENT027', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 128, 0, 0, 0),
('Tonsillectomy (Paed)', 'HS', 0, 'ENT028', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 129, 0, 0, 0),
('Lymph Node Biopsy', 'HS', 0, 'ENT029', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 130, 0, 0, 0),
('Bilateral Maxillary WashOut (BAVO)', 'HS', 0, 'ENT030', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 131, 0, 0, 0),
('Rigid Nasal Endoscopy & Biopsy', 'HS', 0, 'ENT031', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 132, 0, 0, 0),
('Neck Mass Surgery', 'HS', 0, 'ENT032', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 133, 0, 0, 0),
('Insertion of Grommet', 'HS', 0, 'ENT033', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 134, 0, 0, 0),
('Cervical Abscess Drainage', 'HS', 0, 'ENT034', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 135, 0, 0, 0),
('Drainage of Parotid Abscess', 'HS', 0, 'ENT035', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 136, 0, 0, 0),
('Excision of Preanular Sinus', 'HS', 0, 'ENT036', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 137, 0, 0, 0),
('Tracheosectomy', 'HS', 0, 'ENT037', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 138, 0, 0, 0),
('Refashioning of the Tracheostoma', 'HS', 0, 'ENT038', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 139, 0, 0, 0),
('Eosophegoscopy & Removal of FB', 'HS', 0, 'ENT039', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 140, 0, 0, 0),
('Removal of FB Nose/Ear Under GA', 'HS', 0, 'ENT040', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 141, 0, 0, 0),
('Skull Ap/Lateral', 'HS', 0, 'XR001', '', 550.00, 550.00, 1000000000.00, 0.00, '', 142, 0, 0, 0),
('Skull Paranosal Sinuses', 'HS', 0, 'XR002', '', 550.00, 550.00, 1000000000.00, 0.00, '', 143, 0, 0, 0),
('Skull Pituitary Fossa', 'HS', 0, 'XR003', '', 550.00, 550.00, 1000000000.00, 0.00, '', 144, 0, 0, 0),
('Skull Orbits', 'HS', 0, 'XR004', '', 550.00, 550.00, 1000000000.00, 0.00, '', 145, 0, 0, 0),
('Skull Optic Foramen', 'HS', 0, 'XR005', '', 550.00, 550.00, 1000000000.00, 0.00, '', 146, 0, 0, 0),
('Skull Occipital Mental', 'HS', 0, 'XR006', '', 550.00, 550.00, 1000000000.00, 0.00, '', 147, 0, 0, 0),
('Skull Townes View', 'HS', 0, 'XR007', '', 550.00, 550.00, 1000000000.00, 0.00, '', 148, 0, 0, 0),
('Skull Nasal Bones', 'HS', 0, 'XR008', '', 550.00, 550.00, 1000000000.00, 0.00, '', 149, 0, 0, 0),
('Skull Mastiods', 'HS', 0, 'XR009', '', 550.00, 550.00, 1000000000.00, 0.00, '', 150, 0, 0, 0),
('Temporal-Mandibular Joints A-P', 'HS', 0, 'XR010', '', 550.00, 550.00, 1000000000.00, 0.00, '', 151, 0, 0, 0),
('Temporal-Mandibular Joints Bilateral', 'HS', 0, 'XR011', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 152, 0, 0, 0),
('Mandible P-A/LAT', 'HS', 0, 'XR012', '', 550.00, 550.00, 1000000000.00, 0.00, '', 153, 0, 0, 0),
('Mandible Bilateral', 'HS', 0, 'XR01', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 154, 0, 0, 0),
('Cervical Spine Ap/Lateral/Oblique/open Mouth/Flexion', 'HS', 0, 'XR013', '', 550.00, 550.00, 1000000000.00, 0.00, '', 155, 0, 0, 0),
('Thoracic Spine AP/LAT/Thoraco-Lumbar AP/Lat', 'HS', 0, 'XR014', '', 550.00, 550.00, 1000000000.00, 0.00, '', 156, 0, 0, 0),
('Thoracic Spine Myelogram', 'HS', 0, 'XR015', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 157, 0, 0, 0),
('Lumbar Spine AP/LAT', 'HS', 0, 'XR016', '', 550.00, 550.00, 1000000000.00, 0.00, '', 158, 0, 0, 0),
('Thoraco-Lumbar AP/LAT', 'HS', 0, 'XR017', '', 550.00, 550.00, 1000000000.00, 0.00, '', 159, 0, 0, 0),
('Myelogram', 'HS', 0, 'XR018', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 160, 0, 0, 0),
('Pelvis AP', 'HS', 0, 'XR019', '', 550.00, 550.00, 1000000000.00, 0.00, '', 161, 0, 0, 0),
('Hips AP', 'HS', 0, 'XR020', '', 550.00, 550.00, 1000000000.00, 0.00, '', 162, 0, 0, 0),
('Lateral(Bilateral)', 'HS', 0, 'XR021', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 163, 0, 0, 0),
('Urethrograms Micturating/Ascending', 'HS', 0, 'XR022', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 164, 0, 0, 0),
('Femur AP/LAT', 'HS', 0, 'XR023', '', 450.00, 450.00, 1000000000.00, 0.00, '', 165, 0, 0, 0),
('Femur Bilateral', 'HS', 0, 'XR024', '', 800.00, 800.00, 1000000000.00, 0.00, '', 166, 0, 0, 0),
('Femur Venogram', 'HS', 0, 'XR025', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 167, 0, 0, 0),
('Femur Arteriogram', 'HS', 0, 'XR026', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 168, 0, 0, 0),
('Knee Joint AP/LAT/Patella/Skyline', 'HS', 0, 'XR027', '', 450.00, 450.00, 1000000000.00, 0.00, '', 169, 0, 0, 0),
('Knee Joint Bilateral', 'HS', 0, 'XR028', '', 800.00, 800.00, 1000000000.00, 0.00, '', 170, 0, 0, 0),
('Knee Joint Arterioram', 'HS', 0, 'XR029', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 171, 0, 0, 0),
('Tibia-Fibular AP/LAT', 'HS', 0, 'XR030', '', 450.00, 450.00, 1000000000.00, 0.00, '', 172, 0, 0, 0),
('Tibia-Fibular Bilateral', 'HS', 0, 'XR031', '', 900.00, 900.00, 1000000000.00, 0.00, '', 173, 0, 0, 0),
('Tibia-Fibular Arteriogram', 'HS', 0, 'XR032', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 174, 0, 0, 0),
('Tibia-Fibular Venogram', 'HS', 0, 'XR033', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 175, 0, 0, 0),
('Ankle AP/LAT', 'HS', 0, 'XR034', '', 450.00, 450.00, 1000000000.00, 0.00, '', 176, 0, 0, 0),
('Ankle Bilateral', 'HS', 0, 'XR035', '', 800.00, 800.00, 1000000000.00, 0.00, '', 177, 0, 0, 0),
('Abdomen Plain', 'HS', 0, 'XR036', '', 450.00, 450.00, 999999998.00, 0.00, '', 178, 0, 0, 0),
('Abdomen Double Contrast', 'HS', 0, 'XR037', '', 550.00, 550.00, 999999999.00, 0.00, '', 179, 0, 0, 0),
('Abdomen Erect Dorsal Decubitus', 'HS', 0, 'XR038', '', 550.00, 550.00, 1000000000.00, 0.00, '', 180, 0, 0, 0),
('Barium Swallow', 'HS', 0, 'XR039', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 181, 0, 0, 0),
('Barium Meal', 'HS', 0, 'XR040', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 182, 0, 0, 0),
('Barium Follow Through', 'HS', 0, 'XR041', '', 2000.00, 2000.00, 999999999.00, 0.00, '', 183, 0, 0, 0),
('Barium Enema', 'HS', 0, 'XR042', '', 2000.00, 2000.00, 999999999.00, 0.00, '', 184, 0, 0, 0),
('Foot Ap/Oblique/LAT', 'HS', 0, 'XR043', '', 450.00, 450.00, 1000000000.00, 0.00, '', 185, 0, 0, 0),
('Foot Bilateral', 'HS', 0, 'XR044', '', 800.00, 800.00, 1000000000.00, 0.00, '', 186, 0, 0, 0),
('Clavicle AP', 'HS', 0, 'XR045', '', 450.00, 450.00, 1000000000.00, 0.00, '', 187, 0, 0, 0),
('Clavicle Bilateral ', 'HS', 0, 'XR046', '', 800.00, 800.00, 1000000000.00, 0.00, '', 188, 0, 0, 0),
('Scapula AP/LAT', 'HS', 0, 'XR047', '', 450.00, 450.00, 1000000000.00, 0.00, '', 189, 0, 0, 0),
('Scapula Bilateral', 'HS', 0, 'XR048', '', 800.00, 800.00, 1000000000.00, 0.00, '', 190, 0, 0, 0),
('Humerus AP/LAT', 'HS', 0, 'XR049', '', 450.00, 450.00, 1000000000.00, 0.00, '', 191, 0, 0, 0),
('Humerus Bilateral', 'HS', 0, 'XR050', '', 800.00, 800.00, 1000000000.00, 0.00, '', 192, 0, 0, 0),
('Shoulder Joint AP/LAT/Axial', 'HS', 0, 'XR051', '', 450.00, 450.00, 1000000000.00, 0.00, '', 193, 0, 0, 0),
('Shoulder Joint Bilateral', 'HS', 0, 'XR052', '', 800.00, 800.00, 1000000000.00, 0.00, '', 194, 0, 0, 0),
('Elbow Joint AP/LAT', 'HS', 0, 'XR053', '', 450.00, 450.00, 1000000000.00, 0.00, '', 195, 0, 0, 0),
('Elbow Joint Bilateral', 'HS', 0, 'XR054', '', 800.00, 800.00, 1000000000.00, 0.00, '', 196, 0, 0, 0),
('Radius-Ulna AP/LAT', 'HS', 0, 'XR055', '', 450.00, 450.00, 1000000000.00, 0.00, '', 197, 0, 0, 0),
('Radius-Ulna Radio-Ulna Joint', 'HS', 0, 'XR056', '', 450.00, 450.00, 1000000000.00, 0.00, '', 198, 0, 0, 0),
('Wrist Joint AP/LAT', 'HS', 0, 'XR057', '', 450.00, 450.00, 1000000000.00, 0.00, '', 199, 0, 0, 0),
('Wrist Joint Bilateral', 'HS', 0, 'XR058', '', 800.00, 800.00, 1000000000.00, 0.00, '', 200, 0, 0, 0),
('Chest PA/AP/Oblique', 'HS', 0, 'XR059', '', 450.00, 450.00, 1000000000.00, 0.00, '', 201, 0, 0, 0),
('Chest PA & Oblique', 'HS', 0, 'XR060', '', 800.00, 800.00, 1000000000.00, 0.00, '', 202, 0, 0, 0),
('Chest Sternum AP/LAT', 'HS', 0, 'XR061', '', 450.00, 450.00, 1000000000.00, 0.00, '', 203, 0, 0, 0),
('Chest Thoracic Inlet', 'HS', 0, 'XR062', '', 450.00, 450.00, 1000000000.00, 0.00, '', 204, 0, 0, 0),
('Chest Lordotic View', 'HS', 0, 'XR063', '', 450.00, 450.00, 1000000000.00, 0.00, '', 205, 0, 0, 0),
('Hand AP/LAT/Oblique', 'HS', 0, 'XR064', '', 450.00, 450.00, 1000000000.00, 0.00, '', 206, 0, 0, 0),
('Hand Bilateral', 'HS', 0, 'XR065', '', 800.00, 800.00, 1000000000.00, 0.00, '', 207, 0, 0, 0),
('Ultra Sound Examination', 'HS', 0, 'XR066', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 208, 0, 0, 0),
('Sacrum & Coccyx AP/LAT', 'HS', 0, 'XR067', '', 550.00, 550.00, 1000000000.00, 0.00, '', 209, 0, 0, 0),
('Sacro-Illiac Joint AP/Oblique', 'HS', 0, 'XR068', '', 550.00, 550.00, 1000000000.00, 0.00, '', 210, 0, 0, 0),
('Sacro-Illiac Joint Bilateral', 'HS', 0, 'XR069', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 211, 0, 0, 0),
('Dental Intra Oral Peri-apical', 'HS', 0, 'XR070', '', 200.00, 200.00, 1000000000.00, 0.00, '', 212, 0, 0, 0),
('Dental Occlusals', 'HS', 0, 'XR071', '', 300.00, 300.00, 1000000000.00, 0.00, '', 213, 0, 0, 0),
('Dental Bitewings', 'HS', 0, 'XR072', '', 200.00, 200.00, 1000000000.00, 0.00, '', 214, 0, 0, 0),
('Blood Slide for Malaria', 'LT', 0, 'LAB001', '', 100.00, 100.00, 1000000000.00, 0.00, '', 215, 0, 0, 0),
('Stool for O/C/Trophozoites', 'LT', 0, 'LAB002', '', 100.00, 100.00, 1000000000.00, 0.00, '', 216, 0, 0, 0),
('Sputum for AAFB', 'LT', 0, 'LAB003', '', 0.00, 0.00, 1000000000.00, 0.00, '', 217, 0, 0, 0),
('Culture & Sensitivity for any specimen', 'LT', 0, 'LAB004', '', 400.00, 400.00, 1000000000.00, 0.00, '', 218, 0, 0, 0),
('Wet Preparations', 'LT', 0, 'LAB005', '', 100.00, 100.00, 1000000000.00, 0.00, '', 219, 0, 0, 0),
('Gram Staining', 'LT', 0, 'LAB006', '', 200.00, 200.00, 1000000000.00, 0.00, '', 220, 0, 0, 0),
('Syphilis Test', 'LT', 0, 'LAB007', '', 200.00, 200.00, 1000000000.00, 0.00, '', 221, 0, 0, 0),
('ASOT', 'LT', 0, 'LAB008', '', 200.00, 200.00, 1000000000.00, 0.00, '', 222, 0, 0, 0),
('Widal Test', 'LT', 0, 'LAB009', '', 200.00, 200.00, 1000000000.00, 0.00, '', 223, 0, 0, 0),
('Brucella', 'LT', 0, 'LAB010', '', 200.00, 200.00, 1000000000.00, 0.00, '', 224, 0, 0, 0),
('Rheumatoid Factor (RHF)', 'LT', 0, 'LAB011', '', 200.00, 200.00, 1000000000.00, 0.00, '', 225, 0, 0, 0),
('Cryptococcal Antigen', 'LT', 0, 'LAB012', '', 400.00, 400.00, 1000000000.00, 0.00, '', 226, 0, 0, 0),
('Helicobacter Pylory(H. Pylory)', 'LT', 0, 'LAB013', '', 500.00, 500.00, 1000000000.00, 0.00, '', 227, 0, 0, 0),
('Hepatitis', 'LT', 0, 'LAB014', '', 200.00, 200.00, 1000000000.00, 0.00, '', 228, 0, 0, 0),
('CD 4', 'LT', 0, 'LAB015', '', 0.00, 0.00, 1000000000.00, 0.00, '', 229, 0, 0, 0),
('Viral Load', 'LT', 0, 'LAB016', '', 4500.00, 4500.00, 1000000000.00, 0.00, '', 230, 0, 0, 0),
('HIV Screening Long Elisa', 'LT', 0, 'LAB017', '', 400.00, 400.00, 1000000000.00, 0.00, '', 231, 0, 0, 0),
('UEC', 'LT', 0, 'LAB018', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 232, 0, 0, 0),
('Blood Grouping', 'LT', 0, 'LAB019', '', 150.00, 150.00, 1000000000.00, 0.00, '', 233, 0, 0, 0),
('Grouping & Cross Match', 'LT', 0, 'LAB020', '', 400.00, 400.00, 1000000000.00, 0.00, '', 234, 0, 0, 0),
('Sickle cell Screening', 'LT', 0, 'LAB021', '', 200.00, 200.00, 1000000000.00, 0.00, '', 235, 0, 0, 0),
('Reticulocyte Count', 'LT', 0, 'LAB022', '', 200.00, 200.00, 1000000000.00, 0.00, '', 236, 0, 0, 0),
('WBC Count', 'LT', 0, 'LAB023', '', 200.00, 200.00, 1000000000.00, 0.00, '', 237, 0, 0, 0),
('Full Haemogram & ESR', 'LT', 0, 'LAB024', '', 400.00, 400.00, 1000000000.00, 0.00, '', 238, 0, 0, 0),
('HB', 'LT', 0, 'LAB025', '', 100.00, 100.00, 1000000000.00, 0.00, '', 239, 0, 0, 0),
('ESR', 'LT', 0, 'LAB026', '', 150.00, 150.00, 1000000000.00, 0.00, '', 240, 0, 0, 0),
('ANC Profile', 'LT', 0, 'LAB027', '', 600.00, 600.00, 1000000000.00, 0.00, '', 241, 0, 0, 0),
('Urinalysis/Microscopy', 'LT', 0, 'LAB028', '', 100.00, 100.00, 1000000000.00, 0.00, '', 242, 0, 0, 0),
('Pregnancy Test', 'LT', 0, 'LAB029', '', 200.00, 200.00, 1000000000.00, 0.00, '', 243, 0, 0, 0),
('Random/Fasting Blood Sugar', 'LT', 0, 'LAB030', '', 100.00, 100.00, 1000000000.00, 0.00, '', 244, 0, 0, 0),
('OGTT', 'LT', 0, 'LAB031', '', 500.00, 500.00, 1000000000.00, 0.00, '', 245, 0, 0, 0),
('Acid Phosphatase test', 'LT', 0, 'LAB032', '', 200.00, 200.00, 1000000000.00, 0.00, '', 246, 0, 0, 0),
('Calcium', 'LT', 0, 'LAB033', '', 200.00, 200.00, 1000000000.00, 0.00, '', 247, 0, 0, 0),
('Uric Acid', 'LT', 0, 'LAB034', '', 200.00, 200.00, 1000000000.00, 0.00, '', 248, 0, 0, 0),
('Bence Jones Protein', 'LT', 0, 'LAB035', '', 300.00, 300.00, 1000000000.00, 0.00, '', 249, 0, 0, 0),
('Occult Blood', 'LT', 0, 'LAB037', '', 200.00, 200.00, 1000000000.00, 0.00, '', 250, 0, 0, 0),
('C-Reactive Protein', 'LT', 0, 'LAB038', '', 500.00, 500.00, 1000000000.00, 0.00, '', 251, 0, 0, 0),
('Urea', 'LT', 0, 'LAB039', '', 200.00, 200.00, 1000000000.00, 0.00, '', 252, 0, 0, 0),
('Creatinine', 'LT', 0, 'LAB040', '', 200.00, 200.00, 1000000000.00, 0.00, '', 253, 0, 0, 0),
('Sodium', 'LT', 0, 'LAB041', '', 200.00, 200.00, 1000000000.00, 0.00, '', 254, 0, 0, 0),
('Potassium ', 'LT', 0, 'LAB042', '', 200.00, 200.00, 1000000000.00, 0.00, '', 255, 0, 0, 0),
('Chloride', 'LT', 0, 'LAB043', '', 200.00, 200.00, 1000000000.00, 0.00, '', 256, 0, 0, 0),
('Liver Function Test (LFTS)', 'LT', 0, 'LAB044', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 257, 0, 0, 0),
('Serum Protein', 'LT', 0, 'LAB045', '', 200.00, 200.00, 1000000000.00, 0.00, '', 258, 0, 0, 0),
('Direct & Total Bilirubin', 'LT', 0, 'LAB046', '', 200.00, 200.00, 1000000000.00, 0.00, '', 259, 0, 0, 0),
('ALT (SGBT)', 'LT', 0, 'LAB047', '', 200.00, 200.00, 1000000000.00, 0.00, '', 260, 0, 0, 0),
('AST (SGOT)', 'LT', 0, 'LAB049', '', 200.00, 200.00, 1000000000.00, 0.00, '', 261, 0, 0, 0),
('Albumin', 'LT', 0, 'LAB050', '', 200.00, 200.00, 999999999.00, 0.00, '', 262, 0, 0, 0),
('Alkaline Phosphatase', 'LT', 0, 'LAB051', '', 200.00, 200.00, 1000000000.00, 0.00, '', 263, 0, 0, 0),
('Gamma GT', 'LT', 0, 'LAB052', '', 200.00, 200.00, 1000000000.00, 0.00, '', 264, 0, 0, 0),
('Lipid Profile', 'LT', 0, 'LAB053', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 265, 0, 0, 0),
('Total Cholesterol', 'LT', 0, 'LAB054', '', 200.00, 200.00, 1000000000.00, 0.00, '', 266, 0, 0, 0),
('Triglycerides', 'LT', 0, 'LAB055', '', 200.00, 200.00, 1000000000.00, 0.00, '', 267, 0, 0, 0),
('HDL', 'LT', 0, 'LAB056', '', 200.00, 200.00, 1000000000.00, 0.00, '', 268, 0, 0, 0),
('LDL', 'LT', 0, 'LAB057', '', 200.00, 200.00, 1000000000.00, 0.00, '', 269, 0, 0, 0),
('Amylase', 'LT', 0, 'LAB058', '', 200.00, 200.00, 1000000000.00, 0.00, '', 270, 0, 0, 0),
('Glucose', 'LT', 0, 'LAB059', '', 200.00, 200.00, 1000000000.00, 0.00, '', 271, 0, 0, 0),
('CSF', 'LT', 0, 'LAB060', '', 600.00, 600.00, 1000000000.00, 0.00, '', 272, 0, 0, 0),
('Blood Culture', 'LT', 0, 'LAB061', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 273, 0, 0, 0),
('Enzyme Assay', 'LT', 0, 'LAB062', '', 500.00, 500.00, 1000000000.00, 0.00, '', 274, 0, 0, 0),
('T3', 'LT', 0, 'LAB063', '', 400.00, 400.00, 1000000000.00, 0.00, '', 275, 0, 0, 0),
('T4', 'LT', 0, 'LAB064', '', 400.00, 400.00, 1000000000.00, 0.00, '', 276, 0, 0, 0),
('TSH', 'LT', 0, 'LAB065', '', 400.00, 400.00, 1000000000.00, 0.00, '', 277, 0, 0, 0),
('PSA', 'LT', 0, 'LAB066', '', 400.00, 400.00, 1000000000.00, 0.00, '', 278, 0, 0, 0),
('HCG', 'LT', 0, 'LAB067', '', 400.00, 400.00, 1000000000.00, 0.00, '', 279, 0, 0, 0),
('Histology Investigations', 'LT', 0, 'LAB068', '', 500.00, 500.00, 1000000000.00, 0.00, '', 280, 0, 0, 0),
('Cytology Investigations', 'LT', 0, 'LAB069', '', 500.00, 500.00, 1000000000.00, 0.00, '', 281, 0, 0, 0),
('Immunology Investigations', 'LT', 0, 'LAB070', '', 500.00, 500.00, 1000000000.00, 0.00, '', 282, 0, 0, 0),
('Direct Coombs & Indirect Coomb', 'LT', 0, 'LAB071', '', 200.00, 200.00, 1000000000.00, 0.00, '', 283, 0, 0, 0),
('Bleeding Time', 'LT', 0, 'LAB072', '', 500.00, 500.00, 1000000000.00, 0.00, '', 284, 0, 0, 0),
('Peripheral Blood Films (PBF)', 'LT', 0, 'LAB073', '', 200.00, 200.00, 1000000000.00, 0.00, '', 285, 0, 0, 0),
('KOH Test', 'LT', 0, 'LAB074', '', 100.00, 100.00, 1000000000.00, 0.00, '', 286, 0, 0, 0),
('Semen Analysis', 'LT', 0, 'LAB076', '', 500.00, 500.00, 1000000000.00, 0.00, '', 287, 0, 0, 0),
('Assisted Feed', 'HS', 0, 'NURS001', '', 40.00, 40.00, 1000000000.00, 0.00, '', 288, 0, 0, 0),
('Nasogastric Tube Fixing (NGT)', 'HS', 0, 'NURS002', '', 40.00, 40.00, 1000000000.00, 0.00, '', 289, 0, 0, 0),
('Nasogastric Tube Feeding (NGT)', 'HS', 0, 'NURS003', '', 100.00, 100.00, 1000000000.00, 0.00, '', 290, 0, 0, 0),
('Nasogastric Sunctioning', 'HS', 0, 'NURS004', '', 100.00, 100.00, 1000000000.00, 0.00, '', 291, 0, 0, 0),
('Tracheostomy Care', 'HS', 0, 'NURS005', '', 100.00, 100.00, 1000000000.00, 0.00, '', 292, 0, 0, 0),
('Gastrostomy Tube Feed', 'HS', 0, 'NURS006', '', 100.00, 100.00, 1000000000.00, 0.00, '', 293, 0, 0, 0),
('Gastric (Stomach) wash out', 'HS', 0, 'NURS007', '', 300.00, 300.00, 1000000000.00, 0.00, '', 294, 0, 0, 0),
('Fixing Foleys Catheter', 'HS', 0, 'NURS008', '', 100.00, 100.00, 1000000000.00, 0.00, '', 295, 0, 0, 0),
('Fixing a Condom Catheter', 'HS', 0, 'NURS009', '', 50.00, 50.00, 1000000000.00, 0.00, '', 296, 0, 0, 0),
('Wound Dressing', 'HS', 0, 'NURS010', '', 150.00, 150.00, 1000000000.00, 0.00, '', 297, 0, 0, 0),
('Wound Dressing (Minor Theatre)', 'HS', 0, 'NURS011', '', 500.00, 500.00, 1000000000.00, 0.00, '', 298, 0, 0, 0),
('Dressing of Burns (Ward)', 'HS', 0, 'NURS012', '', 200.00, 200.00, 1000000000.00, 0.00, '', 299, 0, 0, 0),
('Endotracheal Tube Sunctioning', 'HS', 0, 'NURS013', '', 150.00, 150.00, 1000000000.00, 0.00, '', 300, 0, 0, 0),
('Blood Transfusion Service', 'HS', 0, 'NURS014', '', 100.00, 100.00, 1000000000.00, 0.00, '', 301, 0, 0, 0),
('Removal of Stitches/Staples/Clips', 'HS', 0, 'NURS015', '', 100.00, 100.00, 1000000000.00, 0.00, '', 302, 0, 0, 0),
('Nebulization', 'HS', 0, 'NURS016', '', 300.00, 300.00, 1000000000.00, 0.00, '', 303, 0, 0, 0),
('Injection', 'HS', 0, 'NURS017', '', 50.00, 50.00, 1000000000.00, 0.00, '', 304, 0, 0, 0),
('Incision and Drainage', 'HS', 0, 'NURS018', '', 500.00, 500.00, 1000000000.00, 0.00, '', 305, 0, 0, 0),
('Circumcission', 'HS', 0, 'NURS019', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 306, 0, 0, 0),
('Enema', 'HS', 0, 'NURS020', '', 100.00, 100.00, 1000000000.00, 0.00, '', 307, 0, 0, 0),
('Bed Bath', 'HS', 0, 'NURS021', '', 100.00, 100.00, 1000000000.00, 0.00, '', 308, 0, 0, 0),
('Assisted Bed Bath', 'HS', 0, 'NURS022', '', 50.00, 50.00, 1000000000.00, 0.00, '', 309, 0, 0, 0),
('Daily Bed Charges', 'HS', 0, 'NURS023', '', 300.00, 300.00, 1000000000.00, 0.00, '', 310, 0, 0, 0),
('Lumbar Puncture', 'HS', 0, 'NURS024', '', 200.00, 200.00, 1000000000.00, 0.00, '', 311, 0, 0, 0),
('Last Offices (in the ward)', 'HS', 0, 'NURS025', '', 100.00, 100.00, 1000000000.00, 0.00, '', 312, 0, 0, 0),
('Mouth Toilet', 'HS', 0, 'NURS026', '', 40.00, 40.00, 1000000000.00, 0.00, '', 313, 0, 0, 0),
('Shaving', 'HS', 0, 'NURS027', '', 40.00, 40.00, 1000000000.00, 0.00, '', 314, 0, 0, 0),
('Gastric Lavage', 'HS', 0, 'NURS028', '', 200.00, 200.00, 1000000000.00, 0.00, '', 315, 0, 0, 0),
('Skin Care', 'HS', 0, 'NURS029', '', 100.00, 100.00, 1000000000.00, 0.00, '', 316, 0, 0, 0),
('Resuscitation', 'HS', 0, 'NURS030', '', 200.00, 200.00, 1000000000.00, 0.00, '', 317, 0, 0, 0),
('Vulva Toilet', 'HS', 0, 'NURS031', '', 100.00, 100.00, 1000000000.00, 0.00, '', 318, 0, 0, 0),
('Stitching (in minor theatre)', 'HS', 0, 'NURS032', '', 500.00, 500.00, 1000000000.00, 0.00, '', 319, 0, 0, 0),
('Bags, Colostomy', 'HS', 0, 'NURS033', '', 500.00, 500.00, 1000000000.00, 0.00, '', 320, 0, 0, 0),
('Blood Giving Sets', 'HS', 0, 'NURS034', '', 80.00, 80.00, 1000000000.00, 0.00, '', 321, 0, 0, 0),
('Catheter Folleys', 'HS', 0, 'NURS035', '', 70.00, 70.00, 1000000000.00, 0.00, '', 322, 0, 0, 0),
('Gynaecological Gloves  ', 'HS', 0, 'NURS036', '', 50.00, 50.00, 1000000000.00, 0.00, '', 323, 0, 0, 0),
('Cord Clumps', 'HS', 0, 'NURS037', '', 10.00, 10.00, 1000000000.00, 0.00, '', 324, 0, 0, 0),
('Crepe Bandages', 'HS', 0, 'NURS038', '', 80.00, 80.00, 1000000000.00, 0.00, '', 325, 0, 0, 0),
('Examination Gloves(Disposable)', 'HS', 0, 'NURS039', '', 10.00, 10.00, 1000000000.00, 0.00, '', 326, 0, 0, 0),
('Surgeon Gloves', 'HS', 0, 'NURS040', '', 30.00, 30.00, 1000000000.00, 0.00, '', 327, 0, 0, 0),
('I.V. Cannulas', 'HS', 0, 'NURS041', '', 50.00, 50.00, 1000000000.00, 0.00, '', 328, 0, 0, 0),
('Identification Bands', 'HS', 0, 'NURS042', '', 10.00, 10.00, 1000000000.00, 0.00, '', 329, 0, 0, 0),
('Infusion Giving Sets', 'HS', 0, 'NURS043', '', 30.00, 30.00, 1000000000.00, 0.00, '', 330, 0, 0, 0),
('Insulin Syringe', 'HS', 0, 'NURS044', '', 10.00, 10.00, 1000000000.00, 0.00, '', 331, 0, 0, 0),
('Intercostal Drainage Tubes', 'HS', 0, 'NURS046', '', 80.00, 80.00, 1000000000.00, 0.00, '', 332, 0, 0, 0),
('Syringe (50cc,60cc)', 'HS', 0, 'NURS047', '', 80.00, 80.00, 1000000000.00, 0.00, '', 333, 0, 0, 0),
('Nasogastric Feeding Tubes', 'HS', 0, 'NURS048', '', 20.00, 20.00, 1000000000.00, 0.00, '', 334, 0, 0, 0),
('Plaster of Paris', 'HS', 0, 'NURS049', '', 250.00, 250.00, 1000000000.00, 0.00, '', 335, 0, 0, 0),
('Solusets for Blood', 'HS', 0, 'NURS050', '', 250.00, 250.00, 1000000000.00, 0.00, '', 336, 0, 0, 0),
('Solusets for Fluids', 'HS', 0, 'NURS051', '', 150.00, 150.00, 1000000000.00, 0.00, '', 337, 0, 0, 0),
('Spinal Needle', 'HS', 0, 'NURS052', '', 70.00, 70.00, 1000000000.00, 0.00, '', 338, 0, 0, 0),
('Suction Catheter', 'HS', 0, 'NURS053', '', 50.00, 50.00, 1000000000.00, 0.00, '', 339, 0, 0, 0),
('Surgical Blades', 'HS', 0, 'NURS054', '', 10.00, 10.00, 1000000000.00, 0.00, '', 340, 0, 0, 0),
('Syringes with Needles (2cc,5cc,10cc,20cc)', 'HS', 0, 'NURS056', '', 10.00, 10.00, 1000000000.00, 0.00, '', 341, 0, 0, 0),
('Urine Bags', 'HS', 0, 'NURS057', '', 50.00, 50.00, 1000000000.00, 0.00, '', 342, 0, 0, 0),
('Sutures Vicryl', 'HS', 0, 'NURS058', '', 250.00, 250.00, 1000000000.00, 0.00, '', 343, 0, 0, 0),
('Sutures Nylon', 'HS', 0, 'NURS059', '', 50.00, 50.00, 1000000000.00, 0.00, '', 344, 0, 0, 0),
('Sutures Silk', 'HS', 0, 'NURS060', '', 50.00, 50.00, 1000000000.00, 0.00, '', 345, 0, 0, 0),
('Embalmment ', 'HS', 0, 'MORT001', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 346, 0, 0, 0),
('Embalmment (BID)', 'HS', 0, 'MORT002', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 347, 0, 0, 0),
('Embalmment (Under 5)', 'HS', 0, 'MORT003', '', 500.00, 500.00, 1000000000.00, 0.00, '', 348, 0, 0, 0),
('Last Offices (Mortuary)', 'HS', 0, 'MORT004', '', 6000.00, 6000.00, 1000000000.00, 0.00, '', 349, 0, 0, 0),
('Post Mortem', 'HS', 0, 'MORT005', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 350, 0, 0, 0),
('Mortuary Charges (per day)', 'HS', 0, 'MORT006', '', 500.00, 500.00, 1000000000.00, 0.00, '', 351, 0, 0, 0),
('Reduction of Dislocations', 'HS', 0, 'ORTH001', '', 500.00, 500.00, 1000000000.00, 0.00, '', 352, 0, 0, 0),
('Full Length POP', 'HS', 0, 'ORTH002', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 353, 0, 0, 0),
('Cylinder POP', 'HS', 0, 'ORTH003', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 354, 0, 0, 0),
('Below Knee POP', 'HS', 0, 'ORTH004', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 355, 0, 0, 0),
('Boot POP', 'HS', 0, 'ORTH005', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 356, 0, 0, 0),
('Above Knee/Back Slab Above Knee POP', 'HS', 0, 'ORTH006', '', 1400.00, 1400.00, 1000000000.00, 0.00, '', 357, 0, 0, 0),
('Back Slab Below Knee POP', 'HS', 0, 'ORTH007', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 358, 0, 0, 0),
('U/Slab POP', 'HS', 0, 'ORTH008', '', 1150.00, 1150.00, 1000000000.00, 0.00, '', 359, 0, 0, 0),
('Above Elbow/Back Slab Above Elbow POP', 'HS', 0, 'ORTH009', '', 900.00, 900.00, 1000000000.00, 0.00, '', 360, 0, 0, 0),
('Scaphoid POP', 'HS', 0, 'ORTH010', '', 800.00, 800.00, 1000000000.00, 0.00, '', 361, 0, 0, 0),
('Above Elbow POP', 'HS', 0, 'ORTH011', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 362, 0, 0, 0),
('Below Elbow POP', 'HS', 0, 'ORTH012', '', 900.00, 900.00, 1000000000.00, 0.00, '', 363, 0, 0, 0),
('Orthopaedic Service Charge', 'HS', 0, 'ORTH014', '', 300.00, 300.00, 1000000000.00, 0.00, '', 364, 0, 0, 0),
('Crepe Bandage Application', 'HS', 0, 'ORTH015', '', 200.00, 200.00, 1000000000.00, 0.00, '', 365, 0, 0, 0),
('POP Removal', 'HS', 0, 'ORTH016', '', 400.00, 400.00, 1000000000.00, 0.00, '', 366, 0, 0, 0),
('POP Removal (Under 5 years)', 'HS', 0, 'ORTH017', '', 0.00, 0.00, 1000000000.00, 0.00, '', 367, 0, 0, 0),
('CTEV', 'HS', 0, 'ORTH018', '', 150.00, 150.00, 1000000000.00, 0.00, '', 368, 0, 0, 0),
('Skin Traction', 'HS', 0, 'ORTH019', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 369, 0, 0, 0),
('Skeletal Traction', 'HS', 0, 'ORTH020', '', 4000.00, 4000.00, 1000000000.00, 0.00, '', 370, 0, 0, 0),
('Arm Sling Application', 'HS', 0, 'ORTH021', '', 150.00, 150.00, 1000000000.00, 0.00, '', 371, 0, 0, 0),
('Knee Support', 'HS', 0, 'ORTH022', '', 800.00, 800.00, 1000000000.00, 0.00, '', 372, 0, 0, 0),
('Ankle Support', 'HS', 0, 'ORTH023', '', 800.00, 800.00, 1000000000.00, 0.00, '', 373, 0, 0, 0),
('Wrist Support', 'HS', 0, 'ORTH024', '', 800.00, 800.00, 1000000000.00, 0.00, '', 374, 0, 0, 0),
('Skeletal Traction Removal', 'HS', 0, 'ORTH025', '', 500.00, 500.00, 1000000000.00, 0.00, '', 375, 0, 0, 0),
('Skin Traction Removal', 'HS', 0, 'ORTH026', '', 300.00, 300.00, 1000000000.00, 0.00, '', 376, 0, 0, 0),
('POP Reinforcement ', 'HS', 0, 'ORTH027', '', 300.00, 300.00, 1000000000.00, 0.00, '', 377, 0, 0, 0),
('Occupational Therapy (Under 5 1st Visit)', 'HS', 0, 'OCT001', '', 100.00, 100.00, 1000000000.00, 0.00, '', 378, 0, 0, 0),
('Sensory Stimulation-Stroking,Happing/Rubbing,Massage', 'HS', 0, 'OCT002', '', 150.00, 150.00, 1000000000.00, 0.00, '', 379, 0, 0, 0),
('Therapeutic Activities', 'HS', 0, 'OCT003', '', 150.00, 150.00, 1000000000.00, 0.00, '', 380, 0, 0, 0),
('Training in Delayed Developmental Milestones', 'HS', 0, 'OCT004', '', 50.00, 50.00, 1000000000.00, 0.00, '', 381, 0, 0, 0),
('Training in ADLS', 'HS', 0, 'OCT005', '', 150.00, 150.00, 1000000000.00, 0.00, '', 382, 0, 0, 0),
('Correction of CTEV (POP)', 'HS', 0, 'OCT006', '', 150.00, 150.00, 1000000000.00, 0.00, '', 383, 0, 0, 0),
('Orthoplast (Dynamic)', 'HS', 0, 'OCT007', '', 2500.00, 2500.00, 1000000000.00, 0.00, '', 384, 0, 0, 0),
('Orthoplast (Static)', 'HS', 0, 'OCT008', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 385, 0, 0, 0),
('POP', 'HS', 0, 'OCT009', '', 500.00, 500.00, 1000000000.00, 0.00, '', 386, 0, 0, 0),
('Calcaneal Spur Pads BIL(MCR)', 'HS', 0, 'ORTH028', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 387, 0, 0, 0),
('Wedges BIL', 'HS', 0, 'ORTH029', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 388, 0, 0, 0),
('Surgical Boot', 'HS', 0, 'ORTH030', '', 1200.00, 1200.00, 1000000000.00, 0.00, '', 389, 0, 0, 0),
('Ankle Foot Orthosis (Metallic)', 'HS', 0, 'ORTH031', '', 2000.00, 2000.00, 999999999.00, 0.00, '', 390, 0, 0, 0),
('Ankle Foot Orthosis (Plastic)', 'HS', 0, 'ORTH032', '', 1800.00, 1800.00, 1000000000.00, 0.00, '', 391, 0, 0, 0),
('Above Knee Brace (KAFO) without joint bill', 'HS', 0, 'ORTH033', '', 6000.00, 6000.00, 1000000000.00, 0.00, '', 392, 0, 0, 0),
('Above Knee Brace (KAFO) with joint bill', 'HS', 0, 'ORTH034', '', 12000.00, 12000.00, 1000000000.00, 0.00, '', 393, 0, 0, 0),
('Knee Cap', 'HS', 0, 'ORTH035', '', 400.00, 400.00, 1000000000.00, 0.00, '', 394, 0, 0, 0),
('T-Strap', 'HS', 0, 'ORTH036', '', 250.00, 250.00, 1000000000.00, 0.00, '', 395, 0, 0, 0),
('Stirrup', 'HS', 0, 'ORTH037', '', 450.00, 450.00, 1000000000.00, 0.00, '', 396, 0, 0, 0),
('Axillary Crutches (Wooden)', 'HS', 0, 'ORTH038', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 397, 0, 0, 0),
('Elbow Crutches (Wooden)', 'HS', 0, 'ORTH039', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 398, 0, 0, 0),
('Cervical Collar (Rigid)', 'HS', 0, 'ORTH040', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 399, 0, 0, 0),
('Cervical Collar (Soft)', 'HS', 0, 'ORTH041', '', 600.00, 600.00, 1000000000.00, 0.00, '', 400, 0, 0, 0),
('Spinal Brace (Child)', 'HS', 0, 'ORTH042', '', 6500.00, 6500.00, 1000000000.00, 0.00, '', 401, 0, 0, 0),
('Spinal Brace (Adult)', 'HS', 0, 'ORTH043', '', 13000.00, 13000.00, 1000000000.00, 0.00, '', 402, 0, 0, 0),
('Spinal Cosert (Child)', 'HS', 0, 'ORTH044', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 403, 0, 0, 0),
('Spinal Cosert (Adult)', 'HS', 0, 'ORTH045', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 404, 0, 0, 0),
('Walking Cane', 'HS', 0, 'ORTH046', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 405, 0, 0, 0),
('Adjustment/Repair(Orthopaedic)', 'HS', 0, 'ORTH047', '', 500.00, 500.00, 999999998.00, 0.00, '', 406, 0, 0, 0),
('Shoe Raise (per inch)', 'HS', 0, 'ORTH048', '', 600.00, 600.00, 1000000000.00, 0.00, '', 407, 0, 0, 0),
('Insole Bill', 'HS', 0, 'ORTH049', '', 500.00, 500.00, 1000000000.00, 0.00, '', 408, 0, 0, 0),
('Arch Support (Mounded)', 'HS', 0, 'ORTH050', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 409, 0, 0, 0),
('Sech Foot', 'HS', 0, 'ORTH051', '', 7000.00, 7000.00, 1000000000.00, 0.00, '', 410, 0, 0, 0),
('BK Prosthesis', 'HS', 0, 'ORTH052', '', 13000.00, 13000.00, 1000000000.00, 0.00, '', 411, 0, 0, 0),
('TK Prosthesis', 'HS', 0, 'ORTH053', '', 15000.00, 15000.00, 1000000000.00, 0.00, '', 412, 0, 0, 0),
('A/K Prosthesis', 'HS', 0, 'ORTH054', '', 25000.00, 25000.00, 999999994.00, 0.00, '', 413, 0, 0, 0),
('Suspension - Prosthetic', 'HS', 0, 'ORTH055', '', 800.00, 800.00, 1000000000.00, 0.00, '', 414, 0, 0, 0),
('Stump Sock', 'HS', 0, 'ORTH056', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 415, 0, 0, 0),
('Knee Joint Unit (Prosthesis)', 'HS', 0, 'ORTH057', '', 16000.00, 16000.00, 1000000000.00, 0.00, '', 416, 0, 0, 0),
('Physiotherapy Session', 'HS', 0, 'HS007', '', 200.00, 200.00, 1000000000.00, 0.00, '', 417, 0, 0, 0),
('Nutrition Session', 'HS', 0, 'HS008', '', 100.00, 100.00, 1000000000.00, 0.00, '', 418, 0, 0, 0),
('Public Health Consultation', 'HS', 0, 'HS009', '', 0.00, 0.00, 1000000000.00, 0.00, '', 419, 0, 0, 0),
('Food Handlers Certificate (Excluding Lab Tests)', 'HS', 0, 'HS010', '', 200.00, 200.00, 1000000000.00, 0.00, '', 420, 0, 0, 0),
('Medical Report/Form', 'HS', 0, 'HS011', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 421, 0, 0, 0),
('General Anaesthesia', 'HS', 0, 'THEATRE001', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 422, 0, 0, 0),
('Local Anaesthesia', 'HS', 0, 'THEATRE002', '', 500.00, 500.00, 1000000000.00, 0.00, '', 423, 0, 0, 0),
('Spinal Anaesthesia', 'HS', 0, 'THEATRE003', '', 500.00, 500.00, 1000000000.00, 0.00, '', 424, 0, 0, 0),
('Sedation/LA (Minor Theatre)', 'HS', 0, 'THEATRE004', '', 300.00, 300.00, 1000000000.00, 0.00, '', 425, 0, 0, 0),
('Nitrous Oxide (1 hour)', 'HS', 0, 'THEATRE005', '', 400.00, 400.00, 1000000000.00, 0.00, '', 426, 0, 0, 0),
('Nitrous Oxide (more than 1 hour)', 'HS', 0, 'THEATRE006', '', 600.00, 600.00, 1000000000.00, 0.00, '', 427, 0, 0, 0),
('Halothane (per hour)', 'HS', 0, 'THEATRE007', '', 100.00, 100.00, 1000000000.00, 0.00, '', 428, 0, 0, 0),
('Isoflurane (per hour)', 'HS', 0, 'THEATRE008', '', 400.00, 400.00, 1000000000.00, 0.00, '', 429, 0, 0, 0),
('Loop Procedures ', 'HS', 0, 'THEATRE009', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 430, 0, 0, 0),
('Laparatomy', 'HS', 0, 'THEATRE010', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 431, 0, 0, 0),
('Thyroidectomy', 'HS', 0, 'THEATRE011', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 432, 0, 0, 0),
('Prostatectomy', 'HS', 0, 'THEATRE012', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 433, 0, 0, 0),
('Mastectomy', 'HS', 0, 'THEATRE013', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 434, 0, 0, 0),
('ORIF', 'HS', 0, 'THEATRE014', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 435, 0, 0, 0),
('Amputation', 'HS', 0, 'THEATRE015', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 436, 0, 0, 0),
('Hernia Mesh Repair', 'HS', 0, 'THEATRE016', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 437, 0, 0, 0),
('Cleft Repair', 'HS', 0, 'THEATRE017', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 438, 0, 0, 0),
('Orchidopexy', 'HS', 0, 'THEATRE018', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 439, 0, 0, 0),
('Skin Grafting/Flaps', 'HS', 0, 'THEATRE019', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 440, 0, 0, 0),
('Herniorraphy (Under GA)', 'HS', 0, 'THEATRE020', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 441, 0, 0, 0),
('Herniorraphy (Under LA)', 'HS', 0, 'THEATRE021', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 442, 0, 0, 0),
('Herniotomy (Under GA)', 'HS', 0, 'THEATRE022', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 443, 0, 0, 0),
('Lumpectomy (Under GA)', 'HS', 0, 'THEATRE023', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 444, 0, 0, 0),
('Lumpectomy (Under LA)', 'HS', 0, 'THEATRE024', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 445, 0, 0, 0),
('Spincterotomy (Under GA)', 'HS', 0, 'THEATRE025', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 446, 0, 0, 0),
('Hemorroidectomy (Under GA)', 'HS', 0, 'THEATRE027', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 447, 0, 0, 0),
('Appendicectomy (Under GA)', 'HS', 0, 'THEATRE026', '', 3000.00, 3000.00, 999999999.00, 0.00, '', 448, 0, 0, 0),
('Hydrocelectomy/ Scrotal Exploration (Under GA)', 'HS', 0, 'THEATRE028', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 449, 0, 0, 0),
('Hydrocelectomy/ Scrotal Exploration (Under LA)', 'HS', 0, 'THEATRE029', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 450, 0, 0, 0),
('Surgical Debridement(Under GA)', 'HS', 0, 'THEATRE030', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 451, 0, 0, 0),
('Excisions/Biopsy (Under GA)', 'HS', 0, 'THEATRE031', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 452, 0, 0, 0),
('Excisions/Biopsy (Under LA)', 'HS', 0, 'THEATRE032', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 453, 0, 0, 0),
('Eye Consultation(General)', 'HS', 0, 'EYE001', '', 100.00, 100.00, 1000000000.00, 0.00, '', 454, 0, 0, 0),
('Eye Consultation(Consultant)', 'HS', 0, 'EYE002', '', 300.00, 300.00, 1000000000.00, 0.00, '', 455, 0, 0, 0),
('Eye Consultation(Under 5)', 'HS', 0, 'EYE003', '', 0.00, 0.00, 1000000000.00, 0.00, '', 456, 0, 0, 0),
('Conjunctival/Lid Growth Excision (LA)', 'HS', 0, 'EYE004', '', 500.00, 500.00, 1000000000.00, 0.00, '', 457, 0, 0, 0),
('Conjunctival/Lid Growth Excision (GA)', 'HS', 0, 'EYE005', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 458, 0, 0, 0),
('Conjunctival Flap (Under LA)', 'HS', 0, 'EYE006', '', 500.00, 500.00, 1000000000.00, 0.00, '', 459, 0, 0, 0),
('Conjunctival Flap (Under GA)', 'HS', 0, 'EYE007', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 460, 0, 0, 0),
('Tarsal Plate Rotation (LA)', 'HS', 0, 'EYE008', '', 500.00, 500.00, 1000000000.00, 0.00, '', 461, 0, 0, 0),
('Tarsal Plate Rotation (GA)', 'HS', 0, 'EYE009', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 462, 0, 0, 0),
('Foreign Body Removal (LA)', 'HS', 0, 'EYE010', '', 300.00, 300.00, 1000000000.00, 0.00, '', 463, 0, 0, 0),
('Foreign Body Removal (GA)', 'HS', 0, 'EYE011', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 464, 0, 0, 0),
('Stitching/Lid Repair (LA)', 'HS', 0, 'EYE012', '', 500.00, 500.00, 1000000000.00, 0.00, '', 465, 0, 0, 0),
('Stitching/Lid Repair (GA)', 'HS', 0, 'EYE013', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 466, 0, 0, 0),
('Eye Incision & Drainage (LA)', 'HS', 0, 'EYE014', '', 500.00, 500.00, 1000000000.00, 0.00, '', 467, 0, 0, 0),
('Eye Incision & Drainage (GA)', 'HS', 0, 'EYE015', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 468, 0, 0, 0),
('Eye Probing & Syringing (LA)', 'HS', 0, 'EYE017', '', 500.00, 500.00, 1000000000.00, 0.00, '', 469, 0, 0, 0),
('Eye Probing & Syringing (GA)', 'HS', 0, 'EYE018', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 470, 0, 0, 0),
('Eye Removal of Stitches (LA)', 'HS', 0, 'EYE019', '', 100.00, 100.00, 1000000000.00, 0.00, '', 471, 0, 0, 0),
('Eye Removal of Stitches (GA)', 'HS', 0, 'EYE020', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 472, 0, 0, 0),
('Eye Irrigation (LA)', 'HS', 0, 'EYE021', '', 500.00, 500.00, 1000000000.00, 0.00, '', 473, 0, 0, 0),
('Eye Irrigation (GA)', 'HS', 0, 'EYE022', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 474, 0, 0, 0),
('Eye Epilation (LA)', 'HS', 0, 'EYE023', '', 300.00, 300.00, 1000000000.00, 0.00, '', 475, 0, 0, 0),
('Eye Epilation (GA)', 'HS', 0, 'EYE024', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 476, 0, 0, 0),
('Eye Padding', 'HS', 0, 'EYE025', '', 100.00, 100.00, 1000000000.00, 0.00, '', 477, 0, 0, 0),
('Eye Prothesis Insertion (LA)', 'HS', 0, 'EYE026', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 478, 0, 0, 0),
('Eye Prothesis Insertion (GA)', 'HS', 0, 'EYE027', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 479, 0, 0, 0),
('Occular Injection (LA)', 'HS', 0, 'EYE028', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 480, 0, 0, 0),
('Occular Injection (GA)', 'HS', 0, 'EYE029', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 481, 0, 0, 0),
('Subconjunctival Injection (LA)', 'HS', 0, 'EYE030', '', 500.00, 500.00, 1000000000.00, 0.00, '', 482, 0, 0, 0),
('Subconjunctival Injection (GA)', 'HS', 0, 'EYE031', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 483, 0, 0, 0),
('Intravirtreal Injection (LA)', 'HS', 0, 'EYE032', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 484, 0, 0, 0),
('Intravirtreal Injection (GA)', 'HS', 0, 'EYE033', '', 1500.00, 1500.00, 999999999.00, 0.00, '', 485, 0, 0, 0),
('Retrobulbar/Parabulbar Injection (LA)', 'HS', 0, 'EYE034', '', 500.00, 500.00, 1000000000.00, 0.00, '', 486, 0, 0, 0),
('Retrobulbar/Parabulbar Injection (GA)', 'HS', 0, 'EYE035', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 487, 0, 0, 0),
('Subtenon Injection (LA)', 'HS', 0, 'EYE036', '', 500.00, 500.00, 1000000000.00, 0.00, '', 488, 0, 0, 0),
('Subtenon Injection (GA)', 'HS', 0, 'EYE037', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 489, 0, 0, 0),
('Eye EUA (GA)', 'HS', 0, 'EYE038', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 490, 0, 0, 0),
('Eye Exenteration (GA)', 'HS', 0, 'EYE039', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 491, 0, 0, 0),
('Eye Orbitotomy (GA)', 'HS', 0, 'EYE040', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 492, 0, 0, 0),
('Cataract Surgery (SICS)+IOL (LA)', 'HS', 0, 'EYE041', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 493, 0, 0, 0),
('Cataract Surgery (SICS)+IOL (GA)', 'HS', 0, 'EYE042', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 494, 0, 0, 0),
('Cataract Surgery (PHACO)+IOL (LA)', 'HS', 0, 'EYE043', '', 25000.00, 25000.00, 1000000000.00, 0.00, '', 495, 0, 0, 0),
('Cataract Surgery (PHACO)+IOL (GA)', 'HS', 0, 'EYE044', '', 23000.00, 23000.00, 1000000000.00, 0.00, '', 496, 0, 0, 0),
('Glaucoma Surgery (LA)', 'HS', 0, 'EYE045', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 497, 0, 0, 0),
('Glaucoma Surgery (GA)', 'HS', 0, 'EYE046', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 498, 0, 0, 0),
('Trabeculectomy (GA)', 'HS', 0, 'EYE047', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 499, 0, 0, 0);
INSERT INTO `ospos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `quantity`, `reorder_level`, `location`, `item_id`, `allow_alt_description`, `is_serialized`, `deleted`) VALUES
('Trabeculotomy(GA)', 'HS', 0, 'EYE048', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 500, 0, 0, 0),
('Goniotomy (LA)', 'HS', 0, 'EYE049', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 501, 0, 0, 0),
('Goniotomy (GA)', 'HS', 0, 'EYE050', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 502, 0, 0, 0),
('Eye drainage Implants (GA)', 'HS', 0, 'EYE051', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 503, 0, 0, 0),
('Corneal Repair (LA)', 'HS', 0, 'EYE052', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 504, 0, 0, 0),
('Corneal Repair (GA)', 'HS', 0, 'EYE053', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 505, 0, 0, 0),
('Eye Anterior Chamber washout (LA)', 'HS', 0, 'EYE054', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 506, 0, 0, 0),
('Eye Anterior Chamber washout (GA)', 'HS', 0, 'EYE055', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 507, 0, 0, 0),
('Lens washout without IOL (LA)', 'HS', 0, 'EYE056', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 508, 0, 0, 0),
('Lens washout without IOL (GA)', 'HS', 0, 'EYE057', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 509, 0, 0, 0),
('Lens washout with IOL (LA)', 'HS', 0, 'EYE058', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 510, 0, 0, 0),
('Lens washout with IOL (GA)', 'HS', 0, 'EYE059', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 511, 0, 0, 0),
('Pars Plana Capsulotomy (LA)', 'HS', 0, 'EYE060', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 512, 0, 0, 0),
('Pars Plana Capsulotomy (GA)', 'HS', 0, 'EYE061', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 513, 0, 0, 0),
('Enucleation (GA)', 'HS', 0, 'EYE062', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 514, 0, 0, 0),
('Evisceration (LA)', 'HS', 0, 'EYE063', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 515, 0, 0, 0),
('Evisceration (GA)', 'HS', 0, 'EYE064', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 516, 0, 0, 0),
('DCR (LA)', 'HS', 0, 'EYE065', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 517, 0, 0, 0),
('DCR (GA)', 'HS', 0, 'EYE066', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 518, 0, 0, 0),
('Ptosis Surgery (LA)', 'HS', 0, 'EYE067', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 519, 0, 0, 0),
('Ptosis Surgery (GA)', 'HS', 0, 'EYE068', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 520, 0, 0, 0),
('Lid Surgery (LA)', 'HS', 0, 'EYE069', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 521, 0, 0, 0),
('Lid Surgery (GA)', 'HS', 0, 'EYE070', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 522, 0, 0, 0),
('Squint Surgery (LA)', 'HS', 0, 'EYE071', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 523, 0, 0, 0),
('Squint Surgery (GA)', 'HS', 0, 'EYE072', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 524, 0, 0, 0),
('Vitreoretinal Surgery (GA)', 'HS', 0, 'EYE073', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 525, 0, 0, 0),
('Vitreoretinal Surgery with Sclera Buckie (GA)', 'HS', 0, 'EYE074', '', 10000.00, 10000.00, 1000000000.00, 0.00, '', 526, 0, 0, 0),
('Eye Cryotherapy (LA)', 'HS', 0, 'EYE075', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 527, 0, 0, 0),
('Eye Cryotherapy (GA)', 'HS', 0, 'EYE076', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 528, 0, 0, 0),
('Humphreys Visual Field Analysis', 'HS', 0, 'EYE077', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 529, 0, 0, 0),
('Ocular Photography', 'HS', 0, 'EYE078', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 530, 0, 0, 0),
('Flouroscene Angiography (FLA)', 'HS', 0, 'EYE079', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 531, 0, 0, 0),
('Optical Coherent Tomography', 'HS', 0, 'EYE080', '', 2500.00, 2500.00, 1000000000.00, 0.00, '', 532, 0, 0, 0),
('Pachymetry', 'HS', 0, 'EYE081', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 533, 0, 0, 0),
('Corneal Topography', 'HS', 0, 'EYE082', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 534, 0, 0, 0),
('Biometry', 'HS', 0, 'EYE083', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 535, 0, 0, 0),
('Ocular Ultrasound', 'HS', 0, 'EYE084', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 536, 0, 0, 0),
('Spectacles (Glass on Budget Frames)', 'HS', 0, 'EYE085', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 537, 0, 0, 0),
('Spectacles (Plastic on Budget Frame)', 'HS', 0, 'EYE086', '', 3000.00, 3000.00, 1000000000.00, 0.00, '', 538, 0, 0, 0),
('Spectacles (Bifocal on Budget Frame)', 'HS', 0, 'EYE087', '', 5000.00, 5000.00, 1000000000.00, 0.00, '', 539, 0, 0, 0),
('Spectacles (Progressive Lenses)', 'HS', 0, 'EYE088', '', 10000.00, 10000.00, 1000000000.00, 0.00, '', 540, 0, 0, 0),
('Spectacles (Bandage Contact Lenses)', 'HS', 0, 'EYE089', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 541, 0, 0, 0),
('Stand Magnifier', 'HS', 0, 'EYE090', '', 2000.00, 2000.00, 1000000000.00, 0.00, '', 542, 0, 0, 0),
('Spectacle Magnifier', 'HS', 0, 'EYE091', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 543, 0, 0, 0),
('Hand Held Magnifier', 'HS', 0, 'EYE092', '', 1000.00, 1000.00, 1000000000.00, 0.00, '', 544, 0, 0, 0),
('Dome Magnifier', 'HS', 0, 'EYE093', '', 1500.00, 1500.00, 1000000000.00, 0.00, '', 545, 0, 0, 0),
('Telescope', 'HS', 0, 'EYE094', '', 2500.00, 2500.00, 1000000000.00, 0.00, '', 546, 0, 0, 0),
('Pharmacy', 'HS', 0, 'HS012', '', 0.00, 0.00, 999999999.00, 0.00, '', 547, 0, 0, 0),
('Misc', 'Misc', NULL, NULL, '', 100.00, 10.00, 10.00, 0.00, '', 548, 0, 0, 1),
('Misc', 'Misc', NULL, NULL, '', 100.00, 10.00, 10.00, 0.00, '', 549, 0, 0, 1),
('Misc', 'Misc', NULL, NULL, '', 100.00, 10.00, 10.00, 1.00, '', 550, 0, 0, 1),
('Misc', 'Misc', NULL, NULL, '', 100.00, 10.00, 10.00, 1.00, '', 551, 0, 0, 1),
('Misc', 'Misc', NULL, NULL, '', 100.00, 100.00, 10.00, 1.00, '', 552, 0, 0, 1),
('Misc', 'Misc', NULL, 'misc', '', 100.00, 100.00, 10.00, 1.00, '', 553, 0, 0, 1),
('Misc', 'Misc', NULL, NULL, '', 0.00, 10.00, 0.00, 0.00, '0', 555, 0, 0, 1),
('misc', 'misc', NULL, NULL, '', 0.00, 100.00, 0.00, 0.00, '0', 556, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(15,3) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_modules`
--

CREATE TABLE IF NOT EXISTS `ospos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_modules`
--

INSERT INTO `ospos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_config', 'module_config_desc', 120, 'config'),
('module_customers', 'module_customers_desc', 70, 'customers'),
('module_employees', 'module_employees_desc', 90, 'employees'),
('module_giftcards', 'module_giftcards_desc', 40, 'giftcards'),
('module_invoices', 'module_invoices_desc', 10, 'invoices'),
('module_items', 'module_items_desc', 50, 'items'),
('module_item_kits', 'module_item_kits_desc', 60, 'item_kits'),
('module_profile', 'module_profile_desc', 110, 'profile'),
('module_receivings', 'module_receivings_desc', 30, 'receivings'),
('module_refunds', 'module_refunds_desc', 30, 'refunds'),
('module_reports', 'module_reports_desc', 100, 'reports'),
('module_sales', 'module_sales_desc', 20, 'sales'),
('module_suppliers', 'module_suppliers_desc', 80, 'suppliers'),
('module_waivers', 'module_waivers_desc', 45, 'waivers');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_people`
--

CREATE TABLE IF NOT EXISTS `ospos_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ospos_people`
--

INSERT INTO `ospos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('John', 'Doe', '', 'admin@pappastech.com', '', '0', 'Nairobi', '0', '', 'Kenya', '0', 1),
('Bob', 'Smith', '585-555-1111', 'bsmith@nowhere.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '11111', 'USA', 'Awesome guy', 2),
('David', 'Gathuku', '0724677872', 'daudithuks@gmail.com', 'P.O. Box 104062', '0', 'Nairobi', '0', '00101', 'Kenya', '0', 3),
('Herp', 'Derp', '', '', '', '0', '', '0', '', '', '0', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_permissions`
--

CREATE TABLE IF NOT EXISTS `ospos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_permissions`
--

INSERT INTO `ospos_permissions` (`module_id`, `person_id`) VALUES
('config', 1),
('customers', 1),
('employees', 1),
('giftcards', 1),
('invoices', 1),
('items', 1),
('item_kits', 1),
('profile', 1),
('refunds', 1),
('reports', 1),
('sales', 1),
('waivers', 1),
('giftcards', 3),
('invoices', 3),
('items', 3),
('item_kits', 3),
('profile', 3),
('sales', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings`
--

CREATE TABLE IF NOT EXISTS `ospos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings_items`
--

CREATE TABLE IF NOT EXISTS `ospos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` int(10) NOT NULL DEFAULT '0',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales`
--

CREATE TABLE IF NOT EXISTS `ospos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ospos_sales`
--

INSERT INTO `ospos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `sale_id`, `payment_type`) VALUES
('2012-09-09 14:12:17', 2, 1, '0', 1, 'Cash: $1750.00<br />'),
('2012-09-09 14:20:49', NULL, 1, '0', 3, 'Gift Card:12345: $1500.00<br />Cash: $250.00<br />'),
('2012-09-09 14:51:48', NULL, 1, '0', 4, 'Cash: $100.00<br />'),
('2012-09-09 17:24:09', NULL, 1, '0', 5, 'Cash: KES1750.00<br />'),
('2012-09-08 21:00:00', 2, 3, '0', 6, 'Cash: KES1000.00<br />Check: KES1100.00<br />'),
('2012-09-09 19:19:19', 2, 3, '0', 7, 'Cash: KES100.00<br />'),
('2012-09-23 08:01:27', 4, 1, '0', 9, 'Cash: KES1500.00<br />'),
('2012-09-23 08:02:04', 2, 1, '0', 10, 'Cash: KES3100.00<br />'),
('2012-09-23 08:03:06', 2, 1, '0', 11, 'Cash: KES2200.00<br />'),
('2012-09-23 08:40:04', 2, 1, '0', 12, 'Gift Card:123456: KES150.00<br />Cash: KES3000.00<br />'),
('2012-09-23 13:12:02', 2, 1, '0', 13, 'Waiver:2: KES1500.00<br />Waiver:1: KES2000.00<br />Cash: KES22000.00<br />');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_sales_items`
--

INSERT INTO `ospos_sales_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`) VALUES
(1, 77, '', '', 1, 1.00, '250.00', 250.00, 0),
(1, 79, '', '', 2, 1.00, '1500.00', 1500.00, 0),
(3, 77, '', '', 1, 1.00, '250.00', 250.00, 0),
(3, 79, '', '', 2, 1.00, '1500.00', 1500.00, 0),
(4, 556, '', '', 1, 1.00, '0.00', 100.00, 0),
(5, 77, '', '', 1, 1.00, '250.00', 250.00, 0),
(5, 79, '', '', 2, 1.00, '1500.00', 1500.00, 0),
(6, 10, '', '2105259805', 3, 1.00, '100.00', 100.00, 0),
(6, 184, '', '', 1, 1.00, '2000.00', 2000.00, 0),
(7, 10, '', '1189653289', 1, 1.00, '100.00', 100.00, 0),
(9, 485, '', '', 1, 1.00, '1500.00', 1500.00, 0),
(10, 41, '', '', 1, 1.00, '100.00', 100.00, 0),
(10, 183, '', '', 2, 1.00, '2000.00', 2000.00, 0),
(10, 406, '0', '', 3, 2.00, '500.00', 500.00, 0),
(11, 262, '', '', 1, 1.00, '200.00', 200.00, 0),
(11, 390, '', '', 2, 1.00, '2000.00', 2000.00, 0),
(12, 448, '', '', 1, 1.00, '3000.00', 3000.00, 0),
(13, 413, '', '', 1, 1.00, '25000.00', 25000.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` double(15,3) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_payments`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_sales_payments`
--

INSERT INTO `ospos_sales_payments` (`sale_id`, `payment_type`, `payment_amount`) VALUES
(1, 'Cash', '1750.00'),
(3, 'Cash', '250.00'),
(3, 'Gift Card:12345', '1500.00'),
(4, 'Cash', '100.00'),
(5, 'Cash', '1750.00'),
(6, 'Cash', '1000.00'),
(6, 'Check', '1100.00'),
(7, 'Cash', '100.00'),
(9, 'Cash', '1500.00'),
(10, 'Cash', '3100.00'),
(11, 'Cash', '2200.00'),
(12, 'Cash', '3000.00'),
(12, 'Gift Card:123456', '150.00'),
(13, 'Cash', '22000.00'),
(13, 'Waiver:1', '2000.00'),
(13, 'Waiver:2', '1500.00');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ospos_sales_suspended`
--

INSERT INTO `ospos_sales_suspended` (`sale_time`, `customer_id`, `employee_id`, `comment`, `sale_id`, `payment_type`) VALUES
('2012-09-09 17:31:06', NULL, 3, '', 4, 'Cash: KES1750.00<br />');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_sales_suspended_items`
--

INSERT INTO `ospos_sales_suspended_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`) VALUES
(4, 77, '', '', 1, 1.00, '250.00', 250.00, 0),
(4, 79, '', '', 2, 1.00, '1500.00', 1500.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` double(15,3) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_payments`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_sales_suspended_payments`
--

INSERT INTO `ospos_sales_suspended_payments` (`sale_id`, `payment_type`, `payment_amount`) VALUES
(4, 'Cash', '1750.00');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sessions`
--

CREATE TABLE IF NOT EXISTS `ospos_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_sessions`
--

INSERT INTO `ospos_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('a9d33065f29e65cf6ad6d5c4a0db907f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', 1348406202, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_suppliers`
--

CREATE TABLE IF NOT EXISTS `ospos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_waivers`
--

CREATE TABLE IF NOT EXISTS `ospos_waivers` (
  `waiver_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `value` double(15,2) NOT NULL,
  `reason` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `waiver_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` int(1) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`waiver_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ospos_waivers`
--

INSERT INTO `ospos_waivers` (`waiver_id`, `customer_id`, `employee_id`, `value`, `reason`, `waiver_date`, `processed`, `deleted`) VALUES
(1, 2, 1, 2000.00, 'this reason', '2012-09-23 11:41:53', 0, 0),
(2, 4, 1, 1500.00, 'what do you want from me', '2012-09-23 11:43:09', 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ospos_customers`
--
ALTER TABLE `ospos_customers`
  ADD CONSTRAINT `ospos_customers_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ospos_employees`
--
ALTER TABLE `ospos_employees`
  ADD CONSTRAINT `ospos_employees_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  ADD CONSTRAINT `ospos_inventory_ibfk_5` FOREIGN KEY (`trans_items`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_inventory_ibfk_6` FOREIGN KEY (`trans_user`) REFERENCES `ospos_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_invoices`
--
ALTER TABLE `ospos_invoices`
  ADD CONSTRAINT `ospos_invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `ospos_customers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_invoices_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_invoices_items`
--
ALTER TABLE `ospos_invoices_items`
  ADD CONSTRAINT `ospos_invoices_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `ospos_invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_invoices_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_item_kit_items`
--
ALTER TABLE `ospos_item_kit_items`
  ADD CONSTRAINT `ospos_item_kit_items_ibfk_3` FOREIGN KEY (`item_kit_id`) REFERENCES `ospos_item_kits` (`item_kit_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_item_kit_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_items`
--
ALTER TABLE `ospos_items`
  ADD CONSTRAINT `ospos_items_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `ospos_suppliers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_items_taxes`
--
ALTER TABLE `ospos_items_taxes`
  ADD CONSTRAINT `ospos_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_permissions`
--
ALTER TABLE `ospos_permissions`
  ADD CONSTRAINT `ospos_permissions_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `ospos_modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_permissions_ibfk_4` FOREIGN KEY (`person_id`) REFERENCES `ospos_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
  ADD CONSTRAINT `ospos_receivings_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `ospos_suppliers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_receivings_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_receivings_items`
--
ALTER TABLE `ospos_receivings_items`
  ADD CONSTRAINT `ospos_receivings_items_ibfk_3` FOREIGN KEY (`receiving_id`) REFERENCES `ospos_receivings` (`receiving_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_receivings_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
  ADD CONSTRAINT `ospos_sales_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `ospos_customers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_sales_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_items`
--
ALTER TABLE `ospos_sales_items`
  ADD CONSTRAINT `ospos_sales_items_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_sales_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_items_taxes`
--
ALTER TABLE `ospos_sales_items_taxes`
  ADD CONSTRAINT `ospos_sales_items_taxes_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_items` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_sales_items_taxes_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_payments`
--
ALTER TABLE `ospos_sales_payments`
  ADD CONSTRAINT `ospos_sales_payments_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
  ADD CONSTRAINT `ospos_sales_suspended_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `ospos_customers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ospos_sales_suspended_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_suspended_items`
--
ALTER TABLE `ospos_sales_suspended_items`
  ADD CONSTRAINT `ospos_sales_suspended_items_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_sales_suspended_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_suspended_items_taxes`
--
ALTER TABLE `ospos_sales_suspended_items_taxes`
  ADD CONSTRAINT `ospos_sales_suspended_items_taxes_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended_items` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ospos_sales_suspended_items_taxes_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ospos_sales_suspended_payments`
--
ALTER TABLE `ospos_sales_suspended_payments`
  ADD CONSTRAINT `ospos_sales_suspended_payments_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ospos_suppliers`
--
ALTER TABLE `ospos_suppliers`
  ADD CONSTRAINT `ospos_suppliers_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
