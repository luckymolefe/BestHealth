<?php
	//hcpModel
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	/**
	* @param
	* @return
	*/
	class Hcp extends Admin {
		private $conn = null;
		
		//inherit parent construct object
		public function __construct() {
			$this->conn = parent::connect();
		}
		//Protect page from unauthorized users
		public function protected_page() {
			if(!isset($_SESSION['hcp']['token'])) {
				header('Location: login.php');
			}
		}
		//Hcp login into account
		public function login($params) {
			$helper = new Helper();
			if(!$this->validateEmail($params['email'])) {
				return false;
			}
			$stmt = $this->conn->prepare("SELECT * FROM hcp WHERE email = ? AND password = ?");
			$stmt->bindValue(1, $params['email']);
			$stmt->bindValue(2, $helper->hashkey($params['password']));
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$_SESSION['hcp']['uid'] = $row->id;
				$_SESSION['hcp']['token'] = $helper->tokenize();
				return true;
			}
			else {
				return false;
			}
		}
		//Hcp account logout
		public function logout() {
			unset($_SESSION['hcp']);
			session_unset();
			return true;
		}
		//validate hcp email on login
		private function validateEmail($email) {
			$stmt = $this->conn->prepare("SELECT email FROM hcp WHERE email = ?");
			$stmt->bindValue(1, $email);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		public function getProfile() {
			$uid = (int)$_SESSION['hcp']['uid'];
			$stmt = $this->conn->prepare("SELECT id, username, email FROM hcp WHERE id = ?");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//call method to change/update hcp login credential
		public function changePassword($uid, $newpassword) {
			return $this->hcpChangePassword($uid, $newpassword);
		}
		//method that makes changes to hcp login details
		private function hcpChangePassword($uid, $newpassword) {
			$stmt = $this->conn->prepare("UPDATE hcp SET password = ? WHERE id = ?");
			$stmt->bindValue(1, $newpassword);
			$stmt->bindValue(2, $uid);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get list of upcoming patients appointment, from current day and in coming 7days.
		public function upcomingApp() {
			$stmt = $this->conn->prepare("SELECT * FROM appointments WHERE status = 1 AND app_date BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY) ORDER BY app_date ASC LIMIT 0,4");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retrieve unread messages for HCP
		public function getInbox() {
			$notify = new Notification();
			return $notify->unreadMessages('doctor@besthealth.com');
		}
		//retrieve patient details by specifying patient ID Number
		public function getPatientById($pid) {
			$stmt = $this->conn->prepare("SELECT *, firstname, lastname, CONCAT(firstname,' ',lastname) AS fullname FROM patients WHERE idnumber = ?");
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//Create/Add new patient record
		public function createNew($params) {
			try {
				$this->conn->beginTransaction();
				$stmt = $this->conn->prepare("INSERT INTO 
												patients (idnumber, firstname, lastname, dob, gender, email, telephone, address) 
												VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bindValue(1, $params['idnumber']);
				$stmt->bindValue(2, $params['firstname']);
				$stmt->bindValue(3, $params['lastname']);
				$stmt->bindValue(4, $params['dob']);
				$stmt->bindValue(5, $params['gender']);
				$stmt->bindValue(6, $params['email']);
				$stmt->bindValue(7, $params['telephone']);
				$stmt->bindValue(8, $params['address']);
				if($stmt->execute()) {
					$this->conn->commit();
					return true;
				}
				else {
					return false;
				}
			}
			catch(PDOException $e) {
				$this->conn->rollBack();
				echo "ERROR: ".$e->getMessage();
			}
		}
		
		//save changes made to patient record
		public function saveEditPatient($params) {
			$stmt = $this->conn->prepare("UPDATE patients 
										  SET firstname = ?, lastname = ?, dob = ?, gender = ?, email = ?, telephone = ?, address = ?
										  WHERE idnumber = ?");
			$stmt->bindValue(1, $params['firstname']);
			$stmt->bindValue(2, $params['lastname']);
			$stmt->bindValue(3, $params['dob']);
			$stmt->bindValue(4, $params['gender']);
			$stmt->bindValue(5, $params['email']);
			$stmt->bindValue(6, $params['telephone']);
			$stmt->bindValue(7, $params['address']);
			$stmt->bindValue(8, $params['idnumber']);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//update appointment status, after hcp has confirm/seen the patient
		public function confirmAppointment($pid, $appdate) {
			$stmt = $this->conn->prepare("UPDATE appointments SET status = 2 WHERE idnumber = ? AND app_date = ?");
			$stmt->bindValue(1, $pid);
			$stmt->bindValue(2, $appdate);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//change status of booked appointment, on cancellation
		public function cancelAppointment($pid, $appdate) {
			$stmt = $this->conn->prepare("UPDATE appointments SET status = 0 WHERE idnumber = ? AND app_date = ?");
			$stmt->bindValue(1, $pid);
			$stmt->bindValue(2, $appdate);
			if($stmt->execute()) {
				$notify = new Notification(); #instantiate to get access to method sendMessage()
				$helper = new Helper(); #instantiate to get access to method tokenize()
				//our notification message body
				$messageBody = "Your appointment for ".date('D, d F Y', strtotime($appdate))."has been cancelled at ".date('g:i A');				//package everything in an array format
				$data = array(
					'id' => 'admin_'.$helper->tokenize(),
					'message' => $messageBody,
					'sent_from' => "admin@besthealth.com",
					'sent_to' => $pid
				);
				return $notify->sendMessage($data);
			}
			else {
				return false;
			}
		}
		//filter appointment by matching specified date
		public function filterAppointments($dated) {
			$stmt = $this->conn->prepare("SELECT * FROM `appointments` WHERE app_date LIKE ?");
			$stmt->bindValue(1, $dated);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retieve patient by search, matching patient idNumber or Lastname
		public function searchPatients($term) {
			$term = "%".$term."%";
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE lastname LIKE ? OR idnumber LIKE ?");
			$stmt->bindValue(1, $term);
			$stmt->bindValue(2, $term);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return 0;
			}
		}
		//Save invoice information in invoices_DBTable
		public function saveInvoice($params='') {
			$stmt = $this->conn->prepare("INSERT INTO invoices (invid, idnumber, description, quantity, amount, payment_type)
										  VALUES (:invid, :idnumber, :items, :qty, :totalamount, :paytype)");
			//format as array inside $stmt->execute([]);
			$response = $stmt->execute(
				[
					':invid' => $params['invid'],
					':idnumber' => $params['idnumber'],
					':items' => $params['items'],
					':qty' => $params['qty'],
					':totalamount' => $params['totalamount'],
					':paytype' => $params['paytype'],
				]
			);
			if($response) {
				$helper = new Helper();
				$notify = new Notification();
				$messageBody = "You received Medical Invoice from Best Health. <br/>Invoice Number: ".$params['invid'];
				//package everything in an array format
				$data = array(
					'id' => 'admin_'.$helper->tokenize(),
					'message' => $messageBody,
					'sent_from' => "doctor@besthealth.com",
					'sent_to' => $params['idnumber'] #we can use an email address here
				);
				$notify->sendMessage($data);
				return true;
			}
			else {
				return false;
			}
		}
		//get notification alert on upcoming patient session
		public function getAlerts() {
			$currDate = date('Y-m-d'); //Today's date
			$stmt = $this->conn->prepare("SELECT * FROM `appointments` WHERE status = 1 AND app_date = ? LIMIT 0,1");
			$stmt->bindValue(1, $currDate);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return 0;
			}
		}
		//prepare to send reminders for all the patients with appointments booked for the following day
		public function sendAppointmentReminder() {
			$stmt = $this->conn->prepare("SELECT * FROM appointments WHERE status = 1 AND app_date = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
				//
				$notify = new Notification(); #instantiate to get access to method sendMessage()
				$helper = new Helper(); #instantiate to get access to method tokenize()
				foreach($rows as $row) :
					//our notification message body
					$messageBody = "Gentle reminder your appointment tomorrow on ".date('D, d F Y', strtotime($row->app_date)). " at ".date('g:i A', strtotime($row->app_time));
					//package everything in an array format
					$data = array(
						'id' => 'admin_'.$helper->tokenize(),
						'message' => $messageBody,
						'sent_from' => "admin@besthealth.com",
						'sent_to' => $row->idnumber #we can use an email address here
					);
					$notify->sendMessage($data); #then pass single array parameter with all data within it.
				endforeach;
				return true;
			}
			else {
				return false;
			}
		}
		//retrieve all invoices from database
		public function retrieveInvoices() {
			$stmt = $this->conn->prepare("SELECT * FROM invoices");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//do database backup and download file
		public function downloadBackup() {
			$helper = new Helper();
			//instantiate backup class
		    $backup = new Backup();
		    //call method to do backup file
		    $filename = $backup->doBackup();
		    #force download
			header('Content-Type: application/octet-stream; charset=utf-8');
			header('Content-Disposition: attachment; filename='.$filename);
			//write action to LOGFILE
		    $helper->createLog('backup');
		}
	}
	$hcp = new Hcp();

?>