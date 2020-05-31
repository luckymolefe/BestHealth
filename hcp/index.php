<?php
	//index for best health
	require_once('controller.php');
	$hcp->protected_page();
	#$hcp->obsoleteAppointments(); //call to check for obsoleteAppointments
	$upcoming = $hcp->upcomingApp();
	$allInboxMsg = $hcp->getInbox();

	/*$namesArr = array('Dusty Miller', 'Malcolm Felt', 'Helen West', 'Jason Smith', 'Christopher Bouwel');
	$messagesArr = array('We are glad you decided to Account..', 'The Monthly report you requested for available..', 'You had a new sale and earned report..', 'Let\'s start by letting you know that..', 'It has come to my attention that..');
	$timeArr = array('Just now', '2min ago', '10min ago', '1week ago', '2 weeks ago');

	$dateArr = array('Today', '8/6/2019', '3/5/2019', '21/4/2019', '');
	$durationArr = array('5 PM', '6 PM', '8 PM', '9 PM', '');
	$statusArr = array('Confirmed', 'Confirmed', 'Pending', 'Cancelled', '');*/

?>
<!DOCTYPE html>
<html>
<head>
	<title>Best Health::Home</title>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			font-family: helvetica, arial;
		}
		.nav {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: auto;
			background-color: rgb(93, 182, 211);
			z-index: 3;
			padding: 5px;
		}
		.nav-item {
			list-style-type: none;
			display: inline-block;
		}
		.nav-item > a {
			padding: 0 0 0 10px;
			text-decoration: none;
			background-color: #5db6d3;
			border-radius: 5px;
			color: #fff;
			padding: 8px;
		}
		.nav-item > a:hover {
			background-color: #28789f;
		}
		.nav-item > img {
			position: absolute;
			top: 0px;
			width: 45px;
			max-width: 100%;
		}
		.nav-item:nth-child(2) {
			position: relative;
			left: 25%;
		}
		.nav-item:nth-child(3) {
			position: relative;
			left: 62%;
		}
		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: 250px;
			height: 800px;
			background-color: rgb(15, 107, 156);
			z-index: 2;
			padding-top: 40px;
			/*font-size: 1.2em;*/
		}
		.bar-item {
			list-style-type: none;
			border-left: 5px solid transparent;
			padding: 10px 5px;
			margin-top: 5px;
			color: #fff;
		}
		.bar-item:hover {
			background-color: #28789f;
			border-left: 5px solid #5db6d3;
			cursor: pointer;
		}
		.bar-item > span {
			font-size: 1.3em;
			padding-right: 5px;
		}
		.bar-item > a {
			text-decoration: none;
			color: #fff;
		}
		.bar-item:nth-child(1), .bar-item:nth-child(1):hover {
			border-left: none;
			background-color: transparent;
		}
		.container {
			position: fixed;
			top: 8%;
			left: 20%;
			width: 78%;
			max-width: 100%;
			height: 100%;
			border-radius: 2px;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
			background-color: #fff;
		}
		.form-input {
			width: 300px;
			max-width: 100%;
			border: none;
			border-radius: 5px 0 0 5px;
			text-indent: 5px;
			color: #777;
			padding: 6px;
		}
		.btn-search {
			width: 35px;
			padding: 6px;
			background-color: #fff; /*rgb(15, 107, 156);*/
			color: rgb(15, 107, 156);
			border: none;
			border-radius: 0 5px 5px 0;
			font-weight: bold;
		}
		.form-input, .btn-search {
			border-top: thin solid;
			border-bottom: thin solid;
			border-color: #999 !important;
			filter: drop-shadow(1px 2px 4px, #fff);
		}
		.form-input {
			border-left: thin solid;
		}

		.btn-search {
			border-right: thin solid;
			margin-left: -10px;
		}
		.btn-search:hover {
			background-color: #fff;
			cursor: pointer;
		}
		.btn-search:active {
			background-color: #f5f5f5;
			cursor: pointer;
		}
		.profile-avatar {
			width: 110px;
			margin-bottom: 10px;
		}
		.notify {
			position: absolute;
			border-radius: 50%;
			width: 15px;
			height: 15px;
			background-color: rgb(153, 193, 60);
			color: #fff;
			padding: 5px;
			margin-left: -10px;
			text-align: center;
			font-weight: bold;
			line-height: 1.5;
		}
		.header {
			color: rgb(15, 107, 156);
			border-bottom: thin solid #ddd;
			margin-top: 15px;
			padding-left: 30px;
		}
		.panels {
			width: 300px;
			height: auto;
			border-radius: 2px;
			border-bottom: 2px solid #5db6d3;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
			display: inline-block;
			margin-left: 10px;
			margin-bottom: 10px;
			padding: 10px;
			cursor: pointer;
		}
		.panels:hover {
			border-bottom: 2px solid #F1C40F; /*#F39C12;*/ /*rgb(153, 193, 60);*/
		}
		.panels:active {
			border-bottom: 2px solid #ED5565;/*rgb(153, 193, 60);*/
		}
		/*.close-panel {
			float: right;
			color: #bbb;
			cursor: pointer;
		}
		.close-panel:hover {
			color: #777;
			cursor: pointer;
		}*/
		.appointment-panel {
			width: 485px;
			height: 280px;
			border-radius: 0px;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
			display: inline-block;
			margin-left: 10px;
			margin-top: 10px;
			padding: 5px;
		}
		.message-panel {
			width: 485px;
			height: 280px;
			border-radius: 0px;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
			display: inline-block;
			margin-left: 10px;
			margin-top: 10px;
			padding: 5px;
		}
		.panels table tr td {
			border-bottom: none;
			padding: 4px;
		}
		.panel-head {
			font-weight: bold;
			color: #5db6d3;
		}
		.panel-icon {
			font-size: 5em;
			color: #28789f;
		}
		.panel-text {
			color: #777;
		}
		.panel-header {
			background-color: rgb(15, 107, 156);
			color: #fff;
			padding: 15px;
			margin: -5px -5px 0 -5px;
			font-weight: bold;
		}
		.view-link {
			float: right;
			margin: 5px 10px 0 0;
			font-weight: bold;
		}
		.view-link > a {
			text-decoration: none;
			color: #5db6d3;
		}
		.view-link > a:hover {
			color: #28789f;
			text-decoration: underline;
		}
		table {
			width: 100%;
			border: none;
			margin-top: 10px;
		}
		th {
			border-bottom: 2px solid #bbb;
			color: #666;
			padding: 8px;
			text-align: left;
		}
		tr > td {
			border-bottom: thin solid #ccc;
			padding: 8px;
			font-size: 0.85em;
			color: #777;
		}
		.status {
			padding: 3px 5px;
			background-color: #bbb;
			color: #fff;
			border-radius: 5px;
		}
		.status.success {
			background-color: #72d572;
			color: #FFF;
		}
		.status.warning  {
			background-color: #f2ae72;
			color: #FFF;
		}
		.status.danger {
			background-color: #dd0000;
			color: #FFF;
		}
		.alert-notify {
			width: 500px;
			max-width: 100%;
			margin: 80px auto; /*modify to 0*/
			border-radius: 5px;
			background-color: #f36c60;
			color: #e51c23;
			padding: 18px 8px;
			font-weight: bold;
			text-align: center;
		}
		.loader {
			text-align: center;
			color: #777;
			margin-top: 100px;
			font-size: 2em;
		}
		.searched {
			color: #28789f;
			font-size: 1.5em;
			font-style: italic;
			font-weight: bold;
			margin: 15px 0 10px 5px;
		}
		.search-result {
			background-color: #f5f5f5;
			color: #777;
			border-bottom: thin solid #ccc;
			padding: 10px 5px;
			text-indent: 5px;
			font-size: .85em;
		}
		.search-result:hover {
			background-color: #f9f9f9;
			cursor: pointer;
		}
		.title-name {
			color: #5db6d3;
			font-size: 1.5em;
			font-weight: bold;
		}
		.alert-notify {
			width: 100%;
			max-width: 100%;
			margin: 10px auto;
			border-radius: 5px;
			background-color: #b3e5fc;
			color: #29b6f6;
			padding: 18px 0px;
			font-weight: bold;
			text-align: center;
		}
		.reminderAlert {
			position: absolute;
			transform: translate(150%, 20%);
			width: 350px;
			height: 300px;
			max-width: 100%;
			margin: 40px auto;
			background-color: #f5f5f5;
			color: #777;
			border-radius: 5px;
			/*padding-top: 10px;*/
			text-align: center;
			z-index: 2;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			display: none;
		}
		.reminderAlert > .icon {
			font-size: 6.5em;
			color: rgb(153, 193, 60);
			background-color: transparent;
			border-radius: 5px 5px 0 0;
			margin-bottom: 10px;
			padding: 5px 0;
			animation: shake 5s ease-in-out forwards;
			/*animation-delay: .55s;*/
		}
		.reminderAlert > .alert-header {
			font-weight: bold;
			font-size: 1.2em;
			color: #777;
			margin-bottom: 10px;
		}
		.reminderAlert > .textMessage {
			color: #777;
		}
		.close {
			position: absolute;
			left: 0;
			bottom: 0;
			width: 100%;
			max-width: 100%;
			padding: 15px 0;
			background-color: #9ED36A;/*rgb(153, 193, 60);*/ /*rgb(93, 182, 211);*/
			color: #fff;
			border: none;
			border-radius: 0 0 5px 5px;
			font-weight: bold;
			font-size: .88em;
		}
		.close:hover {
			cursor: pointer;
			background-color: #B4E080;/*#A0CF6E;*/
		}
		.close:active {
			background-color: #8AC054;
		}
		@keyframes shake {
			1% {
				transform: rotateZ(15deg);
				transform-origin: 50% 0;
			}
			2% {
				transform: rotateZ(-15deg);
				transform-origin: 50% 0;
			}
			3% {
				transform: rotateZ(20deg);
				transform-origin: 50% 0;
			}
			4% {
				transform: rotateZ(-20deg);
				transform-origin: 50% 0;
			}
			5% {
				transform: rotateZ(15deg);
				transform-origin: 50% 0;
			}
			6% {
				transform: rotateZ(-15deg);
				transform-origin: 50% 0;
			}
			7% {
				transform: rotateZ(0);
				transform-origin: 50% 0;
			}
			100% {
				transform: rotateZ(0);
				transform-origin: 50% 0;
			}
		}
		.close-alert {
			position: absolute;
			top: 6px;
			right: 8px;
			color: #777;
			z-index: 1;
		}
		.close-alert:hover {
			color: #ff0000 !important;
			cursor: pointer;
		}

		.custom-alert {
			position: absolute;
			width: 500px;
			height: 200px;
			max-height: 100%;
			margin: 80px 0 0 500px;
			background-color: tomato;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.4);
			border-radius: 5px;
			z-index: 5;
			/*transform: translate(100%, 30%);*/
			display: none;
			animation: zoomIn .2s ease-in;
		}
		.watermark {
			position: fixed;
			margin-top: -20px;
			margin-left: -200px;
			font-size: 7em;
			z-index: -1;
			color: #fc7158;
			transform: rotateZ(-30deg);
		}
		.alert-head {
			position: relative;
			top: 0;
			background-color: #dd0000;
			color: #fff;
			font-weight: bold;
			padding: 10px 10px;
			border-radius: 5px 5px 0 0;
		}
		.alert-text {
			position: relative;
			color: #fff;
			padding: 5px 10px;
			margin: 20px 0;
			text-align: center;
		}
		.alert-footer {
			width: 100%;
			position: absolute;
			bottom: 0;
			background-color: transparent;
			padding: 12px 0;
		}
		.fa-times-circle {
			position: absolute;
			right: 10px;
			cursor: pointer;
			color: #fff;
		}
		.fa-times-circle:hover {
			color: tomato !important;
		}
		.btn-alert {
			width: auto;
			background-color: #dd0000;
			color: #fff;
			border: none;
			border-radius: 2px;
			padding: 8px 10px;
			font-weight: bold;
			cursor: pointer;
		}
		.btn-alert:hover {
			background-color: red;
		}
		@keyframes zoomIn {
			from { transform: scale(0); }
			to { transform: scale(1); }
		}
		.logs {
			width: 500px;
			max-width: 100%;
			height: 400px;
			max-height: 450px;
			margin: 0 auto;
			overflow-y: auto;
			border-radius: 5px;
			background-color: #f5f5f5;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.log-item {
			background-color: skyblue;
			color: #2980B9;
			margin: 2px 0;
			padding: 10px;
			text-indent: 2px;
		}
		.log-item:hover { 
			background-color: lightblue;
			color: #E74C3C;
			cursor: pointer;
		}
		.log-item:active { 
			background-color: royalblue;
			color: #fff;
			cursor: pointer;
		}
		.log-notify {
			background-color: tomato;
			color: #fff;
			text-align: center;
			padding: 15px;
			font-weight: bold;
		}
		.log-head {
			background-color: #2980B9;
			color: #fff;
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
			padding: 10px 0;
		}
		/* Notification alert custom window */
		.custom-notify {
			position: relative;
			width: 300px;
			max-width: 100%;
			margin: 80px auto;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			z-index: 5;
			border-radius: 5px;
			text-align: center;
			animation: test .2s ease-in;
			display: none;
		}
		.notify-icon {
			width: 100%;
			font-size: 5em;
			background-color: #8CC152;
			color: #A0D468;
			padding: 10px 0;
		}
		.notify-title {
			font-size: 1.5em;
			font-weight: bold;
			color: #8CC152;
			padding: 10px 0;
		}
		.notify-text {
			color: #777;
			padding: 0 5px;
			margin-bottom: 10px; 
		}
		.notify-btn-ok {
			width: 150px;
			padding: 6px 0;
			border: none;
			border-radius: 50px;
			margin: 15px 0;
			background-color: #A0D468;
			color: #fff;
			font-weight: bold;
			cursor: pointer;
		}
		.notify-btn-ok:hover {
			background-color: #2ECC71;
		}
		.notify-btn-ok:active {
			background-color: #8CC152;
		}
		/*----*/
		.popupWin {
			position: relative;
			width: 400px;
			max-width: 100%;
			height: 300px;
			max-height: 300px;
			overflow-y: auto;
			margin: 80px auto;
			background-color: #fff;
			color: #777;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			padding: 8px 5px;
			z-index: 4;
			display: none;
			animation: zoomIn .2s ease-in;
		}
		.closeWin {
			float: right;
			color: tomato;
			cursor: pointer;
		}
		.popupTitle {
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
			color: #28789f;
			border-bottom: thin solid #eee;
			margin: 0 0 20px 0;
			padding-bottom: 5px;
		}
		.popupItem {
			background-color: #28789f;
			color: #fff;
			padding: 5px 2px;
			margin: 2px 0;
		}
		.popupItem:hover {
			background-color: #5db6d3;
			color: #fff;
			cursor: pointer;
		}
		.db_mark {
			position: absolute;
			margin: 50px 0 0 120px;
			color: #eee;
			/*transform: rotateZ(-30deg);*/
			font-size: 10em;
			z-index: -1;
		}
		.tooltip {
			position: absolute;
			top: 30px;
			left: 100px;
			/*visibility: hidden;*/
			width: auto;
			max-width: 100%;
			overflow-wrap: break-word;
			background-color: rgba(9, 73, 102, 0.8);
			color: #fff;
			text-align: center;
			padding: 5px 3px;
			border-radius: 6px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			z-index: 5;
			animation: moveObj 5s ease-in-out forwards;
			animation-delay: 1s;
			/*opacity: 0;*/
		}
		.tooltip::after {
			content: " ";
			position: absolute;
			top: 100%;
			left: 50%;
			margin-left: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: royalblue transparent transparent transparent;
		}
		.tooltip.add {
			animation: unset;
			visibility: visible;
			top: unset;
			left: unset;
			right: 40px;
			transform: scale(0);
			animation: showTooltip .55s ease-in-out forwards, hideTooltip .55s ease-in-out forwards;
			animation-delay: 6s, 9s;
		}
		.add::after {
			content: " ";
			position: absolute;
			top: unset;
			bottom: 100%;
			left: 50%;
			margin-left: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: transparent transparent royalblue transparent;
		}
		.tooltip.create {
			position: absolute;
			animation: unset;
			top: 235px;
			right: -150px;
			left: 180px;
			background-color: rgba(0, 0, 0, 0.6);
			transform: scale(0);
			animation: showTooltip .55s ease-in-out forwards, hideTooltip .55s ease-in-out forwards;
			animation-delay: 9s, 12s;
		}
		.create::after {
			content: " ";
			position: absolute;
			top: unset;
			bottom: 45%;
			left: -5px;
			border-width: 5px;
			border-style: solid;
			border-color:  transparent rgba(0, 0, 0, 0.6) transparent  transparent;
		}
		@keyframes moveObj {
			0% { transform: translate(0px); visibility: visible; }
			50% { transform: translate(300px);  }
			100% { transform: translate(650px); visibility: hidden; }
		}
		@keyframes showTooltip {
			from { transform: scale(0); }
			to { transform: scale(1); }
		}
		@keyframes hideTooltip {
			from { transform: scale(1); }
			to { transform: scale(0); }
		}
		.caution {
			background-color: #F5BA45; /*#FECD57;*/
		}
		/*notification popup CSS*/
		.popup {
			position: relative;
			left: 35%;
			float: left;
			width: 300px;
			height: auto;
			max-width: 100%;
			margin: 50px auto;
			background-color: #fff;
			color: #777;
			padding: 15px 10px;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			text-align: center;
			z-index: 2;
			transform: scale(0);
			animation: popin .50s ease-in forwards;
			/*animation-delay: 2s;*/
		}
		.popup-title {
			font-weight: bold;
			font-size: 1.5em;
			color: #8AC054;
			padding: 10px 0;
		}
		.popup-message {
			margin: 10px 0;
		}
		.popup-icon {
			font-size: 5em;
			border: thin solid #8AC054;
			color: #8AC054;
			border-radius: 50%;
			padding: 10px;
			/*transform: scale(0);*/
			/*animation: popin .50s ease-in forwards;*/
		}
		@keyframes popin {
			form { transform: scale(0); }
			to { transform: scale(1); }
		}
		.btn-close {
			width: 150px;
			background-color: #8AC054;
			color: #fff;
			font-weight: bold;
			border: none;
			border-radius: 50px;
			padding: 5px 0;
			margin: 10px 0;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
		}
		.btn-close:hover {
			cursor: pointer;
			background-color: #b4e080;
		}
		.btn-close:active {
			background-color: #8AC054;
		}
		.btn-link {
			background-color: #28789f;
			color: #fff;
			padding: 5px 8px;
			border-radius: 5px;
			margin-left: 15px;
			text-decoration: none;
		}
		.btn-link:hover {
			background-color: #5db6d3;
		}
		.btn-link:active {
			background-color: #094966;
		}
		.log-view {
			background-color: #f9f9f9;
			color: #222;
			padding: 10px 10px;
			margin: 5px 10px;
		}
	</style>
	<script type="text/javascript">

	</script>
