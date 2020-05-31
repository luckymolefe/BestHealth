<?php
	//Patient Notifications Management
	require_once('controller.php');
	$patient->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			position: fixed;
			width: 810px;
			max-width: 100%;
			height: 450px;
			margin: 10px 0 0 30px;
			background-color: #dd0000;
		}
		.stickybar {
			list-style-type: none;
			position: absolute;
			height: inherit !important;
			background-color: #28789f;
		}
		.stickybar > li {
			font-size: 2em;
			background-color: rgb(40, 120, 159);
			color: #fff;
			padding: 12px 20px;
			border-left: 3px solid rgb(40, 120, 159);
		}
		.stickybar > li:nth-child(1) {
			margin-top: 100px;
		}
		.stickybar > li:hover {
			background-color: rgb(93, 182, 211);
			/*color: #28789f;*/
			border-left: 3px solid rgb(153, 193, 60);
			cursor: pointer;
		}
		.fluid-content {
			position: fixed;
			overflow-y: auto;
			width: inherit;
			height: inherit;
			background-color: #e5e5e5;
			display: flex-inline;
			margin-left: 75px;
			/*text-indent:  10px;*/
		}
		.message-item {
			background-color: #f5f5f5;
			color: #777;
			padding: 15px 0;
			padding-left: 5px;
			list-style-type: none;
		}
		.message-item:hover {
			background-color: #efefef;
			cursor: pointer;
		}
		.message-item.seen-item {
			background-color: #dedede !important;
		}
		.item-title {
			font-size: 1.2em;
			color: #777;
			font-weight: bold;
		}
		.item-text {
			color: #aaa;
		}
		.item-time {
			float: right;
			font-size: .80em;
			color: #999 !important;
			margin-right: 10px;
		}
		.seen {
			color: #bbb !important;
		}
		.alert-light {
			color: #5af158;
			filter: drop-shadow(1px 1px 4px #5af158);
			font-size: .55em;
			margin: 5px 0 0 -10px;
			float: right;
		}
		.header {
			font-size: 1.3em;
			color: #5db6d3;
			border-bottom: thin solid #ccc;
			padding: 10px 0;
			text-indent: 25px;
		}
		.card-icon {
			border: thin solid #ccc;
			border-radius: 3px;
			padding: 1px 4px;
		}
		.fa-image {
			color: #5D9CEC;
		}
		.birthday-card {
			margin-top: 15px;
		}
		/*birthday card design CSS*/
		.card-item {
			position: absolute;
			background-color: #f5f5f5;
			color: #777;
			width: 100%;
			max-width: 100%;
			margin: 0 auto;
			height: auto;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			text-align: center;
			padding-bottom: 10px;
			z-index: 5;
			/*transform: translate(129%);*/
			/*animation: zoomIn 1s ease-in 1s forwards;*/
			display: block;
		}
		.card-item > img {
			width: 100%;
			height: 350px;
		}
		.card-title {
			font-weight: bold;
			font-size: 1.8em;
			color: rgb(153, 193, 60);
			margin: 10px 0;
		}
		.card-text {
			color: #777;
			margin: 10px 0;
		}
		@keyframes zoomIn {
		 from {
		 	display:  block;
		 	transform: scale(0);
		 }
		 to {
		 	transform: scale(1);
		 }
		}
		/*------View message style--------*/
		.view-item {
			position: absolute;
			background-color: #f9f9f9;
			color: #777;
			width: 100%;
			height: 430px;
			max-width: 100%;
			margin: 0 auto;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 10px 0;
			display: block;
			/*text-indent: 2px;*/
			/*z-index: 5;*/
		}
		.view-title {
			font-size: 1.2em;
			color: #777;
			font-weight: bold;
		}
		.title-small {
			font-size: .70em !important;
			margin-top: -3px;
		}
		.view-text {
			color: #999;
			margin: 10px 0;
			padding: 10px 0;
			margin-left: 15px;
		}
		.view-time {
			position: absolute;
			top: 10px;
			right: 15px;
			/*float: right;*/
			font-size: .80em;
			color: #777 !important;
			/*margin-top: -20px;*/
			margin-right: 10px;
		}
		.separator {
			margin-top: 10px;
			border-bottom: thin solid #ddd;
		}
		.label-icon {
			position: relative;
			top: -2px;
			width: 20px;
			background-color: #3f51b5;
			color: #fff;
			border-radius: 50%;
			padding: 8px;
			margin-right: 15px;
			margin-left: 5px;
			float: left;
			text-align: center;
		}
		.signature {
			margin-top: 100px;
		}
		.footer {
			position: absolute;
			bottom: 0px;
			transform: translate(300%);
			font-size: .75em;
			text-align: center;
			color: #ccc;
		}
	</style>
</head>
<body onload="return updateAlerts('allmessages');">
	<div class="page-header"><i class="fa fa-bell"></i> My Notifications</div>
	<div class="container-fluid">
		<div class="stickybar">
			<li onclick="updateAlerts('reminder')" title="Reminders"><i class="fa fa-bell"></i>
				<?php if($notify->openBirthdayAlerts($_SESSION['patient']['pid']) != "0") { ?>
				<sup><i class="fa fa-circle alert-light"></i></sup>
				<?php } ?>
			</li>
			<li onclick="updateAlerts('unread')" title="Inbox Messages"><i class="fa fa-envelope"></i>
				<?php if($patient->retrieveInbox($_SESSION['patient']['pid'])) { ?>
				<sup><i class="fa fa-circle alert-light"></i></sup>
				<?php } ?>
			</li>
			<li onclick="updateAlerts('seen')" title="Seen Messages"><i class="fa fa-envelope-open"></i></li>
		</div>
		<div class="fluid-content" id="results">
			<!-- messages will be injected here by javascript -->
		</div>
	</div>
</body>
</html>