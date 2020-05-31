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
			transform: translate(10%, 20%);
		}
		.container-fluid:hover {
			border-color: #DA4453;
			cursor: pointer;
		}
		.page-head {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 2em;
			border-bottom: thin solid #eee;
			padding: 15px 0; 
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
	<div>
		<div class="page-head"><i class="fa fa-database"></i> Manage Database Backups</div>

		<div class="container-fluid" onclick="runAction('getbackuplogs');">
			<div class="fa fa-database head-icon"></div>
			<div class="icon-title">Backup Logs</div>
		</div>
		<div class="container-fluid" onclick="runAction('download');">
			<div class="fa fa-cloud-download head-icon"></div>
			<div class="icon-title">Download Backup</div>
		</div>
		<div class="container-fluid" onclick="runAction('restore');">
			<div class="la la-history head-icon"></div>
			<div class="icon-title">Restore Backup</div>
		</div>
	</div>
</body>
</html>