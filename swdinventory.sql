/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_DB
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : swdinventory

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-02-02 14:37:56
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `po_is_furnished` tinyint(1) DEFAULT NULL,
  `po_created` datetime NOT NULL,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- ----------------------------
-- Records of po
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

-- ----------------------------
-- Records of po_dtl
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
