-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2019 at 07:10 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `besthealth`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(155) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `status`, `created`) VALUES
(1, 'admin', 'admin@besthealth.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2019-06-17 15:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `idnumber` varchar(13) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`idnumber`, `app_date`, `app_time`, `status`, `created`, `modified`) VALUES
('9902024455081', '2019-07-01', '00:00:00', 0, '2019-06-24 14:03:08', '2019-07-08 16:13:59'),
('6005150205088', '2019-07-04', '10:00:00', 2, '2019-07-01 17:09:02', '2019-07-08 16:14:18'),
('9902024455081', '2019-07-02', '10:00:00', 2, '2019-07-01 17:09:53', '2019-07-08 16:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(155) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `username`, `email`, `password`, `created`) VALUES
(1, 'Doctor', 'doctor@besthealth.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2019-06-19 08:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invid` varchar(50) NOT NULL,
  `idnumber` varchar(13) NOT NULL,
  `description` text NOT NULL,
  `quantity` tinyint(2) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_type` varchar(10) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invid`, `idnumber`, `description`, `quantity`, `amount`, `status`, `payment_type`, `created`, `modified`) VALUES
('665759', '9902024455081', 'Consultation Fee MutliVitamin-B ', 2, '770.50', 0, 'EFT', '2019-06-25 22:43:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `sent_from` varchar(50) NOT NULL,
  `sent_to` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `sent_from`, `sent_to`, `status`, `created`, `modified`) VALUES
('admin_dec5a9bf9ba3aa4a', 'Your appointment has been successfully set onTue, 25 June 2019 at 10:00 AM', 'Admin@besthealth.com', '9902024455081', 1, '2019-06-24 14:03:09', '2019-06-24 17:15:06'),
('admin_e78f4caecb997d0c', 'You received Medical Invoice from Best Health. Invoice Number: 665759', 'doctor@besthealth.com', '9902024455081', 1, '2019-06-25 22:43:34', '2019-06-25 22:52:32'),
('admin_3a00b4e144c567fe', 'Your appointment has been successfully set on Thu, 04 July 2019 at 10:00 AM', 'admin@besthealth.com', '6005150205088', 0, '2019-07-01 17:09:03', NULL),
('admin_268f562368a5a026', 'Your appointment has been successfully set on Tue, 02 July 2019 at 10:00 AM', 'admin@besthealth.com', '9902024455081', 0, '2019-07-01 17:09:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `idnumber` varchar(14) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `address` tinytext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES
('6005150205088', 'Mduduzi', 'Buys', '1960-05-15', 'male', 'mduduzi@mweb.co.za', '0675924440', '06 Baileybridge Unit 9 Stonebridge Phoenix', 1, '2019-06-24 19:41:39', '2019-06-24 19:57:19'),
('9902024455081', 'Lucky', 'Molefe', '1999-02-02', 'male', 'luckmolf@company.com', '0821234567', '123 Street, City, Code', 1, '2019-06-17 19:42:29', '2019-07-01 15:35:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invid`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`idnumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `patients` (
  `idnumber` varchar(14) NOT NULL PRIMARY KEY (`idnumber`),
  `firstname` varchar(50) NOT NULL,
 `lastname` varchar(50) NOT NULL,
 `dob` date NOT NULL,
 `gender` varchar(6) NOT NULL,
 `email` varchar(50) NOT NULL,
 `telephone` varchar(10) NOT NULL,
 `address` tinytext NOT NULL,
 `status` tinyint(1) NOT NULL 1,
 `created` datetime NOT NULL CURRENT_TIMESTAMP,
 `modified` datetime NULL on update CURRENT_TIMESTAMP
 ); 