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
		<h1>Approval Page</h1>
		
		On this page you can complete the moderation process by finalising all moderated submissions. Once you hit Apply Moderation,
		all approved photos will have their scores applied, and show up in the main website. All rejected submissions will be kept only
		in the Admin area, under "See All Submissions".
		
		<h2>Submission Stats</h2>
		Below are the stats for all photos submitted today.
		
		<table>
			<thead>
				<tr>
					<th>Word</th>
					<th>Times Used</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$wordStats = generate_word_count_stats();
					
					foreach ($wordStats as $word => $usageCount)
					{
					?>
						<tr>
							<td><?php echo $word; ?></td>
							<td><?php echo $usageCount; ?></td>
						</tr>
					<?php
					}
				?>
			</tbody>
		</table>
		
		
		<?php
			$unmoderatedPhotos = count_unmoderated_submissions();
			
			if ($unmoderatedPhotos == 0)
			{
			?>
				<form name="apply-moderation" action="approval-confirmation.php" method="post">
				<input type="submit" name="apply" value="Apply Moderation" />
			</form>
			<?php
			}
			else
			{
			?>
				There are still <?php echo $unmoderatedPhotos; ?> submissions that need moderation. All submissions must be moderated before
				the moderation process can be finished.
			<?php
			}
		?>
	</div>
	</body>
</html>