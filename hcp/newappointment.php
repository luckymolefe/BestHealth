<?php
	//create new appointment
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 500px;
			max-width: 100%;
			border-radius: 3px;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 12px 10px;
			margin: 50px auto;
		}
		.lead {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 2em;
			border-bottom: thin solid #eee;
			margin-bottom: 10px;
			padding-bottom: 5px;
		}
		.form-control {
			/*width: 200px;*/
			width: 100%;
			max-width: 100%;
			border-radius: 5px;
			border: thin solid #ccc;
			padding: 8px 0;
			color: #777;
			font-size: 1.2em;
			text-indent: 5px;
			margin-bottom: 15px;
		}
		.form-control:focus {
			border: thin solid #17EAD9;
			outline: none;
			filter: drop-shadow(1px 1px 2px #17EAD9);
		}
		label {
			color: #777;
			font-weight: bold;
		}
		.btn {
			width: 100%;
			max-width: 100%;
			background-color: #5d9cec;
			color: #fff;
			border: none;
			border-radius: 3px;
			padding: 12px 8px;
			font-weight: bold;
		}
		.btn:hover {
			background-color: #5db6d3;
			cursor: pointer;
		}
		.btn:active {
			background-color: #28789f;
			cursor: pointer;
		}
		.back-btn {
			color: tomato;
			float: right;
		}
		.back-btn:hover {
			color: #ff0000;
			cursor: pointer;
		}
		.back-btn:active {
			color: #dd0000;
		}
		.availability-panel {
			position: absolute;
			top: 50px;
			width: 200px;
			height: auto;
			margin-left: 20px;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			padding: 5px;
			display: none;
		}
		.panel-head {
			font-size: 1.2em;
			color: #28789f;
			margin-bottom: 10px;
		}
		.danger {
			color: #E8563F;
			font-weight: bold;
		}
		.success {
			color: #8AC054;
			font-weight: bold;
		}
		.bookdate {
			font-weight: bold;
			color: #4b89da;
			margin-bottom: 5px;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<span class="fa fa-close back-btn" title="Close" onclick="runAction('appointments');"></span>
		<div class="lead"><i class="fa fa-clock-o"></i> New Appointment</div>
		<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
			<div>
				<label>Patient ID Number:</label><br>
				<input type="text" name="idnumber" id="idnum" class="form-control" placeholder="Enter ID Number" required>
			</div>
			<div>
				<label>Appointment Date:</label><br>
				<input type="date" name="appdate" id="appdate" onchange="checkTimeSlot(this.value)" class="form-control" placeholder="yyyy/mm/dd">
			</div>
			<div>
				<label>Appointment Time:</label><br>
				<input type="time" name="apptime" id="apptime" class="form-control" placeholder="--:-- --">
			</div>
			<div>
				<button type="button" class="btn" name="bookdate" value="true" onclick="bookAppointment()"><i class="fa fa-check"></i> Make New Appointment</button>
			</div>
		</form>
	</div>

	<div class="availability-panel">
		<div class="panel-head">Bookings Available</div>
		<div id="timeSlots"></div>
	</div>
</body>
</html>