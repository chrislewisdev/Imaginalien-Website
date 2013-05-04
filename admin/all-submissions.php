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
			
			$targetDate = $_GET['date'];
			$dates = retrieve_game_days('2013-04-28', date('Y-m-d'));
		?>
	</head>
	<body>
	<div id="container">
		<div id="wrapper">
			<div id="header">
				<?php
					ob_start();
					include 'header.php';
					$out = ob_get_contents();
					ob_end_clean();
					echo $out;
				?>
			</div>
			<div id="nav">
				<?php
					ob_start();
					include 'navigation.php';
					$out = ob_get_contents();
					ob_end_clean();
					echo $out;
				?>
			</div>
		</div>
		<div id="content">
			<!-- Output list of dates the game was played on -->
			<ul id="game-dates">
				<?php
					/*foreach ($dates as $date)
					{
					?>
						<li><a href="all-submissions.php?date=<?php echo $date; ?>"><?php echo $date; ?></a></li>
					<?php
					}*/
					output_game_days('2013-04-28', date('Y-m-d'), 'all-submissions.php');
				?>
			</ul>
			<h1>Approved Entries</h1>
			<div class="submission-grid">
				<?php
					output_submissions(retrieve_submissions('A', $targetDate), 'moderate-photo.php');
				?>
			</div>
			
			<h1>Rejected Entries</h1>
			<div class="submission-grid">
				<?php
					output_submissions(retrieve_submissions('R', $targetDate), 'moderate-photo.php');
				?>
			</div>
		</div>
	</div>
	</body>
</html>