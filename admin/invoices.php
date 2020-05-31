<?php
	//invoices page
	require_once('controller.php');
	$status = array("Pending", "Paid");
	$paymentType = array("Cash", "Credit Card", "EFT");

	$allinvoices = $admin->viewAllInvoices();
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
		/*text-align: center;*/
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
		width: 80px;
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
	.pending {
		font-weight: bold;
		background-color: #e51c23;
		color: #fff;
		padding: 0 5px;
	}
	.paid {
		font-weight: bold;
		background-color: #2baf2b;
		color: #fff;
		padding: 0 5px;
	}
</style>

<div class="container-fluid">
	<div class="lead"><i class="medical-icon-i-billing"></i> Invoice Management</div>
	<table border="0">
		<thead>
			<th>#InoviceID</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Amount</th>
			<th>Date</th>
			<th>Status</th>
			<th>Payment type</th>
			<th>PatientID</th>
			<th></th>
		</thead>
		<tbody>

			<?php if($allinvoices != false) { ?>
				<?php foreach($allinvoices as $invoice) : ?>
					<tr>
						<td>#<?php echo $invoice->invid; ?></td>
						<td><?php echo $invoice->description; ?></td>
						<td><?php echo $invoice->quantity; ?></td>
						<td><?php echo $invoice->amount; ?></td>
						<td><?php echo date('d M Y', strtotime($invoice->created)); ?></td>
						<td><?php ($invoice->status==0) ? print '<span class="pending">Pending</span>': print '<span class="paid">Paid</span>'; ?></td>
						<td><?php echo $invoice->payment_type; ?></td>
						<td><?php echo $invoice->idnumber; ?></td>
						<td>
							<button type="button" class="btn" <?php ($invoice->status==1) ? print'disabled' : print'';?> name="update" value="true" onclick="router('update_invoice','<?php echo $invoice->invid; ?>')">
								<i class="la la-refresh"></i> Update
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php } else { ?>
				<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No Invoices available.</div></td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>