<?php
	//password settings hcp
?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health::Choose Login</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			max-width: 100%;
			max-height: 100%;
			background: url('../images/healthcare_bg3.jpg') no-repeat;
			background-size: cover;
			background-position: top center;
			font-family: 'helvetica', 'arial';
		}
		.container {
			width: 700px;
			height: 400px;
			max-width: 100%;
			background: rgb(153, 193, 60);
			color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			margin: 80px auto;
		}
		.panels {
			display: inline-block;
		}
		.panels:nth-child(1) {
			width: 350px;
			height: 400px;
			max-width: 100%;
			max-height: 100%;
			background-color: #bbb;
			background: url('../images/bg_logo.png') no-repeat;
			background-size: cover;
			background-position: top center;
			border-radius: 5px 0 0 5px;
		}
		.panels:nth-child(2) {
			/*background-color: #bbb;*/
			position: absolute;
			padding: 10px;
			margin: 20px auto 0 20px;
			text-align: center;
		}
		.lead {
			color: #fff;
			text-align: center;
			font-size: 1.5em;
		}
		.form-input {
			width: 300px;
			background-color: transparent;
			color: #fff;
			font-size: 1.2em;
			border: none;
			border-bottom: thin solid #fff;
			padding: 5px 0;
			margin: 40px 0;
			text-indent: 30px;
		}
		.form-input:focus {
			border-bottom: thin solid #E8563F;
		}
		.btn {
			width: 65%;
			background-color: rgb(15, 107, 156);
			color: #fff;
			font-size: 1em;
			/*font-weight: bold;*/
			border: none;/* thin solid rgb(15, 107, 156);*/
			border-radius: 50px;
			padding: 5px 0;
			margin: 0;
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
			left: 6px;
			font-size: 2em;
			color: #fff;
			margin-top: 40px;
		}
		.panels:nth-child(2) > div {
			position: relative;
			top: 60px;
		}
		.panels:nth-child(2) > div > a {
			text-decoration: none;
			text-align: center;
			color: rgb(15, 107, 156);
		}
		.panels:nth-child(2) > div > a:hover {
			color: #fff;
		}
		.icon {
			font-size: 1.2em;
			font-weight: bold;
		}
		.alert-notify {
			width: 410px;
			max-width: 100%;
			margin: -70px auto; /*modify to 0*/
			border-radius: 5px;
			background-color: #f36c60;
			color: #e51c23;
			padding: 18px 8px;
			font-weight: bold;
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<li class="panels">&nbsp;</li>
		<li class="panels">
			<h3 class="lead"><i class="la la-refresh icon"></i> Password Recovery</h3>
			<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
				<div>
					<i class="la la-envelope input-icon"></i>
					<input type="email" name="email" class="form-input" placeholder="Enter email" required autofocus>
				</div>
				<div>
					<button type="submit" name="resetpassword" value="true" class="btn"><i class="la la-refresh"></i> Reset password</button>
				</div>
			</form>
			<div>
				<a href="login.php"><i class="la la-arrow-left"></i> Login</a> |
				password reset
			</div>
		</li>
	</div>
	<?php 
		$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		switch ($action) {
			case 'null':
				echo '<div class="alert-notify"><i class="fa fa-warning"></i> Please type your email and password!</div>';
			break;
			case 'invalid':
				echo '<div class="alert-notify"><i class="fa fa-warning"></i> Invalid email address!</div>';
			break;
			case 'failed':
				echo '<div class="alert-notify"><i class="fa fa-warning"></i> Invalid login credentails!</div>';
			break;
		}
	?>
</body>
</html>