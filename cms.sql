-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2020 at 08:47 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `propic` varchar(255) NOT NULL,
  `type` text NOT NULL DEFAULT 'Admin',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `phone`, `admin_id`, `username`, `password`, `propic`, `type`, `status`) VALUES
(5, '', '', '', '', 'admin@123', 'admin', '123456', '', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(100) NOT NULL,
  `appointment_date` varchar(20) NOT NULL,
  `type` text NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `doctor_id` varchar(100) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `dept_id` varchar(100) NOT NULL,
  `doctor_type` text NOT NULL,
  `issue` text NOT NULL,
  `cost_bdt` float NOT NULL,
  `cost_usd` float NOT NULL,
  `month` text NOT NULL,
  `year` int(4) NOT NULL,
  `cancelled_cause` text NOT NULL,
  `request_date` varchar(20) NOT NULL,
  `request_time` varchar(50) NOT NULL,
  `request_status` int(1) NOT NULL DEFAULT 0,
  `is_complete` int(1) NOT NULL DEFAULT 0,
  `is_cancelled` int(1) NOT NULL DEFAULT 0,
  `is_visited` int(1) NOT NULL DEFAULT 0,
  `is_rated` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `appointment_id`, `appointment_date`, `type`, `schedule`, `doctor_id`, `client_id`, `dept_id`, `doctor_type`, `issue`, `cost_bdt`, `cost_usd`, `month`, `year`, `cancelled_cause`, `request_date`, `request_time`, `request_status`, `is_complete`, `is_cancelled`, `is_visited`, `is_rated`, `status`, `created_at`, `updated_at`) VALUES
(150, 'appointment@2020-04-27?18:47:10', '28/04/2020', 'Physical', 'Saturday [ 10:00ap-12:00pm ]', 'doctor@123', 'client@2019-12-27?18:17:25', 'dept@123', 'Neurologist', 'sddad asd sda as sa', 1000, 0, 'April', 2020, '', '27-04-2020', 'Monday ,April 27, 2020, 6:47 pm', 0, 1, 0, 0, 0, 1, '2020-04-27 12:47:10', '2020-04-27 16:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `message_id` varchar(100) NOT NULL,
  `message_from` varchar(100) NOT NULL,
  `message_to` varchar(100) NOT NULL,
  `message_body` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` text NOT NULL,
  `message_date` varchar(20) NOT NULL,
  `message_time` varchar(100) NOT NULL,
  `is_seen` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `room_link` varchar(255) NOT NULL,
  `doctor_id` varchar(100) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `date` varchar(20) NOT NULL,
  `is_joined` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `gender` text NOT NULL,
  `address` text NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `propic` varchar(1000) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `birthday`, `gender`, `address`, `country`, `city`, `state`, `postal_code`, `propic`, `phone`, `email`, `username`, `client_id`, `password`, `created_at`, `status`) VALUES
(15, 'Tahasin', 'Islam', '04/03/1999', 'Male', 'assadsasa', 'Afghanistan', 'dsadada', 'asdadas', 'dasdsad', '../gallery/propic/clients/6bccf833ddbd37fe0f87f28901a7be4a-3.png', '015214930744', 'tahasinislam39@gmail.com', 'tahasin@39', 'client@2019-12-27?18:17:25', '123456', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dept_id` varchar(100) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `picture` varchar(1000) NOT NULL,
  `created_on` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept_id`, `dept_name`, `picture`, `created_on`, `description`, `status`) VALUES
(26, 'dept@123', 'Neurology', '', '03/12/2019', 'sdad ad ada sad sa dsa sadsads', 1),
(27, 'dept@1234', 'Physiology', '', '02/01/2020', 'dasdsadsad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `category` text NOT NULL,
  `department_id` varchar(100) NOT NULL,
  `position` text NOT NULL,
  `joining_date` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `gender` text NOT NULL,
  `religion` text NOT NULL,
  `marital_status` text NOT NULL,
  `age` int(11) NOT NULL,
  `nationality` text NOT NULL,
  `interest` text NOT NULL,
  `hobby` text NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `smoking` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `biography` text NOT NULL,
  `propic` varchar(255) NOT NULL,
  `edu_institution` varchar(100) NOT NULL,
  `edu_subject` varchar(100) NOT NULL,
  `pass_year` varchar(20) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `last_company` varchar(100) NOT NULL,
  `last_clocation` varchar(100) NOT NULL,
  `last_cposition` varchar(30) NOT NULL,
  `last_cjoining` varchar(20) NOT NULL,
  `last_cleft` varchar(20) NOT NULL,
  `experience` text NOT NULL,
  `certificate` varchar(1000) NOT NULL,
  `cost_bdt` float NOT NULL,
  `cost_usd` float NOT NULL,
  `profile_status` int(1) NOT NULL DEFAULT 0,
  `doctor_status` int(1) NOT NULL DEFAULT 0,
  `is_certified` int(1) NOT NULL DEFAULT 0,
  `mail_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `first_name`, `last_name`, `username`, `user_id`, `password`, `email`, `category`, `department_id`, `position`, `joining_date`, `birthday`, `gender`, `religion`, `marital_status`, `age`, `nationality`, `interest`, `hobby`, `blood_group`, `smoking`, `address`, `country`, `city`, `state`, `postal_code`, `phone`, `biography`, `propic`, `edu_institution`, `edu_subject`, `pass_year`, `degree`, `grade`, `last_company`, `last_clocation`, `last_cposition`, `last_cjoining`, `last_cleft`, `experience`, `certificate`, `cost_bdt`, `cost_usd`, `profile_status`, `doctor_status`, `is_certified`, `mail_status`) VALUES
