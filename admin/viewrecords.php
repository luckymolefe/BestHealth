<?php
	//patients page
	require_once('controller.php');
	$allpatients = $admin->viewAllPatients();

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
		width: 65px;
		background-color: #5d9cec;
		color: #fff;
		border: none;
		border-radius: 3px;
		padding: 3px 0;
		font-weight: bold;
		margin-bottom: 5px;
	}
	.btn:hover {
		background-color: #5db6d3;
		cursor: pointer;
	}
	.btn:active {
		background-color: #28789f;
		cursor: pointer;
	}
	.warning {
		background-color: #F39C12;/* #f36c60;*/
		/*color: #e51c23;*/
		color: #fff;
	}
	.success {
		background-color: #72d572;
		/*color: #2baf2b;*/
		color: #fff;
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
	<div class="lead"><i class="medical-icon-i-billing"></i> View All Patients</div>
	<table border="0">
		<thead>
			<th>#ID</th>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Gender</th>
			<th>Telephone</th>
			<th>Email</th>
			<th>Address</th>
			<th>&nbsp;</th>
		</thead>
		<tbody>
			<?php if($allpatients != false) { ?>
			<?php foreach($allpatients as $row) : ?>
			<tr>
				<td><?php echo $row->idnumber; ?></td>
				<td><?php echo $row->firstname; ?></td>
				<td><?php echo $row->lastname; ?></td>
				<td><?php echo ucfirst($row->gender); ?></td>
				<td><?php echo $row->telephone; ?></td>
				<td><?php echo $row->email; ?></td>
				<td><?php echo $row->address; ?></td>
				<td>
					<button type="button" class="btn warning" name="edit_record" onclick="router('edit', <?php echo $row->idnumber; ?>)"><i class="la la-edit"></i> Edit</button>
					<button type="button" class="btn success" name="new_booking" onclick="router('createappointment')"><i class="la la-calendar"></i> book</button>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No records available.</div></td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>