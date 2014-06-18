-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.34 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for swdinventory
CREATE DATABASE IF NOT EXISTS `swdinventory` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `swdinventory`;


-- Dumping structure for table swdinventory.article
CREATE TABLE IF NOT EXISTS `article` (
  `article_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `article_name` varchar(100) DEFAULT NULL,
  `article_inventory_type` char(8) DEFAULT NULL,
  `article_created` datetime DEFAULT NULL,
  `article_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table swdinventory.article: ~7 rows (approximately)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`article_id`, `article_name`, `article_inventory_type`, `article_created`, `article_updated`) VALUES
	(1, 'Cleaning Materials', 'SUPPLIES', '2014-02-17 18:55:37', '2014-02-17 18:55:40'),
	(2, 'Bond Papers', 'SUPPLIES', '2014-02-18 21:44:29', '2014-02-21 18:30:18'),
	(5, 'Bolts and Nuts', 'MATERIAL', '2014-02-21 19:09:25', '2014-02-21 19:09:25'),
	(6, 'Blade', 'MATERIAL', '2014-02-21 19:09:54', '2014-02-21 19:09:54'),
	(7, 'Stapler', 'SUPPLIES', '2014-02-21 19:10:25', '2014-02-21 19:10:25'),
	(8, 'Staple Wire', 'SUPPLIES', '2014-02-21 19:15:14', '2014-02-21 19:15:14'),
	(9, 'Office Supplies', 'SUPPLIES', '2014-03-31 23:28:23', '2014-03-31 23:28:23');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;