(63, 'Tahasin', 'Islam', 'doctor', 'doctor@123', '123456', 'tahasinislam9@gmail.com', 'Neurologist', 'dept@123', 'xxxxxxxx', '15/03/2020', '01/03/1994', 'Male', 'Islam', 'Married', 18, 'xxx', 'xxxx', 'xxx', 'A+', 'Non-smoker', 'xxxx', 'Afghanistan', 'xxx', 'xxxx', 'xxxx', 'xxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx    xxxxxxxxxxx xxx  xxxxxxxxx', '../gallery/propic/doctors/62576730_2316606328594159_9097507887101509632_n.jpg', 'xxxx', 'xxxx', '01/03/2020', 'xxxxxxxx', 'x', 'xxxxxxxx', 'xxxxx', 'xxxxxxxx', '01/03/2020', '07/03/2020', 'xxxxxx', '../gallery/certificates/CV [ Tahasin Islam ].pdf', 1000, 16, 1, 1, 1, 1),
(64, 'Alamin', 'Akondo', 'alamin', 'doctor@1234', '123456', 'ghostcorp.x@gmail.com', 'Neurologist', 'dept@123', 'Head of Department, Sexologist ', '16/03/2020', '16/03/1994', 'Male', 'Islam', 'Married', 18, 'ccxzc', 'zxcz', 'zcz', 'A+', 'Non-smoker', 'zxczx', 'Afghanistan', 'zxczxczx', 'czxczx', '1234', 'zxczxczxczx', 'I am xxxxxx.', '../gallery/propic/doctors/800b600.gif', 'zxcxzc', 'zxczxc', '16/03/2020', 'dsfsdf', 'fsdf', '', '', '', '', '', '', '../gallery/certificates/Job Application [ Tahasin Islam ].pdf', 5000, 20, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_id` varchar(100) NOT NULL,
  `event_title` text NOT NULL,
  `event_description` text NOT NULL,
  `event_link` varchar(1000) NOT NULL,
  `event_banner` varchar(1000) NOT NULL,
  `event_file` varchar(1000) NOT NULL,
  `month` text NOT NULL,
  `date` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_id`, `event_title`, `event_description`, `event_link`, `event_banner`, `event_file`, `month`, `date`, `year`, `created_at`, `updated_at`, `status`) VALUES
