<?php
	//patients page
	require_once('controller.php');
	$allpatients = $admin->viewAllPatients();

?>
<style type="text/css">
	.container-fluid {
		width: 950px;
		max-width: 100%;
		max-height: 500px;
		background-color: #fff;
		padding: 10px;
		border-radius: 1px;
		overflow-y: auto;
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
		padding: 5px 3px;
	}
	table tbody tr td {
		background-color: #f5f5f5;/*#a0d468;*/
		color: #777;
		padding: 6px 2px;
		text-align: center;
	}
	table tbody tr:hover {
		background-color: #777;/*#a0d468;*/
	}
	table tbody tr td:nth-of-type(1) {
		text-align: left;
	}
	.btn {
		width: 75px;
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
	<div class="lead"><i class="fa fa-users"></i> View All Patients</div>
	<input type="search" name="search" id="filter" class="form-control" placeholder="Enter lastname or id number"/>
	<button type="button" class="btn" onclick="filter($('#filter').value);"><i class="fa fa-search"></i> Filter</button>
	<table border="0">
		<thead>
			<th>#ID</th>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Gender</th>
			<th>Dob</th>
			<th>Telephone</th>
			<th>Email</th>
			<th>Address</th>
			<th>&nbsp;</th>
		</thead>
		<tbody id="filter-results">
			<?php if($allpatients != false) { ?>
			<?php foreach($allpatients as $row) : ?>
			<tr>
				<td><?php echo $row->idnumber; ?></td>
				<td><?php echo $row->firstname; ?></td>
				<td><?php echo $row->lastname; ?></td>
				<td><?php echo ucfirst($row->gender); ?></td>
				<td><?php echo $row->dob; ?></td>
				<td><?php echo $row->telephone; ?></td>
				<td><?php echo $row->email; ?></td>
				<td><?php echo $row->address; ?></td>
				<td>
					<button type="button" class="btn" onclick="editPatient('edit', <?php echo $row->idnumber; ?>)" name="update"><i class="la la-edit"></i> Update</button>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No records available.</div></td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>