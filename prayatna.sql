-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: prayatna
-- ------------------------------------------------------
-- Server version	5.7.25

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
-- Table structure for table `register_details`
--

DROP TABLE IF EXISTS `register_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `register_details` (
  `workshop_id` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `workshop_id` (`workshop_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `register_details_ibfk_1` FOREIGN KEY (`workshop_id`) REFERENCES `workshop_details` (`workshop_id`),
  CONSTRAINT `register_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `register_details`
--

LOCK TABLES `register_details` WRITE;
/*!40000 ALTER TABLE `register_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `register_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `name` varchar(64) DEFAULT NULL,
  `email_id` varchar(254) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `college` varchar(300) DEFAULT NULL,
  `year_of_study` varchar(4) DEFAULT NULL,
  `bought_entry` tinyint(1) DEFAULT '0',
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `city` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES ('k7','kesavanpalanipk@gmail.com','9090909090','12345',1,NULL,NULL,0,NULL,NULL,''),('k7','akshayred@gmail.com','9090909090','aksgay',2,NULL,NULL,0,NULL,NULL,''),('sample','sample@gmail.com','9090909091','12345',15,'MIT','1',0,NULL,NULL,''),('check','check@gmail.com','9912341234','12345',17,'ASG','1',0,NULL,NULL,''),('vikkikdi','vikramansathi@gmail.com','9119911999','gay123',18,'CMU','3',0,NULL,NULL,''),('dk','deepakoii@gmail.com','9090101010','oii123',19,'MIT','4',0,NULL,NULL,''),('dk1','dk@gmail.com','9090121244','12345',20,'MIT','3',0,NULL,NULL,''),('karthik','karthik@gmail.com','9090121290','12345',21,'MIT','3',0,NULL,NULL,''),('gowtham','gowtham@gmail.com','9898121280','12345',22,'MIT','3',0,NULL,NULL,''),('deepak','abcde@gmail.com','9856748234','abcde',23,'MIT','1',0,NULL,NULL,''),('tim','jeyadosstimothy2@gmail.com','6547891234','12345',24,'MIT','2',0,NULL,NULL,'Chennai'),('Timothy Jones Thomas J','jeyadosstimothy3@gmail.com','9677207736','12345',26,'mit','4',0,NULL,NULL,'chennai'),('Timothy','jeyadosstimothy1@gmail.com','9677207737','12345',27,'mit','2',0,NULL,NULL,'chennai'),('Timothy J','jeyadosstimothy@gmail.com','9677207739','12345',28,'MIT','4',1,'2019-03-07','2019-02-09','Chennai');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workshop_details`
--

DROP TABLE IF EXISTS `workshop_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workshop_details` (
  `workshop_name` varchar(30) DEFAULT NULL,
  `workshop_id` varchar(30) NOT NULL,
  `date` varchar(30) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`workshop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshop_details`
--

LOCK TABLES `workshop_details` WRITE;
/*!40000 ALTER TABLE `workshop_details` DISABLE KEYS */;
INSERT INTO `workshop_details` VALUES ('Artificial Intelligence','artificial-intelligence','March 8th, 2019',699),('Cracking the Coding Interview','cracking-the-coding-interview','March 8th, 2019',499),('Cyber Security','cyber-security','March 9th, 2019',699),('Flutter','flutter','March 8th, 2019',799),('ReactJS','react-js','March 9th, 2019',649),('System Design','system-design','March 9th, 2019',699);
/*!40000 ALTER TABLE `workshop_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-08 20:27:01
