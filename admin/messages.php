<?php
	require_once('controller.php');
	$admin->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.container-fluid {
			width: 810px;
			max-width: 100%;
			height: 450px;
			margin: 10px 0 0 30px;
			background-color: #f5f5f5;
		}
		.stickybar {
			list-style-type: none;
			position: absolute;
			height: inherit !important;
			background-color: #5db6d3;
			height: auto;
		}
		.stickybar > li:nth-child(1) {
			margin-top: 80px;
		}
		.stickybar > li {
			font-size: 2em;
			background-color: #5db6d3;
			color: #fff;
			padding: 10px 20px;
			border-left: 3px solid #5db6d3;
		}
		.stickybar > li:hover {
			background-color: #28789f;
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
			padding: 15px 0;
			padding-left: 5px;
			color: #777;
			list-style-type: none;
		}
		.message-item:hover {
			background-color: #fff;
			cursor: pointer;
		}
		.seen {
			background-color: #ddd !important;
			color: #999 !important;
		}
		.seen:hover {
			background-color: #ccc !important;
		}
		.item-title {
			font-size: 1.2em;
			color: #777;
			font-weight: bold;
		}
		.item-text {
			color: #aaa;
			margin-top: 5px;
		}
		.item-time {
			float: right;
			font-size: .80em;
			color: #999 !important;
			margin-right: 10px;
		}
		.alert-light {
			color: #5af158;
			filter: drop-shadow(1px 1px 4px #5af158);
			font-size: .55em;
			margin: 5px 0 0 -10px;
			float: right;
		}
		/*------admin view message style--------*/
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
<body onload="getNotification('all');">
	<div class="header"><i class="fa fa-bell"></i> ADMIN NOTIFICATIONS</div>
	<div class="container-fluid">
		<div class="stickybar">
			<!-- <li onclick="getNotification('')" title="Compose Message"><i class="fa fa-edit"></i></li> -->
			<li onclick="getNotification('')" title="Reminders"><i class="fa fa-bell"></i>
				<?php if($notify->unreadMessages() != false || $notify->getBirthdays() != false) { ?>
				<sup><i class="fa fa-circle alert-light"></i></sup>
				<?php } ?>
			</li>
			<li onclick="getNotification('unread')" title="Inbox Messages"><i class="fa fa-envelope"></i>
				<?php if($notify->unreadMessages() != false) { ?>
				<sup><i class="fa fa-circle alert-light"></i></sup>
				<?php } ?>
			</li>
			<li onclick="getNotification('seen')" title="Seen Messages"><i class="fa fa-envelope-open"></i></li>
			<li onclick="getNotification('birthdays')" title="Birthdays">
				<i class="fa fa-gift"></i>
				<?php if($notify->getBirthdays() != false) { ?>
				<sup><i class="fa fa-circle alert-light"></i></sup>
				<?php } ?>
			</li>
		</div>
		<div class="fluid-content" id="results">
			<!-- <li class="message-item">
				<div class="item-title">Message 1 Title <span class="item-time">12:58</span></div>
				<div class="item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
			</li>
			<li class="message-item">
				<div class="item-title">Message 2 Title <span class="item-time">09:05</span></div>
				<div class="item-text">tested balh balh albah</div>
			</li> -->
		</div>
	</div>
</body>
</html>