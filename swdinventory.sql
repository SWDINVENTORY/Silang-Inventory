/*
SQLyog Ultimate v9.10 
MySQL - 5.6.14 : Database - swdinventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`swdinventory` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `swdinventory`;

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `article_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `article_name` varchar(100) DEFAULT NULL,
  `article_inventory_type` char(8) DEFAULT NULL,
  `article_created` datetime DEFAULT NULL,
  `article_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `article` */

insert  into `article`(`article_id`,`article_name`,`article_inventory_type`,`article_created`,`article_updated`) values (1,'Cleaning Materials','SUPPLIES','2014-02-17 18:55:37','2014-02-17 18:55:40'),(2,'Bond Papers','SUPPLIES','2014-02-18 21:44:29','2014-02-21 18:30:18'),(5,'Bolts and Nuts','MATERIAL','2014-02-21 19:09:25','2014-02-21 19:09:25'),(6,'Blade','MATERIAL','2014-02-21 19:09:54','2014-02-21 19:09:54'),(7,'Stapler','SUPPLIES','2014-02-21 19:10:25','2014-02-21 19:10:25'),(8,'Staple Wire','SUPPLIES','2014-02-21 19:15:14','2014-02-21 19:15:14');

/*Table structure for table `dept` */

DROP TABLE IF EXISTS `dept`;

