<?php
	//HCP profile password settings
	require_once('controller.php');
	$hcp->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 500px;
			max-width: 100%;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			margin: 50px auto;
			padding: 10px;
		}
		.form-head {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 1.3em;
			border-bottom: thin solid #eee;
			margin-bottom: 10px;
			padding-bottom: 5px; 
		}
		.form-control {
			width: 495px;
			border-radius: 5px;
			border: thin solid #ccc;
			padding: 10px 0;
			color: #777;
			text-indent: 5px;
			font-size: 1em;
			margin-bottom: 10px;
		}
		.form-control:focus {
			border: thin solid #17EAD9;
			outline: none;
			filter: drop-shadow(1px 1px 4px #17EAD9);
		}
		.btn {
			width: 150px;
			background-color: #28789f;
			color: #fff;
			border: thin solid #fff;
			border-radius: 5px;
			padding: 10px 2px;
			font-weight: bold;
		}
		.btn:hover {
			background-color: #5db6d3;
			cursor: pointer;
		}
		.btn:active {
			background-color: #094966;
		}
		
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="form-head">Change Password</div>
		<form action="controller.php" method="POST" enctype="application/www-form-urlencoded">
			<div>
				<input type="text" name="newpassword" class="form-control" placeholder="Enter New password">
			</div>
			<div>
				<input type="text" name="confirmpassword" class="form-control" placeholder="Confirm new password">
			</div>
			<div>
				<button type="submit" name="savesettings" class="btn" value="true"><i class="fa fa-save"></i> Save</button>
			</div>
		</form>
	</div>
</body>
</html>