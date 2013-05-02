<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<?php 
			require_once("admin-functions.php");
			
			if (isset($_POST['apply']))
			{
				end_moderation();
			}
			
			$moderationStatus = get_moderation_status();
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
			Moderation is now complete. Good work! Take the rest of the night off. Or don't, if you have IMPORTANT UNI WORK to do.
		</div>
	</div>
	</body>
</html>