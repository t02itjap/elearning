-- MySQL dump 10.13  Distrib 5.5.32, for Win32 (x86)
--
-- Host: localhost    Database: elearning
-- ------------------------------------------------------
-- Server version	5.5.32

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
-- Table structure for table `tb_banned_students`
--

DROP TABLE IF EXISTS `tb_banned_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_banned_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `banned_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_banned_students`
--

LOCK TABLES `tb_banned_students` WRITE;
/*!40000 ALTER TABLE `tb_banned_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_banned_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_bills`
--

DROP TABLE IF EXISTS `tb_bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `learn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lesson_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_bills`
--

LOCK TABLES `tb_bills` WRITE;
/*!40000 ALTER TABLE `tb_bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_categories`
--

DROP TABLE IF EXISTS `tb_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_categories`
--

LOCK TABLES `tb_categories` WRITE;
/*!40000 ALTER TABLE `tb_categories` DISABLE KEYS */;
INSERT INTO `tb_categories` VALUES (1,'Math'),(2,'Physic'),(3,'Japanese'),(18,'Computer'),(19,'Computer43554'),(20,'English');
/*!40000 ALTER TABLE `tb_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_changeable_values`
--

DROP TABLE IF EXISTS `tb_changeable_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_changeable_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desciption` text NOT NULL,
  `current_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_changeable_values`
--

LOCK TABLES `tb_changeable_values` WRITE;
/*!40000 ALTER TABLE `tb_changeable_values` DISABLE KEYS */;
INSERT INTO `tb_changeable_values` VALUES (1,'Session',10),(2,'Fee of a Leason for Teacher',40),(3,'Fee of System for a Leason',60),(4,'wrong password input',7),(5,'lock time',30),(6,'lesson cost',20000),(7,'learning time',7),(8,'auto back up time',7);
/*!40000 ALTER TABLE `tb_changeable_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_comments`
--

DROP TABLE IF EXISTS `tb_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_comments`
--

LOCK TABLES `tb_comments` WRITE;
/*!40000 ALTER TABLE `tb_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_documents`
--

DROP TABLE IF EXISTS `tb_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_link` varchar(255) NOT NULL,
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1: locked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_documents`
--

LOCK TABLES `tb_documents` WRITE;
/*!40000 ALTER TABLE `tb_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_initial_users`
--

DROP TABLE IF EXISTS `tb_initial_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_initial_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `initial_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_users`
--

LOCK TABLES `tb_initial_users` WRITE;
/*!40000 ALTER TABLE `tb_initial_users` DISABLE KEYS */;
INSERT INTO `tb_initial_users` VALUES (36,48,'914a224e350aa2ac60bb84b69f09961dbeca870d'),(37,50,'e6763fefdf8c4675794f83dd8d19f37ec1d561fb'),(38,51,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(39,52,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(40,53,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(42,56,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(43,57,'89fb7b61ecf3806483a6e4494668e7707b988eec'),(44,58,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(46,61,'1267161fbf982005b197b4c0aa09ac9587f16ee5');
/*!40000 ALTER TABLE `tb_initial_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_initial_verifycodes`
--

DROP TABLE IF EXISTS `tb_initial_verifycodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_initial_verifycodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `initial_question` varchar(255) NOT NULL,
  `initial_verifycode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_verifycodes`
--

LOCK TABLES `tb_initial_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_initial_verifycodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_initial_verifycodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_ip_addresses`
--

DROP TABLE IF EXISTS `tb_ip_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_ip_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_ip_addresses`
--

LOCK TABLES `tb_ip_addresses` WRITE;
/*!40000 ALTER TABLE `tb_ip_addresses` DISABLE KEYS */;
INSERT INTO `tb_ip_addresses` VALUES (41,41,'127.0.0.1');
/*!40000 ALTER TABLE `tb_ip_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_learn_histories`
--

DROP TABLE IF EXISTS `tb_learn_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_learn_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `learn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_learn_histories`
--

LOCK TABLES `tb_learn_histories` WRITE;
/*!40000 ALTER TABLE `tb_learn_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_learn_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_lesson_of_categories`
--

DROP TABLE IF EXISTS `tb_lesson_of_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_lesson_of_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lesson_of_categories`
--

LOCK TABLES `tb_lesson_of_categories` WRITE;
/*!40000 ALTER TABLE `tb_lesson_of_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_lesson_of_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_lessons`
--

DROP TABLE IF EXISTS `tb_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `viewers` text,
  `voters` text,
  `title_reporters` text,
  `title_violation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:violation, 0: not violation',
  `copyright_reporters` text,
  `copyright_violation` tinyint(1) NOT NULL DEFAULT '0',
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: locked, 0: not locked',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: exist, 1: delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lessons`
--

LOCK TABLES `tb_lessons` WRITE;
/*!40000 ALTER TABLE `tb_lessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_locked_users`
--

DROP TABLE IF EXISTS `tb_locked_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_locked_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `lock_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1 lock',
  `lock_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_locked_users`
--

LOCK TABLES `tb_locked_users` WRITE;
/*!40000 ALTER TABLE `tb_locked_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_locked_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_notifications`
--

DROP TABLE IF EXISTS `tb_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_notifications` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `sender_id` varchar(36) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_notifications`
--

LOCK TABLES `tb_notifications` WRITE;
/*!40000 ALTER TABLE `tb_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_test_histories`
--

DROP TABLE IF EXISTS `tb_test_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_test_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `test_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `answers` varchar(255) NOT NULL,
  `score` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_test_histories`
--

LOCK TABLES `tb_test_histories` WRITE;
/*!40000 ALTER TABLE `tb_test_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_test_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tests`
--

DROP TABLE IF EXISTS `tb_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_link` varchar(255) NOT NULL,
  `answers` varchar(255) NOT NULL,
  `mark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tests`
--

LOCK TABLES `tb_tests` WRITE;
/*!40000 ALTER TABLE `tb_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_users`
--

DROP TABLE IF EXISTS `tb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user code',
  `user_name` varchar(255) NOT NULL COMMENT 'user name',
  `real_name` varchar(255) NOT NULL COMMENT 'real name',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'register day',
  `level` int(1) NOT NULL DEFAULT '3' COMMENT '1: admin, 2: teacher. 3: student',
  `birth_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `approve_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not approve yet. 1: approved',
  `status_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: account was deleted, 1: account has existed',
  `bank_account_code` varchar(255) NOT NULL COMMENT 'if user is student, thi column is regedit_card, else this column is bank_account_code',
  `ip_address` varchar(255) NOT NULL,
  `online_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: offline, 1: online',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
INSERT INTO `tb_users` VALUES (41,'A01','khanh','2014-04-28 05:46:54',1,'1910-07-02','A01@gmail.com','1234567890','Ha Noi','892d9aef7955a701c0f34e470c8b545746de2d69',1,1,'khong xac dinh','127.0.0.1',1);
/*!40000 ALTER TABLE `tb_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_verifycodes`
--

DROP TABLE IF EXISTS `tb_verifycodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_verifycodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `verifycode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_verifycodes`
--

LOCK TABLES `tb_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_verifycodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_verifycodes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-28 12:47:19
