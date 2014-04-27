-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2014 at 06:20 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elearning`
--
CREATE DATABASE IF NOT EXISTS `elearning` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `elearning`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_banned_students`
--

CREATE TABLE IF NOT EXISTS `tb_banned_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `banned_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_banned_students`
--

INSERT INTO `tb_banned_students` (`id`, `teacher_id`, `student_id`, `reason`, `banned_date`) VALUES
(5, 51, 56, 'kjkfa', '2014-04-24 23:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bills`
--

CREATE TABLE IF NOT EXISTS `tb_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `learn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lesson_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tb_bills`
--

INSERT INTO `tb_bills` (`id`, `user_id`, `lesson_id`, `learn_date`, `lesson_cost`) VALUES
(9, 56, 13, '2014-04-25 11:15:00', 20000),
(10, 57, 14, '2014-04-25 11:28:00', 20000),
(11, 57, 13, '2014-04-25 11:30:00', 20000),
(12, 56, 14, '2014-04-25 11:45:00', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_categories`
--

CREATE TABLE IF NOT EXISTS `tb_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tb_categories`
--

INSERT INTO `tb_categories` (`id`, `category_name`) VALUES
(1, 'Math'),
(2, 'Physic'),
(3, 'Japanese'),
(18, 'Computer'),
(19, 'Computer43554'),
(20, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `tb_changeable_values`
--

CREATE TABLE IF NOT EXISTS `tb_changeable_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desciption` text NOT NULL,
  `current_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_changeable_values`
--

INSERT INTO `tb_changeable_values` (`id`, `desciption`, `current_value`) VALUES
(1, 'Session', 10),
(2, 'Fee of a Leason for Teacher', 40),
(3, 'Fee of System for a Leason', 60),
(4, 'wrong password input', 7),
(5, 'lock time', 30),
(6, 'lesson cost', 20000),
(7, 'learning time', 7),
(8, 'auto back up time', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_comments`
--

CREATE TABLE IF NOT EXISTS `tb_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tb_comments`
--

INSERT INTO `tb_comments` (`id`, `user_id`, `lesson_id`, `comment`, `comment_date`) VALUES
(9, 56, 13, 'Video ngan the.', '2014-04-25 11:19:20'),
(10, 51, 13, 'ngan', '2014-04-25 11:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `tb_documents`
--

CREATE TABLE IF NOT EXISTS `tb_documents` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `tb_documents`
--

INSERT INTO `tb_documents` (`id`, `lesson_id`, `file_name`, `description`, `create_user_id`, `create_date`, `file_link`, `copyright_reporters`, `copyright_violation`, `lock_flag`) VALUES
(27, 13, 'NTD01-1.mp4', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD01-1.mp4', NULL, 0, 0),
(28, 13, 'NTD02-1.mp3', '', 51, '2014-04-25 11:50:50', 'files\\51\\NTD02-1.mp3', '1', 1, 1),
(29, 13, 'NTD03-1.wav', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD03-1.wav', NULL, 0, 0),
(30, 13, 'NTD04-1.jpg', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD04-1.jpg', NULL, 0, 0),
(31, 13, 'NTD05-1.gif', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD05-1.gif', NULL, 0, 0),
(32, 13, 'NTD06-1.png', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD06-1.png', NULL, 0, 0),
(33, 13, 'NTD07-1.pdf', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD07-1.pdf', NULL, 0, 0),
(34, 14, 'NTD02-1.mp3', '', 58, '2014-04-25 11:26:35', 'files\\58\\NTD02-1.mp3', NULL, 0, 0),
(35, 14, 'NTD04-1.jpg', '', 58, '2014-04-25 11:26:35', 'files\\58\\NTD04-1.jpg', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_initial_users`
--

CREATE TABLE IF NOT EXISTS `tb_initial_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `initial_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `tb_initial_users`
--

INSERT INTO `tb_initial_users` (`id`, `user_id`, `initial_password`) VALUES
(5, 17, '46f4e2584b2db61f19adb27c64831921a68197a4'),
(6, 18, '3b200bc16619f52f5e8d089b81f5cf7902ec0fae'),
(7, 20, 'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),
(8, 21, 'fac26a0dc55e09bbab5a2d536b1bce2ac374e87a'),
(9, 22, 'ca69ce3fda74c6b348e04a020bdbcd5d4a82d7bf'),
(10, 23, 'b8135c76a84f1573b7e0403a106cfab85ab95333'),
(11, 24, '74e23a142904824036c2072bfaee034dbc5d9110'),
(12, 25, '3d5a97064d812ff698ccf6c8e3a8a21f66787a54'),
(13, 25, 'f42e65cc10495636b58b141622f72ce8100ccce5'),
(14, 26, 'fe903374b279d3888641e7259d45b753325ec631'),
(15, 27, '92fc2ed0f99d4fc0b29b61c8dff33c1e9043d19b'),
(16, 28, 'c2a2681192ba023ec8d147bb3ce0baf64058fb5a'),
(17, 29, 'c03f174660181f09589b5b0aed62593b453e7bc6'),
(18, 30, '685b08c1cddf900d933122ff17be15b1267527d1'),
(19, 31, '685b08c1cddf900d933122ff17be15b1267527d1'),
(20, 32, 'fc538353b0f27ee05758003f4c8a4d3f6db79527'),
(21, 33, '685b08c1cddf900d933122ff17be15b1267527d1'),
(22, 34, 'bc20fd676cda2828065f4eef89495ffe1f38a48c'),
(23, 35, 'b2f350a8b580f83b9c30502f45a7c69ddde84fb7'),
(24, 36, '9aa7c51bd5cfd70026a6b331d254ac4b81fc916e'),
(25, 37, 'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),
(26, 38, 'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),
(27, 39, 'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),
(28, 40, 'f0d9d5442fef580fb5cbf119815fd113cb4506c4'),
(29, 41, '892d9aef7955a701c0f34e470c8b545746de2d69'),
(30, 42, '1943adfbf87dda06b39e8e38f4b39252a3472551'),
(31, 43, '1943adfbf87dda06b39e8e38f4b39252a3472551'),
(32, 44, '1267161fbf982005b197b4c0aa09ac9587f16ee5'),
(33, 45, '2b89945e86179fe56b19297d584679fbe3d80fb3'),
(35, 47, '89fb7b61ecf3806483a6e4494668e7707b988eec'),
(36, 48, '914a224e350aa2ac60bb84b69f09961dbeca870d'),
(37, 50, 'e6763fefdf8c4675794f83dd8d19f37ec1d561fb'),
(38, 51, '1943adfbf87dda06b39e8e38f4b39252a3472551'),
(39, 52, '1267161fbf982005b197b4c0aa09ac9587f16ee5'),
(40, 53, '00a215af27506f5939e1cdbd8b5f321851107a3c'),
(42, 56, '00a215af27506f5939e1cdbd8b5f321851107a3c'),
(43, 57, '89fb7b61ecf3806483a6e4494668e7707b988eec'),
(44, 58, '1267161fbf982005b197b4c0aa09ac9587f16ee5');

-- --------------------------------------------------------

--
-- Table structure for table `tb_initial_verifycodes`
--

CREATE TABLE IF NOT EXISTS `tb_initial_verifycodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `initial_question` varchar(255) NOT NULL,
  `initial_verifycode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tb_initial_verifycodes`
--

INSERT INTO `tb_initial_verifycodes` (`id`, `user_id`, `initial_question`, `initial_verifycode`) VALUES
(5, 17, '', ''),
(6, 18, '', ''),
(7, 20, '', ''),
(8, 21, '', ''),
(9, 22, '', ''),
(10, 23, '', ''),
(11, 24, '', ''),
(12, 25, '', ''),
(13, 26, 'dGFpIHNhbw==', '07a6965c84f8c07c42444ef2fc05d5ae2cab47b4'),
(14, 29, 'ZHNh', '5f4c9d59ed439923cee361602b8e5f65a64eff35'),
(15, 34, 'dGFpIHNhbw==', 'd6fbaf19e02c5b827cb152171363f7dfa366b814'),
(16, 42, '5ZCN5YmN44Gv77yf', '53e724ce781235a0d636c52b4977520b1cafd4b8'),
(17, 43, 'd3Rm', '53e724ce781235a0d636c52b4977520b1cafd4b8'),
(18, 44, 'd3Rm', 'c50b299acfd203ba5e9e11f0795f48eedc2119da'),
(19, 45, 'd3Rm', '63c738e723a742e459e385e9363cee696d26276b'),
(20, 50, 'd3Rm', '2e67c2e9a35bcd7bed66babaaae5fd972dd8ef18'),
(21, 51, 'd3Rm', '53e724ce781235a0d636c52b4977520b1cafd4b8'),
(22, 52, 'd3Rm', 'c50b299acfd203ba5e9e11f0795f48eedc2119da'),
(24, 58, 'MTIz', '6eb291bdbff8b679d1e98166314e350db399cc28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ip_addresses`
--

CREATE TABLE IF NOT EXISTS `tb_ip_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tb_ip_addresses`
--

INSERT INTO `tb_ip_addresses` (`id`, `admin_id`, `ip_address`) VALUES
(30, 17, '192.168.0.1'),
(31, 28, '192.168.1.0'),
(32, 37, '127.0.0.1'),
(33, 38, '127.0.0.1'),
(34, 39, '127.0.0.1'),
(41, 41, '127.0.0.1'),
(42, 40, '127.0.0.1'),
(43, 40, '192.168.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_learn_histories`
--

CREATE TABLE IF NOT EXISTS `tb_learn_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `learn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_learn_histories`
--

INSERT INTO `tb_learn_histories` (`id`, `bill_id`, `learn_date`) VALUES
(1, 2, '2014-02-25 17:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons`
--

CREATE TABLE IF NOT EXISTS `tb_lessons` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tb_lessons`
--

INSERT INTO `tb_lessons` (`id`, `lesson_name`, `description`, `create_user_id`, `create_date`, `viewers`, `voters`, `title_reporters`, `title_violation`, `lock_flag`, `delete_flag`) VALUES
(13, 'ỊTap', 'ỊTap', 51, '2014-04-25 11:39:45', NULL, '56,57', NULL, 0, 0, 0),
(14, 'Test T002', 'T002 Test files.', 58, '2014-04-25 11:26:35', NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_lesson_of_categories`
--

CREATE TABLE IF NOT EXISTS `tb_lesson_of_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tb_lesson_of_categories`
--

INSERT INTO `tb_lesson_of_categories` (`id`, `lesson_id`, `category_id`) VALUES
(26, 13, 1),
(27, 13, 3),
(28, 13, 19),
(29, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_locked_users`
--

CREATE TABLE IF NOT EXISTS `tb_locked_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `lock_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1 lock',
  `lock_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notifications`
--

CREATE TABLE IF NOT EXISTS `tb_notifications` (
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

--
-- Dumping data for table `tb_notifications`
--

INSERT INTO `tb_notifications` (`id`, `user_id`, `sender_id`, `type`, `message`, `target`, `is_read`, `created`, `modified`) VALUES
('535a4c1a-a140-4f01-a603-158800000000', '51', NULL, NULL, 'あなたのNTD02-1.mp3ファイルがブロックした', NULL, 0, '2014-04-25 18:50:50', '2014-04-25 18:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tests`
--

CREATE TABLE IF NOT EXISTS `tb_tests` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_tests`
--

INSERT INTO `tb_tests` (`id`, `lesson_id`, `file_name`, `description`, `create_user_id`, `create_date`, `file_link`, `answers`, `mark`) VALUES
(1, 1, 'test_toan_cap_cap.tsv', 'Test bài toán cao cấp, bài 1.', 2, '2014-02-25 17:13:43', 'https://google.com', 'https://google.com.vn', ''),
(2, 11, 'NTD08-1.tsv', '', 52, '2014-04-25 02:20:12', 'files\\52\\NTD08-1.tsv', '', ''),
(3, 12, 'NTD08-1.tsv', '', 51, '2014-04-25 02:25:57', 'files\\51\\NTD08-1.tsv', '', ''),
(4, 13, 'NTD08-1.tsv', '', 51, '2014-04-25 11:11:13', 'files\\51\\NTD08-1.tsv', '', ''),
(5, 14, 'NTD08-1.tsv', '', 58, '2014-04-25 11:26:35', 'files\\58\\NTD08-1.tsv', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_test_histories`
--

CREATE TABLE IF NOT EXISTS `tb_test_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `test_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `answers` varchar(255) NOT NULL,
  `score` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_test_histories`
--

INSERT INTO `tb_test_histories` (`id`, `user_id`, `test_id`, `test_date`, `answers`, `score`) VALUES
(1, 1, 1, '2014-02-25 17:14:16', 'https://google.com.vn/test1.tsv', 100),
(2, 52, 2, '2014-04-25 03:36:57', '-3-2-1-2', 0),
(3, 47, 2, '2014-04-25 04:00:02', '-1-4-2-3', 15),
(4, 56, 4, '2014-04-25 11:16:14', '-2-3-0-3', 0),
(5, 56, 4, '2014-04-25 11:18:27', '-1-2-3-1', 35),
(6, 57, 5, '2014-04-25 11:29:15', '-1-4-3-1', 40);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `user_name`, `real_name`, `reg_date`, `level`, `birth_date`, `email`, `phone_number`, `address`, `password`, `approve_flag`, `status_flag`, `bank_account_code`, `ip_address`, `online_flag`) VALUES
(41, 'A01', 'khanh', '2014-04-25 12:24:49', 1, '1910-07-02', 'A01@gmail.com', '1234567890', 'Ha Noi', '892d9aef7955a701c0f34e470c8b545746de2d69', 1, 1, 'khong xac dinh', '127.0.0.1', 0),
(51, 'T001', 'fsadfas', '2014-04-25 11:44:47', 2, '1910-07-16', 'T001@gmail.com', '45254252525', 'fsdfsaf', '1943adfbf87dda06b39e8e38f4b39252a3472551', 1, 1, '1111-111-1-1111111', '127.0.0.1', 0),
(56, 'S001', 'fasfasf', '2014-04-25 11:53:49', 3, '1917-11-18', 'tien@gmail.com', '534523525', 'fasfasfasfa', '00a215af27506f5939e1cdbd8b5f321851107a3c', 1, 1, '22222222-2222-2222-2222-2222', '127.0.0.1', 0),
(57, 'S002', 'iuyiwiw', '2014-04-25 11:54:40', 3, '1918-10-12', 'T003@gmail.com', '452352452', 'Ha noi', '89fb7b61ecf3806483a6e4494668e7707b988eec', 1, 1, '33333333-3333-3333-3333-3333', '127.0.0.1', 0),
(58, 'T002', 'T002', '2014-04-25 11:38:03', 2, '1904-02-07', 't002@gmail.com', '1234441234234', 'Home', '1267161fbf982005b197b4c0aa09ac9587f16ee5', 1, 1, '1111-111-1-1111111', '127.0.0.1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_verifycodes`
--

CREATE TABLE IF NOT EXISTS `tb_verifycodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `verifycode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tb_verifycodes`
--

INSERT INTO `tb_verifycodes` (`id`, `user_id`, `question`, `verifycode`) VALUES
(25, 58, 'MTIz', '6eb291bdbff8b679d1e98166314e350db399cc28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
