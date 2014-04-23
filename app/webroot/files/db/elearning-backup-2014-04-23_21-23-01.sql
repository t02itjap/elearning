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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_banned_students`
--

LOCK TABLES `tb_banned_students` WRITE;
/*!40000 ALTER TABLE `tb_banned_students` DISABLE KEYS */;
INSERT INTO `tb_banned_students` VALUES (1,2,3,'Học rốt','2014-02-25 17:08:52');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_bills`
--

LOCK TABLES `tb_bills` WRITE;
/*!40000 ALTER TABLE `tb_bills` DISABLE KEYS */;
INSERT INTO `tb_bills` VALUES (1,3,1,'2014-02-25 17:06:17',1),(2,3,1,'2014-02-25 17:11:27',2000),(3,35,1,'2014-04-14 03:14:00',20000),(4,46,1,'2014-04-17 07:54:00',20000),(5,46,1,'2014-04-17 07:55:00',20000);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_categories`
--

LOCK TABLES `tb_categories` WRITE;
/*!40000 ALTER TABLE `tb_categories` DISABLE KEYS */;
INSERT INTO `tb_categories` VALUES (1,'Math'),(2,'Physic'),(3,'Japanese'),(4,'gfdgdf'),(5,'gfdgdf'),(6,'aaa'),(7,'bbb'),(10,'ccc'),(12,'nhu l');
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
INSERT INTO `tb_changeable_values` VALUES (1,'Session',180),(2,'Fee of a Leason for Teacher',40),(3,'Fee of System for a Leason',60),(4,'wrong password input',3),(5,'lock time',30),(6,'lesson cost',20000),(7,'learning time',7),(8,'auto back up time',7);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_comments`
--

LOCK TABLES `tb_comments` WRITE;
/*!40000 ALTER TABLE `tb_comments` DISABLE KEYS */;
INSERT INTO `tb_comments` VALUES (1,1,1,'Bài này có gì đâu mà cũng comment.\r\nComment câu like.\r\nLike tao cho thằng giáo viên nó tức.\r\nCảm ơn đảng nhà nước đã cho em comment vào topic này. \r\nVui vcl.','2014-02-25 17:09:51'),(2,25,1,'ng u v l','2014-03-11 07:08:40');
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
  `copyright_reporters` text,
  `copyright_violation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not violation, 1: violation',
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1: locked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_documents`
--

