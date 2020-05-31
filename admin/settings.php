<?php
	//settings page
	// echo "Settings";
?>
<style type="text/css">
	.container-fluid {
		width: 500px;
		max-width: 100%;
		background-color: #fff;
		border: thin solid #ccc;
		border-radius: 5px;
		padding: 15px 10px;
		margin: 80px auto;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.lead {
		font-size: 2em;
		text-align: center;
		border-bottom: 1px solid #eee;
	}
	.form-input {
		width: 98%;
	}
	.btn {
		width: 150px;
		background-color: #5d9cec;
		color: #fff;
		border: none;
		border-radius: 5px;
		padding: 10px 0;
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
</style>

<div class="container-fluid">
	<div class="lead"><i class="la la-cog"></i> Settings</div>
	<form action="controller.php" method="POST" enctype="application/www-forms-urlencoded">
		<div>
			<input type="text" name="newpassword" class="form-input" placeholder="New Password">
		</div>
		<div>
			<input type="password" name="confirmpassword" class="form-input" placeholder="Confirm Password">
		</div>
		<div>
			<button type="submit" class="btn" name="savepassword" value="true"><i class="la la-save"></i> Save</button>
		</div>
	</form>
</div>