/*
Navicat MySQL Data Transfer

Source Server         : LOCAL-DB
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : swdinventory

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-02-21 14:02:10
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Cleaning Materials', 'SUPPLIES', '2014-02-17 18:55:37', '2014-02-17 18:55:40');
INSERT INTO `article` VALUES ('2', 'Bond Paper', 'SUPPLIES', '2014-02-18 21:44:29', '2014-02-18 21:44:34');
INSERT INTO `article` VALUES ('3', 'Unknown', null, '2014-02-20 15:24:10', '2014-02-20 15:24:14');

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
-- Records of dept
-- ----------------------------
INSERT INTO `dept` VALUES ('1', 'General Service - DMC', 'GEN. SERVICE -DMC', '2014-02-13 20:37:47');
INSERT INTO `dept` VALUES ('2', 'General Service - ABC', 'GEN. SERVICE - DMC', '2014-02-18 13:00:39');

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
  `ia_article_id` mediumint(8) unsigned DEFAULT NULL,
  `ia_status` varchar(255) DEFAULT NULL,
  `ia_date_inspected` datetime DEFAULT NULL,
  `ia_date_is_verified` tinyint(1) unsigned DEFAULT NULL,
  `ia_date_received` datetime DEFAULT NULL,
  `ia_is_partial` tinyint(1) unsigned DEFAULT NULL,
  `ia_partial_qty` tinyint(4) unsigned DEFAULT NULL,
  `ia_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

-- ----------------------------
-- Records of ia
-- ----------------------------
INSERT INTO `ia` VALUES ('1', '12-893', '17', '244', '3456', '2', '630.00', '1', 'Full Delivery', '2014-02-11 18:35:26', '1', '2014-02-11 18:35:43', '1', '28', '2014-02-11 00:00:00');
INSERT INTO `ia` VALUES ('3', '12-890', '18', '234500', '12345', '1', '10800.00', '1', null, null, null, null, '1', '11', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('4', '12-891', '14', '244', '12345', '1', '1280.00', '1', null, null, null, null, '1', '119', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('5', '12-892', '16', '123456', '76543', '2', '78.00', '1', null, null, null, null, '1', '89', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('6', '19-890', '21', '234500', '3456', '1', '5760.00', '1', null, null, null, null, null, null, '2014-02-18 19:35:38');
INSERT INTO `ia` VALUES ('7', '12-898', '22', '123456', '789', '1', '810.00', '2', null, null, null, null, '1', '3', '2014-02-19 00:00:00');
INSERT INTO `ia` VALUES ('8', '13-389', '24', '234500', '12345', '1', '2500.00', null, null, null, null, null, null, null, '2014-02-20 19:24:23');

-- ----------------------------
-- Table structure for ia_dtl
-- ----------------------------
DROP TABLE IF EXISTS `ia_dtl`;
CREATE TABLE `ia_dtl` (
  `ia_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ia_dtl_ia_id` mediumint(8) DEFAULT NULL,
  `ia_dtl_po_dtl_id` mediumint(8) unsigned NOT NULL,
  `ia_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `ia_dtl_item_cost` decimal(10,2) unsigned NOT NULL,
  `ia_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`ia_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Records of ia_dtl
-- ----------------------------
INSERT INTO `ia_dtl` VALUES ('1', '1', '16', '7', '98.00', '2014-02-12 15:41:40');
INSERT INTO `ia_dtl` VALUES ('2', '2', '17', '10', '0.00', '2014-02-18 12:42:28');
INSERT INTO `ia_dtl` VALUES ('3', '3', '17', '12', '0.00', '2014-02-18 12:56:23');
INSERT INTO `ia_dtl` VALUES ('4', '4', '12', '5', '0.00', '2014-02-18 14:47:01');
INSERT INTO `ia_dtl` VALUES ('5', '4', '13', '10', '0.00', '2014-02-18 14:47:01');
INSERT INTO `ia_dtl` VALUES ('6', '5', '15', '1', '0.00', '2014-02-18 14:53:30');
INSERT INTO `ia_dtl` VALUES ('7', '6', '32', '12', '0.00', '2014-02-18 19:35:38');
INSERT INTO `ia_dtl` VALUES ('8', '6', '33', '12', '0.00', '2014-02-18 19:35:38');
INSERT INTO `ia_dtl` VALUES ('9', '7', '34', '9', '0.00', '2014-02-19 23:06:28');
INSERT INTO `ia_dtl` VALUES ('10', '8', '39', '10', '0.00', '2014-02-20 19:24:23');

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_desc` char(50) NOT NULL,
  `item_unit_measure` char(30) NOT NULL,
  `item_qty` smallint(6) NOT NULL,
  `item_stock_no` char(30) DEFAULT NULL,
  `item_remarks` varchar(100) DEFAULT NULL,
  `item_article_id` varchar(30) NOT NULL,
  `item_created` datetime NOT NULL,
  `item_updated` datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Items';

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('7', 'SAMPLE 1', 'pc', '100', 'M001-001', 'Sample 1', '2', '2014-02-19 14:14:58', '2014-02-19 14:14:58');
INSERT INTO `item` VALUES ('8', 'SAMPLE 2', 'bot', '100', 'M001-002', 'Sample 2', '2', '2014-02-19 14:15:26', '2014-02-19 14:17:52');
INSERT INTO `item` VALUES ('9', 'SAMPLE 3', 'ream', '200', 'M001-003', 'Sample 3', '2', '2014-02-19 14:16:14', '2014-02-19 14:16:14');

-- ----------------------------
-- Table structure for item_cost
-- ----------------------------
DROP TABLE IF EXISTS `item_cost`;
CREATE TABLE `item_cost` (
  `item_cost_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_cost_item_id` mediumint(8) unsigned NOT NULL,
  `item_cost_qty` smallint(5) unsigned NOT NULL,
  `item_cost_unit_cost` decimal(10,2) unsigned NOT NULL,
  `item_cost_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`item_cost_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Item Cost';

-- ----------------------------
-- Records of item_cost
-- ----------------------------
INSERT INTO `item_cost` VALUES ('9', '7', '100', '250.00', '2014-02-19 14:14:58');
INSERT INTO `item_cost` VALUES ('10', '8', '100', '90.00', '2014-02-19 14:15:26');
INSERT INTO `item_cost` VALUES ('11', '9', '200', '20.00', '2014-02-19 14:16:14');

-- ----------------------------
-- Table structure for po
-- ----------------------------
DROP TABLE IF EXISTS `po`;
CREATE TABLE `po` (
  `po_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_supplier_id` mediumint(8) NOT NULL,
  `po_no` varchar(20) NOT NULL,
  `po_proc_mod` varchar(20) NOT NULL,
  `po_deliv_place` varchar(40) NOT NULL,
  `po_deliv_date` date NOT NULL,
  `po_deliv_term` varchar(40) NOT NULL,
  `po_pay_term` varchar(30) NOT NULL,
  `po_total` decimal(10,2) NOT NULL,
  `po_auth_off` varchar(50) NOT NULL,
  `po_req_off` varchar(50) NOT NULL,
  `po_funds_off` varchar(50) NOT NULL,
  `po_amount` decimal(10,2) NOT NULL,
  `po_alobs_no` varchar(25) NOT NULL,
  `po_created` datetime NOT NULL,
  `po_is_furnished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `po_is_cancelled` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- ----------------------------
-- Records of po
-- ----------------------------
INSERT INTO `po` VALUES ('24', '64', '13-382', '13-410', 'Bulihan, Malvar', '2014-02-27', '20 days', '30 days', '12500.00', '', '', '', '0.00', '', '2014-02-20 15:57:48', '0', '1');
INSERT INTO `po` VALUES ('25', '65', '13-383', '13-410', 'Lipa', '2014-02-20', '10 days', '15 days', '420.00', '', '', '', '0.00', '', '2014-02-20 17:13:07', '0', '1');
INSERT INTO `po` VALUES ('26', '66', '13-384', '13-410', 'Lipa', '2014-02-27', '12 days', '15 days', '8208.00', '', '', '', '0.00', '', '2014-02-20 18:31:25', '0', '0');
INSERT INTO `po` VALUES ('27', '65', '13-385', '13-410', 'Lipa', '2014-03-07', '20 days', '15 days', '8010.00', '', '', '', '0.00', '', '2014-02-20 18:49:35', '1', '0');
INSERT INTO `po` VALUES ('28', '64', '13-386', '13-410', 'Bulihan, Malvar', '2014-02-27', '20 days', '30 days', '4050.00', '', '', '', '0.00', '', '2014-02-20 18:59:07', '0', '0');

-- ----------------------------
-- Table structure for po_dtl
-- ----------------------------
DROP TABLE IF EXISTS `po_dtl`;
CREATE TABLE `po_dtl` (
  `po_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_dtl_po_id` mediumint(8) unsigned NOT NULL,
  `po_dtl_item_no` smallint(5) unsigned NOT NULL,
  `po_dtl_item_unit` varchar(30) NOT NULL,
  `po_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `po_dtl_article_id` mediumint(8) unsigned DEFAULT NULL,
  `po_dtl_item_desc` char(50) NOT NULL,
  `po_dtl_item_type` char(10) NOT NULL,
  `po_dtl_item_cost` decimal(10,2) unsigned NOT NULL,
  `po_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`po_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Records of po_dtl
-- ----------------------------
INSERT INTO `po_dtl` VALUES ('39', '24', '1', 'bag', '50', '3', 'Test Item', 'NONSTOCK', '250.00', '2014-02-20 15:57:48');
INSERT INTO `po_dtl` VALUES ('40', '25', '1', 'pc', '12', '1', 'Test Item 1', 'STOCK', '35.00', '2014-02-20 17:13:07');
INSERT INTO `po_dtl` VALUES ('41', '26', '1', 'pc', '90', '2', 'Test Item', 'STOCK', '90.00', '2014-02-20 18:31:25');
INSERT INTO `po_dtl` VALUES ('42', '26', '2', 'box', '9', '1', 'TEST 2', 'STOCK', '12.00', '2014-02-20 18:31:25');
INSERT INTO `po_dtl` VALUES ('43', '27', '1', 'box', '90', '2', 'Testing', 'STOCK', '89.00', '2014-02-20 18:49:35');
INSERT INTO `po_dtl` VALUES ('44', '28', '1', 'bot', '90', '2', 'Item', 'STOCK', '45.00', '2014-02-20 18:59:07');

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
-- Records of series
-- ----------------------------

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `supplier_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(60) DEFAULT NULL,
  `supplier_tel_no` varchar(20) DEFAULT NULL,
  `supplier_created` datetime DEFAULT NULL,
  `supplier_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('64', 'JEMARIELL GENERAL MERCHANDISING', 'By-Pass Rd., Silang, Cavite', '865-3975', '2014-02-20 12:41:57', '2014-02-20 12:41:57');
INSERT INTO `supplier` VALUES ('65', 'ABANES MSDE.', 'Bulihan, Malvar', '', '2014-02-20 17:11:47', '2014-02-20 17:11:47');
INSERT INTO `supplier` VALUES ('66', 'GARRY EQUIPMENTS', 'Bulihan, Malvar', '981-9262', '2014-02-20 18:29:46', '2014-02-20 18:29:46');

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

-- ----------------------------
-- Records of user
-- ----------------------------
