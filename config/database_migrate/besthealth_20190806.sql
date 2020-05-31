-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2019 at 03:11 PM
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
('5605150205088', '2019-07-25', '11:00:00', 1, '2019-07-11 23:12:49', '2019-07-14 13:08:57'),
('9907280115082', '2019-07-18', '14:00:00', 2, '2019-07-11 23:13:56', '2019-07-24 18:39:20');

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
('304177', '9907280115082', 'Consultation Fee  ', 1, '977.50', 1, 'EFT', '2019-07-30 20:28:06', '2019-07-30 22:14:03');

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
('admin_11dabc3e30745790', 'Your appointment has been successfully set on Mon, 15 July 2019 at 2:00 PM', 'admin@besthealth.com', '9907280115082', 1, '2019-07-11 23:13:56', '2019-07-19 22:18:58'),
('admin_3a00b4e144c567fe', 'Your appointment has been successfully set on Thu, 04 July 2019 at 10:00 AM', 'admin@besthealth.com', '6005150205088', 0, '2019-07-01 17:09:03', NULL),
('admin_5c9d1dad72f3cc7d', 'Your appointment has been successfully set on Thu, 25 July 2019 at 11:00 AM', 'admin@besthealth.com', '5605150205088', 1, '2019-07-11 23:12:49', '2019-07-24 19:26:00'),
('admin_68ef96709d04c13d', 'Your appointment has been successfully set on Sat, 10 August 2019 at 11:00 AM', 'admin@besthealth.com', '6005150205088', 0, '2019-07-11 16:13:57', NULL),
('admin_7c805af1296669c1', 'Invoice Update<br/>Please update invoice 22345.Thank You', 'doctor@besthealth.com', 'admin@besthealth.com', 1, '2019-07-14 21:34:57', '2019-07-24 22:43:21'),
('admin_a709a16922874ad8', 'You received Medical Invoice from Best Health. Invoice Number: 304177', 'doctor@besthealth.com', '9907280115082', 1, '2019-07-24 20:28:06', '2019-07-24 20:32:43'),
('admin_bb54f78d16dbbffb', 'Gentle reminder your appointment tomorrow Thu, 25 July 2019 at 11:00 AM', 'admin@besthealth.com', '5605150205088', 1, '2019-07-24 19:09:49', '2019-07-24 19:25:53'),
('webvisitor_97e1a41c1d122256', 'Names: Lucky Molefe<br/>Tel: 08144228877<br/>Email: test@test.com<br/>Hello there testing.', 'webcontact@besthealth.com', 'admin@besthealth.com', 1, '2019-07-27 17:25:05', '2019-07-27 17:31:30');

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
('3602250350086', 'Moyahabo', 'Mbonani', '1936-02-25', 'male', 'moyahabo@mweb.co.za', '0847803175', '11 Gallinule Avenue\r\nRooihuiskraal', 1, '2019-08-01 16:53:09', NULL),
('5206110625085', 'Mduduzi', 'Mangena', '1952-06-11', 'male', 'mduduzi@rbiworld.co.za', '0601122791', '11 Mayibuye \r\nHouse No 19326 \r\nJoburg Ivory Park Ext 12', 1, '2019-08-01 16:49:00', NULL),
('5605150205088', 'Busisiwe', 'DuPlessis', '1956-05-15', 'female', 'tlou@rbiworld.co.za', '0667622975', '1 Kliprivier Avenue Secunda Secunda', 1, '2019-07-30 19:18:02', '2019-07-30 22:13:10'),
('6005150205088', 'Mduduzi', 'Buys', '1960-05-15', 'male', 'mduduzi@mweb.co.za', '0675924440', '06 Baileybridge Unit 9 Stonebridge Phoenix', 1, '2019-07-30 19:41:39', '2019-07-30 22:13:34'),
('9907280115082', 'Paul', 'Phakathi', '1999-07-28', 'male', 'brian@rbiworld.co.za', '0563317137', '11 Rutstein Avenue Ben Kamma', 1, '2019-07-11 19:14:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD UNIQUE KEY `created` (`created`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
