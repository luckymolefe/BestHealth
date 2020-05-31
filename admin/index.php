<?php
	//Admin Welcome
	date_default_timezone_set('Africa/Johannesburg');
	require_once('controller.php');
	$admin->protected_page();
	// $totalAlerts = (int)($notify->counter('inbox') + $notify->counter('birthdays'));// + $notify->counter('reminders')
?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health::Admin Welcome</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			font-family: 'helvetica', 'arial';
			background: url('../images/healthcare_bg7.jpg');
			background-size: cover;
		}
		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: 300px;
			height: 800px;
			background-color: rgb(153, 193, 60);
		}
		.sidebar > li:nth-child(1) {
			background-color: transparent !important;
			border-left: none;
			padding: 0;
			cursor: unset;
			color: #fff;
			text-align: center;
			font-weight: bold;
		}
		.sidebar > li {
			list-style-type: none;
			background-color: #5db6d3;
			border-left: 5px solid #5db6d3;
			padding: 10px 0;
			margin-bottom: 2px;
			text-indent: 3px;
		}
		.sidebar > li:hover {
			background-color: rgb(15, 107, 156); /*rgb(93, 182, 211);*/
			cursor: pointer;
		}
		.sidebar > li > a {
			text-decoration: none;
			color: #fff;
		}
		.avatar {
			width: 150px;
			border-radius: 50%;
			margin: 10px auto;
		}
		
		.bar-icon {
			font-size: 1.3em;
		}
		.notify {
			background-color: tomato;
			color: #fff;
			padding: 4px 8px;
			border-radius: 50%;
		}
		.reminder {
			position: absolute;
			background-color: #fff;
			color: tomato;
			/*filter: drop-shadow(1px 1px 4px rgba(0, 0, 0, 0.5));*//*#5af158*/
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			font-size: .20em !important;
			padding: 5px 10px;
			border-radius: 50%;
		}
		#reminder {
			margin-left: -30px;
		}
		#messages {
			margin-left: -10px;
		}
		.container {
			position: fixed;
			left: 300px;
			width: 77%;
			height: 630px;
			max-height: 630px;
			overflow-y: auto;
			background-color: rgba(255, 255, 255, 0.6);
		}
		.lead {
			font-weight: bold;
			color: #28789f;
		}
		
		.form-input {
			width: 300px;
			border: thin solid #ccc;
			color: #555;
			border-radius: 5px;
			padding: 8px 2px;
			margin-top: 10px;
			margin-bottom: 5px;
		}
		
		.months-table {
			width: 100%;
			margin-top: 15px;
		}
		.months-table tr td {
			background-color: #28789f;
			color: #fff;
			font-weight: bold;
			border: thin solid #dec;
			padding: 25px 5px;
			cursor: pointer;
		}
		.months-table  tr  td:hover {
			background-color: #5db6d3;
		}
		.months-table  tr  td:active {
			background-color: #094966;
		}
		.current-month {
			background-color: #ac92ea !important;/*#5aa2e0;*/
		}
		.current-month:hover {
			background-color: #b3a5ef !important;
		}
		.current-month:active {
			background-color: #967ada !important;
		}
		/*Log: added new line to css to highlight previous months with disabled shaded-color*/
		.disabled-month {
			background-color: #ddd !important;
		}
		.disabled-month:hover {
			cursor: unset !important;
		}
		.loader {
			position: absolute;
			top: 200px;
			left: 400px;
			color: #777;
			font-size: 2em;
		}
		.header {
			font-size: 1.3em;
			color: #5db6d3;
			border-bottom: thin solid #ccc;
			padding: 10px 0;
			text-indent: 25px;
		}
		.flexbox {
			display: flex;
		}
		.flex {
			background-color: #5db6d3;
			width: 250px;
			height: auto;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			margin: 5px 15px 20px 0;
			padding: 10px;
			transform: translate(10%, 20%);
			text-align: center;
		}
		.flex:hover { 
			background-color: rgb(153, 193, 60);
			cursor: pointer;
		}
		.icon {
			font-size: 7em;
			color: #fff; /*rgb(153, 193, 60);*/
		}
		.flex-title {
			color: #fff; /*rgb(153, 193, 60);*/
			font-size: 1.5em;
			margin-top: 20px;
		}
		@media screen and (max-width: 768px) {
			.sidebar {
				display: none;
			}
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
		.alert-notify {
			width: 700px;
			max-width: 100%;
			margin: 10px auto;
			border-radius: 5px;
			background-color: #cccc;
			color: #999;
			padding: 18px 8px;
			font-weight: bold;
			text-align: center;
		}
		.danger {
			background-color: #f36c60;
			color: #e51c23;
		}
		.success {
			background-color: #72d572;
			color: #2baf2b;
		}
		.info {
			background-color: #b3e5fc;
			color: #29b6f6;
		}
		.btn-search {
			width: 75px;
			background-color: #5d9cec;
			color: #fff;
			border: none;
			border-radius: 3px;
			padding: 8px 0;
			font-weight: bold;
		}
		.btn-search:hover {
			background-color: #5db6d3;
			cursor: pointer;
		}
		.btn-search:active {
			background-color: #28789f;
			cursor: pointer;
		}
		.btn:disabled {
			background-color: #bbb;
		}
		.btn-logout {
			position: relative;
			top: -40px;
			right: 20px;
			padding: 5px 10px;
			border-radius: 3px;
			background-color: tomato;
			color: #fff;
			float: right;
		}
		.btn-logout:hover {
			background-color: #ff0000;
			cursor: pointer;
		}
		.btn-logout:active {
			background-color: #dd0000;
		}
		#search-results {
			position: absolute;
			margin-left: 85px;
			margin-top: -5px;
			width: 300px;
			background-color: #fff;
			box-shadow: 2px 1px 4px rgba(0, 0, 0, 0.5);
			color: #777;
			padding: 5px 0;
			text-align: left !important;
			list-style-type: none;
			border-radius: 0 0 5px 5px;
			display: none;
			text-indent: 5px;
		}
		.result-item {
			color: #28789f;
			padding: 5px 0;
		}
		.result-item:hover {
			background-color: #5db6d3;
			color: #fff;
			cursor: pointer;
		}
		.error {
			color: #ff5555;
		}
		#client_detials{
			color: #28789f;
			font-weight: bold;
		}
		.picked_date {
			color: #E9573F;
			font-weight: bold;
		}
		
	</style>
