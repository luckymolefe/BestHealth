<?php
	//adminModel.php
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	class Admin extends DBAdapter {
		private $conn = null;

		public function __construct() {
			$this->conn = parent::connect();
		}
		//
		public function protected_page() {
			if(!isset($_SESSION['admin']['token'])) {
				header('Location: login.php');
			}
		}
		//admin login into account
		public function login($params) {
			$helper = new Helper();
			if(!$this->validateEmail($params['username'])) {
				return false;
			}
			$stmt = $this->conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
			$stmt->bindValue(1, $params['username']);
			$stmt->bindValue(2, $helper->hashkey($params['password']));
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$_SESSION['admin']['uid'] = $row->id;
				$_SESSION['admin']['token'] = $helper->tokenize();
				return true;
			}
			else {
				return false;
			}
		}
		//validate admin email
		private function validateEmail($email) {
			$stmt = $this->conn->prepare("SELECT email FROM admin WHERE email = ?");
			$stmt->bindValue(1, $email);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		//admin update password
		private function changePassword($id, $newpassword) {
			$helper = new Helper();
			$stmt = $this->conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
			$stmt->bindValue(1, $helper->hashkey($newpassword));
			$stmt->bindValue(2, $_SESSION['admin']['uid']);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		public function updatePassword($id, $newpassword) {
			return $this->changePassword($id, $newpassword);
		}
		//admin logout
		public function logout() {
			unset($_SESSION['admin']);
			session_unset();
			return true;
		}
		//
		public function addNew($params) {
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

		public function saveEdit($params) {
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
		//returns boolean, create new appointment record for patient
		public function bookAppointment($param) {
			try {
				$stmt = $this->conn->prepare("INSERT INTO appointments (idnumber, app_date, app_time) VALUES (?, ?, ?)");
				$stmt->bindValue(1, $param['uid']);
				$stmt->bindValue(2, $param['appdate']);
				$stmt->bindValue(3, $param['apptime']);
				if($stmt->execute()) {
					$this->sendNotify($param);
					return true;
				}
				else {
					return false;
				}
			}
			catch(PDOException $e) {
				echo "ERROR: ".$e->getMessage();
			}
		}
		//returns Void, method only accessible within this class or within a subClass, inherited this class.
		protected function sendNotify($param) {
			$notify = new Notification(); #instantiate to get access to method sendMessage()
			$helper = new Helper(); #instantiate to get access to method tokenize()
			//our notification message body
			$messageBody = "Your appointment has been successfully set on ".date('D, d F Y', strtotime($param['appdate'])).
			" at ".date('g:i A', strtotime($param['apptime']));
			//package everything in an array format
			$data = array(
				'id' => 'admin_'.$helper->tokenize(),
				'message' => $messageBody,
				'sent_from' => "admin@besthealth.com",
				'sent_to' => $param['uid'] #we can use an email address here
			);
			return $notify->sendMessage($data); #then pass single array parameter with all data within it.
		}

		//function check for avalilable appointments
		public function checkAvailability($date) {
			$stmt = $this->conn->prepare("SELECT app_date, TIME(app_time) AS daytime, HOUR(app_time) AS app_time FROM appointments WHERE app_date = ? AND status = 1");
			$stmt->bindValue(1, $date);
			if($stmt->execute()) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
		}
		//check if patient has an active appointment
		public function isAppActive($param) {
			$stmt = $this->conn->prepare("SELECT idnumber, status FROM appointments WHERE idnumber = ? AND status = 1 LIMIT 0,1");
			$stmt->bindValue(1, $param['uid']);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//retrieve all patients
		public function viewAllPatients() {
			$stmt = $this->conn->prepare("SELECT * FROM patients");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//retrieve all appointments
		public function viewAllAppointments() {
			$stmt = $this->conn->prepare("SELECT * FROM appointments ORDER BY created DESC");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//trigger method to cancel appointments
		public function cancelAppointment($pid, $appdate) {
			$stmt = $this->conn->prepare("UPDATE appointments SET status = 0 WHERE idnumber = ? AND app_date = ?");
			$stmt->bindValue(1, $pid);
			$stmt->bindValue(2, $appdate);
			if($stmt->execute()) {
				$notify = new Notification(); #instantiate to get access to method sendMessage()
				$helper = new Helper(); #instantiate to get access to method tokenize()
				//our notification message body
				$messageBody = "Your appointment for ".date('D, d F Y', strtotime($appdate))."has been cancelled at ".date('g:i A');
				//package everything in an array format
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
		//retrieve all invoices
		public function viewAllInvoices() {
			$stmt = $this->conn->prepare("SELECT * FROM invoices");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//update invoice status, return boolean
		public function updateInvoice($invid) {
			$stmt = $this->conn->prepare("UPDATE invoices SET status = 1 WHERE invid = ?");
			$stmt->bindValue(1, $invid);
			if($stmt->execute()) {
				$this->updateInvoiceFile($invid); //call private method to update json invoice file
				return true;
			} else {
				return false;
			}
		}
		//
		private function updateInvoiceFile($invid) {
			$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
			$basepath = $basepath."invoices/";
			$files = scandir($basepath); //scan specified directory
			$key = 'status'; //key to update
			$update = '1'; //update value
			if(count($files) > 0) {
				foreach($files as $file) :
					if(!is_dir($file)) {
						$part = explode('.', $file);
						if($invid == $part[0]) {
							$file_data = file_get_contents($basepath.'/'.$file);
							$array_data = json_decode($file_data);
							if(array_key_exists($key, $array_data->patient)) {
								$array_data->patient->status = $update;
								file_put_contents($basepath.'/'.$file, json_encode($array_data));
								$response = 1; //update success
							}
							/*if(array_key_exists($key, $array_data)) {
								$array_data[$key] = $update;
								file_put_contents($basepath.'/'.$file, json_encode($array_data));
								$response = 1; //update success
							}*/
							break;
						} else {
							$response = 0; //no match found
						}
					}
				endforeach;
			}
			else {
				$response = 0; //file does not exist
			}
			return $response;
		}
		//retrieve patient by their ID number
		public function getPatientById($id) {
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE idnumber = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//returns Array of Object, filter patients by ID number or Lastname
		public function searchPatients($uid) {
			$uid = "%".$uid."%";
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE idnumber LIKE ? OR lastname LIKE ?");
			$stmt->bindValue(1, $uid);
			$stmt->bindValue(2, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return 0;
			}
		}
		//retrieve all birth dates from patients
		public function birthdayReminders() {
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE MONTH(dob) = MONTH(NOW())");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}

	}

	$admin = new Admin();

?>