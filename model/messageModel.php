<?php
	//message model
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	/**
	* 
	*/
	class Notification extends DBAdapter {
		private $conn = null;

		public function __construct() {
			$this->conn = parent::connect();
		}

		public function sendMessage($params) {
			$stmt = $this->conn->prepare("INSERT INTO messages (id, message, sent_from, sent_to) VALUES (?, ?, ?, ?)");
			$stmt->bindValue(1, $params['id']);
			$stmt->bindValue(2, $params['message']);
			$stmt->bindValue(3, $params['sent_from']);
			$stmt->bindValue(4, $params['sent_to']);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		public function viewMessageItem($timestamp) {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE created = ?");
			$stmt->bindValue(1, $timestamp);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}

		public function updateMessage($timestamp) {
			$stmt = $this->conn->prepare("UPDATE messages SET status = 1 WHERE created = ?");
			$stmt->bindValue(1, $timestamp);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//select all birthday dates within 30days of current month, (i.e. view all patients who birthday is this month).
		public function getBirthdays() {
			$stmt = $this->conn->prepare("SELECT * FROM patients WHERE MONTH(dob) >= MONTH(NOW())");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//
		private function getBirthdaysToday() {
			$stmt = $this->conn->prepare("SELECT * FROM parents WHERE DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT(CURRENT_DATE , '%m-%d')");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			} else {
				return false;
			}
		}
		//Send bithrday wishes to all Patients who's birthday is today i.e the currentDay.
		public function composeCardWishes() {
			$helper = new Helper();
			$alldob = $this->getBirthdaysToday();
			$carditem = $helper->randBirthdayCard();
			$randWish = $this->randomWish();
			// $basepath = $basepath."reminders/";
			//send messages --> create an array and write data to JSON FILE.
			if($alldob != false) {
				foreach($alldob as $row) :
					$cardData = array(
						'birthday' => array(
							'idnumber' => $row->idnumber,
							'fullname' => $row->firstname.' '.$row->lastname,
							'card' => $carditem,
							'from' => 'admin@besthealth.com',
							'title' => 'Happy Birthday',
							'message' => $randWish,
							'created' => date('Y-m-d H:i:s')
						)
					);
					$this->sendWishes($cardData); //call melthod
				endforeach;
				$response = "success";
			} else {
				$response = "failed";
			}
			return $response;
		}
		//
		private function randomWish() {
			$messages = array(
				'We wish you the best day, happiness and wellness life.',
				'Happy birthday and wish you all the healthy life.',
				'Best Health wishes you a happy birthday and all the best for your birthday!.'
			);
			$count = count($messages)-1;
			$random = rand(0, $count);
			return $messages[$random];
		}
		//
		private function sendWishes($data='') {
			//write wish to file and save to folder
			$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
			$basepath = $basepath."reminders/";
			$jsondata = json_encode($data);
			//create directory if not exists
			if(!is_dir($basepath)) {
				mkdir($basepath); 
			}
			//create a file inside reminders directory
			$filename = $data['birthday']['idnumber']."_".date('Y-m-d-H-i-s').'.json';
			try {
				$fp = fopen($basepath.$filename, 'w');
				fwrite($fp, $jsondata); //write birthday message to file created
				fclose($fp);
			} catch(Exception $e) {
				echo "Error: ".$e->getMessage(); //catch any error thrown on opening and writing of invoice data
			}
			return true;
		}

		//Patient read birthday message card
		public function openBirthdayAlerts($pid='') {
			//read and write from a json file
			$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
			$basepath = $basepath."reminders/"; //specify directory folder
			$files = scandir($basepath); //scan specified directory
			if(count($files) > 0) {
				foreach($files as $file) :
					if(!is_dir($file)) {
						$part = explode('_', $file);
						if($pid == $part[0]) {
							$file_data = file_get_contents($basepath.'/'.$file);
							$jason = json_decode($file_data);
						} else {
							$jason = 0;
						}
					}
				endforeach;
			}
			else {
				$jason = 0;
			}
			return $jason;
		}

		//select all messages sent to admin email address
		public function readAllMessages($sent_to='') {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? ORDER BY created DESC");
			$stmt->bindValue(1, $sent_to);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//select all messages with status of 0 zero
		public function unreadMessages($sent_to='') {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? AND status = 0 ORDER BY created DESC");
			$stmt->bindValue(1, $sent_to);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//select all messages with status of 1
		public function seenMessages($sent_to='') {
			$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sent_to = ? AND status = 1 ORDER BY created DESC");
			$stmt->bindValue(1, $sent_to);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//
		public function counter($action='') {
			switch($action) {
				case 'inbox':
					return $this->countUnread();
				break;
				case 'birthdays':
					return $this->monthlyBirthdays();
				break;
				case 'reminders':
					return $this->countReminders();
				break;
			}
		}

		private function countUnread($sent_to='admin@besthealth.com') {
			$stmt = $this->conn->prepare("SELECT id FROM messages WHERE sent_to = ? AND status = 0");
			$stmt->bindValue(1, $sent_to);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->rowCount();
			}
			else {
				return 0;
			}
		}
		//all birthdays within this Month
		private function monthlyBirthdays() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM patients WHERE MONTH(dob) >= MONTH(NOW())");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->rowCount();
			}
			else {
				return 0;
			}
		}
		//
		private function countReminders() {
			/*$stmt = $this->conn->prepare("");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->rowCount();
			}
			else {
				return 0;
			}*/
			return 0;
		}
		
	}
	$notify = new Notification();

?>