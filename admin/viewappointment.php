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
		border-radius: 5px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		/*margin: 50px 20px 0 20px;*/
		margin: 15px auto;
	}
	.lead {
		font-size: 2em;
		text-align: center;
		margin: 10px 0;
		border-bottom: 1px solid #eee;
	}
	table {
		width: 100%;
	}
	table thead th {
		background-color: rgb(153, 193, 60);
		color: #fff;
		padding: 10px 0;
	}
	table tbody tr td {
		background-color: #f5f5f5;/*#a0d468;*/
		color: #777;
		padding: 8px 2px;
		text-align: center;
	}
	table tbody tr:hover {
		background-color: #777;/*#a0d468;*/
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
		background-color: #a0d468;
		color: #fff;
		border-radius: 2px;
		padding: 2px 4px;
	}
	.btn {
		width: 35px;
		background-color: #5d9cec;
		color: #fff;
		border: none;
		border-radius: 3px;
		padding: 3px 0;
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
	.danger {
		background-color: #f36c60;
		color: #fff;
	}
</style>

<div class="container-fluid">
	<div class="lead"><i class="la la-calendar-check-o"></i> Booked Appointments</div>
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
			<th>Action</th>
		</thead>
		<tbody>
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
				<td><button type="button" class="btn danger" name="update" title="Cancel Appointment" onclick="cancelApp(<?php echo $row->idnumber; ?>, '<?php echo $data->app_date; ?>')" <?php ($data->status=="0"||$data->status=="2") ? print'disabled' : print''; ?> ><i class="la la-times"></i></button></td>
			</tr>
			<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No appointments available.</div></td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>