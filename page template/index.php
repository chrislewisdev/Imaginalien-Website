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
			<hr/>
			<br/>
				<?php
				ob_start();
				include 'login.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
			<br/>
		</div>
		<div id="content">
			<h2>Grab your cameras, they are coming...</h2>
			<img src="images/polaroids.png" class="center-image desktop-only" width="474" height="200"/>
			<p><em>
				You have been recruited by Kodack, the leader of an alien race that has set their eye's upon Swinburne.
				They are searching for greater knowledge of mankind and it's up to you to find them the Intel. 
				Fetch your cameras and be ready for his first mission.
			</em></p>
			<h3>What is it?</h3>
				<p>Imaginalien is a photo-based game that will be played at Swinburne from the 6th to the 31st of May. 
				All you need to play is a mobile phone with a camera and a keen imagination.</p>
			<h3>How do I join?</h3>
				<p>Simply <a href="sign-up.php">sign up</a> on this website anytime over the course of the game. Grab
				your mobile and head off to Swinburne. Check the daily mission and start shooting. 
				Try to top the <a href="scoreboard.php">leaderboard</a> and become the ultimate <em>Minion of the Month</em>.</p>
			<img src="images/infographic.png" class="center-image desktop-only" width="600" height="401"/>
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