-- Dumping structure for table swdinventory.dept
CREATE TABLE IF NOT EXISTS `dept` (
  `dept_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT NULL,
  `dept_alias` varchar(255) DEFAULT NULL,
  `dept_created` datetime DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table swdinventory.dept: ~2 rows (approximately)
/*!40000 ALTER TABLE `dept` DISABLE KEYS */;
INSERT INTO `dept` (`dept_id`, `dept_name`, `dept_alias`, `dept_created`) VALUES
	(1, 'General Service - DMC', 'GEN. SERVICE -DMC', '2014-02-13 20:37:47'),
	(2, 'General Service - ABC', 'GEN. SERVICE - DMC', '2014-02-18 13:00:39');
/*!40000 ALTER TABLE `dept` ENABLE KEYS */;


-- Dumping structure for table swdinventory.ia
CREATE TABLE IF NOT EXISTS `ia` (
  `ia_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `ia_no` varchar(10) DEFAULT NULL,
  `ia_po_id` mediumint(8) DEFAULT NULL,
  `ia_inv_no` varchar(50) DEFAULT NULL,
  `ia_dr_no` varchar(50) DEFAULT NULL,
  `ia_dept_id` mediumint(8) unsigned DEFAULT NULL,
  `ia_total_amount` decimal(10,2) DEFAULT NULL,
  `ia_status` varchar(255) DEFAULT NULL,
  `ia_date_inspected` datetime DEFAULT NULL,
  `ia_date_is_verified` tinyint(1) unsigned DEFAULT NULL,
  `ia_date_received` datetime DEFAULT NULL,
  `ia_is_partial` tinyint(1) unsigned DEFAULT NULL,
  `ia_partial_qty` tinyint(4) unsigned DEFAULT NULL,
  `ia_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

-- Dumping data for table swdinventory.ia: ~5 rows (approximately)
/*!40000 ALTER TABLE `ia` DISABLE KEYS */;
INSERT INTO `ia` (`ia_id`, `ia_no`, `ia_po_id`, `ia_inv_no`, `ia_dr_no`, `ia_dept_id`, `ia_total_amount`, `ia_status`, `ia_date_inspected`, `ia_date_is_verified`, `ia_date_received`, `ia_is_partial`, `ia_partial_qty`, `ia_created`) VALUES
	(126, '12-890', 30, '234500', '12345', 1, 132.00, NULL, NULL, NULL, NULL, 1, 1, '2014-02-24 23:06:56'),
	(127, '12-891', 30, '234500', '12345', 1, 12.00, NULL, NULL, NULL, NULL, 1, 11, '2014-02-24 23:07:59'),
	(128, '12-891', 31, '234500', '12345', 1, 1065.00, NULL, NULL, NULL, NULL, 1, 28, '2014-02-24 23:12:49'),
	(129, '12-891', 31, '234500', '12345', 1, 4860.00, NULL, NULL, NULL, NULL, 1, 4, '2014-02-24 23:31:55'),
	(130, '123546', 33, 'Test', '123456', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2014-06-15 10:18:28');
/*!40000 ALTER TABLE `ia` ENABLE KEYS */;


-- Dumping structure for table swdinventory.ia_dtl
CREATE TABLE IF NOT EXISTS `ia_dtl` (
  `ia_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ia_dtl_ia_id` mediumint(8) DEFAULT NULL,
  `ia_dtl_po_dtl_id` mediumint(8) unsigned NOT NULL,
  `ia_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `ia_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`ia_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- Dumping data for table swdinventory.ia_dtl: ~7 rows (approximately)
/*!40000 ALTER TABLE `ia_dtl` DISABLE KEYS */;
INSERT INTO `ia_dtl` (`ia_dtl_id`, `ia_dtl_ia_id`, `ia_dtl_po_dtl_id`, `ia_dtl_item_qty`, `ia_dtl_item_created`) VALUES
	(142, 126, 47, 11, '2014-02-24 23:06:56'),
	(143, 127, 47, 1, '2014-02-24 23:07:59'),
	(144, 128, 48, 5, '2014-02-24 23:12:49'),
	(145, 128, 49, 5, '2014-02-24 23:12:49'),
	(146, 129, 48, 30, '2014-02-24 23:31:55'),
	(147, 129, 49, 13, '2014-02-24 23:31:55'),
	(148, 130, 51, 0, '2014-06-15 10:18:28');
/*!40000 ALTER TABLE `ia_dtl` ENABLE KEYS */;


-- Dumping structure for table swdinventory.item
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_desc` char(50) NOT NULL,
  `item_unit_measure` char(30) NOT NULL,
  `item_qty` smallint(6) NOT NULL,
  `item_type` varchar(8) NOT NULL,
  `item_stock_no` char(30) DEFAULT NULL,
  `item_remarks` varchar(100) DEFAULT NULL,
  `item_article_id` varchar(30) NOT NULL,
  `item_created` datetime NOT NULL,
  `item_updated` datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Items';

-- Dumping data for table swdinventory.item: ~13 rows (approximately)
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`item_id`, `item_desc`, `item_unit_measure`, `item_qty`, `item_type`, `item_stock_no`, `item_remarks`, `item_article_id`, `item_created`, `item_updated`) VALUES
	(7, 'SAMPLE 1', 'pc', 100, '', '4809010524485', ' ', '2', '2014-02-19 14:14:58', '2014-03-15 23:19:38'),
	(8, 'SAMPLE 2', 'bot', 100, '', 'M001-002', 'Sample 2', '2', '2014-02-19 14:15:26', '2014-02-19 14:17:52'),
	(9, 'SAMPLE 3', 'ream', 200, '', 'M001-003', 'Sample 3', '2', '2014-02-19 14:16:14', '2014-02-19 14:16:14'),
	(12, 'Test Item', 'pc', 300, 'STOCK', NULL, NULL, '2', '2014-02-24 21:57:21', '2014-02-24 22:54:54'),
	(13, 'TEST 2', 'box', 138, 'STOCK', NULL, NULL, '1', '2014-02-24 21:57:22', '2014-02-24 22:54:54'),
	(14, 'SAMPLE 1', 'pc', 33, 'STOCK', NULL, NULL, '6', '2014-02-24 23:02:10', '2014-02-24 23:07:59'),
	(15, 'SAMPLE 2', 'bot', 17, 'STOCK', NULL, NULL, '5', '2014-02-24 23:02:10', '2014-02-24 23:02:10'),
	(16, 'SAMPLE 3', 'pc', 51, 'STOCK', NULL, NULL, '6', '2014-02-24 23:12:49', '2014-02-24 23:31:55'),
	(17, 'SAMPLE5', 'pc', 30, 'STOCK', NULL, NULL, '5', '2014-02-24 23:12:49', '2014-02-24 23:31:55'),
	(18, 'THAT\'S CDR 700MB 10 disc', 'box', 1, 'STOCK', '4906915504472', NULL, '9', '2014-03-31 23:29:52', '2014-03-31 23:29:52'),
	(19, 'Best Foods Mayo Magic', 'bottle', 1, '', '4808680023854', 'Mayo', '9', '2014-04-05 15:09:59', '2014-04-05 15:09:59'),
	(20, 'Desc', 'pcs', 1, '', NULL, NULL, '6', '2014-06-15 10:18:28', '2014-06-15 10:18:28'),
	(21, 'Desc', 'box', 1, '', '123123123', 'Remarks', '6', '2014-06-15 12:08:32', '2014-06-15 12:08:32');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;


-- Dumping structure for table swdinventory.item_cost
CREATE TABLE IF NOT EXISTS `item_cost` (
  `item_cost_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_cost_item_id` mediumint(8) unsigned NOT NULL,
  `item_cost_qty` smallint(5) unsigned NOT NULL,
  `item_cost_unit_cost` decimal(10,2) unsigned NOT NULL,
  `item_cost_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`item_cost_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Item Cost';

-- Dumping data for table swdinventory.item_cost: ~6 rows (approximately)
/*!40000 ALTER TABLE `item_cost` DISABLE KEYS */;
INSERT INTO `item_cost` (`item_cost_id`, `item_cost_item_id`, `item_cost_qty`, `item_cost_unit_cost`, `item_cost_updated`) VALUES
	(9, 7, 100, 250.00, '2014-02-19 14:14:58'),
	(10, 8, 100, 90.00, '2014-02-19 14:15:26'),
	(11, 9, 200, 20.00, '2014-02-19 14:16:14'),
	(12, 18, 1, 250.00, '2014-03-31 23:29:52'),
	(13, 19, 1, 10.00, '2014-04-05 15:09:59'),
	(14, 21, 1, 10.00, '2014-06-15 12:08:32');
/*!40000 ALTER TABLE `item_cost` ENABLE KEYS */;


-- Dumping structure for table swdinventory.po
CREATE TABLE IF NOT EXISTS `po` (
  `po_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_supplier_id` mediumint(8) NOT NULL,
  `po_no` varchar(20) NOT NULL,
  `po_proc_mod` varchar(20) NOT NULL,
  `po_deliv_place` varchar(40) NOT NULL,
  `po_deliv_date` date NOT NULL,
  `po_deliv_term` varchar(40) NOT NULL,
  `po_pay_term` varchar(30) NOT NULL,
  `po_total` decimal(10,2) NOT NULL,
  `po_purpose` text,
  `po_conforme` varchar(60) DEFAULT NULL,
  `po_available_fund` decimal(10,2) NOT NULL,
  `po_auth_off` varchar(60) NOT NULL,
  `po_req_off` varchar(60) NOT NULL,
  `po_funds_off` varchar(60) NOT NULL,
  `po_amount` decimal(10,2) NOT NULL,
  `po_alobs_no` varchar(25) NOT NULL,
  `po_created` datetime NOT NULL,
  `po_is_furnished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `po_is_cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- Dumping data for table swdinventory.po: ~4 rows (approximately)
/*!40000 ALTER TABLE `po` DISABLE KEYS */;
INSERT INTO `po` (`po_id`, `po_supplier_id`, `po_no`, `po_proc_mod`, `po_deliv_place`, `po_deliv_date`, `po_deliv_term`, `po_pay_term`, `po_total`, `po_purpose`, `po_conforme`, `po_available_fund`, `po_auth_off`, `po_req_off`, `po_funds_off`, `po_amount`, `po_alobs_no`, `po_created`, `po_is_furnished`, `po_is_cancelled`) VALUES
	(30, 64, '13-382', '13-410', 'Pasong Tamo, Taguig', '2014-02-27', '20 days', '15 days', 144.00, NULL, NULL, 0.00, '', '', '', 0.00, '', '2014-02-24 23:06:02', 1, 0),
	(31, 66, '13-384', '13-410', 'Bulihan, Malvar', '2014-02-20', '20 days', '15 days', 4113.00, NULL, NULL, 0.00, '', '', '', 0.00, '', '2014-02-24 23:11:16', 1, 0),
	(32, 64, '13-385', '13-410', 'Lipa', '2014-02-20', '20 days', '15 days', 1080.00, 'PURPOSE', 'CONFORME', 1000.00, 'OFF', 'AUTH', 'ACCOUNT', 0.00, '', '2014-03-09 22:24:21', 0, 0),
	(33, 64, '12345', '54321', 'Lipa', '2014-05-07', '3 days', 'Monthly', 12.00, 'Test', 'Conforme', 1000.00, 'Official', 'Requisition', 'Accountant', 0.00, '', '2014-05-01 08:44:14', 0, 1);
/*!40000 ALTER TABLE `po` ENABLE KEYS */;


-- Dumping structure for table swdinventory.po_dtl
CREATE TABLE IF NOT EXISTS `po_dtl` (
  `po_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_dtl_po_id` mediumint(8) unsigned NOT NULL,
  `po_dtl_item_no` smallint(5) unsigned NOT NULL,
  `po_dtl_stock_no` varchar(30) DEFAULT NULL,
  `po_dtl_item_unit` varchar(30) NOT NULL,
  `po_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `po_dtl_article_id` mediumint(8) unsigned DEFAULT NULL,
  `po_dtl_item_desc` char(50) NOT NULL,
  `po_dtl_item_type` char(10) NOT NULL,
  `po_dtl_item_cost` decimal(10,2) unsigned NOT NULL,
  `po_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`po_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- Dumping data for table swdinventory.po_dtl: ~5 rows (approximately)
/*!40000 ALTER TABLE `po_dtl` DISABLE KEYS */;
INSERT INTO `po_dtl` (`po_dtl_id`, `po_dtl_po_id`, `po_dtl_item_no`, `po_dtl_stock_no`, `po_dtl_item_unit`, `po_dtl_item_qty`, `po_dtl_article_id`, `po_dtl_item_desc`, `po_dtl_item_type`, `po_dtl_item_cost`, `po_dtl_item_created`) VALUES
	(47, 30, 1, NULL, 'pc', 12, 6, 'SAMPLE 1', 'STOCK', 12.00, '2014-02-24 23:06:02'),
	(48, 31, 1, NULL, 'pc', 21, 6, 'SAMPLE 3', 'STOCK', 123.00, '2014-02-24 23:11:16'),
	(49, 31, 2, NULL, 'pc', 17, 5, 'SAMPLE5', 'STOCK', 90.00, '2014-02-24 23:11:16'),
	(50, 32, 1, NULL, 'pc', 12, 6, 'Desc', 'STOCK', 90.00, '2014-03-09 22:24:21'),
	(51, 33, 1, '12-3424234', 'pcs', 1, 6, 'Desc', 'STOCK', 12.00, '2014-05-01 08:44:14');
/*!40000 ALTER TABLE `po_dtl` ENABLE KEYS */;


-- Dumping structure for table swdinventory.ris
CREATE TABLE IF NOT EXISTS `ris` (
  `ris_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ris_division` varchar(100) NOT NULL,
  `ris_office` varchar(100) NOT NULL,
  `ris_rcc` varchar(200) NOT NULL,
  `ris_no` varchar(100) NOT NULL,
  `ris_purpose` text NOT NULL,
  `ris_created` datetime NOT NULL,
  `ris_updated` datetime DEFAULT NULL,
  `ris_is_issued` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ris_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table swdinventory.ris: ~2 rows (approximately)
/*!40000 ALTER TABLE `ris` DISABLE KEYS */;
INSERT INTO `ris` (`ris_id`, `ris_division`, `ris_office`, `ris_rcc`, `ris_no`, `ris_purpose`, `ris_created`, `ris_updated`, `ris_is_issued`) VALUES
	(1, 'DIV', 'OFF', 'RCC', '90-890', 'PURPOSE', '2014-03-15 17:03:21', NULL, 1),
	(2, 'DIV', 'OFF', 'RCC', 'RISNO', 'Purpose', '2014-04-05 15:20:47', NULL, 0);
/*!40000 ALTER TABLE `ris` ENABLE KEYS */;


-- Dumping structure for table swdinventory.ris_dtl
CREATE TABLE IF NOT EXISTS `ris_dtl` (
  `ris_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ris_dtl_ris_id` mediumint(8) DEFAULT NULL,
  `ris_dtl_item_no` mediumint(9) DEFAULT NULL,
  `ris_dtl_item_stock_no` varchar(255) DEFAULT NULL,
  `ris_dtl_item_desc` varchar(100) NOT NULL,
  `ris_dtl_item_qty` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_unit` varchar(10) DEFAULT NULL,
  `ris_dl_item_qty` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_issued` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_remarks` text,
  `ris_dtl_item_created` datetime NOT NULL,
  `ris_dtl_item_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`ris_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- Dumping data for table swdinventory.ris_dtl: ~6 rows (approximately)
/*!40000 ALTER TABLE `ris_dtl` DISABLE KEYS */;
INSERT INTO `ris_dtl` (`ris_dtl_id`, `ris_dtl_ris_id`, `ris_dtl_item_no`, `ris_dtl_item_stock_no`, `ris_dtl_item_desc`, `ris_dtl_item_qty`, `ris_dtl_item_unit`, `ris_dl_item_qty`, `ris_dtl_item_issued`, `ris_dtl_item_remarks`, `ris_dtl_item_created`, `ris_dtl_item_updated`) VALUES
	(142, 126, NULL, NULL, '11', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:06:56', NULL),
	(143, 127, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:07:59', NULL),
	(144, 128, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:12:49', NULL),
	(145, 128, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:12:49', NULL),
	(146, 129, NULL, NULL, '30', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:31:55', NULL),
	(147, 129, NULL, NULL, '13', NULL, NULL, NULL, NULL, NULL, '2014-02-24 23:31:55', NULL);
/*!40000 ALTER TABLE `ris_dtl` ENABLE KEYS */;


-- Dumping structure for table swdinventory.series
CREATE TABLE IF NOT EXISTS `series` (
  `series_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `series_name` varchar(50) DEFAULT NULL,
  `series_created` datetime DEFAULT NULL,
  PRIMARY KEY (`series_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table swdinventory.series: ~0 rows (approximately)
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
/*!40000 ALTER TABLE `series` ENABLE KEYS */;


-- Dumping structure for table swdinventory.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(60) DEFAULT NULL,
  `supplier_tel_no` varchar(20) DEFAULT NULL,
  `supplier_created` datetime DEFAULT NULL,
  `supplier_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

-- Dumping data for table swdinventory.supplier: ~3 rows (approximately)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_address`, `supplier_tel_no`, `supplier_created`, `supplier_updated`) VALUES
	(64, 'JEMARIELL GENERAL MERCHANDISING', 'By-Pass Rd., Silang, Cavite', '865-3975', '2014-02-20 12:41:57', '2014-02-20 12:41:57'),
	(65, 'ABANES MSDE.', 'Bulihan, Malvar', '', '2014-02-20 17:11:47', '2014-02-20 17:11:47'),
	(66, 'GARRY EQUIPMENTS', 'Bulihan, Malvar', '981-9262', '2014-02-20 18:29:46', '2014-02-20 18:29:46');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;


-- Dumping structure for table swdinventory.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_first` varchar(50) NOT NULL,
  `user_middle` varchar(50) NOT NULL,
  `user_last` varchar(50) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_created` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table swdinventory.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
swdinventoryitem