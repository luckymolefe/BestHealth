<?php
	//login selection
?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health::Choose Login</title>
	<link rel="stylesheet" type="text/css" href="../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			max-width: 100%;
			max-height: 100%;
			background: url('images/healthcare_bg.jpg') no-repeat;
			background-size: cover;
			background-position: top center;
			font-family: 'helvetica', 'arial';
		}
		.container {
			width: 450px;
			max-width: 100%;
			height: 350px;
			background: rgb(153, 193, 60);
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			margin: 80px auto;
		}
		.panels {
			display: inline-block;
		}
		.panels:nth-child(1) {
			width: 350px;
			height: 350px;
			max-width: 100%;
			max-height: 100%;
			background-color: #bbb;
			background: url('images/bg_logo.png') no-repeat;
			background-size: cover;
			background-position: top center;
			border-radius: 5px 0 0 5px;
		}
		.panels:nth-child(1) > div {
			color: #28789f;
			font-size: 1.5em;
			font-weight: bold;
			text-align: center;
			margin-top: 10px;
		}
		.panels:nth-child(2) {
			/*background-color: #999;*/
			position: absolute;
			margin: 5px auto 0 10px;
			/*padding: 20px;*/
			/*margin-left: 110px;*/
			/*animation: slideleft .50s ease-in forwards;*/
		}
		
		.lead {
			color: #fff;
			text-align: center;
		}
		.form-input {
			width: 300px;
			background-color: transparent;
			color: #fff;
			font-size: 1.2em;
			border: none;
			border-bottom: thin solid #fff;
			padding: 5px 0;
			margin: 15px 0;
			text-indent: 30px;
		}
		.btn {
			width: 100%;
			background-color: rgb(15, 107, 156);
			color: #fff;
			font-size: 1.3em;
			border: thin solid rgb(15, 107, 156);
			border-radius: 50px;
			padding: 5px 0;
			margin: 20px 0;
			cursor: pointer;
		}
		.btn:hover {
			background-color: rgb(93, 182, 211);
		}
		.btn:active {
			background-color: rgb(9, 73, 102);
		}
		.input-icon {
			position: absolute;
			left: 18px;
			font-size: 2em;
			color: #fff;
			margin-top: 15px;
		}
		.panel-select {
			/*background-color: #ceb;*/
			color: #fff; /*rgb(9, 73, 102);*/
			padding: 5px 15px;
			margin: 5px 0;
			text-align: center;
			font-weight: bold;
			cursor: pointer;
			transform: scale(0);
			/*border-top: thin solid #ddd;*/
		}
		.panel-select:hover {
			color: #28789f;
		}
		.panel-select:nth-child(1) {
			border-top: none;
		}
		.panel-icon {
			font-size: 3em;
		}
		
		.panel-select:nth-child(1) {
			animation: bounceIn .3s ease-in forwards;
			animation-delay: .1s;
		}
		.panel-select:nth-child(2) {
			animation: bounceIn .3s ease-in forwards;
			animation-delay: .3s;
			
		}
		.panel-select:nth-child(3) {
			animation: bounceIn .3s ease-in forwards;
			animation-delay: .5s;
		}
		.panel-select:nth-child(4) {
			animation: bounceIn .3s ease-in forwards;
			animation-delay: .7s;
		}
		@keyframes bounceIn {
			0% {
				transform: scale(0);
			}
			85% {
				transform: scale(1.5);
			}
			100% {
				transform: scale(1);
			}
		}
	</style>

</head>
<body>
	<div class="container">
		<li class="panels"><div>Choose Login To As</div></li>
		<li class="panels">
			<div class="panel-select" id="home" title="Go Home"><i class="fa fa-home panel-icon"></i><br/> Home</div>
			<div class="panel-select" id="patient" title="Patient Login"><i class="medical-icon-i-outpatient panel-icon"></i><br/> Patient</div>
			<div class="panel-select" id="admin" title="Admin Login"><i class="medical-icon-i-care-staff-area panel-icon"></i><br/> Admin</div>
			<div class="panel-select" id="hcp" title="HCP Login"><i class="fa fa-user-md panel-icon"></i><br/> HCP</div>
		</li>
	</div>
	<script type="text/javascript">
		function $(id) {
			return document.querySelector(id);
		}
		function redirect(url) {
			window.open(url,'_self');
		}
		$('#home').addEventListener('click', function() {
			redirect('index.php');
		});
		$('#patient').addEventListener('click', function() {
			redirect('patient/login.php');
		});
		$('#admin').addEventListener('click', function() {
			redirect('admin/login.php');
		});
		$('#hcp').addEventListener('click', function() {
			redirect('hcp/login.php');
		});
	</script>
</body>
</html>