CREATE TABLE `dept` (
  `dept_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT NULL,
  `dept_alias` varchar(255) DEFAULT NULL,
  `dept_created` datetime DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `dept` */

insert  into `dept`(`dept_id`,`dept_name`,`dept_alias`,`dept_created`) values (1,'General Service - DMC','GEN. SERVICE -DMC','2014-02-13 20:37:47'),(2,'General Service - ABC','GEN. SERVICE - DMC','2014-02-18 13:00:39');

/*Table structure for table `ia` */

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
  `ia_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1 COMMENT='Inspection / Acceptance\r\n';

/*Data for the table `ia` */

insert  into `ia`(`ia_id`,`ia_no`,`ia_po_id`,`ia_inv_no`,`ia_dr_no`,`ia_dept_id`,`ia_total_amount`,`ia_status`,`ia_date_inspected`,`ia_date_is_verified`,`ia_date_received`,`ia_is_partial`,`ia_partial_qty`,`ia_created`) values (126,'12-890',30,'234500','12345',1,'132.00',NULL,NULL,NULL,NULL,1,1,'2014-02-24 23:06:56'),(127,'12-891',30,'234500','12345',1,'12.00',NULL,NULL,NULL,NULL,1,11,'2014-02-24 23:07:59'),(128,'12-891',31,'234500','12345',1,'1065.00',NULL,NULL,NULL,NULL,1,28,'2014-02-24 23:12:49'),(129,'12-891',31,'234500','12345',1,'4860.00',NULL,NULL,NULL,NULL,1,4,'2014-02-24 23:31:55');

/*Table structure for table `ia_dtl` */

DROP TABLE IF EXISTS `ia_dtl`;

CREATE TABLE `ia_dtl` (
  `ia_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ia_dtl_ia_id` mediumint(8) DEFAULT NULL,
  `ia_dtl_po_dtl_id` mediumint(8) unsigned NOT NULL,
  `ia_dtl_item_qty` smallint(5) unsigned NOT NULL,
  `ia_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`ia_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

/*Data for the table `ia_dtl` */

insert  into `ia_dtl`(`ia_dtl_id`,`ia_dtl_ia_id`,`ia_dtl_po_dtl_id`,`ia_dtl_item_qty`,`ia_dtl_item_created`) values (142,126,47,11,'2014-02-24 23:06:56'),(143,127,47,1,'2014-02-24 23:07:59'),(144,128,48,5,'2014-02-24 23:12:49'),(145,128,49,5,'2014-02-24 23:12:49'),(146,129,48,30,'2014-02-24 23:31:55'),(147,129,49,13,'2014-02-24 23:31:55');

/*Table structure for table `item` */

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item` (
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='Items';

/*Data for the table `item` */

insert  into `item`(`item_id`,`item_desc`,`item_unit_measure`,`item_qty`,`item_type`,`item_stock_no`,`item_remarks`,`item_article_id`,`item_created`,`item_updated`) values (7,'SAMPLE 1','pc',100,'','4809010524485',' ','2','2014-02-19 14:14:58','2014-03-15 23:19:38'),(8,'SAMPLE 2','bot',100,'','M001-002','Sample 2','2','2014-02-19 14:15:26','2014-02-19 14:17:52'),(9,'SAMPLE 3','ream',200,'','M001-003','Sample 3','2','2014-02-19 14:16:14','2014-02-19 14:16:14'),(12,'Test Item','pc',300,'STOCK',NULL,NULL,'2','2014-02-24 21:57:21','2014-02-24 22:54:54'),(13,'TEST 2','box',138,'STOCK',NULL,NULL,'1','2014-02-24 21:57:22','2014-02-24 22:54:54'),(14,'SAMPLE 1','pc',33,'STOCK',NULL,NULL,'6','2014-02-24 23:02:10','2014-02-24 23:07:59'),(15,'SAMPLE 2','bot',17,'STOCK',NULL,NULL,'5','2014-02-24 23:02:10','2014-02-24 23:02:10'),(16,'SAMPLE 3','pc',51,'STOCK',NULL,NULL,'6','2014-02-24 23:12:49','2014-02-24 23:31:55'),(17,'SAMPLE5','pc',30,'STOCK',NULL,NULL,'5','2014-02-24 23:12:49','2014-02-24 23:31:55');

/*Table structure for table `item_cost` */

DROP TABLE IF EXISTS `item_cost`;

CREATE TABLE `item_cost` (
  `item_cost_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `item_cost_item_id` mediumint(8) unsigned NOT NULL,
  `item_cost_qty` smallint(5) unsigned NOT NULL,
  `item_cost_unit_cost` decimal(10,2) unsigned NOT NULL,
  `item_cost_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`item_cost_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Item Cost';

/*Data for the table `item_cost` */

insert  into `item_cost`(`item_cost_id`,`item_cost_item_id`,`item_cost_qty`,`item_cost_unit_cost`,`item_cost_updated`) values (9,7,100,'250.00','2014-02-19 14:14:58'),(10,8,100,'90.00','2014-02-19 14:15:26'),(11,9,200,'20.00','2014-02-19 14:16:14');

/*Table structure for table `po` */

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='Purchase Order';

/*Data for the table `po` */

insert  into `po`(`po_id`,`po_supplier_id`,`po_no`,`po_proc_mod`,`po_deliv_place`,`po_deliv_date`,`po_deliv_term`,`po_pay_term`,`po_total`,`po_purpose`,`po_conforme`,`po_available_fund`,`po_auth_off`,`po_req_off`,`po_funds_off`,`po_amount`,`po_alobs_no`,`po_created`,`po_is_furnished`,`po_is_cancelled`) values (30,64,'13-382','13-410','Pasong Tamo, Taguig','2014-02-27','20 days','15 days','144.00',NULL,NULL,'0.00','','','','0.00','','2014-02-24 23:06:02',1,0),(31,66,'13-384','13-410','Bulihan, Malvar','2014-02-20','20 days','15 days','4113.00',NULL,NULL,'0.00','','','','0.00','','2014-02-24 23:11:16',1,0),(32,64,'13-385','13-410','Lipa','2014-02-20','20 days','15 days','1080.00','PURPOSE','CONFORME','1000.00','OFF','AUTH','ACCOUNT','0.00','','2014-03-09 22:24:21',0,0);

/*Table structure for table `po_dtl` */

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='Purchase Order Detail ';

/*Data for the table `po_dtl` */

insert  into `po_dtl`(`po_dtl_id`,`po_dtl_po_id`,`po_dtl_item_no`,`po_dtl_item_unit`,`po_dtl_item_qty`,`po_dtl_article_id`,`po_dtl_item_desc`,`po_dtl_item_type`,`po_dtl_item_cost`,`po_dtl_item_created`) values (47,30,1,'pc',12,6,'SAMPLE 1','STOCK','12.00','2014-02-24 23:06:02'),(48,31,1,'pc',21,6,'SAMPLE 3','STOCK','123.00','2014-02-24 23:11:16'),(49,31,2,'pc',17,5,'SAMPLE5','STOCK','90.00','2014-02-24 23:11:16'),(50,32,1,'pc',12,6,'Desc','STOCK','90.00','2014-03-09 22:24:21');

/*Table structure for table `ris` */

DROP TABLE IF EXISTS `ris`;

CREATE TABLE `ris` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Data for the table `ris` */

insert  into `ris`(`ris_id`,`ris_division`,`ris_office`,`ris_rcc`,`ris_no`,`ris_purpose`,`ris_created`,`ris_updated`,`ris_is_issued`) values (1,'DIV','OFF','RCC','90-890','PURPOSE','2014-03-15 17:03:21',NULL,1);

/*Table structure for table `ris_dtl` */

DROP TABLE IF EXISTS `ris_dtl`;

CREATE TABLE `ris_dtl` (
  `ris_dtl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ris_dtl_ris_id` mediumint(8) DEFAULT NULL,
  `ris_dtl_item_stock_no` varchar(255) DEFAULT NULL,
  `ris_dtl_item_no` mediumint(9) DEFAULT NULL,
  `ris_dtl_item_desc` varchar(100) NOT NULL,
  `ris_dtl_item_qty` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_unit` varchar(10) DEFAULT NULL,
  `ris_dtl_item_issued` mediumint(11) DEFAULT NULL,
  `ris_dtl_item_remarks` text,
  `ris_dtl_item_created` datetime NOT NULL,
  PRIMARY KEY (`ris_dtl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `ris_dtl` */

insert  into `ris_dtl`(`ris_dtl_id`,`ris_dtl_ris_id`,`ris_dtl_item_stock_no`,`ris_dtl_item_no`,`ris_dtl_item_desc`,`ris_dtl_item_qty`,`ris_dtl_item_unit`,`ris_dtl_item_issued`,`ris_dtl_item_remarks`,`ris_dtl_item_created`) values (148,1,'13-123',1,'ETO ASOA',10,'pc',0,'ASDASDASDASD','0000-00-00 00:00:00'),(149,1,'13-124',1,'asdsad',10,'pc',0,'sdsaASD','0000-00-00 00:00:00');

/*Table structure for table `series` */

DROP TABLE IF EXISTS `series`;

CREATE TABLE `series` (
  `series_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `series_name` varchar(50) DEFAULT NULL,
  `series_created` datetime DEFAULT NULL,
  PRIMARY KEY (`series_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `series` */

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `supplier_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(60) DEFAULT NULL,
  `supplier_tel_no` varchar(20) DEFAULT NULL,
  `supplier_created` datetime DEFAULT NULL,
  `supplier_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='Suppliers';

/*Data for the table `supplier` */

insert  into `supplier`(`supplier_id`,`supplier_name`,`supplier_address`,`supplier_tel_no`,`supplier_created`,`supplier_updated`) values (64,'JEMARIELL GENERAL MERCHANDISING','By-Pass Rd., Silang, Cavite','865-3975','2014-02-20 12:41:57','2014-02-20 12:41:57'),(65,'ABANES MSDE.','Bulihan, Malvar','','2014-02-20 17:11:47','2014-02-20 17:11:47'),(66,'GARRY EQUIPMENTS','Bulihan, Malvar','981-9262','2014-02-20 18:29:46','2014-02-20 18:29:46'),(67,'Sample Supplier','Sample Address','','2014-02-24 22:58:03','2014-02-24 22:58:03');

/*Table structure for table `user` */

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

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
