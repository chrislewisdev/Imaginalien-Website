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
		<img src="images/Nikonia.png" width="289" height="496" class="right-column desktop-only"/>
			<h1>Instructions</h1>
			<p>Getting started with Imaginalien is simple:</p>
			
			<p><img src="images/info-1.jpg" width="200" height="200"/></p>
			<p>1. If you haven't already, <a href="./sign-up.php">create an account</a>.</p>
			<p>2. Check the daily mission on your mobile.</p>
			<p>If, for example, the mission is the letter 'A' you must take a photo of something starting with the 
			letter A. If the mission was 'Red' you must take a photo of something red. If you don't 
			achieve the mission your photo won't gain points.
			
			<hr/>
			
			<p><img src="images/info-2.jpg" width="200" height="200"/></p>
			<p>3. Take up to 3 photos anywhere on the Swinburne campus that fit the daily mission!
			   Be creative! Extra points are awarded to unique photos and points may be lost if the
			   same object has been submitted multiple times</p>
			   
			<hr/>
			
			<p><img src="images/info-3.jpg" width="200" height="200"/></p>
			<p>4. <a href="./submit-photo.php">Submit your photos</a> on this website, from your mobile or PC.</p>
			<p>5. You will recieve your score at the end of the day. Climb the <a href="scoreboard.php">leaderboard</a> and 
			   attempt to win <em>Minion of the Month</em>.</p>
			 <p>To begin with, points will be awarded based on the length of your word (eg. 'computer' is worth 8, 'lamp' is worth 4).
			 Although in later stages of the game you will face new challenges and may be 
			 scored on different criteria (eg. No. of people in the photo).</p>
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