</head>
<body>
	<div class="sidebar">
		<li><img src="../images/avatar.png" class="avatar"><p>Logged in as: Admin</p></li>
		<li onclick="router('home')"><a href="#"><i class="fa fa-home bar-icon"></i> Home</a></li>
		<li onclick="router('appointments')"><a href="javascript:void(0)"><i class="fa fa-calendar-check-o bar-icon"></i> Appointments</a></li>
		<li onclick="router('patients')"><a href="javascript:void(0)"><i class="medical-icon-i-medical-records bar-icon"></i> Patients</a></li>
		<li onclick="router('invoices')"><a href="javascript:void(0)"><i class="fa fa-clipboard bar-icon"></i> Invoices</a></li>
		<li onclick="router('messages')"><a href="javascript:void(0)"><i class="fa fa-bell bar-icon"></i> Notifications <sup class="notify">0</sup></a></li>
		<li onclick="router('settings')"><a href="javascript:void(0)"><i class="fa fa-cog bar-icon"></i> Settings</a></li>
		<li onclick="router('logout')"><a href="javascript:"><i class="fa fa-power-off bar-icon"></i> Logout</a></li>
	</div>
	
	<div class="container">
		<div class="header"><i class="fa fa-home"></i> ADMIN DASHBOARD</div><span onclick="router('logout')" class="btn-logout" title="Logout"><i class="fa fa-power-off"></i></span>

		<?php #Handles action response to display response-message
			$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
			switch($action) {
				case 'invalid':
					echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Please type all fields are required!</div>";
				break;
				case 'failed':
					echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Sorry failed to add new record!</div>";
				break;
				case 'success':
					echo "<div class='alert-notify success'><i class='fa fa-check'></i> Patient record added successfully!</div>";
				break;
				case 'unmatch':
					echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Password do not match!</div>";
				break;
				case 'passfail':
					echo "<div class='alert-notify danger'><i class='fa fa-warning'></i> Failed to change Password!</div>";
				break;
				case 'passmatch':
					echo "<div class='alert-notify success'><i class='fa fa-check'></i> Password updated successfully!</div>";
				break;
			}
		?> 
		<div class="flexbox">
			<div class="flex" onclick="router('appointments');">
				<span class="fa fa-calendar-check-o icon"></span>
				<div class="flex-title">Appointments</div>
			</div>
			<div class="flex" onclick="router('patients');">
				<span class="medical-icon-i-medical-records icon"></span>
				<div class="flex-title">Manage Patients</div>
			</div>
			<div class="flex" onclick="router('invoices');">
				<span class="fa fa-calendar-check-o icon"></span>
				<div class="flex-title">Manage Invoices</div>
			</div>
		</div>
		<div class="flexbox">
			<div class="flex" onclick="router('messages')">
				<span class="fa fa-envelope-o icon"><sup class="reminder" id="messages">0<?php #echo $notify->counter('inbox'); ?></sup></span>
				<div class="flex-title">Messages</div>
			</div>
			<div class="flex" onclick="router('messages')">
				<span class="fa fa-gift icon"><sup class="reminder" id="reminder">0<?php #echo $notify->counter('reminders'); ?></sup></span>
				<div class="flex-title">Reminders</div>
			</div>
			<div class="flex" onclick="router('settings')">
				<span class="la la-cog icon"></span>
				<div class="flex-title">Settings</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function $(id) {
			return document.querySelector(id);
		}
		function pickMonth(param) { //get YearMonth to show calendar
			var year = $('#year').value;
			var month = param.getAttribute('data-month');
			month = (month.length < 2) ? '0'+ month : month; //append leading zero for single digits
			var book_date = year+'-'+month; //Year and Month
			router('getcalendar', book_date);
		}
		function calPickDate(datePick) { //get date picked from calendar
			return router('getdate', options=datePick);
		}
		//function to hanlde http request/response.
		function ajaxCall(url, param='', options='') {
			// alert(url+param+options);
			// $('.container').innerHTML = "<div class='loader'>Loading...</div>";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", url+param, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					if(options=="container") {
						var option = $('.container');
					} else {
						var option = $('.calendar');
					}
					option.innerHTML = xhr.responseText;
				}
				if(xhr.status == 404) {
				    //on error show message
				    alert("ERROR 404: URL/page not found.");
				}
			}
			xhr.send();
		}
		//
		function router(action, options='') {
			switch(action) {
				case 'getmonths':
					ajaxCall('controller.php?', 'getmonths=true', 'calendar');
				break;
				case 'getcalendar':
					ajaxCall('calendar.php?ym=', options, 'calendar');
				break;
				case 'getdate':
					ajaxCall('controller.php?getSlots=true&bookdate=', options, 'calendar');
				break;
				case 'gettime':
					var appdate = options.date;
					var apptime = options.time;
					var uid = $('#uid').value;
					if(uid=="") {
						// $('.calendar').innerHTML = "<div class='alert danger'><i class='fa fa-warning'></i> Please provide patient id number for booking!</div>";
						return alert('Please provide patient ID Number for booking!');
					}
					ajaxCall('controller.php?book=true&idnumber='+uid+'&bookdate='+appdate+"&booktime="+apptime, '', 'calendar');
				break;
				case 'cancelApp':
					//array valules passed as funciton parameters
					var idNum = options.idnum; //extract id number from array
					var appDate = options.date; //extract appointment date
					var parameters = '?cancel_app=true&idnumber='+idNum+'&app_date='+appDate;
					ajaxCall('controller.php', parameters, 'container');
				break;
				case 'home':
					location.href = "index.php";
				break;
				case 'logout':
					var action = confirm('Want to logout?');
					if(action == false) {
						return false;
					} else {
						return location.href = "controller.php?logout=true";
					}
				break;
				case 'appointments':
					ajaxCall('appointments.php','','container');
				break;
				case 'patients':
					ajaxCall('patients.php','','container');
				break;
				case 'invoices':
					ajaxCall('invoices.php','','container');
				break;
				case 'messages':
					setTimeout("getNotification('all')", 500);
					ajaxCall('messages.php','','container');
				break;
				case 'settings':
					ajaxCall('settings.php','','container');
				break;
				case 'addnew':
					ajaxCall('addnew.php', '','container');
				break;
				case 'viewrecords':
					ajaxCall('viewrecords.php','','container');
				break;
				case 'createappointment':
					ajaxCall('createappointment.php','','container');
				break;
				case 'viewappointment':
					ajaxCall('viewappointment.php','','container');
				break;
				case 'edit':
					var params = "?edit=true&pid="+options;
					ajaxCall('edit.php', params, 'container');
				break;
				case 'update_invoice':
					var params = "?update=true&invid="+options;
					ajaxCall('controller.php', params, 'container');
				break;
			}
		}
		//
		function searchUser(param) {
			var xhr = new XMLHttpRequest()
			xhr.open("GET", "controller.php?search=true&uid="+param.trim(), true);
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					// console.log(xhr.responseText);
					var jason = JSON.parse(xhr.responseText);
					$('#search-results').style.display = "block";
					if(jason.patient == "0") {
						$('#search-results').innerHTML = "<li class='error'><center><i class='fa fa-warning'></i> <strong>No Match Found!</strong></center></li>";
					} else {
						for(i = 0; i < jason.patient.length; i++) {
							//create array object person, pass object to a function
							var person = '{"uid": "'+jason.patient[i].idnumber+'", "fname": "'+jason.patient[i].firstname+'", "lname": "'+jason.patient[i].lastname+'"}'; 
							//create <li> element with event click action to pass patient detials
							var result_data = "<li class='result-item' onclick='getIdNum("+person+")'>"+jason.patient[i].idnumber+" "+jason.patient[i].firstname+" "+jason.patient[i].lastname+"</li>";
						}
						$('#search-results').innerHTML = result_data; //display results to page
					}
				}
			}
			xhr.send();
		}
		/*get value from list of displayed results and assign to a hidden textbox located in controller.php page*/
		function getIdNum(person) {
			$('#uid').value = person.uid; //assing value to hidden textbox
			$('#search-results').style.display = "none"; //hide result list
			$('#idNum').style.display = "none";
			$('.btn-search').style.display = "none";
			$('#idNum').value = ""; //clear value from search textbox
			//then display ID number for patient
			$('#client_detials').innerHTML = "<p>Booking For: <br/>"+person.fname+' '+person.lname+' - '+person.uid+"</p>"; 
		}
		//function to get id number and date from onclick to cancel appointment
		function cancelApp(pid, app_date) {
			var action = confirm("Cancel this appointment?");
			if(action == false) {
				return false;
			} else {
				//package values in javascript array
				var options = {idnum: pid, date: app_date}; 
				router('cancelApp', options); //call router function to compete ajax web request
			}
		}
		
		function fetchAPI(params='') {
			var url = 'controller.php?';
			var params = params; //
			fetch(url+params)
			.then(response => response.text())
			.then(data => {
				$('#results').innerHTML = data; //print received data
			})
			.catch(error => console.log(error));
		}
		//use switch() inside a function to route/direct user action
		function getNotification(action, options) {
			switch(action) {
				case 'birthdays':
					var parameters = 'checkBirthdays=true';
					return fetchAPI(parameters); //call function to open url and send browser request, for birthdays
				break;
				case 'all':
					var parameters = 'allmessages=true';
					return fetchAPI(parameters);
				break;
				case 'unread':
					var parameters = 'checkunread=true';
					return fetchAPI(parameters);
				break;
				case 'seen':
					var parameters = 'checkseen=true';
					return fetchAPI(parameters);
				break;
				case 'openmessage':
					var parameters = 'viewmessage=true&timestamp='+options;
					return fetchAPI(parameters);
				break;
			}
		}
		//check to notification every
		function checkAlerts() {
			//open url and send parameters, and results returned;
			var url = 'controller.php?notifycounter=true';
			fetch(url)
			.then(response => response.json())
			.then(data => {
				$('.notify').innerHTML = data.notify; //print received data
				$('#messages').innerHTML = data.messages;
				$('#reminder').innerHTML = data.reminder;
			})
			.catch(error => console.log(error)); //if any error occured return Error message	
		}

		//call function to check notification every 1min (60000=1min)
		function checkNotifications() {
			checkAlerts(); //call function inside checkNotification to check for notification;
			getNotification('birthdays'); //call function to check for birthdays
			getNotification('unread'); //call function to check for inbox messages
			setTimeout("checkNotifications()", 120000); //delays for 2minute and function calls itself infinitely
		}
		checkNotifications();
	</script>
</body>
</html>