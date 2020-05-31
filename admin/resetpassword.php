<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health::Password Recovery</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
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
			color: #fff;
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
			padding-top: 10px;
			padding-bottom: 10px;
			margin-bottom: 20px;
			text-indent: 33px;
		}
		.form-input:focus {
			border-bottom: thin solid #E8563F;
		}
		.input-icon {
			position: absolute;
			font-size: 1.6em;
			color: #fff;
			margin: 28px 0 0 -100px;
		}
		.form-label {
			color: #fff;
			font-size: .85em;
			font-weight: bold;
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
		.back-url  {
			text-align: center;
			padding: 15px 0;
		}
		.back-url > a {
			color: rgb(15, 107, 156);
			text-decoration: none;
		}
		.back-url > a:hover {
			color: rgb(153, 193, 60);
		}
		.back-url > a {
			text-decoration: none;
			color: rgb(15, 107, 156);
		}
		.back-url > a:hover {
			color: #fff;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header"><i class="fa fa-refresh"></i> Password Recovery</div>

		<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
			<div>
				<label class="form-label">Email Address:</label>
				<i class="fa fa-envelope-o input-icon"></i>
				<input type="email" name="email" class="form-input" placeholder="Enter email address" required autofocus>
			</div>
			<div>
				<button type="submit" class="btn" name="reset" value="true"><i class="fa fa-refresh"></i> Reset</button>
			</div>
		</form>
		<div class="back-url">
			<a href="login.php">&larr; Login</a> | Password recovery
		</div>
	</div>
</body>
</html>