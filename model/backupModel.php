<?php
//Backup Model
$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
require_once($basepath.'bootstrap.php');
/**
* class extends connection adapter to make use of connection object
*/
class Backup extends DBAdapter {
	private $conn = null;
	public const __DIRPATH__ = "../backups/"; //define constant value to path

	public function __construct() {
		$this->conn = parent::connect();
	}
	//return all tables in the specified database
	private function getTables() {
		$stmt = $this->conn->prepare("SHOW TABLES");
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
		if($rows) {
			$tables_names = array(); //create an empty array
			foreach($rows as $row) {
				array_push($tables_names, $row->Tables_in_besthealth); //push table names into an array
			}
			return $tables_names; //return table names in array
		} else {
			return false;
		}
	}
	//returns table structure for specified table
	private function createStructure($tbl_name='') {
		$stmt = $this->conn->prepare("SHOW CREATE TABLE {$tbl_name}");
	    $stmt->execute();
	    if($stmt->rowCount() > 0) {
		    $tbl_create = $stmt->fetch(PDO::FETCH_NUM);
		    return $tbl_create;
		} else {
			return false;
		}
	}
	//returns table rows for specified table
	private function readRows($table_name='') {
		$stmt = $this->conn->prepare("SELECT * FROM {$table_name}");
		$stmt->execute();
		$totalRows = $stmt->rowCount();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$response = '';

		if($totalRows > 0) {
			$response .= "\n-- Dumping data for table `{$table_name}`\n";
			$tbl_cols = array_keys($rows[0]);
			$response .= "\nINSERT INTO `{$table_name}`";
			$response .= " (`".implode('`, `', $tbl_cols)."`) VALUES\n";
			for($i=0; $i<$totalRows; $i++) {
				$tbl_data = array_values($rows[$i]);
				if($i != $totalRows-1) {
					$response .= "('".implode("','", $tbl_data)."'),\n";
				} else {
					$response .= "('".implode("','", $tbl_data)."');\n\n";
				}
			}
			return $response;
		} else {
			return false;
		}
		
	}
	//returns full Database backup formatted in SQL Code
	private function runBackup() {
		// Get All Table Names From the Database
		$table_list = $this->getTables();
		if($table_list != false) {
			$structure = array();

			foreach($table_list as $tbl_name) :
				$structure[] = $this->createStructure($tbl_name);
			endforeach;

			$data = '';
			foreach($structure as $struct) {
				$data .= "\n-- Table structure for table `".$struct[0]."`\n";
				$data .= "\n".$struct[1].";\n\n";
				$data .= $this->readRows($struct[0]);
			}
			return $data;
		} else {
			return false;
		}
	}

	public function doBackup() {
		//call method to return full sql database code
		$backup_data = $this->runBackup();
		//full path for backup file
		$filepath = self::__DIRPATH__;
		//SQL backup data filename
		$filename = "besthealth_backup_". date("d-m-Y-H-i") . ".sql";
		//write data to the file
		$results = file_put_contents($filepath.$filename, $backup_data);
		if($results > 0) {
			// echo "<h2>BACKUP CREATED SUCCESSFULLY...</h2>";
			// readfile($filepath.$filename, $backup_data);
			return $filename;
		}
		else {
			return false;
		}
	}

	public function doRestoreDatabase($query) {
		//create database table & insert data into table
		try {
			$stmt = $this->conn->prepare($query);
			if($stmt->execute()) {
				$helper = new Helper();
				$helper->createLog('restore'); //write to log file
				$message = "Success";
			} else {
				$message = "Failed";
			}
		}
		catch(PDOException $e) {
			$message = "Failed";
			echo "Error: ".$e->getMessage();
		}
		return $message;
		exit();
	}
}
//instantiate class
// $backup = new Backup();


?>