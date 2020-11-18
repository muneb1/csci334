-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2020 at 08:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csci334`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignhistory`
--

CREATE TABLE `assignhistory` (
  `rid` varchar(11) NOT NULL,
  `sid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignhistory`
--

INSERT INTO `assignhistory` (`rid`, `sid`) VALUES
('20201113127', 'vanessa'),
('20201113154', 'jakob'),
('20201113154', 'vanessa'),
('20201113221', 'weihan'),
('20201113444', 'vanessa'),
('20201113485', 'dexter'),
('20201113504', 'dexter'),
('20201113513', 'weihan'),
('20201113632', 'weihan'),
('20201113779', 'vanessa'),
('20201113812', 'vanessa'),
('20201113812', 'weihan'),
('20201113827', 'weihan'),
('20201113902', 'dexter'),
('20201113926', 'dexter'),
('2020111394', 'vanessa'),
('20201113953', 'weihan');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `cid` varchar(20) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `c_contact` varchar(15) NOT NULL,
  `c_company` varchar(100) NOT NULL,
  `active` int(1) NOT NULL COMMENT '0-Deactive\r\n1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`cid`, `c_name`, `c_contact`, `c_company`, `active`) VALUES
('alex', 'Alex Morgan', '0123456789', 'Apple Inc', 1),
('jackson', 'Jackson Robinson', '0147283821', 'Samsung Group', 1),
('james', 'James William', '0129876534', 'Addidas', 1),
('leong', 'Ms Leong', '01489723', 'Inti College', 0);

-- --------------------------------------------------------

--
-- Table structure for table `credential`
--

CREATE TABLE `credential` (
  `uid` varchar(20) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_pass` varchar(64) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_group` int(1) NOT NULL COMMENT '0-staff, 1-client',
  `status` int(1) NOT NULL COMMENT '0-Deactive, 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `credential`
--

INSERT INTO `credential` (`uid`, `u_email`, `u_pass`, `last_login`, `user_group`, `status`) VALUES
('alex', 'alex@apple.inc', 'D9508122CD143D69DF229BF3624B7BCB2B8AC81ED210A0C926455EF119C12ABD', '2020-11-03 12:31:26', 1, 1),
('aman', 'aman@adtech.com.my', '45F30B0DA9CE2AF048BEA1987ECC2ABD35FBEE2C972F696C65E04E648239C0D8', '2020-11-01 08:15:03', 0, 1),
('brandon', 'brandon@adtech.com.my', '660D20373E8ECD7A1E43B9BFE05D98ACEB85F95DE49640B5333948B3140F43B6', '2020-11-01 08:15:05', 0, 1),
('dexter', 'dexter@adtech.com.my', 'C1359035F4C6451634CBE5791BA82D75153B155618C5B9FB5C8C37111BDB6F87', '2020-11-01 08:15:09', 0, 1),
('jackson', 'jackson@samsung.com', 'FE8863AECBEDEDB0027001E36FEDBD8461BB11B5D9D5012B2F15C75D9310ACF4', '2020-11-03 12:31:38', 1, 1),
('jakob', 'jakob@adtech.com.my', 'a34df53307a3cad62bf634deebb56478e453f41ca7150d8fe087997e53d8bd0e', '2020-11-13 03:37:25', 0, 1),
('james', 'james@addidas.com', 'EBA2346346BCE6E941A9FF0A0C96E0E9D4282B658BD72CA2BC93D81021DE08D0', '2020-11-03 12:31:30', 1, 1),
('leong', 'leong@inti.edu.my', '8d2f439d211e0ae66d519cd2aa7382fb58d6cb745e543edee535518a8df9ccd8', '2020-11-13 03:39:33', 1, 0),
('muneeb', 'muneeb@adtech.com.my', '1CDE8416005CF477EA141B6ACCD673E62C4DEB9126CC69181D2B86491A44A7DB', '2020-11-01 08:15:16', 0, 1),
('vanessa', 'vanessa@adtech.com.my', '0e8341968360719c3a3b5080047219e2c69f1586780e4920a55e3f5307d5881e', '2020-11-05 20:25:17', 0, 1),
('weihan', 'weihan@adtech.com.my', '4F6038E198AFE2467D1B865A2D004FC31731C35FF412E5E772E62CEDC9400020', '2020-11-01 08:15:18', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `nid` varchar(30) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `pos` int(1) DEFAULT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-unread, 1-read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`nid`, `uid`, `pos`, `created_time`, `title`, `content`, `status`) VALUES
('20201113127assign', 'vanessa', NULL, '2020-11-13 02:45:50', 'New Request', 'Request (20201113127) assigned to you', 1),
('20201113127complete', NULL, 2, '2020-11-13 03:06:26', 'Request Completed', 'Request (20201113127) completed by Vanessa', 1),
('20201113127create', NULL, 2, '2020-11-13 02:43:49', 'New Request', 'Addidas submit a new request', 1),
('20201113127review', NULL, 1, '2020-11-13 03:07:03', 'New Review', 'Customer has left a review', 1),
('20201113154assign', 'vanessa', NULL, '2020-11-13 02:50:48', 'New Request', 'Request (20201113154) assigned to you', 0),
('20201113154create', NULL, 2, '2020-11-13 02:48:50', 'New Request', 'Apple Inc submit a new request', 1),
('20201113154Vanessa', NULL, 2, '2020-11-13 11:43:09', 'Request Overdue', 'Request (20201113154) that assigned to Vanessa is overdued, reassign if necessary', 1),
('20201113221assign', 'weihan', NULL, '2020-11-13 02:45:55', 'New Request', 'Request (20201113221) assigned to you', 0),
('20201113221complete', NULL, 2, '2020-11-13 03:10:20', 'Request Completed', 'Request (20201113221) completed by Wei Han', 1),
('20201113221create', NULL, 2, '2020-11-13 02:43:33', 'New Request', 'Addidas submit a new request', 1),
('20201113221review', NULL, 1, '2020-11-13 03:11:04', 'New Review', 'Customer has left a review', 1),
('20201113444assign', 'vanessa', NULL, '2020-11-13 02:45:41', 'New Request', 'Request (20201113444) assigned to you', 1),
('20201113444complete', NULL, 2, '2020-11-13 02:58:54', 'Request Completed', 'Request (20201113444) completed by Vanessa', 1),
('20201113444create', NULL, 2, '2020-11-13 02:42:36', 'New Request', 'Samsung Group submit a new request', 1),
('20201113444review', NULL, 1, '2020-11-13 02:59:18', 'New Review', 'Customer has left a review', 1),
('20201113485assign', 'dexter', NULL, '2020-11-13 02:46:02', 'New Request', 'Request (20201113485) assigned to you', 1),
('20201113485create', NULL, 2, '2020-11-13 02:41:50', 'New Request', 'Apple Inc submit a new request', 1),
('20201113504assign', 'dexter', NULL, '2020-11-13 02:50:44', 'New Request', 'Request (20201113504) assigned to you', 0),
('20201113504complete', NULL, 2, '2020-11-13 03:13:14', 'Request Completed', 'Request (20201113504) completed by Dexter', 1),
('20201113504create', NULL, 2, '2020-11-13 02:48:01', 'New Request', 'Addidas submit a new request', 1),
('20201113504review', NULL, 1, '2020-11-13 03:13:31', 'New Review', 'Customer has left a review', 1),
('20201113513assign', 'weihan', NULL, '2020-11-13 11:25:03', 'New Request', 'Request (20201113513) assigned to you', 1),
('20201113513complete', NULL, 2, '2020-11-13 11:30:17', 'Request Completed', 'Request (20201113513) completed by Wei Han', 0),
('20201113513create', NULL, 2, '2020-11-13 11:23:11', 'New Request', 'Apple Inc submit a new request', 1),
('20201113513review', NULL, 1, '2020-11-13 11:31:21', 'New Review', 'Customer has left a review', 0),
('20201113632assign', 'weihan', NULL, '2020-11-13 02:46:08', 'New Request', 'Request (20201113632) assigned to you', 0),
('20201113632complete', NULL, 2, '2020-11-13 03:17:33', 'Request Completed', 'Request (20201113632) completed by Wei Han', 1),
('20201113632create', NULL, 2, '2020-11-13 02:42:05', 'New Request', 'Apple Inc submit a new request', 1),
('20201113632review', NULL, 1, '2020-11-13 03:17:50', 'New Review', 'Customer has left a review', 1),
('20201113779assign', 'vanessa', NULL, '2020-11-13 02:50:40', 'New Request', 'Request (20201113779) assigned to you', 1),
('20201113779create', NULL, 2, '2020-11-13 02:47:14', 'New Request', 'Addidas submit a new request', 1),
('20201113779Vanessa', NULL, 2, '2020-11-13 03:30:48', 'Request Overdue', 'Request (20201113779) that assigned to Vanessa is overdued, reassign if necessary', 1),
('20201113812assign', 'weihan', NULL, '2020-11-13 02:50:55', 'New Request', 'Request (20201113812) assigned to you', 0),
('20201113812create', NULL, 2, '2020-11-13 02:50:27', 'New Request', 'Samsung Group submit a new request', 1),
('20201113812WeiHan', NULL, 2, '2020-11-13 03:31:29', 'Request Overdue', 'Request (20201113812) that assigned to Wei Han is overdued, reassign if necessary', 1),
('20201113827assign', 'weihan', NULL, '2020-11-13 02:50:51', 'New Request', 'Request (20201113827) assigned to you', 0),
('20201113827create', NULL, 2, '2020-11-13 02:49:52', 'New Request', 'Samsung Group submit a new request', 1),
('20201113902assign', 'dexter', NULL, '2020-11-13 02:45:59', 'New Request', 'Request (20201113902) assigned to you', 1),
('20201113902complete', NULL, 2, '2020-11-13 02:54:11', 'Request Completed', 'Request (20201113902) completed by Dexter', 1),
('20201113902create', NULL, 2, '2020-11-13 02:42:50', 'New Request', 'Samsung Group submit a new request', 1),
('20201113902review', NULL, 1, '2020-11-13 02:54:26', 'New Review', 'Customer has left a review', 1),
('20201113926assign', 'dexter', NULL, '2020-11-13 02:45:45', 'New Request', 'Request (20201113926) assigned to you', 1),
('20201113926create', NULL, 2, '2020-11-13 02:43:21', 'New Request', 'Addidas submit a new request', 1),
('2020111394assign', 'vanessa', NULL, '2020-11-13 03:32:50', 'New Request', 'Request (2020111394) assigned to you', 0),
('2020111394create', NULL, 2, '2020-11-13 03:32:41', 'New Request', 'Apple Inc submit a new request', 1),
('20201113953assign', 'weihan', NULL, '2020-11-13 02:45:35', 'New Request', 'Request (20201113953) assigned to you', 0),
('20201113953create', NULL, 2, '2020-11-13 02:41:37', 'New Request', 'Apple Inc submit a new request', 1);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `request_id` varchar(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`request_id`, `content`, `created_by`, `created_time`) VALUES
('20201113127', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:43:49'),
('20201113127', 'Vanessa had assigned to help you', NULL, '2020-11-12 18:45:50'),
('20201113127', 'What is your hardware issue?', 'vanessa', '2020-11-12 19:03:24'),
('20201113127', 'My thermal printer not working', 'james', '2020-11-12 19:03:34'),
('20201113127', 'please check if the LED light on?', 'vanessa', '2020-11-12 19:03:45'),
('20201113127', 'no, no light on', 'james', '2020-11-12 19:03:52'),
('20201113127', 'check you power cable', 'vanessa', '2020-11-12 19:04:00'),
('20201113127', 'my power cable is connected', 'james', '2020-11-12 19:04:10'),
('20201113127', 'two possibility, first is the adapter broken, secondly, the printer broken', 'vanessa', '2020-11-12 19:04:41'),
('20201113127', 'Let me arrange a technician to visit your store by tomorrow', 'vanessa', '2020-11-12 19:05:00'),
('20201113127', 'ok thanks', 'james', '2020-11-12 19:05:05'),
('20201113127', 'no worry, tomorrow the technician will call you', 'vanessa', '2020-11-12 19:06:11'),
('20201113127', 'ok, thanks', 'james', '2020-11-12 19:06:25'),
('20201113154', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:48:50'),
('20201113154', 'Vanessa had assigned to help you', NULL, '2020-11-12 18:50:48'),
('20201113154', 'Jakob had assigned to help you', NULL, '2020-11-13 03:43:36'),
('20201113221', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:43:33'),
('20201113221', 'Wei Han had assigned to help you', NULL, '2020-11-12 18:45:55'),
('20201113221', 'hi, please check your notification setting, did you able the notification?', 'weihan', '2020-11-12 19:09:55'),
('20201113221', 'oh, ya thanks, I got it! ', 'james', '2020-11-12 19:10:12'),
('20201113221', 'don\'t worry', 'weihan', '2020-11-12 19:10:17'),
('20201113444', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:42:36'),
('20201113444', 'Vanessa had assigned to help you', NULL, '2020-11-12 18:45:41'),
('20201113444', 'Let me check for you', 'vanessa', '2020-11-12 18:55:03'),
('20201113444', 'ok, please check', 'jackson', '2020-11-12 18:55:14'),
('20201113444', 'we don\'t get your payment', 'vanessa', '2020-11-12 18:55:24'),
('20201113444', 'what?! I have paid@', 'jackson', '2020-11-12 18:55:33'),
('20201113444', 'paid!**', 'jackson', '2020-11-12 18:55:46'),
('20201113444', 'Let me check again', 'vanessa', '2020-11-12 18:55:56'),
('20201113444', 'We really don\'t receive the payment from you, please check with your back, sorry', 'vanessa', '2020-11-12 18:56:24'),
('20201113444', 'I have the receipt! I can prove', 'jackson', '2020-11-12 18:56:41'),
('20201113444', 'but the transaction might failed for some reason, kindly check with your bank', 'vanessa', '2020-11-12 18:57:05'),
('20201113444', 'Bad service, is ok, I don\'t need your help, never user your service again!!!!', 'jackson', '2020-11-12 18:57:32'),
('20201113444', 'Sorry to cause inconvenience, but we can\'t help', 'vanessa', '2020-11-12 18:58:30'),
('20201113444', 'Hi, sir are you still there?', 'vanessa', '2020-11-12 18:58:40'),
('20201113444', 'If not I will closed this request, thanks you', 'vanessa', '2020-11-12 18:58:53'),
('20201113485', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:41:50'),
('20201113485', 'Dexter had assigned to help you', NULL, '2020-11-12 18:46:02'),
('20201113504', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:48:01'),
('20201113504', 'Dexter had assigned to help you', NULL, '2020-11-12 18:50:44'),
('20201113504', 'Let me check your payment gateway', 'dexter', '2020-11-12 19:12:03'),
('20201113504', 'sure', 'james', '2020-11-12 19:12:08'),
('20201113504', 'Your back is rejecting your payment, please contact to your bank', 'dexter', '2020-11-12 19:12:31'),
('20201113504', 'oh, ok, let me check with the bank', 'james', '2020-11-12 19:12:43'),
('20201113504', 'ok, I will close this request, create another new request if you get feedback from bank', 'dexter', '2020-11-12 19:13:11'),
('20201113504', 'ok', 'james', '2020-11-12 19:13:13'),
('20201113513', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-13 03:23:11'),
('20201113513', 'Wei Han had assigned to help you', NULL, '2020-11-13 03:25:03'),
('20201113513', 'What can I help you?', 'weihan', '2020-11-13 03:29:07'),
('20201113513', 'please help me to solve the problem', 'alex', '2020-11-13 03:29:21'),
('20201113513', 'hold on, let me check', 'weihan', '2020-11-13 03:29:29'),
('20201113513', 'sure', 'alex', '2020-11-13 03:29:34'),
('20201113632', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:42:05'),
('20201113632', 'Wei Han had assigned to help you', NULL, '2020-11-12 18:46:08'),
('20201113632', 'you can simply click on the password reset button', 'weihan', '2020-11-12 19:15:33'),
('20201113632', 'I don\'t where is it', 'alex', '2020-11-12 19:15:44'),
('20201113632', 'just at the above of login button', 'weihan', '2020-11-12 19:15:59'),
('20201113632', 'can\'t you help me to reset?', 'alex', '2020-11-12 19:16:08'),
('20201113632', 'sorry, I don\'t have the permission to do so', 'weihan', '2020-11-12 19:16:22'),
('20201113632', 'ahhhhh, is ok, I will try to do it myself', 'alex', '2020-11-12 19:16:38'),
('20201113632', 'I will be here, and guide you', 'weihan', '2020-11-12 19:16:57'),
('20201113632', 'is ok, thanks', 'alex', '2020-11-12 19:17:03'),
('20201113632', 'ok, you can contact us anytime if you can\'t reset the password', 'weihan', '2020-11-12 19:17:26'),
('20201113779', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:47:14'),
('20201113779', 'Vanessa had assigned to help you', NULL, '2020-11-12 18:50:40'),
('20201113812', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:50:27'),
('20201113812', 'Wei Han had assigned to help you', NULL, '2020-11-12 18:50:55'),
('20201113812', 'Vanessa had assigned to help you', NULL, '2020-11-12 19:31:35'),
('20201113827', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:49:52'),
('20201113827', 'Wei Han had assigned to help you', NULL, '2020-11-12 18:50:51'),
('20201113902', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:42:50'),
('20201113902', 'Dexter had assigned to help you', NULL, '2020-11-12 18:45:59'),
('20201113902', 'Let me help you to fixed from remote desktop', 'dexter', '2020-11-12 18:53:18'),
('20201113902', 'ok', 'jackson', '2020-11-12 18:53:21'),
('20201113902', 'Give me 5 mins', 'dexter', '2020-11-12 18:53:29'),
('20201113902', 'Take your time', 'jackson', '2020-11-12 18:53:37'),
('20201113902', 'completed', 'dexter', '2020-11-12 18:53:43'),
('20201113902', 'thanks, now I can login', 'jackson', '2020-11-12 18:53:51'),
('20201113902', 'ok, that for choosing us, bye', 'dexter', '2020-11-12 18:54:02'),
('20201113902', 'thanks, bye', 'jackson', '2020-11-12 18:54:09'),
('20201113926', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:43:21'),
('20201113926', 'Dexter had assigned to help you', NULL, '2020-11-12 18:45:45'),
('2020111394', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 19:32:41'),
('2020111394', 'Vanessa had assigned to help you', NULL, '2020-11-12 19:32:50'),
('20201113953', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-12 18:41:37'),
('20201113953', 'Wei Han had assigned to help you', NULL, '2020-11-12 18:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `rid` varchar(11) NOT NULL,
  `r_title` varchar(100) NOT NULL,
  `r_content` varchar(255) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `assigned_time` timestamp NULL DEFAULT NULL,
  `assigned_to` varchar(20) DEFAULT NULL,
  `completed_time` datetime DEFAULT NULL,
  `review` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `reviewed_time` timestamp NULL DEFAULT NULL,
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL COMMENT '0-Deleted 1-New 2-Assigned 3-Ongoing 4-Pending 5-Completed 6-Reviewed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`rid`, `r_title`, `r_content`, `created_by`, `created_time`, `assigned_time`, `assigned_to`, `completed_time`, `review`, `comment`, `reviewed_time`, `updated_time`, `status`) VALUES
('20201113127', 'Hardware Issue', 'Hi, having problem with my hardware', 'james', '2020-11-12 18:43:49', '2020-11-12 18:45:50', 'vanessa', '2020-11-13 03:06:26', 4, 'Quick respond, good attitude', '2020-11-12 19:07:03', '2020-11-13 03:07:03', 6),
('20201113154', 'Need a CDN service', 'I need a cdn service for my web app', 'alex', '2020-11-12 18:48:50', '2020-11-13 03:43:36', 'jakob', NULL, NULL, NULL, NULL, '2020-11-13 11:46:08', 4),
('20201113221', 'Notification not working', 'I can\'t receive notification', 'james', '2020-11-12 18:43:33', '2020-11-12 18:45:55', 'weihan', '2020-11-13 03:10:20', 4, 'Good attitude', '2020-11-12 19:11:04', '2020-11-13 03:13:45', 6),
('20201113444', 'I paid the subscription fees but get nothing', 'Please check what happen\n', 'jackson', '2020-11-12 18:42:36', '2020-11-12 18:45:41', 'vanessa', '2020-11-13 02:58:54', 1, 'Bad service, give me my money!!!!', '2020-11-12 18:59:18', '2020-11-13 02:59:18', 6),
('20201113485', 'Client cannot login', 'My website client login not working', 'alex', '2020-11-12 18:41:50', '2020-11-12 18:46:02', 'dexter', NULL, NULL, NULL, NULL, '2020-11-13 02:46:02', 2),
('20201113504', 'Payment gateway problem', 'Customer unable to pay', 'james', '2020-11-12 18:48:01', '2020-11-12 18:50:44', 'dexter', '2020-11-13 03:13:18', 3, 'Thank for service', '2020-11-12 19:13:31', '2020-11-13 03:13:31', 6),
('20201113513', 'My website DNS not working', 'I updated my DNS record, its not working', 'alex', '2020-11-13 03:23:11', '2020-11-05 03:25:03', 'weihan', '2020-11-13 11:30:17', 5, 'Good service, ', '2020-11-13 03:31:21', '2020-11-13 11:43:03', 6),
('20201113632', 'Forget Password', 'I need to reset my password', 'alex', '2020-11-12 18:42:05', '2020-11-12 18:46:08', 'weihan', '2020-11-13 03:17:33', 2, 'Can\'t even help to reset the password', '2020-11-12 19:17:50', '2020-11-13 03:17:50', 6),
('20201113779', 'Email hosting problem', 'I cant send the email', 'james', '2020-11-12 18:47:14', '2020-11-12 18:50:14', 'vanessa', NULL, NULL, NULL, NULL, '2020-11-13 03:31:15', 4),
('20201113812', 'Need website design', 'I need you to help me with design my company website', 'jackson', '2020-11-12 18:50:27', '2020-11-12 19:31:35', 'vanessa', NULL, NULL, NULL, NULL, '2020-11-13 03:31:35', 2),
('20201113827', 'Need a new website', 'I want to redesign my website, please advise', 'jackson', '2020-11-12 18:49:52', '2020-11-12 18:50:51', 'weihan', NULL, NULL, NULL, NULL, '2020-11-13 02:50:51', 2),
('20201113902', 'Software Issue', 'I can\'t login to my outlet pos system', 'jackson', '2020-11-12 18:42:50', '2020-11-12 18:45:59', 'dexter', '2020-11-13 02:54:11', 5, 'Quick respond and good services', '2020-11-12 18:54:26', '2020-11-13 02:54:26', 6),
('20201113926', 'Hardware problem', 'My computer back screen', 'james', '2020-11-12 18:43:21', '2020-11-12 18:45:45', 'dexter', NULL, NULL, NULL, NULL, '2020-11-13 02:45:45', 2),
('2020111394', 'Website chart not showing', 'please help', 'alex', '2020-11-12 19:32:41', '2020-11-12 19:32:50', 'vanessa', NULL, NULL, NULL, NULL, '2020-11-13 03:32:50', 2),
('20201113953', 'Not receive notification email', 'I can\'t receive notification email when I register', 'alex', '2020-11-12 18:41:37', '2020-11-12 18:45:35', 'weihan', NULL, NULL, NULL, NULL, '2020-11-13 03:09:33', 4);

--
-- Triggers `request`
--
DELIMITER $$
CREATE TRIGGER `new_request` AFTER INSERT ON `request` FOR EACH ROW INSERT INTO `replies`(`request_id`, `content`, `created_by`, `created_time`) VALUES (NEW.rid,"We have received you request, an IT technician will be assigned to help you soon.",NULL,CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `service_session`
--

CREATE TABLE `service_session` (
  `session_id` int(11) NOT NULL,
  `requestID` varchar(11) DEFAULT NULL,
  `staff_id` varchar(20) NOT NULL,
  `startTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `endTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_session`
--

INSERT INTO `service_session` (`session_id`, `requestID`, `staff_id`, `startTime`, `endTime`) VALUES
(136, '20201113812', 'weihan', '2020-11-12 18:51:56', NULL),
(137, '20201113812', 'weihan', '2020-11-12 18:51:56', '2020-11-12 18:52:11'),
(138, '20201113902', 'dexter', '2020-11-12 18:52:55', NULL),
(139, '20201113902', 'dexter', '2020-11-12 18:52:55', '2020-11-12 18:54:11'),
(140, '20201113444', 'vanessa', '2020-11-12 18:54:55', NULL),
(141, '20201113444', 'vanessa', '2020-11-12 18:54:55', '2020-11-12 18:58:54'),
(142, '20201113127', 'vanessa', '2020-11-12 19:00:23', NULL),
(143, '20201113127', 'vanessa', '2020-11-12 19:00:23', '2020-11-12 19:01:11'),
(144, '20201113154', 'vanessa', '2020-11-12 19:01:15', NULL),
(145, '20201113154', 'vanessa', '2020-11-12 19:01:15', '2020-11-12 19:01:18'),
(146, '20201113127', 'vanessa', '2020-11-12 18:23:02', '2020-11-12 19:06:26'),
(147, '20201113779', 'vanessa', '2020-11-12 18:07:27', NULL),
(148, '20201113779', 'vanessa', '2020-11-12 19:07:27', '2020-11-12 19:07:28'),
(149, '20201113953', 'weihan', '2020-11-12 19:09:30', NULL),
(150, '20201113953', 'weihan', '2020-11-12 18:49:31', '2020-11-12 19:09:33'),
(151, '20201113221', 'weihan', '2020-11-12 19:09:35', NULL),
(152, '20201113221', 'weihan', '2020-11-12 18:09:35', '2020-11-12 19:10:20'),
(153, '20201113504', 'dexter', '2020-11-12 19:11:48', NULL),
(154, '20201113504', 'dexter', '2020-11-12 18:11:48', '2020-11-12 19:13:15'),
(155, '20201113504', 'dexter', '2020-11-12 18:33:15', '2020-11-12 19:13:18'),
(156, '20201113632', 'weihan', '2020-11-12 19:14:43', NULL),
(157, '20201113632', 'weihan', '2020-11-12 19:14:44', '2020-11-12 19:17:33'),
(158, '20201113513', 'weihan', '2020-11-13 03:27:07', NULL),
(159, '20201113513', 'weihan', '2020-11-13 03:27:07', '2020-11-13 03:28:55'),
(160, '20201113513', 'weihan', '2020-11-13 03:28:56', '2020-11-13 03:30:17'),
(161, '20201113154', 'jakob', '2020-11-13 03:45:51', NULL),
(162, '20201113154', 'jakob', '2020-11-13 03:45:51', '2020-11-13 03:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `sid` varchar(20) NOT NULL,
  `s_fname` varchar(30) NOT NULL,
  `s_lname` varchar(30) NOT NULL,
  `s_contact` varchar(15) NOT NULL,
  `position` int(1) NOT NULL COMMENT '1-CEO, 2-Manager, 3-IT Technician, 4-User',
  `active` int(1) NOT NULL COMMENT '0-Deactive 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`sid`, `s_fname`, `s_lname`, `s_contact`, `position`, `active`) VALUES
('aman', 'Amandeep', 'Singh', '0126804436', 2, 1),
('brandon', 'Brandon', 'Khoo', '0178833878', 2, 1),
('dexter', 'Dexter', 'Sia', '0108342880', 3, 1),
('jakob', 'Jakob', 'Harward', '01927342231', 3, 1),
('muneeb', 'Muneeb', '', '0169734283', 1, 1),
('vanessa', 'Vanessa', 'Frey', '0134652468', 3, 1),
('weihan', 'Wei Han', 'Soong', '0165673963', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignhistory`
--
ALTER TABLE `assignhistory`
  ADD PRIMARY KEY (`rid`,`sid`) USING BTREE,
  ADD KEY `sid_assHis_FK` (`sid`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `credential`
--
ALTER TABLE `credential`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `uid_noti_FK` (`uid`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`request_id`,`created_time`),
  ADD KEY `replies_uid_FK` (`created_by`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `technician_FK` (`assigned_to`),
  ADD KEY `client_FK` (`created_by`);

--
-- Indexes for table `service_session`
--
ALTER TABLE `service_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `sid_sess_FK` (`staff_id`),
  ADD KEY `rid_sess_FK` (`requestID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `service_session`
--
ALTER TABLE `service_session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignhistory`
--
ALTER TABLE `assignhistory`
  ADD CONSTRAINT `rid_assHis_FK` FOREIGN KEY (`rid`) REFERENCES `request` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sid_assHis_FK` FOREIGN KEY (`sid`) REFERENCES `staff` (`sid`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_credential_FK` FOREIGN KEY (`cid`) REFERENCES `credential` (`uid`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `uid_FK` FOREIGN KEY (`uid`) REFERENCES `credential` (`uid`),
  ADD CONSTRAINT `uid_noti_FK` FOREIGN KEY (`uid`) REFERENCES `credential` (`uid`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_uid_FK` FOREIGN KEY (`created_by`) REFERENCES `credential` (`uid`),
  ADD CONSTRAINT `rid_reply_FK` FOREIGN KEY (`request_id`) REFERENCES `request` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `client_FK` FOREIGN KEY (`created_by`) REFERENCES `client` (`cid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `technician_FK` FOREIGN KEY (`assigned_to`) REFERENCES `staff` (`sid`) ON UPDATE CASCADE;

--
-- Constraints for table `service_session`
--
ALTER TABLE `service_session`
  ADD CONSTRAINT `rid_sess_FK` FOREIGN KEY (`requestID`) REFERENCES `request` (`rid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sid_sess_FK` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`sid`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_credential_FK` FOREIGN KEY (`sid`) REFERENCES `credential` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
