/*
Navicat MySQL Data Transfer

Source Server         : LOCAL-DB
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : swdinventory_tmp

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-07-13 12:26:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `article_name` varchar(100) DEFAULT NULL,
  `article_inventory_type` char(8) DEFAULT NULL,
  `article_created` datetime DEFAULT NULL,
  `article_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for dept
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `dept_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT NULL,
  `dept_alias` varchar(255) DEFAULT NULL,
  `dept_created` datetime DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ia
-- ----------------------------
DROP TABLE IF EXISTS `ia`;
CREATE TABLE `ia` (
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
  `ia_inspection` date DEFAULT NULL,
  `ia_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

-- ----------------------------
-- Table structure for ia_dtl
-- ----------------------------
DROP TABLE IF EXISTS `ia_dtl`;
CREATE TABLE `ia_dtl` (
  `ia_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ia_dtl_ia_id` mediumint(8) DEFAULT NULL,
  `ia_dtl_po_dtl_id` mediumint(8) unsigned NOT NULL,
  `ia_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `ia_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`ia_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Table structure for issuance
-- ----------------------------
DROP TABLE IF EXISTS `issuance`;
CREATE TABLE `issuance` (
  `issuance_id` int(11) NOT NULL AUTO_INCREMENT,
  `issuance_no` varchar(255) DEFAULT NULL,
  `issuance_ris_id` int(11) NOT NULL,
  `issuance_charging` varchar(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`issuance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for issuance_dtl
-- ----------------------------
DROP TABLE IF EXISTS `issuance_dtl`;
CREATE TABLE `issuance_dtl` (
  `issuance_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `issuance_dtl_issuance_id` mediumint(8) NOT NULL,
  `issuance_dtl_ris_dtl_id` int(11) NOT NULL,
  `issuance_dtl_item_issued` mediumint(11) NOT NULL,
  `issuance_dtl_item_remarks` text,
  `issuance_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`issuance_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_desc` char(50) NOT NULL,
  `item_size` char(30) DEFAULT NULL,
  `item_unit_measure` char(30) NOT NULL,
  `item_qty` smallint(6) NOT NULL,
  `item_type` varchar(8) NOT NULL,
  `item_acct_no` char(8) DEFAULT NULL,
  `item_stock_no` char(30) DEFAULT NULL,
  `item_remarks` varchar(100) DEFAULT NULL,
  `item_article_id` varchar(30) NOT NULL,
  `item_created` datetime NOT NULL,
  `item_updated` datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Items';

-- ----------------------------
-- Table structure for item_cost
-- ----------------------------
DROP TABLE IF EXISTS `item_cost`;
CREATE TABLE `item_cost` (
  `item_cost_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_cost_item_id` mediumint(8) unsigned NOT NULL,
  `item_cost_qty` smallint(5) unsigned NOT NULL,
  `item_cost_unit_cost` decimal(10,2) unsigned NOT NULL,
  `item_cost_created` datetime DEFAULT NULL,
  `item_cost_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`item_cost_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='Item Cost';

-- ----------------------------
-- Table structure for item_init
-- ----------------------------
DROP TABLE IF EXISTS `item_init`;
CREATE TABLE `item_init` (
  `item_init_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `init_qty` int(11) DEFAULT NULL,
  `init_date` datetime DEFAULT NULL,
  PRIMARY KEY (`item_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for po
-- ----------------------------
DROP TABLE IF EXISTS `po`;
CREATE TABLE `po` (
  `po_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_supplier_id` mediumint(8) NOT NULL,
  `po_no` varchar(20) NOT NULL,
  `po_proc_mod` varchar(20) NOT NULL,
  `po_account_no` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- ----------------------------
-- Table structure for po_dtl
-- ----------------------------
DROP TABLE IF EXISTS `po_dtl`;
CREATE TABLE `po_dtl` (
  `po_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_dtl_po_id` mediumint(8) unsigned NOT NULL,
  `po_dtl_item_no` smallint(5) unsigned NOT NULL,
  `po_dtl_stock_no` varchar(30) NOT NULL,
  `po_dtl_item_unit` varchar(30) NOT NULL,
  `po_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `po_dtl_article_id` mediumint(8) unsigned NOT NULL,
  `po_dtl_item_desc` char(50) NOT NULL,
  `po_dtl_item_size` char(10) NOT NULL,
  `po_dtl_item_type` char(10) NOT NULL,
  `po_dtl_item_cost` decimal(10,2) unsigned NOT NULL,
  `po_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`po_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Table structure for ris
-- ----------------------------
DROP TABLE IF EXISTS `ris`;
CREATE TABLE `ris` (
  `ris_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ris_division` varchar(100) NOT NULL,
  `ris_office` varchar(100) NOT NULL,
  `ris_request` varchar(100) NOT NULL,
  `ris_approval` varchar(100) NOT NULL,
  `ris_issued` varchar(100) NOT NULL,
  `ris_received` varchar(100) NOT NULL,
  `ris_charging` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `ris_rcc` varchar(200) NOT NULL,
  `ris_no` varchar(100) NOT NULL,
  `ris_purpose` text NOT NULL,
  `ris_created` datetime NOT NULL,
  `ris_updated` datetime DEFAULT NULL,
  `ris_is_issued` tinyint(1) DEFAULT '0',
  `ris_is_cancelled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ris_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ris_dtl
-- ----------------------------
DROP TABLE IF EXISTS `ris_dtl`;
CREATE TABLE `ris_dtl` (
  `ris_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ris_dtl_ris_id` mediumint(8) DEFAULT NULL,
  `ris_dtl_item_acct_no` mediumint(9) DEFAULT NULL,
  `ris_dtl_item_stock_no` varchar(255) DEFAULT NULL,
  `ris_dtl_item_no` int(11) DEFAULT NULL,
  `ris_dtl_item_desc` varchar(100) NOT NULL,
  `ris_dtl_item_size` varchar(10) DEFAULT NULL,
  `ris_dtl_item_qty` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_unit` varchar(10) DEFAULT NULL,
  `ris_dl_item_qty` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_issued` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_remarks` text,
  `ris_dtl_item_created` datetime NOT NULL,
  `ris_dtl_item_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`ris_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Table structure for series
-- ----------------------------
DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `series_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `series_name` varchar(50) DEFAULT NULL,
  `series_created` datetime DEFAULT NULL,
  PRIMARY KEY (`series_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for signatories
-- ----------------------------
DROP TABLE IF EXISTS `signatories`;
CREATE TABLE `signatories` (
  `signatories_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` enum('PO','IA','RIS','RMS') DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL COMMENT 'inspection o accpetance pag wala edi null',
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`signatories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_position` varchar(255) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `staff_id_no` int(11) DEFAULT NULL,
  `staff_created` datetime DEFAULT NULL,
  `staff_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `supplier_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(60) DEFAULT NULL,
  `supplier_tel_no` varchar(20) DEFAULT NULL,
  `supplier_vat` varchar(8) DEFAULT NULL,
  `supplier_tin` varchar(30) DEFAULT NULL,
  `supplier_created` datetime DEFAULT NULL,
  `supplier_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_first` varchar(50) NOT NULL,
  `user_middle` varchar(50) NOT NULL,
  `user_last` varchar(50) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_created` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
