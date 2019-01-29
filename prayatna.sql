-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: prayatna
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.16.04.2

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
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`workshop_id`),
  KEY `workshop_id` (`workshop_id`),
  CONSTRAINT `register_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`),
  CONSTRAINT `register_details_ibfk_2` FOREIGN KEY (`workshop_id`) REFERENCES `workshop_details` (`workshop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `register_details`
--

LOCK TABLES `register_details` WRITE;
/*!40000 ALTER TABLE `register_details` DISABLE KEYS */;
INSERT INTO `register_details` VALUES (1,1),(1,2),(2,3);
/*!40000 ALTER TABLE `register_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `name` varchar(30) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `college` varchar(50) DEFAULT NULL,
  `year_of_study` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES ('k7','kesavanpalanipk@gmail.com','9090909090','12345',1,NULL,NULL),('k7','akshayred@gmail.com','9090909090','aksgay',2,NULL,NULL),('timothy','jeyadosstimothy@gmail.com','9090902424','12345',3,'MIT','1'),('sample','sample@gmail.com','9090909091','12345',15,'MIT','1');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workshop_details`
--

DROP TABLE IF EXISTS `workshop_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workshop_details` (
  `workshop_id` int(11) NOT NULL,
  `workshop_name` varchar(30) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`workshop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshop_details`
--

LOCK TABLES `workshop_details` WRITE;
/*!40000 ALTER TABLE `workshop_details` DISABLE KEYS */;
INSERT INTO `workshop_details` VALUES (1,'Flutter','2019-03-08'),(2,'Cyber_security','2019-03-08'),(3,'system_design','2019-03-09'),(4,'Placement','2019-03-09'),(5,'Node.js','2019-03-09'),(6,'Artificial Intelligence','2019-03-09'),(7,'Android','2019-03-09');
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

-- Dump completed on 2019-01-29 20:41:02
