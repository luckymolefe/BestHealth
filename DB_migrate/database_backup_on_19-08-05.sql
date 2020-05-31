

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


INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES ('3602250350086','Moyahabo','Mbonani','1936-02-25','male','moyahabo@mweb.co.za','0847803175','11 Gallinule Avenue
Rooihuiskraal','1','2019-08-01 16:53:09','');

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES ('5206110625085','Mduduzi','Mangena','1952-06-11','male','mduduzi@rbiworld.co.za','0601122791','11 Mayibuye 
House No 19326 
Joburg Ivory Park Ext 12','1','2019-08-01 16:49:00','');

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES ('5605150205088','Busisiwe','DuPlessis','1956-05-15','female','tlou@rbiworld.co.za','0667622975','1 Kliprivier Avenue Secunda Secunda','1','2019-07-30 19:18:02','2019-07-30 22:13:10');

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES ('6005150205088','Mduduzi','Buys','1960-05-15','male','mduduzi@mweb.co.za','0675924440','06 Baileybridge Unit 9 Stonebridge Phoenix','1','2019-07-30 19:41:39','2019-07-30 22:13:34');

INSERT INTO `patients` (`idnumber`, `firstname`, `lastname`, `dob`, `gender`, `email`, `telephone`, `address`, `status`, `created`, `modified`) VALUES ('9907280115082','Paul','Phakathi','1999-07-28','male','brian@rbiworld.co.za','0563317137','11 Rutstein Avenue Ben Kamma','1','2019-07-11 19:14:36','');
