/*
Navicat MySQL Data Transfer

Source Server         : LOCAL-DB
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : swdinventory

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-02-19 16:42:19
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Cleaning Materials', 'SUPPLIES', '2014-02-17 18:55:37', '2014-02-17 18:55:40');
INSERT INTO `article` VALUES ('2', 'Bond Paper', 'SUPPLIES', '2014-02-18 21:44:29', '2014-02-18 21:44:34');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

-- ----------------------------
-- Records of ia
-- ----------------------------
INSERT INTO `ia` VALUES ('1', '12-893', '17', '244', '3456', '2', '630.00', '1', 'Full Delivery', '2014-02-11 18:35:26', '1', '2014-02-11 18:35:43', '1', '28', '2014-02-11 00:00:00');
INSERT INTO `ia` VALUES ('3', '12-890', '18', '234500', '12345', '1', '10800.00', '1', null, null, null, null, '1', '11', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('4', '12-891', '14', '244', '12345', '1', '1280.00', '1', null, null, null, null, '1', '119', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('5', '12-892', '16', '123456', '76543', '2', '78.00', '1', null, null, null, null, '1', '89', '2014-02-18 00:00:00');
INSERT INTO `ia` VALUES ('6', '19-890', '21', '234500', '3456', '1', '5760.00', '1', null, null, null, null, null, null, '2014-02-18 19:35:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

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
  `po_is_furnished` tinyint(1) NOT NULL DEFAULT '0',
  `po_is_ia` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

-- ----------------------------
-- Records of po
-- ----------------------------
INSERT INTO `po` VALUES ('14', '47', '13-386', '13-410', 'Darasa, Tanuan', '2014-02-14', '5 days', '17 days', '12652.00', '', '', '', '0.00', '', '2014-02-18 00:00:00', '0', '0');
INSERT INTO `po` VALUES ('16', '44', '13-384', '13-410', 'Siniloan, Laguna', '2014-02-19', '5 days', '15 days', '7020.00', '', '', '', '0.00', '', '2014-02-07 00:00:00', '0', '0');
INSERT INTO `po` VALUES ('17', '45', '13-388', '13-410', 'Bulihan, Malvar', '2014-02-28', '10 days', '35 days', '13950.00', '', '', '', '0.00', '', '2014-02-11 00:00:00', '0', '1');
INSERT INTO `po` VALUES ('18', '42', '13-382', '13-410', 'Bulihan, Malvar', '2014-02-28', '10 days', '17 days', '20700.00', '', '', '', '0.00', '', '2014-02-11 15:03:16', '0', '0');
INSERT INTO `po` VALUES ('19', '43', '13-386', '13-410', 'Angeles, Pampanga', '2014-02-11', '7 days', '25 days', '4050.00', '', '', '', '0.00', '', '2014-02-11 00:00:00', '0', '0');
INSERT INTO `po` VALUES ('20', '1', '13-802', '12-203', 'Bulihan', '2014-02-19', '12 days', '20 days', '29515.00', '', '', '', '0.00', '', '2014-02-12 00:00:00', '0', '0');
INSERT INTO `po` VALUES ('21', '62', '13-401', '13-410', 'Sample Place', '2014-02-28', '12 days', '25 days', '28800.00', '', '', '', '0.00', '', '2014-02-18 00:00:00', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

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
INSERT INTO `po_dtl` VALUES ('19', '20', '1', 'pc', '30', 'Albatros', '35.00', '2014-02-12 18:46:17');
INSERT INTO `po_dtl` VALUES ('20', '20', '2', 'pc', '20', 'Table Napkin', '100.00', '2014-02-12 18:46:17');
INSERT INTO `po_dtl` VALUES ('21', '20', '3', 'bot', '20', 'Liquid Wax for Tiles', '240.00', '2014-02-17 16:27:21');
INSERT INTO `po_dtl` VALUES ('23', '20', '4', 'box', '30', 'Zonrox', '39.00', '2014-02-17 16:35:53');
INSERT INTO `po_dtl` VALUES ('24', '20', '5', 'bot', '20', 'Baygon Multi Insect Killer', '295.00', '2014-02-17 16:38:03');
INSERT INTO `po_dtl` VALUES ('25', '20', '6', 'bot', '30', 'Axion Dishwashing Liquid', '65.00', '2014-02-17 16:40:13');
INSERT INTO `po_dtl` VALUES ('26', '20', '7', 'bot', '20', 'Pledge', '280.00', '2014-02-17 16:42:23');
INSERT INTO `po_dtl` VALUES ('27', '20', '8', 'kg', '5', 'Rags Round', '65.00', '2014-02-17 16:44:07');
INSERT INTO `po_dtl` VALUES ('28', '20', '9', 'bot', '30', 'Liquid Hand Soap', '80.00', '2014-02-17 16:45:28');
INSERT INTO `po_dtl` VALUES ('29', '20', '10', 'bot', '20', 'Domex', '99.00', '2014-02-17 18:25:59');
INSERT INTO `po_dtl` VALUES ('30', '20', '11', 'bot', '30', 'Joy Diswashing Liquid', '78.00', '2014-02-17 18:27:57');
INSERT INTO `po_dtl` VALUES ('31', '19', '2', 'bot', '20', 'TESTING 2', '240.00', '2014-02-18 19:16:03');
INSERT INTO `po_dtl` VALUES ('32', '21', '1', 'bot', '20', 'Sample Item 1', '240.00', '2014-02-18 19:34:00');
INSERT INTO `po_dtl` VALUES ('33', '21', '2', 'pc', '100', 'HELLO TEST 2', '240.00', '2014-02-18 19:34:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

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
INSERT INTO `supplier` VALUES ('53', 'ANOTHER ONE', 'ANOTHER Address', 'Another Tel No', '2014-01-28 00:29:08', '2014-02-14 17:25:11');
INSERT INTO `supplier` VALUES ('54', 'LAST', 'LAST', '', '2014-01-02 00:32:19', '2014-01-28 20:44:18');
INSERT INTO `supplier` VALUES ('55', 'JEROME MSDE', 'Sabang, Lipa CIty', '981-9262', '2014-02-13 22:41:37', '2014-02-13 22:41:37');
INSERT INTO `supplier` VALUES ('56', 'VIC MSDE', 'Pakil, Laguna', '78977897', '2014-02-13 22:44:42', '2014-02-13 22:44:42');
INSERT INTO `supplier` VALUES ('57', 'MSDE', 'Blah Blah', '981-9262', '2014-02-13 22:59:34', '2014-02-13 22:59:34');
INSERT INTO `supplier` VALUES ('58', 'New One', 'Lipa City', '', '2014-02-13 23:09:38', '2014-02-13 23:09:38');
INSERT INTO `supplier` VALUES ('59', 'QWERTY', 'qwerty', '123123', '2014-02-13 23:15:49', '2014-02-13 23:15:49');
INSERT INTO `supplier` VALUES ('60', 'Test Name', 'Test Address', '', '2014-02-14 17:10:35', '2014-02-14 17:10:35');
INSERT INTO `supplier` VALUES ('61', 'AKA', 'Lodlod, Batangas', '1234567', '2014-02-18 15:41:23', '2014-02-18 15:41:23');
INSERT INTO `supplier` VALUES ('62', 'SAMPLE SUPPLIER', 'SAMPLE SUPPLIER ADDRESS', '1234567', '2014-02-18 18:24:10', '2014-02-18 18:24:10');

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
