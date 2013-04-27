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
			
			//If a score adjustment was submitted, process it
			if (isset($_POST['submit']))
			{
				$result = adjust_user_score_by_name($_POST['name'], $_POST['adjustment']);
			}
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
		<h1>Score Adjustment</h1>
		Use this page to apply bonuses/negatives players, such as bonus points for "Photo of the Day", or negatives for players
		who may be abusing the rules somehow.<br /><br />
		
		<?php
			if (isset($_POST['submit']))
			{
				if ($result)
				{
					?>The score adjustment was successfully applied.<br /><br /><?php
				}
				else 
				{
					?>The score adjustment failed. This is most likely to be due to an incorrect player name.<?php
				}
			}
		?>
		
		<form name="score-adjustment" action="./score-adjustment.php" method="post">
			Name: <input type="text" name="name" value="" /><br />
			Score <input type="text" name="adjustment" value="0" /> (e.g. 5 or -5)<br />
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>
	</body>
</html>