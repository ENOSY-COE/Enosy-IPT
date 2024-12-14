-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 10:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `co_id` int(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_phone` int(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_location` varchar(255) NOT NULL,
  `user_id` int(222) NOT NULL,
  `user_name` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`co_id`, `company_name`, `company_email`, `company_phone`, `company_address`, `company_location`, `user_id`, `user_name`, `date`) VALUES
(1, 'MIHTECH', 'enosymihambo@mihtech.com', 682321042, 'dsm', 'KINYEREZI', 10, 'MIHAMBO', '2024-08-19 10:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d-id` int(255) NOT NULL,
  `company_name` text NOT NULL,
  `department_name` text NOT NULL,
  `supervisor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d-id`, `company_name`, `department_name`, `supervisor`) VALUES
(1, 'MIHTECH', 'SOFTWARE DEVELOPMENT', 'MIHAMBO'),
(7, 'MIHTECH', 'ACCOUTANT', 'JOHN'),
(8, 'MIHTECH', 'IT SECURITY', 'SUZUGUYE');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `job_location` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `date_posted` date NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`job_id`, `job_title`, `job_description`, `job_location`, `company_id`, `job_type`, `department`, `date_posted`, `image_path`) VALUES
(1, 'IPT REQUEST POSITION', 'STUDENT TO PERFORM INDUSTRIAL PRACTICAL TRAINING', 'DSM', 1, 'IPT', 'SOFTWARE DEVELOPMENT', '2024-08-26', '66c34782ab6f92.90235797.jpeg'),
(2, 'IPT REQUEST POSITION', 'STUDENT TO PERFORM INDUSTRIAL PRACTICAL TRAINING', 'DSM', 1, 'IPT', 'SOFTWARE DEVELOPMENT', '2024-08-26', '66c347c1aabcf8.57427165.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `university_name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `level` enum('Degree','Diploma') NOT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `job_id` int(11) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `first_name`, `last_name`, `phone`, `email`, `university_name`, `course`, `level`, `pdf_path`, `job_id`, `date_submitted`) VALUES
(7, 'Robethinho', 'Lyando', '0789052127', 'lyandorobetho@gmail.com', 'NIT', 'basic mathe', 'Degree', '66c8666d7576b_kazi ipo.pdf', 2, '2024-08-23 10:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `company` varchar(255) NOT NULL,
  `department` text NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `role_as` enum('0','1','2','3') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_session_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`user_id`, `user_fullname`, `user_name`, `user_email`, `company`, `department`, `user_password`, `role_as`, `date`, `user_session_id`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', 'derrsd', '', 'admin', '1', '2024-08-18 07:35:15', 'hk8ne4gnk84q0cl0q3ljck9qjr'),
(2, 'peter parker', 'peterparker', 'peterparker@gmail.com', 'rrrr', '', 'password', '0', '2024-08-18 07:35:15', 'gatc0fcuqauuc6kq592o2s3to0'),
(3, 'Manager Manager', 'manager', 'manager@gmail.com', 'tttt', '', 'manager@manager', '2', '2024-08-18 07:35:15', 'o53pkii2429kihnh7ip6mqcv2j'),
(4, 'Supervisor Supervisor', 'supervisor', 'supervisor@gmail.com', 'COMPUTER CENTER', '', 'supervisor@supervisor', '3', '2024-08-18 07:35:15', 'qwe34rt56yu67io89'),
(8, 'robby john', 'johnrobby', 'robby@gmail.com', 'MIHTECH', '', 'qwerty', '2', '2024-08-18 07:35:15', '2v0m07pmgj0uumqhncri55gckc'),
(9, 'stellah', 'lyandostellah', 'stellah@gmail.com', 'KIMARA HEALTH CENTER', '', 'stellah@gmail.com', '3', '2024-08-18 07:35:15', '1nccmbg61bh9eqigm1v56vauvb'),
(10, 'MIHAMBO, Enosy John', 'MIHAMBO', 'enosymihambo@gmail.com', 'CCTZ', '', 'qwerty', '2', '2024-08-18 07:35:15', 'eebc2g5ka02qncurna110kh01p'),
(12, 'TATU M WARYOBA', 'WARYOBA', 'tatuwaryoba@gmail.com', 'KIMARA-HC', '', 'QWERTY', '2', '2024-08-18 07:35:15', '19aec0c4b68b21d32a905d23ae1e8d44'),
(13, 'LAURIAN SUZUGUYE', 'SUZUGUYE', 'suzuguye@mihtech.com', 'MIHTECH', '', '$2y$10$blZwZbXe1GKK/X7O6U6EfuihOd1PoEznJfmaE3RKRSCa22D4FOCs.', '', '2024-08-19 10:43:35', 'f9cc25236215ee1e689c16336b6f25c0'),
(15, 'Robethinho john Lyando', 'robby', 'lyandorobetho@gmail.com', 'MIHTECH', '', '$2y$10$MK2XAvxHkjUGQFS3j9e5.eHewe4GBAsVW919RbxgxdOtM0hfOQLfW', '3', '2024-08-23 12:40:27', 'd7pkpg6mr9g9sl34qcs1m0afg7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`co_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`d-id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `unique_request` (`first_name`,`last_name`,`email`,`job_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `co_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d-id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`co_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
