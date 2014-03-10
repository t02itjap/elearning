-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2014 at 02:56 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elearning`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_banned_students`
--

INSERT INTO `tb_banned_students` (`id`, `teacher_id`, `student_id`, `reason`, `banned_date`) VALUES
(1, 2, 3, 'Học rốt', '2014-02-25 17:08:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_bills`
--

INSERT INTO `tb_bills` (`id`, `user_id`, `lesson_id`, `learn_date`, `lesson_cost`) VALUES
(1, 3, 1, '2014-02-25 17:06:17', 1),
(2, 3, 1, '2014-02-25 17:11:27', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_categories`
--

CREATE TABLE IF NOT EXISTS `tb_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tb_categories`
--

INSERT INTO `tb_categories` (`id`, `category_name`) VALUES
(1, 'Math'),
(2, 'Physic'),
(3, 'Japanese');

-- --------------------------------------------------------

--
-- Table structure for table `tb_changeable_values`
--

CREATE TABLE IF NOT EXISTS `tb_changeable_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desciption` text NOT NULL,
  `current_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_changeable_values`
--

INSERT INTO `tb_changeable_values` (`id`, `desciption`, `current_value`) VALUES
(1, 'Session', 5),
(2, 'Fee of a Leason for Teacher', 40),
(3, 'Fee of System for a Leason', 60),
(4, 'Được nhập sai password bao lần?', 3),
(5, 'Lession cost', 20000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_comments`
--

INSERT INTO `tb_comments` (`id`, `user_id`, `lesson_id`, `comment`, `comment_date`) VALUES
(1, 1, 1, 'Bài này có gì đâu mà cũng comment.\r\nComment câu like.\r\nLike tao cho thằng giáo viên nó tức.\r\nCảm ơn đảng nhà nước đã cho em comment vào topic này. \r\nVui vcl.', '2014-02-25 17:09:51');

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
  `copyright_report` int(11) NOT NULL,
  `copyright_violation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not violation, 1: violation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_documents`
--

INSERT INTO `tb_documents` (`id`, `lesson_id`, `file_name`, `description`, `create_user_id`, `create_date`, `file_link`, `copyright_report`, `copyright_violation`) VALUES
(1, 1, 'toan_cao_cap.pdf', 'Bài giảng 1 toán cao cấp', 2, '2014-02-25 17:10:39', 'https://google.com', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_initial_users`
--

CREATE TABLE IF NOT EXISTS `tb_initial_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `initial_password` varchar(255) NOT NULL,
  `initial_question_type` int(11) NOT NULL,
  `initial_verifycode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ip_address`
--

CREATE TABLE IF NOT EXISTS `tb_ip_address` (
  `ip_address` varchar(255) NOT NULL COMMENT 'ip of admins'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_ip_address`
--

INSERT INTO `tb_ip_address` (`ip_address`) VALUES
('127.0.0.1'),
('192.168.0.1');

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
  `category_id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tag` text NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vote_total` int(11) NOT NULL DEFAULT '0',
  `title_report` int(11) NOT NULL DEFAULT '0',
  `title_violation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:violation, 0: not violation',
  `lock_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: locked, 0: not locked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_lessons`
--

INSERT INTO `tb_lessons` (`id`, `category_id`, `lesson_name`, `description`, `tag`, `create_user_id`, `create_date`, `vote_total`, `title_report`, `title_violation`, `lock_flag`) VALUES
(1, 1, 'Toán cao cấp', 'Toán cao cấp - Giải phương trình bậc 1', 'toán cao cấp', 2, '2014-02-25 17:05:44', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_locked_users`
--

CREATE TABLE IF NOT EXISTS `tb_locked_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `lock_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not lock, 1 lock',
  `lock_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_locked_users`
--

INSERT INTO `tb_locked_users` (`id`, `user_id`, `count`, `lock_flg`, `lock_start_time`) VALUES
(1, 7, 2, 0, '2014-02-25 17:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `tb_online_users`
--

CREATE TABLE IF NOT EXISTS `tb_online_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `online_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not online, 1:online',
  `online_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_online_users`
--

INSERT INTO `tb_online_users` (`id`, `user_id`, `online_flg`, `online_start_time`) VALUES
(1, 1, 1, '2014-02-25 17:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_question_types`
--

CREATE TABLE IF NOT EXISTS `tb_question_types` (
  `question_type` int(11) NOT NULL AUTO_INCREMENT,
  `question_content` text NOT NULL,
  PRIMARY KEY (`question_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_tests`
--

INSERT INTO `tb_tests` (`id`, `lesson_id`, `file_name`, `description`, `create_user_id`, `create_date`, `file_link`, `answers`) VALUES
(1, 1, 'test_toan_cap_cap.tsv', 'Test bài toán cao cấp, bài 1.', 2, '2014-02-25 17:13:43', 'https://google.com', 'https://google.com.vn');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_test_histories`
--

INSERT INTO `tb_test_histories` (`id`, `user_id`, `test_id`, `test_date`, `answers`, `score`) VALUES
(1, 1, 1, '2014-02-25 17:14:16', 'https://google.com.vn/test1.tsv', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user code',
  `user_name` varchar(255) NOT NULL COMMENT 'user name',
  `real_name` varchar(255) NOT NULL COMMENT 'real name',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'register day',
  `level` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1: admin, 2: teacher. 3: student',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `question_type` int(11) NOT NULL,
  `verifycode` varchar(255) NOT NULL,
  `approve_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not approve yet. 1: approved',
  `status_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: account was deleted, 1: account has existed',
  `bank_account_code` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `user_name`, `real_name`, `reg_date`, `level`, `email`, `phone_number`, `address`, `password`, `question_type`, `verifycode`, `approve_flag`, `status_flag`, `bank_account_code`, `ip_address`) VALUES
(1, 'phinm', 'Nguyễn Mạnh Phi', '2014-02-25 16:59:42', 1, 'phinm@t02.com', '12345678', 'Hoàng Mai, Hà Nội', '123456', 1, 'phi', 0, 1, '123456789', '127.0.0.1'),
(2, 'hoanln', 'Lê Ngọc Hoàn', '2014-02-25 16:59:47', 2, 'hoanln@t02.com', '123456', 'Hà Nội', '123456', 1, 'hoan', 0, 1, '123456789', '127.0.0.1'),
(3, 'thangvm', 'Vũ Mạnh Thắng', '2014-02-25 16:53:32', 3, 'thangvm@t02.com', '123456', 'Hà Nội', '123456', 1, 'thang', 0, 1, '1234567890', '127.0.0.1'),
(4, 'tiendq', 'Đinh Quang Tiến', '2014-02-25 16:54:24', 3, 'tiendq@t02.com', '123456', 'Hà Nội', '123456', 1, 'tien', 0, 1, '1234567890', '127.0.0.1'),
(5, 'huongcv', 'Chu Văn Hưởng', '2014-02-25 16:55:07', 3, 'huongcv@t02.com', '123456', 'Hà Nội', '123456', 1, 'huong', 0, 1, '1234567890', '127.0.0.1'),
(6, 'thinhnv', 'Nguyễn Vĩnh Thịnh', '2014-02-25 16:55:49', 3, 'thinhnv@t02.com', '123466', 'Hà Nội', '123456', 1, 'thinh', 0, 1, '1234567890', '127.0.0.1'),
(7, 'khanhnd', 'Nguyễn Đình Khánh', '2014-02-25 16:56:39', 3, 'khanhnd@t02.com', '123456', 'Hà Nội', '123456', 1, 'khanh', 0, 1, '1234567890', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_types`
--

CREATE TABLE IF NOT EXISTS `tb_user_types` (
  `level` tinyint(1) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user_types`
--

INSERT INTO `tb_user_types` (`level`, `user_type`) VALUES
(1, 'admin'),
(2, 'teacher'),
(3, 'student');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
