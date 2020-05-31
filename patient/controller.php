<?php
	//Patient controller script
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	require_once($basepath.'bootstrap.php');
	
	if(isset($_GET['logout']) && $_GET['logout'] == "true") {
		if($patient->logout()) {
			$helper->redirect('login.php');
		}
		exit();
	}

	if(isset($_POST['login']) && $_POST['login'] == "true") {
		//check if submitted data does not have empty values
		if(in_array('', $_POST)) {
			$helper->redirect('login.php?action=null');
		}
		//package form data in an array
		$param = array(
			'lastname' => $_POST['lastname'],
			'idnumber' => $_POST['idnumber']
		);
		//clean form data, return data as array
		$data = $helper->strip_data($param);
		//now validate form data
		if(!preg_match('/^[a-zA-Z]+$/', $data['lastname'])) {
			$helper->redirect('login.php?action=invalid');
		}
		elseif(!preg_match('/^[0-9]{13}+$/', $data['idnumber'])) {
			$helper->redirect('login.php?action=invalid');
		}
		elseif($patient->checkIDNumber($data['idnumber']) == false) {
			$helper->redirect('login.php?action=nomatch');
		}
		else {
			//finally login
			if($patient->login($data)) {
				$helper->redirect('index.php');
				exit(); #if login is successful, then redirect to index page
			}
			else {
				#else if login failed, then redirect to login
				$helper->redirect('login.php?action=failed');
			}
		}
		exit();
	}

	if(isset($_POST['reset']) && $_POST['reset'] == "true") {
		echo "request password reset for: ".$_POST['email'];
	}

	//
	if(isset($_REQUEST['cancelappointment']) && $_REQUEST['cancelappointment'] == "true") {
		$pid = $_REQUEST['pid'];
		$date = urldecode($_REQUEST['appdate']);

		if(!preg_match('/^[0-9]{13}+$/', $pid)) {
			exit("Invalid id number");
		} elseif(!preg_match('/^([0-9]{4}\-)+([0-9]{2}\-)+([0-9]{2})+$/', $date)) {
			 exit("Invalid Date Format (yyyy-mm-dd)");
		}
		else {
			//failed to update
			if($patient->cancelAppointment($pid, $date)) {
				$helper->redirect('index.php');
			}
		}
		exit();
	}
	
	if(isset($_REQUEST['allmessages']) && $_REQUEST['allmessages'] == "true") {
		$patientId = $_REQUEST['pid'];
		$allmessages = $patient->retrieveAll($patientId);
		if($allmessages != false) {
			foreach($allmessages as $message) :
				$opened = ($message->status=="1") ? 'seen-item': '';
				$seen = ($message->status=="1") ? 'seen': '';
?>
				<li class='message-item <?php echo $opened; ?>' onclick="openInbox('<?php echo $message->created; ?>')">
					<div class="item-title <?php echo $seen; ?>">
						<?php echo $message->sent_from; ?>
						<span class="item-time <?php echo $seen; ?>"><?php echo date('D d F, G:i a', strtotime($message->created)); ?></span>
					</div>
					<div class="item-text <?php echo $seen; ?>">
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
		exit();
	}
	//
	if(isset($_REQUEST['checkunread']) && $_REQUEST['checkunread'] == "true") {
		$patientId = $_REQUEST['pid'];
		$allunread = $patient->retrieveInbox($patientId);
		if($allunread != false) {
			foreach($allunread as $unread) :
?>
				<li class='message-item' onclick="openInbox('<?php echo $unread->created; ?>');">
					<div class="item-title">
						<?php echo $unread->sent_from; ?>
						<span class="item-time"><?php echo date('D d F, G:i a', strtotime($unread->created)); ?></span>
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
		exit();
	}
	//
	if(isset($_REQUEST['checkseen']) && $_REQUEST['checkseen'] == "true") {
		$patientId = $_REQUEST['pid'];
		$allseen = $patient->retrieveSeen($patientId);
		if($allseen != false) {
			foreach($allseen as $seen) :
?>
				<li class='message-item seen-item' onclick="openInbox('<?php echo $seen->created; ?>');">
					<div class="item-title seen">
						<?php echo $seen->sent_from; ?>
						<span class="item-time seen"><?php echo date('D d F, G:i a', strtotime($seen->created)); ?></span>
					</div>
					<div class="item-text seen">
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
		exit();
	}
	//
	if(isset($_REQUEST['reminder']) && $_REQUEST['reminder'] == "true") {
		$pid = $_REQUEST['pid'];
		//call method to retrieve birthdayAlert data
		$jason = $notify->openBirthdayAlerts($pid);
		if($jason != '') {
			$sent_date = ( strtotime(date('Y-m-d ', strtotime($jason->birthday->created))) == strtotime(date('Y-m-d')) ) 
			? 'Today ' : date('D d, M Y g:i A', strtotime($jason->birthday->created));
			$sent_date .= date('g:i A', strtotime($jason->birthday->created));
	?>
			<li class='message-item' onclick="viewCardMessage(<?php echo $pid; ?>);">
				<div class="item-title">
					<?php echo "Best Health"; ?>
					<span class="item-time"><?php echo $sent_date; ?></span>
				</div>
				<div class="item-text birthday-card">
					<div>
						<span class='card-icon'><i class='fa fa-image'></i> Birthday Card</span>
						Birthday message for you...
					</div>
				</div>
			</li>
	<?php } else { ?>
			<li class='message-item'><div class="alert info"><i class="fa fa-info-circle"></i> No notifications available!</div></li>
	<?php }
		exit();
	}
	//handles request to open and view birthday card wishes.
	if(isset($_REQUEST['openNotify']) && $_REQUEST['openNotify'] == "true") {
		$colors = array('#ff81e5', '#ffa620','#f0312e','#7777f6','#00d72c','#ffde00','#7777f6','#53d9e9');
		$pid = $_REQUEST['pid'];
		//call method to retrieve birthdayAlert data
		$jason = $notify->openBirthdayAlerts($pid);
		
		$title = $jason->birthday->title;
		$len = strlen($title);
		#$arr = array();
		#$img = $helper->randBirthdayCard(); //get random birthday card image
		#$row = $admin->getPatientById($pid);
?>
		<div class="card-item">
			<img src="../images/bcards/<?php echo $jason->birthday->card; ?>">
			<div class="card-title">
				<?php for($i=0; $i < $len; $i++) : ?>
				<?php $colorInt = rand(0, count($colors)); ?>
					<span style="color: <?php echo $colors[$colorInt] ?>"><?php echo $title[$i] ?></span>
				<?php endfor; ?>
			</div>
			<div class="card-text">
				Hello <?php echo $jason->birthday->fullname; ?><br/>
				<?php echo $jason->birthday->message; ?><br/>
				<br/>
				<small>BestHealth &copy; <?php echo date('Y', strtotime($jason->birthday->created)); ?></small>
			</div>
		</div>
<?php
		exit();
	}
	//handle request to view messages and notification alerts
	if(isset($_REQUEST['viewitem']) && $_REQUEST['viewitem'] == "true") {
		$timestamp = $_REQUEST['timestamp']; //catch sent timestamp request
		$view = $notify->viewMessageItem($timestamp); //call method to open message details.
		$profile = $patient->readProfile($pid=$view->sent_to); //call method to retrieve patient details, passing patientId
		$gender = (strtolower($profile->gender)=="male") ? 'Mr' : 'Miss'; //check patient gender
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
					<p>Dear <?php echo $gender.' '.$profile->firstname.' '.$profile->lastname ?></p>
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