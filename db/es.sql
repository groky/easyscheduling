-- MySQL dump 10.13  Distrib 5.1.36, for Win32 (ia32)
--
-- Host: localhost    Database: easyschedule
-- ------------------------------------------------------
-- Server version	5.1.36-community-log

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
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `organisation_id` int(11) DEFAULT NULL,
  `multi_day` tinyint(1) DEFAULT '0',
  `contact_person` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'Oscar\'s Birthday Bash','At our place',19,1,'Foxy'),(2,'Lilly\'s Birthday','There will be a party for one day',19,0,'Dan'),(3,'Mfsjfdsf','fsdfsdf',24,0,'dsfdsf'),(4,'Mfsjfdsf','fsdfsdf',24,0,'dsfdsf'),(5,'Mfsjfdsf','fsdfsdf',24,0,'dsfdsf'),(6,'Grand Opening','<script>alert(\'hi\');</script>',25,0,'Bros'),(8,'Playdate','please come',19,0,'Dan'),(9,'Lunchtime game','Guys! be there or be square',27,0,'Roger'),(10,'Meeting with the bad arses','Punch, kick, etc...',28,0,'Me');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_option`
--

DROP TABLE IF EXISTS `event_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_start` bigint(20) NOT NULL,
  `o_end` bigint(20) DEFAULT NULL,
  `start_time` bigint(20) NOT NULL,
  `end_time` bigint(20) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_option`
--

