<?php

	//patientModel
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	/**
	* @param
	* @return Patient Object
	* Description: 
	*/
	class Patient extends DBAdapter {
		private $conn = null;

		
		public function __construct() {
			$this->conn = parent::connect();
		}
		//procted page for unauthorized user
		public function protected_page() {
			if(!isset($_SESSION['patient']['token'])) {
				header('Location: login.php');
			}
		}
		//Patient account login
		public function login($params) {
			$helper = new Helper();
			$stmt =  $this->conn->prepare('SELECT * FROM patients WHERE idnumber = ? AND lastname = ?');
			$stmt->bindValue(1, $params['idnumber']);
			$stmt->bindValue(2, $params['lastname']);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$_SESSION['patient']['token'] = $helper->tokenize();
				$_SESSION['patient']['pid'] = $row->idnumber;
				return true;
			}
			else {
				return false;
			}
		}
		//Patient logout
		public function logout() {
			unset($_SESSION['patient']);
			session_unset();
			return true;
		}

		//validate patient account ID Number if exist
		public function checkIDNumber($uid) {
			$stmt = $this->conn->prepare("SELECT idnumber FROM patients WHERE idnumber = ?");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		//
		public function readProfile($pid) {
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE idnumber = ?");
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//
		public function readHistory($pid='') {
			$stmt = $this->conn->prepare("SELECT * FROM appointments WHERE idnumber = ? ORDER BY created DESC");
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//
		public function cancelAppointment($pid, $appdate) {
			$stmt = $this->conn->prepare("UPDATE appointments SET status = 0 WHERE idnumber = ? AND app_date = ?");
			$stmt->bindValue(1, $pid);
			$stmt->bindValue(2, $appdate);
			if($stmt->execute()) {
				$notify = new Notification(); #instantiate to get access to method sendMessage()
				$helper = new Helper(); #instantiate to get access to method tokenize()
				//our notification message body
				$messageBody = "You have cancelled appointment for ".date('D, d F Y', strtotime($appdate))." at ".date('g:i A');
				//package everything in an array format
				$data = array(
					'id' => 'self_'.$helper->tokenize(),
					'message' => $messageBody,
					'sent_from' => $pid,
					'sent_to' => $pid
				);
				return $notify->sendMessage($data);
			}
			else {
				return false;
			}
		}
		//
		public function getInvoices($pid) {
			$stmt = $this->conn->prepare("SELECT * FROM invoices WHERE idnumber = ?");
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retrieve all unread and read messages
		public function retrieveAll($uid) {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? ORDER BY created DESC");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retrieve all unread messages
		public function retrieveInbox($uid) {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? AND status = 0 ORDER BY created DESC");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retrieve all seen messages
		public function retrieveSeen($uid) {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? AND status = 1 ORDER BY created DESC");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//method to open and read patient invoice, from JSON file
		public function readInvoice($invid) {
			$path = (is_dir('../invoices/')) ? "../invoices/" : ''; 
			$filename = $path.$invid.".json";
			if(is_file($filename)) {
				$jasonArr = file_get_contents($filename);
				$data = json_decode($jasonArr, true);
			}
			else {
				$data = '';
			}
			return $data;
			exit();
		}
	}

	$patient = new Patient();

?>