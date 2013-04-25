<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<?php 
			require_once("admin-functions.php");
			$moderationStatus = get_moderation_status();
		?>
	</head>
	<body>
	<div id="container">
		<div id="nav">
			<ul>
				<li><a href="./index.php">Admin Home</a></li>
				<?php 
					if ($moderationStatus == 'U')
					{
					?>
						<li><a href="./index.php">Entries Pending Moderation</a></li>
						<li><a href="./index.php">Currently Approved Entries</a></li>
						<li><a href="./index.php">Currently Rejected Entries</a></li>
						<li><a href="./index.php">Approval Page</a></li>
					<?php	
					}
				?>
				<li><a href="./index.php">Player Score Adjustment</a></li>
				<li><a href="./index.php">See All Submissions</a></li>
			</ul>
		</div>
	</div>
	</body>
</html>