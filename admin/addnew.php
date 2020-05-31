<?php
	//create new patients record
	// echo "Patients";
?>
<style type="text/css">
	.container-fluid {
		width: 650px;
		max-width: 100%;
		background-color: #fff;
		border: thin solid #ccc;
		border-radius: 5px;
		padding: 10px;
		margin: 30px auto;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	table {
		width: 100%;
	}
	table tr td {
		padding: 5px;
	}
	textarea {
		width: 98% !important;
		resize: none;
	}
	.lead {
		font-size: 2em;
		text-align: center;
		border-bottom: 1px solid #eee;
	}
	.btn {
		width: 150px;
		background-color: #5d9cec;
		color: #fff;
		border: none;
		border-radius: 5px;
		padding: 10px 0;
		font-weight: bold;
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
</style>

<div class="container-fluid">
	<div class="lead"><i class="medical-icon-i-medical-records"></i> Add New Patient</div>
	<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
	<table border="0">
		<tr>
			<td>
				<input type="text" name="firstname" class="form-input" placeholder="Enter Firstname">
			</td>
			<td>
				<input type="text" name="lastname" class="form-input" placeholder="Enter Lastname">
			</td>
		</tr>
		
		<tr>
			<td>
				<input type="text" name="idNumber" class="form-input" placeholder="Enter ID Number">
			</td>
			<td>
				<input type="date" name="dob" class="form-input" placeholder="yyyy-mm-dd">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<select class="form-input" name="gender">
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="email" name="email" class="form-input" placeholder="Enter Email">
			</td>
			<td>
				<input type="tel" name="telephone" class="form-input" placeholder="Enter Telephone">
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<textarea name="address" rows="5" class="form-input" placeholder="Enter Address"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="reset" class="btn" name="clear">Clear</button>
				<button type="submit" class="btn" name="addnew" value="true"><i class="fa fa-plus"></i> Add New</button>
			</td>
		</tr>
	</table>
	</form>
</div>
