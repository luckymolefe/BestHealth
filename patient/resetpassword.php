<?php

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<style type="text/css">
		body {
			max-width: 100%;
			max-height: 100%;
			background: url('../images/healthcare_bg6.jpg') no-repeat;
			background-size: cover;
			background-position: top center;
			font-family: 'helvetica', arial;
		}
		.container {
			width: 500px;
			max-width: 100%;
			margin: 0 auto;
			border-radius: 5px;
			background-color: rgba(255,255,255, 0.8);
			box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.5);
			padding: 10px;
			margin-top: 80px;
		}
		.header {
			color: rgb(15, 107, 156);
			font-size: 2em;
			font-weight: bold;
			text-align: center;
			border-bottom: thin solid #ddd;
			padding-bottom: 10px;
			margin-bottom: 10px;
		}
		.form-input {
			width: 100%;
			max-width: 100%;
			/*border-radius: 5px;*/
			border: none;
			background-color: transparent;
			color: #777;
			border-bottom: thin solid #5db6d3;
			font-size: 1.2em;
			text-indent: 5px;
			padding-top: 10px;
			padding-bottom: 10px;
			margin-top: 15px;
		}
		.btn {
			width: 150px;
			padding: 10px;
			background-color: rgb(15, 107, 156);
			color: #fff;
			border: thin solid #eee;
			border-radius: 5px;
			font-size: 1em;
			font-weight: bold;
			margin-top: 15px;
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
	</style>
</head>
<body>
	<div class="container">
		<div class="header"><i class="la la-refresh"></i> Password Recovery</div>

		<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
			<div>
				<input type="email" name="email" class="form-input" placeholder="Enter email address" required autofocus>
			</div>
			<!-- <div>
				<input type="password" name="idnumber" class="form-input" placeholder="Enter id number" required>
			</div> -->
			<div>
				<button type="submit" class="btn" name="reset" value="true"><span class="fa fa-lock"></span><i class="la la-refresh"></i> Reset</button>
			</div>
		</form>
		<div class="back-url">
			<a href="login.php">&larr; Login</a> | Password recovery
		</div>
	</div>
</body>
</html>