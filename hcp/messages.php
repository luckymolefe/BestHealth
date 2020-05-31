<?php
	//hcp message management
	require_once('controller.php');
	$hcp->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 99%;
			max-width: 100%;
			height: 450px;
			background-color: #fff;
			display: inline-flex;
			border: thin solid #eee;
		}
		.lead {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 2em;
			border-bottom: thin solid #eee;
			margin-bottom: 10px;
			padding-bottom: 5px; 
		}
		.sidenav {
			width: 200px;
			height: inherit;
			background-color: #2C3E50;
			list-style-type: none;
			z-index: 1;
		}
		.sidenav-item {
			color: #fff;
			padding: 12px 2px;
			font-weight: bold;
			text-indent: 5px;
			margin-top: 2px;
		}
		.sidenav-item:hover {
			background-color: #34495E;
			cursor: pointer;
		}
		.sidenav-item:active {
			background-color: #555;
		}
		.sidenav-item:nth-child(1) {
			margin-bottom: 60px;
		}
		.sidenav-item:nth-child(1):hover {
			cursor: default;
			background-color: transparent;
		}
		.badge {
			background-color: #3498DB;
			border-radius: 50%;
			padding: 2px 6px;
		}
		.message-content {
			width: 80%;
			height: inherit;
			max-height: inherit;
			overflow-y: auto;
			background-color: #f9f9f9;
			/*display: inline-flex;*/
			position: absolute;
			right: 10px;
		}
		.message-item {
			display: block;
			background-color: #fff;
			color: #777;
			padding: 10px 5px !important;
			margin-bottom: 1px;
			text-indent: 10px;
		}
		.message-item:hover {
			background-color: #DFE3EE;/*#f5f5f5;*/
			cursor: pointer;
		}
		.compose-form {
			width: 85%;
			max-width: 100%;
			margin: 5px auto;
		}
		.form-title {
			color: #4E5F70;
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
		}
		.form-control {
			width: 100%;
			color: #777;
			background-color: transparent;
			border: none;
			border-bottom: thin solid #ccc;
			border-radius: 1px;
			color: #777;
			padding: 12px 0;
			margin-top: 15px;
			text-indent: 18px;
		}
		.btn {
			float: right;
			width: 150px;
			background-color: #bbb;
			color: #fff;
			border: none;
			padding: 10px 5px;
			background-color: #34495E;
			margin: 8px 0;
		}
		.btn:hover {
			background-color: #4E5F70;
			cursor: pointer;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.btn:active {
			background-color: #2C3E50;
		}
		textarea {
			resize: none;
		}
		.msg-icon {
			position: absolute;
			color: #777;
			margin-top: 28px;
		}
		.item-sender {
			/*font-weight: bold;*/
		}
		.item-timestamp {
			position: relative;
			top: 0;
			float: right;
		}
		.item-text {
			margin-top: 5px;
		}
		.strong {
			font-weight: bold;
		}
		.seen {
			background-color: #f5f5f5;
		}
		.body_obj {
			background-color: tomato;
			color: #fff;
			text-align: center;
			padding: 2px 4px;
			border-radius: 3px;
		}
		.alert-error {
			width: 100%;
			max-width: 100%;
			margin: 10px auto;
			border-radius: 5px;
			background-color: #b3e5fc;
			color: #29b6f6;
			padding: 18px 0px;
			font-weight: bold;
			text-align: center;
			display: none;
		}
		.danger {
			background-color: #f36c60;
			color: #e51c23;
		}
		.success {
			background-color: #72d572;
			color: #2baf2b;
		}
	</style>
</head>
<body onload="return runAction('retrieveAll');">
	<div class="lead"><i class="fa fa-envelope"></i> Messages</div>
	<div class="container-fluid">
		<div class="sidenav">
			<li class="sidenav-item"></li>
			<li class="sidenav-item" onclick="runAction('compose')"><i class="fa fa-plus"></i> Compose New</li>
			<li class="sidenav-item" onclick="runAction('retrieveInbox')">
				<i class="fa fa-inbox"></i> Inbox
				<span class="badge">
				<?php
					echo ($notify->unreadMessages('doctor@besthealth.com') != false) ?
			  		  count($notify->unreadMessages('doctor@besthealth.com')) : '0'; 
			  	?>
				</span>
			</li>
			<!-- <li class="sidenav-item"><i class="fa fa-bell-o"></i> Notifications</li> -->
			<li class="sidenav-item" onclick="runAction('birthdays')"><i class="fa fa-birthday-cake"></i> Birthdays</li>
		</div>
		<div class="message-content">
			<!-- message data dynamically injected via javascript -->
		</div>
	</div>
</body>
</html>