LOCK TABLES `tb_documents` WRITE;
/*!40000 ALTER TABLE `tb_documents` DISABLE KEYS */;
INSERT INTO `tb_documents` VALUES (1,1,'toan_cao_cap.pdf','Bài giảng 1 toán cao cấp',2,'2014-03-11 07:53:49','https://google.com','8',2,0),(2,2,'Peacock - Z Hera.mp3','',44,'2014-04-17 07:18:02','files/Peacock - Z Hera.mp3',NULL,0,0),(3,2,'Chrysanthemum.jpg','',44,'2014-04-17 07:18:02','files/Chrysanthemum.jpg',NULL,0,0),(4,2,'Untitled.png','',44,'2014-04-17 07:18:02','files/Untitled.png',NULL,0,0),(5,2,'01W-02-E-learningシステム機能要求仕様V03.02.pdf','',44,'2014-04-17 07:18:02','files/01W-02-E-learningシステム機能要求仕様V03.02.pdf',NULL,0,0),(6,2,'01W-02-E-learningシステム機能要求仕様V03.00.pdf','',44,'2014-04-17 07:18:02','files/01W-02-E-learningシステム機能要求仕様V03.00.pdf',NULL,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_users`
--

LOCK TABLES `tb_initial_users` WRITE;
/*!40000 ALTER TABLE `tb_initial_users` DISABLE KEYS */;
INSERT INTO `tb_initial_users` VALUES (5,17,'46f4e2584b2db61f19adb27c64831921a68197a4'),(6,18,'3b200bc16619f52f5e8d089b81f5cf7902ec0fae'),(7,20,'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),(8,21,'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),(9,22,'ca69ce3fda74c6b348e04a020bdbcd5d4a82d7bf'),(10,23,'b8135c76a84f1573b7e0403a106cfab85ab95333'),(11,24,'74e23a142904824036c2072bfaee034dbc5d9110'),(12,25,'3d5a97064d812ff698ccf6c8e3a8a21f66787a54'),(13,25,'f42e65cc10495636b58b141622f72ce8100ccce5'),(14,26,'fe903374b279d3888641e7259d45b753325ec631'),(15,27,'92fc2ed0f99d4fc0b29b61c8dff33c1e9043d19b'),(16,28,'c2a2681192ba023ec8d147bb3ce0baf64058fb5a'),(17,29,'c03f174660181f09589b5b0aed62593b453e7bc6'),(18,30,'685b08c1cddf900d933122ff17be15b1267527d1'),(19,31,'685b08c1cddf900d933122ff17be15b1267527d1'),(20,32,'fc538353b0f27ee05758003f4c8a4d3f6db79527'),(21,33,'685b08c1cddf900d933122ff17be15b1267527d1'),(22,34,'bc20fd676cda2828065f4eef89495ffe1f38a48c'),(23,35,'b2f350a8b580f83b9c30502f45a7c69ddde84fb7'),(24,36,'9aa7c51bd5cfd70026a6b331d254ac4b81fc916e'),(25,37,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(26,38,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(27,39,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(28,40,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(29,41,'892d9aef7955a701c0f34e470c8b545746de2d69'),(30,42,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(31,43,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(32,44,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(33,45,'2b89945e86179fe56b19297d584679fbe3d80fb3'),(34,46,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(35,47,'89fb7b61ecf3806483a6e4494668e7707b988eec'),(36,48,'914a224e350aa2ac60bb84b69f09961dbeca870d');
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_verifycodes`
--

LOCK TABLES `tb_initial_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_initial_verifycodes` DISABLE KEYS */;
INSERT INTO `tb_initial_verifycodes` VALUES (5,17,'',''),(6,18,'',''),(7,20,'',''),(8,21,'',''),(9,22,'',''),(10,23,'',''),(11,24,'',''),(12,25,'',''),(13,26,'dGFpIHNhbw==','07a6965c84f8c07c42444ef2fc05d5ae2cab47b4'),(14,29,'ZHNh','5f4c9d59ed439923cee361602b8e5f65a64eff35'),(15,34,'dGFpIHNhbw==','d6fbaf19e02c5b827cb152171363f7dfa366b814'),(16,42,'5ZCN5YmN44Gv77yf','53e724ce781235a0d636c52b4977520b1cafd4b8'),(17,43,'d3Rm','53e724ce781235a0d636c52b4977520b1cafd4b8'),(18,44,'d3Rm','c50b299acfd203ba5e9e11f0795f48eedc2119da'),(19,45,'d3Rm','63c738e723a742e459e385e9363cee696d26276b');
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
INSERT INTO `tb_ip_addresses` VALUES (30,17,'192.168.0.1'),(31,28,'192.168.1.0'),(32,37,'127.0.0.1'),(33,38,'127.0.0.1'),(34,39,'127.0.0.1'),(41,41,'127.0.0.1'),(42,40,'127.0.0.1'),(43,40,'192.168.0.1');
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
INSERT INTO `tb_learn_histories` VALUES (1,2,'2014-02-25 17:11:58');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lesson_of_categories`
--

LOCK TABLES `tb_lesson_of_categories` WRITE;
/*!40000 ALTER TABLE `tb_lesson_of_categories` DISABLE KEYS */;
INSERT INTO `tb_lesson_of_categories` VALUES (1,1,1);
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
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: locked, 0: not locked',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: exist, 1: delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lessons`
--

LOCK TABLES `tb_lessons` WRITE;
/*!40000 ALTER TABLE `tb_lessons` DISABLE KEYS */;
INSERT INTO `tb_lessons` VALUES (1,'Toán cao cấp','Toán cao cấp - Giải phương trình bậc 1',43,'2014-04-18 05:56:18',NULL,'0,35,46','0,44',1,0,0),(2,'','',44,'2014-04-17 07:18:02',NULL,NULL,NULL,0,0,0),(3,'anh lam nhu shit','thuc su la anh lam nhu shit',44,'2014-04-17 07:24:47',NULL,NULL,NULL,0,0,0),(4,'aaa','bbb',43,'2014-04-18 02:28:21',NULL,NULL,NULL,0,0,0),(5,'ccc','ddd',43,'2014-04-18 02:52:30',NULL,NULL,NULL,0,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_locked_users`
--

LOCK TABLES `tb_locked_users` WRITE;
/*!40000 ALTER TABLE `tb_locked_users` DISABLE KEYS */;
INSERT INTO `tb_locked_users` VALUES (2,'::1',1,0,'0000-00-00 00:00:00'),(3,'64.37.66.58',1,0,'0000-00-00 00:00:00'),(4,'18.53.42.11',1,0,'0000-00-00 00:00:00'),(5,'21.85.53.17',1,0,'0000-00-00 00:00:00'),(6,'55.2.43.20',1,0,'0000-00-00 00:00:00');
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
INSERT INTO `tb_notifications` VALUES ('5356989d-37f0-463b-aae3-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 18:28:13','2014-04-22 18:33:21'),('53569795-0df0-447a-9a9e-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 18:23:49','2014-04-22 18:26:48'),('53568d25-5d34-483a-8c09-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 17:39:17','2014-04-22 17:39:40'),('53568d87-72cc-48cc-9705-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 17:40:55','2014-04-22 17:41:06'),('53568d93-dcb4-4205-9f27-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 17:41:07','2014-04-22 17:43:21'),('53568f86-91e0-483f-a585-189000000000','41',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 17:49:26','2014-04-22 21:36:51'),('5355f58a-36d4-4e0a-bafa-17c400000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 06:52:26','2014-04-22 16:38:38'),('5356a981-2ccc-4cc8-82fe-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:40:17','2014-04-22 19:40:29'),('5356a98e-6728-4622-a840-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:40:30','2014-04-22 19:40:43'),('5356a99d-3c80-4ce7-b97d-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:40:45','2014-04-22 19:41:01'),('5356a9ae-4380-4ec9-a6d5-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:41:02','2014-04-22 19:41:26'),('5356a9c7-d698-4d0c-a7b6-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:41:27','2014-04-22 19:42:19'),('5356ab32-c3c8-4658-96e0-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:47:30','2014-04-22 19:54:54'),('5356ab79-b608-4cc7-a2b4-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:48:41','2014-04-22 19:53:37'),('5356ab99-1424-4a2e-a319-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:49:13','2014-04-22 19:49:30'),('5356abab-c84c-40ff-90e6-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 19:49:31','2014-04-22 19:53:24'),('5356b1ac-3958-4b20-9242-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 20:15:08','2014-04-22 20:15:08'),('5356b1b1-613c-4f3c-bca1-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 20:15:13','2014-04-22 20:15:13'),('5356b1b3-5308-40eb-93a5-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 20:15:15','2014-04-22 20:15:15'),('5356b1c1-f06c-4130-af93-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 20:15:29','2014-04-22 20:15:29'),('5356b1cb-cc58-4495-92ef-189000000000','44',NULL,NULL,'You logged in!',NULL,1,'2014-04-22 20:15:39','2014-04-22 20:18:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_test_histories`
--

LOCK TABLES `tb_test_histories` WRITE;
/*!40000 ALTER TABLE `tb_test_histories` DISABLE KEYS */;
INSERT INTO `tb_test_histories` VALUES (1,1,1,'2014-02-25 17:14:16','https://google.com.vn/test1.tsv',100);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tests`
--

LOCK TABLES `tb_tests` WRITE;
/*!40000 ALTER TABLE `tb_tests` DISABLE KEYS */;
INSERT INTO `tb_tests` VALUES (1,1,'test_toan_cap_cap.tsv','Test bài toán cao cấp, bài 1.',2,'2014-02-25 17:13:43','https://google.com','https://google.com.vn','');
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
INSERT INTO `tb_users` VALUES (17,'nguyendinhkhanh','khanh','2014-04-06 16:16:16',1,'1915-11-18','vuabanhmi_xanh@yahoo.com','456','123','46f4e2584b2db61f19adb27c64831921a68197a4',1,0,'123','',0),(21,'nguyendinhtanh','tanh','2014-04-17 08:41:15',2,'1902-03-01','vuabanhmi_tanh@yahoo.com','123','123','fac26a0dc55e09bbab5a2d536b1bce2ac374e87a',1,1,'123','',0),(22,'nguyendinhhanh','tanh','2014-04-17 08:39:43',2,'1902-03-01','vuabanhmi_hanh@yahoo.com','123','123','ca69ce3fda74c6b348e04a020bdbcd5d4a82d7bf',1,1,'123','',0),(23,'nguyendinhmanh','tanh','2014-04-17 08:39:06',2,'1902-03-01','vuabanhmi_manh@yahoo.com','123','123','b8135c76a84f1573b7e0403a106cfab85ab95333',1,1,'123','',0),(24,'nguyendinhlanh','tanh','2014-04-17 08:38:21',2,'1902-03-01','vuabanhmi_lanh@yahoo.com','123','123','74e23a142904824036c2072bfaee034dbc5d9110',1,1,'123','',0),(25,'anhdeptrai','khanh','2014-04-06 16:11:09',2,'1918-12-19','vuabanhmi_canh@gmail.com','123','123','f42e65cc10495636b58b141622f72ce8100ccce5',1,1,'123','127.0.0.1',0),(26,'anhdeptrai1','khanh','2014-04-17 08:44:20',2,'1918-12-19','vuabanhmi_ianh@gmail.com','123','123','fe903374b279d3888641e7259d45b753325ec631',1,1,'123','',0),(27,'anhdeptrai2','khanh','2014-04-09 16:08:03',1,'1914-01-15','vuabanhmi_tanh@gmail.com','123','123','92fc2ed0f99d4fc0b29b61c8dff33c1e9043d19b',1,1,'khong xac dinh','127.0.0.1',0),(28,'anhdeptrai3','khanh','2014-04-06 16:26:23',3,'1914-01-15','vuabanhmi_tanh@khanh.com','123','123','c2a2681192ba023ec8d147bb3ce0baf64058fb5a',1,1,'khong xac dinh','',0),(29,'admin','admin','2014-04-17 10:05:21',2,'1945-11-30','admin@yahoo.com','123','123','c03f174660181f09589b5b0aed62593b453e7bc6',1,1,'123','',0),(33,'hoanle','hoanle','2014-04-06 16:25:03',3,'1900-10-10','hoanle@gmail.com','123','123','685b08c1cddf900d933122ff17be15b1267527d1',1,1,'123','',0),(34,'khanh','khanh','2014-04-07 07:23:23',2,'1918-12-19','vua@gmail.com','123','123','bc20fd676cda2828065f4eef89495ffe1f38a48c',1,1,'123','127.0.0.1',0),(35,'student','student','2014-04-08 07:51:03',3,'1918-11-18','vuabanhmi@gmail.com','123456','123','b2f350a8b580f83b9c30502f45a7c69ddde84fb7',1,1,'123','127.0.0.1',0),(36,'bacbaphi','本田','2014-04-17 08:37:34',3,'1917-01-19','本田@gmail.com','123456','123','9aa7c51bd5cfd70026a6b331d254ac4b81fc916e',1,1,'1234567','',0),(40,'A00','khanh','2014-04-17 06:13:06',1,'1999-02-01','A00@gmail.com','123456789','ha noi','92aa2fd48e7b316d36535f6a249b662688d1e55e',1,1,'khong xac dinh','127.0.0.1',0),(41,'A01','khanh','2014-04-17 07:33:11',1,'1910-07-02','A01@gmail.com','1234567890','Ha Noi','892d9aef7955a701c0f34e470c8b545746de2d69',1,1,'khong xac dinh','127.0.0.1',0),(43,'T001','khanh','2014-04-17 12:03:28',2,'1946-02-02','T001@gmail.com','123456789','Ha Noi','1943adfbf87dda06b39e8e38f4b39252a3472551',1,1,'123456','127.0.0.1',0),(44,'T002','khanh','2014-04-23 08:11:02',2,'1944-03-02','T002@gmail.com','123456789','Ha Loi','1267161fbf982005b197b4c0aa09ac9587f16ee5',1,1,'123456789','105.163.181.125',0),(46,'S001','khanh','2014-04-17 12:04:13',3,'1961-04-02','S001@gmail.com','123456789','Ha Noi','00a215af27506f5939e1cdbd8b5f321851107a3c',1,1,'123456','127.0.0.1',0),(47,'S002','khanh','2014-04-17 12:00:48',3,'1957-03-03','S002@gmail.com','123456789','Ha Loi','89fb7b61ecf3806483a6e4494668e7707b988eec',1,1,'1234567890','127.0.0.1',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_verifycodes`
--

LOCK TABLES `tb_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_verifycodes` DISABLE KEYS */;
INSERT INTO `tb_verifycodes` VALUES (5,17,'dGFpIHNhbw==','867b22a1b2bf13730569b1dde9661ee9e9d5cf98'),(7,20,'dGFpIHNhbw==','8e35495513865e7020f9cb0d89de638630c8961c'),(8,21,'dGFpIHNhbw==','8e35495513865e7020f9cb0d89de638630c8961c'),(9,22,'dGFpIHNhbw==','59bd1878282b18482048b82276a4eba7cfac74d8'),(10,23,'dGFpIHNhbw==','460e0dad5c86477378cfce8cf379e0932ddc874a'),(11,24,'dGFpIHNhbw==','1c74383b0e9ac51210f22b41061a201f733245a9'),(12,25,'dGFpIHNhbw==','4d89613319b3af6aa360acc69a9f34b174e9620b'),(13,26,'dGFpIHNhbw==','07a6965c84f8c07c42444ef2fc05d5ae2cab47b4'),(14,29,'ZHNh','5f4c9d59ed439923cee361602b8e5f65a64eff35'),(15,34,'dGFpIHNhbw==','d6fbaf19e02c5b827cb152171363f7dfa366b814'),(16,42,'5ZCN5YmN44Gv77yf','53e724ce781235a0d636c52b4977520b1cafd4b8'),(17,43,'d3Rm','53e724ce781235a0d636c52b4977520b1cafd4b8'),(18,44,'b29r','8ed6706a56790aad16227bc0c0529f5680f4448d'),(19,45,'d3Rm','63c738e723a742e459e385e9363cee696d26276b'),(20,0,'','779c73d6a7a2444f7e0dbf7182c966a7211e26b2');
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

-- Dump completed on 2014-04-24  2:23:03
