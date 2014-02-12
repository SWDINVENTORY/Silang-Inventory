/*
Navicat MySQL Data Transfer

Source Server         : LOCAL-DB
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : swdinventory

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-02-12 16:45:42
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `ia_req_dept_id` mediumint(8) DEFAULT NULL,
  `ia_total_amount` decimal(10,2) DEFAULT NULL,
  `ia_status` varchar(255) DEFAULT NULL,
  `ia_date_inspected` datetime DEFAULT NULL,
  `ia_date_is_verified` tinyint(1) DEFAULT NULL,
  `ia_date_received` datetime DEFAULT NULL,
  `ia_is_partial` tinyint(1) DEFAULT NULL,
  `ia_is_partial_qty` tinyint(4) DEFAULT NULL,
  `ia_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

-- ----------------------------
-- Records of ia
-- ----------------------------
INSERT INTO `ia` VALUES ('1', '13-389', '17', '000244/000245', null, '2', '1320.00', 'Full Delivery', '2014-02-11 18:35:26', '1', '2014-02-11 18:35:43', '1', '23', '2014-02-11 18:36:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Records of ia_dtl
-- ----------------------------
INSERT INTO `ia_dtl` VALUES ('1', '1', '16', '7', '98.00', '2014-02-12 15:41:40');

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
  `item_item_type` mediumint(8) NOT NULL,
  `item_supplier_id` mediumint(8) unsigned DEFAULT NULL,
  `item_article` varchar(30) NOT NULL,
  `item_created` datetime NOT NULL,
  `item_updated` datetime NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_supplier` (`item_supplier_id`),
  CONSTRAINT `item_supplier` FOREIGN KEY (`item_supplier_id`) REFERENCES `supplier` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Items';

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', 'Short s20', 'ream', '12', 'M001-001', 'Bond Paper Short', '0', '1', 'BOND PAPER', '2014-01-21 21:04:54', '2014-01-21 21:04:54');
INSERT INTO `item` VALUES ('2', 'Long s20', 'ream', '12', 'M001-002', 'Bond Paper Long', '1', null, 'BOND PAPER', '2014-01-21 23:00:22', '2014-01-26 22:43:29');

-- ----------------------------
-- Table structure for item_cost
-- ----------------------------
DROP TABLE IF EXISTS `item_cost`;
CREATE TABLE `item_cost` (
  `item_cost_id` mediumint(8) unsigned NOT NULL,
  `item_cost_item_id` mediumint(8) unsigned NOT NULL,
  `item_cost_qty` smallint(5) unsigned NOT NULL,
  `item_cost_unit_cost` decimal(10,2) unsigned NOT NULL,
  `item_cost_updated` datetime NOT NULL,
  PRIMARY KEY (`item_cost_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Item Cost';

-- ----------------------------
-- Records of item_cost
-- ----------------------------

-- ----------------------------
-- Table structure for item_type
-- ----------------------------
DROP TABLE IF EXISTS `item_type`;
CREATE TABLE `item_type` (
  `item_type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_type_name` varchar(30) NOT NULL,
  `item_type_created` datetime NOT NULL,
  PRIMARY KEY (`item_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Item Types';

-- ----------------------------
-- Records of item_type
-- ----------------------------

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
  `po_is_furnished` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- ----------------------------
-- Records of po
-- ----------------------------
INSERT INTO `po` VALUES ('12', '1', '13-382', '13-410', 'Lipa', '2014-02-14', '7 days', '15 days', '4880.00', '', '', '', '0.00', '', '2014-02-06 00:00:00', '0');
INSERT INTO `po` VALUES ('14', '47', '13-386', '13-410', 'Darasa, Tanuan', '2014-02-14', '5 days', '17 days', '12652.00', '', '', '', '0.00', '', '2014-02-18 00:00:00', '0');
INSERT INTO `po` VALUES ('16', '44', '13-384', '13-410', 'Siniloan, Laguna', '2014-02-19', '5 days', '15 days', '7020.00', '', '', '', '0.00', '', '2014-02-07 00:00:00', '0');
INSERT INTO `po` VALUES ('17', '45', '13-388', '13-410', 'Bulihan, Malvar', '2014-02-28', '10 days', '35 days', '13950.00', '', '', '', '0.00', '', '2014-02-11 00:00:00', '0');
INSERT INTO `po` VALUES ('18', '42', '13-382', '13-410', 'Bulihan, Malvar', '2014-02-28', '10 days', '17 days', '20700.00', '', '', '', '0.00', '', '2014-02-11 15:03:16', '0');
INSERT INTO `po` VALUES ('19', '43', '13-386', '13-410', 'Angeles, Pampanga', '2014-02-11', '7 days', '25 days', '10080.00', '', '', '', '0.00', '', '2014-02-11 00:00:00', '0');

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
  `po_dtl_item_desc` char(50) NOT NULL,
  `po_dtl_item_cost` decimal(10,2) unsigned NOT NULL,
  `po_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`po_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Records of po_dtl
-- ----------------------------
INSERT INTO `po_dtl` VALUES ('1', '6', '1', 'bag', '50', 'Rod', '228.50', '2014-01-27 16:10:14');
INSERT INTO `po_dtl` VALUES ('2', '7', '1', 'bag', '50', 'Rod', '228.50', '2014-01-27 17:40:39');
INSERT INTO `po_dtl` VALUES ('3', '8', '1', 'bag', '50', 'Rod', '228.50', '2014-01-27 17:43:42');
INSERT INTO `po_dtl` VALUES ('4', '9', '1', 'bag', '50', 'Rod', '228.50', '2014-01-27 18:38:52');
INSERT INTO `po_dtl` VALUES ('5', '10', '1', 'pc/s', '1', 'TEST', '34.00', '2014-02-06 14:48:07');
INSERT INTO `po_dtl` VALUES ('6', '11', '1', 'pc/s', '23', 'ANOTHER', '12.00', '2014-02-06 17:00:15');
INSERT INTO `po_dtl` VALUES ('7', '12', '1', 'pc/s', '100', 'TEST', '12.00', '2014-02-06 17:16:00');
INSERT INTO `po_dtl` VALUES ('8', '12', '2', 'kg', '20', 'TEST 1', '130.00', '2014-02-06 17:16:00');
INSERT INTO `po_dtl` VALUES ('9', '12', '3', 'c/m 3', '12', 'TEST 2', '90.00', '2014-02-06 17:16:00');
INSERT INTO `po_dtl` VALUES ('10', '13', '1', 'pc/s', '126', 'TRIAL', '89.00', '2014-02-06 17:17:44');
INSERT INTO `po_dtl` VALUES ('11', '13', '2', 'kg', '90', 'TRIAL 2', '34.00', '2014-02-06 17:17:45');
INSERT INTO `po_dtl` VALUES ('12', '14', '1', 'pc/s', '100', 'TESTING', '100.00', '2014-02-06 21:52:52');
INSERT INTO `po_dtl` VALUES ('13', '14', '2', 'kg', '34', 'TESTING 2', '78.00', '2014-02-06 21:52:53');
INSERT INTO `po_dtl` VALUES ('14', '15', '1', 'kg', '12', 'TEST', '90.00', '2014-02-07 00:30:30');
INSERT INTO `po_dtl` VALUES ('15', '16', '1', 'g', '90', 'WEW', '78.00', '2014-02-07 14:25:43');
INSERT INTO `po_dtl` VALUES ('16', '17', '1', 'pc/s', '35', 'HELLO TEST', '90.00', '2014-02-11 15:00:14');
INSERT INTO `po_dtl` VALUES ('17', '18', '1', 'g', '23', 'ME', '900.00', '2014-02-11 15:03:16');
INSERT INTO `po_dtl` VALUES ('18', '19', '1', 'box', '45', 'TESTING', '90.00', '2014-02-11 21:50:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('1', 'JEMARIELL GENERAL MERCHANDISING', 'By-Pass Rd., Silang, Cavite', '', '2014-01-18 09:58:56', '2014-01-18 09:58:56');
INSERT INTO `supplier` VALUES ('41', 'CHARLES SANTIAGO SUPPLIES', 'Mataas Na Kahoy, Batangas', '', '2014-01-21 18:35:22', '2014-01-28 20:43:31');
INSERT INTO `supplier` VALUES ('42', 'GARRY EQUIPMENTS', 'Malvar, Batangas', '', '2014-01-21 18:36:13', '2014-01-21 18:36:13');
INSERT INTO `supplier` VALUES ('43', 'VIC PLUMBINGS', 'Famy, Laguna', '', '2014-01-21 18:45:54', '2014-01-21 18:45:54');
INSERT INTO `supplier` VALUES ('44', 'NELLY PIPES', 'Albay, Legaspi', '', '2014-01-21 20:22:26', '2014-01-21 20:22:26');
INSERT INTO `supplier` VALUES ('45', 'UTO PRODUCTS', 'Bolbok, Batangas', '', '2014-01-23 23:26:57', '2014-01-24 00:02:50');
INSERT INTO `supplier` VALUES ('46', 'NIKOS', 'Mataas Na Kahoy, Batangas', '', '2014-01-24 16:01:02', '2014-01-24 16:01:02');
INSERT INTO `supplier` VALUES ('47', 'LYNEL\'S MERCHANDISE', 'Bolbok, Batangas', '', '2014-01-26 15:12:48', '2014-01-26 15:12:48');
INSERT INTO `supplier` VALUES ('52', 'TEST', 'Test, Test', '', '2014-01-27 23:10:46', '2014-01-28 20:44:48');
INSERT INTO `supplier` VALUES ('53', 'ANOTHER', 'ANOTHER', '', '2014-01-28 00:29:08', '2014-01-28 20:43:58');
INSERT INTO `supplier` VALUES ('54', 'LAST', 'LAST', '', '2014-01-02 00:32:19', '2014-01-28 20:44:18');

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
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
