<?php
	//HCP Manages profile details
	require_once('controller.php');
	$hcp->protected_page();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.container-fluid {
			width: 400px;
			height: 200px;
			max-width: 100%;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			margin: 50px auto;
			padding: 10px;
		}
		table {
			border-collapse: collapse;
		}
		table tr td {
			border: 0 none;

		}
		.page-head {
			font-weight: bold;
			text-align: center;
			color: #28789f;
			font-size: 2em;
			border-bottom: thin solid #eee;
			padding: 15px 0; 
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
		.profile-icon {
			font-size: 8em;
			color: #28789f;
		}
		.profile-item {
			font-size: 1.5em;
			margin-top: 5px;
		}
	</style>
</head>
<body>
	<div class="page-head"><i class="la la-user"></i> myProfile Details</div>
	<div class="container-fluid">
		<table>
			<tr>
				<td><i class="fa fa-user-md profile-icon"></i></td>
				<td valign="top">
					<?php
						$profile = $hcp->getProfile();
						echo "<div class='profile-item'><i class='fa fa-user-md'></i> ".$profile->username."</div>";
						echo "<div class='profile-item'><i class='fa fa-envelope'></i> ".$profile->email."</div>";
						echo "<div class='profile-item'><i class='fa fa-phone'></i> (012) 713 3369</div>";
					?>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>