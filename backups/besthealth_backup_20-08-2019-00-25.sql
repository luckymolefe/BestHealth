
-- Table structure for table `admin`

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(155) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Dumping data for table `admin`

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `status`, `created`) VALUES
('1','admin','admin@besthealth.com','d033e22ae348aeb5660fc2140aec35850c4da997','1','2019-06-17 15:51:07');


-- Table structure for table `appointments`

CREATE TABLE `appointments` (
  `idnumber` varchar(13) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `appointments`

INSERT INTO `appointments` (`idnumber`, `app_date`, `app_time`, `status`, `created`, `modified`) VALUES
('5605150205088','2019-07-25','11:00:00','0','2019-07-11 23:12:49','2019-08-08 14:43:35'),
('9907280115082','2019-07-18','14:00:00','2','2019-07-11 23:13:56','2019-07-24 18:39:20'),
('9907280115082','2019-08-09','10:00:00','1','2019-08-08 14:43:18',''),
('5206110625085','2019-08-21','11:00:00','2','2019-08-19 23:38:56','2019-08-20 00:10:03');


-- Table structure for table `doctor`

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(155) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Dumping data for table `doctor`

INSERT INTO `doctor` (`id`, `username`, `email`, `password`, `created`) VALUES
('1','Doctor','doctor@besthealth.com','d033e22ae348aeb5660fc2140aec35850c4da997','2019-06-19 08:14:13');


-- Table structure for table `invoices`

CREATE TABLE `invoices` (
  `invid` varchar(50) NOT NULL,
  `idnumber` varchar(13) NOT NULL,
  `description` text NOT NULL,
  `quantity` tinyint(2) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_type` varchar(10) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`invid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `invoices`

INSERT INTO `invoices` (`invid`, `idnumber`, `description`, `quantity`, `amount`, `status`, `payment_type`, `created`, `modified`) VALUES
('304177','9907280115082','Consultation Fee  ','1','977.50','1','EFT','2019-07-30 20:28:06','2019-07-30 22:14:03'),
('387819','5605150205088','Consultation Fee  ','1','632.50','0','Cash','2019-08-20 00:15:46','');


-- Table structure for table `messages`

CREATE TABLE `messages` (
  `id` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `sent_from` varchar(50) NOT NULL,
  `sent_to` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `messages`

INSERT INTO `messages` (`id`, `message`, `sent_from`, `sent_to`, `status`, `created`, `modified`) VALUES
('admin_0f69defdc7464964','Your appointment has been successfully set on Wed, 21 August 2019 at 11:00 AM','admin@besthealth.com','5206110625085','1','2019-08-19 23:38:56','2019-08-19 23:55:42'),
('admin_11dabc3e30745790','Your appointment has been successfully set on Mon, 15 July 2019 at 2:00 PM','admin@besthealth.com','9907280115082','1','2019-07-11 23:13:56','2019-07-19 22:18:58'),
('admin_1691d0fe4e5e8b22','Gentle reminder your appointment tomorrow on Wed, 21 August 2019 at 11:00 AM','admin@besthealth.com','5206110625085','0','2019-08-20 00:02:40',''),
('admin_16ded66b8791538d','You received Medical Invoice from Best Health. <br/>Invoice Number: 387819','doctor@besthealth.com','5605150205088','0','2019-08-20 00:15:46',''),
('admin_3a00b4e144c567fe','Your appointment has been successfully set on Thu, 04 July 2019 at 10:00 AM','admin@besthealth.com','6005150205088','0','2019-07-01 17:09:03',''),
('admin_5c9d1dad72f3cc7d','Your appointment has been successfully set on Thu, 25 July 2019 at 11:00 AM','admin@besthealth.com','5605150205088','1','2019-07-11 23:12:49','2019-07-24 19:26:00'),
('admin_68ef96709d04c13d','Your appointment has been successfully set on Sat, 10 August 2019 at 11:00 AM','admin@besthealth.com','6005150205088','0','2019-07-11 16:13:57',''),
('admin_7c805af1296669c1','Invoice Update<br/>Please update invoice 22345.Thank You','doctor@besthealth.com','admin@besthealth.com','1','2019-07-14 21:34:57','2019-07-24 22:43:21'),
('admin_834a2e131c1f378b','Your appointment has been successfully set on Fri, 09 August 2019 at 10:00 AM','admin@besthealth.com','9907280115082','1','2019-08-08 14:43:18','2019-08-08 19:47:08'),
('admin_a709a16922874ad8','You received Medical Invoice from Best Health. Invoice Number: 304177','doctor@besthealth.com','9907280115082','1','2019-07-24 20:28:06','2019-07-24 20:32:43'),
('admin_bb54f78d16dbbffb','Gentle reminder your appointment tomorrow Thu, 25 July 2019 at 11:00 AM','admin@besthealth.com','5605150205088','1','2019-07-24 19:09:49','2019-07-24 19:25:53'),
('webvisitor_97e1a41c1d122256','Names: Lucky Molefe<br/>Tel: 08144228877<br/>Email: test@test.com<br/>Hello there testing.','webcontact@besthealth.com','admin@besthealth.com','1','2019-07-27 17:25:05','2019-07-27 17:31:30'),
('webvisitor_f4bf81e3582ab73b','Names: Lucky Molefe<br/>Tel: 08144228877<br/>Email: luckmolf@company.com<br/>hello there','webcontact@besthealth.com','admin@besthealth.com','1','2019-08-19 23:25:02','2019-08-19 23:48:31');


-- Table structure for table `patients`

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
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `patients`

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES
('3602250350086','Moyahabo','Mbonani','1936-02-25','male','moyahabo@mweb.co.za','0847803175','11 Gallinule Avenue, Rooihuiskraal','1','2019-08-01 16:53:09','2019-08-08 23:34:51'),
('5002080660085','Tlou','Mabotja','1950-02-08','male','tlou@rbiworld.co.za','0834736015','1158 Manchester Crescent, Lenasia South','1','2019-08-08 22:59:00',''),
('5206110625085','Mduduzi','Mangena','1952-06-11','male','mduduzi@rbiworld.co.za','0601122791','11 Mayibuye 
House No 19326 
Joburg Ivory Park Ext 12','1','2019-08-01 16:49:00',''),
('5605150205088','Busisiwe','DuPlessis','1956-05-15','female','busisiwe@rbiworld.co.za','0667622975','1 Kliprivier Avenue Secunda Secunda','1','2019-07-30 19:18:02','2019-08-08 22:51:03'),
('6005150205088','Mduduzi','Buys','1960-05-15','male','mduduzi@mweb.co.za','0675924440','06 Baileybridge Unit 9 Stonebridge Phoenix','1','2019-07-30 19:41:39','2019-07-30 22:13:34'),
('9907280115082','Paul','Phakathi','1999-07-28','male','paul@rbiworld.co.za','0563317137','11 Rutstein Avenue Ben Kamma','1','2019-07-11 19:14:36','2019-08-08 22:50:53');

