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
			<?php
				ob_start();
				include 'navigation.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
	</div>
	</body>
</html>