-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2020 at 09:01 AM
-- Server version: 10.2.32-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cycaminf_dbtrial`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `id` int(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_priority` varchar(100) NOT NULL,
  `synopsis` varchar(255) NOT NULL,
  `status` int(6) NOT NULL,
  `post_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todo_list`
--

INSERT INTO `todo_list` (`id`, `event_type`, `event_name`, `event_venue`, `event_date`, `event_time`, `event_priority`, `synopsis`, `status`, `post_time`) VALUES
(14, 'Academic', 'register for a new semister', 'rongo university', '2020-01-26', '8:00-am', 'High', 'register for 4.2', 1, '2020-02-17 08:59:43.431908'),
(15, 'Academic', 'read confrencing', 'library', '2020-01-25', '8:00- pm', 'High', 'i want to read about video confre.', 1, '2020-02-17 08:59:48.600572'),
(16, 'Work', 'seee dallo', 'playstation', '2020-02-17', '15:00-pm', 'High', 'hhhhu', 1, '2020-02-17 05:13:34.818730');

-- --------------------------------------------------------

--
-- Table structure for table `uses`
--

CREATE TABLE `uses` (
  `id` int(255) NOT NULL,
  `img` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `security_answer` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uses`
--

INSERT INTO `uses` (`id`, `img`, `user_name`, `first_name`, `last_name`, `email`, `password`, `security_answer`, `reg_date`) VALUES
(1, 'cara3.jpg', 'mwalimu_jr!', 'mwalimu', 'kasia', 'jose@gmail.com', '22', '', '2020-01-12 13:57:16'),
(8, 'handphone.jpg', 'hermans', 'jose', 'matheka', 'mathekajosef571@gmail.com', 'jose', '', '2020-01-12 14:06:57'),
(9, 'pexels-photo-209680.jpg', 'mwangi', 'DAVID', 'MUCHIRI', 'davislanking@gmail.com', '1234', '', '2020-01-15 09:12:00'),
(10, 'Screenshot (3).png', 'celeb!', 'caleb', 'mulatya', 'mulatyacaleb@gmail.com', '1234', 'musyoka', '2020-01-19 20:31:19'),
(11, '1.jpg', 'asher', 'Daniel', 'kasia', 'jose@gmail.com', '22', 'musyoka', '2020-01-22 08:26:52'),
(12, 'course2.jpg', 'muli!', 'cyrus', 'mulatya', 'mulatyacyrus@gmail.com', 'mulatya', 'mutomo', '2020-01-24 12:06:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uses`
--
ALTER TABLE `uses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `uses`
--
ALTER TABLE `uses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
