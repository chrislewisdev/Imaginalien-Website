<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<?php 
			require_once("admin-functions.php");
			
			if (isset($_POST['mod_begin']))
			{
				begin_moderation();
			}
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
		<div id="content">
			<?php
				if (output_submissions(retrieve_submissions('UM'), 'moderate-photo.php') == 0)
				{
				?>
					All submissions have been successfully moderated. Go to the Approval Page to complete the moderation process,
					or if you wish to change the approval status of any photos, go to Currently Approved/Rejected Entries to see
					all the submissions that you have already approved or rejected.
				<?php
				}
			?>
		</div>
	</div>
	</body>
</html>