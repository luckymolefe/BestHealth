<?php
	//reportsModel.php
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	/**
	* 
	*/
	class Report extends DBAdapter {
		private $conn = null;

		public function __construct() {
			$this->conn = parent::connect();
		}

		public function totalSeenCurYear() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM patients WHERE YEAR(created) = YEAR(CURRENT_DATE)");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function totalSeenPrevYear() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM patients WHERE YEAR(created) = YEAR(DATE_SUB(CURRENT_DATE, 1 YEAR))");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function totalRegisteredToday() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM patients WHERE DATE_FORMAT(created, '%Y-%m-%d') = DATE_FORMAT(CURRENT_DATE, '%Y-%m-%d')");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function totalSeenToday() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM appointments WHERE status = 2 AND DATE_FORMAT(created, '%Y-%m-%d') = CURRENT_DATE");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function seenLastWeek() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM appointments WHERE status = 2 AND DATE_FORMAT(created, '%Y-%m-%d') = DATE_SUB(CURRENT_DATE, 7 DAYS)");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function seenCurrMonth() {
			$stmt = $this->conn->prepare("SELECT idnumber FROM appointments WHERE status = 2 AND DATE_FORMAT(created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')");
			$stmt->execute();
			return $stmt->rowCount();
		}
		//
		public function seenLastMonth() {
			$stmt = $this->conn->prepare("SELECT COUNT(idnumber) AS totalSeenPrevWeek FROM appointments WHERE status = 2 AND DATE_FORMAT(created, '%Y-%m-%d') = DATE_SUB(CURRENT_DATE, 1 MONTH)" );
			$stmt->execute();
			return $stmt->rowCount();
		}
		//
		public function upcomingBirthdays($date) {
			$stmt = $this->conn->prepare("SELECT YEAR(?) AS curYear, MONTHNAME(?) AS curMonth, COUNT(idnumber) AS totalDob
										  FROM patients 
										  WHERE MONTH(dob) = MONTH(?)" );
			$stmt->bindValue(1, $date);
			$stmt->bindValue(2, $date);
			$stmt->bindValue(3, $date);
			$stmt->execute();
			if($stmt->rowCount()) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			} else {
				return 0;
			}
		}
		//
		public function topFiveBirthdays() {
			$stmt = $this->conn->prepare("SELECT dob FROM patients 
										WHERE MONTH(dob) = MONTH(NOW()) 
										AND DAY(dob) BETWEEN DAY(CURRENT_DATE) AND DAY(DATE_ADD(CURRENT_DATE, INTERVAL 7 DAYS)) LIMIT 0,5");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			} else {
				return 0;
			}
		}

	}
	$report = new Report();

?>