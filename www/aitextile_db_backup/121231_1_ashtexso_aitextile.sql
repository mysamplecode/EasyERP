CREATE DATABASE  IF NOT EXISTS `ashtexso_aitextile` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ashtexso_aitextile`;
-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: ashtexso_aitextile
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.3-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `0_crm_persons`
--

DROP TABLE IF EXISTS `0_crm_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_crm_persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(30) NOT NULL,
  `name` varchar(60) NOT NULL,
  `name2` varchar(60) DEFAULT NULL,
  `address` tinytext,
  `phone` varchar(30) DEFAULT NULL,
  `phone2` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `lang` char(5) DEFAULT NULL,
  `notes` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ref` (`ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_crm_persons`
--

LOCK TABLES `0_crm_persons` WRITE;
/*!40000 ALTER TABLE `0_crm_persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_crm_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_item_units`
--

DROP TABLE IF EXISTS `0_item_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_item_units` (
  `abbr` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `decimals` tinyint(2) NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`abbr`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_item_units`
--

LOCK TABLES `0_item_units` WRITE;
/*!40000 ALTER TABLE `0_item_units` DISABLE KEYS */;
INSERT INTO `0_item_units` VALUES ('ea.','Each',0,0);
/*!40000 ALTER TABLE `0_item_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_holiday`
--

DROP TABLE IF EXISTS `0_holiday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_holiday` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(900) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `start_holiday` date NOT NULL,
  `end_holiday` date NOT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_holiday`
--

LOCK TABLES `0_holiday` WRITE;
/*!40000 ALTER TABLE `0_holiday` DISABLE KEYS */;
INSERT INTO `0_holiday` VALUES (4,'INDIPENDENCE DAY','14 august 1947',4,'0000-00-00','0000-00-00'),(7,'INDIPENDENCE DAY3','14 august 1947',4,'0000-00-00','0000-00-00'),(8,'INDIPENDENCE ','14 august 1947',4,'0000-00-00','0000-00-00'),(9,'Labour day','To motivate Our labour by showing his importance.',4,'0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `0_holiday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_chart_class`
--

DROP TABLE IF EXISTS `0_chart_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_chart_class` (
  `cid` varchar(3) NOT NULL,
  `class_name` varchar(60) NOT NULL DEFAULT '',
  `ctype` tinyint(1) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_chart_class`
--

LOCK TABLES `0_chart_class` WRITE;
/*!40000 ALTER TABLE `0_chart_class` DISABLE KEYS */;
INSERT INTO `0_chart_class` VALUES ('1','Assets',1,0),('2','Liabilities',2,0),('3','Income',4,0),('4','Costs',6,0);
/*!40000 ALTER TABLE `0_chart_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_shippers`
--

DROP TABLE IF EXISTS `0_shippers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_shippers` (
  `shipper_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipper_name` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `phone2` varchar(30) NOT NULL DEFAULT '',
  `contact` tinytext NOT NULL,
  `address` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipper_id`),
  UNIQUE KEY `name` (`shipper_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_shippers`
--

LOCK TABLES `0_shippers` WRITE;
/*!40000 ALTER TABLE `0_shippers` DISABLE KEYS */;
INSERT INTO `0_shippers` VALUES (1,'Default','','','','',0);
/*!40000 ALTER TABLE `0_shippers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_teparam`
--

DROP TABLE IF EXISTS `0_teparam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_teparam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lsize` float NOT NULL,
  `tol` float NOT NULL,
  `lpre` float NOT NULL,
  `care` float NOT NULL,
  `bleach` float NOT NULL,
  `dye` float NOT NULL,
  `hydro` float NOT NULL,
  `tum` float NOT NULL,
  `qua` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_teparam`
--

LOCK TABLES `0_teparam` WRITE;
/*!40000 ALTER TABLE `0_teparam` DISABLE KEYS */;
INSERT INTO `0_teparam` VALUES (4,2000,7,2,8,5,4,4,5,1);
/*!40000 ALTER TABLE `0_teparam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sys_types`
--

DROP TABLE IF EXISTS `0_sys_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sys_types` (
  `type_id` smallint(6) NOT NULL DEFAULT '0',
  `type_no` int(11) NOT NULL DEFAULT '1',
  `next_reference` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sys_types`
--

LOCK TABLES `0_sys_types` WRITE;
/*!40000 ALTER TABLE `0_sys_types` DISABLE KEYS */;
INSERT INTO `0_sys_types` VALUES (0,17,'1'),(1,7,'1'),(2,4,'1'),(4,3,'1'),(10,16,'1'),(11,2,'1'),(12,6,'1'),(13,1,'1'),(16,2,'1'),(17,2,'1'),(18,1,'1'),(20,6,'1'),(21,1,'1'),(22,3,'1'),(25,1,'1'),(26,1,'1'),(28,1,'1'),(29,1,'1'),(30,0,'1'),(32,0,'1'),(35,1,'1'),(40,1,'1');
/*!40000 ALTER TABLE `0_sys_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tsupplier`
--

DROP TABLE IF EXISTS `0_tsupplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tsupplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text NOT NULL,
  `ntn` bigint(20) NOT NULL,
  `contact_pname` text NOT NULL,
  `contact_pdesig` text NOT NULL,
  `contact_pno` text NOT NULL,
  `stype` varchar(100) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tsupplier`
--

LOCK TABLES `0_tsupplier` WRITE;
/*!40000 ALTER TABLE `0_tsupplier` DISABLE KEYS */;
INSERT INTO `0_tsupplier` VALUES (1,'ABC',123456789,'Ali','weavingincharge','03217177408','Commercial Dyer',''),(2,'CDE',654321,'Abbas','WeavingMaster','03458912010','Greige Manufacturer','');
/*!40000 ALTER TABLE `0_tsupplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tlots`
--

DROP TABLE IF EXISTS `0_tlots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tlots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` text NOT NULL,
  `pdate` text NOT NULL,
  `lno` int(11) NOT NULL,
  `issue` int(11) NOT NULL,
  `process` int(11) NOT NULL,
  `dispatch` int(11) NOT NULL,
  `cuid` int(11) NOT NULL,
  `issue_date` text NOT NULL,
  `process_date` text NOT NULL,
  `dispatch_date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tlots`
--

LOCK TABLES `0_tlots` WRITE;
/*!40000 ALTER TABLE `0_tlots` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tlots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_dependent`
--

DROP TABLE IF EXISTS `0_employee_dependent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_dependent` (
  `employee_dependent_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `dependent_name` varchar(100) NOT NULL,
  `dependent_relation` varchar(100) DEFAULT NULL,
  `dependent_date_of_birth` date DEFAULT NULL,
  `dependent_occupation` date DEFAULT NULL,
  PRIMARY KEY (`employee_dependent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_dependent`
--

LOCK TABLES `0_employee_dependent` WRITE;
/*!40000 ALTER TABLE `0_employee_dependent` DISABLE KEYS */;
INSERT INTO `0_employee_dependent` VALUES (1,1,'ABC','ABC','2012-12-06','0000-00-00');
/*!40000 ALTER TABLE `0_employee_dependent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_supp_trans`
--

DROP TABLE IF EXISTS `0_supp_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_supp_trans` (
  `trans_no` int(11) unsigned NOT NULL DEFAULT '0',
  `type` smallint(6) unsigned NOT NULL DEFAULT '0',
  `supplier_id` int(11) unsigned DEFAULT NULL,
  `reference` tinytext NOT NULL,
  `supp_reference` varchar(60) NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  `ov_amount` double NOT NULL DEFAULT '0',
  `ov_discount` double NOT NULL DEFAULT '0',
  `ov_gst` double NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '1',
  `alloc` double NOT NULL DEFAULT '0',
  `tax_included` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type`,`trans_no`),
  KEY `supplier_id` (`supplier_id`),
  KEY `SupplierID_2` (`supplier_id`,`supp_reference`),
  KEY `type` (`type`),
  KEY `tran_date` (`tran_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_supp_trans`
--

LOCK TABLES `0_supp_trans` WRITE;
/*!40000 ALTER TABLE `0_supp_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_supp_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_refs`
--

DROP TABLE IF EXISTS `0_refs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_refs` (
  `id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `reference` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`type`),
  KEY `Type_and_Reference` (`type`,`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_refs`
--

LOCK TABLES `0_refs` WRITE;
/*!40000 ALTER TABLE `0_refs` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_refs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_cust_allocations`
--

DROP TABLE IF EXISTS `0_cust_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_cust_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amt` double unsigned DEFAULT NULL,
  `date_alloc` date NOT NULL DEFAULT '0000-00-00',
  `trans_no_from` int(11) DEFAULT NULL,
  `trans_type_from` int(11) DEFAULT NULL,
  `trans_no_to` int(11) DEFAULT NULL,
  `trans_type_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `From` (`trans_type_from`,`trans_no_from`),
  KEY `To` (`trans_type_to`,`trans_no_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_cust_allocations`
--

LOCK TABLES `0_cust_allocations` WRITE;
/*!40000 ALTER TABLE `0_cust_allocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_cust_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_quick_entries`
--

DROP TABLE IF EXISTS `0_quick_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_quick_entries` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(60) NOT NULL,
  `base_amount` double NOT NULL DEFAULT '0',
  `base_desc` varchar(60) DEFAULT NULL,
  `bal_type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_quick_entries`
--

LOCK TABLES `0_quick_entries` WRITE;
/*!40000 ALTER TABLE `0_quick_entries` DISABLE KEYS */;
INSERT INTO `0_quick_entries` VALUES (1,1,'Maintenance',0,'Amount',0),(2,4,'Phone',0,'Amount',0),(3,2,'Cash Sales',0,'Amount',0);
/*!40000 ALTER TABLE `0_quick_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_unit`
--

DROP TABLE IF EXISTS `0_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_unit`
--

LOCK TABLES `0_unit` WRITE;
/*!40000 ALTER TABLE `0_unit` DISABLE KEYS */;
INSERT INTO `0_unit` VALUES (14,'HEAD OFFICE '),(19,'STITCHING'),(21,'WEAVING'),(22,'TOWEL WEAVING');
/*!40000 ALTER TABLE `0_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_allowance`
--

DROP TABLE IF EXISTS `0_allowance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_allowance` (
  `allowance_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(900) NOT NULL,
  `type` int(2) NOT NULL,
  PRIMARY KEY (`allowance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_allowance`
--

LOCK TABLES `0_allowance` WRITE;
/*!40000 ALTER TABLE `0_allowance` DISABLE KEYS */;
INSERT INTO `0_allowance` VALUES (3,'FUEL ALLOWANCE','IT IS ALLOWED TO ONLY THOSE EMPLOYEES HAVING COMPANYS CONVEYANCE',0),(4,'PHONE ALLOWENCE','ONLY FOR OUT DOOR DUTY PERSONS',0),(6,'Not alloewd','as per company policy is allowance is not allowed',0);
/*!40000 ALTER TABLE `0_allowance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_print_profiles`
--

DROP TABLE IF EXISTS `0_print_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_print_profiles` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `profile` varchar(30) NOT NULL,
  `report` varchar(5) DEFAULT NULL,
  `printer` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile` (`profile`,`report`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_print_profiles`
--

LOCK TABLES `0_print_profiles` WRITE;
/*!40000 ALTER TABLE `0_print_profiles` DISABLE KEYS */;
INSERT INTO `0_print_profiles` VALUES (1,'Out of office','',0),(2,'Sales Department','',0),(3,'Central','',2),(4,'Sales Department','104',2),(5,'Sales Department','105',2),(6,'Sales Department','107',2),(7,'Sales Department','109',2),(8,'Sales Department','110',2),(9,'Sales Department','201',2);
/*!40000 ALTER TABLE `0_print_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tssearch`
--

DROP TABLE IF EXISTS `0_tssearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tssearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dom` longtext NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tssearch`
--

LOCK TABLES `0_tssearch` WRITE;
/*!40000 ALTER TABLE `0_tssearch` DISABLE KEYS */;
INSERT INTO `0_tssearch` VALUES (8,'\n	&lt;table align=&quot;center&quot; width=&quot;80%&quot; style=&quot;border:1px solid #cccccc;&quot;&gt;\n		&lt;tbody&gt;\n			&lt;tr valign=&quot;top&quot;&gt;\n				&lt;td width=&quot;50%&quot; id=&quot;left_panel&quot;&gt;\n					&lt;b&gt;Search Options:&lt;/b&gt; &lt;br&gt;\n						&lt;a href=&quot;#invdate_panel&quot; id=&quot;invdate&quot;&gt;Inventory by date&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#invsup_panel&quot; id=&quot;invsup&quot;&gt;Inventory by Supplier&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#invinv_panel&quot; id=&quot;invinv&quot;&gt;Inventory by Inventory #&lt;/a&gt;&lt;br&gt;\n					&lt;b&gt;Include issued inventories:&lt;/b&gt;&lt;input type=&quot;checkbox&quot; name=&quot;issued_inventories&quot; value=&quot;1&quot; id=&quot;issued_inventories&quot; checked=&quot;checked&quot;&gt;&lt;br&gt;\n					&lt;div id=&quot;issued_filters&quot; style=&quot;padding-left: 20px; padding-top: 10px; padding-bottom: 10px; &quot;&gt;\n						&lt;a href=&quot;#invdatei_panel&quot; id=&quot;invdatei&quot;&gt;Inventory by issued date&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#invlot_panel&quot; id=&quot;invlot&quot;&gt;Inventory by Lot #&lt;/a&gt;&lt;br&gt; \n					&lt;/div&gt;\n					&lt;b&gt;Include processed inventories:&lt;/b&gt;&lt;input type=&quot;checkbox&quot; name=&quot;processed_inventories&quot; value=&quot;1&quot; id=&quot;processed_inventories&quot; checked=&quot;checked&quot;&gt;&lt;br&gt;\n					&lt;div id=&quot;processed_filters&quot; style=&quot;padding-left: 20px; padding-top: 10px; padding-bottom: 10px; &quot;&gt;\n						&lt;a href=&quot;#invdatep_panel&quot; id=&quot;invdatep&quot;&gt;Inventory by processed date&lt;/a&gt;&lt;br&gt; \n					&lt;/div&gt;\n					&lt;b&gt;Include dispatch inventories:&lt;/b&gt;&lt;input type=&quot;checkbox&quot; name=&quot;dispatch_inventories&quot; value=&quot;1&quot; id=&quot;dispatch_inventories&quot; checked=&quot;checked&quot;&gt;&lt;br&gt;\n					&lt;div id=&quot;dispatch_filters&quot; style=&quot;padding-left: 20px; padding-top: 10px; padding-bottom: 10px; &quot;&gt;\n						&lt;a href=&quot;#invdated_panel&quot; id=&quot;invdated&quot;&gt;Inventory by dispatch date&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#invcus_panel&quot; id=&quot;invcus&quot;&gt;Inventory by customer&lt;/a&gt;&lt;br&gt; \n					&lt;/div&gt;\n				&lt;/td&gt;\n				&lt;td width=&quot;50&quot; style=&quot;border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;&quot; id=&quot;right_panel&quot;&gt;\n					&lt;b&gt;Filters:&lt;/b&gt; \n					&lt;div id=&quot;invdate_panel&quot; class=&quot;panels&quot; active=&quot;active&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot;&gt;\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n							Start Date:&lt;input type=&quot;text&quot; name=&quot;invadate_input_start00&quot; class=&quot;invdate_input_start date_field&quot; value=&quot;&quot;&gt; &lt;br&gt;\n							End Date: &lt;input type=&quot;text&quot; name=&quot;invadate_input_end&quot; class=&quot;invdate_input_end date_field&quot; value=&quot;&quot;&gt; \n						&lt;/div&gt;&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n							Start Date:&lt;input type=&quot;text&quot; name=&quot;invadate_input_start2&quot; class=&quot;invdate_input_start date_field&quot; value=&quot;&quot;&gt; &lt;br&gt;\n							End Date: &lt;input type=&quot;text&quot; name=&quot;invadate_input_end&quot; class=&quot;invdate_input_end date_field&quot; value=&quot;&quot;&gt; \n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					&lt;/div&gt;\n					&lt;div id=&quot;invsup_panel&quot; class=&quot;panels&quot; active=&quot;active&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: block; &quot;&gt;\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n						&lt;select name=&quot;lov_select&quot; class=&quot;lov_select&quot;&gt;\n							&lt;option value=&quot;&quot; selected=&quot;selected&quot;&gt;None&lt;/option&gt;\n													&lt;/select&gt;\n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invinv_panel&quot; class=&quot;panels&quot; active=&quot;active&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot;&gt; \n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n						&lt;select name=&quot;lov_select&quot; class=&quot;lov_select&quot;&gt;\n							&lt;option value=&quot;&quot; selected=&quot;selected&quot;&gt;None&lt;/option&gt;\n													&lt;/select&gt;\n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invdatei_panel&quot; class=&quot;panels&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot; active=&quot;active&quot;&gt;\n					\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n							Start Date:&lt;input type=&quot;text&quot; name=&quot;invadate_input_start&quot; class=&quot;invdate_input_start date_field&quot; value=&quot;&quot;&gt; &lt;br&gt;\n							End Date: &lt;input type=&quot;text&quot; name=&quot;invadate_input_end&quot; class=&quot;invdate_input_end date_field&quot; value=&quot;&quot;&gt; \n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invlot_panel&quot; class=&quot;panels&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot; active=&quot;active&quot;&gt;\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n						&lt;select name=&quot;lov_select&quot; class=&quot;lov_select&quot;&gt;\n							&lt;option value=&quot;&quot; selected=&quot;selected&quot;&gt;None&lt;/option&gt;\n													&lt;/select&gt;\n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invdatep_panel&quot; class=&quot;panels&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot; active=&quot;active&quot;&gt;\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n							Start Date:&lt;input type=&quot;text&quot; name=&quot;invadate_input_start&quot; class=&quot;invdate_input_start date_field&quot; value=&quot;&quot;&gt; &lt;br&gt;\n							End Date: &lt;input type=&quot;text&quot; name=&quot;invadate_input_end&quot; class=&quot;invdate_input_end date_field&quot; value=&quot;&quot;&gt; \n						&lt;/div&gt;\n				 \n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot; &quot;=&quot;&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invdated_panel&quot; class=&quot;panels&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot; active=&quot;active&quot;&gt;\n						&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n							Start Date:&lt;input type=&quot;text&quot; name=&quot;invadate_input_start&quot; class=&quot;invdate_input_start date_field&quot; value=&quot;&quot;&gt; &lt;br&gt;\n							End Date: &lt;input type=&quot;text&quot; name=&quot;invadate_input_end&quot; class=&quot;invdate_input_end date_field&quot; value=&quot;&quot;&gt; \n						&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					\n					\n					\n					&lt;/div&gt;\n					&lt;div id=&quot;invcus_panel&quot; class=&quot;panels&quot; style=&quot;text-align: center; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; display: none; &quot; active=&quot;active&quot;&gt;\n					&lt;div class=&quot;filter_wrapper&quot; style=&quot;margin:5px;&quot;&gt;\n						&lt;select name=&quot;lov_select&quot; class=&quot;lov_select&quot;&gt;\n							&lt;option value=&quot;&quot; selected=&quot;selected&quot;&gt;None&lt;/option&gt;\n													&lt;/select&gt;\n					&lt;/div&gt;\n						&lt;a href=&quot;#&quot; class=&quot;add_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/add.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Add&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;update_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/button_ok.png&quot; height=&quot;12&quot;&gt;&lt;span&gt;Update&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;block_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/login.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Block&lt;/span&gt;&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#&quot; class=&quot;exclude_filter&quot;&gt;&lt;img src=&quot;../../themes/default/images/delete.gif&quot; height=&quot;12&quot;&gt;&lt;span&gt;Exclude&lt;/span&gt;&lt;/a&gt;\n					\n					\n					\n					\n					&lt;/div&gt;\n				&lt;/td&gt; \n			&lt;/tr&gt;\n		&lt;/tbody&gt;\n	&lt;/table&gt;\n	&lt;table align=&quot;center&quot; width=&quot;80%&quot; style=&quot;border:1px solid #cccccc;&quot;&gt;\n		&lt;tbody&gt;\n			&lt;tr valign=&quot;top&quot;&gt;\n				&lt;td width=&quot;50%&quot; id=&quot;leftpanel_print&quot;&gt;\n					&lt;b&gt;Print options:&lt;/b&gt; &lt;br&gt; \n					\n						&lt;a href=&quot;#printinv_panel&quot; id=&quot;printinv&quot;&gt;Inventory table&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#printsup_panel&quot; id=&quot;printsup&quot;&gt;Supplier table&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#printlot_panel&quot; id=&quot;printlot&quot;&gt;Lot table&lt;/a&gt;&lt;br&gt;\n						&lt;a href=&quot;#printcust_panel&quot; id=&quot;printcust&quot;&gt;Customer tabler&lt;/a&gt;&lt;br&gt;\n				&lt;/td&gt;\n				&lt;td width=&quot;50&quot; style=&quot;border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;&quot; id=&quot;rightpanel_print&quot;&gt;\n					&lt;b&gt;Print filters:&lt;/b&gt; \n					&lt;div id=&quot;printinv_panel&quot; style=&quot;display:none;  padding:10px;&quot;&gt;\n						Inventory #&lt;input type=&quot;checkbox&quot; name=&quot;id&quot; value=&quot;Inventory #&quot;&gt;&lt;br&gt;\n						Supplier&lt;input type=&quot;checkbox&quot; name=&quot;sup&quot; value=&quot;Supplier&quot;&gt;&lt;br&gt;\n						Gate in&lt;input type=&quot;checkbox&quot; name=&quot;gate_in&quot; value=&quot;Gate in&quot;&gt;&lt;br&gt;\n						IGP&lt;input type=&quot;checkbox&quot; name=&quot;igp&quot; value=&quot;IGP&quot;&gt;&lt;br&gt;\n						Description of Goods&lt;input type=&quot;checkbox&quot; name=&quot;goods&quot; value=&quot;Description of Goods&quot;&gt;&lt;br&gt;\n						Driver Name&lt;input type=&quot;checkbox&quot; name=&quot;driver&quot; value=&quot;Driver Name&quot;&gt;&lt;br&gt;\n						Vehicle&lt;input type=&quot;checkbox&quot; name=&quot;vehicle&quot; value=&quot;Vehicle&quot;&gt;&lt;br&gt;\n						Gate out&lt;input type=&quot;checkbox&quot; name=&quot;gate_out&quot; value=&quot;Gate out&quot;&gt;&lt;br&gt;\n						Received by&lt;input type=&quot;checkbox&quot; name=&quot;recv&quot; value=&quot;Received by&quot;&gt;&lt;br&gt;\n						Received by designation&lt;input type=&quot;checkbox&quot; name=&quot;recvby&quot; value=&quot;Received by designation&quot;&gt;&lt;br&gt; \n					&lt;/div&gt;\n					&lt;div id=&quot;printcust_panel&quot; style=&quot;display:none;  padding:10px;&quot;&gt;\n						 Name&lt;input type=&quot;checkbox&quot; name=&quot;name&quot; value=&quot;Name&quot;&gt;&lt;br&gt;\n						Adress&lt;input type=&quot;checkbox&quot; name=&quot;address&quot; value=&quot;Adress&quot;&gt;&lt;br&gt;\n						Ntn&lt;input type=&quot;checkbox&quot; name=&quot;ntn&quot; value=&quot;Ntn&quot;&gt;&lt;br&gt;\n						Contact person name&lt;input type=&quot;checkbox&quot; name=&quot;contact_pname&quot; value=&quot;Contact person name&quot;&gt;&lt;br&gt;\n						Contact person designation&lt;input type=&quot;checkbox&quot; name=&quot;contact_pdesig&quot; value=&quot;Contact person designation&quot;&gt;&lt;br&gt;\n						Contact person number&lt;input type=&quot;checkbox&quot; name=&quot;contact_pno&quot; value=&quot;Contact person number&quot;&gt;&lt;br&gt;\n						Customer type&lt;input type=&quot;checkbox&quot; name=&quot;stype&quot; value=&quot;Customer type&quot;&gt;&lt;br&gt; \n					&lt;/div&gt;\n					&lt;div id=&quot;printlot_panel&quot; style=&quot;display:none;  padding:10px;&quot;&gt;\n						Lot #&lt;input type=&quot;checkbox&quot; name=&quot;lno&quot; value=&quot;Lot #&quot;&gt;&lt;br&gt;\n						Lot description&lt;input type=&quot;checkbox&quot; name=&quot;descr&quot; value=&quot;	Lot description&quot;&gt;&lt;br&gt;\n						Lot proposed process date&lt;input type=&quot;checkbox&quot; name=&quot;pdate&quot; value=&quot;Lot proposed process date&quot;&gt;&lt;br&gt;\n						  \n					&lt;/div&gt;\n					&lt;div id=&quot;printsup_panel&quot; style=&quot;display:none;  padding:10px;&quot;&gt;\n						Name&lt;input type=&quot;checkbox&quot; name=&quot;name&quot; value=&quot;Name&quot;&gt;&lt;br&gt;\n						Adress&lt;input type=&quot;checkbox&quot; name=&quot;address&quot; value=&quot;Adress&quot;&gt;&lt;br&gt;\n						Ntn&lt;input type=&quot;checkbox&quot; name=&quot;ntn&quot; value=&quot;Ntn&quot;&gt;&lt;br&gt;\n						Contact person name&lt;input type=&quot;checkbox&quot; name=&quot;contact_pname&quot; value=&quot;Contact person name&quot;&gt;&lt;br&gt;\n						COntact person designation&lt;input type=&quot;checkbox&quot; name=&quot;contact_pdesig&quot; value=&quot;COntact person designation&quot;&gt;&lt;br&gt;\n						Contact person number&lt;input type=&quot;checkbox&quot; name=&quot;contact_pno&quot; value=&quot;Contact person number&quot;&gt;&lt;br&gt;\n						Supplier type&lt;input type=&quot;checkbox&quot; name=&quot;stype&quot; value=&quot;Supplier type&quot;&gt;&lt;br&gt; \n					&lt;/div&gt;\n				&lt;/td&gt; \n			&lt;/tr&gt;\n		&lt;/tbody&gt;\n	&lt;/table&gt;\n	','search 1');
/*!40000 ALTER TABLE `0_tssearch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_deduction`
--

DROP TABLE IF EXISTS `0_employee_deduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_deduction` (
  `employee_deduction_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `deduction_amount` decimal(10,0) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_deduction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_deduction`
--

LOCK TABLES `0_employee_deduction` WRITE;
/*!40000 ALTER TABLE `0_employee_deduction` DISABLE KEYS */;
INSERT INTO `0_employee_deduction` VALUES (1,1,80,4),(2,1,500,8),(3,53,300,8);
/*!40000 ALTER TABLE `0_employee_deduction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_transaction`
--

DROP TABLE IF EXISTS `0_employee_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_transaction` (
  `employee_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `transaction_code` int(11) NOT NULL,
  `transaction_reason` varchar(500) NOT NULL,
  `transaction_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_int1` int(11) DEFAULT NULL,
  `transaction_int2` int(11) DEFAULT NULL,
  `transaction_int3` int(11) DEFAULT NULL,
  `transaction_dec1` decimal(10,0) DEFAULT NULL,
  `transaction_dec2` decimal(10,0) DEFAULT NULL,
  `transaction_dec3` decimal(10,0) DEFAULT NULL,
  `transaction_timestamp1` datetime DEFAULT NULL,
  `transaction_timestamp2` datetime DEFAULT NULL,
  `transaction_timestamp3` datetime DEFAULT NULL,
  `transaction_string1` varchar(200) DEFAULT NULL,
  `transaction_string2` varchar(300) DEFAULT NULL,
  `transaction_string3` varchar(500) DEFAULT NULL,
  `transaction_int4` int(11) DEFAULT NULL,
  `transaction_dec4` decimal(10,0) DEFAULT NULL,
  `transaction_int5` int(11) DEFAULT NULL,
  `transaction_dec5` decimal(10,0) DEFAULT NULL,
  `transaction_dump` text,
  PRIMARY KEY (`employee_transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_transaction`
--

LOCK TABLES `0_employee_transaction` WRITE;
/*!40000 ALTER TABLE `0_employee_transaction` DISABLE KEYS */;
INSERT INTO `0_employee_transaction` VALUES (1,1,8,'abc','2012-12-14 11:00:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,98,7,' physically fit','2012-12-14 11:04:53',8,7,218,4,8,NULL,'2012-12-14 00:00:00','2012-12-14 00:00:00',NULL,'2012-07-01 to 2013-06-30','SICK LEAVE',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `0_employee_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_printers`
--

DROP TABLE IF EXISTS `0_printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_printers` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(60) NOT NULL,
  `queue` varchar(20) NOT NULL,
  `host` varchar(40) NOT NULL,
  `port` smallint(11) unsigned NOT NULL,
  `timeout` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_printers`
--

LOCK TABLES `0_printers` WRITE;
/*!40000 ALTER TABLE `0_printers` DISABLE KEYS */;
INSERT INTO `0_printers` VALUES (1,'QL500','Label printer','QL500','server',127,20),(2,'Samsung','Main network printer','scx4521F','server',515,5),(3,'Local','Local print server at user IP','lp','',515,10);
/*!40000 ALTER TABLE `0_printers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_wo_issues`
--

DROP TABLE IF EXISTS `0_wo_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_wo_issues` (
  `issue_no` int(11) NOT NULL AUTO_INCREMENT,
  `workorder_id` int(11) NOT NULL DEFAULT '0',
  `reference` varchar(100) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`issue_no`),
  KEY `workorder_id` (`workorder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_wo_issues`
--

LOCK TABLES `0_wo_issues` WRITE;
/*!40000 ALTER TABLE `0_wo_issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_wo_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tag_associations`
--

DROP TABLE IF EXISTS `0_tag_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tag_associations` (
  `record_id` varchar(15) NOT NULL,
  `tag_id` int(11) NOT NULL,
  UNIQUE KEY `record_id` (`record_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tag_associations`
--

LOCK TABLES `0_tag_associations` WRITE;
/*!40000 ALTER TABLE `0_tag_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tag_associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_wo_issue_items`
--

DROP TABLE IF EXISTS `0_wo_issue_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_wo_issue_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(40) DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_wo_issue_items`
--

LOCK TABLES `0_wo_issue_items` WRITE;
/*!40000 ALTER TABLE `0_wo_issue_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_wo_issue_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tsesearch`
--

DROP TABLE IF EXISTS `0_tsesearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tsesearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `doom` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tsesearch`
--

LOCK TABLES `0_tsesearch` WRITE;
/*!40000 ALTER TABLE `0_tsesearch` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tsesearch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee`
--

DROP TABLE IF EXISTS `0_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_status_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `joining_date` date DEFAULT NULL,
  `guardian_first_name` varchar(50) DEFAULT NULL,
  `guardian_last_name` varchar(50) DEFAULT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL,
  `primary_contact` varchar(50) DEFAULT NULL,
  `secondary_contact` varchar(50) DEFAULT NULL,
  `path_to_cv` varchar(600) DEFAULT NULL,
  `path_to_picture` varchar(600) DEFAULT NULL,
  `permenant_address` varchar(900) DEFAULT NULL,
  `temporary_address` varchar(900) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `domicile` varchar(30) DEFAULT NULL,
  `sex` varchar(30) DEFAULT NULL,
  `nationality` varchar(30) DEFAULT NULL,
  `marital_status` varchar(30) DEFAULT NULL,
  `native_language` varchar(30) DEFAULT NULL,
  `blood_group` varchar(30) DEFAULT NULL,
  `religion` varchar(30) DEFAULT NULL,
  `cast` varchar(30) DEFAULT NULL,
  `disability` varchar(900) DEFAULT NULL,
  `remarks` varchar(900) DEFAULT NULL,
  `designation_id` int(11) NOT NULL,
  `salary_type` varchar(30) DEFAULT NULL,
  `allow` int(11) NOT NULL,
  `deduction` int(11) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `basic_salary` decimal(10,0) DEFAULT NULL,
  `shift_id` int(11) NOT NULL,
  `cnic` varchar(30) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `account_holder_name` varchar(50) DEFAULT NULL,
  `account_holder_address` varchar(300) DEFAULT NULL,
  `account_iban` varchar(30) DEFAULT NULL,
  `check_reciever` varchar(50) DEFAULT NULL,
  `reports_to` int(11) DEFAULT NULL,
  `advance` decimal(10,0) DEFAULT NULL,
  `installment` decimal(10,0) DEFAULT NULL,
  `paid_installment` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee`
--

LOCK TABLES `0_employee` WRITE;
/*!40000 ALTER TABLE `0_employee` DISABLE KEYS */;
INSERT INTO `0_employee` VALUES (1,14,5,2,4,'MUHAMMAD AMMAD','ALTAF','2011-11-21','Muhammad ',' Altaf','Father','03457912010','03217177408','','../../company/0/profile_pics/profile-50c04234ed38c.png','p-25 street #1 new haseeb shaheed colony FSd.','p-25 street #1 new haseeb shaheed colony FSd','Faisalabad','Pakistan','Faisalabad','Male','Pakistani','','Urdu','B +','Islam','Sheikh','No','ABC',51,'Fixed',3,6,'Bank Transfer',20000,16,'33100-9290653-1','1985-11-17',2,'MUHAMMAD AMMAD ALTAF','P-25 STREET#1 NEW HASEEB SHAHEED COLONY NEAR MIAN CHOWK FSD',NULL,NULL,NULL,NULL,NULL,NULL),(2,14,5,2,4,'MUHAMMAD SHAKIL','ASIF','2011-12-05','SHAHADAT ','ALI','FATHER','03327258416','03327258416','','../../company/0/profile_pics/profile-50cf111d77531.png','Chak # 534 G.B  Tehsil Jaranwala District Faisalabad','Chak # 140 Tehsil Jaranwala District Faisalabad','JARANWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','JUTT','NO','',51,'fixed',3,4,'btransfer',NULL,16,'331049690226-5','1986-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,14,42,4,4,'MUHAMMAD RAFAQAT','ALI','2012-12-16','MUHAMMAD ','RAFI','FATHER','03427436126','123456789','','../../company/0/profile_pics/profile-50ded332a7191.png','CHAK #106 G.B KHALSA PUR TEHSIL JARANWALA DISTRICT FAISALABAD','CHAK #106 G.B KHALSA PUR TEHSIL JARANWALA DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKIISTANI','Single','Urdu','','ISLAM','RAJPOOT','NO','',63,'fixed',0,0,'cash',15000,16,'331047587999-5','2005-09-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,14,42,1,4,'M AYAZ','AHMED BUTT','2012-06-25','MUSHTAQ AHMAD','BUTT','FATHER','03017264170','03017264170','','../../company/0/profile_pics/profile-50ded3819269f.png','HOUSE#217 st#7 safia park jaranwala faisalabad','HOUSE#217 st#7 safia park jaranwala faisalabad','JARANWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','BUTT','NO','ABC',17,'fixed',0,0,'cash',15000,16,'33104-6791986-5','1987-10-25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,14,43,5,4,'MUHAMMAD ADNAN','KHALID','0000-00-00','MUHAMMAD KHALID','ZAHID','FATHER','03458006688','03458677726','','','CHAK NO 76/J.B P/O 74/J.B THIKRIWALA TEH &amp; DISTT FAISALABAD','CHAK NO 76/J.B P/O 74/J.B THIKRIWALA TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTAN','single','Punjabi','B+','ISLAM','JUTT','','',62,'fixed',0,0,'cash',12000,26,'3310050358149','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,14,43,5,4,'MUHAMMAD NAUMAN','TOHEED','0000-00-00','MUHAMMAD','TOHEED','FATHER','0301-7041551','','','','CHAK NO 209 R.B FAISALABAD','CHAK NO 209 R.B FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','JUTT','NO','',62,'fixed',0,0,'cash',10500,26,'33104-5848614-8','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,14,4,2,4,'AAMIR ','SHAHZAD','2000-01-01','MUHAMMAD ','RAFIQUE','FATHER','03018686265','03018686265','','../../company/0/profile_pics/profile-50d00e44449db.png','Kashmir Road House # p-117 Mohallha Khyaban colony faisalabad','Kashmir Road House # p-117 Mohallha Khyaban colony faisalabad','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','B +','ISLAM','','NO`','',73,'fixed',0,0,'btransfer',16000,16,'37302-1148471-9','1983-07-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,14,9,2,4,'MUHAMMAD','ANWAR','2012-08-24','ALTAF ','HUSSAIN','FATHER','03226338485','03226338485','','../../company/0/profile_pics/profile-50debeae45fc1.png','HOHSE P#213 ST#6 TAJ COLONY MILLAT ROAD FAISALABAD','HOHSE P#213 ST#6 TAJ COLONY MILLAT ROAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','',74,'fixed',0,0,'cash',30000,16,'not available','1956-06-21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,14,9,2,4,'ASIF ','ALI','2011-04-07','MUHAMMAD ','KHALIQ','FATHER','03334674891','03334674891','','../../company/0/profile_pics/profile-50dec00e3c137.png','CHAK # 104 GB TEHSIL JARANWALA DIST FSD','CHAK # 104 GB TEHSIL JARANWALA DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO`','',57,'fixed',0,0,'cash',14000,16,'33104-2779043-5','1990-05-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,14,9,2,4,'ALI','AHMAD','2012-07-17','BASHIR','AHMAD','FATHER','03007290699','03007290699','','../../company/0/profile_pics/profile-50dec21d1b2c1.png','MAIN BAZAR JHNG ROAD H#197-P MOHALLHA SAIFABAD NO#1 FAISALABAD','MAIN BAZAR JHNG ROAD H#197-P MOHALLHA SAIFABAD NO#1 FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','',58,'fixed',0,0,'cash',11000,16,'33100-3206819-3','1987-12-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,14,9,2,4,'GULL','NAWAZ','2012-06-19','NOOR ','MUHAMMAD','FATHER','03217804223','03217804223','','../../company/0/profile_pics/profile-50dec29d80180.png','CHAK # 227/R.B P/O 215/R.B TEH &amp; DISTT FAISALABAD','CHAK # 227/R.B P/O 215/R.B TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','NO',58,'fixed',0,0,'cash',12000,16,'33100-9038013-7','1983-02-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,14,33,2,4,'IFTIKHAR ','AHMAD','2004-07-24','MUNIR ','AHMAD','FATHER','03028659800','03028659800','','../../company/0/profile_pics/profile-50debb5ed64f1.png','ALIF SANI CHOWK H#380, BLOCK B, G.M ABAD,','ALIF SANI CHOWK H#380, BLOCK B, G.M ABAD,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',54,'fixed',0,0,'btransfer',22000,16,'33100-9413244-5','1985-06-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,21,27,2,4,'ABDUL ','GHAFOOR','2007-11-10','MUHAMMAD','HUSSAIN','FATHER','03236051240','03236051240','','../../company/0/profile_pics/profile-50decd970c3ca.png','CHAK # 240 GB TEHSEEL JARANWALA\r\n','STREET # 4 MOHALLA MOMAN ABAD FSD\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',36,'fixed',0,0,'btransfer',20000,31,'33104-2089171-5','1969-06-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,14,7,2,4,'ARSHAD','TABASSUM','2003-08-01','MUHAMMAD','SHARIF','FATHER','03007976235','03007976235','','../../company/0/profile_pics/profile-50dd7e5136fd8.png','JHAAL LAMBRAN, P/O MANDI SADIQ GUNJ/MINCHINABAD','JHAAL LAMBRAN, P/O MANDI SADIQ GUNJ/MINCHINABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',44,'fixed',0,0,'btransfer',23000,16,'31105-0265487-1','1980-12-12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,14,7,2,4,'KASHIF','ATTIQUE','2002-06-01','MUHAMMAD','ATTIQUE','FATHER','03007607330','03007607330','','../../company/0/profile_pics/profile-50dd3554e44e4.png','H# P-183 BHORA STR # 1\r\nAMINPUR BAZAR,FAISALABAD','H# P-183 BHORA STR # 1\r\nAMINPUR BAZAR,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',12,'fixed',0,0,'btransfer',27000,16,'33100-5811479-9','1976-11-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,14,7,2,4,'MUHAMMAD ZAHIR-UL-DIN','BABAR','2010-08-07','GHULAM','RASOOL','FATHER','03338396088','03338396088','','../../company/0/profile_pics/profile-50dd3a8a4f825.png','CHAK NO 188 MURAD TEHSIL HASIL PUR BAHAWALPUR','CHAK NO 188 MURAD TEHSIL HASIL PUR BAHAWALPUR','HASIL PUR','PAKISTAN','BAHAWALPUR','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',11,'fixed',0,0,'btransfer',22000,16,'31203-9843228-7','1984-11-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,14,7,2,4,'IJAZ','ABBAS','2008-10-09','ABBAS','ALI','FATHER','03134717584','03134717584','','../../company/0/profile_pics/profile-50dd601aa31b7.png','656/C BATALA COLONY PEOPLE COLONY #2  FAISALABAD','656/C BATALA COLONY PEOPLE COLONY #2  FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',43,'fixed',0,0,'btransfer',25000,16,'33100-2735462-9','1978-03-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,14,7,2,4,'ABDUL JABBAR','DOGAR','2007-11-01','MUHAMMAD','TUFAIL','FATHER','03156561208','03156561208','','../../company/0/profile_pics/profile-50dd60d5d8457.png','CHAK # 208 RB MAKOWANA  JARANWALA ROAD FAISALABAD \r\n','CHAK # 208 RB MAKOWANA  JARANWALA ROAD FAISALABAD \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',44,'fixed',0,0,'btransfer',20000,16,'33100-6249123-5','1980-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,14,7,2,4,'MUHAMMAD','AWAIS','2004-04-01','ABDUL','GHANI','FATHER','03018625183','03018625183','','../../company/0/profile_pics/profile-50dd6f46b0e78.png','126-E,KOT KHAN MUHAMMAD, SITYANA ROAD,','126-E,KOT KHAN MUHAMMAD, SITYANA ROAD,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',42,'fixed',0,0,'btransfer',60000,16,'33100-0743061-9','1975-09-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,14,7,2,4,'MAQSOOD AHMAD','KHAN','2007-02-06','MUHAMMAD','KHAN','FATHER','03016002165','03016002165','','../../company/0/profile_pics/profile-50dd7038ba4cf.png','P-31, STR # 3, AMINABAD-1SAMNAABAD FAISALABAD','P-31, STR # 3, AMINABAD-1SAMNAABAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',45,'fixed',0,0,'btransfer',37000,16,'33102-1792227-3','1965-04-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,19,22,5,4,'UMAR','HABIB','0000-00-00','HABIB ','AHMAD','FATHER','03137120525','','','profile-1350471275.gif','HOUSE NO 96.MOHALLA MADINA TOWN.BLOCK X,FAISALABAD','HOUSE NO 96.MOHALLA MADINA TOWN.BLOCK X,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',12000,20,'33102-7425126-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,19,21,2,4,'BILAWAL','ALI','2012-08-01','MUHAMMAD','SALEEM','FATHER','0300','0300','','../../company/0/profile_pics/profile-50dedce8a1db8.png','BISMILLAH CHOK, HOUSE #1411/24,MOHALLA SHADI PUR FSD.','BISMILLAH CHOK, HOUSE #1411/24,MOHALLA SHADI PUR FSD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33102-6498229-5','1991-05-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,19,21,2,4,'MUHAMMAD ','SHERYAR','2012-08-01','MUHAMMAD','SALEEM','FATHER','0300','0300','','../../company/0/profile_pics/profile-50dedd855dfd9.png','BISMILLAH CHOK, HOUSE #1411/24,MOHALLA SHADI PUR FSD.','BISMILLAH CHOK, HOUSE #1411/24,MOHALLA SHADI PUR FSD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,32,'33102-6498229-5','1992-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,19,22,5,4,'MUHAMMAD ','MAQBOOL','0000-00-00','MUHAMMAD','AFZAL','FATHER','03336600778','','','profile-1350560576.gif','H.NO.340-B,STREET NO.06,CHAK NO 66/J.B DHANDRA FAISALABAD','H.NO.340-B,STREET NO.06,CHAK NO 66/J.B DHANDRA FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',10000,20,'33103-1649706-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,19,22,5,4,'HAMAD','ALI','0000-00-00','SAIDER','KHAN','FATHER','0346-9314454','','','','C/O Aamir Medicos Lundkhwar Bazar , Tehsil Takht Bahi,District Mardan, kpk , Pakistan','C/O Aamir Medicos Lundkhwar Bazar , Tehsil Takht Bahi,District Mardan, kpk , Pakistan','TAKHT BAHI','PAKISTAN','KPK','man','PAKISTANI','single','Pashto','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',20000,4,'16102-3112307-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,19,21,2,4,'MUHAMMAD','MUSTAFA','2010-10-07','ABDUL','KHALIQ','FATHER','03437624872','03437624872','','../../company/0/profile_pics/profile-50dede2bac726.png','CHAK#123 GB P OFFICE JARANWALA\r\n','CHAK#123 GB P OFFICE JARANWALA\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',7000,32,'33104-3300258-9','1985-12-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,19,23,6,4,'SHAHID','RAFIQUE','0000-00-00','MUHAMMAD','RAFIQUE','FATHER','0301-3964632','','','profile-1350562505.gif','STR AMAM BARGAH, HAWELI BUHADER SHAH TEHSIL SHORKOT,','STR AMAM BARGAH, HAWELI BUHADER SHAH TEHSIL SHORKOT,','SHORE KOOT','PAKISTAN','JHANG','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',10000,4,'33203-4242730-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,19,23,6,4,'MUHAMMAD','ASHIQ','0000-00-00','NATHY','KHAN','FATHER','0333-6594162','','','profile-1350562835.gif','H#P-262 STR#6 B.BLOCK ALJANAT COLONY\r\n','H#P-262 STR#6 B.BLOCK ALJANAT COLONY\r\n','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',12000,4,'33100-0984542-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,19,21,2,4,'MUHAMMAD ADIL','RAFIQUE','2012-08-01','MUHAMMAD','RAFIQUE','FATHER','03014633125','0300','','../../company/0/profile_pics/profile-50dedf4372de3.png','CHAK # 209 RB TEH &amp; DIST FAISALABAD','CHAK # 209 RB TEH &amp; DIST FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'123456789','1994-03-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,19,21,5,4,'ASIF','ALI','0000-00-00','ASHIQ','HUSSAIN','FATHER','0301.7066769','','','profile-1350563585.gif','CHAK NO#  215 RB P/O TEH JARANWALA DISTT FAISALABAD','CHAK NO#  215 RB P/O TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8500,20,'33100-8695210-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,19,21,2,4,'ZAHID','IQBAL','2012-06-01','MUHAMMAD','SARWAR','FATHER','03218788106','0300','','../../company/0/profile_pics/profile-50dee00920f27.png','CHAK #106 GB PO KHAS JARANWALA FSD','CHAK #106 GB PO KHAS JARANWALA FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',66,'fixed',0,0,'cash',10000,31,'33104-6152124-3','1993-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,19,21,2,4,'ALI','RAZA','2012-08-01','MUHAMMAD','AMIN','FATHER','3000','0300','','../../company/0/profile_pics/profile-50dee1598350b.png','CHAK NO# 229RB MAKKOWANA TEH JARANWALA DISST FAISALABAD','CHAK NO# 229RB MAKKOWANA TEH JARANWALA DISST FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33104-1981792-9','1992-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(33,19,21,2,4,'IFTHIKHAR','AHMED','2012-09-01','SYED NIAZ','HUSSAIN','FATHER','3030','0303','','../../company/0/profile_pics/profile-50dee1c9c28c3.png','CHAK NO #229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','CHAK NO #229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',10000,31,'33104-7394566-9','1989-12-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,19,21,5,4,'JAVAD','IQBAL','0000-00-00','NAZEER','HUSSAIN','FATHER','','','','profile-1350623386.gif','CHAK NO 104 GB SAMRAN FSD','CHAK NO 104 GB SAMRAN FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8500,20,'33104-9359289-9          ','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,19,21,2,4,'MUHAMMAD','SHAHNAWAZ','2012-08-01','MUHAMMAD','ALI','FATHER','0300','0300','','../../company/0/profile_pics/profile-50dee3df1989c.png','CHAK#229 R.B MAKKUANA,JARANWALA ROAD FAISALABAD','CHAK#229 R.B MAKKUANA,JARANWALA ROAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33104-2171591-3','1980-12-27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,19,21,2,4,'MUHAMMAD','WAQAS','2011-06-10','MUHAMMAD','ASLAM','FATHER','03017471700','0300','','../../company/0/profile_pics/profile-50e11f5f30e0e.png','CHAK#209 R.B,AKAAL GARH,DAK KHANA KHAS','CHAK#209 R.B,AKAAL GARH,DAK KHANA KHAS','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33103-4347379-1','1991-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(37,19,21,2,4,'ALLAH','DIN','2010-06-09','MUHAMMAD','TUFAIL','FATHER','0300','0300','','../../company/0/profile_pics/profile-50e11ffc95423.png','229 RB, MAKUANA','229 RB, MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',9000,31,'33104-7020194-7','1989-12-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(38,19,21,2,4,'MUHAMMAD','NADEEM','2010-01-13','MUHAMMAD','BASHIR','FATHER','03448734517','000','','../../company/0/profile_pics/profile-50e123315f9ec.png','KHAN MODEL COLONY S.3, HOUSE#P308 214RB,','KHAN MODEL COLONY S.3, HOUSE#P308 214RB,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',67,'fixed',0,0,'cash',9000,31,'31304-2074782-7','1983-08-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,19,21,2,4,'KHADIM','HUSSAIN','2010-08-09','MUHAMMAD','ISMAIL','FATHER','0300','0300','','../../company/0/profile_pics/profile-50e12425c4ebf.png','CHAK#229,R.B MAKKUANA JARANWALA','CHAK#229,R.B MAKKUANA JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,24,'33104-2169061-3','1969-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(40,19,21,2,4,'MUHAMMAD','IRFAN','2011-09-23','ABDUL','RASHID','FATHER','03016048234','0300','','../../company/0/profile_pics/profile-50e13a6514b7f.png','104 GB, JARANWALA FAISALABAD','104 GB, JARANWALA FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33104-1396954-3','1992-12-12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(41,19,21,2,4,'MUHAMMAD','SARFARAZ','2010-03-01','ALI','MUHAMMAD','FATHER','03127156379','0300','','../../company/0/profile_pics/profile-50e124d620eb8.png','CHACK#108 GB, P/O SAME, JARANWALA,','CHACK#108 GB, P/O SAME, JARANWALA,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',68,'fixed',0,0,'cash',9000,31,'33100-1234567-8','1990-08-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(42,19,21,2,4,'KHURRAM','ALI','2010-03-01','MUHAMMAD','SALEEM','FATHER','0300','0300','','../../company/0/profile_pics/profile-50e125376ada2.png','HOUSE#1411/24,STR#5 MOHALLAH SHADI PURA','HOUSE#1411/24,STR#5 MOHALLAH SHADI PURA','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',68,'fixed',0,0,'cash',9000,24,'33102-8284182-5','1989-11-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(43,14,37,2,4,'MUHAMMAD','MUSHATAQ','2006-04-25','ABDUL','GHAFOOR','FATHER','03137985432','03137985432','','../../company/0/profile_pics/profile-50ded0ffab487.png','MOHALLA NAWAB TOWN CHAK # 225 RB, \r\n','MOHALLA NAWAB TOWN CHAK # 225 RB, \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',15,'fixed',0,0,'btransfer',11500,16,'33100-0573548-7','1979-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(44,19,21,2,4,'MUHAMMAD','AZAM','2010-08-02','WILAYAT','ALI','FATHER','03447719604','0300','','../../company/0/profile_pics/profile-50e128d4ddc39.png','CHAK#214 R.B DHUDDI WALA,MUHALLAA BAQIR TEHSIL AND DISTRICT FAISALABAD','CHAK#214 R.B DHUDDI WALA,MUHALLAA BAQIR TEHSIL AND DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33104-2278992-5','1990-01-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(45,19,21,2,4,'MUHAMMAD','RASHID','2011-03-14','M.ASHRAF ','JAVED','FATHER','03477771767','03477771767','','../../company/0/profile_pics/profile-50e12a8d6c377.png','CHAK #215 AMDAD TOWN ST #3 H #P-129 JARANWALA ROAD FSD','CHAK #215 AMDAD TOWN ST #3 H #P-129 JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',8000,31,'33104-3254713-7','1973-12-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(46,19,21,2,4,'ABRAR','SADDIQUE','2011-07-18','SHAFQAT','HUSSAIN','FATHER','03063337729','03063337729','','../../company/0/profile_pics/profile-50e139b437f21.png','H#1324 GHALI NO 3 GHOUSIA PARK D TYPE COLONY FAISALABAD','H#1324 GHALI NO 3 GHOUSIA PARK D TYPE COLONY FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',68,'fixed',0,0,'cash',8000,31,'33100-8252405-9','1990-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(47,19,21,5,4,'MUJAHID','ALI','0000-00-00','LIAQAT','ALI','FATHER','','','','profile-1350967539.gif','CHAK NO 113 GB FSD','CHAK NO 113 GB FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,24,'33104-9445198-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(48,19,21,2,4,'MUHAMMAD','SHAHZAD','2010-05-01','MUHAMMAD','ISHAQ','FATHER','03007239626','0300','','../../company/0/profile_pics/profile-50e125e2c713b.png','H#03, STR#2 RANA TOWN, JARANWALA ROAD,FAISALABAD','H#03, STR#2 RANA TOWN, JARANWALA ROAD,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',9000,31,'33103-6317934-9','1990-03-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(49,19,21,2,4,'MUHAMMAD','BOOTA','2011-10-19','NAZEER ','AHMAD','FATHER','0300','0300','','../../company/0/profile_pics/profile-50e13bf4cd4ee.png','H#P.223,ST#9,MOHALLAH MOHAMMAD PURA,FSD','H#P.223,ST#9,MOHALLAH MOHAMMAD PURA,FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',8,'fixed',0,0,'cash',10000,31,'33100-4212519-9','1970-12-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(50,19,21,5,4,'IFTIKHAR','AHMAD','0000-00-00','SADIQ','ALI','FATHER','','','','profile-1350968761.gif','CHAK NO#229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','CHAK NO#229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,24,'33104-2619154-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(51,19,46,2,4,'MAZHAR','MALIK','2011-05-18','MUHAMMAD','MALIK','FATHER','3000','300','','../../company/0/profile_pics/profile-50dedc67a8bf0.png','CHAK # 216 JARANWALA ROAD MUHAMMAD WALA FSD','CHAK # 216 JARANWALA ROAD MUHAMMAD WALA FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','JUTT','NO','NO',10,'fixed',0,0,'cash',11500,24,'33104-7785994-2','1990-01-12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(52,19,21,2,4,'AKHTAR','ALI','2010-06-01','MUHAMMAD','HUSSAIN','FATHER','0300','0300','','../../company/0/profile_pics/profile-50e12747e716c.png','CHAK #111 GB TESIL JARANWALA DISTRCT FAISALABAD,','CHAK #111 GB TESIL JARANWALA DISTRCT FAISALABAD,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','JUTT','NO','NO',80,'fixed',0,0,'cash',9000,31,'33104-1936891-3','1980-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(53,19,30,2,4,'SHAHBAZ','MOON','2012-11-04','MUHAMMAD','MUNIR','FATHER','03226679224','03226679224','','../../company/0/profile_pics/profile-50deb9c56dc46.png','MAIN BAZAR  HOUSE#P-116 FAISALABAD','MAIN BAZAR  HOUSE#P-116 FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','JUTT','NO','NO',30,'Fixed',0,0,'Cash',12000,25,'33100-8013014-9','1984-02-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(54,19,30,2,4,'SHAHID','PARVEEZ','2012-05-03','REHMAT','ALI','FATHER','03457797044','03457797044','','../../company/0/profile_pics/profile-50deb7647e9cd.png','CHAK#214 RB, DHUDIWALA,','CHAK#214 RB, DHUDIWALA,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','A +','ISLAM','N/A','NO','NO',76,'fixed',0,0,'btransfer',12000,25,'33100-2831802-3','1980-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(55,19,30,2,4,'ABID','HUSSAIN','2011-01-06','ABDUL','KHALIQ','FATHER','03454540030','03454540030','','../../company/0/profile_pics/profile-50deb614edcf2.png','CHAK #104GB THESEL JARANWALA DEST FAISALABAD','CHAK #104GB THESEL JARANWALA DEST FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','RAJPUT','NO','NO',29,'fixed',0,0,'btransfer',30000,24,'33104-2254639-5','1982-10-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(56,19,30,5,4,'MAQSOOD','UL HASSAN','0000-00-00','HASSAN','AKHTAR','FATHER','0301.7121026','0301.7121026','','profile-1350973012.gif','CHAK NO# 108 GB TEH JARANWALA DISTT FAISALABAD','CHAK NO# 108 GB TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','RAJPUT','NO','NO',57,'fixed',0,0,'btransfer',20000,24,'33104-2257839-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(57,19,30,2,4,'FAHEEM','AKHTAR','2011-06-02','ASHIQ','ALI','FATHER','03007984032','03007984032','','../../company/0/profile_pics/profile-50dedbd97953a.png','CHAK # 128 GB JARANWALA FAISALABAD','CHAK # 128 GB JARANWALA FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','Male','P]','Single','Urdu','','ISLAM','SHAH','NO','NO',65,'fixed',0,0,'btransfer',14000,16,'33104-0240856-5','1989-03-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(58,21,35,2,4,'MUHAMMAD','AKRAM','1987-01-01','MUHAMMAD','ASLAM','FATHER','03016084812','03016084812','','../../company/0/profile_pics/profile-50dd74f38b457.png','SAIFABAD#2,   NAIMATABAD ROAD, JHANG ROADSTR#9,\r\n','SAIFABAD#2,   NAIMATABAD ROAD, JHANG ROADSTR#9,\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','O +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',17300,28,'33100-2285475-1','1967-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(59,21,35,2,4,'MUHAMMAD','AFZAL','2009-08-06','MUHAMMAD','HUSSAIN','FATHER','03449464220','03449464220','','../../company/0/profile_pics/profile-50dd7777b8c86.png','CHAK#107GB,          PATHAN KOAT,P.O SAME,TEH JARANWALA,','CHAK#107GB,          PATHAN KOAT,P.O SAME,TEH JARANWALA,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','A +','ISLAM','N/A','','NO',9,'fixed',0,0,'cash',10500,28,'33104-2220096-5','1977-07-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(60,21,35,2,4,'ZAHID','HUSSAIN','2008-03-12','MUHAMMAD','HANIF','FATHER','03026021368','03026021368','','../../company/0/profile_pics/profile-50dd436f3975d.png','CHAK#229 RB,MAKUAANA TEH JARANWALA, \r\n','CHAK#229 RB,MAKUAANA TEH JARANWALA, \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',26,'fixed',0,0,'btransfer',11500,28,'33100-1234567-1','1977-07-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(61,21,35,2,4,'MUHAMMAD','AZAM','2007-02-03','ABDUL','KHALIQ','FATHER','03437624872','03437624872','','../../company/0/profile_pics/profile-50dd78f2e6850.png','CHAK#123 GB,TEHSIL  JARANWALA  DISTRICT FAISALABAD,','CHAK#123 GB,TEHSIL  JARANWALA  DISTRICT FAISALABAD,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','AB +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',13000,28,'33104-2127250-1','1982-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(62,21,35,2,4,'RIZWAN','AHMAD','2009-11-12','ABDUL','RAZZAQ','FATHER','03216622436','03216622436','','../../company/0/profile_pics/profile-50dd7a5e523a7.png','H#460,STR#13, MUHALLA RAZA ABAD,','H#460,STR#13, MUHALLA RAZA ABAD,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','O +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',12500,28,'33102-7720229-5','1981-10-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,21,35,2,4,'MUHAMMAD','MAJID','2004-01-01','ALLHA','RAKHA','FATHER','03346418564','03346418564','','../../company/0/profile_pics/profile-50dd7ba755b24.png','CHAK# 214 R.B,       H#P-82,\r\n STR#6,HIMAT PURA, FAISALABAD','CHAK# 214 R.B,       H#P-82,\r\n STR#6,HIMAT PURA, FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','A +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',15800,24,'33100-5112438-1','1980-07-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,14,43,2,4,'QAISER','TABASSUM','2006-02-01','ABDUL','SATTAR','FATHER','03457835408','03457835408','','../../company/0/profile_pics/profile-50dd4123072fa.png','CHAK#108 GB,JARANWALA, FAISALABAD','CHAK#108 GB,JARANWALA, FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','N/A','NO','NO',62,'fixed',0,0,'btransfer',15000,16,'33104-2177072-7','1982-10-25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(65,21,35,2,4,'MAZAMIL','HUSSAIN','2003-06-30','MUHAMMAD ABDUL','MAJID','FATHER','03137078492','03137078492','','../../company/0/profile_pics/profile-50dd378d1689f.png','P-402,STR#5,DHUDIWALA, FAISALABAD.','P-402,STR#5,DHUDIWALA, FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','A +','ISLAM','N/A','NO','NO',25,'fixed',0,0,'btransfer',20000,26,'33102-1748420-9','1974-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(66,21,35,2,4,'SARWAR','HUSSAIN','2006-01-16','HASSAN','DIN','FATHER','03226316997','03226316997','','../../company/0/profile_pics/profile-50e173fad03ac.png','H#P-436C,PEOPLES COLONY#2,GHOSIA CHOWK,P.OFAWARA CHOWK,','H#P-436C,PEOPLES COLONY#2,GHOSIA CHOWK,P.OFAWARA CHOWK,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',14500,28,'33100-7039557-5','1977-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,21,35,2,4,'MAHMOOD-UL','HASSAN','2004-01-01','ABDUL','KAREEM','FATHER','03437393484','03437393484','','../../company/0/profile_pics/profile-50dd7da66411b.png','CHAK#473GB(BEEJA)P.O SAME,SAMUNDARI \r\n','CHAK#473GB(BEEJA)P.O SAME,SAMUNDARI \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',17500,28,'33100-1234567-1','1964-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,21,35,2,4,'NOOR','AHMAD','2009-06-03','SHAMAND','ALI','FATHER','03437433214','03437433214','','../../company/0/profile_pics/profile-50dd7e7a556be.png','CHAK#216 RB, MUHAMMAD WALA, P.OFFICE SAME, TEHSEEL JARANWALA,','CHAK#216 RB, MUHAMMAD WALA, P.OFFICE SAME, TEHSEEL JARANWALA,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','N/A','NO','NO',9,'fixed',0,0,'btransfer',11500,28,'33104-4096381-7','1978-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,14,41,2,4,'MUHAMMAD AKBAR','MALIK','2001-01-01','DOST','MUHAMMAD','FATHER','03017128302','03017128302','','../../company/0/profile_pics/profile-50ded3f606c44.png','DALL MOR, P.OFFICE ALI NAGAR, JHANG','DALL MOR, P.OFFICE ALI NAGAR, JHANG','DALMORE','PAKISTAN','JHANG','Male','PAKISTANI','Married','Urdu','','ISLAM','MALIK','NO','NO',18,'fixed',0,0,'cash',14500,38,'33202-1375643-1','1947-08-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,14,41,1,4,'YOUNIS','ALI','2012-12-02','BAAT','ALI','FATHER','03447878916','03447878916','','','MUHALLA RAZAABAD,ST#11 JARANWALA','MUHALLA RAZAABAD,ST#11 JARANWALA','JARANWALA','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','N/A','NO','NO',6,'fixed',0,0,'cash',8500,29,'33104-5415740-1','2012-12-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(71,14,41,2,4,'MANZOOR','HUSSAIN','2011-03-12','MUHAMMAD','ANWAR','FATHER','0300','0300','','../../company/0/profile_pics/profile-50ded4728ce0e.png','CHAK # 240 GB PO JARANWALA,TEH JARANWALA DIST FAISALABAD','CHAK # 240 GB PO JARANWALA,TEH JARANWALA DIST FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',6,'fixed',0,0,'cash',10500,38,'33104-2048828-1','1967-06-12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(72,14,39,2,4,'TARIQ','MASIH','2009-01-01','AMANAT','MASIH','FATHER','0300','0300','','../../company/0/profile_pics/profile-50ded2a282b66.png','DHUDIWALA\r\n','DHUDIWALA\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','CHTISTAIN','','NO','NO',14,'fixed',0,0,'cash',8500,33,'33100-1234567-8','1992-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(73,14,39,2,4,'GHULAM','RASOOL','2010-01-01','WALI','MUHAMMAD','FATHER','0300','0300','','../../company/0/profile_pics/profile-50ded2f73b98c.png','CHAK # 113 GB, P.O SAME, TEHSIL JARANWALA,','CHAK # 113 GB, P.O SAME, TEHSIL JARANWALA,','JARANWALA','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','','NO','NO',14,'fixed',0,0,'cash',8500,33,'33104-2106758-7','1976-04-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(74,22,24,2,4,'MUHAMMAD','AAMIR','2011-01-01','Muhammad ','Aslam','Father','03004096101','03004096101','','../../company/0/profile_pics/profile-50decfbfacda0.png','MUhallah near railway phatak farooq abad sheikhupura','MUhallah near railway phatak farooq abad sheikhupura','Sheikhupura','Pakistan','Punjab','Male','PAkistani','Married','Urdu','','Islam','Rana','No','ok',72,'',0,0,'',NULL,24,'35404-4815149-5','1976-02-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(75,14,39,2,4,'MUHAMMAD','MUSHTAQ','2012-12-18','ABDUL','GHAFAR','FATHER','03137985432','03007985432','','','MOHALLA NAWAB TOWN CHAK # 225 RB,','MOHALLA NAWAB TOWN CHAK # 225 RB,','FAISALABAD','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','RAJPUT','NO','NO',15,'fixed',0,0,'btransfer',11500,16,'33100-0573548-7','2012-12-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(76,14,39,2,4,'SHARAFAT ','ALI','2007-11-19','NOOR','MUHAMMAD','FATHER','0673501190','0673501190','','../../company/0/profile_pics/profile-50dec8001c3a4.png','CHAK#193 EB,P.O GAGU MANDI TEH BORYWALA,','CHAK#193 EB,P.O GAGU MANDI TEH BORYWALA,','BURYWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',13,'fixed',0,0,'cash',10500,16,'36601-5959008-9','1987-12-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(77,21,35,2,4,'MUHAMMAD','BOOTA','2011-10-19','NAZEER','HUSSAIN','FATHER','8741541','8741541','','../../company/0/profile_pics/profile-50dd82f83d57e.png','H#P223,ST#9,MOHALLA MUHAMMAD PURA','H#P223,ST#9,MOHALLA MUHAMMAD PURA','FAISALABAD','PAKISTAN','PUNJAB','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','OK',69,'fixed',0,0,'cash',10500,28,'33100-4212519-9','1970-12-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(78,14,4,2,4,'NAZAR','ABBAS','2006-07-17','ABDUL','SALAM','FATHER','03136502000','03136502000','','../../company/0/profile_pics/profile-50d00eef4d3db.png','HOUSE#1056/A,STR, MUHALLA 6,SHADAB  COLONY JHANG ROAD .FAISALABAD \r\n','HOUSE#1056/A,STR, MUHALLA 6,SHADAB  COLONY JHANG ROAD .FAISALABAD \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',77,'fixed',0,0,'btransfer',19500,16,'33100-0896824-9','1981-03-25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(79,14,4,2,4,'AAMIR','SHAHZAD','2011-06-20','GHULAM','ALI','FATHER','03339932461','03339932461','','../../company/0/profile_pics/profile-50d01047137bd.png','CHAK NO.461 G.B,TEHSIL SAMUNDARI,DISTRICT FAISALABAD.','CHAK NO.461 G.B,TEHSIL SAMUNDARI,DISTRICT FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',77,'fixed',0,0,'btransfer',15000,16,'03339932461','1988-01-12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(80,14,4,2,4,'NASIR','ALI','2011-11-28','MUHAMMAD','RAMAZAN','FATHER','03123650871','03123650871','','../../company/0/profile_pics/profile-50d01129c6335.png','P612, ALI HUOSING COLONY JHANG ROAD FAISALABAD.','P612, ALI HUOSING COLONY JHANG ROAD FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','N/A','NO','NO',77,'fixed',0,0,'btransfer',15000,16,'33100-0815251-3','1988-06-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,14,38,2,4,'ABDUL','GHAFOOR','2012-07-02','MUHAMMAD','YAQOOB','FATHER','8741541','8741541','','../../company/0/profile_pics/profile-50ded1ee0a243.png','MUHALLA FAROOQ ABAD,ST#19,H#2437','MUHALLA FAROOQ ABAD,ST#19,H#2437','FAISALABAD','PAKISTAN','PUNJAB','Male','PAKISTANI','','Punjabi','','ISLAM','','NO','OK',16,'fixed',0,0,'cash',15000,39,'33102-1771246-1','1956-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,14,4,2,4,'USMAN','AKRAM','2006-04-14','MUHAMMAD','AKRAM','FATHER','03017091245','03017091245','','../../company/0/profile_pics/profile-50d01258d8428.png','AWAMI COLONY STR#6, GHULISTAN ROAD,FAISALABAD','AWAMI COLONY STR#6, GHULISTAN ROAD,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','SHEIKH','NO','NO',77,'fixed',0,0,'btransfer',23000,16,'33102-4585527-7','1984-10-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(83,14,39,2,4,'MUHAMMAD','TAHIR','2012-04-12','KHUSHI','MUHAMMAD','FATHER','03007600298','03007600298','','../../company/0/profile_pics/profile-50dedac4e219b.png','CHAK NO 209/R.B TEH &amp; DISTT FAISALABAD','CHAK NO 209/R.B TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','PUNJAB','Male','PAKISTANI','Married','Punjabi','','ISLAM','RANA','NO','OK',7,'',0,0,'',NULL,26,'33100-1511498-9','1952-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,14,39,2,4,'LIAQAT','ALI','2010-08-13','KHUSHI','MUHAMMAD','FATHER','03027159767','03027159767','','../../company/0/profile_pics/profile-50deda229027e.png','CHAK NO 209/R.B TEH &amp; DISTT FAISALABAD','CHAK NO 209/R.B TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','PUNJAB','Male','PAKISTANI','Married','Punjabi','','ISLAM','RANA','NO','OK',7,'fixed',0,0,'cash',11500,16,'33100-9116309-5','1958-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,14,4,2,4,'CH.NAIMAT','ALI','2006-01-21','CH.MEHNGA ','KHAN','FATHER','03066097622','03066097622','','../../company/0/profile_pics/profile-50d013566ae31.png','107/E AL MASOOM TOWN SARFARAZ COLONY .PEOPLE COLONY NO#2 FAISALABAD\r\n \r\n','107/E AL MASOOM TOWN SARFARAZ COLONY .PEOPLE COLONY NO#2 FAISALABAD\r\n \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','N/A','NO','NO',78,'fixed',0,0,'btransfer',26500,16,'33100-6699838-7','1944-08-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,14,43,5,4,'MUHAMMAD','TAHIR','0000-00-00','ANAYET','KHAN','FATHER','03007600298','','','profile-1351164505.gif','CHAK NO 209/R.B FAISALABAD','CHAK NO 209/R.B FAISALABAD','FAISALABAD','PAKISTAN','PUNJAB','man','PAKISTANI','maried','Punjabi','A+','ISLAM','','NO','OK',57,'',0,0,'',NULL,26,'33100-1511498-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,14,43,5,4,'MUHAMMAD','TAHIR','0000-00-00','ANAYET','KHAN','FATHER','03007600298','','','profile-1351164509.gif','CHAK NO 209/R.B FAISALABAD','CHAK NO 209/R.B FAISALABAD','FAISALABAD','PAKISTAN','PUNJAB','man','PAKISTANI','maried','Punjabi','A+','ISLAM','','NO','OK',57,'fixed',0,0,'cash',10000,26,'33100-1511498-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(88,14,4,1,4,'ABAID','ULLHA','2012-06-14','ASIF','ALI','FATHER','03143013309','03143013309','','../../company/0/profile_pics/profile-50d0142dc66a3.png','Chak #139/RB Ghammi,Tehsil Chak Jhumra \r\nDistrict Faisalabad','Chak #139/RB Ghammi,Tehsil Chak Jhumra \r\nDistrict Faisalabad','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','N/A','NO','NO',77,'fixed',0,0,'cash',15000,16,'33101-8011353-3','1987-01-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(89,22,24,2,4,'MUHAMMAD','ASLAM','2012-02-10','MUHAMMAD','AFZAL','FATHER','03009198590','03009198590','','../../company/0/profile_pics/profile-50decf255bf24.png','FAROOQABAD VILLAGE NEAR JINNAH ACADEMY SHEIKHUPURA ','FAROOQABAD VILLAGE NEAR JINNAH ACADEMY SHEIKHUPURA ','Sheikhupura','PAKISTAN','PUNJAB','Male','PAKISTANI','Married','Punjabi','','ISLAM','RANA','NO','OK',71,'',0,0,'',NULL,31,'35404-5898524-1','1943-12-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(91,14,4,1,4,'MUHAMMAD TANSEER','ALI','2012-06-11','ABDUL','RASHEED','FATHER','03344356559','03344356559','','../../company/0/profile_pics/profile-50d0153ec6ea8.png','STAFF COLONY CIVIL HOSPITAL SHAHKOT,TEH SHAHKOT DISTT NANKANASAHIB','STAFF COLONY CIVIL HOSPITAL SHAHKOT,TEH SHAHKOT DISTT NANKANASAHIB','SHAHKOT','PAKISTAN','SHAHKOT','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',41,'fixed',0,0,'cash',35000,16,'35502-1680889-1','1986-02-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(92,14,39,2,4,'IMRAN','KHAN','2008-11-03','ZAHOOR','AHMED','FATHER','03027181585','03027181585','','../../company/0/profile_pics/profile-50ded71aef021.png','CHAK#214 RB, DAKHANA KHAS,  \r\nJARANWALA ROAD FAISALABAD','CHAK#214 RB, DAKHANA KHAS,  \r\nJARANWALA ROAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','RAJPUT','NO','NO',13,'fixed',0,0,'cash',10500,16,'33103-1533488-9','1988-11-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,14,39,2,4,'GHULAM','HUSSAIN','2009-11-23','MANZOOR','HUSSAIN','FATHER','03006562208','03006562208','','../../company/0/profile_pics/profile-50ded83f726d7.png','CHAK#208 RB, GUTWALA SAKHAN.P. O SAME,','CHAK#208 RB, GUTWALA SAKHAN.P. O SAME,','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',13,'fixed',0,0,'cash',10500,16,'33102-4769102-9','1989-04-26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,14,7,2,4,'ABDUL','HANAN','2009-10-01','MUHAMMAD ','ISRAR-UL-HAQ','FATHER','03226221232','03226221232','','../../company/0/profile_pics/profile-50dd73344787d.png','HOUSE NO 1-C,SAEED COLONY NO 2.DEFENSE BLOCK QURAN ACADEMY ROAD FAISALABAD\r\n','HOUSE NO 1-C,SAEED COLONY NO 2.DEFENSE BLOCK QURAN ACADEMY ROAD FAISALABAD\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','N/A','NO','NO',47,'fixed',0,0,'btransfer',16000,16,'33100-8375804-1','1991-10-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,14,39,2,4,'MUHAMMAD','ZUBAIR','2011-05-03','SARDAR','MUHAMMAD','FATHER','03157233266','03157233266','','../../company/0/profile_pics/profile-50ded8ece4f32.png','DUDI WALAH H # P-117 KHAN  MODEL COLONY FSD','DUDI WALAH H # P-117 KHAN  MODEL COLONY FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','SHIEKH','NO','NO',13,'fixed',0,0,'cash',10200,26,'33100-0467485-3','1983-04-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(96,14,41,2,4,'MUHAMMAD','ASHRAF','2012-12-02','MUHAMMAD','DIN','FATHER','03457889559','03457889559','','','CHAK # 559 GB PO KHAS TEH JARANWALA DIST FSD','CHAK # 559 GB PO KHAS TEH JARANWALA DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',10000,29,'33104-5420040-5','2012-12-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,22,25,2,4,'MANSAF','ALI','2009-04-20','NIAZ ','AHMAD','FATHER','03338900595','03338900595','','../../company/0/profile_pics/profile-50ded063e138d.png','H#72, BLOCK #7, WARD #2, MANDI TOWN,','H#72, BLOCK #7, WARD #2, MANDI TOWN,','BHAKKAR','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','N/A','NO','NO',35,'fixed',0,0,'btransfer',17500,26,'38101-0603417-7','1972-02-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,14,41,2,4,'ASGHAR','ALI','2010-03-26','NAZIR','AHMED','FATHER','03013932464','03013932464','','../../company/0/profile_pics/profile-50ded4f31544f.png','CHAK#229 RB MAKUAANA P.OFFICE SAME TEHSIL JARANWALA','CHAK#229 RB MAKUAANA P.OFFICE SAME TEHSIL JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',10500,39,'33104-1766327-1','1955-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,14,41,2,4,'GHULAM','ABBAS','2004-09-01','WALAYAT','KHAN','FATHER','03065517562','03065517562','','../../company/0/profile_pics/profile-50ded5472d65a.png','BASTI ABDULLAHPUR P.OFFICE ALI NAGAR,','BASTI ABDULLAHPUR P.OFFICE ALI NAGAR,','JHANG','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',11500,38,'33202-4062503-3','1968-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(100,21,35,2,4,'MUHAMMAD','QAISER','2008-06-01','MUHAMMAD','RAMAZAN','FATHER','8741541','8741541','','../../company/0/profile_pics/profile-50dd6fde77ee2.png','H#P-97,STR#4 PEOPLES COLONY#2 MOH MAQSOODABAD','H#P-97,STR#4 PEOPLES COLONY#2 MOH MAQSOODABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','A +','ISLAM','N/A','NO','NO',27,'fixed',0,0,'btransfer',13000,24,'33100-0617841-9','1982-11-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(101,14,41,2,4,'MUKHTAR','AHMED','2009-08-01','HIDAYAT','ALI','FATHER','03326569188','03326569188','','../../company/0/profile_pics/profile-50ded5d50782d.png','H#P-318,BLOCK C AHMAD NAGARCHAK#225 RB P.O MALKHANWALA\r\n','H#P-318,BLOCK C AHMAD NAGARCHAK#225 RB P.O MALKHANWALA\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',10500,39,'33100-0761742-3','1955-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(102,14,41,2,4,'ALLAH','DITTA','2009-09-09','HIDAYAT','BAIG','FATHER','03065452227','03065452227','','../../company/0/profile_pics/profile-50e175f4bbeb1.png','CHAK # 74 GB PAKEWAN , P.O SAME,  JARANWALA, \r\n\r\n','CHAK # 74 GB PAKEWAN , P.O SAME,  JARANWALA, \r\n\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','O +','ISLAM','','NO','NO',6,'fixed',0,0,'cash',10500,39,'33104-2169366-7','1954-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(103,14,41,2,4,'AHSAN','ILAHI','2012-03-10','FAZAL','ILAHI','FATHER','03034837473','03034837473','','../../company/0/profile_pics/profile-50ded62e197d6.png','CHAK NO#116 SB P/O TEH &amp;DISTT SARGODHA','CHAK NO#116 SB P/O TEH &amp;DISTT SARGODHA','SARGODHA','PAKISTAN','SARGODHA','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',9000,38,'38403-2056877-1','1951-11-27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(104,14,41,2,4,'SHEHZAD','HUSSAIN','2010-05-03','DOST','MUHAMMAD','FATHER','03047071783','03047071783','','../../company/0/profile_pics/profile-50ded6796fefb.png','MOZA BHUDWAL WALA, CHAH NO SHARIF P.OFFICE HAIDARABAD,','MOZA BHUDWAL WALA, CHAH NO SHARIF P.OFFICE HAIDARABAD,','HAIDERABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',6,'fixed',0,0,'cash',10500,38,'38104-9450194-7','1964-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(105,14,10,2,4,'KASHIF','SALEEM','2003-09-25','MUHAMMAD','SALEEM','FATHER','03336588288','03336588288','','../../company/0/profile_pics/profile-50deda3bb35e7.png','H#548, STR#7, SARFARAZ COLONY, FAISALABAD','H#548, STR#7, SARFARAZ COLONY, FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',61,'fixed',0,0,'btransfer',21000,16,'33100-0880555-3','1982-04-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,14,10,2,4,'MUHAMMAD','SHAFIQUE','1999-03-01','ZULFIQAR','ALI','FATHER','3336511101','3336511101','','../../company/0/profile_pics/profile-50dec522bdcdb.png','H.#237, A,BLOCK SITARA COLONY,SAMNAABAD FAISALABAD','H.#237, A,BLOCK SITARA COLONY,SAMNAABAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',60,'fixed',0,0,'btransfer',27500,16,'33100-0506381-3','1973-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(107,21,35,2,4,'QAMAR','ISLAM','2007-02-18','ISLAM','UD-DIN','FATHER','8741541','8741541','','../../company/0/profile_pics/profile-50dd84ee94f35.png','H#36,STR#3,MADINA TOWN,FAISALABAD','H#36,STR#3,MADINA TOWN,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','N/A','NO','NO',28,'fixed',0,0,'btransfer',17600,28,'33100-2266190-7','1961-03-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(108,14,10,2,4,'MUHAMMAD','AHMED','2000-09-01','NAWAB','UD DIN','FATHERQ','03007668107','03007668107','','../../company/0/profile_pics/profile-50dec5b289ad2.png','H#1, STR#1, SARFARAZ COLONY,\r\nFAISALABAD','H#1, STR#1, SARFARAZ COLONY,\r\nFAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',59,'fixed',0,0,'btransfer',29500,16,'33100-5136243-3','1965-08-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(109,14,33,2,4,'MUHAMMAD','QASIM ALTAF','2012-01-30','MUHAMMAD','ALTAF','FATHER','0345.7912009','0345.7912009','','../../company/0/profile_pics/profile-50debc6a14b9e.png','P.25 ST#1 NEW HASEEB SHAHEED COLONY NEAR MIAN CHOWK FAISALABAD','P.25 ST#1 NEW HASEEB SHAHEED COLONY NEAR MIAN CHOWK FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','SHIEKH','NO','NO',56,'',0,0,'',NULL,16,'33100-1894227-5','1983-11-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(110,14,33,6,4,'MUHAMMAD','QASIM ALTAF','0000-00-00','MUHAMMAD','ALTAF','FATHER','0345.7912009','0345.7912009','','profile-1351579546.gif','P.25 ST#1 NEW HASEEB SHAHEED COLONY NEAR MIAN CHOWK FAISALABAD','P.25 ST#1 NEW HASEEB SHAHEED COLONY NEAR MIAN CHOWK FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','SHIEKH','NO','NO',57,'fixed',0,0,'btransfer',20000,26,'33100-1894227-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(111,14,33,2,4,'IRFAN','KHAN','2007-04-17','TOHEED','AHMED','FATHER','03006623257','03006623257','','../../company/0/profile_pics/profile-50debd95491c2.png','HOUSE# P-514, STR#4, ANAND PURA FSD.','HOUSE# P-514, STR#4, ANAND PURA FSD.','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','KHAN','NO','NO',12,'fixed',0,0,'btransfer',31000,16,'33100-5276521-3','1970-06-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(112,14,33,6,4,'IFTIKHAR','AHMED','0000-00-00','MUNIR','AHMED','FATHER','0302-8659800','0302-8659800','','profile-1351580055.GIF','ALIF SANI CHOWK H#380, BLOCK B, G.M ABAD,','ALIF SANI CHOWK H#380, BLOCK B, G.M ABAD,','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','JUTT','NO','NO',57,'fixed',0,0,'btransfer',22000,26,'33100-9413244-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(113,14,39,2,4,'ABDUR','REHMAN','2012-12-02','YOUNIS','ALI','FATHER','03062314884','03062314884','','','MOHLLAH FATEH PUR CHAK# 215 RB PO KHAS FSD','MOHLLAH FATEH PUR CHAK# 215 RB PO KHAS FSD','FAISALABAD','PAKISTAN','FAISALABAD','','PAKISTANI','','Urdu','','ISLAM','N/A','NO','NO',57,'fixed',0,0,'cash',10500,29,'33103-1549564-9','2012-12-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(114,14,39,1,4,'MUHAMMAD','WASEEM SAJID','2012-06-01','NAZEER','AHMED','FATHER','03007656585','03007656585','','../../company/0/profile_pics/profile-50ded962af83b.png','P529 ST#1 OLD CENTRAL JAIL DJKOT ROAD FSD','P529 ST#1 OLD CENTRAL JAIL DJKOT ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',23,'fixed',0,0,'cash',12000,16,'33100-7406909-1','1983-02-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(115,21,26,2,4,'MUHAMMAD','SERWER','2007-10-15','JAAN','MUHAMMAD','FATHER','03027984363','03027984363','','../../company/0/profile_pics/profile-50decc9710639.png','CHAK#199 R.B GATWALA,DAK KHANA KHAS','CHAK#199 R.B GATWALA,DAK KHANA KHAS','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','','Urdu','','ISLAM','','NO','NO',79,'fixed',0,0,'cash',8400,31,'33100-0919084-5','1957-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(116,21,36,6,4,'MUHAMMAD','SAJID','0000-00-00','MUSHTAQ','AHMED','FATHER','0301.8696363','0301.8696363','','profile-1351582921.gif','HOUSE#P-83, STREET NO 2, MURAD ABAD GHULAM MUHAMMAD ABAD FSD.','HOUSE#P-83, STREET NO 2, MURAD ABAD GHULAM MUHAMMAD ABAD FSD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'',0,0,'',NULL,26,'33100-0968290-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(117,21,36,6,4,'MUHAMMAD','SAJID','0000-00-00','MUSHTAQ','AHMED','FATHER','0301.8696363','0301.8696363','','profile-1351582933.gif','HOUSE#P-83, STREET NO 2, MURAD ABAD GHULAM MUHAMMAD ABAD FSD.','HOUSE#P-83, STREET NO 2, MURAD ABAD GHULAM MUHAMMAD ABAD FSD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',24000,26,'33100-0968290-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(118,21,36,6,4,'MUHAMMAD','ALI','0000-00-00','MUHAMMAD','SADIQ','FATHER','0301-8625182','0301-8625182','','profile-1351583244.gif','MILLAT ROAD,ST#01,MUHALLA GHAUSIA ABAD,FAISALABAD.','MILLAT ROAD,ST#01,MUHALLA GHAUSIA ABAD,FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','AB+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',30500,26,'33102-4829674-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(119,21,36,6,4,'MUHAMMAD','BILAL','0000-00-00','MUHAMMAD','ASHRAF','FATHER','','','','profile-1351584013.gif','CHAK#73 R.B TIBBI,JARANWALA','CHAK#73 R.B TIBBI,JARANWALA','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',9500,26,'33104-6243206-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(120,21,36,6,4,'MUHAMMAD','QASIM','0000-00-00','ABDUL','HAQ','FATHER','0300-8667036','03008667036','','','20-W/5 madina town fsd','20-W/5 madina town fsd','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',45000,26,'33100-6095164-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(121,21,36,6,4,'MUHAMMAD','ILYAS','0000-00-00','TAAJ','DIN','FATHER','','','','profile-1351584729.gif','Chak#472 G.B Har Go Band Pura Same Post Office Tehsil Samundary  District Faisalabad','Chak#472 G.B Har Go Band Pura Same Post Office Tehsil Samundary  District Faisalabad','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',16000,26,'33105-7548767-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(122,21,36,6,4,'NOOR','MUHAMMAD','0000-00-00','MUHAMMAD','SULEMAN','FATHER','','','','','Chak No#318 G.B Post office 316 G.B Teh.&amp; Dict.Toba Tek Singh','Chak No#318 G.B Post office 316 G.B Teh.&amp; Dict.Toba Tek Singh','TOBA TEK SINGH','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'btransfer',16000,26,'33303-4123393-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(123,21,28,2,4,'NAZIR','AHMED','2008-01-24','MUNSHI','KHAN','FATHER','03457807485','03457807485','','../../company/0/profile_pics/profile-50dece620fc6b.png','SATO DAK KHANA SIKHANA BAJWA TAHSIL KAMOKI DIST. GUJRANWALA','SATO DAK KHANA SIKHANA BAJWA TAHSIL KAMOKI DIST. GUJRANWALA','GUJRANWALA','PAKISTAN','GUJRANWALA','Male','PAKISTANI','Married','Urdu','','ISLAM','','NO','NO',33,'fixed',0,0,'cash',8200,32,'34102-6714977-7','1954-03-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(124,21,35,2,4,'GHULAM','MOHIUD DIN','2008-07-12','AASHIQ','HUSSAIN','FATHER','03126503684','03126503684','','../../company/0/profile_pics/profile-50dd867d2f435.png','NEAR MASJID GULZAR HABIBSTR#8 REHMAN COLONY','NEAR MASJID GULZAR HABIBSTR#8 REHMAN COLONY','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','B +','ISLAM','','NO','NO',69,'fixed',0,0,'btransfer',11500,28,'33100-6502400-1','1985-09-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(125,21,35,2,4,'NAEEM ','JAVEED','2009-01-01','MUHAMMAD','RAFIQ','FATHER','03214330719','03214330719','','../../company/0/profile_pics/profile-50dd8846a0f3a.png','H#P378.ST#5,MOHALLA FATEH ABAD','H#P378.ST#5,MOHALLA FATEH ABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','O -','ISLAM','','NO','NO',9,'fixed',0,0,'cash',13000,28,'33100-6761738-9','1962-02-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(126,14,7,1,4,'MUHAMMAD','TOQEER ZAMEER','2012-05-05','MUHAMMAD','ZAMIT-UD-DIN','FATHER','12345','12345','','','Near punjab ice factory House#P-251 St#5 Mohallha badar colony Faisalabad','Near punjab ice factory House#P-251 St#5 Mohallha badar colony Faisalabad','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',57,'fixed',0,0,'cash',17000,26,'33100-0994724-7','1988-12-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(127,19,21,7,4,'ABID','ALI','0000-00-00','ABDUL','JABBAR','FATHER','','','','profile-1351663084.gif','NAI ABADI CHAK NO #229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','NAI ABADI CHAK NO #229 RB MAKOWANA TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','SHIEKH','LEG DISABILITY','NO',57,'wages',0,0,'cash',0,24,'33104-1894933-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(128,19,21,7,4,'ABID','HUSSAIN','0000-00-00','ZAFAR','IQBAL','FATHER','','','','profile-1351663260.gif','RANA TOWN CHAK NO 215 RB TEH &amp; DISTT FAISALABAD','RANA TOWN CHAK NO 215 RB TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','RAJPUT','NO','NO',57,'wages',0,0,'cash',0,24,'33103-4693176-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(129,19,21,7,4,'ASIF','NISAR','0000-00-00','NISAR','AHMED','FATHER','','','','profile-1351663448.gif','HOUSE NO 13,ST#2,MOHALA KHALID TOWN,JARANWALA ROAD FSD','HOUSE NO 13,ST#2,MOHALA KHALID TOWN,JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33102-3733992-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(130,19,21,7,4,'IRFAN','KHAN','0000-00-00','SARFRAZ','KHAN','FATHER','0344.4648553','0344.4648553','','profile-1351663657.gif','CHAK NO# 276 GB TEH JARANWALA DISTT FAISALABAD','CHAK NO# 276 GB TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','0+','ISLAM','KHAN','NO','NO',57,'wages',0,0,'cash',0,24,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(131,19,21,7,4,'MUHAMMAD','ALI','0000-00-00','MUHAMMAD','ZULFIQAR','FATHER','','','','profile-1351663918.gif','508 GB THEKRI WALA TEH JARANWALA DIST FAISALABAD','508 GB THEKRI WALA TEH JARANWALA DIST FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','MARTH','NO','NO',57,'wages',0,0,'cash',0,24,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(132,19,21,7,4,'MUHAMMAD','SAEED','0000-00-00','NAWAB','DIN','FATHER','','','','profile-1351664082.gif','CHAK NO# 229 R B TEH JARANWALA DISTT FAISALABAD','CHAK NO# 229 R B TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','JUTT','NO','NO',57,'wages',0,0,'cash',0,24,'33104-4188603-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(133,19,21,7,4,'MUHAMMAD','RAMZAN','0000-00-00','ABDUL','MAJEED','FATHER','','','','profile-1351664249.gif','chak no 113/G.B tehsil Jaranwala.','chak no 113/G.B tehsil Jaranwala.','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-9011258-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(134,19,21,5,4,'MUHAMMAD','SERWER','0000-00-00','MUHAMMAD','ANWAR','FATHER','03013035439','03013035439','','','CHAK NO 229/R.B MAKUANA,JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA,JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-2409937-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(135,19,21,7,4,'TARIQ','MEHMOOD','0000-00-00','MAQBOOL','AHMED','FATHER','0347-8872821','0347-8872821','','profile-1351665269.gif','CHAK #  104 GB PO KHAS TEH JARANWALA DIST FSD','CHAK #  104 GB PO KHAS TEH JARANWALA DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','RAJPUT','NO','NO',57,'wages',0,0,'cash',0,24,'33104-6233334-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(136,19,21,7,4,'ABDUL','GHAFAR','0000-00-00','ANAYAT','ULLAH','FATHER','','','','profile-1351665522.gif','CHAK NO 198,FAISALABAD','CHAK NO 198,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33100-0668268-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(137,19,21,7,4,'ARIF','ALI','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(138,19,21,7,4,'ARSHAD','HUSSAIN','0000-00-00','MAZHAR','HUSSAIN','FATHER','','','','profile-1351665984.gif','HOUSE NO 38P.ST#3 MOHALLA IQBAL NAGAR,FAISALABAD','HOUSE NO 38P.ST#3 MOHALLA IQBAL NAGAR,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33100-6163179-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(139,19,21,7,4,'FARYAD','HUSSAIN','0000-00-00','MUHAMMAD','BOOTA','FATHER','','','','profile-1351666283.gif','CHAK NO 229/R.B,MAKUANA','CHAK NO 229/R.B,MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-8976645-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(140,19,21,7,4,'JAVAID','IQBAL','0000-00-00','SAIF','ULLAH','FATHER','','','','profile-1351666457.gif','CHAK NO 211/R.B TEH JARANWALA.FAISALABAD','CHAK NO 211/R.B TEH JARANWALA.FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-7499944-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(141,19,21,7,4,'MUHAMMAD','ADIL','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','profile-1351666718.gif','CHAK NO 229/R.B MAKUANA','CHAK NO 229/R.B MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-3276833-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(142,19,21,7,4,'MUHAMMAD','ADNAN','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','profile-1351667108.gif','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(143,19,21,7,4,'MUHAMMAD','AFZAL','0000-00-00','MUHAMMAD','ANWAR','FATHER','','','','profile-1351667260.gif','CHAK NO 229/R.B MAKUANA','CHAK NO 229/R.B MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-2260082-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(144,19,21,7,4,'MUHAMMAD','ASIF SHEHZAD','0000-00-00','MUHAMMAD','ANWAR','FATHER','','','','profile-1351667581.gif','CHAK NO 229/R.B MAKUANA','CHAK NO 229/R.B MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','man','P&#039;','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-2260082-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(145,19,21,7,4,'MUHAMMAD','SAJID','0000-00-00','MUHAMMAD','TUFAIL','FATHER','','','','profile-1351667789.gif','CHAK NO 229/R.B MAKUANA,FSD','CHAK NO 229/R.B MAKUANA,FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-2147104-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(146,19,21,7,4,'MUHAMMAD','SALAM','0000-00-00','ABDUL','RASHEED','FATHER','','','','profile-1351667937.gif','CHAK NO 104/G.B JARANWALA','CHAK NO 104/G.B JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,16,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(147,19,21,7,4,'MUHAMMAD','WAHEED','0000-00-00','NAWAB','ALI','FATHER','','','','profile-1351668076.gif','KAKUANA,CHAK NO 215/R.B P/O SAME TEH &amp; DISTT FAISALABAD','KAKUANA,CHAK NO 215/R.B P/O SAME TEH &amp; DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33103-4740713-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(148,19,21,7,4,'MAZHAR','IQBAL','0000-00-00','NOOR','MUHAMMAD','FATHER','','','','','HASUKY P/O 363/G.B TEH TANDLIANWALA.DISTT FAISALABAD','HASUKY P/O 363/G.B TEH TANDLIANWALA.DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',8,'wages',0,0,'cash',0,24,'33106-8943227-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(149,19,21,7,4,'MUHAMMAD','ZEESHAN','0000-00-00','KHAN','MUHAMMAD','FATHER','','','','profile-1351668424.gif','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-4063400-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(150,19,21,7,4,'NAEEM','ULLAH','0000-00-00','UMAR FAROOQ','RASHID','FATHER','','','','profile-1351668615.gif','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'',0,0,'',NULL,24,'33104-6412438-7','2066-00-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(151,19,21,7,4,'NAEEM','ULLAH','0000-00-00','UMAR FAROOQ','RASHID','FATHER','','','','profile-1351668626.gif','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','CHAK NO 229/R.B MAKUANA JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'wages',0,0,'cash',0,24,'33104-6412438-7','2066-00-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(152,19,21,7,4,'TARIQ','MEHMOOD','0000-00-00','SHAHDAT','ALI','FATHER','','','','profile-1351668776.gif','CHAK NO 276/G.B TEH JARANWANA,FSD','CHAK NO 276/G.B TEH JARANWANA,FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'',0,0,'',NULL,24,'33104-7315094-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(153,21,47,7,4,'ASGHAR','ALI','0000-00-00','BASHEER','AHMED','FATHER','0300-6564606','0300-6564606','','profile-1351678528.gif','SITARA WEAVING INDUSTRIES CHAK# 295 G.B BYRIAN WALA','SITARA WEAVING INDUSTRIES CHAK# 295 G.B BYRIAN WALA','BERIYAN WALA','PAKISTAN','BERIYAN WALA','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',20000,24,'33303-5617296-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(154,21,47,7,4,'SHOUKAT','ALI','0000-00-00','NABI','AHMED','FATHER','03068489983','03068489983','','profile-1351678837.gif','CHAK # 349 EB, P.OFFICE 157 EB,TEHSIL ARIFWALA,','CHAK # 349 EB, P.OFFICE 157 EB,TEHSIL ARIFWALA,','SAHIWAL','PAKISTAN','SAHIWAL','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',85000,25,'36601-1571268-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(155,21,26,7,4,'MUHAMMAD','FIAZ','0000-00-00','ABDUL','LATIF','FATHER','','','','profile-1351679096.gif','CHAK#291 W.B TAHSIL DUNYA PUR,DIST. LODHRAN','CHAK#291 W.B TAHSIL DUNYA PUR,DIST. LODHRAN','LODHRAN','PAKISTAN','LODHRAN','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',94000,25,'36201-0276397-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(156,21,47,7,4,'SHOUKAT','ALI','0000-00-00','BASHEER','AHMED','FATHER','','','','profile-1351679572.gif','SITARA WEAVING INDUSTRIES,TEHSIL &amp; DISTT. T.T SINGH.','SITARA WEAVING INDUSTRIES,TEHSIL &amp; DISTT. T.T SINGH.','TOBA TEK SINGH','PAKISTAN','TOBA TEK SINGH','man','PAKISTANI','maried','Urdu','A+','ISLAM','RAJPUT','NO','NO',57,'fixed',0,0,'cash',89000,25,'33303-1859071-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(157,21,47,7,4,'MUHAMMAD','SERWER','0000-00-00','MANZOOR','HUSSAIN','FATHER','03008791024','03008791024','','profile-1351680332.gif','H# 447,MOHD MNAGAR,BUREWALA','H# 447,MOHD MNAGAR,BUREWALA','BURYWALA','PAKISTAN','BERIYAN WALA','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,25,'36601-1189092-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(158,22,24,7,4,'MUHAMMAD','RAMAZAN','0000-00-00','MUHAMMAD','DIN','FATHER','','','','profile-1351680379.gif','SHAK NO.563 G.B P.O KHAS, TEHSIL JARANWALA.FAISALABAD.','SHAK NO.563 G.B P.O KHAS, TEHSIL JARANWALA.FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','N/A','NO','NO',57,'fixed',0,0,'cash',10000,29,'33104-5237654-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(159,22,24,7,4,'MUHAMMAD','SHAN','0000-00-00','BASHIR','AHMAD','FATHER','','','','profile-1351680531.gif','CHAK NO 140 GB TEHSIL SAMUNDRI DISTT. FSD.','CHAK NO 140 GB TEHSIL SAMUNDRI DISTT. FSD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',57,'fixed',0,0,'cash',10000,29,'33104-5842896-8','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(160,21,47,7,4,'MUHAMMAD','NADEEM','0000-00-00','RANA','SHOUKAT','FATHER','','','','profile-1351680596.gif','MOHALA SHIEKHA  WALA GHALI NO 8  FAISALABAD','MOHALA SHIEKHA  WALA GHALI NO 8  FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','RAJPUT','NO','NO',57,'fixed',0,0,'cash',13700,29,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(161,21,47,7,4,'JAFFAR','ALI','0000-00-00','SULTAN','ALI','FATHER','0300-7291390','0300-7291390','','profile-1351680831.gif','CHAK#34,16 L KOT SUBHAN MIAN CHANU','CHAK#34,16 L KOT SUBHAN MIAN CHANU','MIAN CHANU','PAKISTAN','MIAN CHANU','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7500,25,'33100-1234567-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(162,21,47,7,4,'MUHAMMAD','SHAREEF','0000-00-00','MUHAMMAD','SHAKOOR','FATHER','','','','profile-1351681073.gif','chah dewan wala,aludywali, p/o rohelanwali teh &amp; distt MUZAFIRGARH','chah dewan wala,aludywali, p/o rohelanwali teh &amp; distt MUZAFIRGARH','MUZAFIRGARH','PAKISTAN','MUZAFIRGARH','man','PAKISTANI','single','Urdu','A+','ISLAM','ARAIEN','NO','NO',57,'fixed',0,0,'cash',8000,25,'32304-9159258-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(163,21,47,7,4,'MUHAMMAD','NADEEM','0000-00-00','MUHAMMAD','YOUNIS','FATHER','','','','profile-1351681251.gif','CHAK # 493 EB PO CHAK # 495 EB TEH BURAYWALA , DIST VEHARI','CHAK # 493 EB PO CHAK # 495 EB TEH BURAYWALA , DIST VEHARI','VEHARI','PAKISTAN','VEHARI','man','PAKISTANI','single','Urdu','A+','ISLAM','ARAIEN','NO','NO',57,'fixed',0,0,'cash',7900,25,'36601-1867160-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(164,21,47,7,4,'ATIF','SALEEM','0000-00-00','BASHEER','AHMED','FATHER','','','','profile-1351684705.gif','CHAK#388 R.B TEHSIL,DIST TOBA TEK SINGH','CHAK#388 R.B TEHSIL,DIST TOBA TEK SINGH','TOBA TEK SINGH','PAKISTAN','TOBA TEK SINGH','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,25,'33303-2100617-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(165,21,47,7,4,'MALIK','NISAR ALI','0000-00-00','MUHAMMAD','SALEEM','FATHER','','','','profile-1351684862.gif','CHAK# 229 RB MAKUWANA PO KHAS TEH, JARANWALA, DIST FSD','CHAK# 229 RB MAKUWANA PO KHAS TEH, JARANWALA, DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7900,25,'33104-2182633-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(166,21,47,7,4,'MUHAMMAD','SAEED','0000-00-00','ABDUL','MAJEED','FATHER','','','','profile-1351685043.gif','CHAK NO#1 MOBANA P/O SHAH JAMAL TEH&amp; DISTT MAZAFAER GHAR','CHAK NO#1 MOBANA P/O SHAH JAMAL TEH&amp; DISTT MAZAFAER GHAR','MAZAFAER GHAR','PAKISTAN','MAZAFAER GHAR','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8400,25,'12304-0162877-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(167,21,47,7,4,'MUHAMMAD','SHEHBAZ','0000-00-00','NUSHER','ALI','FATHER','','','','profile-1351745194.gif','CHAK #238 RB AWAN WALA TE &amp; DIST FSD','CHAK #238 RB AWAN WALA TE &amp; DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7900,25,'33103-1396900-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(168,21,47,7,4,'SIKANDAR','HAYAT','0000-00-00','MUHAMMAD','HUSSAIN','FATHER','','','','profile-1351745346.gif','CHAK # 238 RB  PO KHAS TEH &amp; DIST FAISALABAD','CHAK # 238 RB  PO KHAS TEH &amp; DIST FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7900,25,'33100-9532692-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(169,21,47,7,4,'MUHAMMAD','ASLAM','0000-00-00','ANAYAT','ULLAH','FATHER','','','','profile-1351745530.gif','CHAK NO 119/R.B BHLER P/O SAME TEH SANGLAHIL DISTT NANKANA','CHAK NO 119/R.B BHLER P/O SAME TEH SANGLAHIL DISTT NANKANA','NANKANA','PAKISTAN','NANKANA','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8400,25,'35503-0146091-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(170,21,47,7,4,'MUHAMMAD','AFZAL','0000-00-00','SHAFI','MUHAMMAD','FATHER','','','','profile-1351745970.gif','CHAK#229 RB, ALMANA MAKOOANA, JARANWALA','CHAK#229 RB, ALMANA MAKOOANA, JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',6500,25,'33104-9438038-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(171,21,47,7,4,'SHAHDAT','ALI','0000-00-00','SALEH','MUHAMMAD','FATHER','','','','profile-1351746188.gif','CHAK#229 R.B MAKUANA DAK KHANA KHAS TAHSIL JARANWALA DIST. FAISLABAD','CHAK#229 R.B MAKUANA DAK KHANA KHAS TAHSIL JARANWALA DIST. FAISLABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,25,'33104-7993447-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(172,21,47,7,4,'MUHAMMAD','MANSHA','0000-00-00','MUHAMMAD','YOUNIS','FATHER','','','','profile-1351748333.gif','Chak.196/ EB Tehsil &amp; Distt vehari','Chak.196/ EB Tehsil &amp; Distt vehari','VEHARI','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',4500,25,'36603-7959495-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(173,21,47,7,4,'KHIZAR','HAYAT','0000-00-00','MUHAMMAD','SHAFI','FATHER','','','','profile-1351748625.gif','CHAK#229 R.B MAKKU&#039;ANA TEHSIL JARANWALA','CHAK#229 R.B MAKKU&#039;ANA TEHSIL JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','AB+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,25,'33104-7811947-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(174,21,47,7,4,'AMEER','MUHAMMAD','0000-00-00','SHEER','MUHAMMAD','FATHER','','','','profile-1351748818.gif','CHAK NO#229 R B MAKOWANA TEH JARANWALA DISTT FAISALABAD','CHAK NO#229 R B MAKOWANA TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,25,'33104-2992653-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(175,21,47,7,4,'MUHAMMAD','SHEHBAZ','0000-00-00','MUHAMMAD','MUMTAZ','FATHER','','','','profile-1351749022.gif','CHAK NO 229/R.B JARANWALA','CHAK NO 229/R.B JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5400,25,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(176,21,47,7,4,'MUHAMMAD','WAQAS','0000-00-00','ALTAF','HUSSAIN','FATHER','','','','','CHAK NO 214/R.B DHUDIWALA,HOUSE#174,ST# 3 MOHALA FAREED TOWN FAISALABAD','CHAK NO 214/R.B DHUDIWALA,HOUSE#174,ST# 3 MOHALA FAREED TOWN FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5400,25,'33102-4011750-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(177,22,24,7,4,'MAQBOOL','AHMED','0000-00-00','MURAD','ALI','FATHER','','','','profile-1351751357.gif','BHAN PUR,P/O PURAN PUR TEH &amp; DISTT GUJRANWALA','BHAN PUR,P/O PURAN PUR TEH &amp; DISTT GUJRANWALA','GUJRANWALA','PAKISTAN','GUJRANWALA','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',10500,29,'34101-7176721-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(178,22,24,7,4,'FAKHAR','ABBAS','0000-00-00','GULZAR','AHMED','FATHER','','','','profile-1351751676.gif','CHAK 742/G.B P/O SAME,TEH KAMALIA DISTT TTSINGH','CHAK 742/G.B P/O SAME,TEH KAMALIA DISTT TTSINGH','TOBA TEK SINGH','PAKISTAN','TOBA TEK SINGH','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7500,29,'33302-3409256-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(179,22,24,7,4,'MUHAMMAD','IJAZ','0000-00-00','REHMAT','ALI','FATHER','','','','profile-1351751844.gif','CHAK NO 142/G.B TEH KAMALIA DISTT TOBA TEK SINGH','CHAK NO 142/G.B TEH KAMALIA DISTT TOBA TEK SINGH','TOBA TEK SINGH','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7000,29,'33302-1449562-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(180,22,24,7,4,'MUHAMMAD','TANVEER HUSSAIN','0000-00-00','BASHEER','AHMED','FATHER','0300-6090968','0300-6090968','','','CHAK#84 G.B,P.O#78 G.B TEHSIL &amp; DISTT. FSD.','CHAK#84 G.B,P.O#78 G.B TEHSIL &amp; DISTT. FSD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','0-','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7000,29,'33100-7058904-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(181,22,24,7,4,'GHULAM','MURTAZA','0000-00-00','GULAM','MOHUIDIN','FATHER','','','','profile-1351758168.gif','CHAK NO 106/G.B P/O SAME JARANWALA','CHAK NO 106/G.B P/O SAME JARANWALA','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',7500,29,'33104-2118957-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(182,22,24,7,4,'SABIR','ALI','0000-00-00','MUHAMMAD','YOUSIF','FATHER','','','','profile-1351763906.gif','CHAK NO 229 RB JARANWALA ROAD FAISALABAD','CHAK NO 229 RB JARANWALA ROAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,29,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(183,22,24,7,4,'BABER','NAZIR','0000-00-00','NAZIR','AHMED','FATHER','','','','profile-1351764127.gif','CHAK NO 229 RB JARANWALA ROAD FAISALABAD','CHAK NO 229 RB JARANWALA ROAD FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,29,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(184,22,24,7,4,'MULAZIM','HUSSAIN','0000-00-00','MUHAMMAD','MUKHTAR','FATHER','03068743229','03068743229','','profile-1351764465.gif','NAI ABADI BAI PASS ROAD CHAK # 225 RB PO KHAS JARANWALA FSD','NAI ABADI BAI PASS ROAD CHAK # 225 RB PO KHAS JARANWALA FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,29,'33104-6193279-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(185,22,24,5,4,'SHAMAS','UD DIN','0000-00-00','ROSHAN','ALI','FATHER','','','','profile-1351764698.gif','HOUSE NO 172,FAREED TOWN COLUNY CHAK 214/R.B DHUDUWALA,FAISALABAD','HOUSE NO 172,FAREED TOWN COLUNY CHAK 214/R.B DHUDUWALA,FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','N',57,'fixed',0,0,'cash',6000,16,'33100-7027374-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(186,22,24,7,4,'BAHADUR','ALI','0000-00-00','IMAM','ALI','FATHER','03007059803','03007059803','','profile-1351765252.gif','BALA ARAIEN TEHSIL &amp; DISTT. BAHAWALNAGAR.','BALA ARAIEN TEHSIL &amp; DISTT. BAHAWALNAGAR.','BAHAWALNAGAR.','PAKISTAN','BAHAWALNAGAR.','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',17000,29,'31101-6997963-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(187,22,24,7,4,'RASHID ','ALI','0000-00-00','MUHAMMAD','SARDAR','FATHER','','','','profile-1351765560.gif','CHAK NO# 229 RB MAKOWANA P/O KHAS TEH JARANWALA DISTT FAISALABAD','CHAK NO# 229 RB MAKOWANA P/O KHAS TEH JARANWALA DISTT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,29,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(188,22,24,7,4,'AZAM','HUSSAIN','0000-00-00','MUHAMMAD','SADIQ','FATHER','','','','profile-1351765924.gif','NAI ABADI NAZD MASJID TAFHIM AL QURAN MALHU.P/O SINGOTHI,TEH &amp; DISTT JEHLUM','NAI ABADI NAZD MASJID TAFHIM AL QURAN MALHU.P/O SINGOTHI,TEH &amp; DISTT JEHLUM','JEHLUM','PAKISTAN','JEHLUM','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',18000,29,'37301-3369055-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(189,21,35,7,4,'KHALID','MEHMOOD','0000-00-00','ALLAH','JAWAYA','FATHER','0345-7890270','0345-7890270','','profile-1351766410.gif','CHAK#229 R.B DAK KHANA KHAS JARANWALA','CHAK#229 R.B DAK KHANA KHAS JARANWALA','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5000,25,'33104-2223692-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(190,14,8,2,4,'SAFWAN','HANIF','2007-10-01','MUHAMMAD','HANIF','FATHER','03326652422','0418524168','','../../company/0/profile_pics/profile-50deb9a8d08a7.png','P-296 HAMZA CHOWK KASHMIR ROAD KHAYABAN COLONY#2','P-296 HAMZA CHOWK KASHMIR ROAD KHAYABAN COLONY#2\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','Muslim','NO','NO',52,'fixed',0,0,'btransfer',16000,16,'3310095302711','1984-11-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(191,14,8,2,4,'HAMID','NADEEM','2008-02-08','MUNEER','AHMED','FATHER','03457686074','03457686074','','../../company/0/profile_pics/profile-50deba27382b7.png','H#560 STR#6/A  MASOODABAD \r\n','H#560 STR#6/A  MASOODABAD \r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','BHATTI','NO','NO',20,'fixed',0,0,'btransfer',20000,16,'33100-1625725-1','1976-08-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(192,21,35,7,4,'SHAMAND','ALI','0000-00-00','ABDUL','REHMAN','FATHER','','','','profile-1351768295.gif','CHAK NO.229 R.B MAKKUANA DISTT.FAISALABAD.','CHAK NO.229 R.B MAKKUANA DISTT.FAISALABAD.','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',6000,25,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(193,21,35,7,4,'AZIZ','UR REHMAN','0000-00-00','MUHAMMAD','SERWER','FATHER','','','','profile-1351768606.gif','CHAK # 238 RB AWAN WALAPO CHAK # 275 TEH &amp; DIST FSD','CHAK # 238 RB AWAN WALAPO CHAK # 275 TEH &amp; DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','MALIK','NO','NO',57,'fixed',0,0,'cash',7200,25,'33103-5290998-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(194,21,35,7,4,'BUSHARAT','ALI','0000-00-00','RIYASAT','ALI','FATHER','','','','profile-1351768879.gif','CHAK#214 DHUDHI WALA FAISALABAD','CHAK#214 DHUDHI WALA FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5400,25,'33100-1234567-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(195,21,35,7,4,'SABIR','ALI','0000-00-00','BASARA','BASARA','FATHER','','','','profile-1351769129.gif','CHAK#112 D.B DAK,KHANA CHAK#108','CHAK#112 D.B DAK,KHANA CHAK#108','BAHAWALPUR','PAKISTAN','BAHAWALPUR','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',4500,25,'33100-4588413-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(196,21,35,7,4,'SANA','ULLAH','0000-00-00','NOOR','MUHAMMAD','FATHER','','','','profile-1351769368.gif','CHAK # 111 GB PO KHAS TEH JARANWALA DIST FSD','CHAK # 111 GB PO KHAS TEH JARANWALA DIST FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','KHOKHAR','NO','NO',57,'fixed',0,0,'cash',5600,25,'33104-4764216-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(197,14,7,2,4,'AZEEM','SADIQ','2011-06-20','MUHAMMAD','SADIQ','FATHER','03227107080','03227107080','','../../company/0/profile_pics/profile-50dd7d0b194a5.png','H # 134/12 GALI TALIB WALI TALI MOHLLAH PAKPATTAN','H # 134/12 GALI TALIB WALI TALI MOHLLAH PAKPATTAN','PAKPATTAN','PAKISTAN','PAKPATTAN','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',48,'fixed',0,0,'btransfer',13000,16,'36402-5474595-9','1990-04-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(198,14,11,2,4,'IMRAN','ALI','2005-12-01','ALI','HASSAN','FATHER','03006654474','03006654474','','../../company/0/profile_pics/profile-50dec64f3dc30.png','CHAK # 68 GB, TEHSIL JARANWALA, DISTT.FAISALABAD','CHAK # 68 GB, TEHSIL JARANWALA, DISTT.FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',21,'fixed',0,0,'btransfer',13500,16,'33104-3238788-3','1985-02-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(199,14,11,2,4,'ZAFAR','IQBAL','2010-06-17','ALI','MUHAMMAD','FATHER','03007645033','03007645033','','../../company/0/profile_pics/profile-50dec6e52f5f8.png','CHAK # 273-GB, TEHSIL JARANWALA,','CHAK # 273-GB, TEHSIL JARANWALA,','JARANWALA','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',22,'fixed',0,0,'cash',10500,16,'33104-3708194-5','1984-04-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(200,19,21,6,4,'MUHAMMAD','AZAM','0000-00-00','WALAYAT','ALI','FATHER','0344-7719604','0344-7719604','','profile-1351771090.gif','CHAK#214 R.B DHUDDI WALA,MUHALLAA BAQIR','CHAK#214 R.B DHUDDI WALA,MUHALLAA BAQIR','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,24,'33102-3482068-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(201,19,21,5,4,'FARYAD','HUSSAIN','0000-00-00','BASHEER','AHMED','FATHER','','','','profile-1351771287.gif','CHAK NO 224/G.B P/O 273/G.B TEH JARANWALA','CHAK NO 224/G.B P/O 273/G.B TEH JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','AB+','ISLAM','','NO','NO',57,'wages',0,0,'cash',285,24,'33104-5788698-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(202,19,21,6,4,'MUHAMMAD','ARFAN','0000-00-00','ABDUL','RASHEED','FATHER','','','','profile-1351771420.gif','104 GB, JARANWALA FAISALABAD','104 GB, JARANWALA FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','RAJPUT','NO','NO',57,'fixed',0,0,'cash',8000,24,'33104-2047697-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(203,19,21,6,4,'MUHAMMAD','RASHID','0000-00-00','MUHAMMAD','ASHRAF JAVEED','FATHER','0347-7771767','0347-7771767','','profile-1351771665.gif','CHAK #215 AMDAD TOWN ST #3 H #P-129 JARANWALA ROAD FSD','CHAK #215 AMDAD TOWN ST #3 H #P-129 JARANWALA ROAD FSD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,24,'31104-9420189-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(204,21,35,7,4,'UMAR','HAYAT','0000-00-00','LIAQAT','ALI','FATHER','','','','profile-1351771934.gif','chak no 229/R.B makuana,teh jaranwala,FAISALABAD','chak no 229/R.B makuana,teh jaranwala,FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',0,25,'33104-1610786-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(205,21,27,7,4,'MUHAMMAD','ARSLAN','0000-00-00','MUHAMMAD','MANSHA','FATHER','','','','profile-1351772316.gif','CHAK NO 229/R.B MAKUANA','CHAK NO 229/R.B MAKUANA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5400,25,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(206,21,35,7,4,'AZAM','ALI','0000-00-00','MUHAMMAD','SHAREEF','FATHER','','','','profile-1351772522.gif','CHAK#229 R.B DAK&#039;KHANA KHAS,JARANWALA','CHAK#229 R.B DAK&#039;KHANA KHAS,JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',5500,25,'33105-6340853-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(207,21,35,7,4,'MUHAMMAD','ASIF','0000-00-00','ABDUL','SATTAR','FATHER','0302-7049202','0302-7049202','','profile-1351772764.gif','CHAK#229 R.B MAKUANA TAHSIL JARANWALA','CHAK#229 R.B MAKUANA TAHSIL JARANWALA','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',57,'fixed',0,0,'cash',8000,16,'33104-8125009-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(208,14,5,2,4,'MUHAMMAD','ASGHAR','2010-02-01','MUHAMMAD','SADIQUE','FATHER','03006648155','03006648155','','../../company/0/profile_pics/profile-50deb91a0d0eb.png','H#3/A PEOPLES COLONY#2 MUHAMMADI CHOCK FAISALABAD','H#3/A PEOPLES COLONY#2 MUHAMMADI CHOCK FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Married','Urdu','','ISLAM','SHIEKH','NO','NO',12,'fixed',0,0,'btransfer',27000,16,'33100-0815460-3','1978-07-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(209,14,7,2,4,'MUHAMMAD','LATIF AKKAS','2008-10-07','ABDUL','RASHEED','FATHER','03027172730','03027172730','','../../company/0/profile_pics/profile-50dd7e01493de.png','SOHAILABAD NEAR BATALA COLONY, SATYANA ROAD,FAISALABAD\r\n','SOHAILABAD NEAR BATALA COLONY, SATYANA ROAD,FAISALABAD\r\n','FAISALABAD','PAKISTAN','FAISALABAD','Male','PAKISTANI','Single','Urdu','','ISLAM','','NO','NO',43,'fixed',0,0,'cash',20000,26,'33100-8314244-5','1985-11-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(210,19,23,5,4,'ADEEL ','ABBAS','0000-00-00','GHULAM','ABBAS','FATHER','0323-6032528','','','','HOUSE#P-863 STREET#1 MOHALLHA GAHZI ABAD SALEEMI CHOWK FAISALABAD','HOUSE#P-863 STREET#1 MOHALLHA GAHZI ABAD SALEEMI CHOWK FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','B+','ISLAM','N/A','NO','NO',35,'fixed',0,0,'cash',15000,26,'33102-9497812-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(211,19,21,7,4,'MUHAMMAD ','ARSLAN','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','','WARD #8 GHALA MANDI HOUSE#B-VI/343 SAHIWAL','WARD #8 GHALA MANDI HOUSE#B-VI/343 SAHIWAL','SAHIWAL','PAKISTAN','SAHIWAL','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',8,'wages',0,0,'cash',285,24,'36502-0345296-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(212,19,21,7,4,'ABUZAR','ALI','0000-00-00','MUHAMMAD','DAWOOD','FATHER','','','','','CHAK#229 R B TEHSIL JARANWAL DISTRICT FAISALABAD','CHAK#229 R B TEHSIL JARANWAL DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',8,'wages',0,0,'cash',285,24,'33100-5358469-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(213,19,21,7,4,'SHAHID ','PERVAIZ','0000-00-00','ABDUL','RASHEED','FATHER','0313-5641229','','','','CHAK#229 RB TEHSIL JARANWAL DISTRICT FAISALABAD','CHAK#229 RB TEHSIL JARANWAL DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',8,'wages',0,0,'cash',285,24,'33104-4870853-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(214,19,21,7,4,'WASEEM','ALI','0000-00-00','NAZEER','HUSSAIN','FATHER','','','','','CHAK #104 SAMRAN TEHSIL JARANWALA DISTRICT FAISALABAD','CHAK #104 SAMRAN TEHSIL JARANWALA DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',31,'wages',0,0,'cash',285,24,'33104-6147691-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(215,19,21,7,4,'BILAL','MOHION DIN','0000-00-00','MUHAMMAD','ASLAM','FATHER','0343-7624872','','','','BILAL COLONY DHUDI WALA HOUSE # 10 ST#1 MOHALLHA HASSAN PURA FAISALABAD','BILAL COLONY DHUDI WALA HOUSE # 10 ST#1 MOHALLHA HASSAN PURA FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','N/A','NO','NO',31,'wages',0,0,'cash',285,24,'33102-7103303-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(216,19,21,7,4,'JAVED','IQBAL','0000-00-00','MUHAMMAD','IQBAL','FATHER','','','','profile-1353303863.gif','CHAK#109 RB JARANWALA FAISALABAD','CHAK#109 RB JARANWALA FAISALABAD','JARANWALA','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','RAJPUT','NO','NO',8,'wages',0,0,'cash',285,24,'33104-9994025-3','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(217,19,21,7,4,'MAZHAR','IQBAL','0000-00-00','ABDUL','GHANI','FATHER','','','','profile-1353304589.bmp','JALVI MARKEET MOHALLHA HASSAN PURA FAISALABAD','JALVI MARKEET MOHALLHA HASSAN PURA FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',31,'wages',0,0,'cash',225,24,'','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(218,21,47,7,4,'MUHAMMAD','AKBAR','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','profile-1353305758.bmp','CHAK#5 RATIAN SANGLA HILL, NANAKANA','CHAK#5 RATIAN SANGLA HILL, NANAKANA','NANKANA','PAKISTAN','NANKANA','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',82,'fixed',0,0,'cash',8400,29,'35403-3220232-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(219,21,47,7,4,'ASIF','MANZOOR','0000-00-00','MANZOOR','HUSSAIN','FATHER','','','','profile-1353305960.bmp','CHAK#104 IQBAL NAGAR,CHECHA WATNI, SAHIWAL','CHAK#104 IQBAL NAGAR,CHECHA WATNI, SAHIWAL','SAHIWAL','PAKISTAN','SAHIWAL','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',82,'fixed',0,0,'cash',8400,29,'36501-1916709-1','2041-05-08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(220,19,4,7,4,'MUHAMMAD','ARSLAN','0000-00-00','MUHAMMAD','ASLAM','FATHER','','','','profile-1353307682.jpg','WARD #8 GHALA MANDI HOUSE#B-VI/343 SAHIWAL','WARD #8 GHALA MANDI HOUSE#B-VI/343 SAHIWAL','SAHIWAL','PAKISTAN','SAHIWAL','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',8,'wages',0,0,'cash',285,24,'36502-0345296-7','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(221,19,21,7,4,'ABU','ZAR','0000-00-00','MUHAMMAD','DAUD','FATHER','','','','profile-1353308129.jpg','CHAK#229 R B TEHSIL JARANWAL DISTRICT FAISALABAD','CHAK#229 R B TEHSIL JARANWAL DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','','NO','NO',8,'wages',0,0,'cash',285,24,'33100-5358469-1','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(222,19,21,7,4,'SHAHID','PARVEEZ','0000-00-00','ABDUL','RASHEED','FATHER','','','','profile-1353308337.jpg','CHAK#229 R B MAKUANA TEHSIL JARANWAL DISTRICT FAISALABAD','CHAK#229 R B MAKUANA TEHSIL JARANWAL DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','maried','Urdu','A+','ISLAM','ARAIEN','NO','NO',8,'wages',0,0,'cash',285,24,'33104-4870853-9','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(223,19,21,7,4,'WASEEM','ALI','0000-00-00','NAZEER','HUSSAIN','FATHER','','','','profile-1353309885.jpg','CHAK #104 SAMRAN TEHSIL JARANWALA DISTRICT FAISALABAD','CHAK #104 SAMRAN TEHSIL JARANWALA DISTRICT FAISALABAD','FAISALABAD','PAKISTAN','FAISALABAD','man','PAKISTANI','single','Urdu','A+','ISLAM','','NO','NO',31,'wages',0,0,'cash',225,24,'33104-6147691-5','0000-00-00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `0_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_allowance`
--

DROP TABLE IF EXISTS `0_employee_allowance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_allowance` (
  `employee_allowance_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `allowance_amount` decimal(10,0) NOT NULL,
  `allowance_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_allowance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_allowance`
--

LOCK TABLES `0_employee_allowance` WRITE;
/*!40000 ALTER TABLE `0_employee_allowance` DISABLE KEYS */;
INSERT INTO `0_employee_allowance` VALUES (1,1,1000,3);
/*!40000 ALTER TABLE `0_employee_allowance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tax_groups`
--

DROP TABLE IF EXISTS `0_tax_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tax_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `tax_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tax_groups`
--

LOCK TABLES `0_tax_groups` WRITE;
/*!40000 ALTER TABLE `0_tax_groups` DISABLE KEYS */;
INSERT INTO `0_tax_groups` VALUES (1,'Tax',0,0),(2,'Tax Exempt',0,0);
/*!40000 ALTER TABLE `0_tax_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_credit_status`
--

DROP TABLE IF EXISTS `0_credit_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_credit_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason_description` char(100) NOT NULL DEFAULT '',
  `dissallow_invoices` tinyint(1) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `reason_description` (`reason_description`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_credit_status`
--

LOCK TABLES `0_credit_status` WRITE;
/*!40000 ALTER TABLE `0_credit_status` DISABLE KEYS */;
INSERT INTO `0_credit_status` VALUES (1,'Good History',0,0),(3,'No more work until payment received',1,0),(4,'In liquidation',1,0);
/*!40000 ALTER TABLE `0_credit_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_attachments`
--

DROP TABLE IF EXISTS `0_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(60) NOT NULL DEFAULT '',
  `type_no` int(11) NOT NULL DEFAULT '0',
  `trans_no` int(11) NOT NULL DEFAULT '0',
  `unique_name` varchar(60) NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `filename` varchar(60) NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `filetype` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type_no` (`type_no`,`trans_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_attachments`
--

LOCK TABLES `0_attachments` WRITE;
/*!40000 ALTER TABLE `0_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tsize`
--

DROP TABLE IF EXISTS `0_tsize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tsize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tsize`
--

LOCK TABLES `0_tsize` WRITE;
/*!40000 ALTER TABLE `0_tsize` DISABLE KEYS */;
INSERT INTO `0_tsize` VALUES (5,70,140,550,''),(6,30,30,200,''),(7,45,75,300,''),(8,50,90,325,'');
/*!40000 ALTER TABLE `0_tsize` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_debtor_trans`
--

DROP TABLE IF EXISTS `0_debtor_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_debtor_trans` (
  `trans_no` int(11) unsigned NOT NULL DEFAULT '0',
  `type` smallint(6) unsigned NOT NULL DEFAULT '0',
  `version` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `debtor_no` int(11) unsigned DEFAULT NULL,
  `branch_code` int(11) NOT NULL DEFAULT '-1',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  `reference` varchar(60) NOT NULL DEFAULT '',
  `tpe` int(11) NOT NULL DEFAULT '0',
  `order_` int(11) NOT NULL DEFAULT '0',
  `ov_amount` double NOT NULL DEFAULT '0',
  `ov_gst` double NOT NULL DEFAULT '0',
  `ov_freight` double NOT NULL DEFAULT '0',
  `ov_freight_tax` double NOT NULL DEFAULT '0',
  `ov_discount` double NOT NULL DEFAULT '0',
  `alloc` double NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '1',
  `ship_via` int(11) DEFAULT NULL,
  `dimension_id` int(11) NOT NULL DEFAULT '0',
  `dimension2_id` int(11) NOT NULL DEFAULT '0',
  `payment_terms` int(11) DEFAULT NULL,
  PRIMARY KEY (`type`,`trans_no`),
  KEY `debtor_no` (`debtor_no`,`branch_code`),
  KEY `tran_date` (`tran_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_debtor_trans`
--

LOCK TABLES `0_debtor_trans` WRITE;
/*!40000 ALTER TABLE `0_debtor_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_debtor_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_grn_items`
--

DROP TABLE IF EXISTS `0_grn_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_grn_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_batch_id` int(11) DEFAULT NULL,
  `po_detail_item` int(11) NOT NULL DEFAULT '0',
  `item_code` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext,
  `qty_recd` double NOT NULL DEFAULT '0',
  `quantity_inv` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `grn_batch_id` (`grn_batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_grn_items`
--

LOCK TABLES `0_grn_items` WRITE;
/*!40000 ALTER TABLE `0_grn_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_grn_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_shift`
--

DROP TABLE IF EXISTS `0_shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_shift` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `standard_shift_start` time NOT NULL,
  `standard_shift_end` time NOT NULL,
  `standard_relax_start` time NOT NULL,
  `standard_relax_end` time NOT NULL,
  `description` varchar(900) NOT NULL,
  `rotation_flag` int(11) DEFAULT NULL,
  `rotation_interval` int(11) DEFAULT NULL,
  `rotation_shift_start` time NOT NULL,
  `rotation_shift_end` time NOT NULL,
  `rotation_relax_start` time NOT NULL,
  `rotation_relax_end` time NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_shift`
--

LOCK TABLES `0_shift` WRITE;
/*!40000 ALTER TABLE `0_shift` DISABLE KEYS */;
INSERT INTO `0_shift` VALUES (16,'HEAD OFFICE GENERAL','09:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(24,'HEAD OFFICE GENERAL II','10:00:00','18:00:00','13:00:00','14:00:00','LATE MORNING',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(25,'STITCHING GENERAL','09:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(26,'GREIGE GODOWN GENERAL','09:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(28,'GREIGE GODOWN II','08:30:00','17:30:00','13:00:00','14:00:00','EARLY MORNING BEFORE GENERAL',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(29,'TOWEL WEAVING GENERAL','09:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(31,'WEAVING GENERAL','09:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(32,'WEAVING MORNING','08:00:00','16:30:00','13:00:00','14:00:00','LABOUR MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(33,'WEAVING EARLY MORNING','05:00:00','13:00:00','08:45:00','09:00:00','EARLY MORNING LABOUR SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(34,'WEAVING EVENING SHIFT','13:00:00','21:00:00','16:45:00','17:00:00','SECOND SHIFT OF WEAVERS',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(37,'WEAVING NIGHT SHIFT','21:00:00','05:00:00','12:45:00','01:00:00','THIRD SHIFT OF WEAVERS',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(38,'SECURITY FIRST SHIFT','06:00:00','18:00:00','13:00:00','14:00:00','MORNING SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00'),(39,'SECURITY SECOND SHIFT','18:00:00','06:00:00','12:00:00','12:00:00','NIGHT SHIFT',NULL,NULL,'00:00:00','00:00:00','00:00:00','00:00:00');
/*!40000 ALTER TABLE `0_shift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tcustomer`
--

DROP TABLE IF EXISTS `0_tcustomer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tcustomer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text NOT NULL,
  `ntn` bigint(20) NOT NULL,
  `contact_pname` text NOT NULL,
  `contact_pdesig` text NOT NULL,
  `contact_pno` text NOT NULL,
  `stype` varchar(100) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tcustomer`
--

LOCK TABLES `0_tcustomer` WRITE;
/*!40000 ALTER TABLE `0_tcustomer` DISABLE KEYS */;
INSERT INTO `0_tcustomer` VALUES (2,'ABc',2583697417,'UsmanAli','towelexporter','3258','Commercial Dyer','');
/*!40000 ALTER TABLE `0_tcustomer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_useronline`
--

DROP TABLE IF EXISTS `0_useronline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_useronline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(15) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  `file` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=9257 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_useronline`
--

LOCK TABLES `0_useronline` WRITE;
/*!40000 ALTER TABLE `0_useronline` DISABLE KEYS */;
INSERT INTO `0_useronline` VALUES (9245,1356959960,'182.189.151.137','/index.php'),(9246,1356959967,'192.168.0.18','/index.php'),(9250,1356960005,'192.168.0.18','/hrm/transactions/transaction_penalty.php'),(9248,1356959999,'192.168.0.18','/hrm/transactions/transaction_attendance.php'),(9253,1356960030,'192.168.0.18','/hrm/transactions/transaction_salary.php'),(9255,1356960060,'182.189.151.137','/hrm/transactions/transaction_attendance_confirmation.php'),(9254,1356960030,'192.168.0.18','/hrm/transactions/transaction_salary.php'),(9251,1356960027,'192.168.0.18','/hrm/transactions/transaction_resignation.php'),(9256,1356960078,'182.189.151.137','/index.php'),(9252,1356960027,'192.168.0.18','/hrm/transactions/transaction_resignation.php'),(9247,1356959999,'192.168.0.18','/hrm/transactions/transaction_attendance.php'),(9249,1356960005,'192.168.0.18','/hrm/transactions/transaction_penalty.php');
/*!40000 ALTER TABLE `0_useronline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_purch_order_details`
--

DROP TABLE IF EXISTS `0_purch_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_purch_order_details` (
  `po_detail_item` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL DEFAULT '0',
  `item_code` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext,
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `qty_invoiced` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `act_price` double NOT NULL DEFAULT '0',
  `std_cost_unit` double NOT NULL DEFAULT '0',
  `quantity_ordered` double NOT NULL DEFAULT '0',
  `quantity_received` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`po_detail_item`),
  KEY `order` (`order_no`,`po_detail_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_purch_order_details`
--

LOCK TABLES `0_purch_order_details` WRITE;
/*!40000 ALTER TABLE `0_purch_order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_purch_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_dimensions`
--

DROP TABLE IF EXISTS `0_dimensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_dimensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `type_` tinyint(1) NOT NULL DEFAULT '1',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference` (`reference`),
  KEY `date_` (`date_`),
  KEY `due_date` (`due_date`),
  KEY `type_` (`type_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_dimensions`
--

LOCK TABLES `0_dimensions` WRITE;
/*!40000 ALTER TABLE `0_dimensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_dimensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_status`
--

DROP TABLE IF EXISTS `0_employee_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_status` (
  `employee_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_status`
--

LOCK TABLES `0_employee_status` WRITE;
/*!40000 ALTER TABLE `0_employee_status` DISABLE KEYS */;
INSERT INTO `0_employee_status` VALUES (1,'ON PROBATION'),(2,'CONFIRMED'),(3,'RESIGNED'),(4,'TERMINATED');
/*!40000 ALTER TABLE `0_employee_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tax_group_items`
--

DROP TABLE IF EXISTS `0_tax_group_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tax_group_items` (
  `tax_group_id` int(11) NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`tax_group_id`,`tax_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tax_group_items`
--

LOCK TABLES `0_tax_group_items` WRITE;
/*!40000 ALTER TABLE `0_tax_group_items` DISABLE KEYS */;
INSERT INTO `0_tax_group_items` VALUES (1,1,5);
/*!40000 ALTER TABLE `0_tax_group_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_prices`
--

DROP TABLE IF EXISTS `0_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(20) NOT NULL DEFAULT '',
  `sales_type_id` int(11) NOT NULL DEFAULT '0',
  `curr_abrev` char(3) NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `price` (`stock_id`,`sales_type_id`,`curr_abrev`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_prices`
--

LOCK TABLES `0_prices` WRITE;
/*!40000 ALTER TABLE `0_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_grn_batch`
--

DROP TABLE IF EXISTS `0_grn_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_grn_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `purch_order_no` int(11) DEFAULT NULL,
  `reference` varchar(60) NOT NULL DEFAULT '',
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `loc_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_date` (`delivery_date`),
  KEY `purch_order_no` (`purch_order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_grn_batch`
--

LOCK TABLES `0_grn_batch` WRITE;
/*!40000 ALTER TABLE `0_grn_batch` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_grn_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_users`
--

DROP TABLE IF EXISTS `0_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `real_name` varchar(100) NOT NULL DEFAULT '',
  `role_id` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `date_format` tinyint(1) NOT NULL DEFAULT '0',
  `date_sep` tinyint(1) NOT NULL DEFAULT '0',
  `tho_sep` tinyint(1) NOT NULL DEFAULT '0',
  `dec_sep` tinyint(1) NOT NULL DEFAULT '0',
  `theme` varchar(20) NOT NULL DEFAULT 'default',
  `page_size` varchar(20) NOT NULL DEFAULT 'A4',
  `prices_dec` smallint(6) NOT NULL DEFAULT '2',
  `qty_dec` smallint(6) NOT NULL DEFAULT '2',
  `rates_dec` smallint(6) NOT NULL DEFAULT '4',
  `percent_dec` smallint(6) NOT NULL DEFAULT '1',
  `show_gl` tinyint(1) NOT NULL DEFAULT '1',
  `show_codes` tinyint(1) NOT NULL DEFAULT '0',
  `show_hints` tinyint(1) NOT NULL DEFAULT '0',
  `last_visit_date` datetime DEFAULT NULL,
  `query_size` tinyint(1) DEFAULT '10',
  `graphic_links` tinyint(1) DEFAULT '1',
  `pos` smallint(6) DEFAULT '1',
  `print_profile` varchar(30) NOT NULL DEFAULT '1',
  `rep_popup` tinyint(1) DEFAULT '1',
  `sticky_doc_date` tinyint(1) DEFAULT '0',
  `startup_tab` varchar(20) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_users`
--

LOCK TABLES `0_users` WRITE;
/*!40000 ALTER TABLE `0_users` DISABLE KEYS */;
INSERT INTO `0_users` VALUES (1,'admin','f6882e63875336f33b3866442386a199','Administrator',2,'','adm@adm.com','C',0,0,0,0,'aqua','Letter',2,2,4,1,1,0,0,'2012-12-31 18:14:09',10,1,1,'',1,0,'hrm',0,NULL),(3,'Ammad Altaf','a1c3b53dab08a267e1333b65a69238a9','M. Ammad Altaf',12,'9999999','ammad@aitextiles.com','C',0,0,0,0,'aqua','Letter',2,2,4,1,1,0,0,'2012-12-31 04:49:18',25,1,1,'',1,0,'hrm',0,1),(4,'SHAKEEL','ce0b996aa0b7d64169a4b8ffeaf878c5','Shakeel Asif',13,'33333','audit@aitextiles.com','C',0,0,0,0,'cool','Letter',2,2,4,1,1,0,0,'2012-12-25 23:55:54',10,1,1,'',1,0,'hrm',0,76),(5,'safwan','cc03e747a6afbbcbf8be7668acfebee5','Safwan Hanif',2,'999','','C',0,0,0,0,'aqua','Letter',2,2,4,1,1,0,0,'2012-12-31 18:19:27',10,1,1,'',1,0,'hrm',0,18);
/*!40000 ALTER TABLE `0_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_payroll`
--

DROP TABLE IF EXISTS `0_employee_payroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_payroll` (
  `employee_id` int(11) NOT NULL,
  `basic_salary` decimal(10,0) DEFAULT NULL,
  `allowances` decimal(10,0) DEFAULT NULL,
  `deductions` decimal(10,0) DEFAULT NULL,
  `lates` decimal(10,0) DEFAULT NULL,
  `leaves` decimal(10,0) DEFAULT NULL,
  `advances` decimal(10,0) DEFAULT NULL,
  `installments` decimal(10,0) DEFAULT NULL,
  `field1` decimal(10,0) DEFAULT NULL,
  `field2` decimal(10,0) DEFAULT NULL,
  `field3` decimal(10,0) DEFAULT NULL,
  `field4` decimal(10,0) DEFAULT NULL,
  `field5` decimal(10,0) DEFAULT NULL,
  `field6` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `last_update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `overdue_days` int(11) DEFAULT NULL,
  `absents` decimal(10,0) DEFAULT NULL,
  `payable_salary` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_payroll`
--

LOCK TABLES `0_employee_payroll` WRITE;
/*!40000 ALTER TABLE `0_employee_payroll` DISABLE KEYS */;
INSERT INTO `0_employee_payroll` VALUES (1,39355,0,-580,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,710,'2012-12-31 06:28:04',30,-38065,-580),(2,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:05',30,0,0),(3,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:05',30,-29516,0),(4,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:05',30,-29516,0),(5,23613,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,23613,'2012-12-31 06:28:05',30,0,12000),(6,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,20661,'2012-12-31 06:28:05',30,0,10500),(7,31484,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:05',30,-31484,0),(8,59032,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:06',30,-59032,0),(9,27548,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:06',30,-27548,0),(10,21645,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:06',30,-21645,0),(11,23613,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:06',30,-23613,0),(12,43290,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:06',30,-43290,0),(13,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-39355,0),(14,45258,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-45258,0),(15,53129,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-53129,0),(16,43290,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-43290,0),(17,49194,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-49194,0),(18,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-39355,0),(19,118065,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:07',30,-118065,0),(20,72806,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:08',30,-72806,0),(21,12000,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12000,'2012-12-17 07:46:09',18,NULL,NULL),(22,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:08',30,-15742,0),(23,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:08',30,-15742,0),(24,10000,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10000,'2012-12-17 07:46:11',18,NULL,NULL),(25,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,39355,'2012-12-31 06:28:08',30,0,20000),(26,13774,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:08',30,-13774,0),(27,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,19677,'2012-12-31 06:28:08',30,0,10000),(28,23613,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,23613,'2012-12-31 06:28:08',30,0,12000),(29,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:08',30,-15742,0),(30,8500,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8500,'2012-12-17 07:46:12',18,NULL,NULL),(31,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:09',30,-19677,0),(32,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:09',30,-15742,0),(33,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:09',30,-19677,0),(34,8500,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8500,'2012-12-17 07:46:13',18,NULL,NULL),(35,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:09',30,-15742,0),(36,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:09',30,-15742,0),(37,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-17710,0),(38,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-17710,0),(39,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-15742,0),(40,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:10',30,0,8000),(41,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-17710,0),(42,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-17710,0),(43,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:10',30,-22629,0),(44,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:11',30,-15742,0),(45,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:11',30,-15742,0),(46,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:11',30,0,8000),(47,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:11',30,0,8000),(48,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:11',30,-17710,0),(49,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,19677,'2012-12-31 06:28:11',30,0,10000),(50,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:11',30,0,8000),(51,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:11',30,-22629,0),(52,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:12',30,-17710,0),(53,23613,0,-300,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,-300,'2012-12-31 06:28:12',30,-23613,-300),(54,23613,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:13',30,-23613,0),(55,59032,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:13',30,-59032,0),(56,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,39355,'2012-12-31 06:28:13',30,0,20000),(57,27548,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:13',30,-27548,0),(58,34042,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-34042,0),(59,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-20661,0),(60,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-22629,0),(61,25581,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-25581,0),(62,24597,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-24597,0),(63,31090,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:14',30,-31090,0),(64,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-29516,0),(65,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-39355,0),(66,28532,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-28532,0),(67,34435,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-34435,0),(68,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-22629,0),(69,28532,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-28532,0),(70,16726,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-16726,0),(71,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:15',30,-20661,0),(72,16726,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-16726,0),(73,16726,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-16726,0),(74,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,0,0),(75,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-22629,0),(76,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-20661,0),(77,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-20661,0),(78,38371,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-38371,0),(79,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:16',30,-29516,0),(80,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,-29516,0),(81,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,-29516,0),(82,45258,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,-45258,0),(83,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,0,0),(84,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,-22629,0),(85,52145,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,-52145,0),(86,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:17',30,0,0),(87,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,19677,'2012-12-31 06:28:17',30,0,10000),(88,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:18',30,-29516,0),(89,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:18',30,0,0),(91,68871,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:18',30,-68871,0),(92,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:18',30,-20661,0),(93,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:18',30,-20661,0),(94,31484,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:19',30,-31484,0),(95,20071,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:19',30,-20071,0),(96,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:19',30,-19677,0),(97,34435,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:19',30,-34435,0),(98,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,339,'2012-12-31 06:28:20',30,-20323,0),(99,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:20',30,-22629,0),(100,25581,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:20',30,-25581,0),(101,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:20',30,-20661,0),(102,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:20',30,-20661,0),(103,17710,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-17710,0),(104,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-20661,0),(105,41323,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-41323,0),(106,54113,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-54113,0),(107,34632,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-34632,0),(108,58048,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,-58048,0),(109,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:21',30,0,0),(110,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,39355,'2012-12-31 06:28:22',30,0,20000),(111,61000,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:22',30,-61000,0),(112,43290,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,43290,'2012-12-31 06:28:22',30,0,22000),(113,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:22',30,-20661,0),(114,23613,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:22',30,-23613,0),(115,16529,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:22',30,-16529,0),(116,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:22',30,0,0),(117,47226,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,47226,'2012-12-31 06:28:22',30,0,24000),(118,60016,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,60016,'2012-12-31 06:28:22',30,0,30500),(119,18694,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,18694,'2012-12-31 06:28:22',30,0,9500),(120,88548,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,88548,'2012-12-31 06:28:22',30,0,45000),(121,31484,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,31484,'2012-12-31 06:28:22',30,0,16000),(122,31484,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,31484,'2012-12-31 06:28:22',30,0,16000),(123,16135,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,-16135,0),(124,22629,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,-22629,0),(125,25581,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,-25581,0),(126,33452,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,-33452,0),(127,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(128,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(129,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(130,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(131,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(132,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(133,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(134,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(135,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(136,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(137,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(138,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:23',30,0,0),(139,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(140,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(141,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(142,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(143,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(144,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(145,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(146,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(147,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(148,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(149,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(150,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(151,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(152,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:24',30,0,0),(153,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,39355,'2012-12-31 06:28:24',30,0,20000),(154,167258,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,167258,'2012-12-31 06:28:24',30,0,85000),(155,184968,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,184968,'2012-12-31 06:28:24',30,0,94000),(156,175129,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,175129,'2012-12-31 06:28:24',30,0,89000),(157,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:24',30,0,8000),(158,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,19677,'2012-12-31 06:28:24',30,0,10000),(159,19677,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,19677,'2012-12-31 06:28:24',30,0,10000),(160,26958,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,26958,'2012-12-31 06:28:24',30,0,13700),(161,14758,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,14758,'2012-12-31 06:28:24',30,0,7500),(162,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:24',30,0,8000),(163,15545,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15545,'2012-12-31 06:28:24',30,0,7900),(164,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:24',30,0,8000),(165,15545,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15545,'2012-12-31 06:28:25',30,0,7900),(166,16529,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,16529,'2012-12-31 06:28:25',30,0,8400),(167,15545,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15545,'2012-12-31 06:28:25',30,0,7900),(168,15545,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15545,'2012-12-31 06:28:25',30,0,7900),(169,16529,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,16529,'2012-12-31 06:28:25',30,0,8400),(170,12790,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,12790,'2012-12-31 06:28:25',30,0,6500),(171,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(172,8855,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,8855,'2012-12-31 06:28:25',30,0,4500),(173,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(174,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(175,10626,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10626,'2012-12-31 06:28:25',30,0,5400),(176,10626,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10626,'2012-12-31 06:28:25',30,0,5400),(177,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,20661,'2012-12-31 06:28:25',30,0,10500),(178,14758,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,14758,'2012-12-31 06:28:25',30,0,7500),(179,13774,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,13774,'2012-12-31 06:28:25',30,0,7000),(180,13774,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,13774,'2012-12-31 06:28:25',30,0,7000),(181,14758,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,14758,'2012-12-31 06:28:25',30,0,7500),(182,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(183,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(184,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:25',30,0,5500),(185,11806,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,11806,'2012-12-31 06:28:25',30,0,6000),(186,33452,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,33452,'2012-12-31 06:28:26',30,0,17000),(187,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:26',30,0,8000),(188,35419,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,35419,'2012-12-31 06:28:26',30,0,18000),(189,9839,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,9839,'2012-12-31 06:28:26',30,0,5000),(190,31484,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:26',30,-31484,0),(191,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:26',30,-39355,0),(192,11806,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,11806,'2012-12-31 06:28:26',30,0,6000),(193,14168,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,14168,'2012-12-31 06:28:26',30,0,7200),(194,10626,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10626,'2012-12-31 06:28:26',30,0,5400),(195,8855,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,8855,'2012-12-31 06:28:26',30,0,4500),(196,11019,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,11019,'2012-12-31 06:28:26',30,0,5600),(197,25581,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:26',30,-25581,0),(198,26565,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:26',30,-26565,0),(199,20661,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:27',30,-20661,0),(200,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:27',30,0,8000),(201,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:27',30,0,285),(202,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:27',30,0,8000),(203,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:27',30,0,8000),(204,0,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:27',30,0,0),(205,10626,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10626,'2012-12-31 06:28:27',30,0,5400),(206,10823,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,10823,'2012-12-31 06:28:27',30,0,5500),(207,15742,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,15742,'2012-12-31 06:28:27',30,0,8000),(208,53129,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:27',30,-53129,0),(209,39355,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'2012-12-31 06:28:27',30,-39355,0),(210,29516,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,29516,'2012-12-31 06:28:28',30,0,15000),(211,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(212,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(213,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(214,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(215,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(216,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(217,443,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,443,'2012-12-31 06:28:28',30,0,225),(218,16529,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,16529,'2012-12-31 06:28:28',30,0,8400),(219,16529,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,16529,'2012-12-31 06:28:28',30,0,8400),(220,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(221,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(222,561,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,561,'2012-12-31 06:28:28',30,0,285),(223,443,0,0,0,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,443,'2012-12-31 06:28:28',30,0,225);
/*!40000 ALTER TABLE `0_employee_payroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_item_tax_types`
--

DROP TABLE IF EXISTS `0_item_tax_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_item_tax_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `exempt` tinyint(1) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_item_tax_types`
--

LOCK TABLES `0_item_tax_types` WRITE;
/*!40000 ALTER TABLE `0_item_tax_types` DISABLE KEYS */;
INSERT INTO `0_item_tax_types` VALUES (1,'Regular',0,0);
/*!40000 ALTER TABLE `0_item_tax_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_exchange_rates`
--

DROP TABLE IF EXISTS `0_exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_exchange_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curr_code` char(3) NOT NULL DEFAULT '',
  `rate_buy` double NOT NULL DEFAULT '0',
  `rate_sell` double NOT NULL DEFAULT '0',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `curr_code` (`curr_code`,`date_`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_exchange_rates`
--

LOCK TABLES `0_exchange_rates` WRITE;
/*!40000 ALTER TABLE `0_exchange_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_exchange_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sales_orders`
--

DROP TABLE IF EXISTS `0_sales_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sales_orders` (
  `order_no` int(11) NOT NULL,
  `trans_type` smallint(6) NOT NULL DEFAULT '30',
  `version` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `debtor_no` int(11) NOT NULL DEFAULT '0',
  `branch_code` int(11) NOT NULL DEFAULT '0',
  `reference` varchar(100) NOT NULL DEFAULT '',
  `customer_ref` tinytext NOT NULL,
  `comments` tinytext,
  `ord_date` date NOT NULL DEFAULT '0000-00-00',
  `order_type` int(11) NOT NULL DEFAULT '0',
  `ship_via` int(11) NOT NULL DEFAULT '0',
  `delivery_address` tinytext NOT NULL,
  `contact_phone` varchar(30) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `deliver_to` tinytext NOT NULL,
  `freight_cost` double NOT NULL DEFAULT '0',
  `from_stk_loc` varchar(5) NOT NULL DEFAULT '',
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `payment_terms` int(11) DEFAULT NULL,
  `total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_type`,`order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sales_orders`
--

LOCK TABLES `0_sales_orders` WRITE;
/*!40000 ALTER TABLE `0_sales_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_sales_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tax_types`
--

DROP TABLE IF EXISTS `0_tax_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tax_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate` double NOT NULL DEFAULT '0',
  `sales_gl_code` varchar(15) NOT NULL DEFAULT '',
  `purchasing_gl_code` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tax_types`
--

LOCK TABLES `0_tax_types` WRITE;
/*!40000 ALTER TABLE `0_tax_types` DISABLE KEYS */;
INSERT INTO `0_tax_types` VALUES (1,5,'2150','2150','Tax',0);
/*!40000 ALTER TABLE `0_tax_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_wo_requirements`
--

DROP TABLE IF EXISTS `0_wo_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_wo_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workorder_id` int(11) NOT NULL DEFAULT '0',
  `stock_id` char(20) NOT NULL DEFAULT '',
  `workcentre` int(11) NOT NULL DEFAULT '0',
  `units_req` double NOT NULL DEFAULT '1',
  `std_cost` double NOT NULL DEFAULT '0',
  `loc_code` char(5) NOT NULL DEFAULT '',
  `units_issued` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `workorder_id` (`workorder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_wo_requirements`
--

LOCK TABLES `0_wo_requirements` WRITE;
/*!40000 ALTER TABLE `0_wo_requirements` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_wo_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_attendance`
--

DROP TABLE IF EXISTS `0_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_attendance` (
  `attendance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `attendance_int1` int(11) DEFAULT NULL,
  `attendance_dec1` decimal(11,0) DEFAULT NULL,
  `attendance_string1` varchar(200) DEFAULT NULL,
  `attendance_timestamp1` datetime DEFAULT NULL,
  `gate_code` varchar(100) DEFAULT NULL,
  `gate_in` time DEFAULT NULL,
  `gate_out` time DEFAULT NULL,
  `employee_confirmed` varchar(10) DEFAULT NULL,
  `employee_comments` varchar(500) DEFAULT NULL,
  `superior_id` int(11) DEFAULT NULL,
  `superior_name` varchar(100) DEFAULT NULL,
  `superior_confirmed` varchar(10) DEFAULT NULL,
  `superior_comments` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_attendance`
--

LOCK TABLES `0_attendance` WRITE;
/*!40000 ALTER TABLE `0_attendance` DISABLE KEYS */;
INSERT INTO `0_attendance` VALUES (1,2,'2012-12-21 02:52:41','GATE-IN',908,1,'MISSING GATE OUT',NULL,'PERSONAL','18:00:00','02:52:41',NULL,NULL,NULL,NULL,NULL,NULL),(2,1,'2012-12-21 02:53:44','GATE-IN',0,0,'',NULL,'','00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,1,'2012-12-21 04:42:15','GATE-OUT',798,1,'EARLY GATE OUT',NULL,'PERSONAL','18:00:00','04:42:15',NULL,NULL,NULL,NULL,NULL,NULL),(4,1,'2012-12-28 05:34:00','GATE-IN',746,1,'MISSING GATE OUT',NULL,'PERSONAL','18:00:00','05:34:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `0_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tbales`
--

DROP TABLE IF EXISTS `0_tbales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tbales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bale` int(11) NOT NULL,
  `pally` int(11) NOT NULL,
  `gweight` int(11) NOT NULL,
  `nweight` int(11) NOT NULL,
  `shade` text NOT NULL,
  `taginfo` text NOT NULL,
  `remarks` text NOT NULL,
  `ptype` text NOT NULL,
  `invid` int(11) NOT NULL,
  `tsize` int(11) NOT NULL,
  `npieces` int(11) NOT NULL,
  `lotid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tbales`
--

LOCK TABLES `0_tbales` WRITE;
/*!40000 ALTER TABLE `0_tbales` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tbales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_crm_categories`
--

DROP TABLE IF EXISTS `0_crm_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_crm_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'pure technical key',
  `type` varchar(20) NOT NULL COMMENT 'contact type e.g. customer',
  `action` varchar(20) NOT NULL COMMENT 'detailed usage e.g. department',
  `name` varchar(30) NOT NULL COMMENT 'for category selector',
  `description` tinytext NOT NULL COMMENT 'usage description',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'nonzero for core system usage',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`,`action`),
  UNIQUE KEY `type_2` (`type`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_crm_categories`
--

LOCK TABLES `0_crm_categories` WRITE;
/*!40000 ALTER TABLE `0_crm_categories` DISABLE KEYS */;
INSERT INTO `0_crm_categories` VALUES (1,'cust_branch','general','General','General contact data for customer branch (overrides company setting)',1,0),(2,'cust_branch','invoice','Invoices','Invoice posting (overrides company setting)',1,0),(3,'cust_branch','order','Orders','Order confirmation (overrides company setting)',1,0),(4,'cust_branch','delivery','Deliveries','Delivery coordination (overrides company setting)',1,0),(5,'customer','general','General','General contact data for customer',1,0),(6,'customer','order','Orders','Order confirmation',1,0),(7,'customer','delivery','Deliveries','Delivery coordination',1,0),(8,'customer','invoice','Invoices','Invoice posting',1,0),(9,'supplier','general','General','General contact data for supplier',1,0),(10,'supplier','order','Orders','Order confirmation',1,0),(11,'supplier','delivery','Deliveries','Delivery coordination',1,0),(12,'supplier','invoice','Invoices','Invoice posting',1,0);
/*!40000 ALTER TABLE `0_crm_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_department`
--

DROP TABLE IF EXISTS `0_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `strength` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_department`
--

LOCK TABLES `0_department` WRITE;
/*!40000 ALTER TABLE `0_department` DISABLE KEYS */;
INSERT INTO `0_department` VALUES (4,'ACCOUNTS',10,14),(5,'INTERNAL AUDIT',4,14),(7,'EXPORT MARKETING',11,14),(8,'MIS',3,14),(9,'PURCHASE',3,14),(10,'SALES TAX',3,14),(11,'SAMPLING',2,14),(21,'STITCHING PRODUCTION',20,19),(22,'QUALITY',2,19),(23,'STITCHING STORE',3,19),(24,'TOWEL PRODUCTION',2,22),(25,'TOWEL STORE',1,22),(26,'FOLDING',1,21),(27,'WEAVING GENERAL STAFF',5,21),(28,'WEAVING STORE',1,21),(30,'STITCHING GENERAL STAFF',6,19),(33,'PPC',3,14),(35,'GREY GODOWN',13,21),(36,'PROCESSING STAFF',6,21),(37,'CIVIL',1,14),(38,'ELECTRIC',2,14),(39,'SERVICES',10,14),(41,'SECURITY',11,14),(42,'HR',1,14),(43,'ADMIN ',2,14),(44,'SOCIAL COMPLIANCE ',1,14),(45,'AUDIT',3,14),(46,'KNITTED',2,19),(47,'WEAVING HALL STAFF',50,21);
/*!40000 ALTER TABLE `0_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_voided`
--

DROP TABLE IF EXISTS `0_voided`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_voided` (
  `type` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL DEFAULT '0',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `memo_` tinytext NOT NULL,
  UNIQUE KEY `id` (`type`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_voided`
--

LOCK TABLES `0_voided` WRITE;
/*!40000 ALTER TABLE `0_voided` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_voided` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tinventory`
--

DROP TABLE IF EXISTS `0_tinventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tinventory` (
  `id` int(11) NOT NULL,
  `sup` int(11) NOT NULL,
  `gate_in` bigint(20) NOT NULL,
  `igp` bigint(20) NOT NULL,
  `goods` text NOT NULL,
  `driver` text NOT NULL,
  `vehicle` text NOT NULL,
  `builty` text NOT NULL,
  `gate_out` bigint(20) NOT NULL,
  `recv` text NOT NULL,
  `recvby` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tinventory`
--

LOCK TABLES `0_tinventory` WRITE;
/*!40000 ALTER TABLE `0_tinventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tinventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_currencies`
--

DROP TABLE IF EXISTS `0_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_currencies` (
  `currency` varchar(60) NOT NULL DEFAULT '',
  `curr_abrev` char(3) NOT NULL DEFAULT '',
  `curr_symbol` varchar(10) NOT NULL DEFAULT '',
  `country` varchar(100) NOT NULL DEFAULT '',
  `hundreds_name` varchar(15) NOT NULL DEFAULT '',
  `auto_update` tinyint(1) NOT NULL DEFAULT '1',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`curr_abrev`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_currencies`
--

LOCK TABLES `0_currencies` WRITE;
/*!40000 ALTER TABLE `0_currencies` DISABLE KEYS */;
INSERT INTO `0_currencies` VALUES ('US Dollars','USD','$','United States','Cents',1,0),('PAK Rupee','PKR','PKR','Pakistan','Pisas',1,0),('Euro','EUR','?','Europe','Cents',1,0),('Pounds','GBP','?','England','Pence',1,0);
/*!40000 ALTER TABLE `0_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_groups`
--

DROP TABLE IF EXISTS `0_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_groups` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_groups`
--

LOCK TABLES `0_groups` WRITE;
/*!40000 ALTER TABLE `0_groups` DISABLE KEYS */;
INSERT INTO `0_groups` VALUES (1,'Small',0),(2,'Medium',0),(3,'Large',0);
/*!40000 ALTER TABLE `0_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_loc_stock`
--

DROP TABLE IF EXISTS `0_loc_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_loc_stock` (
  `loc_code` char(5) NOT NULL DEFAULT '',
  `stock_id` char(20) NOT NULL DEFAULT '',
  `reorder_level` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`loc_code`,`stock_id`),
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_loc_stock`
--

LOCK TABLES `0_loc_stock` WRITE;
/*!40000 ALTER TABLE `0_loc_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_loc_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_qualification`
--

DROP TABLE IF EXISTS `0_employee_qualification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_qualification` (
  `employee_qualification_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `university_name` varchar(100) DEFAULT NULL,
  `university_address` varchar(900) DEFAULT NULL,
  `degree_start_year` date DEFAULT NULL,
  `degree_end_year` date DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `marks_obtained` int(11) DEFAULT NULL,
  `grade` varchar(30) DEFAULT NULL,
  `degree_majors` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`employee_qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_qualification`
--

LOCK TABLES `0_employee_qualification` WRITE;
/*!40000 ALTER TABLE `0_employee_qualification` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_employee_qualification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_areas`
--

DROP TABLE IF EXISTS `0_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_areas` (
  `area_code` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_code`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_areas`
--

LOCK TABLES `0_areas` WRITE;
/*!40000 ALTER TABLE `0_areas` DISABLE KEYS */;
INSERT INTO `0_areas` VALUES (1,'Global',0);
/*!40000 ALTER TABLE `0_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_wo_manufacture`
--

DROP TABLE IF EXISTS `0_wo_manufacture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_wo_manufacture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `workorder_id` (`workorder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_wo_manufacture`
--

LOCK TABLES `0_wo_manufacture` WRITE;
/*!40000 ALTER TABLE `0_wo_manufacture` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_wo_manufacture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_comments`
--

DROP TABLE IF EXISTS `0_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_comments` (
  `type` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL DEFAULT '0',
  `date_` date DEFAULT '0000-00-00',
  `memo_` tinytext,
  KEY `type_and_id` (`type`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_comments`
--

LOCK TABLES `0_comments` WRITE;
/*!40000 ALTER TABLE `0_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_salesman`
--

DROP TABLE IF EXISTS `0_salesman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_salesman` (
  `salesman_code` int(11) NOT NULL AUTO_INCREMENT,
  `salesman_name` char(60) NOT NULL DEFAULT '',
  `salesman_phone` char(30) NOT NULL DEFAULT '',
  `salesman_fax` char(30) NOT NULL DEFAULT '',
  `salesman_email` varchar(100) NOT NULL DEFAULT '',
  `provision` double NOT NULL DEFAULT '0',
  `break_pt` double NOT NULL DEFAULT '0',
  `provision2` double NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`salesman_code`),
  UNIQUE KEY `salesman_name` (`salesman_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_salesman`
--

LOCK TABLES `0_salesman` WRITE;
/*!40000 ALTER TABLE `0_salesman` DISABLE KEYS */;
INSERT INTO `0_salesman` VALUES (1,'Sales Person','','','',5,1000,4,0);
/*!40000 ALTER TABLE `0_salesman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sales_types`
--

DROP TABLE IF EXISTS `0_sales_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sales_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_type` char(50) NOT NULL DEFAULT '',
  `tax_included` int(1) NOT NULL DEFAULT '0',
  `factor` double NOT NULL DEFAULT '1',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_type` (`sales_type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sales_types`
--

LOCK TABLES `0_sales_types` WRITE;
/*!40000 ALTER TABLE `0_sales_types` DISABLE KEYS */;
INSERT INTO `0_sales_types` VALUES (1,'Retail',1,1,0),(2,'Wholesale',0,0.7,0);
/*!40000 ALTER TABLE `0_sales_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_payment_terms`
--

DROP TABLE IF EXISTS `0_payment_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_payment_terms` (
  `terms_indicator` int(11) NOT NULL AUTO_INCREMENT,
  `terms` char(80) NOT NULL DEFAULT '',
  `days_before_due` smallint(6) NOT NULL DEFAULT '0',
  `day_in_following_month` smallint(6) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`terms_indicator`),
  UNIQUE KEY `terms` (`terms`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_payment_terms`
--

LOCK TABLES `0_payment_terms` WRITE;
/*!40000 ALTER TABLE `0_payment_terms` DISABLE KEYS */;
INSERT INTO `0_payment_terms` VALUES (1,'Due 15th Of the Following Month',0,17,0),(2,'Due By End Of The Following Month',0,30,0),(3,'Payment due within 10 days',10,0,0),(4,'Cash Only',0,0,0);
/*!40000 ALTER TABLE `0_payment_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_purch_orders`
--

DROP TABLE IF EXISTS `0_purch_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_purch_orders` (
  `order_no` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `comments` tinytext,
  `ord_date` date NOT NULL DEFAULT '0000-00-00',
  `reference` tinytext NOT NULL,
  `requisition_no` tinytext,
  `into_stock_location` varchar(5) NOT NULL DEFAULT '',
  `delivery_address` tinytext NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `tax_included` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_no`),
  KEY `ord_date` (`ord_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_purch_orders`
--

LOCK TABLES `0_purch_orders` WRITE;
/*!40000 ALTER TABLE `0_purch_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_purch_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_gl_trans`
--

DROP TABLE IF EXISTS `0_gl_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_gl_trans` (
  `counter` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `type_no` bigint(16) NOT NULL DEFAULT '1',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `account` varchar(15) NOT NULL DEFAULT '',
  `memo_` tinytext NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `dimension_id` int(11) NOT NULL DEFAULT '0',
  `dimension2_id` int(11) NOT NULL DEFAULT '0',
  `person_type_id` int(11) DEFAULT NULL,
  `person_id` tinyblob,
  PRIMARY KEY (`counter`),
  KEY `Type_and_Number` (`type`,`type_no`),
  KEY `dimension_id` (`dimension_id`),
  KEY `dimension2_id` (`dimension2_id`),
  KEY `tran_date` (`tran_date`),
  KEY `account_and_tran_date` (`account`,`tran_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_gl_trans`
--

LOCK TABLES `0_gl_trans` WRITE;
/*!40000 ALTER TABLE `0_gl_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_gl_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_item_tax_type_exemptions`
--

DROP TABLE IF EXISTS `0_item_tax_type_exemptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_item_tax_type_exemptions` (
  `item_tax_type_id` int(11) NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_tax_type_id`,`tax_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_item_tax_type_exemptions`
--

LOCK TABLES `0_item_tax_type_exemptions` WRITE;
/*!40000 ALTER TABLE `0_item_tax_type_exemptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_item_tax_type_exemptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_supp_invoice_items`
--

DROP TABLE IF EXISTS `0_supp_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_supp_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supp_trans_no` int(11) DEFAULT NULL,
  `supp_trans_type` int(11) DEFAULT NULL,
  `gl_code` varchar(15) NOT NULL DEFAULT '',
  `grn_item_id` int(11) DEFAULT NULL,
  `po_detail_item_id` int(11) DEFAULT NULL,
  `stock_id` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext,
  `quantity` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `unit_tax` double NOT NULL DEFAULT '0',
  `memo_` tinytext,
  PRIMARY KEY (`id`),
  KEY `Transaction` (`supp_trans_type`,`supp_trans_no`,`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_supp_invoice_items`
--

LOCK TABLES `0_supp_invoice_items` WRITE;
/*!40000 ALTER TABLE `0_supp_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_supp_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_budget_trans`
--

DROP TABLE IF EXISTS `0_budget_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_budget_trans` (
  `counter` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `type_no` bigint(16) NOT NULL DEFAULT '1',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `account` varchar(15) NOT NULL DEFAULT '',
  `memo_` tinytext NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `dimension_id` int(11) DEFAULT '0',
  `dimension2_id` int(11) DEFAULT '0',
  `person_type_id` int(11) DEFAULT NULL,
  `person_id` tinyblob,
  PRIMARY KEY (`counter`),
  KEY `Type_and_Number` (`type`,`type_no`),
  KEY `Account` (`account`,`tran_date`,`dimension_id`,`dimension2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_budget_trans`
--

LOCK TABLES `0_budget_trans` WRITE;
/*!40000 ALTER TABLE `0_budget_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_budget_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sale_order_type`
--

DROP TABLE IF EXISTS `0_sale_order_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sale_order_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sale_order_type`
--

LOCK TABLES `0_sale_order_type` WRITE;
/*!40000 ALTER TABLE `0_sale_order_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_sale_order_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_workcentres`
--

DROP TABLE IF EXISTS `0_workcentres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_workcentres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(40) NOT NULL DEFAULT '',
  `description` char(50) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_workcentres`
--

LOCK TABLES `0_workcentres` WRITE;
/*!40000 ALTER TABLE `0_workcentres` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_workcentres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_deduction`
--

DROP TABLE IF EXISTS `0_deduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_deduction` (
  `deduction_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(900) NOT NULL,
  `type` int(2) NOT NULL,
  `deduction_multiplier` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`deduction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_deduction`
--

LOCK TABLES `0_deduction` WRITE;
/*!40000 ALTER TABLE `0_deduction` DISABLE KEYS */;
INSERT INTO `0_deduction` VALUES (4,'EOBI',' FOR PENSION SYASTEM',0,NULL),(6,'ADVANCE','DUE TO LOAN',0,NULL),(8,'PROVIDENT FUND','TO PROVIDE THE FACILITY AT THE TIME OF RETIREMENT ',0,NULL);
/*!40000 ALTER TABLE `0_deduction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_reference`
--

DROP TABLE IF EXISTS `0_employee_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_reference` (
  `employee_reference_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `reference_name` varchar(100) NOT NULL,
  `reference_address` varchar(900) DEFAULT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `know_since_date` date DEFAULT NULL,
  PRIMARY KEY (`employee_reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_reference`
--

LOCK TABLES `0_employee_reference` WRITE;
/*!40000 ALTER TABLE `0_employee_reference` DISABLE KEYS */;
INSERT INTO `0_employee_reference` VALUES (1,1,'ABC','ABC','123','2012-12-06');
/*!40000 ALTER TABLE `0_employee_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_bom`
--

DROP TABLE IF EXISTS `0_bom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_bom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` char(20) NOT NULL DEFAULT '',
  `component` char(20) NOT NULL DEFAULT '',
  `workcentre_added` int(11) NOT NULL DEFAULT '0',
  `loc_code` char(5) NOT NULL DEFAULT '',
  `quantity` double NOT NULL DEFAULT '1',
  PRIMARY KEY (`parent`,`component`,`workcentre_added`,`loc_code`),
  KEY `component` (`component`),
  KEY `id` (`id`),
  KEY `loc_code` (`loc_code`),
  KEY `parent` (`parent`,`loc_code`),
  KEY `workcentre_added` (`workcentre_added`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_bom`
--

LOCK TABLES `0_bom` WRITE;
/*!40000 ALTER TABLE `0_bom` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_bom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sales_order_details`
--

DROP TABLE IF EXISTS `0_sales_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sales_order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL DEFAULT '0',
  `trans_type` smallint(6) NOT NULL DEFAULT '30',
  `stk_code` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext,
  `qty_sent` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `discount_percent` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sorder` (`trans_type`,`order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sales_order_details`
--

LOCK TABLES `0_sales_order_details` WRITE;
/*!40000 ALTER TABLE `0_sales_order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_sales_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_bank_trans`
--

DROP TABLE IF EXISTS `0_bank_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_bank_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) DEFAULT NULL,
  `trans_no` int(11) DEFAULT NULL,
  `bank_act` varchar(15) NOT NULL DEFAULT '',
  `ref` varchar(40) DEFAULT NULL,
  `trans_date` date NOT NULL DEFAULT '0000-00-00',
  `amount` double DEFAULT NULL,
  `dimension_id` int(11) NOT NULL DEFAULT '0',
  `dimension2_id` int(11) NOT NULL DEFAULT '0',
  `person_type_id` int(11) NOT NULL DEFAULT '0',
  `person_id` tinyblob,
  `reconciled` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_act` (`bank_act`,`ref`),
  KEY `type` (`type`,`trans_no`),
  KEY `bank_act_2` (`bank_act`,`reconciled`),
  KEY `bank_act_3` (`bank_act`,`trans_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_bank_trans`
--

LOCK TABLES `0_bank_trans` WRITE;
/*!40000 ALTER TABLE `0_bank_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_bank_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_bank`
--

DROP TABLE IF EXISTS `0_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `country` varchar(30) NOT NULL,
  `swift` varchar(30) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `branch_number` varchar(30) NOT NULL,
  `address` varchar(900) NOT NULL,
  `city` varchar(30) NOT NULL,
  `province` varchar(30) NOT NULL,
  `postal_code` varchar(30) NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_bank`
--

LOCK TABLES `0_bank` WRITE;
/*!40000 ALTER TABLE `0_bank` DISABLE KEYS */;
INSERT INTO `0_bank` VALUES (2,'ASKRI BANK','PAKISTAN','1564156','UNIVERSITY ROAD BRANCH','00090','SBDVASHJDFAS','FAISALABAD','PUNJAB','23464');
/*!40000 ALTER TABLE `0_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_supp_allocations`
--

DROP TABLE IF EXISTS `0_supp_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_supp_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amt` double unsigned DEFAULT NULL,
  `date_alloc` date NOT NULL DEFAULT '0000-00-00',
  `trans_no_from` int(11) DEFAULT NULL,
  `trans_type_from` int(11) DEFAULT NULL,
  `trans_no_to` int(11) DEFAULT NULL,
  `trans_type_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `From` (`trans_type_from`,`trans_no_from`),
  KEY `To` (`trans_type_to`,`trans_no_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_supp_allocations`
--

LOCK TABLES `0_supp_allocations` WRITE;
/*!40000 ALTER TABLE `0_supp_allocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_supp_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_locations`
--

DROP TABLE IF EXISTS `0_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_locations` (
  `loc_code` varchar(5) NOT NULL DEFAULT '',
  `location_name` varchar(60) NOT NULL DEFAULT '',
  `delivery_address` tinytext NOT NULL,
  `phone` varchar(30) NOT NULL DEFAULT '',
  `phone2` varchar(30) NOT NULL DEFAULT '',
  `fax` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `contact` varchar(30) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`loc_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_locations`
--

LOCK TABLES `0_locations` WRITE;
/*!40000 ALTER TABLE `0_locations` DISABLE KEYS */;
INSERT INTO `0_locations` VALUES ('DEF','Default','N/A','','','','','',0);
/*!40000 ALTER TABLE `0_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sql_trail`
--

DROP TABLE IF EXISTS `0_sql_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sql_trail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sql` text NOT NULL,
  `result` tinyint(1) NOT NULL,
  `msg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sql_trail`
--

LOCK TABLES `0_sql_trail` WRITE;
/*!40000 ALTER TABLE `0_sql_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_sql_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_stock_master`
--

DROP TABLE IF EXISTS `0_stock_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_stock_master` (
  `stock_id` varchar(20) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL DEFAULT '0',
  `description` varchar(200) NOT NULL DEFAULT '',
  `long_description` tinytext NOT NULL,
  `units` varchar(20) NOT NULL DEFAULT 'each',
  `mb_flag` char(1) NOT NULL DEFAULT 'B',
  `sales_account` varchar(15) NOT NULL DEFAULT '',
  `cogs_account` varchar(15) NOT NULL DEFAULT '',
  `inventory_account` varchar(15) NOT NULL DEFAULT '',
  `adjustment_account` varchar(15) NOT NULL DEFAULT '',
  `assembly_account` varchar(15) NOT NULL DEFAULT '',
  `dimension_id` int(11) DEFAULT NULL,
  `dimension2_id` int(11) DEFAULT NULL,
  `actual_cost` double NOT NULL DEFAULT '0',
  `last_cost` double NOT NULL DEFAULT '0',
  `material_cost` double NOT NULL DEFAULT '0',
  `labour_cost` double NOT NULL DEFAULT '0',
  `overhead_cost` double NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  `no_sale` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_stock_master`
--

LOCK TABLES `0_stock_master` WRITE;
/*!40000 ALTER TABLE `0_stock_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_stock_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_security_roles`
--

DROP TABLE IF EXISTS `0_security_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_security_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `sections` text,
  `areas` text,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_security_roles`
--

LOCK TABLES `0_security_roles` WRITE;
/*!40000 ALTER TABLE `0_security_roles` DISABLE KEYS */;
INSERT INTO `0_security_roles` VALUES (2,'System Administrator','System Administrator','256;512;768;16384;16640','257;258;259;260;513;514;515;516;517;518;519;520;521;522;523;524;525;526;769;770;771;772;773;774;16385;16386;16387;16388;16389;16390;16391;16392;16393;16394;16395;16641;16642;16643;16644;16645;16646;16647;16648;16649;16650;16651;16652;16653;16654;16655;16656;16657;16897',0),(12,'HR-HOD','The Human Resource HOD','512;768;16384;16640','257;258;259;260;513;514;515;527;771;773;774;16385;16386;16387;16388;16389;16390;16391;16392;16393;16394;16395;16641;16642;16643;16644;16645;16646;16647;16648;16649;16650;16651;16652;16653;16654;16655;16656;16657;16897',0),(13,'HR-DATA ENTRY','which role has been createdto enter data in system','512;16640','257;258;259;260;515;769;770;771;772;773;774;16385;16386;16387;16388;16389;16390;16391;16392;16393;16394;16395;16641;16656;16897',0);
/*!40000 ALTER TABLE `0_security_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_fiscal_year`
--

DROP TABLE IF EXISTS `0_fiscal_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_fiscal_year` (
  `fiscal_year_id` int(11) NOT NULL,
  `begin` date DEFAULT '0000-00-00',
  `end` date DEFAULT '0000-00-00',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fiscal_year_id`),
  UNIQUE KEY `begin` (`begin`),
  UNIQUE KEY `end` (`end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_fiscal_year`
--

LOCK TABLES `0_fiscal_year` WRITE;
/*!40000 ALTER TABLE `0_fiscal_year` DISABLE KEYS */;
INSERT INTO `0_fiscal_year` VALUES (1,'2008-01-01','2008-12-31',1),(2,'2009-01-01','2009-12-31',1),(3,'2010-01-01','2010-12-31',1),(4,'2012-07-01','2013-06-30',0);
/*!40000 ALTER TABLE `0_fiscal_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_audit_trail`
--

DROP TABLE IF EXISTS `0_audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) unsigned NOT NULL DEFAULT '0',
  `trans_no` int(11) unsigned NOT NULL DEFAULT '0',
  `user` smallint(6) unsigned NOT NULL DEFAULT '0',
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(60) DEFAULT NULL,
  `fiscal_year` int(11) NOT NULL,
  `gl_date` date NOT NULL DEFAULT '0000-00-00',
  `gl_seq` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Seq` (`fiscal_year`,`gl_date`,`gl_seq`),
  KEY `Type_and_Number` (`type`,`trans_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_audit_trail`
--

LOCK TABLES `0_audit_trail` WRITE;
/*!40000 ALTER TABLE `0_audit_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_item_codes`
--

DROP TABLE IF EXISTS `0_item_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_item_codes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_code` varchar(20) NOT NULL,
  `stock_id` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL DEFAULT '',
  `category_id` smallint(6) unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '1',
  `is_foreign` tinyint(1) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_id` (`stock_id`,`item_code`),
  KEY `item_code` (`item_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_item_codes`
--

LOCK TABLES `0_item_codes` WRITE;
/*!40000 ALTER TABLE `0_item_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_item_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_designation`
--

DROP TABLE IF EXISTS `0_designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_designation` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(900) NOT NULL,
  `start_salary_bracket` int(11) NOT NULL,
  `end_salary_bracket` int(11) NOT NULL,
  `curr_abrev` varchar(3) NOT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_designation`
--

LOCK TABLES `0_designation` WRITE;
/*!40000 ALTER TABLE `0_designation` DISABLE KEYS */;
INSERT INTO `0_designation` VALUES (2,' OFFICER','ENTRING DATA INTO SOFTWARE AND UPDATE RECORD',10000,20000,'PKR'),(4,'MANAGERS ','TO SUPERVISE THEIR DEPARTMENT',35000,70000,'PKR'),(6,'SECURITY GUARD','PROVIDE THE SECURITY',10000,18000,'PKR'),(7,'DRIVER','PROVIDE FACILITY IN TRANSPOTATION',10000,15000,'PKR'),(8,'TABLE CHECKER','CHECK FABRIC',8000,10000,'PKR'),(9,'GREY CHECKER','CHECK GREY FABRIC QUALITY',8000,14000,'PKR'),(10,'QUALITY CHCKER','CHECK THE QUALITY ',12000,18000,'PKR'),(11,'MERCHANDISER','ABC',15000,20000,'PKR'),(12,'DUPUTY MANAGER','ABC',20000,30000,'PKR'),(13,'OFFICE BOY','ABC',80000,10000,'PKR'),(14,'SWEEPER','ABC',7000,9000,'PKR'),(15,'CARPENTER','ABC',10000,12000,'PKR'),(16,'ELECTRICIAN','ABC',10000,15000,'PKR'),(17,'SOCIAL COMPLIANCE OFFICER','ABC',150000,20000,'PKR'),(18,'SECURITY INCHARGE','ABC',12000,15000,'PKR'),(19,'ASSISTANT MANAGER ','ABC',15000,25000,'PKR'),(20,'CAD DESIGNER','ABC',20000,30000,'PKR'),(21,'INCHARGE SAMPLING','ABC',12000,15000,'PKR'),(22,'ASSISTANT SAMPLING','ABC',10000,12000,'PKR'),(23,'TELEPHONE OPERATOR','ABC',12000,15000,'PKR'),(24,'TIME KEEPER','ABC',12000,15000,'PKR'),(25,'INCHARGE INVENTORY','ABC',15000,17000,'PKR'),(26,'REJECTION KEEPER','ABC',10000,15000,'PKR'),(27,'QUALITY CONTROLER','ABC',15000,170000,'PKR'),(28,'INSPECTION CHECKER','ABC',14000,17000,'PKR'),(29,'INDUSTRIAL ENGINEER','ABC',15000,25000,'PKR'),(30,'MECHANIC','ABC',8000,12000,'PKR'),(31,'FOLDER','ABC',8000,12000,'PKR'),(32,'STITCHING SUPERVISOR','ABC',15000,18000,'PKR'),(33,'STORE KEEPER','ABC',10000,15000,'PKR'),(34,'TRAINEE QUALITY ASSURANCE OFFICER','ABC',12000,15000,'PKR'),(35,'STORE INCHARGE','ABC',15000,20000,'PKR'),(36,'INCHARGE WEAVING','ABC',15000,20000,'PKR'),(37,'FOLDING INCHARGE','ABC',8000,10000,'PKR'),(38,'OFFICER RECOVERY','ABC',15000,17000,'PKR'),(39,'SENIOR OFFICER RECOVERY','ABC',18000,22000,'PKR'),(40,'MANAGEMENT TRAINEE ACCOUNT','ABC',15000,18000,'PKR'),(41,'MANAGER ACCOUNT AND FINANCE','ABC',30000,40000,'PKR'),(42,'MANAGER MARKETING','ABC',40000,50000,'PKR'),(43,'ASSISTANT MERCHANDISER','ABC',20000,25000,'PKR'),(44,'SENIOR OFFICER DOCUMENTATION','ABC',20000,25000,'PKR'),(45,'MANAGER LOGISTICS','ABC',35000,40000,'PKR'),(46,'DEPUTY MANAGER MARKETING','ABC',25000,30000,'PKR'),(47,'JUNIOR MERCHANDISER','ABC',15000,18000,'PKR'),(48,'TRAINEE MERCHANDISER','ABC',12000,15000,'PKR'),(49,'DEPUTY MANAGER INTERNAL AUDIT','ABC',22000,25000,'PKR'),(50,'MANAGEMENT TRAINEE INTERNAL AUDIT','ABC',15000,20000,'PKR'),(51,'INTERNAL AUDIT OFFICER','ABC',15000,20000,'PKR'),(52,'IT OFFICER','ABC',15000,17000,'PKR'),(53,'OFFICER HARDWARE MIS','ABC',10000,12000,'PKR'),(54,'ASSISTAN MANAGER PPC','ABC',18000,20000,'PKR'),(55,'IRFAN KHAN','ABC',25000,33000,'PKR'),(56,'PPC OFFICER','ABC',15000,20000,'PKR'),(57,'ASSISTANT MANAGER PURCHASE','ABC',15000,20000,'PKR'),(58,'PURCHASE OFFICER','ABC',12000,15000,'PKR'),(59,'MANAGER TAXATION ','ABC',25000,30000,'PKR'),(60,'A/ MANAGER TAXATION','ABC',25000,30000,'PKR'),(61,'OFICER TAXATION','ABC',20000,25000,'PKR'),(62,'ADMIN OFFICER','ABC',10000,15000,'PKR'),(63,'HR OFFICER','ABC',12000,15000,'PKR'),(64,'IMAM MASJID','ABC',8000,10000,'PKR'),(65,'PRODUCTION OFFICER','ABC',12000,15000,'PKR'),(66,'FINAL QUALITY CHECKER','ABC',10000,12000,'PKR'),(67,'PACKING CHECKER','ABC',8000,10000,'PKR'),(68,'INLINE CHECKER','ABC',8000,10000,'PKR'),(69,'CHECKER B GRADE','ABC',9000,12000,'PKR'),(70,'THREADING AND FOLDING SUPERVISOR','ABC',10000,12000,'PKR'),(71,'MANAGER TOWEL WEAVING','ABC',25000,30000,'PKR'),(72,'MERCHANDISER TOWEL ','ABC',20000,25000,'PKR'),(73,'RECOVERY OFFICER','ABC',12000,15000,'PKR'),(74,'PURCHASE MANAGER','ABC',30000,35000,'PKR'),(75,'DATA ENTERY OPERATOR','ABC',10000,12000,'PKR'),(76,'SAMPLE MASTER','ABC',12000,14000,'PKR'),(77,'ACCOUNT OFFICER','ABC',14000,16000,'PKR'),(78,'SNR ACCOUNT OFFICER','ABC',18000,22000,'PKR'),(79,'Assistant Incharge Folding','ABC',10000,12000,'PKR'),(80,'SUPERVISOR','ABC',15000,18000,'PKR'),(81,'FORMAN','MANAGE THE WEAVING ALL STAFF AND PRODUCTION',15000,25000,'PKR'),(82,'JABBER','LOOK AFTER THE MACGINE',8000,15000,'PKR'),(83,'OIL MAN','CLEANING MACHINES ',8000,12000,'PKR'),(84,'FITTER','RESPONSIBLE FOR MACHINE PARTS',8000,15000,'PKR'),(85,'KNITTING MAN','CHECK THE KNITTING',7500,15000,'PKR'),(86,'BOBEN BOY','MANAGE THE BOBENS',6000,10000,'PKR'),(87,'WARBER','MANAGE THE BOBENS',5000,10000,'PKR'),(88,'MENDER','COUNT THE MEND',8000,15000,'PKR'),(89,'GRADER','ASSIGN GRADES TO CLOTH',8000,12000,'PKR'),(90,'ROLL CUTTER','MANAGE TJE ROLLS',8000,12000,'PKR');
/*!40000 ALTER TABLE `0_designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_stock_category`
--

DROP TABLE IF EXISTS `0_stock_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_stock_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) NOT NULL DEFAULT '',
  `dflt_tax_type` int(11) NOT NULL DEFAULT '1',
  `dflt_units` varchar(20) NOT NULL DEFAULT 'each',
  `dflt_mb_flag` char(1) NOT NULL DEFAULT 'B',
  `dflt_sales_act` varchar(15) NOT NULL DEFAULT '',
  `dflt_cogs_act` varchar(15) NOT NULL DEFAULT '',
  `dflt_inventory_act` varchar(15) NOT NULL DEFAULT '',
  `dflt_adjustment_act` varchar(15) NOT NULL DEFAULT '',
  `dflt_assembly_act` varchar(15) NOT NULL DEFAULT '',
  `dflt_dim1` int(11) DEFAULT NULL,
  `dflt_dim2` int(11) DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  `dflt_no_sale` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_stock_category`
--

LOCK TABLES `0_stock_category` WRITE;
/*!40000 ALTER TABLE `0_stock_category` DISABLE KEYS */;
INSERT INTO `0_stock_category` VALUES (1,'Components',1,'each','B','4010','5010','1510','5040','1530',0,0,0,0),(2,'Charges',1,'each','D','4010','5010','1510','5040','1530',0,0,0,0),(3,'Systems',1,'each','M','4010','5010','1510','5040','1530',0,0,0,0),(4,'Services',1,'hrs','D','4010','5010','1510','5040','1530',0,0,0,0);
/*!40000 ALTER TABLE `0_stock_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_steps`
--

DROP TABLE IF EXISTS `0_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lotid` int(11) NOT NULL,
  `prep_bool` varchar(3) NOT NULL DEFAULT 'no',
  `prep` int(11) NOT NULL,
  `care_bool` varchar(3) NOT NULL DEFAULT 'no',
  `care` int(11) NOT NULL,
  `bleach_bool` varchar(3) NOT NULL DEFAULT 'no',
  `bleach` int(11) NOT NULL,
  `dye_bool` varchar(3) NOT NULL DEFAULT 'no',
  `dye` int(11) NOT NULL,
  `hydro_bool` varchar(3) NOT NULL DEFAULT 'no',
  `hydro` int(11) NOT NULL,
  `tumbler_bool` varchar(3) NOT NULL DEFAULT 'no',
  `tumbl` int(11) NOT NULL,
  `quality_bool` varchar(3) NOT NULL DEFAULT 'no',
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_steps`
--

LOCK TABLES `0_steps` WRITE;
/*!40000 ALTER TABLE `0_steps` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_leave`
--

DROP TABLE IF EXISTS `0_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(900) NOT NULL,
  `minimum_leaves` int(11) NOT NULL,
  `maximum_leaves` int(11) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_leave`
--

LOCK TABLES `0_leave` WRITE;
/*!40000 ALTER TABLE `0_leave` DISABLE KEYS */;
INSERT INTO `0_leave` VALUES (2,'SICK LEAVE','It is allowed if an employee is not fit',8,8),(3,'CASUAL LEAVES','IT IS ALLOWED ON THE EMPLOYEE NEED',10,10),(4,'ANNUAL LEAVES','ON THE COMPLETION OF ONE YEAR',14,14);
/*!40000 ALTER TABLE `0_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_bank_accounts`
--

DROP TABLE IF EXISTS `0_bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_bank_accounts` (
  `account_code` varchar(15) NOT NULL DEFAULT '',
  `account_type` smallint(6) NOT NULL DEFAULT '0',
  `bank_account_name` varchar(60) NOT NULL DEFAULT '',
  `bank_account_number` varchar(100) NOT NULL DEFAULT '',
  `bank_name` varchar(60) NOT NULL DEFAULT '',
  `bank_address` tinytext,
  `bank_curr_code` char(3) NOT NULL DEFAULT '',
  `dflt_curr_act` tinyint(1) NOT NULL DEFAULT '0',
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `last_reconciled_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ending_reconcile_balance` double NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bank_account_name` (`bank_account_name`),
  KEY `bank_account_number` (`bank_account_number`),
  KEY `account_code` (`account_code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_bank_accounts`
--

LOCK TABLES `0_bank_accounts` WRITE;
/*!40000 ALTER TABLE `0_bank_accounts` DISABLE KEYS */;
INSERT INTO `0_bank_accounts` VALUES ('1060',0,'Current account','N/A','N/A','','USD',1,1,'0000-00-00 00:00:00',0,0),('1065',3,'Petty Cash account','N/A','N/A','','USD',0,2,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `0_bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sales_pos`
--

DROP TABLE IF EXISTS `0_sales_pos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sales_pos` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(30) NOT NULL,
  `cash_sale` tinyint(1) NOT NULL,
  `credit_sale` tinyint(1) NOT NULL,
  `pos_location` varchar(5) NOT NULL,
  `pos_account` smallint(6) unsigned NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pos_name` (`pos_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sales_pos`
--

LOCK TABLES `0_sales_pos` WRITE;
/*!40000 ALTER TABLE `0_sales_pos` DISABLE KEYS */;
INSERT INTO `0_sales_pos` VALUES (1,'Default',1,1,'DEF',2,0);
/*!40000 ALTER TABLE `0_sales_pos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_cust_branch`
--

DROP TABLE IF EXISTS `0_cust_branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_cust_branch` (
  `branch_code` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_no` int(11) NOT NULL DEFAULT '0',
  `br_name` varchar(60) NOT NULL DEFAULT '',
  `branch_ref` varchar(30) NOT NULL DEFAULT '',
  `br_address` tinytext NOT NULL,
  `area` int(11) DEFAULT NULL,
  `salesman` int(11) NOT NULL DEFAULT '0',
  `contact_name` varchar(60) NOT NULL DEFAULT '',
  `default_location` varchar(5) NOT NULL DEFAULT '',
  `tax_group_id` int(11) DEFAULT NULL,
  `sales_account` varchar(15) NOT NULL DEFAULT '',
  `sales_discount_account` varchar(15) NOT NULL DEFAULT '',
  `receivables_account` varchar(15) NOT NULL DEFAULT '',
  `payment_discount_account` varchar(15) NOT NULL DEFAULT '',
  `default_ship_via` int(11) NOT NULL DEFAULT '1',
  `disable_trans` tinyint(4) NOT NULL DEFAULT '0',
  `br_post_address` tinytext NOT NULL,
  `group_no` int(11) NOT NULL DEFAULT '0',
  `notes` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  `customer_type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cont_name` varchar(255) NOT NULL,
  `cont_designation` varchar(255) NOT NULL,
  `cont_number` varchar(20) NOT NULL,
  `cont_email` varchar(100) NOT NULL,
  PRIMARY KEY (`branch_code`,`debtor_no`),
  KEY `branch_code` (`branch_code`),
  KEY `branch_ref` (`branch_ref`),
  KEY `group_no` (`group_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_cust_branch`
--

LOCK TABLES `0_cust_branch` WRITE;
/*!40000 ALTER TABLE `0_cust_branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_cust_branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_workorders`
--

DROP TABLE IF EXISTS `0_workorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_workorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wo_ref` varchar(60) NOT NULL DEFAULT '',
  `loc_code` varchar(5) NOT NULL DEFAULT '',
  `units_reqd` double NOT NULL DEFAULT '1',
  `stock_id` varchar(20) NOT NULL DEFAULT '',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `required_by` date NOT NULL DEFAULT '0000-00-00',
  `released_date` date NOT NULL DEFAULT '0000-00-00',
  `units_issued` double NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `released` tinyint(1) NOT NULL DEFAULT '0',
  `additional_costs` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `wo_ref` (`wo_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_workorders`
--

LOCK TABLES `0_workorders` WRITE;
/*!40000 ALTER TABLE `0_workorders` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_workorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_stock_moves`
--

DROP TABLE IF EXISTS `0_stock_moves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_stock_moves` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_no` int(11) NOT NULL DEFAULT '0',
  `stock_id` char(20) NOT NULL DEFAULT '',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `loc_code` char(5) NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `person_id` int(11) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `reference` char(40) NOT NULL DEFAULT '',
  `qty` double NOT NULL DEFAULT '1',
  `discount_percent` double NOT NULL DEFAULT '0',
  `standard_cost` double NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`trans_id`),
  KEY `type` (`type`,`trans_no`),
  KEY `Move` (`stock_id`,`loc_code`,`tran_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_stock_moves`
--

LOCK TABLES `0_stock_moves` WRITE;
/*!40000 ALTER TABLE `0_stock_moves` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_stock_moves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_chart_types`
--

DROP TABLE IF EXISTS `0_chart_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_chart_types` (
  `id` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `class_id` varchar(3) NOT NULL DEFAULT '',
  `parent` varchar(10) NOT NULL DEFAULT '-1',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_chart_types`
--

LOCK TABLES `0_chart_types` WRITE;
/*!40000 ALTER TABLE `0_chart_types` DISABLE KEYS */;
INSERT INTO `0_chart_types` VALUES ('1','Current Assets','1','',0),('2','Inventory Assets','1','',0),('3','Capital Assets','1','',0),('4','Current Liabilities','2','',0),('5','Long Term Liabilities','2','',0),('6','Share Capital','2','',0),('7','Retained Earnings','2','',0),('8','Sales Revenue','3','',0),('9','Other Revenue','3','',0),('10','Cost of Goods Sold','4','',0),('11','Payroll Expenses','4','',0),('12','General &amp; Administrative expenses','4','',0);
/*!40000 ALTER TABLE `0_chart_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_joining`
--

DROP TABLE IF EXISTS `0_employee_joining`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_joining` (
  `employee_joining_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `last_organization` varchar(300) NOT NULL,
  `last_salary` decimal(10,0) NOT NULL,
  `joining_start_date` date DEFAULT NULL,
  `joining_end_date` date DEFAULT NULL,
  `reason_for_leaving` varchar(900) DEFAULT NULL,
  PRIMARY KEY (`employee_joining_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_joining`
--

LOCK TABLES `0_employee_joining` WRITE;
/*!40000 ALTER TABLE `0_employee_joining` DISABLE KEYS */;
INSERT INTO `0_employee_joining` VALUES (1,1,'Juser Farm Private Limited',20000,'2011-02-01','2011-11-15',NULL);
/*!40000 ALTER TABLE `0_employee_joining` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_movement_types`
--

DROP TABLE IF EXISTS `0_movement_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_movement_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_movement_types`
--

LOCK TABLES `0_movement_types` WRITE;
/*!40000 ALTER TABLE `0_movement_types` DISABLE KEYS */;
INSERT INTO `0_movement_types` VALUES (1,'Adjustment',0);
/*!40000 ALTER TABLE `0_movement_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_chart_master`
--

DROP TABLE IF EXISTS `0_chart_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_chart_master` (
  `account_code` varchar(15) NOT NULL DEFAULT '',
  `account_code2` varchar(15) NOT NULL DEFAULT '',
  `account_name` varchar(60) NOT NULL DEFAULT '',
  `account_type` varchar(10) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_code`),
  KEY `account_name` (`account_name`),
  KEY `accounts_by_type` (`account_type`,`account_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_chart_master`
--

LOCK TABLES `0_chart_master` WRITE;
/*!40000 ALTER TABLE `0_chart_master` DISABLE KEYS */;
INSERT INTO `0_chart_master` VALUES ('1060','','Checking Account','1',0),('1065','','Petty Cash','1',0),('1200','','Accounts Receivables','1',0),('1205','','Allowance for doubtful accounts','1',0),('1510','','Inventory','2',0),('1520','','Stocks of Raw Materials','2',0),('1530','','Stocks of Work In Progress','2',0),('1540','','Stocks of Finsihed Goods','2',0),('1550','','Goods Received Clearing account','2',0),('1820','','Office Furniture &amp; Equipment','3',0),('1825','','Accum. Amort. -Furn. &amp; Equip.','3',0),('1840','','Vehicle','3',0),('1845','','Accum. Amort. -Vehicle','3',0),('2100','','Accounts Payable','4',0),('2110','','Accrued Income Tax - Federal','4',0),('2120','','Accrued Income Tax - State','4',0),('2130','','Accrued Franchise Tax','4',0),('2140','','Accrued Real &amp; Personal Prop Tax','4',0),('2150','','Sales Tax','4',0),('2160','','Accrued Use Tax Payable','4',0),('2210','','Accrued Wages','4',0),('2220','','Accrued Comp Time','4',0),('2230','','Accrued Holiday Pay','4',0),('2240','','Accrued Vacation Pay','4',0),('2310','','Accr. Benefits - 401K','4',0),('2320','','Accr. Benefits - Stock Purchase','4',0),('2330','','Accr. Benefits - Med, Den','4',0),('2340','','Accr. Benefits - Payroll Taxes','4',0),('2350','','Accr. Benefits - Credit Union','4',0),('2360','','Accr. Benefits - Savings Bond','4',0),('2370','','Accr. Benefits - Garnish','4',0),('2380','','Accr. Benefits - Charity Cont.','4',0),('2620','','Bank Loans','5',0),('2680','','Loans from Shareholders','5',0),('3350','','Common Shares','6',0),('3590','','Retained Earnings - prior years','7',0),('4010','','Sales','8',0),('4430','','Shipping &amp; Handling','9',0),('4440','','Interest','9',0),('4450','','Foreign Exchange Gain','9',0),('4500','','Prompt Payment Discounts','9',0),('4510','','Discounts Given','9',0),('5010','','Cost of Goods Sold - Retail','10',0),('5020','','Material Usage Varaiance','10',0),('5030','','Consumable Materials','10',0),('5040','','Purchase price Variance','10',0),('5050','','Purchases of materials','10',0),('5060','','Discounts Received','10',0),('5100','','Freight','10',0),('5410','','Wages &amp; Salaries','11',0),('5420','','Wages - Overtime','11',0),('5430','','Benefits - Comp Time','11',0),('5440','','Benefits - Payroll Taxes','11',0),('5450','','Benefits - Workers Comp','11',0),('5460','','Benefits - Pension','11',0),('5470','','Benefits - General Benefits','11',0),('5510','','Inc Tax Exp - Federal','11',0),('5520','','Inc Tax Exp - State','11',0),('5530','','Taxes - Real Estate','11',0),('5540','','Taxes - Personal Property','11',0),('5550','','Taxes - Franchise','11',0),('5560','','Taxes - Foreign Withholding','11',0),('5610','','Accounting &amp; Legal','12',0),('5615','','Advertising &amp; Promotions','12',0),('5620','','Bad Debts','12',0),('5660','','Amortization Expense','12',0),('5685','','Insurance','12',0),('5690','','Interest &amp; Bank Charges','12',0),('5700','','Office Supplies','12',0),('5760','','Rent','12',0),('5765','','Repair &amp; Maintenance','12',0),('5780','','Telephone','12',0),('5785','','Travel &amp; Entertainment','12',0),('5790','','Utilities','12',0),('5795','','Registrations','12',0),('5800','','Licenses','12',0),('5810','','Foreign Exchange Loss','12',0),('9990','','Year Profit/Loss','12',0);
/*!40000 ALTER TABLE `0_chart_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_recurrent_invoices`
--

DROP TABLE IF EXISTS `0_recurrent_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_recurrent_invoices` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(60) NOT NULL DEFAULT '',
  `order_no` int(11) unsigned NOT NULL,
  `debtor_no` int(11) unsigned DEFAULT NULL,
  `group_no` smallint(6) unsigned DEFAULT NULL,
  `days` int(11) NOT NULL DEFAULT '0',
  `monthly` int(11) NOT NULL DEFAULT '0',
  `begin` date NOT NULL DEFAULT '0000-00-00',
  `end` date NOT NULL DEFAULT '0000-00-00',
  `last_sent` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_recurrent_invoices`
--

LOCK TABLES `0_recurrent_invoices` WRITE;
/*!40000 ALTER TABLE `0_recurrent_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_recurrent_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_title`
--

DROP TABLE IF EXISTS `0_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_title` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_title`
--

LOCK TABLES `0_title` WRITE;
/*!40000 ALTER TABLE `0_title` DISABLE KEYS */;
INSERT INTO `0_title` VALUES (4,'Mr.'),(6,'Miss');
/*!40000 ALTER TABLE `0_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_debtor_trans_details`
--

DROP TABLE IF EXISTS `0_debtor_trans_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_debtor_trans_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_trans_no` int(11) DEFAULT NULL,
  `debtor_trans_type` int(11) DEFAULT NULL,
  `stock_id` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext,
  `unit_price` double NOT NULL DEFAULT '0',
  `unit_tax` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `discount_percent` double NOT NULL DEFAULT '0',
  `standard_cost` double NOT NULL DEFAULT '0',
  `qty_done` double NOT NULL DEFAULT '0',
  `src_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Transaction` (`debtor_trans_type`,`debtor_trans_no`),
  KEY `src_id` (`src_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_debtor_trans_details`
--

LOCK TABLES `0_debtor_trans_details` WRITE;
/*!40000 ALTER TABLE `0_debtor_trans_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_debtor_trans_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_crm_contacts`
--

DROP TABLE IF EXISTS `0_crm_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_crm_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to crm_contacts',
  `type` varchar(20) NOT NULL COMMENT 'foreign key to crm_categories',
  `action` varchar(20) NOT NULL COMMENT 'foreign key to crm_categories',
  `entity_id` varchar(11) DEFAULT NULL COMMENT 'entity id in related class table',
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_crm_contacts`
--

LOCK TABLES `0_crm_contacts` WRITE;
/*!40000 ALTER TABLE `0_crm_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_crm_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_employee_leave`
--

DROP TABLE IF EXISTS `0_employee_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_employee_leave` (
  `employee_leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `leave_assigned` int(11) NOT NULL,
  PRIMARY KEY (`employee_leave_id`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_employee_leave`
--

LOCK TABLES `0_employee_leave` WRITE;
/*!40000 ALTER TABLE `0_employee_leave` DISABLE KEYS */;
INSERT INTO `0_employee_leave` VALUES (3,1,2,8),(4,2,2,8),(5,2,3,10),(6,2,4,14),(7,1,3,10),(8,3,2,8),(9,3,3,10),(10,3,4,14),(11,4,2,8),(12,4,3,10),(13,4,4,14),(14,5,2,8),(15,5,3,10),(16,5,4,14),(17,6,2,8),(18,6,3,10),(19,6,4,14),(20,7,2,8),(21,7,3,10),(22,7,4,14),(23,9,2,8),(24,9,3,10),(25,9,4,14),(26,10,2,8),(27,10,3,10),(28,10,4,14),(29,11,2,8),(30,11,3,10),(31,11,4,14),(32,12,2,8),(33,12,3,10),(34,12,4,14),(35,13,2,8),(36,13,3,10),(37,13,4,14),(38,14,2,8),(39,14,3,10),(40,14,4,14),(41,15,2,8),(42,15,3,10),(43,15,4,14),(44,16,2,8),(45,16,3,10),(46,16,4,14),(47,17,2,8),(48,17,3,10),(49,17,4,14),(50,18,2,8),(51,18,3,10),(52,18,4,14),(53,19,2,8),(54,19,3,10),(55,19,4,14),(56,20,2,8),(57,20,3,10),(58,20,4,14),(59,21,2,8),(60,21,3,10),(61,21,4,14),(62,27,2,8),(63,27,3,10),(64,27,4,14),(65,28,2,8),(66,28,3,10),(67,28,4,14),(68,36,2,8),(69,36,3,10),(70,36,4,14),(71,37,2,8),(72,37,3,10),(73,37,4,14),(74,38,2,8),(75,38,3,10),(76,38,4,14),(77,39,2,8),(78,39,3,10),(79,39,4,14),(80,40,2,8),(81,40,3,10),(82,40,4,14),(83,41,2,8),(84,41,3,10),(85,41,4,14),(86,42,2,8),(87,42,3,10),(88,42,4,14),(89,43,2,8),(90,43,3,10),(91,43,4,14),(92,48,2,8),(93,48,3,10),(94,48,4,14),(95,49,2,8),(96,49,3,10),(97,49,4,14),(98,51,2,8),(99,51,3,10),(100,51,4,14),(101,52,2,8),(102,52,3,10),(103,52,4,14),(104,53,2,8),(105,53,3,10),(106,53,4,14),(107,54,2,8),(108,54,3,10),(109,54,4,14),(110,55,2,8),(111,55,3,10),(112,55,4,14),(113,57,2,8),(114,57,3,10),(115,57,4,14),(116,58,2,8),(117,58,3,10),(118,58,4,14),(119,59,2,8),(120,59,3,10),(121,59,4,14),(122,60,2,8),(123,60,3,10),(124,60,4,14),(125,61,2,8),(126,61,3,10),(127,61,4,14),(128,62,2,8),(129,62,3,10),(130,62,4,14),(131,63,2,8),(132,63,3,10),(133,63,4,14),(134,64,2,8),(135,64,3,10),(136,64,4,14),(137,65,2,8),(138,65,3,10),(139,65,4,14),(140,66,2,8),(141,66,3,10),(142,66,4,14),(143,67,2,8),(144,67,3,10),(145,67,4,14),(146,68,2,8),(147,68,3,10),(148,68,4,14),(149,69,2,8),(150,69,3,10),(151,69,4,14),(152,71,2,8),(153,71,3,10),(154,71,4,14),(155,72,2,8),(156,72,3,10),(157,72,4,14),(158,73,2,8),(159,73,3,10),(160,73,4,14),(161,74,2,8),(162,74,3,10),(163,74,4,14),(164,75,2,8),(165,75,3,10),(166,75,4,14),(167,76,2,8),(168,76,3,10),(169,76,4,14),(170,77,2,8),(171,77,3,10),(172,77,4,14),(173,78,2,8),(174,78,3,10),(175,78,4,14),(176,79,2,8),(177,79,3,10),(178,79,4,14),(179,80,2,8),(180,80,3,10),(181,80,4,14),(182,81,2,8),(183,81,3,10),(184,81,4,14),(185,82,2,8),(186,82,3,10),(187,82,4,14),(188,84,2,8),(189,84,3,10),(190,84,4,14),(191,85,2,8),(192,85,3,10),(193,85,4,14),(194,87,2,8),(195,87,3,10),(196,87,4,14),(197,90,2,8),(198,90,3,10),(199,90,4,14),(200,92,2,8),(201,92,3,10),(202,92,4,14),(203,93,2,8),(204,93,3,10),(205,93,4,14),(206,94,2,8),(207,94,3,10),(208,94,4,14),(209,95,2,8),(210,95,3,10),(211,95,4,14),(212,96,2,8),(213,96,3,10),(214,96,4,14),(215,97,2,8),(216,97,3,10),(217,97,4,14),(218,98,2,8),(219,98,3,10),(220,98,4,14),(221,99,2,8),(222,99,3,10),(223,99,4,14),(225,100,2,8),(226,100,3,10),(227,100,4,14),(228,101,2,8),(229,101,3,10),(230,101,4,14),(231,102,2,8),(232,102,3,10),(233,102,4,14),(234,104,2,8),(235,104,3,10),(236,104,4,14),(237,105,2,8),(238,105,3,10),(239,105,4,14),(240,106,2,8),(241,106,3,10),(242,106,4,14),(243,107,2,8),(244,107,3,10),(245,107,4,14),(246,108,2,8),(247,108,3,10),(248,108,4,14),(249,110,2,8),(250,110,3,10),(251,110,4,14),(252,111,2,8),(253,111,3,10),(254,111,4,14),(255,112,2,8),(256,112,3,10),(257,112,4,14),(258,115,2,8),(259,115,3,10),(260,115,4,14),(261,117,2,8),(262,117,3,10),(263,117,4,14),(264,118,2,8),(265,118,3,10),(266,118,4,14),(267,119,2,8),(268,119,3,10),(269,119,4,14),(270,120,2,8),(271,120,3,10),(272,120,4,14),(273,121,2,8),(274,121,3,10),(275,121,4,14),(276,122,2,8),(277,122,3,10),(278,122,4,14),(279,123,2,8),(280,123,3,10),(281,123,4,14),(282,124,2,8),(283,124,3,10),(284,124,4,14),(285,125,2,8),(286,125,3,10),(287,125,4,14),(288,126,2,8),(289,126,3,10),(290,126,4,14),(291,190,2,8),(292,190,3,10),(293,190,4,14),(294,191,2,8),(295,191,3,10),(296,191,4,14),(297,197,2,8),(298,197,3,10),(299,197,4,14),(300,198,2,8),(301,198,3,10),(302,198,4,14),(303,199,2,8),(304,199,3,10),(305,199,4,14),(306,200,2,8),(307,200,3,10),(308,200,4,14),(309,202,2,8),(310,202,3,10),(311,202,4,14),(312,203,2,8),(313,203,3,10),(314,203,4,14),(315,208,2,8),(316,208,3,10),(317,208,4,14),(318,209,2,8),(319,209,3,10),(320,209,4,14),(321,1,4,14);
/*!40000 ALTER TABLE `0_employee_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_tags`
--

DROP TABLE IF EXISTS `0_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_tags`
--

LOCK TABLES `0_tags` WRITE;
/*!40000 ALTER TABLE `0_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_sys_prefs`
--

DROP TABLE IF EXISTS `0_sys_prefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_sys_prefs` (
  `name` varchar(35) NOT NULL DEFAULT '',
  `category` varchar(30) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT '',
  `length` smallint(6) DEFAULT NULL,
  `value` tinytext,
  PRIMARY KEY (`name`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_sys_prefs`
--

LOCK TABLES `0_sys_prefs` WRITE;
/*!40000 ALTER TABLE `0_sys_prefs` DISABLE KEYS */;
INSERT INTO `0_sys_prefs` VALUES ('coy_name','setup.company','varchar',60,'AI TEXTILES '),('gst_no','setup.company','varchar',25,''),('coy_no','setup.company','varchar',25,'041-87411541-9'),('tax_prd','setup.company','int',11,'1'),('tax_last','setup.company','int',11,'1'),('postal_address','setup.company','tinytext',0,'A.I TEXTILES, 11-KM, JARANWALA ROAD, FAISALABAD,041-87411541-9'),('phone','setup.company','varchar',30,'041-87411541-9'),('fax','setup.company','varchar',30,''),('email','setup.company','varchar',100,'info@aitextile.com'),('coy_logo','setup.company','varchar',100,'logo_ait.JPG'),('domicile','setup.company','varchar',55,''),('curr_default','setup.company','char',3,'PKR'),('use_dimension','setup.company','tinyint',1,'1'),('f_year','setup.company','int',11,'4'),('no_item_list','setup.company','tinyint',1,'0'),('no_customer_list','setup.company','tinyint',1,'0'),('no_supplier_list','setup.company','tinyint',1,'0'),('base_sales','setup.company','int',11,'1'),('time_zone','setup.company','tinyint',1,'0'),('add_pct','setup.company','int',5,'-1'),('round_to','setup.company','int',5,'1'),('login_tout','setup.company','smallint',6,'64000'),('past_due_days','glsetup.general','int',11,'30'),('profit_loss_year_act','glsetup.general','varchar',15,'9990'),('retained_earnings_act','glsetup.general','varchar',15,'3590'),('bank_charge_act','glsetup.general','varchar',15,'5690'),('exchange_diff_act','glsetup.general','varchar',15,'4450'),('default_credit_limit','glsetup.customer','int',11,'1000'),('accumulate_shipping','glsetup.customer','tinyint',1,'0'),('legal_text','glsetup.customer','tinytext',0,''),('freight_act','glsetup.customer','varchar',15,'4430'),('debtors_act','glsetup.sales','varchar',15,'1200'),('default_sales_act','glsetup.sales','varchar',15,'4010'),('default_sales_discount_act','glsetup.sales','varchar',15,'4510'),('default_prompt_payment_act','glsetup.sales','varchar',15,'4500'),('default_delivery_required','glsetup.sales','smallint',6,'1'),('default_dim_required','glsetup.dims','int',11,'20'),('pyt_discount_act','glsetup.purchase','varchar',15,'5060'),('creditors_act','glsetup.purchase','varchar',15,'2100'),('po_over_receive','glsetup.purchase','int',11,'10'),('po_over_charge','glsetup.purchase','int',11,'10'),('allow_negative_stock','glsetup.inventory','tinyint',1,'0'),('default_inventory_act','glsetup.items','varchar',15,'1510'),('default_cogs_act','glsetup.items','varchar',15,'5010'),('default_adj_act','glsetup.items','varchar',15,'5040'),('default_inv_sales_act','glsetup.items','varchar',15,'4010'),('default_assembly_act','glsetup.items','varchar',15,'1530'),('default_workorder_required','glsetup.manuf','int',11,'20'),('version_id','system','varchar',11,'2.3rc'),('auto_curr_reval','setup.company','smallint',6,'1'),('grn_clearing_act','glsetup.purchase','varchar',15,'1550');
/*!40000 ALTER TABLE `0_sys_prefs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_suppliers`
--

DROP TABLE IF EXISTS `0_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supp_name` varchar(60) NOT NULL DEFAULT '',
  `supp_ref` varchar(30) NOT NULL DEFAULT '',
  `address` tinytext NOT NULL,
  `supp_address` tinytext NOT NULL,
  `gst_no` varchar(25) NOT NULL DEFAULT '',
  `contact` varchar(60) NOT NULL DEFAULT '',
  `supp_account_no` varchar(40) NOT NULL DEFAULT '',
  `website` varchar(100) NOT NULL DEFAULT '',
  `bank_account` varchar(60) NOT NULL DEFAULT '',
  `curr_code` char(3) DEFAULT NULL,
  `payment_terms` int(11) DEFAULT NULL,
  `tax_included` tinyint(1) NOT NULL DEFAULT '0',
  `dimension_id` int(11) DEFAULT '0',
  `dimension2_id` int(11) DEFAULT '0',
  `tax_group_id` int(11) DEFAULT NULL,
  `credit_limit` double NOT NULL DEFAULT '0',
  `purchase_account` varchar(15) NOT NULL DEFAULT '',
  `payable_account` varchar(15) NOT NULL DEFAULT '',
  `payment_discount_account` varchar(15) NOT NULL DEFAULT '',
  `notes` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`supplier_id`),
  KEY `supp_ref` (`supp_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_suppliers`
--

LOCK TABLES `0_suppliers` WRITE;
/*!40000 ALTER TABLE `0_suppliers` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_purch_data`
--

DROP TABLE IF EXISTS `0_purch_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_purch_data` (
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `stock_id` char(20) NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `suppliers_uom` char(50) NOT NULL DEFAULT '',
  `conversion_factor` double NOT NULL DEFAULT '1',
  `supplier_description` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`supplier_id`,`stock_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_purch_data`
--

LOCK TABLES `0_purch_data` WRITE;
/*!40000 ALTER TABLE `0_purch_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_purch_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_quick_entry_lines`
--

DROP TABLE IF EXISTS `0_quick_entry_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_quick_entry_lines` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `qid` smallint(6) unsigned NOT NULL,
  `amount` double DEFAULT '0',
  `action` varchar(2) NOT NULL,
  `dest_id` varchar(15) NOT NULL DEFAULT '',
  `dimension_id` smallint(6) unsigned DEFAULT NULL,
  `dimension2_id` smallint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_quick_entry_lines`
--

LOCK TABLES `0_quick_entry_lines` WRITE;
/*!40000 ALTER TABLE `0_quick_entry_lines` DISABLE KEYS */;
INSERT INTO `0_quick_entry_lines` VALUES (1,1,0,'t-','1',0,0),(2,2,0,'t-','1',0,0),(3,3,0,'t-','1',0,0),(4,3,0,'=','4010',0,0),(5,1,0,'=','5765',0,0),(6,2,0,'=','5780',0,0);
/*!40000 ALTER TABLE `0_quick_entry_lines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_debtors_master`
--

DROP TABLE IF EXISTS `0_debtors_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_debtors_master` (
  `debtor_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `debtor_ref` varchar(30) NOT NULL,
  `address` tinytext,
  `tax_id` varchar(55) NOT NULL DEFAULT '',
  `curr_code` char(3) NOT NULL DEFAULT '',
  `sales_type` int(11) NOT NULL DEFAULT '1',
  `dimension_id` int(11) NOT NULL DEFAULT '0',
  `dimension2_id` int(11) NOT NULL DEFAULT '0',
  `credit_status` int(11) NOT NULL DEFAULT '0',
  `payment_terms` int(11) DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `pymt_discount` double NOT NULL DEFAULT '0',
  `credit_limit` float NOT NULL DEFAULT '1000',
  `notes` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`debtor_no`),
  UNIQUE KEY `debtor_ref` (`debtor_ref`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_debtors_master`
--

LOCK TABLES `0_debtors_master` WRITE;
/*!40000 ALTER TABLE `0_debtors_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_debtors_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `0_trans_tax_details`
--

DROP TABLE IF EXISTS `0_trans_tax_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_trans_tax_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_type` smallint(6) DEFAULT NULL,
  `trans_no` int(11) DEFAULT NULL,
  `tran_date` date NOT NULL,
  `tax_type_id` int(11) NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '0',
  `ex_rate` double NOT NULL DEFAULT '1',
  `included_in_price` tinyint(1) NOT NULL DEFAULT '0',
  `net_amount` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `memo` tinytext,
  PRIMARY KEY (`id`),
  KEY `Type_and_Number` (`trans_type`,`trans_no`),
  KEY `tran_date` (`tran_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_trans_tax_details`
--

LOCK TABLES `0_trans_tax_details` WRITE;
/*!40000 ALTER TABLE `0_trans_tax_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `0_trans_tax_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-12-31 18:36:45
