<?php
	//billing page
	require_once('controller.php');
	$hcp->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-wrap {
			max-height: 550px;
			overflow-y: auto;
		}
		.container-fluid {
			width: 90%;
			max-width: 100%;
			background: #fff;
			padding: 10px;
			border: thin solid #ccc;
			margin: 10px auto;
		}
		table {
			widows: 100%;
		}
		table tr th {
			background-color: #28789f;
			color: #fff;
			padding: 5px 3px;
		}
		table tr td {
			border: none;
		}
		textarea {
			resize: none;
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
		.lead {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 2em;
			border-bottom: thin solid #eee;
			margin-bottom: 10px;
			padding-bottom: 5px;
		}
		.btn {
			background-color: #5d9cec;
			color: #fff;
			border: none;
			border-radius: 3px;
			padding: 10px 12px;
			font-weight: bold;
			margin-top: 10px;
			margin-right: 10px;
		}
		.btn:hover {
			background-color: #5db6d3;
			cursor: pointer;
		}
		.btn:active {
			background-color: #28789f;
			cursor: pointer;
		}
		label {
			color: #777;
			font-weight: bold;
		}
		.form-control {
			width: 100%;
			resize: none;
			/*background-color: transparent;*/
			color: #777;
			font-size: 1.2em;
			border: none;
			border-radius: 0px;
		}
		.form-control:focus {
			border-bottom: thin solid #17EAD9;
			outline: none;
		}
		.invoice-header {
			background-color: #28789f;
			color: #fff;
			font-size: 1.3em;
			font-weight: bold;
			letter-spacing: 40px;
			text-align: center;
		}
		.inv-logo {
			position: relative;
			top: -40px;
			width: 200px;
			max-width: 100%;
		}
		.inv-subhead {
			font-size: 1.3em;
			font-weight: bold;
			background-color: #28789f;
			color: #fff;
			text-align: center;
		}
		.filter-results {
			/*position: relative;*/
			width: 87%;
			max-height: 100px;
			overflow-y: auto;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 8px 0px;
			margin-top: -8px;
			border-radius: 0 0 5px 5px;
			display: none;
			z-index: 1;
		}
		.resp-item {
			font-weight: bold;
			color: #28789f;
			text-indent: 5px;
			padding: 10px 0;
		}
		.resp-item:hover {
			background-color: #28789f;
			color: #fff;
			cursor: pointer;
		}
		input[type="number"] {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container-wrap">
		<div class="container-fluid">
			<div class="lead"><i class="fa fa-credit-card"></i> Billing Patient</div>
			<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
				<div>
					<label>Enter ID Number:</label><br/>
					<div>
					<input type="search" id="filtersearch" class="form-control" class="form-control" onkeyup="patientLookup(this.value)" placeholder="Type patient id number">
					<span class="filter-results" id="filter-results"></span>
					</div>
				</div>
				<hr>
			<table border="0">
				<tr>
					<td colspan="4" class="invoice-header"><div>INVOICE</div></td>
				</tr>
				<tr>
					<td colspan="2">
						<div><input type="text" class="form-control" name="idnumber" id="idNum" readonly="readonly" placeholder="Patient ID Number"></div>
						<div><input type="text" class="form-control" name="fullnames" id="names" placeholder="Fullnames"></div>
						<div><textarea class="form-control" name="address" id="address" placeholder="Patient Address" rows="1"></textarea></div>
						<div><input type="email" class="form-control" name="email" id="email" placeholder="Email"></div>
						<div><input type="tel" class="form-control" name="telephone" id="telephone" placeholder="Telephone"></div>
					</td>
					<td colspan="2" align="right">
						<img src="../images/bg-image.png" class="inv-logo">
					</td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>Invoice No:</td>
					<td><input type="text" class="form-control" id="invNum" name="invnumber" value="<?php echo "#".$helper->randomInvoice(); ?>" readonly="readonly" placeholder="#123456"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>Date:</td>
					<td><input type="date" class="form-control" id="invdate" name="invdate" value="<?php echo date('d/m/Y'); ?>" placeholder="dd/mm/yyyy"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>Payment Type:</td>
					<td>
						<select class="form-control" name="payment_type">
							<option value="Cash">Cash</option>
							<option value="EFT">EFT</option>
							<option value="CCard">Credit Card</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td class="inv-subhead">Item</td>
					<td class="inv-subhead">Price</td>
					<td class="inv-subhead">Quantity</td>
					<td class="inv-subhead">Total Price</td>
				</tr>
				<tr>
					<td><textarea class="form-control" id="item1" name="item1" placeholder="Item Code/Description" rows="2">Consultation Fee</textarea></td>
					<td><input type="text" class="form-control" id="price1" value="850" placeholder="R0.00" onblur="getValues()"></td>
					<td><input type="number" class="form-control" name="qty1" id="quantity1" min="0" value="1" max="10" onchange="getValues()"></td>
					<td><input type="text" class="form-control" name="price1" value="850" id="totalprice1" placeholder="R0.00" readonly="readonly"></td>
				</tr>
				<tr>
					<td><textarea class="form-control" id="item2" name="item2" placeholder="Item Code/Description"></textarea></td>
					<td><input type="text" class="form-control" id="price2" placeholder="R0.00" onblur="getValues()"></td>
					<td><input type="number" class="form-control" name="qty2" id="quantity2" min="0" value="0" max="10" onchange="getValues()"></td>
					<td><input type="text" class="form-control" name="price2" id="totalprice2" placeholder="R0.00" readonly="readonly"></td>
				</tr>
				<tr>
					<td><textarea class="form-control" id="item3" name="item3" placeholder="Item Code/Description"></textarea></td>
					<td><input type="text" class="form-control" id="price3" placeholder="R0.00" onblur="getValues()"></td>
					<td><input type="number" class="form-control" name="qty3" id="quantity3" min="0" value="0" max="10" onchange="getValues()"></td>
					<td><input type="text" class="form-control" name="price3" id="totalprice3" placeholder="R0.00" readonly="readonly"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>SubTotal:</td>
					<td><input type="text" class="form-control" id="subtotal" readonly="readonly" placeholder="0.00"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>Tax Rate:</td>
					<td><input type="text" class="form-control" id="taxrate" readonly="readonly" placeholder="15%"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>Total Amount Due:</td>
					<td><input type="text" class="form-control totaldue" name="totaldue" placeholder="0.00" readonly="readonly"></td>
				</tr>
			</table>
				<div align="right">
					<button type="reset" class="btn" name="">Clear Invoice</button>
					<button type="submit" name="sendbill" class="btn" value="true" onclick="return validateSubmit();">Submit Invoice</button>
				</div>
			</form>
		</div>
	</div>

</body>
</html>
