<?php
	//Patient invoices page
	require_once('controller.php');
	$invoices = $patient->getInvoices($_SESSION['patient']['pid']);
?>
<style type="text/css">
	.container-fluid {
		width: 100%;
		/*background-color: transparent;*/
		padding: 10px 0;
	}
	.header {
		color: rgb(15, 107, 156);
		font-size: 1.5em;
		text-align: left;
		border-bottom: thin solid #eee;
		padding: 0 0 5px 0;
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
	.btn-view {
		background-color: #b3e5fc;
		color: #29b6f6;
		padding: 2px 8px;
		border: thin solid #29b6f6;
		border-radius: 5px;
		font-weight: bold;
	}
	.btn-view:hover {
		background-color: #29b6f6;
		color: #fff;
		border: thin solid #b3e5fc;
		cursor: pointer;
	}
	.status {
		background-color: #777;
		color: #fff;
		padding: 2px 2px;
		border-radius: 5px;
	}
	.status.pending {
		background-color: #FAC4BF;
		color: #F0616B;
	}
	.status.success {
		background-color: #A0CF6E;
		color: #fff;
	}
</style>
<div class="container-fluid">
	<div class="header"><i class="fa fa-clipboard"></i> My Invoices</div>
	<table border="0">
		<tr>
			<th>#invID</th>
			<th>Desc</th>
			<th>Qty</th>
			<th>Amount</th>
			<th>Status</th>
			<th>Payment Type</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php if($invoices != false) { ?>
			<?php foreach($invoices as $inv) : ?>
			<tr>
				<td>#<?php echo $inv->invid; ?></td>
				<td><?php echo $inv->description; ?></td>
				<td><?php echo $inv->quantity; ?></td>
				<td>R<?php echo $inv->amount; ?></td>
				<td><?php echo ($inv->status==0) ? '<div class="status pending">Pending</div>' : '<div class="status success">Paid</div>'; ?></td>
				<td><?php echo $inv->payment_type; ?></td>
				<td><?php echo date('D, d F Y', strtotime($inv->created)); ?></td>
				<td>
					<button type="button" class="btn-view" onclick="router('view', '<?php echo $inv->invid; ?>')">View</button>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php } else {?>
		<tr><td colspan="8"><div class="alert-notify"><i class="fa fa-info-circle"></i> No appointments history available.</div></td></tr>
		<?php } ?>
	</table>
</div>