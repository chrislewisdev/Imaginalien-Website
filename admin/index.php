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
		<div id="content">
			Welcome to the Imaginalien Admin Home Page. From here you can start up a new moderation process, or if one is already underway,
			access the moderation pages.
			
			<h1>Begin Moderation</h1>
			<?php
				if ($moderationStatus == 'N')
				{
				?>
					When you hit begin moderation, all photos that have not yet been moderated will be moved into a pool of submissions
					for you to moderate. Any submissions that get sent in while you are moderating will NOT appear in the pool of submissions.
					Instead, they will show up the next time you begin a mdoeration process.
					<form name="begin-moderation" action="view-pending-submissions.php" method="post">
						<input type="hidden" name="mod_begin" value="yes" />
						<input type="submit" name="submit" value="Begin Moderation" />
					</form>
				<?php
				} 
				else
				{
				?>
					Moderation is already underway. Please go to the 'Entries Pending Moderation' page to begin moderation entries.
				<?php	
				}
			?>
		</div>
	</div>
	</body>
</html>