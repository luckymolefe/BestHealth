<?php
	//admin controller script
	$root = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($root.'bootstrap.php');

	//handling admin login
	if(isset($_POST['login']) && $_POST['login'] == "true") {
		$param = array(
			'username' => $_POST['username'],
			'password' => $_POST['password']
		);
		$data = $helper->strip_data($param); #clean data
		if(!empty($data['username']) && !empty($data['password'])) {
			if($admin->login($data)) {
				header("Location: index.php");
				exit();
			}
			else {
				header("Location: login.php?action=unsuccessful");
				exit();
			}
		}
	}
	//handles requests on Admin updates password
	if(isset($_POST['savepassword']) && $_POST['savepassword'] == "true") {
		//Check for empty array value submission
		if (in_array('', $_POST)) {
			$helper->redirect('index.php?action=invalid');
			exit();
		}
		$param = ['newpassword'=>$_POST['newpassword'], 'confirmpassword'=>$_POST['confirmpassword']];
		$data = $helper->strip_data($param);
		if($data['newpassword'] != $data['confirmpassword']) {
			//Password do not match
			$helper->redirect('index.php?action=unmatch');
			exit();
		}
		if($admin->updatePassword($_SESSION['admin']['uid'], $data['newpassword'])) {
			//Success
			$helper->redirect('index.php?action=passmatch');
			exit();
		}
		else {
			//Failed
			$helper->redirect('index.php?action=passfail');
			exit();
		}
		
	}
	//handles admin logout
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == "true") {
		if($admin->logout()) {
			header('Location: login.php');
			exit();
		}
	}
	//handles adding new patient
	if(isset($_POST['addnew']) && $_POST['addnew'] == "true") {
		if(in_array('', $_POST)) {
			header("Location: index.php?action=invalid");
			exit();
		}
		$params = array(
			'firstname' => $_POST['firstname'],
			'lastname'  => $_POST['lastname'],
			'gender'  => $_POST['gender'],
			'idnumber'  => $_POST['idNumber'],
			'dob' => $_POST['dob'],
			'email'  => $_POST['email'],
			'telephone'  => $_POST['telephone'],
			'address'  => nl2br($_POST['address'])
		);
		$data = $helper->strip_data($params);
		// print_r($data); exit(); #test if we get all formdata
		if($admin->addNew($data)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();

		}
	}
	//
	if(isset($_REQUEST['savedit']) && $_REQUEST['savedit'] == "true") {
		if(in_array('', $_POST)) {
			header("Location: index.php?action=invalid");
			exit();
		}
		$params = array(
			'idnumber'  => $_POST['idnumber'],
			'firstname' => $_POST['firstname'],
			'lastname'  => $_POST['lastname'],
			'gender'  => $_POST['gender'],
			'dob' => $_POST['dob'],
			'email'  => $_POST['email'],
			'telephone'  => $_POST['telephone'],
			'address'  => nl2br($_POST['address'])
		);
		$data = $helper->strip_data($params);
		if($admin->saveEdit($data)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();

		}
	}
	//get full months
	if(isset($_REQUEST['getmonths']) && $_REQUEST['getmonths'] == "true") {
		$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
						'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
		$count = 1;
	?>
		<table class="months-table">
			<tr>
			<?php foreach($months as $month): ?>
			<?php $selector = (date('m') == $count) ? 'current-month' : ''; ?>
			<?php $monthCount = ($count >= date('m')) ? 'onclick="pickMonth(this)"' : ''; #log: added new line to control clickable, previous and coming months ?>
			<?php $disabled = ($count < date('m')) ? ' disabled-month ' : ''; #log: added this new line of code ?>
				<?php  if($count%4==0) { ?>
					<td <?php echo $monthCount; ?> class="<?php echo $selector.$disabled; ?>" data-month="<?php echo $count; ?>"><?php echo $month; ?></td>
					</tr>
					<tr>
				<?php  } else { ?>
					<td <?php echo $monthCount; ?> class="<?php echo $selector.$disabled; ?>" data-month="<?php echo $count; ?>"><?php echo $month; ?></td>
				<?php  } ?>
			<?php $count++;  endforeach; ?>
			</tr>
		</table>
	<?php
		exit();
	}

	//get time slots for selected date
	if(isset($_GET['getSlots']) && $_GET['getSlots'] =="true") {
		//array to hold time slots
		$slots = array('09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00');
		$bookdate = $_GET['bookdate']; #get date value
		?>
		<input type="search" name="idnumber" class="form-input" id="idNum" onkeyup="searchUser(this.value)"  placeholder="Enter ID Number/Lastname">
		<div id="search-results"></div>
		<button type="button" class="btn-search" onclick="searchUser($('#idNum').value)">Search</button>
		<input type="hidden" id="uid" value="" readonly="readonly" />
		
		<div id='client_detials'></div>
		<div class="picked_date"><?php echo date('D d, F Y', strtotime($bookdate));#format and display date selected ro booking ?></div>

	<?php
		$available = $admin->checkAvailability($bookdate); //if book time appear in table, then get all booked times
		if(count($available) > 0) {
			$arrTimes = array();
			for($i=0; $i < count($available); $i++) {
				$arrTimes = $available[$i]->app_time; //get all times and create new array
			}
		} else { $arrTimes=0; } //if not available set to zero

		foreach($slots as $booktimes) :
			$disabled = ( substr($booktimes, 0, 2) == $arrTimes ) ? 'disabled' : ''; //if  times match, then set button as disabled
			$datatransfer = json_encode(array('date'=>$bookdate, 'time'=>$booktimes));
	?>
		<button class="time-select" <?php echo $disabled; ?> onclick='router("gettime", <?php echo $datatransfer; ?>);'>
			<?php echo date('H:i A', strtotime($booktimes)); ?>
		</button>
	<?php
		endforeach;
		echo "<button style='background-color:transparent' class='time-select'>&nbsp;</button>";
	}
	//handles request after user pick appointment time 
	if(isset($_REQUEST['book']) && $_REQUEST['book'] == "true") {
		if(in_array('', $_REQUEST)) {
			echo "<div class='alert danger'><i class='fa fa-warning'></i> Invalid submission: Missing patient details.</div>";
			exit();
		}
		$data = array(
			'uid'  => $_REQUEST['idnumber'],
			'appdate' => $_REQUEST['bookdate'],
			'apptime' => $_REQUEST['booktime']
		);
		if($admin->isAppActive($data)) {
			echo "<div class='alert danger'><i class='fa fa-warning'></i> Sorry this patient has an active appointment!.</div>";
			exit();
		}
		if($admin->bookAppointment($data)) {
			echo "<div class='alert success'><i class='fa fa-info-circle'></i> Appointment Booked Successfully!</div>";
		}
		else {
			echo "<div class='alert danger'><i class='fa fa-warning'></i> Failed to save</div>";
		}
	}

	if(isset($_REQUEST['update']) && $_REQUEST['update'] == "true") {
		$invoiceId = intval($_REQUEST['invid']);
		// echo "You submitted this invoice number: ".$invoiceId;
		if($admin->updateInvoice($invoiceId)) {
			echo "<div class='alert-notify success'><i class='fa fa-check'></i> Invoice updated successfully!</div>";
		}
		else {
			echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Failed to update invoice, please try again!</div>";
		}
	}
	//
	if(isset($_REQUEST['search']) && $_REQUEST['search'] == "true") {
		if(!in_array('', $_REQUEST)) {
			$params = array('uid' => $_REQUEST['uid']);
			$data = $helper->strip_data($params);
			$response = $admin->searchPatients($data['uid']);	
			$jasondata['patient'] = $response;
		} else {
			$jasondata['patient'] = 0;
		}
		echo json_encode($jasondata); //encode array response into json format
		exit();
	}

	if(isset($_REQUEST['cancel_app']) && $_REQUEST['cancel_app'] == "true") {
		if(in_array('', $_REQUEST)) {
			echo "<div class='alert danger'><i class='fa fa-warning'></i> Missing patient id number or appointment date!.</div>";
			exit();
		}
		$param = array(
				'pid' => $_REQUEST['idnumber'],
				'appdate' => $_REQUEST['app_date']
			);
		$response = $admin->cancelAppointment($param['pid'], $param['appdate']);
		if($response == true) {
			echo "<div class='alert success'><i class='fa fa-info-circle'></i> Appointment Cancelled Successfully!</div>";	
		}
		else {
			echo "<div class='alert danger'><i class='fa fa-warning'></i> Failed to cancel appointment.</div>";
		}
		exit();
	}

	if(isset($_REQUEST['checkBirthdays']) && $_REQUEST['checkBirthdays'] == "true") {
		/*$jasondata['test'] = "<li class='message-item'>Hello from server</li>";
		echo json_encode($jasondata);*/
		// echo "<li class='message-item'>Hello from server</li>"; 
		$reminders = $notify->getBirthdays();
		if($reminders != false) {
			foreach ($reminders as $reminder) :
	?>
				<li class='message-item'>
					<div class="item-title">Upcoming Birthday
						<span class="item-time">09:05</span>
					</div>
					<div class="item-text">
						Upcoming birthday for <?php echo $reminder->firstname.' '.$reminder->lastname; ?>
						on <?php echo date('D, d F', strtotime($reminder->dob)); ?>
					</div>
				</li> 
  <?php 
			endforeach;
		} else {
?>
			<li class='message-item'><div class="alert info"><i class="fa fa-info-circle"></i> No upcoming birthdays yet!</div></li>
<?php
		}
		exit();
	}

	//
	if(isset($_REQUEST['allmessages']) && $_REQUEST['allmessages'] == "true") {
		$allmessages = $notify->readAllMessages('admin@besthealth.com');
		if($allmessages != false) {
			foreach($allmessages as $message) :
				$opened = ($message->status=="1") ? 'seen': '';
?>
				<li class='message-item <?php echo $opened; ?>' onclick="getNotification('openmessage', '<?php echo $message->created; ?>')">
					<div class="item-title">
						<?php echo $message->sent_from; ?>
						<span class="item-time"><?php echo date('G:i a', strtotime($message->created)); ?></span>
					</div>
					<div class="item-text">
						<?php echo $message->message; ?>
					</div>
				</li> 
<?php
			endforeach;
		} else {
?>
			<li class='message-item'><div class="alert info"><i class="fa fa-info-circle"></i> No messages available!</div></li>
<?php
		}
	}

	//
	if(isset($_REQUEST['checkunread']) && $_REQUEST['checkunread'] == "true") {
		$allunread = $notify->unreadMessages('admin@besthealth.com');
		if($allunread != false) {
			foreach($allunread as $unread) :
?>
				<li class='message-item' onclick="getNotification('openmessage', '<?php echo $unread->created; ?>')">
					<div class="item-title">
						<?php echo $unread->sent_from; ?>
						<span class="item-time"><?php echo date('G:i a', strtotime($unread->created)); ?></span>
					</div>
					<div class="item-text">
						<?php echo $unread->message; ?>
					</div>
				</li> 
<?php
			endforeach;
		} else {
?>
			<li class='message-item'><div class="alert info"><i class="fa fa-info-circle"></i> No messages available!</div></li>
<?php
		}
	}
	//
	if(isset($_REQUEST['checkseen']) && $_REQUEST['checkseen'] == "true") {
		$allseen = $notify->seenMessages('admin@besthealth.com');
		if($allseen != false) {
			foreach($allseen as $seen) :
?>
				<li class='message-item seen' onclick="getNotification('openmessage', '<?php echo $seen->created; ?>')">
					<div class="item-title">
						<?php echo $seen->sent_from; ?>
						<span class="item-time"><?php echo date('G:i a', strtotime($seen->created)); ?></span>
					</div>
					<div class="item-text">
						<?php echo $seen->message; ?>
					</div>
				</li>
<?php
			endforeach;
		} else {
?>
			<li class='message-item'><div class="alert info"><i class="fa fa-info-circle"></i> No messages available!</div></li>
<?php
		}
	}
	//handles requests for check any alert or notification messages, to display number counted if any available.
	if(isset($_REQUEST['notifycounter']) && $_REQUEST['notifycounter'] == "true") {
		/*header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');*/
		$totalAlerts = (int)($notify->counter('inbox') + (int)$notify->counter('birthdays')) + (int)$notify->counter('reminders');
		$messages = $notify->counter('inbox');
		$reminders = $notify->counter('birthdays');
		$data = array('notify' => $totalAlerts, 'messages' => $messages, 'reminder' => $reminders);
		echo json_encode($data); #send data in JSON Format
		// flush();
		exit();
	}
	//
	if(isset($_REQUEST['viewmessage']) && $_REQUEST['viewmessage'] == "true") {
		$timestamp = $_REQUEST['timestamp']; //catch sent timestamp request
		$view = $notify->viewMessageItem($timestamp); //call method to open message details.
		$colors = array("#3f51b5","#00b8d4","#12c700","#ffab00","#ff4081","#aa00ff","#ff5722");
		shuffle($colors); //pick random color
		$count = count($colors)-1;
		$random = rand(0, $count);
		$name = explode('@', $view->sent_from);
		if($view != false) {
			$notify->updateMessage($view->created); //update message status as viewed.
			?>
			<div class="view-item">
				<div class="view-title">
					<span class="label-icon" style="background-color: <?php echo $colors[$random]; ?>">
						<?php echo strtoupper(substr($view->sent_from, 0,1)); ?></span>
					Best Health<br>
					<div class="title-small">From: <?php echo $view->sent_from; ?></div>
					<span class="view-time"><?php echo date('D d F, G:i a', strtotime($view->created)); ?></span>
					<div class="separator"></div>
				</div>
				<div class="view-text">
					<p>Good day</p>
					<?php echo $view->message; ?>.
					<p class="signature">Best Regards<br/><?php echo ucfirst($name[0]); ?></p>
					<p class="footer">Besthealth &copy; <?php echo date('Y', strtotime($view->created)); ?>.</p>
				</div>
			</div>
			<?php
		}
		 else { ?>
		 	<div class="view-item">
		 		<div class="view-title">
		 			<span class="label-icon" style="background-color: #ff3333;"><i class="fa fa-warning"></i></span>
				 	<div style="color: #ff3333;">Message Open Failure</div>
				 	<div>&nbsp;</div>
				 	<!-- <div class="separator"></div> -->
		 		</div>
		 		<div class="view-text" style="color: tomato;"><i class="fa fa-frown-o"></i> 
		 			An Error Occured:<br> Failed to open this message.<br>If this error persist please report to
		 			 <a href="mailto:admin@besthealth.com">admin@besthealth.com</a>
		 		</div>
		 	</div>
  <?php }
		exit();
	}
?>