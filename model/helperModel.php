<?php
//helperClass
/**
* 
*/
class Helper {
	private $data = null;

	//return generated token
	public function tokenize() {
		return $this->generateToken();
	}
	//private method to generate new random token
	private function generateToken() {
		return  bin2hex(openssl_random_pseudo_bytes(8));
	}
	//returns hashed data
	public function hashkey($data) {
		$this->data = $data;
		return  hash('sha1', $this->data);
	}
	//method to sanitize/clean data
	public function strip_data($data) {
		$clean_data = array();
		foreach($data as $k => $v) {
			$clean_data[$k] = htmlentities(stripslashes(strip_tags(trim($v)))); 
		}
		return $clean_data;
	}
	//method to redirect page when called
	public function redirect($url='') {
		echo "<script>window.open('".$url."','_self')</script>";
	}
	//private method to generate invoice numbers.
	private function randInvoiceGenerator() {
		return rand(100000, 999999);
	}
	//method returning generated InvoiceNumber
	public function randomInvoice() {
		return $this->randInvoiceGenerator();
	}
	//generate random images from images/bcards/ folder
	public function randBirthdayCard() {
		$path = "../images/bcards/";
		$cards = scandir($path);
		$range = range(1, 12);
		$randCard = rand(2, count($range));
		return $cards[$randCard];
	}
	//method to create and write to log file.
	public function createLog($action) {
		$action = ($action == "backup") ? "Backup" : "Restore";
		$dirpath = "../logs/";
		if(!is_dir($dirpath)) {
			mkdir($dirpath); //create new directory if does not exits
		}
		$filename = date('Ymdhis')."_backup_log.txt"; //give file a name combine dateTime to make timestamp, and underscore with backup 
		$file = $dirpath.$filename; #concatenate directory name and folder path
		if(is_dir($dirpath)) { //check if file already exists
			try{
				ob_start();
				$f = fopen($file, "a+"); //open file for appending
				$data = "TIMESTAMP \t\t ACTION MESSAGE \r\n";
				$data .= date('d-m-Y h:i:s')."\t"."Created Database ".$action." \n<br>"; //data to be written to file
				fwrite($f, $data); //now wite data to file
				fclose($f); //close the file when done
				ob_clean();
				ob_flush();
			} catch(Exception $e) {
				echo $e->getMessage(); //handle any errors occures
			}
		} 
		else {
			echo "Invalid File Path: failed to create log ({$filename}_backup.txt)";
		}
	}
	//method to retrieve all available logs files
	public function retrieveLogs() {
		$dirpath = "../logs/";
		if(is_dir($dirpath)) { //check if directory exist
			$files = scandir($dirpath); //scan inside the given directory path
			$data = array(); #create an empty array
			foreach($files as $file) {
				if(!is_dir($file)) {
					array_push($data, $file); #push data into an empty array
				}
			}
			return $data; #then return data in array format
		}
		else {
			return 0; #else return zero if no files found
		}
	}
	//method to open and read log file 
	public function readLog($filename='') {
		$dirpath = "../logs/";
		$file = $dirpath.$filename; #concatenate folder path with filename passed
		if(is_dir($dirpath)) {
			try {
				$file = file_get_contents($file); //retrieve data inside the textfile
			} catch (Exception $e) {
				echo $e->getMessage(); //handle any errors occures
				$file = 0; #assign null on failed to open file
			}
		}
		else {
			echo "Invalid Path: directory does not exist!";
		}
		return $file; #then return data
	}
}
//instantiate Helper class
$helper = new Helper();

?>