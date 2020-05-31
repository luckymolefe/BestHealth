<?php
/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 4.8.5
 */

/**
 * Database `besthealth`
 */

/* `besthealth`.`admin` */
$admin = array(
  array('id' => '1','username' => 'admin','email' => 'admin@besthealth.com','password' => 'd033e22ae348aeb5660fc2140aec35850c4da997','status' => '1','created' => '2019-06-17 15:51:07')
);

/* `besthealth`.`appointments` */
$appointments = array(
  array('idnumber' => '9902024455081','app_date' => '2019-07-01','app_time' => '00:00:00','status' => '0','created' => '2019-06-24 14:03:08','modified' => '2019-07-08 16:13:59'),
  array('idnumber' => '6005150205088','app_date' => '2019-07-04','app_time' => '10:00:00','status' => '2','created' => '2019-07-01 17:09:02','modified' => '2019-07-08 16:14:18'),
  array('idnumber' => '9902024455081','app_date' => '2019-07-10','app_time' => '21:00:00','status' => '0','created' => '2019-07-01 17:09:53','modified' => '2019-07-10 20:43:32')
);

/* `besthealth`.`doctor` */
$doctor = array(
  array('id' => '1','username' => 'Doctor','email' => 'doctor@besthealth.com','password' => 'd033e22ae348aeb5660fc2140aec35850c4da997','created' => '2019-06-19 08:14:13')
);

/* `besthealth`.`invoices` */
$invoices = array(
  array('invid' => '665759','idnumber' => '9902024455081','description' => 'Consultation Fee MutliVitamin-B ','quantity' => '2','amount' => '770.50','status' => '0','payment_type' => 'EFT','created' => '2019-06-25 22:43:34','modified' => NULL)
);

/* `besthealth`.`messages` */
$messages = array(
  array('id' => 'admin_dec5a9bf9ba3aa4a','message' => 'Your appointment has been successfully set onTue, 25 June 2019 at 10:00 AM','sent_from' => 'Admin@besthealth.com','sent_to' => '9902024455081','status' => '1','created' => '2019-06-24 14:03:09','modified' => '2019-06-24 17:15:06'),
  array('id' => 'admin_e78f4caecb997d0c','message' => 'You received Medical Invoice from Best Health. Invoice Number: 665759','sent_from' => 'doctor@besthealth.com','sent_to' => '9902024455081','status' => '1','created' => '2019-06-25 22:43:34','modified' => '2019-06-25 22:52:32'),
  array('id' => 'admin_3a00b4e144c567fe','message' => 'Your appointment has been successfully set on Thu, 04 July 2019 at 10:00 AM','sent_from' => 'admin@besthealth.com','sent_to' => '6005150205088','status' => '0','created' => '2019-07-01 17:09:03','modified' => NULL),
  array('id' => 'admin_268f562368a5a026','message' => 'Your appointment has been successfully set on Tue, 02 July 2019 at 10:00 AM','sent_from' => 'admin@besthealth.com','sent_to' => '9902024455081','status' => '0','created' => '2019-07-01 17:09:53','modified' => NULL)
);

/* `besthealth`.`patients` */
$patients = array(
  array('idnumber' => '6005150205088','firstname' => 'Mduduzi','lastname' => 'Buys','dob' => '1960-05-15','gender' => 'male','email' => 'mduduzi@mweb.co.za','telephone' => '0675924440','address' => '06 Baileybridge Unit 9 Stonebridge Phoenix','status' => '1','created' => '2019-06-24 19:41:39','modified' => '2019-06-24 19:57:19'),
  array('idnumber' => '9902024455081','firstname' => 'Lucky','lastname' => 'Molefe','dob' => '1999-02-02','gender' => 'male','email' => 'luckmolf@company.com','telephone' => '0821234567','address' => '123 Street, City, Code','status' => '1','created' => '2019-06-17 19:42:29','modified' => '2019-07-01 15:35:23')
);
