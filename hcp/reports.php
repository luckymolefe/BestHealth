<?php
	//MIS Reports
	require_once('controller.php');
	$hcp->protected_page();

	/*Calculate percentage year goal*/
	$targetGoal = 250; //set goal amount to reach 

	$currentYearTotal = $report->totalSeenCurYear();
	$percentCurYear = ($currentYearTotal / $targetGoal) * 100;
	$percentCurYear = round($percentCurYear);

	$prevYearTotal = $report->totalSeenPrevYear();
	$percentPrevYear = ($prevYearTotal / $targetGoal) * 100;
	$percentPrevYear = round($percentPrevYear);

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../boostrap3/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/line-awesome/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../boostrap3/webfont-medical-icons/css/wfmi-style.css">
	<style type="text/css">
		body {
			font-family: helvetica, arial;
			overflow-y: auto;
		}
		.container-fluid {
			width: 1000px;
			max-width: 100%;
			height: 520px;
			overflow-y: auto;
			margin: 5px auto;
			padding: 10px;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.progress {
			width: 100%;
			background-color: #ddd;
			border-radius: 5px;
		}
		.bar {
			width: 1%;
			height: 30px;
			background-color: #5db6d3;
			color: #fff;
			text-align: center;
			border-radius: 5px;
			line-height: 2;
		}
		.page-header {
			font-size: 2em;
			color: #28789f;
			border-bottom: thin solid #ccc;
			padding: 10px 10px;
			text-align: center;
		}
		caption {
			font-size: 1.2em;
			color: #777;
		}
		.chart-table {
			width: 800px;
			max-width: 100%;
			margin: 10px auto;
			border: thin solid #bbb;
			margin-bottom: 20px;
			border-collapse: collapse;
		}
		.chart-table tr td {
			border: none;
			padding: 5px 2px;
		}
		.chart-table tr td:nth-of-type(1) {
			width: 40px;
			color: #094966;
			font-weight: bold;
		}
		.chart-table tr td:nth-of-type(3) {
			width: 100px;
			border-left: 1px solid #ccc;
			color: #E9573F;
			font-weight: bold;
		}
		.chart-table tr td:nth-of-type(2) {
			border-left: 1px solid #ccc;
		}

		.circle {
			width: 25px;
			height: 25px;
			border-radius: 50%;
			background-color: #5db6d3;
			float: left;
			margin-top: -3px;
			margin-right: 10px;
		}
		.bar.deepblue {
			background-color: rgb(9, 73, 102) !important;
		}
		.bar.green {
			background-color: rgb(153, 193, 60) !important;
		}
		.circle.deepblue {
			background-color: rgb(9, 73, 102) !important;
		}
		.circle.green {
			background-color: #A0CF6E !important;
		}
		.center {
			color: #999;
		}
		.statspanel {
			width: 200px;
			height: 150px;
			display: inline-block;
			/*background-color: #f5f5f5;*/
			/*box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.4);*/
			padding: 5px;
			text-align: center;
			margin: 10px 0 15px 15px;
		}
		.stat-title {
			font-weight: bold;
			color: #28789f;
		}
		.stat-counter {
			width: 140px;
			height: 140px;
			background-color: #5db6d3;
			color: #fff;
			border: 10px solid #28789f;
			border-radius: 50%;
			line-height: 2.2;
			font-size: 4em;
			margin: 15px auto;
			text-align: center;
		}
		.table-stat tr:nth-child(even) {
			background-color: #f9f9f9;
		}
		.table-stat tr:hover {
			background-color: #e6e7eb;
		}
		.table-stat tr td {
			padding: 10px;
			font-size: 1em;
			border-bottom: thin solid #ddd;
			font-weight: bold;
		}
		.table-stat tr td:last-child {
			border-left: thin solid #A0D468;
		}
	</style>
</head>
<body> <!-- onload="return move();" -->
<div class="page-header"><i class="fa fa-pie-chart"></i> STATISTICAL REPORT</div>
<div class="container-fluid">
	<table border="0" class="chart-table">
		<caption>Statistical Presentation</caption>
		<tr>
			<td><?php echo date('Y'); ?></td>
			<td>
				<center>Total Registered 2019</center>
				<div class="progress">
					<div class="bar" id="bar1"  style="<?php echo $percentCurYear; ?>%;"></div>
				</div>
			</td>
			<td>
				<div class="circle"></div>
				<span id="val1"><?php echo $percentCurYear; ?> %</span>
			</td>
		</tr>
		<tr>
			<td><?php echo date('Y')-1; ?></td>
			<td>
				<center>Total Registered 2018</center>
				<div class="progress">
					<div class="bar green" id="bar2" style="width: <?php echo $percentPrevYear; ?> %;"></div>
				</div>
			</td>
			<td>
				<div class="circle green"></div>
				<span id="val2"><?php echo $percentPrevYear; ?> %</span>
			</td>
		</tr>
		
	</table>
	<center>
		<div class="statspanel">
			<div class="stat-title">Total Registered Today</div>
			<div class="stat-counter"><?php ($report->totalRegisteredToday() > 0) ? print $report->totalRegisteredToday() : print'0'; ?></div>
		</div>

		<div class="statspanel">
			<div class="stat-title">Total Seen Today</div>
			<div class="stat-counter"><?php ($report->totalSeenToday() > 0) ? print $report->totalSeenToday() : print'0'; ?></div>
		</div>

		<div class="statspanel">
			<div class="stat-title">Total Seen Last 7 days</div>
			<div class="stat-counter"><?php ($report->seenLastWeek() > 0) ? print $report->seenLastWeek() : print'0'; ?></div>
		</div>

		<div class="statspanel">
			<div class="stat-title">Total Seen <?php echo date('F Y', strtotime("This month")); ?></div>
			<div class="stat-counter"><?php ($report->seenCurrMonth() > 0) ? print $report->seenCurrMonth() : print '0'; ?></div>
		</div>

		<br/><br/><br/>

		<table class="table-stat" style="width: 70%; border: thin solid #A0D468; border-collapse: collapse;">
			<tr>
				<th colspan="2" style="padding:15px 0;font-weight: bold;font-size: 1.5em;color: #fff;background-color: #8CC152">2019 Upcoming Birthdays</th>
			</tr>
			<th style="background-color: #A0CF6E; color: #fff;padding: 10px;">Year - Month</th>
			<th style="background-color: #A0CF6E; color: #fff;padding: 10px;">Total Count</th>
			<tbody>
				<?php
					//Use forLoop to iterate 6-times, to display upcoming 6-Months birthday total count for each month.
					for($i = 1; $i <= 6; $i++) :
						$date = date('Y-m-d', strtotime("+$i month")); //add by one month to every iterate.
						$row = $report->upcomingBirthdays($date); //pass date to method, and retrun birthday total counts.
					?>
						<tr>
							<td><?php echo $row->curYear.' - '.$row->curMonth; ?></td>
							<td><?php echo $row->totalDob; ?></td>
						</tr>
				<?php endfor; ?>
				
			</tbody>
		</table>
		<br>
		<table border="0" id="tbl3" style="width: 70%; border: thin solid #A0CF6E; font-weight: bold; border-collapse: collapse;margin-bottom:50px;">
			<tr>
				<th colspan="3" style="padding:10px 0;font-weight: bold;font-size: 1.5em;color: #fff;background-color: #8CC152">Top 5 Upcoming Birthdays in 7 days</th>
			</tr>
			<th style="background-color: #A0CF6E; color: #fff;padding: 10px">Year - Month</th>
			<th style="background-color: #A0CF6E; color: #fff;padding: 10px">Birth Date</th>
			<th style="background-color: #A0CF6E; color: #fff;padding: 10px">Day</th>
			<?php $data = $report->topFiveBirthdays(); ?>
			<?php if($data != 0) { ?>
			<?php foreach($data as $row): ?>
				<tr>
					<td><?php echo date('Y - F'); ?></td>
					<td><?php echo date('d/m/Y', ($row->dob)); ?></td>
					<td><?php echo date('D', ($row->dob)); ?></td>
				</tr>
			<?php endforeach; 
				  } else {
			?>
				<tr><td colspan="3"><div class="alert-notify info"><i class="fa fa-info-circle"></i> No birthdays currently.</div></td></tr>
			<?php } ?>
		</table>
	</center>
</div>
</body>
</html>
