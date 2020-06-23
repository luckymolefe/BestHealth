<?php
	//Index page [Home] of Best Health
	#require_once('bootstrap.php');
	if(isset($_POST['send']) && $_POST['send'] == "true") {
		$notify = new Notification(); #instantiate to get access to method sendMessage()
		$helper = new Helper(); #instantiate to get access to method tokenize()
		//our notification message body
		if(in_array('', $_POST)) {
			//if any of form fields is empty, redirect to page with null action.
			$helper->redirect('index.php?action=null');
		} else {
			//package form data into an array
			$data = array(
				'name' => $_POST['name'],
				'phone' => $_POST['phone'],
				'email' => $_POST['email'],
				'messageText' => nl2br($_POST['message']),
			);
			$params = $helper->strip_data($data); #clean data
			if(empty($params['name']) || empty($params['phone']) || empty($params['email']) || empty($params['messageText'])) {
				$helper->redirect('index.php?action=null');
			} else {
				$messageBody = "Names: ".$params['name']."<br/>Tel: ".$params['phone'].
							  "<br/>Email: ".$params['email']."<br/>".$params['messageText'];
				//package everything in an array format
				$data = array(
					'id' => 'webvisitor_'.$helper->tokenize(),
					'message' => $messageBody, //message body
					'sent_from' => "webcontact@besthealth.com", //sender
					'sent_to' => "admin@besthealth.com" //
				);
				#then pass single array parameter with all data packaged it.
				if($notify->sendMessage($data)) {
					$helper->redirect('index.php?action=success');
				} else {
					$helper->redirect('index.php?action=failed');
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>BestHealth::Home</title>
<!-- 	<link rel="stylesheet" type="text/css" href="../boostrap3/font-awesome/css/font-awesome.min.css"> -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- 	<link rel="stylesheet" type="text/css" href="../boostrap3/line-awesome/css/line-awesome.min.css"> -->
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
<!-- 	<link rel="stylesheet" type="text/css" href="../boostrap3/webfont-medical-icons/css/wfmi-style.css"> -->
	<link rel="stylesheet" href="../css/wfmi-style.css">
	<style type="text/css">
		body {
			position: fixed;
			top: 0;
			left: 0;
			max-width: 100%;
			max-height: 100%;
			background: url('images/healthcare_bg.jpg') no-repeat;
			background-size: cover;
			background-position: top center;
			font-family: 'helvetica', 'arial';
		}
		.nav {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			background-color: transparent;
			padding: 15px;
			z-index: 1;
		}
		.nav > li {
			display: inline-block;
		}
		.nav > li > a {
			color: #fff;
			text-decoration: none;
			padding: 15px;
		}
		.nav > li > a:hover, a:active {
			background-color: rgba(0, 0, 0, 0.2);
		}
		.logo {
			position: absolute;
			top: 2px;
			width: 50px;
			max-width: 100%;
		}
		.pull-right {
			float: right;
			margin-right: 2px;
		}
		.nav > li:nth-child(1) {
			font-weight: bold;
		}
		.nav > li:nth-child(2) {
			margin-right: 40px;
		}
		.footer {
			position: fixed;
			left: 0;
			bottom: 0px;
			width: 100%;
			max-width: 100%;
		}
		.footer > li {
			display: inline-block;
			padding: 15px;
			color: #fff;
		}
		.footer > li > a {
			text-decoration: none;
			color: #fff;
		}
		.footer > li:hover, li:active {
			background-color: rgba(0, 0, 0, 0.2);
		}
		.layer {
			position: fixed;
			top: 0;
			left: 0;
			background-color: rgba(0, 0, 0, 0.5);
			width: 100%;
			height: 100%;
			z-index: 0;
		}
		.pull-center {
			float: right;
			margin-right: 10px;
			text-align: right;
		}
		.container {
			position: relative;
			width: 1250px;
			max-width: 100%;
			height: auto;
			background-color: #fff;
			color: rgb(15, 107, 156);
			background-size: cover;
			/*margin-top: 320px;*/
			margin-top: 680px;
			padding: 60px 50px;
			animation: slidebottom .5s ease-in forwards;
		}
		.container > h2 {
			color: rgb(153, 193, 60);
			font-weight: bold;
			text-indent: 20px;
		}
		.container > p {
			color: #777;
			margin-left: 170px;
			margin-right: 430px;
		}
		.page-title {
			position: absolute;
			font-size: 4em;
			font-weight: bold;
			color: rgb(153, 193, 60); /*light green color*/
			-webkit-transform: translate(30%, 20%);
			animation: bounce .5s forwards;
		}
		.page-title > small {
			font-size: .30em;
			font-weight: bold;
			color: #fff;
		}
		.page-title > span {
			position: absolute;
			width: 400px;
			font-size: .20em;
			color: #fff;
		}
		.booking-panel {
			position: absolute;
			right: -500px;
			top: 0px;
			-webkit-transform: translate(-35%, -70%);
			width: 350px;
			max-width: 100%;
			margin: 0 auto;
			background-color: #f5f5f5;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			z-index: 1;
			animation: slide .5s ease-in forwards;
			-webkit-animation-delay: 1s;
		}

		.panel-title {
			background-color: rgb(153, 193, 60);
			color: #fff;
			text-align: center;
			font-weight: bold;
			padding: 5px;
			margin-bottom: 10px;
			border-radius: 5px 5px 0 0;
		}
		@keyframes bounce {
 			0% {
 				top: -200px;
 			}
 			85% {
 				top: 15px;
 			}
 			100% {
 				top: 0;
 			}
 		}
 		@keyframes slide {
 			0% {
 				-webkit-transform: scale(0.5);
 			}
 			85% {
 				right: 20px;
 			}
 			100% {
 				right: 0px;
 			}
 		}
		.form-input {
			width: 320px;
			padding: 5px 2px;
			font-size: 1.2em;
			color: #777;
			border: thin solid #ddd;
			border-radius: 5px;
			margin-bottom: 10px;
			margin-left: 10px;
			text-indent: 5px;
		}
		.form-input:focus {
			outline: none;
			filter: drop-shadow(1px 1px 2px #17EAD9);
		}
		textarea {
			resize: none;
		}
		.btn {
			width: 320px;
			background-color: rgb(153, 193, 60);
			color: #fff;
			text-align: center;
			font-weight: bold;
			border: thin solid #ccc;
			border-radius: 5px;
			padding: 10px;
			margin: 10px;
			cursor: pointer;
		}
		.btn:hover {
			background-color: #b4e080;/*#aed581;*/
		}
		.btn:active {
			background-color: #8ac054;/*#7cb342;*/
		}
		.bar-float {
			position: absolute;
			left: -700px; /*left: 100px;*/
			top: 260px;
			width: 600px;
			background-color: #fff;
			color: rgb(40, 120, 159);
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 10px;
			z-index: 1;
			animation: slideleft .5s ease-in forwards;
			-webkit-animation-delay: .50s;
		}
		@keyframes slideleft {
			0% {
				left: -700px;
			}
			85% {
				left: 130px;
			}
			100% {
				left: 100px;
			}
		}
		@keyframes slidebottom {
			0% {

			}
			85% {
				margin-top: 300px;
			}
			100% {
				margin-top: 320px;
			}
		}
		.icons {
			font-size: 5em;
		}
		table tr td:nth-child(2), td:nth-child(4) {
			border-right: 1px solid #ddd;
		}
		/*table tr td:nth-of-type(1) {
			float: left;
		}*/
		/*.circle_loader {
 			position: absolute;
 			top: 45%;
 			left: 50%;
 			transform: translate(-50%, -50%);
 			width: 100px;
 			height: 100px;
 			border-radius: 50%;
 			border: 10px solid #588c7e;
 			border-top: 10px solid #b5e7a0;
 			animation: animate 0.8s infinite linear; 
 		}
 		@keyframes animate {
 			0% {
 				transform: translate(-50%, -50%) rotate(0deg);
 			}
 			100% {
 				transform: translate(-50%, -50%) rotate(360deg);
 			}
 		}*/
 		.section {
			position: relative;
			top: 0px;
			width: 85%;
			height: 400px;
			margin: 0 auto;
			background-color: rgba(255, 255, 255, 1) !important;
			color: #777;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			z-index: 2;
			padding: 12px 0; 
			display: none;
			opacity: 0;
		}
		.section > div {
			padding: 10px 15px;
		}
		.section > div > h1 {
			color: rgb(153, 193, 60) !important;
		}
		.hr-bar {
			width: 20%;
			border-bottom: 6px solid rgb(153, 193, 60);
		}
		.pullup {
			display: block;
			animation: pull-up 1s ease-in forwards, fadeIn 1.5s ease-in forwards;
			/*-webkit-animation-delay: 0s;*/
		}
		.reflect {
			transition: all 500ms ease 0.5s;
			background-color: #5db6d3 !important;
		}
		@keyframes pull-up {
			from { top: 0px; }
			to { top: -520px; }
		}
		@keyframes pull-down {
			from { top: -540px; }
			to { top: 0px; }
		}
		@keyframes fadeIn {
			0% {opacity: 0;}
			100% {opacity: 1;}
		}
		.companyAddr {
			list-style-type: none;
			line-height: 2;
		}
		.popup {
			position: relative;
			left: 35%;
			float: left;
			width: 300px;
			height: auto;
			max-width: 100%;
			margin: 20px auto;
			background-color: #fff;
			color: #777;
			padding: 15px 10px;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			text-align: center;
			z-index: 2;
			transform: scale(0);
			animation: popin .50s ease-in forwards;
			/*animation-delay: 2s;*/
		}
		.popup-title {
			font-weight: bold;
			font-size: 1.5em;
			color: #8AC054;
			padding: 10px 0;
		}
		.popup-message {
			margin: 10px 0;
		}
		.popup-icon {
			font-size: 5em;
			border: thin solid #8AC054;
			color: #8AC054;
			border-radius: 50%;
			padding: 10px;
			/*transform: scale(0);*/
			/*animation: popin .50s ease-in forwards;*/
		}
		@keyframes popin {
			form { transform: scale(0); }
			to { transform: scale(1); }
		}
		.btn-close {
			width: 150px;
			background-color: #8AC054;
			color: #fff;
			font-weight: bold;
			border: none;
			border-radius: 50px;
			padding: 5px 0;
			margin: 10px 0;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
		}
		.btn-close:hover {
			cursor: pointer;
			background-color: #b4e080;
		}
		.btn-close:active {
			background-color: #8AC054;
		}
		.fadeOut {
			animation: fadeOut .55s ease forwards;
		}
		@keyframes fadeOut {
			from { opacity: 1; }
			to { opacity: 0; }
		}
		.warning {
			color: #E8563F !important; /*#FB6D51*/ 
			border: none;
		}
		.btn-close.warning {
			background-color: #E8563F !important;
			color: #fff !important;
		}
		.btn-close.warning:hover {
			background-color: #FC8370 !important;
			color: #fff !important;
		}
	</style>
	
</head>
<body>
	<div class="layer"></div>
	<nav class="nav">
		<!-- <li><a href="#home"><img src="images/logo1.png" class="logo"></a></li> -->
		<li><a href="index.php"><span class="fa fa-home"></span> Best Health</a></li>
		<li class="pull-right"><a href="login.php"><span class="la la-user"></span> Login</a></li>
		<li class="pull-right"><a href="javascript:reflect()" id="contact"><span class="fa fa-envelope"></span> Contact us</a></li>
		<li class="pull-right"><a href="javascript:navUp()" id="about"><span class="fa fa-info-circle"></span> About us</a></li>
	</nav>
	<?php
		$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		if($action=="success") {
	?>
		<div class="popup">
			<i class="la la-check popup-icon"></i>
			<div class="popup-title">Success</div>
			<div class="popup-message">Your message has been sent successfully.</div>
			<div class=""></div>
			<button class="btn-close" title="Close" onclick="closeItem('.popup')">Close</button>
		</div>
	<?php } elseif($action=="null" || $action=="failed") { ?>
		<div class="popup">
			<i class="fa fa-warning popup-icon warning"></i>
			<div class="popup-title warning">Failed</div>
			<div class="popup-message">Failed to send your message.</div>
			<div class=""></div>
			<button class="btn-close warning" title="Close" onclick="closeItem('.popup')">Close</button>
		</div>
	<?php } ?>

	<div class="page-title">
		<small>WELCOME TO</small>
		<br/>Best Health<br/>
		<span>
		Book appointments, view your medical records, message your doctor and more. Everything you need to take charge of your health, now in one place.</span>
	</div>
	<div class="bar-float">
		<table border="0">
			<tr>
				<td> <span class="medical-icon-i-family-practice icons"></span></td>
				<td>Family Medical Care</td>
				<td> <span class="medical-icon-i-billing icons"></span></td>
				<td>Electronic Medical Billing</td>
				<td> <span class="medical-icon-i-care-staff-area icons"></span></td>
				<td>Well Trained Staff</td>
			</tr>
		</table>
	</div>
	<div class="container">
		<img src="images/logo1.png" style="width:150px; float: left;">
		<h2>Do It The Healthy Way</h2>
		<p>
			We are dedicated to compassionate care, clinical excellence, 
			quality service and a spirit of giving to those entrusted to our care.
			We provide the best produts that suites every individual's health needs and offers altenative health care products. 
		</p>

		<div class="booking-panel">
			<div class="panel-title"><i class="fa fa-envelope" style="font-size: 1.5em;"></i> Quick Message</div>
			<form action="" method="POST" enctype="application/www-forms-urlencoded">
				<div>
					<input type="text" name="name" class="form-input" placeholder="Enter fullname" autofocus required>
				</div>
				<!-- <div>
					<select class="form-input" name="gender">
						<option>Male</option>
						<option>Female</option>
					</select>
				</div> -->
				<div>
					<input type="tel" name="phone" class="form-input" placeholder="Enter mobile" required>
				</div>
				<div>
					<input type="email" name="email" class="form-input" placeholder="Enter Email" required>
				</div>
				<div>
					<textarea name="message" rows="4" class="form-input" placeholder="Type your message here..." required></textarea>
				</div>
				<!-- <div>
					<input type="date" name="appdate" class="form-input" placeholder="yyyy/mm/dd">
				</div>
				<div>
					<input type="time" name="apptime" class="form-input" min="9:00" max="16:00" required maxlength="5" placeholder="00:00 PM">
				</div> -->
				<div>
					<button type="submit" name="send" value="true" class="btn"><i class="fa fa-check"></i> Send Message</button>
				</div>
			</form>
		</div>
	</div>

	<div class="section" id="aboutus">
		<div>
			<h1><i class="fa fa-info-circle"></i> About Us</h1>
			<div class="hr-bar"></div>
			<p>
				Best health is a small business that offers altenative health care products. 
				Best Health was established in 2016 to provide health care supplements to the communities around Pretoria North. We provide the best produts that suites 
				every individual's health needs. Do it The Healthy Way!
			</p>
			<h4>You can find us here:</h4>
			<div class="companyAddr">
				<li><i class="fa fa-phone"></i> 0127133369</li>
				<li><i class="fa fa-mobile fa-1x"></i> 0732622969</li>
				<li><i class="fa fa-envelope"></i> makgathomoloko@gmail.com</li>
				<li><i class="fa fa-map-marker"></i> Chervil Aven, Annlin, Pretoria North</li>
			</div>
		</div>
	</div>

	<footer class="footer">
		<li><a href="#aboutus">About us</a></li>
		<li><a href="#privacy">Privacy Policy</a></li>
		<li><a href="#terms">Terms of use</a></li>
		<li class="pull-center">BestHealth &copy; <?php echo date('Y'); ?> All rights reserved.</li>
	</footer>
	<script type="text/javascript">
		function $(id) {
			return document.querySelector(id);
		}
		function navUp() {
			$('#aboutus').classList.toggle('pullup');
		}
		function reflect() {
			$('.booking-panel').classList.toggle('reflect');
		}
		function closeItem(id) {
			$(id).classList.add('fadeOut');
		}

	</script>
</body>
</html>
