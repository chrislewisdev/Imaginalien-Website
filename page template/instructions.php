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
		<img src="images/Kodack.png" width="244" height="496" class="right-column desktop-only"/>
			<h1>Instructions</h1>
			Getting started with Imaginalien is simple:
			
			<ol>
				<li>If you haven't already, <a href="./sign-up.php">create an account</a>.</li>
				<li>Check the daily theme, either here or at the <a href="http://www.facebook.com/#!/Imaginalien">Imaginalien Facebook Page</a>.</li>
				<li>Take photos of objects at Swinburne Hawthorn that fit the daily theme!</li>
				<li><a href="./submit-photo.php">Submit your photos</a> on this website, from your mobile or PC.</li>
				<li>Receive Points and climb the <a href="scoreboard.php">Scoreboards</a>!</li>
			</ol>
			
			<h2>The Official Rules</h2>
			<ol>
				<li>Submitted photos must fit the daily theme: e.g. if the daily theme is 'L', the objects you choose must start with L!</li>
				<li>The reward you get is determined by the length of the name of your object- so for example, 'Lamp' is worth 4 points, and 'Lecture' is worth 7.</li>
				<li>However, words will be worth less if multiple people submit the same object. So try to be creative!</li>
				<li>At the end of each day, scores will be tallied and announced; then you can check your new score and leaderboard position.</li>
			</ol>
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