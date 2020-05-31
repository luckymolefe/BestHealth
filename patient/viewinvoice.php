<?php
	//View Invoice
	require_once('controller.php');

	if(isset($_REQUEST['invid'])) {
		$invid = (int)$_REQUEST['invid'];
		$response = $patient->readInvoice($invid);
		// print_r($response);
	}
	// echo "Will view invoice here";
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-wrapper {
			width: 1200px;
			max-width: 100%;
			height: auto;
			/*overflow-y: auto;*/
			margin: 0 auto;
			background-color: #fff;
			font-family: helvetica, arial;
		}
		table {
			width: 95%;
			color: #555;
			border: thin solid #ddd;
			margin-bottom: 10px;
			padding-bottom: 5px;
			/*box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.3);*/
			border-collapse: collapse;
		}
		table tr td {
			padding: 0 10px;
		}
		table tr:nth-of-type(1) {
			background: url('../images/healthcare_bg4.jpg') no-repeat;
			background-size: cover;
			background-position: top left;
			background-color: #5db6d3;
			color: #fff;
			font-weight: bold;
		}
		table tr:nth-of-type(1) td:nth-of-type(2) {
			text-align: right;
		}
		table tr:nth-of-type(2) {
			background: url('../images/healthcare_bg4.jpg') no-repeat;
			background-size: cover;
			background-position: top left;
			background-color: #28789f;
			color: #fff;
		}
		table tr:nth-of-type(1) td {
			padding: 5px;
		}
		table tr:nth-of-type(2) td {
			padding: 10px 0;
			border-bottom: 2px solid #5db6d3;
		}
		table tr:nth-of-type(4) td {
			border-bottom: thin solid #ccc;
		}
		.invoice-wrap {
			height: inherit;
			max-height: inherit;
			overflow-y: auto;
		}
		.logo {
			width: 300px;
			max-width: 100%;
		}
		.totalAmt {
			font-size: 1.8em;
			font-weight: bold;
		}
		.inv-head {
			font-weight: bold;
			color: #28789f;
		}
		.inv-head:first-child {
			margin-top: 15px;
		}
		.inv-text {
			color: #777;
			margin-bottom: 5px;
		}
		.pending {
			color: #F0616B;
			font-weight: bolder;
		}
		.success {
			color: #8AC054;/*#A0CF6E;*/
			font-weight: bolder;
		}
		.inv-title {
			font-size: 2em;
			font-weight: bold;
			letter-spacing: 20px;
			text-align: center;
			margin-bottom: -40px;
		}
		.inv-footer {
			text-align: center;
			padding: 5px 0;
			line-height: 2;
			border-top: thin solid #ccc;
		}
	</style>
</head>
<body>
	<!-- <a href="" onclick="openPrintWindow('<?php echo $invid; ?>')">Print Invoice</a> -->
	<div class="container-wrapper">
		<div class="invoice-wrap">
			<table align="center">
				<tr>
					<td colspan="7">
						<div class="inv-title">INVOICE</div>
						<span style="float:left;">
							Best Health<br/>
							<i class="fa fa-phone"></i> T : 012 123 5545<br>
							<i class="fa fa-envelope"></i> E : admin@besthealth.com
						</span>
						<span style="float:right;">122 Hillway Ave<br/>Pretoria<br/>0002</span>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<center><img src="../images/logo_white.png" class="logo"></center>
					</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
					<td rowspan="5" width="200px" valign="top" align="right">
						<div class="inv-head">Amount Due</div>
						<div class="totalAmt">R <?php echo number_format($response['items']['totaldue'], 2); ?></div>
						<div>&nbsp;</div>
						<div class="inv-head">Billing To</div>
						<div class="inv-text">
							<?php echo $response['patient']['fullnames']; ?><br>
							<?php echo $response['patient']['email']; ?><br>
							<?php echo $response['patient']['telephone']; ?><br>
							<?php echo $response['patient']['address']; ?>
						</div>
						<div>&nbsp;</div>
						<div class="inv-head">Invoice Number</div>
						<div class="inv-text">
							#<?php echo $response['patient']['invnumber']; ?>
						</div>
						<div class="inv-head">Invoice Date</div>
						<div class="inv-text">
							<?php echo $response['patient']['invdate']; ?>
						</div>
						<div class="inv-head">Payment Type</div>
						<div class="inv-text">
							<?php echo $response['patient']['payment_type']; ?>
						</div>
						<div class="inv-head">Invoice Status</div>
						<div class="inv-text">
							<?php echo ($response['patient']['status'] == 0) ? '<div class="pending">Pending</div>' : '<div class="success">Paid</div>'; ?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="inv-head">Description</td>
					<td class="inv-head">Quantity</td>
					<td class="inv-head">Total Price</td>
				</tr>
				<tr>
					<td><?php echo $response['items']['item1']; ?></td>
					<td><?php echo $response['items']['qty1']; ?></td>
					<td>R <?php echo number_format($response['items']['price1'], 2); ?></td>
				</tr>
				<tr>
					<td><?php echo $response['items']['item2']; ?></td>
					<td><?php echo $response['items']['qty2']; ?></td>
					<td>R <?php echo number_format($response['items']['price2'], 2); ?></td>
				</tr>
				<tr>
					<td><?php echo $response['items']['item3']; ?></td>
					<td><?php echo $response['items']['qty3']; ?></td>
					<td>R <?php echo number_format($response['items']['price3'], 2); ?></td>
				</tr>
				<tr>
					<td colspan="5">
						<div class="inv-footer">
							Thank You<br/>
							<small>BestHealth &copy; <?php echo date('Y'); ?></small>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		window.onload = function() {
			self.print(); //print current window
			self.close(); //close window
		}
	</script>
</body>
</html>