(25, 'event?27-12-2019@05:24:45', 'Blood Donation Camp , 2020', '<p><strong>X</strong>&nbsp;are an American&nbsp;<a href=\"https://en.wikipedia.org/wiki/Punk_rock\">punk rock</a>&nbsp;band, formed in&nbsp;<a href=\"https://en.wikipedia.org/wiki/Los_Angeles\">Los Angeles</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/California\">California</a>, United States, in 1977.<a href=\"https://en.wikipedia.org/wiki/X_(American_band)#cite_note-RollingStone-2\">[2]</a>&nbsp;The original members are vocalist&nbsp;<a href=\"https://en.wikipedia.org/wiki/Exene_Cervenka\">Exene Cervenka</a>, vocalist-bassist&nbsp;<a href=\"https://en.wikipedia.org/wiki/John_Doe_(musician)\">John Doe</a>, guitarist&nbsp;<a href=\"https://en.wikipedia.org/wiki/Billy_Zoom\">Billy Zoom</a>&nbsp;and drummer&nbsp;<a href=\"https://en.wikipedia.org/wiki/D._J._Bonebrake\">D. J. Bonebrake</a>. The band released seven studio albums from 1980 to 1993. After a period of inactivity during the mid- to late 1990s, X reunited in the early 2000s, and currently tours, as of 2019.<a href=\"https://en.wikipedia.org/wiki/X_(American_band)#cite_note-RollingStone-2\">[2]</a><a href=\"https://en.wikipedia.org/wiki/X_(American_band)#cite_note-Xshows-3\">[3]</a></p>\r\n', 'asdsadas', '../gallery/events/banner/185325-full_45-linux-dragon-wallpapers-download-at-wallpaperbro.jpg', '../gallery/events/files/154371.pdf', 'October', 15, 2036, '2019-12-27 17:24:45', '2019-12-27 11:59:55', 1),
(26, 'event?16-03-2020@05:10:32', 'Blood Donation Camp', '<p>Think a bit about it: what exactly do you want to compute? Start with an item without any ratings. Add a rating, let&#39;s say 3 stars. What is average now? Why? Add another rating, let&#39;s say 4 stars. What is the average rating now and why? Iterate a couple of times more and find the formula yourself, it&#39;s not that difficult.</p>\r\n', '', '../gallery/events/banner/be-happy-smiley.jpg', '../gallery/events/files/', 'January', 25, 2432, '2020-03-16 17:10:32', '2020-03-16 12:34:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `request_id` varchar(100) NOT NULL,
  `item_name` text NOT NULL,
  `unit_price` int(11) NOT NULL,
  `delivery_cost` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab-requests`
--

CREATE TABLE `lab-requests` (
  `id` int(11) NOT NULL,
  `request_id` varchar(100) NOT NULL,
  `requested_by` varchar(100) NOT NULL,
  `request_for` text NOT NULL,
  `prescription_image` varchar(255) NOT NULL,
  `requested_on` varchar(100) NOT NULL,
  `delivered_on` varchar(100) NOT NULL,
  `received_on` varchar(100) NOT NULL,
  `month` text NOT NULL,
  `year` int(4) NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT 1,
  `is_processing` tinyint(1) NOT NULL DEFAULT 0,
  `is_delivered` tinyint(1) NOT NULL DEFAULT 0,
  `is_received` tinyint(1) NOT NULL DEFAULT 0,
  `is_feedbacked` tinyint(1) NOT NULL DEFAULT 0,
  `is_agreed` tinyint(1) NOT NULL DEFAULT 0,
  `is_cancelled` tinyint(1) NOT NULL DEFAULT 0,
  `total_cost` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification_id` varchar(100) NOT NULL,
  `notification_to` varchar(100) NOT NULL,
  `notification_from` varchar(100) NOT NULL,
  `notification_type` text NOT NULL,
  `notification_about` text NOT NULL,
  `notification_time` varchar(50) NOT NULL,
  `is_seen` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_id`, `notification_to`, `notification_from`, `notification_type`, `notification_about`, `notification_time`, `is_seen`, `created_at`, `updated_at`) VALUES
(208, 'notification@16-03-2020?18:28:07', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Monday ,March 16, 2020, 6:28 pm', 1, '2020-03-16 18:28:07', '2020-03-16 12:28:07'),
(209, 'notification@16-03-2020?18:28:35', 'doctor@123', 'client@2019-12-27?18:17:25', 'Message', 'Sent you a new message.', 'Monday ,March 16, 2020, 6:28 pm', 1, '2020-03-16 18:28:35', '2020-03-16 12:28:35'),
(210, 'notification@16-03-2020?18:28:52', 'client@2019-12-27?18:17:25', 'doctor@123', 'message', 'sent you a new message.', 'Monday ,March 16, 2020, 6:28 pm', 1, '2020-03-16 18:28:52', '2020-03-16 12:28:52'),
(211, 'notification@16-03-2020?18:40:19', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Monday ,March 16, 2020, 6:40 pm', 1, '2020-03-16 18:40:19', '2020-03-16 12:40:52'),
(212, 'notification@16-03-2020?18:40:43', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Monday ,March 16, 2020, 6:40 pm', 1, '2020-03-16 18:40:43', '2020-03-16 12:40:52'),
(213, 'notification@2020-04-24?05:34:37', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Friday ,April 24, 2020, 5:34 am', 1, '2020-04-24 05:34:37', '2020-04-23 23:40:43'),
(214, 'notification@2020-04-24?06:19:10', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Friday ,April 24, 2020, 6:19 am', 1, '2020-04-24 06:19:11', '2020-04-24 00:19:19'),
(215, 'notification@2020-04-24?06:19:10', 'doctor@123', 'admin', 'appointment', 'You have got a new appoinment.', 'Friday ,April 24, 2020, 6:19 am', 1, '2020-04-24 06:19:11', '2020-04-26 16:02:40'),
(216, 'notification@24-04-2020?16:33:53', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Friday ,April 24, 2020, 4:33 pm', 1, '2020-04-24 16:33:53', '2020-04-26 22:06:25'),
(217, 'notification@24-04-2020?16:33:58', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Friday ,April 24, 2020, 4:33 pm', 1, '2020-04-24 16:33:58', '2020-04-26 22:06:25'),
(218, 'notification@2020-04-27?03:29:56', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Monday ,April 27, 2020, 3:29 am', 1, '2020-04-27 03:29:56', '2020-04-26 21:58:41'),
(219, 'notification@2020-04-27?03:31:22', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Monday ,April 27, 2020, 3:31 am', 1, '2020-04-27 03:31:22', '2020-04-26 21:58:41'),
(220, 'notification@2020-04-27?03:58:51', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 3:58 am', 1, '2020-04-27 03:58:51', '2020-04-26 21:59:33'),
(221, 'notification@2020-04-27?03:58:51', 'doctor@123', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 3:58 am', 1, '2020-04-27 03:58:51', '2020-04-27 01:23:49'),
(222, 'notification@27-04-2020?04:00:42', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Monday ,April 27, 2020, 4:00 am', 1, '2020-04-27 04:00:42', '2020-04-26 22:06:25'),
(223, 'notification@27-04-2020?04:11:33', 'client@2019-12-27?18:17:25', 'doctor@123', 'message', 'sent you a new message.', 'Monday ,April 27, 2020, 4:11 am', 1, '2020-04-27 04:11:33', '2020-04-26 23:36:19'),
(224, 'notification@27-04-2020?04:25:12', 'client@2019-12-27?18:17:25', 'doctor@123', 'message', 'sent you a new message.', 'Monday ,April 27, 2020, 4:25 am', 1, '2020-04-27 04:25:12', '2020-04-26 23:36:19'),
(225, 'notification@27-04-2020?04:28:29', 'client@2019-12-27?18:17:25', 'doctor@123', 'message', 'sent you a new message.', 'Monday ,April 27, 2020, 4:28 am', 1, '2020-04-27 04:28:29', '2020-04-26 23:36:19'),
(226, 'notification@27-04-2020?06:45:27', 'doctor@123', 'client@2019-12-27?18:17:25', 'message', 'sent you a new message.', 'Monday ,April 27, 2020, 6:45 am', 1, '2020-04-27 06:45:27', '2020-04-27 00:45:27'),
(227, 'notification@27-04-2020?06:51:09', 'doctor@123', 'client@2019-12-27?18:17:25', 'Message', 'Sent you a new message.', 'Monday ,April 27, 2020, 6:51 am', 1, '2020-04-27 06:51:09', '2020-04-27 00:53:16'),
(228, 'notification@27-04-2020?06:51:32', 'doctor@123', 'client@2019-12-27?18:17:25', 'Message', 'Sent you a new message.', 'Monday ,April 27, 2020, 6:51 am', 1, '2020-04-27 06:51:32', '2020-04-27 00:53:16'),
(229, 'notification@2020-04-27?16:36:47', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Monday ,April 27, 2020, 4:36 pm', 1, '2020-04-27 16:36:47', '2020-04-27 10:37:01'),
(230, 'notification@2020-04-27?16:37:14', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 4:37 pm', 1, '2020-04-27 16:37:14', '2020-04-27 10:37:14'),
(231, 'notification@2020-04-27?16:37:14', 'doctor@123', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 4:37 pm', 1, '2020-04-27 16:37:14', '2020-04-27 14:20:46'),
(232, 'notification@2020-04-27?17:04:45', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Monday ,April 27, 2020, 5:04 pm', 1, '2020-04-27 17:04:46', '2020-04-27 11:04:56'),
(233, 'notification@2020-04-27?17:17:30', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:17 pm', 1, '2020-04-27 17:17:30', '2020-04-27 11:17:31'),
(234, 'notification@2020-04-27?17:17:30', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:17 pm', 0, '2020-04-27 17:17:31', '2020-04-27 11:17:31'),
(235, 'notification@2020-04-27?17:21:51', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:21 pm', 1, '2020-04-27 17:21:51', '2020-04-27 11:21:51'),
(236, 'notification@2020-04-27?17:21:51', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:21 pm', 0, '2020-04-27 17:21:51', '2020-04-27 11:21:51'),
(237, 'notification@2020-04-27?17:28:50', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:28 pm', 1, '2020-04-27 17:28:50', '2020-04-27 11:28:50'),
(238, 'notification@2020-04-27?17:28:50', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:28 pm', 0, '2020-04-27 17:28:50', '2020-04-27 11:28:50'),
(239, 'notification@2020-04-27?17:45:15', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:45 pm', 1, '2020-04-27 17:45:15', '2020-04-27 12:47:19'),
(240, 'notification@2020-04-27?17:45:15', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:45 pm', 0, '2020-04-27 17:45:15', '2020-04-27 11:45:15'),
(241, 'notification@2020-04-27?17:47:10', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:47 pm', 1, '2020-04-27 17:47:10', '2020-04-27 12:47:19'),
(242, 'notification@2020-04-27?17:47:10', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:47 pm', 0, '2020-04-27 17:47:10', '2020-04-27 11:47:10'),
(243, 'notification@2020-04-27?17:57:46', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:57 pm', 1, '2020-04-27 17:57:47', '2020-04-27 12:47:19'),
(244, 'notification@2020-04-27?17:57:46', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:57 pm', 0, '2020-04-27 17:57:47', '2020-04-27 11:57:47'),
(245, 'notification@2020-04-27?17:59:56', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 5:59 pm', 1, '2020-04-27 17:59:56', '2020-04-27 12:47:19'),
(246, 'notification@2020-04-27?17:59:56', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 5:59 pm', 0, '2020-04-27 17:59:56', '2020-04-27 11:59:56'),
(247, 'notification@2020-04-27?18:01:52', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 6:01 pm', 1, '2020-04-27 18:01:52', '2020-04-27 12:47:19'),
(248, 'notification@2020-04-27?18:01:52', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 6:01 pm', 0, '2020-04-27 18:01:52', '2020-04-27 12:01:52'),
(249, 'notification@2020-04-27?18:06:01', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 6:06 pm', 1, '2020-04-27 18:06:01', '2020-04-27 12:47:19'),
(250, 'notification@2020-04-27?18:06:01', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 6:06 pm', 0, '2020-04-27 18:06:01', '2020-04-27 12:06:01'),
(251, 'notification@2020-04-27?18:10:56', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 6:10 pm', 1, '2020-04-27 18:10:56', '2020-04-27 12:47:19'),
(252, 'notification@2020-04-27?18:10:56', 'doctor@1234', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 6:10 pm', 0, '2020-04-27 18:10:56', '2020-04-27 12:10:56'),
(253, 'notification@2020-04-27?18:47:17', 'admin', 'client@2019-12-27?18:17:25', 'appointment', 'sent an appointment request.', 'Monday ,April 27, 2020, 6:47 pm', 1, '2020-04-27 18:47:17', '2020-04-27 12:50:40'),
(254, 'notification@2020-04-27?18:52:13', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 6:52 pm', 1, '2020-04-27 18:52:13', '2020-04-27 12:52:13'),
(255, 'notification@2020-04-27?18:52:13', 'doctor@123', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 6:52 pm', 1, '2020-04-27 18:52:13', '2020-04-27 14:20:46'),
(256, 'notification@2020-04-27?19:02:02', 'client@2019-12-27?18:17:25', 'admin', 'appointment', 'accepted your appointment request.', 'Monday ,April 27, 2020, 7:02 pm', 1, '2020-04-27 19:02:02', '2020-04-27 13:02:02'),
(257, 'notification@2020-04-27?19:02:02', 'doctor@123', 'admin', 'appointment', 'You have got a new appoinment.', 'Monday ,April 27, 2020, 7:02 pm', 1, '2020-04-27 19:02:02', '2020-04-27 14:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(100) NOT NULL,
  `doctor_id` varchar(100) NOT NULL,
  `rated_by` varchar(100) NOT NULL,
  `rating_point` int(1) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `doctor_id` varchar(100) NOT NULL,
  `day_1` text NOT NULL,
  `day1_time` varchar(20) NOT NULL,
  `day1_status` int(1) NOT NULL DEFAULT 0,
  `day_2` text NOT NULL,
  `day2_time` varchar(20) NOT NULL,
  `day2_status` int(1) NOT NULL DEFAULT 0,
  `day_3` text NOT NULL,
  `day3_time` varchar(20) NOT NULL,
  `day3_status` int(1) NOT NULL DEFAULT 0,
  `day_4` text NOT NULL,
  `day4_time` varchar(20) NOT NULL,
  `day4_status` int(1) NOT NULL DEFAULT 0,
  `day_5` text NOT NULL,
  `day5_time` varchar(20) NOT NULL,
  `day5_status` int(1) NOT NULL DEFAULT 0,
  `day_6` text NOT NULL,
  `day6_time` varchar(20) NOT NULL,
  `day6_status` int(1) NOT NULL DEFAULT 0,
  `day_7` text NOT NULL,
  `day7_time` varchar(20) NOT NULL,
  `day7_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `doctor_id`, `day_1`, `day1_time`, `day1_status`, `day_2`, `day2_time`, `day2_status`, `day_3`, `day3_time`, `day3_status`, `day_4`, `day4_time`, `day4_status`, `day_5`, `day5_time`, `day5_status`, `day_6`, `day6_time`, `day6_status`, `day_7`, `day7_time`, `day7_status`) VALUES
(38, 'doctor@123', 'Saturday', '10:00ap-12:00pm', 1, 'Sunday', '', 0, 'Monday', '10:00ap-12:00pm', 1, 'Tuesday', '', 0, 'Wednesday', '10:00ap-12:00pm', 1, 'Thursday', '', 0, 'Friday', '10:00ap-12:00pm', 1),
(39, 'doctor@1234', 'Saturday', '10:00am-02:00pm', 1, 'Sunday', '', 0, 'Monday', '10:00am-02:00pm', 1, 'Tuesday', '10:00am-02:00pm', 1, 'Wednesday', '10:00am-02:00pm', 1, 'Thursday', '', 0, 'Friday', '10:00am-02:00pm', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id` (`client_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_id` (`dept_id`),
  ADD UNIQUE KEY `dept_name` (`dept_name`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab-requests`
--
ALTER TABLE `lab-requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=609;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `lab-requests`
--
ALTER TABLE `lab-requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