</head>
<body onload="return updateBirthdayAlerts();">
	
	<!-- window popup for database restore -->
	<div class="popupWin">
		<i class="la la-history db_mark"></i>
		<i class="fa fa-times closeWin" title="Close window" onclick="closeItem('.popupWin');"></i>
		<div class="popupTitle"><i class="la la-history"></i> Restore Database</div>
		<div><label>Select your SQL backup file to upload:</label>
			<input type="file" id="db_file" name="db_file">
			<button type="button" class="btn-alert" accept="text/.sql" name="uploadBackup" id="uploadBackup"><i class="fa fa-cloud-upload"></i> Upload</button>
			<button type="button" class="btn-alert" onclick="deleteAll()"><i class="fa fa-trash"></i> Delete Backups</button>
		</div>
		<div>
			<?php
				$dirpath = $basepath."backups/";
				$files = scandir($dirpath);
				rsort($files); //reverse sort array
				if(is_dir($dirpath)) {
					if(count($files) > 2) {
					$count = 1;
					foreach($files as $file):
						if(!is_dir($file)) :
			?>
							<div class='popupItem' onclick="runAction('dorestore', '<?php echo $file ?>')"> <?php echo $count++.') '.$file; ?></div>
			<?php
						endif;
					endforeach;
					} else {
						echo "<div><center>No backups available!</center></div>";
					}
				}
			?>
		</div>
	</div>

	<?php
		$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		if($action=="success") {
	?>
		<div class="popup">
			<i class="la la-check popup-icon"></i>
			<div class="popup-title">Success</div>
			<div class="popup-message">Action executed successfully.</div>
			<div class=""></div>
			<button class="btn-close" title="Close" onclick="closeItem('.popup')">Close</button>
		</div>
	<?php } elseif($action=="null" || $action=="failed") { ?>
		<div class="popup">
			<i class="fa fa-warning popup-icon warning"></i>
			<div class="popup-title warning">Failed</div>
			<div class="popup-message">Action execution Failed!.</div>
			<div class=""></div>
			<button class="btn-close warning" title="Close" onclick="closeItem('.popup')">Close</button>
		</div>
	<?php } ?>

	<!-- Alert popup response notify-->
	<div class="custom-notify">
		<span><i class="fa fa-check-circle notify-icon"></i></span>
		<div class="notify-title">Success!</div>
		<div class="notify-text">Appointment booked successfully!.</div>
		<button type="button" class="notify-btn-ok" onclick="closeItem('.custom-notify')">Close</button>
	</div>

	<!-- Confirm popup alert -->
	<div class="custom-alert">
		<div class="alert-head">
			<i class="fa fa-warning"></i> Notification Confirm
			<span class="fa fa-times-circle close-alert" title="Close" onclick="closeItem('.custom-alert')"></span>
		</div>
		<div class="alert-text"><i class="fa fa-info-circle"></i> Are you sure you want to delete this?
			<i class="la la-warning watermark"></i></div>
		<div class="alert-footer">
			<center>
			<button type="button" class="btn-alert" id="ok" value="ok" onclick="confirmAction('ok')">OK</button>
			<button type="button" class="btn-alert" id="cancel" value="cancel" onclick="closeItem('.custom-alert')">Cancel</button>
			</center>
		</div>
	</div>
	<!-- Appointment Reminder Popup -->
	<div class="reminderAlert">
		<audio id="notifyAlert" ><source src="../images/chime-sound.mp3" type="audio/mp3"></audio>
		<div onclick="closeItem('.reminderAlert');"><i class="la la-times close-alert" ></i></div>
		<div class="icon"><i class="fa fa-bell"></i></div>
		<div class="alert-header">Reminder</div>
		<div class="textMessage">
			<div>Your appointment with <span id="appBookedBy"></span></div>
			<div>Today at <span id="appTime"></span></div>
			<div><i class="fa fa-clock-o"></i> <small id="timelapse">in 30 minutes...</small></div>
		</div>
		<div>
			<button type="button" class="close" onclick="closeItem('.reminderAlert');" title="Close">Dismiss</button>
		</div>
	</div>

	<nav class="nav">
		<li class="nav-item"><img src="../images/bg_logo.png"/></li>
		<!-- <li class="nav-item"><a href="#"><span class="fa fa-home"></span> Home</a></li> -->
		<li class="nav-item">
			<input type="search" class="form-input" id="search" name="search" placeholder="Search" onkeyup="doSearch(this.value)"/>
			<button class="btn-search" id="btn-search" onclick="doSearch($('#search').value)"><span class="fa fa-search"></span></button>
		</li>
		<li class="nav-item"><a href="javascript:void(0)" onclick="runAction('addnew')"><span class="fa fa-plus"></span> Add Patient</a></li>
		<div class="tooltip add">
			Add new patient here.
		</div>
	</nav>
	<div class="sidebar">
		<li class="bar-item">
			<center><img src="../images/logo_white.png" class="profile-avatar"></center>
		</li>
		<li class="bar-item" onclick="runAction('home')"><span class="fa fa-home"></span> HOME</li>
		<li class="bar-item" onclick="runAction('appointments')"><span class="fa fa-calendar"></span> APPOINTMENTS
			<div class="tooltip create">
			View and create appointments here
		</div></li>
		<li class="bar-item" onclick="runAction('patients')"><span class="fa fa-users"></span> PATIENTS</li>
		<li class="bar-item" onclick="runAction('billing')"><span class="fa fa-credit-card"></span> BILLING</li>
		<li class="bar-item" onclick="runAction('reports')"><span class="la la-bar-chart"></span> REPORTS</li>
		<li class="bar-item" onclick="runAction('backups')"><span class="fa fa-database"></span> BACKUPS</li>
		<li class="bar-item" onclick="runAction('settings')"><span class="la la-cog"></span> SETTINGS</li>
		<li class="bar-item" onclick="runAction('logout')"><span class="fa fa-power-off"></span> LOGOUT</li>
	</div>
	<div class="container">
		<h2 class="header"><i class="fa fa-dashboard"></i> HCP DASHBOARD</h2>
		<div class="tooltip">
			Click one of this panels.
		</div>
		<div class="panels" onclick="runAction('messages')">
			<table border="0">
				<tr>
					<td><div class="panel-head">AVAILABLE MESSAGES</div></td>
					<td rowspan="2">
						<span class="fa fa-envelope-o panel-icon"></span>
						<sup class="notify">
							<?php
							  echo ($notify->unreadMessages('doctor@besthealth.com') != false) ?
					  		  count($notify->unreadMessages('doctor@besthealth.com')) : '0'; 
						  	?>
						</sup>
					</td>
				</tr>
				<tr>
					<td>
						<span class="panel-text">Manage Your Messages.<br>Inbox messages<br/>Send messages</span>
					</td>
				</tr>
			</table>
		</div>
		<div class="panels" onclick="runAction('reports')">
			<table border="0">
				<tr>
					<td><div class="panel-head">STATISTICAL REPORTS</div></td>
					<td rowspan="2">
						<span class="fa fa-bar-chart panel-icon"></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="panel-text">Manage Your Reports.<br>Daily Report.<br>Monthly &amp; Yearly Report.</span>
					</td>
				</tr>
			</table>
		</div>
		<div class="panels" onclick="runAction('backups')">
			<table border="0">
				<tr>
					<td><div class="panel-head">DATABASE BACKUPS</div></td>
					<td rowspan="2">
						<span class="fa fa-database panel-icon"></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="panel-text">
							Manage Your Database Backups.
						<br/>Download backups
						<br>Upload backups</span>
					</td>
				</tr>
			</table>
		</div>

		<div class="appointment-panel">
			<div class="panel-header">UPCOMING APPOINTMENTS</div>
			<table border="0">
				<thead>
					<th>Patient Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Status</th>
				</thead>
				<?php if($upcoming != false) { ?>
					<?php foreach($upcoming as $row) : ?>
						<?php $person = $hcp->getPatientById($row->idnumber); ?>
					<tr>
						<td><?php echo $person->fullname; ?></td>
						<td><?php echo date('j/m/Y', strtotime($row->app_date)); ?></td>
						<td><?php echo date('h A', strtotime($row->app_time)); ?></td>
						<td>
							<?php $color = (strtotime($row->app_date) <= strtotime(date('Y-m-d'))) ? 'success' : 'caution'; ?>
							<span class="status <?php echo $color; ?>"><?php echo ($row->status=='1') ? 'Active': 'Cancelled'; ?></span>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php } else {?>
					<tr><td colspan="4"><div class="alert-notify"><i class="fa fa-info-circle"></i> No Appointments Available</div></td></tr>
				<?php } ?>
			</table>
			<div class="view-link"><a href="javascript:runAction('appointments');">VIEW ALL APPOINTMENTS</a></div>
		</div>

		<div class="message-panel">
			<div class="panel-header">MESSAGES (<?php echo ($allInboxMsg!=false) ? count($allInboxMsg).' NEW' : '0'; ?>)</div>
			<table border="0">
				<?php if($allInboxMsg != false) { ?>
				<?php foreach($allInboxMsg as $msg) : ?>
					<tr>
						<td><?php echo $msg->sent_from; ?></td>
						<td><?php echo $msg->message; ?></td>
						<td><?php echo date('g:i A', strtotime($msg->created)); ?></td>
					</tr>
				<?php endforeach; ?>
				<?php } else { ?>
					<tr><td colspan="3"><div class="alert-notify"><i class="fa fa-info-circle"></i> No Messages Available!</div></td></tr>
				<?php } ?>
			</table>
			<div class="view-link"><a href="javascript:runAction('messages')">VIEW ALL MESSAGES</a></div>
		</div>
	</div>
	<script type="text/javascript">
		//call function to return element by ID/className
		function $(id) {
			return document.querySelector(id);
		}
		//call function to hide visible html element
		function closeItem(elem) {
			$(elem).style.display = "none";
		}
		//call function to display hidden html element
		function show(id) {
			$(id).style.display = "block";
		}
		//call this function to bind response to html
		function html(id, message) {
			$(id).innerHTML = message;
		}
		//call function to search for patients
		function doSearch(term) {
			return doAjax('controller.php?search=true&term='+term);
		}
		//call function to help switch to select action for each user query.
		function runAction(action, options='') {
			switch(action) {
				case 'home':
					window.open('index.php','_self');
				break;
				case 'appointments':
					doAjax('appointments.php');
				break;
				case 'patients':
					doAjax('patients.php');
				break;
				case 'billing':
					doAjax('billing.php');
				break;
				case 'reports':
					doAjax('reports.php');
					setTimeout("move()", 100);
					// move();
				break;
				case 'messages':
					doAjax('messages.php');
					setTimeout(function() { 
						doMessages('controller.php', '?retrieveAll=true');
					}, 500);
				break;
				case 'passwords':
					doAjax('managepassword.php');
				break;
				case 'backups':
					doAjax('managebackups.php');
				break;
				case 'restore':
					//open window to select a db backups
					openWindow();
				break;
				case 'dorestore':
					confirmRestore(options);
				break;
				case 'getbackuplogs':
					doAjax('controller.php?getlogs=true');
				break;
				case 'readlog':
					doAjax('controller.php?readlog=true&filename='+options);
				break;
				case 'profile':
					doAjax('manageprofile.php');
				break;
				case 'settings':
					doAjax('settings.php');
				break;
				case 'logout':
					var confirmAction = confirm("Want to logout?");
					if(confirmAction==false) {
						return false;
					} else {
						window.open('controller.php?logout=true','_self');
					}
				break;
				case 'addnew':
					doAjax('addnew.php');
				break;
				case 'createappointment':
					doAjax('newappointment.php');
				break;
				case'download':
					var confirmAction = confirm("Create Database Backup?");
					if(confirmAction==false) {
						return false;
					} else {
						location.href = "controller.php?download=true";
					}
				break;
				case 'compose':
					doMessages('controller.php','?compose=true');
				break;
				case 'sendMsg':
					var sent_to = $('#sent_to').value;
					var subject = $('#msg_subject').value;
					var msg_body = $('#message_text').value;
					if(sent_to=='' || subject=='' || msg_body=='') {
						$('.alert-error').style.display = "block";
					} else {
						doMessages('controller.php', '?sendMessage=true&msg_body='+msg_body+'&sent_to='+sent_to+'&subject='+subject);
					}
				break;
				case 'retrieveAll':
					setTimeout(function() { 
						doMessages('controller.php', '?retrieveAll=true');
					}, 500);
				break;
				case 'retrieveInbox':
					doMessages('controller.php', '?retrieveInbox=true');
				break;
				case'birthdays':
					doMessages('controller.php', '?getbirthdays=true');
				break;
			}
		}
		//call function to help, send and recieve data from/to server, to check messages
		function doMessages(url, params) {
			var url = url;
			var params = params;
			fetch(url+params)
			.then(response => response.text())
			.then(data => {
				html('.message-content', data); //print received data
			})
			.catch(error => alert(error));
		}
		//call function to help communicate client with server, to send and recieve data
		function doAjax(url) {
			var xhr = new XMLHttpRequest();
			$('.container').innerHTML = "<div class='loader'><i class='fa fa-spinner fa-pulse'></i> Loading...</div>";
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					$('.container').innerHTML = xhr.responseText;
				}
				if(xhr.status == 404) {
					alert('ERROR 404 URL/page not found!');
				}
			}
			xhr.open("GET", url, true);
			xhr.send();
		}
		//call function to filter patients by ID/Lastname
		function filter(param) {
			return doFilter('controller.php?filter=true&filterterm='+param);
		}
		//call function to filter appointments by date
		function filterbydate(param) {
			return doFilter('controller.php?filterby=true&date='+param);
		}
		//call function to help send and receive data from server
		function doFilter(url) {
			var xhr = new XMLHttpRequest();
			$('#filter-results').innerHTML = "<tr><td colspan='8'><center>Loading...</center></td></tr>";
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					$('#filter-results').innerHTML = xhr.responseText;
				}
				if(xhr.status == 404) {
					alert('ERROR 404 URL/page not found!');
				}
			}
			xhr.open("GET", url, true);
			xhr.send();
		}
		//call function on edit/save patient details
		function editPatient(action, options='') {
			switch(action) {
				case'edit':
					var url = "edit.php";
					var params = "?edit=true&pid="+options;
					return fetchAPI(url, params);
				break;
				case'savedit':
					var confirmAction = confirm("Save details?");
					if(confirmAction==false) {
						return false;
					}
				break;
				case 'back':
					return runAction('patients');
				break;
			}
		}
		//when button seen clicked tiggers a function, send data to server to confirm patient as seen by HCP
		function confirmSeen(pid, app_date) {
			var action = confirm("Confirm this patient?");
			if(action == false) {
				return false;
			} else {
				var params = "?confirmApp=true&pid="+pid+"&app_date="+app_date;
				fetchAPI('controller.php', params);
			}
			return 0;
		}
		//function called when cancel button clicked, to cancel patient's appointment 
		function cancelApp(pid, app_date) {
			var action = confirm("Cancel this appointment?");
			if(action == false) {
				return false;
			} else {
				var params = "?cancelApp=true&pid="+pid+"&app_date="+app_date;
				fetchAPI('controller.php', params);
			}
		}
		//helper commiunication send data from HMTL forms to php script on the server and returns server response
		function fetchAPI(url='', params='', options='') {
			var url = url;
			var params = params;
			fetch(url+params)
			.then(response => response.text())
			.then(data => {
				if(options=='appointment' && data=='success') {
					show('.custom-notify');
				} else {
					$('.container').innerHTML = data; //print received data
				}
			})
			.catch(error => alert(error));
		}
		//
		function bookAppointment() {
			var idnumber = $('#idnum').value;
			var appdate = $('#appdate').value;
			var apptime = $('#apptime').value;
			if(idnumber=='' || appdate=='' || apptime=='') {
				alert("Please provide data all fields are required");
			} else {
				var params = '?bookdate=true&idnumber='+idnumber+'&appdate='+appdate+'&apptime='+apptime;
				fetchAPI('controller.php', params, 'appointment');
				$('#idnum').value = '';
				$('#appdate').value = '';
				$('#apptime').value = '';
			}

		}
		//
		function patientLookup(params) {
			var url = 'controller.php?lookup=true&patient=';
			var params = params;
			fetch(url+params)
			.then(response => response.text())
			.then(data => {
				$('.filter-results').style.display = "block";
				$('.filter-results').innerHTML = data; //print received data to html body
			})
			.catch(error => alert(error));
		}
		//paste values from patient search into billing form
		function pasteData(uid, names, addr, email, tel) {
			self.value = "";
			$('#idNum').value = uid;
			$('#names').value = names;
			$('#address').value = addr;
			$('#email').value = email;
			$('#telephone').value = tel;
			$('.filter-results').style.display = "none";
			$('#filtersearch').value = "";
		}
		//check Billing Form on submission, if form has values.
		function validateSubmit() {
			var action = confirm('Send Invoice?');
			if(action==false) {
				return false;
			}
			else {
				if($('#idNum').value=='' || $('#names').value=='' || $('#address').value=='' || $('#email').value=='') {
					alert('Please provide patient details:\n(ID Number, fullnames, physical Address, email).');
					return false;
				}
			}
		}

		//on keypress or quantity click update values on Invoice page
		function getValues() {
			var taxrate = .15; //set tax rate;
			var subtotal = 0;
			var totalDue = 0;
			//get values from price and quantity input
			var price1 = ($('#quantity1').value * $('#price1').value);
			var price2 = ($('#quantity2').value * $('#price2').value);
			var price3 = ($('#quantity3').value * $('#price3').value);
			//assign values to total price
			$('#taxrate').value = "15%";
			$('#totalprice1').value = price1;
			$('#totalprice2').value = price2;
			$('#totalprice3').value = price3;
			//do some calculation
			subtotal = price1 + price2 + price3;
			totalDue = subtotal + (taxrate * subtotal);
			//assign subtotal and totaldue amount
			$('#subtotal').value = subtotal;
			$('.totaldue').value = totalDue;
			$('#totaldue').value = totalDue;
		}

		//call function to check notification every 1min (60000=1min), then (30000=30sec)
		function checkNotifications() {
			var count = 1;
			var timer = setInterval(function() {
				if(count == 30) {
					clearInterval(timer);
					setTimeout("checkNotifications()", 300000); //delays for 5-minute(s) and function calls itself again.
					checkAlerts(); //function will be called everytime in 1minute(s) to check for notification alerts
				}
				count++;
			}, 2000); //run every 2000-miliseconds
		}
		checkNotifications();

		//function to check for reminders
		function checkAlerts() {
			var url = "controller.php";
			var params = "?reminder=true";
			fetch(url+params)
			.then(response => response.json()) //return data in json format
			.then(data => {
				if(data != 0 && data.timeleft != 0) {
					$('.reminderAlert').style.display = "block"; //show notification alert window
					$('#appBookedBy').innerHTML = data.fullname; //print patient name.
					$('#appTime').innerHTML = data.apptime; //print appointment time.
					$('#timelapse').innerHTML = 'in '+data.timeleft+' minute(s)...';
					if($('.reminderAlert').style.display = "block") {
						$('#notifyAlert').play(); //play sound, if notification is visible/shown
					}
				}
			})
			.catch(error => console.log(error)); //log errors
		}

		//function moves report status bar fill
		/*function move() {
			var elem = $('#bar1');
			var countval = $('#val1');
			var width = 1;
			var id = setInterval(frame, 150);
			function frame() {
				if(width >= 25) {
					clearInterval(id);
				}
				else {
					width++;
					elem.style.width = width + "%";
					//display percentage progress
					countval.innerHTML = width + "%";
				}
			}
		}*/

		function openWindow() {
			$('.popupWin').style.display = "block";
		}

		function confirmRestore(param) {
			var item = param;
			var action = confirm('Continue to Restore Database?');
			if(action==false) {
				return false;
			} else {
				//continue to action
				// alert(item);
				closeItem('.popupWin');
				var params = '?restore=true&filename='+item;
				fetchAPI('controller.php', params, '');
				closeItem('.popupWin');
			}
		}
		//send file data to server for upload
		function uploadItem(data) {
			fetch("controller.php", {
				method: 'POST',
				body: data
				}).then(response => response.text())
				  .then(data => {
					alert(data);
					// console.log(data);
				}).catch(error => alert(error));
		}
		//onclick upload backup button
		$('#uploadBackup').addEventListener('click', function() {
			var filename = document.querySelector('input[type=file]').files[0]; //$('#db_file').value;
			if(filename != '') {
				var formdata = new FormData();
				formdata.append('upload', 'true');
				formdata.append('files', filename);
				uploadItem(formdata); //call restore and pass filename
				$('#db_file').value = '';
				closeItem('.popupWin');
			} else {
				alert('Please select file to upload');
			}
		});
		//call function to delete all backup files from server
		function deleteAll() {
			var params = "?deleteBackups=true";
			var action = confirm("You're about to delete all your backup files, continue?");
			if(action == false) {
				return false;
			} else {
				fetchAPI('controller.php', params);
				closeItem('.popupWin');
				setTimeout(function() {
					runAction('backups');
				}, 3000);
			}
		}
		//this function will send birthday wishes
		function updateBirthdayAlerts() {
			if(typeof(Storage) !== "undefined") {
				var dateObj = new Date();
				var year = dateObj.getFullYear();
				var month = dateObj.getMonth()+1;
				month = (month <= 9) ? '0'+month : month; //if single digit, pre add zero.
				var days = dateObj.getDate();
				days = (days <= 9) ? '0'+days : days; //if single digit, pre add zero.
				var currentDate = year+"-"+month+"-"+days; //combine to make full date
				//if it is Set compare dates, if matched don't do anything, else run, function helps to update once a day every day
				if(localStorage.getItem("refreshAlertTime") != "<?php echo date('Y-m-d'); ?>") {
					//if current date, not match localStorage.
					localStorage.clear(); //clear old data within storage 
					sendOutWishes(); //call function to send wishes automatically
					localStorage.refreshAlertTime = currentDate; //set new date to local storage
				} else {
					//else skip dont do anything
				}
			}
			else {
				alert("Sorry your browser does not support Web Storage!"); //if browser has no support for webstorage.
			}
		}
		// updateBirthdayAlerts();

		//check for available birthdays then, send BirthdayCardWish to patient if available.
		function sendOutWishes() {
			fetch('controller.php?wishes=true')
			.then(response => response.text())
			.then(data => {
				console.log(data);
				location.reload(true); //reload the page automatically
			})
			.catch(error => alert(error));
		}

		$('.close-alert').addEventListener('click', close);

		//function triggered onChange of textbox, gets value and send to server
		function checkTimeSlot(dateslot) {
			if(dateslot != '') {
				//then check time slots
				fetch('controller.php?checkslot=true&dateslot='+dateslot)
				.then(response => response.text())
				.then(data => {
					// console.log(data);
					show('.availability-panel'); //display element
					var title = '<div class="bookdate">On '+dateslot+'</div>'+'<div class="bookdate">09:00 AM - 16:00 PM</div>';
					if(data == "dayopen") {
						html('#timeSlots', title+'<div class="success"><i class="fa fa-check"></i> All Day Available.<div>');
					} else {
						html('#timeSlots', title+data); //print data on the element
					}
				})
				.catch(error => alert(error));
			}
		}

	</script>
</body>
</html>