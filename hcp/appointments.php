<?php
	//invoices page
	require_once('controller.php');
	$appointments = $admin->viewAllAppointments();
?>
<style type="text/css">
	.container-fluid {
		width: 950px;
		max-width: 100%;
		background-color: #fff;
		padding: 10px;
		/*margin: 50px 20px 0 20px;*/
		margin: 15px auto;
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
	table {
		width: 100%;
		border: thin solid #eee;
	}
	table thead th {
		background-color: #28789f;
		color: #fff;
		padding: 5px 3px
	}
	table tbody tr:nth-child(even) {
		background-color: #777; /*#a0d468;*/
	}
	table tbody tr td {
		background-color: #f5f5f5;/*#a0d468;*/
		color: #777;
		padding: 8px 2px;
		text-align: center;
	}
	table tbody tr td:nth-of-type(1) {
		text-align: left;
	}
	.pending {
		background-color: #ed5565;
		color: #fff;
		border-radius: 2px;
		padding: 2px 4px;
	}
	.success {
		background-color: #a0d468 !important;
		color: #fff !important;
		border-radius: 2px;
		padding: 2px 4px;
	}
	.btn {
		width: 80px;
		background-color: #5d9cec;
		color: #fff;
		border: none;
		border-radius: 3px;
		padding: 5px 0;
		font-weight: bold;
	}
	.btn:hover {
		background-color: #5db6d3;
		cursor: pointer;
	}
	.btn:active {
		background-color: #28789f;
		cursor: pointer;
	}
	/*Success button*/
	.btn.success {
		width: 40px;
		background-color: #2ecc71 !important;
		color: #fff !important;
	}
	.btn.success:hover {
		background-color: #a0d468 !important;
		color: #fff !important;
	}
	.btn.success:active {
		background-color: #27ae60 !important;
		color: #fff !important;
	}
	/*Danger button*/
	.btn.danger {
		width: 40px;
		background-color: #e74c3c !important;
		color: #fff !important;
	}
	.btn.danger:hover {
		background-color: tomato !important;
		color: #fff !important;
	}
	.btn.danger:active {
		background-color: #c0392b !important;
		color: #fff !important;
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
	.form-control {
		width: 200px;
		border-radius: 5px;
		border: thin solid #ccc;
		padding: 6px 0;
		color: #777;
		text-indent: 5px;
		margin-bottom: 5px;
	}
	.form-control:focus {
		border: thin solid #17EAD9;
		outline: none;
		filter: drop-shadow(1px 1px 2px #17EAD9);
	}
	.btn-make {
		background-color: #28789f;
		color: #fff;
		border: none;
		border-radius: 5px;
		padding: 8px 5px;
		font-weight: bold;
	}
	.btn-make:hover {
		background-color: #5db6d3;
		cursor: pointer;
	}
	.btn-make:active {
		background-color: #094966
	}
	.btn:disabled {
		background-color: #ccc !important;
	}
</style>

<div class="container-fluid">
	<div class="lead"><i class="fa fa-calendar"></i> Booked Appointments</div>
	<input type="date" name="search" id="filter" class="form-control" placeholder="dd-mm-yyyy"/>
	<button type="button" class="btn" onclick="filterbydate($('#filter').value);"><i class="fa fa-calendar"></i> View</button>
	<span style="float: right;"><button type="button" onclick="runAction('createappointment')" class="btn-make"><i class="la la-plus"></i> Create Appointment</button></span>
	<table border="0">
		<thead>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Gender</th>
			<th>Telephone</th>
			<th>Email</th>
			<th>Booked Date</th>
			<th>Booked Time</th>
			<th>Status</th>
			<th>&nbsp;</th>
		</thead>
		<tbody id="filter-results">
			<?php if($appointments != false) { ?>
			<?php foreach($appointments as $data): 
				$row = $admin->getPatientById($data->idnumber);
				$status = ($data->status=="1") ? 'Active' : ($data->status=="0" ? '<strike>Cancelled</strike>' : '<strike>Seen</strike>');
			?>
			<tr>
				<td><?php echo $row->firstname; ?></td>
				<td><?php echo $row->lastname; ?></td>
				<td><?php echo ucfirst($row->gender); ?></td>
				<td><?php echo $row->telephone; ?></td>
				<td><?php echo $row->email; ?></td>
				<td><?php echo date('D, d M Y', strtotime($data->app_date)); ?></td>
				<td><?php echo date('g:i A', strtotime($data->app_time)); ?></td>
				<td><?php echo $status; ?></td>
				<td>
					<button type="button" class="btn danger" name="update" title="Cancel Appointment" onclick="cancelApp(<?php echo $row->idnumber; ?>, '<?php echo $data->app_date; ?>');" <?php ($data->status=="0"||$data->status=="2") ? print'disabled' : print''; ?> ><i class="la la-times"></i></button>
					<button type="button" class="btn success" title="Confirm Seen" onclick="confirmSeen(<?php echo $row->idnumber; ?>, '<?php echo $data->app_date; ?>')" <?php ($data->status=="0"||$data->status=="2") ? print'disabled' : print''; ?>><i class="la la-check"></i></button>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No appointments available.</div></td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>