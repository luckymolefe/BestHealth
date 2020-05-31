<?php
	//Hcp profile password settings
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 300px;
			height: 200px;
			max-width: 100%;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 2px;
			margin: 50px 10px auto;
			border-bottom: 3px solid #5db6d3;
			display: inline-grid;
			text-align: center;
			transform: translate(50%, 40%);
		}
		.container-fluid:hover {
			border-color: #DA4453;
			cursor: pointer;
		}
		.head-icon {
			font-weight: bold;
			color: #28789f;
			font-size: 8em;
			margin-top: 15px;
			margin-bottom: 5px;
		}
		.icon-title {
			font-size: 1.5em;
			font-weight: bold;
			color: #28789f;
		}
	</style>
</head>
<body>
	<div class="container-fluid" onclick="runAction('profile');">
		<div class="la la-user head-icon"></div>
		<div class="icon-title">Manage Profile</div>
	</div>
	<div class="container-fluid" onclick="runAction('passwords');">
		<div class="la la-unlock head-icon"></div>
		<div class="icon-title">Manage Passwords</div>
	</div>
</body>
</html>