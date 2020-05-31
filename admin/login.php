<?php
//Login page best health
?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Heath::Login</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			max-width: 100%;
			max-height: 100%;
			background: url('../images/healthcare_bg7.jpg') no-repeat;
			background-size: cover;
			background-position: top center;
			font-family: 'helvetica', arial;
		}
		.container {
			width: 400px;
			max-width: 100%;
			margin: 0 auto;
			border-radius: 5px;
			background-color: rgb(153, 193, 60, 0.8);
			box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.5);
			padding: 20px 10px;
			margin-top: 80px;
		}
		.header {
			color: #fff;
			font-size: 1.5em;
			font-weight: bold;
			text-align: center;
			/*border-bottom: thin solid #ccc;*/
			padding-bottom: 10px;
			margin-bottom: 10px;
		}
		.form-input {
			width: 100%;
			max-width: 100%;
			background-color: transparent;
			color: #fff;
			border: none;
			border-bottom: thin solid #eee;
			font-size: 1.2em;
			text-indent: 5px;
			padding-top: 10px;
			padding-bottom: 10px;
			margin-bottom: 20px;
			text-indent: 40px;
		}
		.form-input:focus {
			border-bottom: thin solid #E8563F;
		}
		.input-icon {
			position: absolute;
			font-size: 3em;
			color: #fff;
			margin: 18px 0 0 -70px;
		}
		.form-label {
			color: #fff;
			font-size: .85em;
		}
		.btn {
			width: 150px;
			background-color: rgb(15, 107, 156);
			color: #fff;
			border: none;
			border-radius: 50px;
			font-size: 1em;
			font-weight: bold;
			padding: 8px;
			margin: 10px 0 20px 0;
		}
		.btn:hover {
			background-color: rgb(93, 182, 211);
			cursor: pointer;
		}
		.btn:active {
			background-color: rgb(9, 73, 102);
			cursor: pointer;
		}
		form > div > a {
			text-decoration: none;
			color: rgb(15, 107, 156);
		}
		form > div > a:hover {
			color: #fff;
		}
		.alert-notify {
			width: 410px;
			max-width: 100%;
			margin: 10px auto;
			border-radius: 5px;
			background-color: #f36c60;
			color: #e51c23;
			padding: 18px 8px;
			font-weight: bold;
			text-align: center;
		}
	</style>
	<script type="text/javascript"></script>
</head>
<body>
	<div class="container">
		<div class="header"><i class="medical-icon-i-care-staff-area"></i> Admin</div>

		<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
			<div>
				<label class="form-label">Username:</label>
				<i class="la la-user input-icon"></i>
				<input type="email" name="username" class="form-input" placeholder="Enter username" required autofocus>
			</div>
			<div>
				<label class="form-label">Password:</label>
				<i class="la la-unlock input-icon"></i>
				<input type="password" name="password" class="form-input" placeholder="Enter password" required>
			</div>
			<div>
				<button class="btn" name="login" value="true"><span class="fa fa-sign-in"></span> Continue</button>
			</div>
			<div align="center">
				<a href="../login.php"><i class="la la-arrow-left"></i> Back</a> |
				<a href="resetpassword.php">Forgot password?</a>
			</div>
		</form>
	</div>
	<?php 
		$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		switch ($action) {
			case 'unsuccessful':
	?>
				<div class="alert-notify"><i class="fa fa-warning"></i> Invalid login credentails!</div>
	<?php
				break;
		}
	?>
</body>
</html>