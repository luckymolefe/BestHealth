<?php

date_default_timezone_set('Africa/Johannesburg');

if(isset($_GET['ym'])) {
	//ym == Year Month
	$ym = $_GET['ym'];	
} else {
	//this month
	$ym = date('Y-m');
}

//check format
$timestamp = strtotime($ym.'-01'); //the first day of the month
if($timestamp===false) {
	$ym = date('Y-m');
	$timestamp = strtotime($ym.'-01');
}

//today format 2018-10-10
$today = date('Y-m-j');

//TItle (Format:October, 2018)
$title = date('F, Y', $timestamp);

//Create prev and next month link
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

//Number of days in a month
$day_count = date('t', $timestamp);

//1:Min, 2:Tues, 3:Wed...7:Sun
$str = date('N', $timestamp);

//Array for calendar
$weeks = [];
$week = '';

//Add empty cell(S)
$week = str_repeat('<td></td>', $str-0);

for($day = 1; $day <= $day_count; $day++) {
	$str++;
	$date = $ym.'-'.$day;

	if($today == $date) {
		$week .= '<td class="today"><span class="highlight">';
	} else {
		$week .= '<td onclick="calPickDate(\''.$ym.'-'.$day.'\')">';
	}
	$week .= $day.'</span></td>';

	//Sunday Or last day of the month
	if($str % 7 == 0 || $day == $day_count) {
		//last day of the month
		if($day == $day_count && $str % 7 != 0) {
			//Add empty cells(s)
			$week .= str_repeat('<td></td>', 7 - $str % 7);
		}
		
		$weeks[] = '<tr>'.$week.'</tr>';

		$week = '';
	}

}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Calendar 3 Test</title>
	<style type="text/css">
		.list-item {
			list-style-type: none;
			display: inline-block;
		}
		.table {
			width: 100%;
			max-width: 100%;
			margin: 15px auto;
			height: auto;
			font-family: helvetica, arial;
			border: thin solid #8cc152;
			border-collapse: collapse;
		}
		.table thead tr th {
			background-color: rgb(163, 200, 100);/*#5db6d3;*/
			color: #fff;
			padding: 8px 5px;
		}
		.table tbody tr td {
			background-color: #f5f5f5;
			color: #777;
			text-align: center;
			padding: 8px 5px;
		}
		.table tbody tr td:hover {
			background-color: #afbfff;
			color: #fff;
			cursor: pointer;
		}
		.table tbody tr td:nth-of-type(1) {
			color: #dd0000;
		}
		.table tbody tr td:nth-of-type(7) {
			color: #28789f;
		}
		.title {
			background-color: #8cc152;/*#28789f;*/
			color: #fff;
			text-align: center;
			padding: 10px;
		}
		.nav-today {
			font-size: 0.85em;
			text-decoration: none;
			color: #f5f5f5;
			font-weight: bold;
		}
		.left, .right {
			position: relative;
			top: 5px;
			background-color: #fff;
			color: #28789f;
			font-weight: bold;
			border-radius: 50%;
			padding: 8px 10px;
			text-decoration: none;
		}
		.left {
			left: -50px;
		}
		.right {
			right: -50px;
		}
		.left:hover, .right:hover {
			background-color: #73b1f4;
			color: #fff;
		}
		.left:active, .right:active {
			background-color: #4b89da;
			color: #fff;
		}
		.highlight {
			margin-top: -15px;
			background-color: #5db6d3 !important;
			border-radius: 50%;
			color: #fff;
			padding: 5px 6px;
			font-weight: bold;
		}
	</style>
	<script type="text/javascript">
		/*function calPickDate(datePick) {
			return alert(datePick);
		}*/
	</script>
</head>
<body>
<!-- <div class="container"> -->
	<table class="table" border="0">
		<thead>
			<tr>
				<td colspan="8" class="title">
					<!-- <li class="list-item" title="Previous"><a href="javascript:router('getcalendar','<?= $prev; ?>')" class="left">&lt;</a></li> -->
					<li class="list-item" title="Previous"><a href="javascript:router('getcalendar','<?= $prev; ?>')" class="left"><i class="la la-arrow-left"></i></a></li>
					<li class="list-item"><span class="title"><?= $title; ?></span></li>
					<!-- <li class="list-item" title="Next"><a href="javascript:router('getcalendar','<?= $next; ?>')" class="right">&gt;</a></li> -->
					<li class="list-item" title="Next"><a href="javascript:router('getcalendar','<?= $next; ?>')" class="right"><i class="la la-arrow-right"></i></a></li>
					<div><a href="javascript:router('getcalendar','<?php echo date('Y-m'); ?>');" title="Goto Today" class="nav-today">Today</a></div>
				</td>
			</tr>
			<tr>
				<th>Sun</th>
				<th>Mon</th>
				<th>Tue</th>
				<th>Wed</th>
				<th>Thu</th>
				<th>Fri</th>
				<th>Sat</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($weeks as $week) {
					echo $week;
				}
			?>
		</tbody>
	</table>
<!-- </div> -->
</body>
</html>