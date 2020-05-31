<?php
	//Appointment history page
	require_once('controller.php');
	if(isset($_SESSION['patient']['pid'])) {
		$appointments = $patient->readHistory($_SESSION['patient']['pid']);
		$count = 1;
	} else {
		exit('Missing user session token. Sorry failed to load patient Appointment History!.');
	}
?>
<style type="text/css">
	.container-fluid {
		width: 100%;
		background-color: transparent;
		padding: 10px 0;
	}
	table {
		width: 100%;
		margin-top: 15px;
		text-align: center;
	}
	table th {
		background-color: #28789f; /*#bae;*/
		color: #fff;
		padding: 10px 0;
	}
	table tr td {
		background-color: #d0f8ce;
		color: #777;
		padding: 5px;
	}
	.header {
		color: rgb(15, 107, 156);
		font-size: 1.5em;
		text-align: left;
		border-bottom: thin solid #eee;
		padding: 0 0 5px 0;
	}
	.btn {
		width: 30px;
		padding: 3px 0;
		background-color: tomato;
		color: #fff;
		border: none;
		border-radius: 5px;
		font-weight: bold;
	}
	.btn:hover {
		background-color: #ee8888;
		cursor: pointer;
	}
	.btn:active {
		background-color: #dd0000;
	}
	.btn:disabled {
		background-color: #bbb !important;
	}
	.alert-notify {
		width: 700px;
		max-width: 100%;
		margin: 10px auto;
		border-radius: 5px;
		background-color: #b3e5fc;
		color: #29b6f6;
		padding: 18px 8px;
		font-weight: bold;
		text-align: center;
	}
</style>

<div class="container-fluid">
	<div class="header"><i class="fa fa-calendar-plus-o"></i> Appointment History</div>
	<table border="0">
		<thead>
			<th>#</th>
			<th>Appointment Date</th>
			<th>Appointment Time</th>
			<th>Created</th>
			<th>Status</th>
			<th>Action</th>
		</thead>
		<?php if($appointments != false) { ?>
		<?php foreach($appointments as $history) : ?>
		<tr>
			<td><?php echo $count++; ?></td>
			<td><?php echo date('D, d F Y', strtotime($history->app_date)); ?></td>
			<td><?php echo date('H:i A', strtotime($history->app_time)); ?></td>
			<td><?php echo date('d-M-Y', strtotime($history->created)); ?></td>
			<td><?php switch($history->status) { case'1':echo'Active';break; case'0':echo'Cancelled';break; case'2':echo'Confirmed';break; } ?></td>
			<td>
				<button type="button" class="btn" name="cancel" title="Cancel" onclick="cancelApp(<?php echo $history->idnumber; ?>, '<?php echo urlencode($history->app_date); ?>')" <?php ($history->status==0) ? print'disabled':''; ?> 
					<?php ($history->status=="0"||$history->status=="2") ? print'disabled' : print''; ?>><i class="la la-times"></i></button>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php } else { ?>
			<tr><td colspan="6"><div class="alert-notify"><i class="fa fa-info-circle"></i> No appointments history available.</div></td></tr>
		<?php } ?>
	</table>
</div>