<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=320"/>
		<title>Imaginalien</title>
		<link rel="stylesheet" media="only screen and (max-width: 400px)" href="mobile-device.css"/>
		<link rel="stylesheet" media="only screen and (min-width: 401px)" href="desktop.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<script type="text/javascript" src="validation.js"></script>
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
		<div id="login">
			<?php
				ob_start();
				include 'login.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
		<div id="content">
			<div id="column-1">
				<h2>Daily Scores</h2>
				<table>
					<?php
						require_once 'scoreboard-functions.php';
						get_scoreboard_daily(10,null);
					?>
				</table>
				<p><a href="scoreboard-daily.php" title="Daily Scoreboard">View all</a></p>
			</div>
			<div id="column-2">
				<h2>Weekly Scores</h2>
				<table>
					<?php
						require_once 'scoreboard-functions.php';
						get_scoreboard_weekly(10,null);
					?>
				</table>
				<p><a href="scoreboard-weekly.php" title="Weekly Scoreboard">View all</a></p>
				<br/>
			</div>
			<div id="column-3">
				<h2>Overall Scores</h2>
				<table>
					<?php
						require_once 'scoreboard-functions.php';
						get_scoreboard_overall(10);
					?>
				</table>
				<p><a href="scoreboard-overall.php" title="Overall Scoreboard">View all</a></p>
			</div>
		</div>
		<div id="footer">
			<?php
				ob_start();
				include 'footer.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
	</div>
	</body>
</html>
