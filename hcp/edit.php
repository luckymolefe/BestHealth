<?php
	require_once('controller.php');
	// $hcp->protected_page();

if(!isset($_REQUEST['edit'])) {
	exit("Sorry seems your unauthorized to view this page!");	
}
if(isset($_REQUEST['pid'])) {
	$row = $hcp->getPatientById($_REQUEST['pid']);
}
$gender = array("male"=>"Male", "female"=>"Female");
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 450px;
			max-width: 100%;
			margin: 30px auto;
			padding: 10px 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.form-control {
			width: 440px;
			color: #777;
			border: thin solid #ccc;
			border-radius:  5px;
			padding: 4px;
			font-size: 1em;
			margin-top: 10px;
			text-indent: 5px;
		}
		.lead {
			font-size: 1.5em;
			color: #28789f;
			text-align: center;
			border-bottom: thin solid #ccc;
			padding: 5px 0;
			margin-bottom: 10px;
		}
		.btn {
			width: 130px;
			background-color: #28789f;
			color: #fff;
			border: thin solid #fff;
			border-radius: 5px;
			padding: 8px 0;
			font-weight: bold;
			margin-top: 15px;
		}
		.btn:hover {
			background-color: #5db6d3;
			cursor: pointer;
		}
		.btn:active {
			background-color: #094966;	
		}
		textarea {
			resize: none;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="lead"><i class="fa fa-edit"></i> Edit Patient Details</div>
		<form action="controller.php" method="POST" enctype="application/x-www-forms-urlencoded">
			<div>
				<input type="text" name="idnumber" class="form-control" readonly="readonly" value="<?php echo $row->idnumber; ?>" placeholder="Enter ID Number">
			</div>
			<div>
				<input type="text" name="firstname" class="form-control" value="<?php echo $row->firstname; ?>" placeholder="Enter firstname">
			</div>
			<div>
				<input type="text" name="lastname" class="form-control" value="<?php echo $row->lastname; ?>" placeholder="Enter lastname">
			</div>
			<div>
				<select name="gender" class="form-control">
					<option value="">Select Gender</option>
					<?php foreach($gender as $k => $v) : ?>
						<option value="<?php echo $k; ?>" <?php if($k == $row->gender) { echo "selected='selected'"; } ?>><?php echo $v; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<input type="date" name="dob" class="form-control" value="<?php echo $row->dob; ?>" placeholder="yyyy/mm/dd">
			</div>
			<div>
				<input type="tel" name="telephone" class="form-control" value="<?php echo $row->telephone; ?>" placeholder="Enter telephone">
			</div>
			<div>
				<input type="email" name="email" class="form-control" value="<?php echo $row->email; ?>" placeholder="Enter email address">
			</div>
			<div>
				<textarea class="form-control" name="address" placeholder="Enter physical address"><?php echo $row->address; ?></textarea>
			</div>
			<div>
				<button type="button" name="back" class="btn" onclick="editPatient('back')">&larr; Back</button>
				<button type="submit" name="savedit" value="true" class="btn" onclick="editPatient('savedit')"><i class="fa fa-save"></i> Save</button>
			</div>
		</form>
	</div>
</body>
</html>