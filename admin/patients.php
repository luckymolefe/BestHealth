<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.container-fluid {
			width: 850px;
			max-width: 100%;
			height: 400px;
			/*background-color: #f5f5f5;*/
			/*border: thin solid #ccc;*/
			border-radius: 5px;
			margin: 50px auto;
			text-align: center;
			padding: 10px;
		}
		.panel {
			width: 280px;
			/*height: 200px;*/
			max-width: 100%;
			background-color: #f5f5f5;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			list-style-type: none;
			display: inline-block;
			padding: 20px 25px;
			margin: 50px 10px auto;
			text-align: center;
			
		}
		.panel:hover {
			background-color: #eee;
			cursor: pointer;
		}
		.panel-icon {
			font-size: 7em;
			color: rgb(153, 193, 60);
		}
		.panel-title {
			font-size: 2em;
			color: #5d9cec;
			font-weight: bold;
			margin-top: 20px;
		}
		.lead {
			font-size: 2em;
		}
		
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="lead"><i class="medical-icon-i-medical-records"></i> Manage Patients</div>
		<li class="panel" onclick="router('addnew')">
			<div class="medical-icon-i-administration panel-icon"></div>
			<div class="panel-title"><i class="fa fa-plus"></i> Add New</div>
		</li>
		<li class="panel" onclick="router('viewrecords')">
			<div class="medical-icon-i-medical-library panel-icon"></div>
			<div class="panel-title"><i class="la la-clipboard"></i> View Records</div>
		</li>
	</div>
</body>
</html>