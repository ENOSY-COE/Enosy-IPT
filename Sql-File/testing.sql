-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2024 at 07:21 PM
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
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `role_as` enum('0','1','2','3') NOT NULL,
  `user_session_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`user_id`, `user_fullname`, `user_name`, `user_email`, `user_password`, `role_as`, `user_session_id`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', 'admin', '1', 'h88qn6oqpldk9fbvfovasnq0ho'),
(2, 'peter parker', 'peterparker', 'peterparker@gmail.com', 'password', '0', 'huo6t9e5tgamujk6u2ra5pf4ef'),
(3, 'Manager Manager', 'manager', 'manager@gmail.com', 'manager@manager', '2', 'o53pkii2429kihnh7ip6mqcv2j'),
(4, 'Supervisor Supervisor', 'supervisor', 'supervisor@gmail.com', 'supervisor@supervisor', '3', 'qwe34rt56yu67io89'),
(8, 'robby john', 'johnrobby', 'robby@gmail.com', 'qwerty', '2', '2v0m07pmgj0uumqhncri55gckc'),
(9, 'stellah', 'lyandostellah', 'stellah@gmail.com', 'stellah@gmail.com', '3', '1nccmbg61bh9eqigm1v56vauvb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
