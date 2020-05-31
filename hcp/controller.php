<?php
	//HCP controller script
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');

	//
	if(isset($_POST['login']) && $_POST['login'] == "true") {
		if(in_array('', $_POST)) {
			$helper->redirect('login.php?action=null');
		}
		$param = array(
			'email' => $_POST['email'],
			'password' => $_POST['password']
		);
		$data = $helper->strip_data($param);
		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$helper->redirect('login.php?action=invalid');
			exit();
		}
		if($hcp->login($data)) {
			$helper->redirect('index.php');
			exit();
		} else {
			$helper->redirect('login.php?action=failed');
		}
		exit();
	}
	//
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == "true") {
		if($hcp->logout()) {
			$helper->redirect('login.php');
		}
		exit();
	}
	//
	if(isset($_REQUEST['resetpassword']) && $_REQUEST['resetpassword'] == "true") {
		if(!empty($_REQUEST['email'])) {
			if(filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
				//request password reset
				//$hcp->resetPassword($email);
				echo "Processing password reset"; 
			} else {
				echo "invalid email";
			}
		} else {
			echo "null values";
		}
		exit();
	}
	//
	if(isset($_POST['savesettings']) && $_POST['savesettings'] == "true") {
		if(in_array('', $_POST)) {
			echo "<script>alert('Please type your password');</script>";
			$helper->redirect('index.php');
			exit();
		}
		$param = array(
			'newpassword'=>$_POST['newpassword'],
			'confirmpassword'=>$_POST['confirmpassword']
		);
		$data = $helper->strip_data($param);
		$resp = $hcp->changePassword($_SESSION['hcp']['uid'], $data['newpassword']);
		if($resp != false) {
			echo "<script>alert('Password updated successfully');</script>";
			$helper->redirect('index.php');
		}
		else {
			echo "<script>alert('Sorry failed to update your password');</script>";
			$helper->redirect('index.php');
		}
	}
	//
	if(isset($_REQUEST['search']) && $_REQUEST['search'] == "true") {
		if(empty($_REQUEST['term'])) {
			echo "<div class='alert-notify'><i class='fa fa-warning'></i> Please type something!</div>";
			exit();
		}
		else {
			$param = array('term' => $_REQUEST['term']);
			// print_r($param); exit();
			$data = $helper->strip_data($param);
			/*$response['response'] = $hcp->searchPatients($data);
			echo json_encode($response);*/
			$response = $hcp->searchPatients($data['term']);
			sleep(1);
			if($response != 0) { ?>
				<div class="searched">Searching for: <?php echo $data['term']; ?></div>
		<?php foreach ($response as $row) : ?>
				<div class="search-result" onclick="editPatient('edit', <?php echo $row->idnumber; ?>)">
					<?php
						$row->lastname = str_ireplace($data['term'], '<i style="background-color:tomato;color:#fff">'.$data['term'].'</i>', $row->lastname); //highlight searched word with color
						$row->idnumber = str_ireplace($data['term'], '<i style="background-color:tomato;color:#fff">'.$data['term'].'</i>', $row->idnumber);
						$icon = ($row->gender=="male") ? 'fa-male' : 'fa-female'; //display appropriate icon, according to gender
					?>
					<div class="title-name"><?php echo $row->firstname.' '.ucfirst($row->lastname); ?></div>
					<div><i class="fa fa-id-card"></i> <?php echo $row->idnumber; ?></div>
					<div><i class="fa <?php echo $icon; ?>"></i> <?php echo ucfirst($row->gender); ?></div>
					<div><i class="fa fa-phone"></i> <?php echo $row->telephone; ?></div>
					<div><i class="fa fa-envelope"></i> <?php echo $row->email; ?></div>
				</div>
	<?php
				endforeach;
			}
			else {
				echo "<div class='alert-notify'><i class='fa fa-warning'></i> Sorry No Match Found!</div>";
			}
			exit();
		}
	}

	//
	if(isset($_REQUEST['filter']) && $_REQUEST['filter'] == "true") {
		// sleep(1);
		$param = array('filterterm' => $_REQUEST['filterterm']);
		$data = $helper->strip_data($param);
		$searchResults = $hcp->searchPatients($data['filterterm']);
		if($searchResults != false) {
			foreach($searchResults as $row) : ?>
			<tr>
				<td><?php echo $row->idnumber; ?></td>
				<td><?php echo $row->firstname; ?></td>
				<td><?php echo $row->lastname; ?></td>
				<td><?php echo ucfirst($row->gender); ?></td>
				<td><?php echo $row->dob; ?></td>
				<td><?php echo $row->telephone; ?></td>
				<td><?php echo $row->email; ?></td>
				<td><?php echo $row->address; ?></td>
				<td>
					<button type="button" class="btn" onclick="editPatient('edit', <?php echo $row->idnumber; ?>)" name="update"><i class="la la-edit"></i> Update</button>
				</td>
			</tr>
	<?php 	endforeach;
		} 
		else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> Sorry no match available.</div></td></tr>
	<?php 	} 
	}
	//
	if(isset($_REQUEST['filterby']) && $_REQUEST['filterby'] == "true") {
		if(empty($_REQUEST['date'])) {
			echo '<tr><td colspan="9"><div class="alert-notify"><i class="fa fa-warning"></i> Please provide valid date.</div></td></tr>';
			exit();
		}
		$date = date('Y-m-d', strtotime($_REQUEST['date'])); #convert date to match DB date format.
		/*if(preg_match('/^[0-9]+$/', $date)) {
			exit("<tr><td colspan='9'><div class='alert-notify'><i class='fa fa-warning'></i> Invalid Date Format (dd/mm/yyyy)</div></td></tr>");
		} else {*/
			$filtered = $hcp->filterAppointments($date);
			if($filtered != false) {
				foreach($filtered as $data): 
					$row = $admin->getPatientById($data->idnumber);
					$status = ($data->status=="1") ? 'Active' : ($data->status=="0" ? 'Cancelled' : 'Seen');
			?>
				<tr>
					<td><?php echo $row->firstname; ?></td>
					<td><?php echo $row->lastname; ?></td>
					<td><?php echo ucfirst($row->gender); ?></td>
					<td><?php echo $row->telephone; ?></td>
					<td><?php echo $row->email; ?></td>
					<td><?php echo date('D, d M Y', strtotime($data->app_date)); ?></td>
					<td><?php echo date('g:i A', strtotime($data->app_time)); ?></td>
					<td><?php echo $status; ?></td>
					<td>
						<button type="button" class="btn danger" name="update" onclick="cancelApp(<?php echo $row->idnumber; ?>, '<?php echo $data->app_date; ?>')" <?php ($data->status=="0"||$data->status=="2") ? print'disabled' : print''; ?> ><i class="la la-times"></i></button>
						<button type="button" class="btn success" title="Confirm Seen" onclick="confirmSeen(<?php echo $row->idnumber; ?>, '<?php echo $data->app_date; ?>')" <?php ($data->status=="0"||$data->status=="2") ? print'disabled' : print''; ?>><i class="la la-check"></i>
						</button>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="9"><div class="alert-notify"><i class="fa fa-info-circle"></i> No appointments available.</div></td></tr>
	  <?php } 
		#}
		exit();
	}
	//
	if(isset($_REQUEST['addnew']) && $_REQUEST['addnew'] == "true") {
		if(in_array('', $_REQUEST)) {
			$helper->redirect('index.php?action=failed');
			exit('Please type all required fields');
		}
		$data = array(
			'idnumber' => $_REQUEST['idNumber'],
			'firstname' => $_REQUEST['firstname'],
			'lastname' => $_REQUEST['lastname'],
			'gender' => $_REQUEST['gender'],
			'telephone' => $_REQUEST['telephone'],
			'dob' => $_REQUEST['dob'],
			'email' => $_REQUEST['email'],
			'address' => nl2br($_REQUEST['address'])
		);
		$params = $helper->strip_data($data);
		// print_r($params); exit();
		if($hcp->createNew($params)) {
			$helper->redirect('index.php?action=success');
			exit();
		}
		else {
			$helper->redirect('index.php?action=failed');
			exit();
		}
	}

	//
	if(isset($_REQUEST['savedit']) && $_REQUEST['savedit'] == "true") {
		if(in_array('', $_REQUEST)) {
			$helper->redirect('index.php?action=invalid');
			exit('Please type all required fields');
		}
		$data = array(
			'idnumber' => $_REQUEST['idnumber'],
			'firstname' => $_REQUEST['firstname'],
			'lastname' => $_REQUEST['lastname'],
			'gender' => $_REQUEST['gender'],
			'telephone' => $_REQUEST['telephone'],
			'dob' => $_REQUEST['dob'],
			'email' => $_REQUEST['email'],
			'address' => nl2br($_REQUEST['address'])
		);
		$params = $helper->strip_data($data);
		// print_r($params); exit(); #test data is received
		if($hcp->saveEditPatient($params)) {
			$helper->redirect('index.php?action=success');
			exit();
		}
		else {
			exit();
			$helper->redirect('index.php?action=failed');
		}
		exit();
	}

	//
	if(isset($_REQUEST['lookup']) && $_REQUEST['lookup'] == "true") {
		$term = htmlentities(strip_tags(trim($_REQUEST['patient'])));
		if(!empty($term)) {
			$response = $hcp->searchPatients($term);
			if($response != 0) {
				foreach($response as $resp) :
		?>
					<div class='resp-item' onclick="pasteData(
					'<?php echo $resp->idnumber; ?>', '<?php echo $resp->firstname.' '.$resp->lastname; ?>',
					' <?php echo $resp->address; ?>', '<?php echo $resp->email; ?>', '<?php echo $resp->telephone; ?>');">
						<?php echo $resp->idnumber.', '.$resp->firstname.' '.$resp->lastname; ?>
					</div>
		<?php	endforeach;
			}
			else {
				echo "<div><i class='fa fa-warning'></i> No Match Found!</div>";
			}
		}
		else {
			echo "<div><i class='fa fa-warning'></i> Please type something!</div>";
		}
		exit();
	}
	//
	if(isset($_REQUEST['sendbill']) && $_REQUEST['sendbill'] == "true") {
		//
		if(empty($_REQUEST['idnumber'])) {
			exit("Please provide patient details!");
		}
		if(!preg_match('/^[0-9]+$/', $_REQUEST['idnumber'])) {
			exit("Please provide patient details!");
		}
		$_REQUEST['invnumber'] = str_ireplace('#', '', $_REQUEST['invnumber']);
		$status = ($_REQUEST['payment_type'] == "CCard") ? '1' : '0'; //if creditCard set as paid, else as pending
		//
		$invoiceArr = array(
			"patient" => array(
					'idnumber' => $_REQUEST['idnumber'],
					'fullnames' => $_REQUEST['fullnames'],
					'address' => $_REQUEST['address'],
					'email' => $_REQUEST['email'],
					'telephone' => $_REQUEST['telephone'],
					'invnumber' => $_REQUEST['invnumber'],
					'invdate' => $_REQUEST['invdate'],
					'payment_type' => $_REQUEST['payment_type'],
					'status' => $status /*depents on type of payment sumitted by FORM*/
			),
			"items" => array(
					'item1' => $_REQUEST['item1'],
					'qty1' => $_REQUEST['qty1'],
					'price1' => $_REQUEST['price1'],

					'item2' => $_REQUEST['item2'],
					'qty2' => $_REQUEST['qty2'],
					'price2' => $_REQUEST['price2'],

					'item3' => $_REQUEST['item3'],
					'qty3' => $_REQUEST['qty3'],
					'price3' => $_REQUEST['price3'],
					'totaldue' => $_REQUEST['totaldue']
			)
		);

		//invoice file location
		$basepath = $basepath."invoices/";
		//get invoice number from array collection
		$invoiceId = $invoiceArr['patient']['invnumber'];
		$filename = $invoiceId.'.json';
		$invoice_data = json_encode($invoiceArr);
		//create directory if not exists
		if(!is_dir($basepath)) {
			mkdir($basepath); 
		}
		//create an invoice file inside directory
		try {
			$fp = fopen($basepath.$filename, 'w');
			fwrite($fp, $invoice_data); //write data to file created
			fclose($fp);
		} catch(Exception $e) {
			echo "Error: ".$e->getMessage(); //catch any error thrown on opening and writing of invoice data
		}

		$items = $invoiceArr['items']['item1'].', '.$invoiceArr['items']['item2'].', '.$invoiceArr['items']['item3'];
		$qty = ((int)$invoiceArr['items']['qty1']+(int)$invoiceArr['items']['qty2']+(int)$invoiceArr['items']['qty3']);

		$params = array(
			'invid' => $invoiceArr['patient']['invnumber'],
			'idnumber' => $invoiceArr['patient']['idnumber'],
			'items' => $items,
			'qty' => $qty,
			'totalamount' => $invoiceArr['items']['totaldue'],
			'paytype' => $invoiceArr['patient']['payment_type']
		);
		
		if($hcp->saveInvoice($params)) {
			echo "<script>alert('Invoice sent successfully!')</script>";
			$helper->redirect('index.php?action=success');
		}
		else {
			echo "<script>alert('Failed to sent invoice data')</sscript>";
			$helper->redirect('index.php?action=failed');
		}
		exit();
	}

	if(isset($_REQUEST['checkslot']) && $_REQUEST['checkslot'] == "true") {
		$date = $helper->strip_data(['slot'=>$_REQUEST['dateslot']]); //call method to clean form data
		if(!empty($date['slot'])) {
			$date['slot'] = date('Y-m-d', strtotime($date['slot'])); //format the date
			if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2]{2})-(0[1-9]|[1-2][0-9]|3[0-1]{2})$/', $date['slot'])) {
				echo "<div class='danger'>Invalid date format (yyyy/mm/dd/)</div>"; //if invalid date method show error
				exit();
			}
			$allSlots = $admin->checkAvailability($date['slot']); //call method, pass date as parameter, to return booked slots for that date
			if(empty($allSlots)) {
				echo "dayopen"; //if date/day has no bookings. 
			} else {
				//else loop through the return results from method and display booked Times for the day.
				foreach($allSlots as $time) :
					echo "<div class='danger'>".date('H:i A', strtotime($time->daytime))." &rarr; Booked</div>";
				endforeach;
			}
		}
		exit();
	}

	if(isset($_REQUEST['bookdate']) && $_REQUEST['bookdate'] == "true") {
		$pid = $_REQUEST['idnumber']; #get patient ID number
		$appdate = $_REQUEST['appdate']; #get appointment date
		$apptime = $_REQUEST['apptime']; #get appointment time
		if(in_array('', $_REQUEST)) {
			$message = "Please provide all required fields.";
		}
		else {
			$params = array(
				'uid' => $pid,
				'appdate' => date('Y-m-d', strtotime($appdate)), #format the date
				'apptime' => $apptime
			);
			if($admin->bookAppointment($params)) {
				$message = "success"; //if appointment save, method returns boolen value of true.
			}
			else {
				$message = "failed"; //else if returns false
			}
		}
		echo $message;
		exit();
	}

	if(isset($_REQUEST['confirmApp']) && $_REQUEST['confirmApp'] == "true") {
		if(in_array('', $_REQUEST)) {
			echo "<div class='alert-notify danger'>Missing patient Id Of appointment!";
			exit();
		}
		$pid = $_REQUEST['pid']; #get patient Id submitted by form
		$appdate = $_REQUEST['app_date'];
		if($hcp->confirmAppointment($pid, $appdate)) {
			echo "<div class='alert-notify sucess'>Appointment Confirmed As Seen!</div>";
		}
		else {
			echo "<div class='alert-notify danger'>Sorry Failed to Confirmed Appointment!</div>";
		}
		exit();
	}
	//
	if(isset($_REQUEST['cancelApp']) && $_REQUEST['cancelApp'] == "true") {
		if(in_array('', $_REQUEST)) {
			echo "<div class='alert-notify danger'>Missing patient Id of appointment!";
			exit();
		}
		$pid = $_REQUEST['pid']; //patient Id number
		$appdate = $_REQUEST['app_date'];
		if($hcp->cancelAppointment($pid, $appdate)) {
			echo "<div class='alert-notify sucess'>Appointment Cancelled successfully!</div>";
		}
		else {
			echo "<div class='alert-notify danger'>Sorry Failed to Cancel Appointment!</div>";
		}
		exit();
	}
	//handles requests for appointments
	if(isset($_REQUEST['reminder']) && $_REQUEST['reminder'] == "true") {
		//retrieve all appointments for the current day
		$alert['alertdata'] = $hcp->getAlerts();
		//if recieved data greater than zero
		if($alert['alertdata']) {
			//pass patientID Number to method, to return patient details
			$data['patientdata'] = $admin->getPatientById($alert['alertdata']->idnumber);
			$startIn = strtotime(date('h:i')); #current time
			$endIn = strtotime(date('h:i', strtotime($alert['alertdata']->app_time) )); #appointment time from database
			$diff = ($endIn - $startIn) / 60; #subtract current-time from appointment-time, and display remaining divide by 60 to get minutes
			//now get minutes left between 30mins of appointment-time
			if($diff > 0 && $diff <= 30) {
				$timelapse = $diff; #assign time-left value
			}
			else {
				$timelapse = 0; #else assign zero
			}
			//get patients details like Firstname and Lastname, using idNumber from appointments
			$response = array(
				'fullname' => $data['patientdata']->firstname .' '. $data['patientdata']->lastname,
				'idnumber' => $alert['alertdata']->idnumber,
				'appdate' => $alert['alertdata']->app_date,
				'apptime' => date('H:i A', strtotime($alert['alertdata']->app_time)),
				'timeleft' => $timelapse //pass minutes left into array
			);
		}
		else {
			$response = 0; #else assign zero response value
		}
		echo json_encode($response); //finally encode/convert data into JSON format
		exit();
	}

	//handles requests for automatically sending birthday wishes.
	if(isset($_REQUEST['wishes']) && $_REQUEST['wishes'] == "true") {
		$hcp->sendAppointmentReminder(); //function will be called only once, to send reminder since this will run once in a day.
		if($notify->composeCardWishes() == "success") {
			echo "success";
		}
		else {
			echo "failed";
		}
		exit();
	}

	//read all database backup log files
	if(isset($_REQUEST['getlogs']) && $_REQUEST['getlogs'] == "true") {
		$results = $helper->retrieveLogs();
		rsort($results);
		echo '<p><a href="javascript:runAction(\'backups\')" class="btn-link" title="Go back"><i class="fa fa-arrow-left"></i> Back</a></p>';
		echo"<h1 class='header'><i class='fa fa-database'></i> Backup Logs</h1>";
		echo'<div class="logs">';
		if(count($results) > 0) {
	?>
			<div class="log-head">
				Available Logs:
			</div>
		<?php foreach($results as $log) : ?>
			<div class="log-item" title="Click to open" onclick="runAction('readlog','<?php echo $log; ?>')"><i class="fa fa-file"></i> <?php echo $log; ?></div>
		<?php endforeach;
		}
		else {
			echo "<div class='log-notify'><i class='fa fa-warning'></i> No backup logs available!</div>";
		}
			echo"</div>";
	}
	//handles request for reading a backup file log.
	if(isset($_REQUEST['readlog']) && $_REQUEST['readlog'] == "true") {
		$filename = $_REQUEST['filename'];
		$response = $helper->readLog($filename);
		echo '<p><a href="javascript:runAction(\'getbackuplogs\')" class="btn-link" title="Go back"><i class="fa fa-arrow-left"></i> Back</a></p>';
		echo"<h1 class='header'><i class='fa fa-file'></i> Viewing Log File</h1>";
		if($response) {
			echo "<div class='log-view'>".$response."</div>";
		} else {
			echo "<div>File Empty!</div>";
		}
		exit();
	}

	//handles request for backup downloads
	if(isset($_REQUEST['download']) && $_REQUEST['download'] == "true") {
		$filename = $hcp->downloadBackup(); //call method to return file object for backup download
	}

	//handles request for restoring database from backups
	if(isset($_REQUEST['restore']) && $_REQUEST['restore'] == "true") {
		$dirpath = "../backups/";
		//restore DB, get filename,
		$filename = stripslashes(strip_tags(trim($_REQUEST['filename'])));
		//create full path from DirectoryFolder and Filename
		$fullpath = $dirpath.$filename;
		//check if directory exists
		if(is_dir($dirpath)) {
			if(file_exists($fullpath)) {
				$queries = file($fullpath);
				//process file, extract file data into database tables
				$backup = new Backup();
				$query = '';
				foreach($queries as $line) :
					$startWith = substr(trim($line), 0 ,2);
					$endWith = substr(trim($line), -1 ,1);
					if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
						continue;
					}
					$query = $query . $line;
					if ($endWith == ';') {
						$response = $backup->doRestoreDatabase($query);
						$query='';
					}
				endforeach;
				if($response=="success") {
					echo "<div class='alert-notify success'><i class='fa fa-check'></i> Database restore ".ucfirst($response)."!</div>";
				} else {
					echo "<div class='alert-notify success'><i class='fa fa-warning'></i> Database restore ".ucfirst($response)."!</div>";
				}
			}
			else {
				echo "File does not exits!";
			}
		}
		else {
			echo "Invalid directory path!";
		}
		exit();
	}
	//handles server backup file upload
	if(isset($_REQUEST['upload']) && $_REQUEST['upload'] == "true") {
		define('__DIRPATH__', "backups/"); //define directory
		$fileupload = (!empty($_FILES['files']['name'])) ? $_FILES['files']['name'] : null;
		$file_info = explode('.', $fileupload);
		$file_ext = end($file_info);
		$file_ext = strtolower($file_ext); //get file extension
		$allowed_file_ext = array('sql'); //set allowed file extension
		if(!in_array($file_ext, $allowed_file_ext)) {
			unlink($_FILES['files']['tmp_name']); //delete temp file if upload failure 
			echo  "File Invalid: file is not (.sql).";
			exit();
		}
		else {
			//upload file to directory path
			if(move_uploaded_file($_FILES['files']['tmp_name'], $basepath.__DIRPATH__.$fileupload)) {
				echo "File uploaded successfully!...";
			} else {
				echo "Failed to upload file!";
			}
		}
		exit();
	}

	if(isset($_REQUEST['deleteBackups']) && $_REQUEST['deleteBackups'] = "true") {
		$fullpath = $basepath.'backups/';
		$allfiles = scandir($fullpath); //scan directory for all existing files
		foreach($allfiles as $file) :
			if(!is_dir($file)) {
				unlink($fullpath.$file); //delete every file in directory
			}
		endforeach;
		echo "<div class='alert-notify success'><i class='fa fa-check'></i> Deleted All database backups successfully!</div>";
		exit();
	}

	//handles request to display HTML Form to compose new message
	if(isset($_REQUEST['compose']) && $_REQUEST['compose'] == "true") {
	?>
		<div class="compose-form">
			<div class="form-title">Compose New Message</div>
			<form action="POST" name="compose" method="POST" enctype="application/www-forms-urlencoded">
				<div class='alert-error danger'><i class='fa fa-warning'></i> Please type all fileds are required!</div>
				<div>
					<i class="fa fa-user msg-icon"></i>
					<input type="text" name="sent_to" id="sent_to" class="form-control" placeholder="Enter receipient">
				</div>
				<div>
					<i class="fa fa-font msg-icon"></i>
					<input type="text" name="subject" id="msg_subject" class="form-control" placeholder="Enter Message Subject">
				</div>
				<div>
					<i class="fa fa-edit msg-icon"></i>
					<textarea name="message_body" value="" id="message_text" rows="12" class="form-control" placeholder="Type your message here..."></textarea>
				</div>
				<div>
					<button type="button" class="btn " name="send" value="true" onclick="runAction('sendMsg')">Send Message</button>
				</div>
			</form>
		</div>
	<?php
	}
	//handles request form data, hcp sending a message.
	if(isset($_REQUEST['sendMessage']) && $_REQUEST['sendMessage'] == "true") {
		if(in_array('', $_REQUEST)) {
			echo "<div class='alert-error danger'><i class='fa fa-warning'></i> Please type all fileds are required!</div>";
		}
		else {
			$body = $_REQUEST['subject']."<br/>".nl2br(htmlentities($_REQUEST['msg_body']));
			$data = array(
				'id' => 'admin_'.$helper->tokenize(),
				'message' => $body,
				'sent_from' => "doctor@besthealth.com",
				'sent_to' => $_REQUEST['sent_to']
			);
			if($notify->sendMessage($data)) {
				echo "<div class='alert-notify success'><i class='fa fa-check'></i> Message sent successfully!</div>";
			}
			else {
				echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Failed to send message!</div>";
			}
		}
		exit();
	}
	//handles retrieving new inbox messages
	if(isset($_REQUEST['retrieveInbox']) && $_REQUEST['retrieveInbox'] == "true") {
		$allinbox = $notify->unreadMessages('doctor@besthealth.com');
		if($allinbox != false) {
		foreach($allinbox as $inbox) :
			$item->message = (in_array(array('.png','.jpg','.gif'), $item->message)) ? '<span class="body_obj"></span> '.$item->message : $item->message;
	?>
			<li class="message-item">
				<div class="item-timestamp strong"><?php echo date('g:i', strtotime($inbox->created)); ?></div>
				<div class="item-sender strong"><?php echo $inbox->message; ?></div>
				<div class="item-text"><?php echo $inbox->message; ?></div>
			</li>
	<?php
		endforeach;
		} else {
			echo "<div class='alert-notify'><i class='fa fa-info-circle'></i> No New Messages!</div>";
		}
		exit();
	}
	//handles retireving of all old and new messages.
	if(isset($_REQUEST['retrieveAll']) && $_REQUEST['retrieveAll'] == "true") {
		$allMsg = $notify->readAllMessages('doctor@besthealth.com');
		if($allMsg != false) {
		foreach($allMsg as $item) :
			$item->message = (in_array(array('.png','.jpg','.gif'), $item->message)) ? '<span class="body_obj"></span> '.$item->message : $item->message;
	?>
			<li class="message-item">
				<div class="item-timestamp"><?php echo date('g:i', strtotime($item->created)); ?></div>
				<div class="item-sender"><?php echo $item->message; ?></div>
				<div class="item-text"><?php echo $item->message; ?></div>
			</li>
	<?php
		endforeach;
		} else {
			echo "<div class='alert-notify'><i class='fa fa-info-circle'></i> No Messages!</div>";
		}
		exit();
	}
	//handle request to get birthday for the current months
	if(isset($_REQUEST['getbirthdays']) && $_REQUEST['getbirthdays'] == "true") {
		$birthdays = $notify->getBirthdays();
		if($birthdays != false) {
			foreach($birthdays as $birthday) :
				$row = $hcp->getPatientById($birthday->idnumber);
	?>
			<li class="message-item">
				<div class="item-timestamp strong"><?php echo date('g:i', strtotime($birthday->created)); ?></div>
				<div class="item-sender strong">Upcoming Birthday</div>
				<div class="item-text">
					Upcoming birthday for <?php echo $row->firstname.' '.$row->lastname; ?>
					on <?php echo date('D, d F', strtotime($row->dob)); ?>		
				</div>
			</li>
	<?php
			endforeach;
		} else {
			echo "<div class='alert-notify'><i class='fa fa-info-circle'></i> No birthdays for this month!</div>";
		}
		exit();
	}

?>