LOCK TABLES `event_option` WRITE;
/*!40000 ALTER TABLE `event_option` DISABLE KEYS */;
INSERT INTO `event_option` VALUES (18,1259366400,1264809600,1259132400,1259172000,1),(17,1259280000,1262995200,1259132400,1259182800,1),(16,1259193600,1259280000,1259172000,1259172000,1),(15,1259366400,1295049600,1259118000,1259132400,1),(14,1259280000,1259366400,1259132400,1259139600,1),(19,1259280000,NULL,1259175600,1259190000,2);
/*!40000 ALTER TABLE `event_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `event_id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `reference` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'http://localhost/es/?page_name=m_s&id=1&ipx=Xe1IKIvuzIYIRUseSAKI1ArU3uKIqeguHubAdudI0e4ufAZebUGu','Xe1IKIvuzIYIRUseSAKI1ArU3uKIqeguHubAdudI0e4ufAZebUGu');
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `description` text,
  `options_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'Function Centre',NULL,1),(2,'At Home',NULL,2),(3,'At Home',NULL,3),(17,'mj',NULL,17),(16,'At Home',NULL,16),(6,'mj',NULL,6),(15,'hjhji',NULL,15),(12,'uhuh',NULL,12),(14,'uhuh',NULL,14),(18,'rt',NULL,18),(19,'Dan\'s Place',NULL,19);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (25,'Matt','Meriaux'),(26,'Mathieu','Meriaux'),(27,'Mathieu','Meriaux'),(28,'Mathieu','Meriaux'),(29,'Mathieu','Meriaux'),(30,'Mathieu','Meriaux'),(31,'Mathieu','Meriaux'),(32,'Mathieu','Meriaux'),(33,'Mathieu','Meriaux'),(34,'Mathieu','Meriaux'),(35,'Rob','Winters'),(36,'John','Smith'),(37,'Right','Fred'),(38,'Oscar','Dog'),(39,'Lilly','Dog'),(40,'Mathieu','Meriaux'),(42,'Mathieu','Meriaux'),(43,'MAt','Boy'),(44,'Easy','Scheduling'),(45,'Mat','Mer'),(46,'Roger','Federrer'),(47,'Mat','Damon'),(48,'mathieu','meriaux'),(52,'Oscar','Dog');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_link`
--

DROP TABLE IF EXISTS `member_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_link` (
  `member_id` int(11) NOT NULL,
  `reference` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_link`
--

LOCK TABLES `member_link` WRITE;
/*!40000 ALTER TABLE `member_link` DISABLE KEYS */;
INSERT INTO `member_link` VALUES (52,'Xe1IKIvuzIYIRUseSAKI1ArU3uKIqeguHubAdudI0e4ufAZebUGu');
/*!40000 ALTER TABLE `member_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_option`
--

DROP TABLE IF EXISTS `member_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_option` (
  `member_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `reference` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_option`
--

LOCK TABLES `member_option` WRITE;
/*!40000 ALTER TABLE `member_option` DISABLE KEYS */;
INSERT INTO `member_option` VALUES (52,14,NULL),(52,15,NULL),(52,17,NULL);
/*!40000 ALTER TABLE `member_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `logo` blob,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `org_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisation`
--

LOCK TABLES `organisation` WRITE;
/*!40000 ALTER TABLE `organisation` DISABLE KEYS */;
INSERT INTO `organisation` VALUES (6,'mat@esp.com','pass',NULL,'2009-10-20 08:00:48','ESP'),(7,'mat@dot.com','escrime',NULL,'2009-10-20 08:41:22','ESP'),(8,'Mat@gmail.com','escrime',NULL,'2009-10-20 08:43:14','Triathlon ACT'),(9,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:28:52','Triathlon ACT'),(10,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:33:02','Triathlon ACT'),(11,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:34:03','Triathlon ACT'),(12,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:35:04','Triathlon ACT'),(13,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:36:06','Triathlon ACT'),(14,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:36:34','Triathlon ACT'),(15,'Mat@gmail.com','escrime',NULL,'2009-10-20 11:37:37','Triathlon ACT'),(16,'rob@winter.com','2618eafe1418e11d615f0c598f3675c5',NULL,'2009-10-22 09:29:36','WinterWeather'),(17,'john@smith.com','5111a834f08cb69faccade1084c8617f',NULL,'2009-10-22 10:25:14','JS'),(18,'right@fred.com','7f5ea11664876a0f820c4ee4e50a0d15',NULL,'2009-10-22 10:33:22','RF'),(19,'oscar@dog.com','2dff4fc90e2973f54d62e257480de234bc59e2c4',NULL,'2009-10-22 10:47:30','od'),(20,'lilly@dog.com','e49512524f47b4138d850c9d9d85972927281da0',NULL,'2009-10-23 00:26:09','LD'),(21,'mathieu.meriaux@gmail.com','8634c9632d2a98e334a896042f687d1455de9dae',NULL,'2009-10-24 03:44:55','Triathlon ACT'),(23,'Mathieumer@hotmail.com','8634c9632d2a98e334a896042f687d1455de9dae',NULL,'2009-11-05 09:01:49','TACT'),(24,'mat@toto.com','8634c9632d2a98e334a896042f687d1455de9dae',NULL,'2009-11-05 09:04:02','TOTTO'),(25,'easy@scheduling.com','861c4f67e887dec85292d36ab05cd7a1a7275228',NULL,'2009-11-05 09:51:41','ES'),(26,'mathieu@Meriaux.com','8634c9632d2a98e334a896042f687d1455de9dae',NULL,'2009-11-18 08:41:07','TACT'),(27,'roger@tennis.com','9c881bdb6bc930d18797d72d07bb9e01eeb40d8b',NULL,'2009-11-19 23:48:51','Tennis'),(28,'mat@damon.com','68c46a606457643eab92053c1c05574abb26f861',NULL,'2009-11-20 21:51:47','OO'),(29,'mathieu@gmail.com','8634c9632d2a98e334a896042f687d1455de9dae',NULL,'2009-11-25 20:24:12','TACT');
/*!40000 ALTER TABLE `organisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organiser`
--

DROP TABLE IF EXISTS `organiser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organiser` (
  `member_id` int(11) DEFAULT NULL,
  `organisation_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organiser`
--

LOCK TABLES `organiser` WRITE;
/*!40000 ALTER TABLE `organiser` DISABLE KEYS */;
INSERT INTO `organiser` VALUES (25,6),(26,7),(27,8),(28,9),(29,10),(30,11),(31,12),(32,13),(33,14),(34,15),(35,16),(36,17),(37,18),(38,19),(39,20),(40,21),(42,23),(43,24),(44,25),(45,26),(46,27),(47,28),(48,29);
/*!40000 ALTER TABLE `organiser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-11-30  9:45:07
