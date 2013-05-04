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
			<p><em>
				You have been recruited by Kodack, the leader of an alien race that has set their eye's upon Swinburne.
				They are searching for greater knowledge of mankind and it's up to you to find them the Intel. 
				Fetch your cameras and be ready for his first mission.
			</em></p>
			<p>
				Imaginalien is a game that will take place at Swinburne over four weeks. 
				Players will receive a photo challenge every day. 
				They must then explore the Swinburne campus for the best photo opportunity 
				they can find. After taking a photo, they must upload it to the website 
				and will receive a score for their image based on how well it achieves 
				the challenge. Players must strive for the highest score in order to win the ultimate title, 
				<strong>Minion of the Month!</strong>
			</p>	
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