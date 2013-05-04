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
	</div>
	</body>
</html>