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
						<li><a href="./view-pending-submissions.php">Entries Pending Moderation</a></li>
						<li><a href="./approved-submissions.php">Currently Approved Entries</a></li>
						<li><a href="./rejected-submissions.php">Currently Rejected Entries</a></li>
						<li><a href="./approval-page.php">Approval Page</a></li>
					<?php	
					}
				?>
				<li><a href="./score-adjustment.php">Player Score Adjustment</a></li>
				<li><a href="./all-submissions.php?date=<?php echo date('Y-m-d'); ?>">See All Submissions</a></li>
			</ul>
		</div>
	</div>
	<div id="content">
			<?php
				output_submissions(retrieve_submissions('UR'), 'moderate-photo.php');
			?>
		</div>
	</body>
</html>