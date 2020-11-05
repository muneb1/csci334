-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2020 at 10:53 PM
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
('20201031441', 'dexter'),
('20201031441', 'weihan'),
('20201031877', 'dexter'),
('20201103008', 'weihan'),
('20201104626', 'dexter'),
('20201106127', 'vanessa'),
('20201106520', 'vanessa'),
('20201106768', 'vanessa');

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
('james', 'James William', '0129876534', 'Addidas', 1);

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
('james', 'james@addidas.com', 'EBA2346346BCE6E941A9FF0A0C96E0E9D4282B658BD72CA2BC93D81021DE08D0', '2020-11-03 12:31:30', 1, 1),
('muneeb', 'muneeb@adtech.com.my', '1CDE8416005CF477EA141B6ACCD673E62C4DEB9126CC69181D2B86491A44A7DB', '2020-11-01 08:15:16', 0, 1),
('vanessa', 'vanessa@adtech.com.my', '0e8341968360719c3a3b5080047219e2c69f1586780e4920a55e3f5307d5881e', '2020-11-05 20:25:17', 0, 1),
('weihan', 'weihan@adtech.com.my', '4F6038E198AFE2467D1B865A2D004FC31731C35FF412E5E772E62CEDC9400020', '2020-11-01 08:15:18', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `uid` varchar(20) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `content` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-unread, 1-read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('20201031441', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-03 16:04:39'),
('20201031441', 'Aman had assigned to help you\r\n', NULL, '2020-11-03 16:15:42'),
('20201031441', 'Updated', NULL, '2020-11-05 10:25:03'),
('20201031877', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-03 16:04:39'),
('20201031877', 'Dexter had assigned to help you', NULL, '2020-11-04 18:01:27'),
('20201031877', 'Test', 'dexter', '2020-11-04 18:45:27'),
('20201031877', 'Hello', 'dexter', '2020-11-04 18:47:17'),
('20201031877', 'Anyone?', 'dexter', '2020-11-04 18:47:43'),
('20201031877', 'Anyone?', 'dexter', '2020-11-04 18:47:57'),
('20201031877', 'test', 'dexter', '2020-11-04 18:48:15'),
('20201031877', 'Hello', 'alex', '2020-11-04 19:09:59'),
('20201031877', 'add', 'dexter', '2020-11-04 19:25:37'),
('20201031877', 'add', 'dexter', '2020-11-04 19:26:11'),
('20201031877', 'add', 'dexter', '2020-11-04 19:26:41'),
('20201031877', 'test', 'dexter', '2020-11-04 19:28:22'),
('20201031877', 'bottom', 'dexter', '2020-11-04 19:35:43'),
('20201103008', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-03 12:40:01'),
('20201104626', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-03 16:52:18'),
('20201104626', 'Dexter had assigned to help you', NULL, '2020-11-05 13:38:04'),
('20201104626', 'Reply', 'dexter', '2020-11-05 18:57:53'),
('20201104949', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-03 16:50:42'),
('20201106127', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-05 20:53:10'),
('20201106127', 'Vanessa had assigned to help you', NULL, '2020-11-05 20:53:28'),
('20201106127', 'Hi what can I help you', 'vanessa', '2020-11-05 20:54:37'),
('20201106127', 'My screen black out, how to solve this?', 'james', '2020-11-05 20:55:18'),
('20201106127', 'Hi don\'t worry, I\'m here to help you', 'vanessa', '2020-11-05 20:58:22'),
('20201106520', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-05 21:44:25'),
('20201106520', 'Vanessa had assigned to help you', NULL, '2020-11-05 21:44:48'),
('20201106520', 'Hi again\n', 'vanessa', '2020-11-05 21:45:47'),
('20201106520', 'Bye', 'james', '2020-11-05 21:45:58'),
('20201106768', 'We have received you request, an IT technician will be assigned to help you soon.', NULL, '2020-11-05 21:39:15'),
('20201106768', 'Vanessa had assigned to help you', NULL, '2020-11-05 21:39:47'),
('20201106768', 'Hello', 'vanessa', '2020-11-05 21:39:57'),
('20201106768', 'Hello', 'james', '2020-11-05 21:40:10');

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
('20201031441', 'tes', 'test', 'alex', '2020-10-31 08:50:19', '2020-11-03 16:14:40', 'dexter', '2020-11-06 03:35:26', NULL, NULL, NULL, '2020-11-06 03:35:26', 5),
('20201031877', 'tes', 'test', 'alex', '2020-10-31 08:50:27', '2020-11-04 18:02:05', 'dexter', '2020-11-06 03:38:43', NULL, NULL, NULL, '2020-11-06 03:38:43', 5),
('20201103008', 'Hardware', 'Description', 'alex', '2020-11-03 12:40:01', '2020-11-03 16:45:43', 'weihan', '2020-11-04 00:45:50', NULL, NULL, NULL, '0000-00-00 00:00:00', 4),
('20201104626', 'Testing 2', 'Testing 2', 'alex', '2020-11-03 16:52:18', '2020-11-05 13:38:04', 'dexter', '2020-11-06 03:36:16', NULL, NULL, NULL, '2020-11-06 03:36:16', 5),
('20201104949', 'Testing', 'Testing', 'alex', '2020-11-03 16:50:42', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 1),
('20201106127', 'Hardware problem', 'My computer back screen', 'james', '2020-11-05 20:53:10', '2020-11-05 20:53:28', 'vanessa', '2020-11-06 05:02:04', 4, 'Good Service', '2020-11-05 21:27:32', '2020-11-06 05:27:32', 6),
('20201106520', 'Have Request Again', 'Why you closed the ticket?', 'james', '2020-11-05 21:44:25', '2020-11-05 21:44:48', 'vanessa', '2020-11-06 05:46:01', 1, 'Again', '2020-11-05 21:48:08', '2020-11-06 05:48:08', 6),
('20201106768', 'Another New Request', 'I Have Problem', 'james', '2020-11-05 21:39:15', '2020-11-05 21:39:47', 'vanessa', '2020-11-06 05:40:15', 3, 'No Good', '2020-11-05 21:40:27', '2020-11-06 05:40:27', 6);

--
-- Triggers `request`
--
DELIMITER $$
CREATE TRIGGER `assigned_request` AFTER UPDATE ON `request` FOR EACH ROW IF OLD.assigned_to <> NEW.assigned_to THEN
INSERT INTO `replies`(`request_id`, `content`, `created_by`, `created_time`) VALUES (OLD.rid,"Updated",NULL,CURRENT_TIMESTAMP);
END IF
$$
DELIMITER ;
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
  `requestID` varchar(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `startTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `endTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_session`
--

INSERT INTO `service_session` (`session_id`, `requestID`, `staff_id`, `startTime`, `endTime`) VALUES
(2, '20201104626', 'dexter', '2020-11-06 00:00:00', '2020-11-06 02:00:00'),
(3, '20201031441', 'dexter', '2020-11-06 08:00:00', '2020-11-06 12:00:00'),
(4, '20201031877', 'dexter', '2020-11-06 00:00:00', '2020-11-06 11:00:00'),
(5, '20201031877', 'dexter', '2020-11-06 00:00:00', '2020-11-07 11:00:00'),
(9, '20201031441', 'dexter', '2020-11-06 01:00:00', '2020-11-06 02:00:00'),
(12, '20201104626', 'dexter', '2020-11-06 01:00:00', '2020-11-06 02:00:00'),
(53, '20201106127', 'vanessa', '2020-11-05 20:54:28', '2020-11-05 20:58:06'),
(54, '20201106127', 'vanessa', '2020-11-05 20:58:06', '2020-11-05 20:59:01'),
(55, '20201106127', 'vanessa', '2020-11-05 21:00:08', '2020-11-05 21:00:11'),
(56, '20201106127', 'vanessa', '2020-11-05 21:01:30', '2020-11-05 21:02:04'),
(57, '20201106768', 'vanessa', '2020-11-05 21:39:52', NULL),
(58, '20201106768', 'vanessa', '2020-11-05 21:39:52', '2020-11-05 21:40:14'),
(59, '20201106768', 'vanessa', '2020-11-05 21:40:14', '2020-11-05 21:40:15'),
(60, '20201106520', 'vanessa', '2020-11-05 21:45:41', NULL),
(61, '20201106520', 'vanessa', '2020-11-05 21:45:41', '2020-11-05 21:46:00'),
(62, '20201106520', 'vanessa', '2020-11-05 21:46:00', '2020-11-05 21:46:01');

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
  ADD PRIMARY KEY (`uid`,`created_time`) USING BTREE;

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
  ADD KEY `client_FK` (`created_by`),
  ADD KEY `technician_FK` (`assigned_to`);

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
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignhistory`
--
ALTER TABLE `assignhistory`
  ADD CONSTRAINT `rid_assHis_FK` FOREIGN KEY (`rid`) REFERENCES `request` (`rid`),
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
  ADD CONSTRAINT `uid_FK` FOREIGN KEY (`uid`) REFERENCES `credential` (`uid`);

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
