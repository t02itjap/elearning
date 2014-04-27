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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
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
  `copyright_reporters` text,
  `copyright_violation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not violation, 1: violation',
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1: locked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_documents`
--

LOCK TABLES `tb_documents` WRITE;
/*!40000 ALTER TABLE `tb_documents` DISABLE KEYS */;
INSERT INTO `tb_documents` VALUES (36,15,'NTD01-1.mp4','',61,'2014-04-27 10:29:22','files\\61\\NTD01-1.mp4',NULL,0,0),(37,15,'NTD02-1.mp3','',61,'2014-04-27 10:29:22','files\\61\\NTD02-1.mp3',NULL,0,0),(38,15,'NTD02-1.mp3','',61,'2014-04-27 10:29:22','files\\61\\NTD02-1.mp3',NULL,0,0),(39,15,'NTD03-1.wav','',61,'2014-04-27 10:29:22','files\\61\\NTD03-1.wav',NULL,0,0),(40,15,'NTD04-1.jpg','',61,'2014-04-27 10:29:22','files\\61\\NTD04-1.jpg',NULL,0,0),(41,15,'NTD06-1.png','',61,'2014-04-27 10:29:22','files\\61\\NTD06-1.png',NULL,0,0),(42,15,'NTD07-1.pdf','',61,'2014-04-27 10:29:22','files\\61\\NTD07-1.pdf',NULL,0,0),(43,16,'NTD07-1.pdf','',60,'2014-04-27 11:12:45','files\\60\\NTD07-1.pdf',NULL,0,0),(45,16,'NTD05-1.gif','',60,'2014-04-27 11:12:45','files\\60\\NTD05-1.gif',NULL,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_users`
--

LOCK TABLES `tb_initial_users` WRITE;
/*!40000 ALTER TABLE `tb_initial_users` DISABLE KEYS */;
INSERT INTO `tb_initial_users` VALUES (5,17,'46f4e2584b2db61f19adb27c64831921a68197a4'),(6,18,'3b200bc16619f52f5e8d089b81f5cf7902ec0fae'),(7,20,'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),(8,21,'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),(9,22,'ca69ce3fda74c6b348e04a020bdbcd5d4a82d7bf'),(10,23,'b8135c76a84f1573b7e0403a106cfab85ab95333'),(11,24,'74e23a142904824036c2072bfaee034dbc5d9110'),(12,25,'3d5a97064d812ff698ccf6c8e3a8a21f66787a54'),(13,25,'f42e65cc10495636b58b141622f72ce8100ccce5'),(14,26,'fe903374b279d3888641e7259d45b753325ec631'),(15,27,'92fc2ed0f99d4fc0b29b61c8dff33c1e9043d19b'),(16,28,'c2a2681192ba023ec8d147bb3ce0baf64058fb5a'),(17,29,'c03f174660181f09589b5b0aed62593b453e7bc6'),(18,30,'685b08c1cddf900d933122ff17be15b1267527d1'),(19,31,'685b08c1cddf900d933122ff17be15b1267527d1'),(20,32,'fc538353b0f27ee05758003f4c8a4d3f6db79527'),(21,33,'685b08c1cddf900d933122ff17be15b1267527d1'),(22,34,'bc20fd676cda2828065f4eef89495ffe1f38a48c'),(23,35,'b2f350a8b580f83b9c30502f45a7c69ddde84fb7'),(24,36,'9aa7c51bd5cfd70026a6b331d254ac4b81fc916e'),(25,37,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(26,38,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(27,39,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(28,40,'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),(29,41,'892d9aef7955a701c0f34e470c8b545746de2d69'),(30,42,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(31,43,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(32,44,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(33,45,'2b89945e86179fe56b19297d584679fbe3d80fb3'),(35,47,'89fb7b61ecf3806483a6e4494668e7707b988eec'),(36,48,'914a224e350aa2ac60bb84b69f09961dbeca870d'),(37,50,'e6763fefdf8c4675794f83dd8d19f37ec1d561fb'),(38,51,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(39,52,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(40,53,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(42,56,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(43,57,'89fb7b61ecf3806483a6e4494668e7707b988eec'),(44,58,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(45,60,'1943adfbf87dda06b39e8e38f4b39252a3472551'),(46,61,'1267161fbf982005b197b4c0aa09ac9587f16ee5'),(47,62,'00a215af27506f5939e1cdbd8b5f321851107a3c'),(48,63,'89fb7b61ecf3806483a6e4494668e7707b988eec');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_initial_verifycodes`
--

LOCK TABLES `tb_initial_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_initial_verifycodes` DISABLE KEYS */;
INSERT INTO `tb_initial_verifycodes` VALUES (5,17,'',''),(6,18,'',''),(7,20,'',''),(8,21,'',''),(9,22,'',''),(10,23,'',''),(11,24,'',''),(12,25,'',''),(13,26,'dGFpIHNhbw==','07a6965c84f8c07c42444ef2fc05d5ae2cab47b4'),(14,29,'ZHNh','5f4c9d59ed439923cee361602b8e5f65a64eff35'),(15,34,'dGFpIHNhbw==','d6fbaf19e02c5b827cb152171363f7dfa366b814'),(16,42,'5ZCN5YmN44Gv77yf','53e724ce781235a0d636c52b4977520b1cafd4b8'),(17,43,'d3Rm','53e724ce781235a0d636c52b4977520b1cafd4b8'),(18,44,'d3Rm','c50b299acfd203ba5e9e11f0795f48eedc2119da'),(19,45,'d3Rm','63c738e723a742e459e385e9363cee696d26276b'),(20,50,'d3Rm','2e67c2e9a35bcd7bed66babaaae5fd972dd8ef18'),(21,51,'d3Rm','53e724ce781235a0d636c52b4977520b1cafd4b8'),(22,52,'d3Rm','c50b299acfd203ba5e9e11f0795f48eedc2119da'),(24,58,'MTIz','6eb291bdbff8b679d1e98166314e350db399cc28'),(25,60,'5pig55S7','53e724ce781235a0d636c52b4977520b1cafd4b8'),(26,61,'dGFpIHNhbw==','c50b299acfd203ba5e9e11f0795f48eedc2119da');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lesson_of_categories`
--

LOCK TABLES `tb_lesson_of_categories` WRITE;
/*!40000 ALTER TABLE `tb_lesson_of_categories` DISABLE KEYS */;
INSERT INTO `tb_lesson_of_categories` VALUES (30,15,1),(31,15,2),(32,15,3),(33,15,20),(34,16,2),(35,16,18),(36,16,19);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_lessons`
--

LOCK TABLES `tb_lessons` WRITE;
/*!40000 ALTER TABLE `tb_lessons` DISABLE KEYS */;
INSERT INTO `tb_lessons` VALUES (15,'Lesson1','Lesson 1',61,'2014-04-27 10:29:22',NULL,NULL,NULL,0,0,0),(16,'Lesson2','fsdfsafasdf',60,'2014-04-27 11:18:32',NULL,NULL,'61',1,0,0);
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
INSERT INTO `tb_notifications` VALUES ('535a4c1a-a140-4f01-a603-158800000000','51',NULL,NULL,'あなたのNTD02-1.mp3ファイルがブロックした',NULL,1,'2014-04-25 18:50:50','2014-04-27 17:07:18'),('535ce7a3-fca0-4e5e-9025-09ec00000000','60',NULL,NULL,'あなたの授業Lesson2がタイトル違反した',NULL,1,'2014-04-27 18:18:59','2014-04-27 18:20:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_test_histories`
--

LOCK TABLES `tb_test_histories` WRITE;
/*!40000 ALTER TABLE `tb_test_histories` DISABLE KEYS */;
INSERT INTO `tb_test_histories` VALUES (7,61,6,'2014-04-27 10:47:27','-3-3-2-2',0),(8,61,6,'2014-04-27 11:06:55','-1-4-1-3',15);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tests`
--

LOCK TABLES `tb_tests` WRITE;
/*!40000 ALTER TABLE `tb_tests` DISABLE KEYS */;
INSERT INTO `tb_tests` VALUES (6,15,'NTD08-1.tsv','',61,'2014-04-27 10:29:22','files\\61\\NTD08-1.tsv','',''),(7,16,'NTD08-1.tsv','',60,'2014-04-27 11:12:45','files\\60\\NTD08-1.tsv','','');
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
INSERT INTO `tb_users` VALUES (41,'A01','khanh','2014-04-27 11:08:52',1,'1910-07-02','A01@gmail.com','1234567890','Ha Noi','892d9aef7955a701c0f34e470c8b545746de2d69',1,1,'khong xac dinh','127.0.0.1',1),(60,'T001','teacher1','2014-04-27 11:19:51',2,'1915-11-16','techer1@gmail.com','42343432424','Cfas','1943adfbf87dda06b39e8e38f4b39252a3472551',1,1,'1111-222-3-4444444','127.0.0.1',1),(61,'T002','teacher2','2014-04-27 11:19:39',2,'1915-11-12','teacher02@gmail.com','5425245254','fgafadfa','1267161fbf982005b197b4c0aa09ac9587f16ee5',1,1,'2222-222-3-2222222','127.0.0.1',0),(62,'S001','stu001','2014-04-27 11:10:52',3,'1914-10-17','stu01@gmail.com','467446546','hadkfn','00a215af27506f5939e1cdbd8b5f321851107a3c',1,1,'55555555-2222-7777-3333-9999','127.0.0.1',0),(63,'S002','stu02','2014-04-27 10:25:05',3,'1918-11-15','tien02@gmail.com','34324324234','Viet nam','89fb7b61ecf3806483a6e4494668e7707b988eec',1,1,'45534534-6666-5555-9999-0000','',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_verifycodes`
--

LOCK TABLES `tb_verifycodes` WRITE;
/*!40000 ALTER TABLE `tb_verifycodes` DISABLE KEYS */;
INSERT INTO `tb_verifycodes` VALUES (26,60,'5pig55S7','53e724ce781235a0d636c52b4977520b1cafd4b8'),(27,61,'dGFpIHNhbw==','c50b299acfd203ba5e9e11f0795f48eedc2119da');
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

-- Dump completed on 2014-04-27 18:20:53
