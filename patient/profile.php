<?php
	//settings
	require_once('controller.php');
	if(isset($_SESSION['patient']['pid'])) {
		$profile = $patient->readProfile($_SESSION['patient']['pid']);
	} else {
		exit("Missing user session token. Sorry failed to load profile account data!.");
	}
?>
<style type="text/css">
	.container-fluid {
		width: 450px;
		max-width: 100%;
		background-color: #fff;
		border-radius: 5px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		margin: 0 auto;
		padding: 15px 0;
		transform: translate(0%, 50%);
		text-align: center;
	}
	.header {
		color: rgb(15, 107, 156);
		font-size: 1.5em;
		/*border-bottom: thin solid #ccc;*/
		margin: 40px 0 10px 0;
	}
	.label {
		text-align: left;
		text-indent: 30px;
		color: #777;
	}
	.profile-icon {
		position: absolute;
		margin-top: -80px;
		background-color: #fff;
		color: rgb(93, 182, 211);
		border: thin solid #fff;
		margin-left: -50px;
		border-radius: 50%;
		font-size: 6em;
		padding: 5px 8px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		text-indent: 5px;
	}
</style>
<div class="page-header"><i class="la la-user"></i> My Profile</div>
<div class="container-fluid">
	<i class="la la-user profile-icon"></i>
	<div class="header"><?php echo $profile->firstname.' '.$profile->lastname; ?></div>
	<div class="label">Firstname: <?php echo $profile->firstname; ?></div>
	<div class="label">Lastname: <?php echo $profile->lastname; ?></div>
	<div class="label">ID Number: <?php echo $profile->idnumber; ?></div>
	<div class="label">Birthday: <?php echo date('d F Y', strtotime($profile->dob)); ?></div>
	<div class="label">Gender: <?php echo ucfirst($profile->gender); ?></div>
	<div class="label">Telephone: <?php echo $profile->telephone; ?></div>
	<div class="label">Email: <?php echo $profile->email; ?></div>
</div>