<?php
	//
	require_once('controller.php');
	$patient->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health | Patient Home</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">

	<style type="text/css">
		body {
			font-family: helvetica, arial;
		}
		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: 250px;
			height: 700px;
			background-color: rgb(40, 120, 159);
			list-style-type: none;
		}
		.sidebar-brand {
			font-weight: bold;
			color: #fff;
			text-align: center;
			margin-bottom: 20px;
		}
		.sidebar-brand > img {
			width: 150px;
			max-width: 100%;
			border-radius: 50%;
			padding: 15px 0;
		}
		.sidebar-item {
			background-color: rgb(9, 73, 102);
			color: #fff;
			text-indent: 5px;
			padding: 10px 0;
			margin-top: 1px;
			border-left: 5px solid rgb(9, 73, 102);
		}
		.sidebar-item:hover {
			background-color: rgb(93, 182, 211);
			cursor: pointer;
			border-left: 5px solid #fff;
		}
		.container {
			display: flex;
			margin-left: 250px;
		}
		.flexbox {
			height: 550px;
			max-height: auto;
			overflow-y: auto;
			flex: 1;
			background-color: #fff;
			/*box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);*/
			padding: 10px;
		}
		.flex1, .flex2, .flex3 {
			display: inline-block;
			width: 300px;
			height: 200px;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			padding: 5px;
			transform: translate(10%, 15%) !important;
			margin: 0 10px 20px 0px;
			text-align: center;
		}

		.flex1:hover, .flex2:hover, .flex3:hover {
			background-color: #f5f5f5;
			cursor: pointer;
		}
		.page-header {
			font-size: 1.3em;
			color: rgb(15, 107, 156);
			border-bottom: thin solid #eee;
			padding: 10px 0;
		}
		.icon {
			font-size: 5em;
			color: #28789f;
			margin-top: 40px;
		}
		.panel-title {
			position: relative;
			top: 30px;
			color:  #28789f;
			font-size: 1.4em;
			/*font-weight: bold;*/
		}
		.alert {
			width: 400px;
			max-width: 100%;
			margin: 0 auto;
			padding: 12px 5px;
			background-color: transparent;
			color: transparent;
			font-weight: bold;
			text-align: center;
			border-radius: 5px;
		}
		.info {
			background-color: #b3e5fc;
			color: #29b6f6;
		}
		.lighter {
			position: absolute;
			left: 19px;
			color: #5af158;
			filter: drop-shadow(1px 1px 4px #5af158);
			font-size: .85em;
			margin: 2px 0 0 0;
		}
		.loader {
			font-size: 1.5em;
			color: #777;
			margin-top: 150px;
		}

	</style>
</head>
<body>
	<audio id="birthdaySong"><source src="../images/birthday-tone.mp3" type="audio/mp3"></audio>

	<div class="sidebar">
		<li class="sidebar-brand">
			<img src="../images/bg_logo.png"/>
		</li>
		<li class="sidebar-item" onclick="router('home');"><i class="fa fa-home"></i> Dashboard</li>
		<!-- <li class="sidebar-item" onclick="router('bookings');"><i class="fa fa-calendar-plus-o"></i> Book Appointment</li> -->
		<li class="sidebar-item" onclick="router('history');"><i class="fa fa-calendar"></i> Appointment History</li>
		<li class="sidebar-item" onclick="router('invoices')"><i class="fa fa-credit-card"></i> My Invoices</li>
		<li class="sidebar-item" onclick="router('notify');"><i class="fa fa-bell-o"></i> Notifications
			<?php if($patient->retrieveInbox($_SESSION['patient']['pid'])) { ?>
			<sup><i class="fa fa-circle lighter"></i></sup></li>
			<?php } ?>
		<li class="sidebar-item" onclick="router('profile')"><i class="la la-user"></i> Account</li>
		<li class="sidebar-item" onclick="router('logout');"><i class="fa fa-power-off"></i> Logout</li>
	</div>

	<div class="container">
		<div class="flexbox">
			<div class="page-header">PATIENT DASHBOARD</div>
			
			<!-- <div class="flex2" onclick="router('bookings');">
				<i class="fa fa-calendar-plus-o icon"></i>
				<div class="panel-title">Book Appointment</div>
			</div> -->
			<div class="flex3" onclick="router('history');">
				<i class="fa fa-calendar icon"></i>
				<div class="panel-title">Appointment History</div>
			</div>
			<div class="flex1" onclick="router('invoices');">
				<i class="la la-credit-card icon"></i>
				<div class="panel-title">My Invoices</div>
			</div>
			<br/>
			<div class="flex1" onclick="router('notify');">
				<i class="fa fa-bell-o icon"></i>
				<div class="panel-title">Notifications</div>
			</div>
			<!-- <div class="flex1" onclick="router('');">
				<i class="fa fa-envelope-o icon"></i>
				<div class="panel-title">Messages</div>
			</div> -->
			<div class="flex1" onclick="router('profile');">
				<i class="la la-user icon"></i>
				<div class="panel-title">myProfile</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	//function to return element by Id
	function $(id) {
		return document.querySelector(id);
	}
	//function helps switches user actions
	function router(action, options='') {
		switch(action) {
			case 'home':
				location.href = "index.php";
			break;
			case 'logout':
				var action = confirm('Want to logout?');
				if(action == false) {
					return false;
				} else {
					location.href = "controller.php?logout=true";
				}
			break;
			case 'invoices':
				runAjax('invoices.php');
			break;
			case 'view':
				runAjax('viewinvoice.php?invid='+options);
				setTimeout(function() {
					openPrintWindow(options); //call open new window for printing 
				}, 500); //delay 500miliseconds before run
			break;
			case 'history':
				runAjax('history.php');
			break;
			case 'profile':
				runAjax('profile.php');
			break;
			case 'notify':
				runAjax('notify.php');
				setTimeout("updateAlerts('allmessages')", 200);
			break;
		}
	}
	//function triggered when patients, click cancel button
	function cancelApp(pid, appdate) {
		var action = confirm("Want to cancel this appointment?");
		if(action == false) {
			return false;
		} else {
			window.open("controller.php?cancelappointment=true&pid="+pid+"&appdate="+appdate, '_self');
		}
	}
	//
	function runAjax(url) {
		var xhr = new XMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4 && xhr.status == 200) {
				$('.flexbox').innerHTML = xhr.responseText;
			}
			if(xhr.status == 404) {
				alert("ERROR 404: URL/Page not found!.");
			}
		}
		xhr.send();
	}

	function updateAlerts(action) {
		//grap patient ID Number from stored session, assign value to javascript variable
		var pid = <?php echo $_SESSION['patient']['pid']; ?>;
		switch(action) {
			case 'allmessages':
				var params = "?allmessages=true&pid="+pid;
				return fetchAPI(params);
			break;
			case 'unread':
				var params = "?checkunread=true&pid="+pid;
				return fetchAPI(params);
			break;
			case 'seen':
				var params = "?checkseen=true&pid="+pid;
				return fetchAPI(params);
			break;
			case 'reminder':
				var params = "?reminder=true&pid="+pid;
				return fetchAPI(params);
			break;
		}
	}
	//request/response from controller
	function fetchAPI(params='') {
		$('#results').innerHTML = "<div class='loader'><center>Loading...</center></div>";
		var url = 'controller.php';
		var params = params; //"?checkBirthdays=true";
		fetch(url+params)
		.then(response => response.text())
		.then(data => {
			$('#results').innerHTML = data; //print received data
		})
		.catch(error => alert(error));
	}
	//viewing inbox message item
	function openInbox(params) {
		var urldata = "?viewitem=true&timestamp="+params;
		fetchAPI(urldata);
	}
	//open card birthday message
	function viewCardMessage(pid) {
		var urldata = "?openNotify=true&pid="+pid;
		fetchAPI(urldata);
		$('#birthdaySong').play();
	}
	//open window for printing invoice
	function openPrintWindow(invid) {
		var action = confirm('Do you want to print this invoice?');
		if(action == false) {
			return false;
		} else {
			window.open('viewinvoice.php?invid='+invid,'_blank');
		}
	}
</script>
</html>