<?php 
	session_start();
	require_once("image_upload.php");
	
	if (isset($_POST['submit-photo']))
	{
		$url = attemptSubmission();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=320"/>
		<title>Imaginalien</title>
		<link rel="stylesheet" media="only screen and (max-device-width: 400px)" href="mobile-device.css"/>
		<link rel="stylesheet" media="only screen and (min-device-width: 401px)" href="desktop.css"/>
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
			<p><?php
					$responses = array('Your data has been received, I’ll get one of my slaves to look at it soon. Well done! Now go out and find more!',
								  'PATHETIC HUMAN! Well done! Your submission has been very useful to me. I will look over it later tonight, now get back out there!',
								  'You seem to have grown in intelligence since you last bowed before me. I enjoyed your submission. I will give you your score tonight!',
								  'Well done minion, you live to serve me another day! The slaves will rate your intel tonight!',
								  'Thank you inferior humans, your submissions will assist me greatly! The slaves will review it later tonight!');
								
					echo $responses[array_rand($responses, 1)];
				?></p> 
			<p>You have <strong><?php echo 3 -  checkSubmissionCount(get_user_id()); ?></strong> photos remaining today.<p>
			<?php 

			echo('<img src="');
			echo $url;
			echo('" class="center-column center-image desktop-only"/>');
			
			echo('<img src="');
			echo $url;
			echo('" class="center-column center-image mobile-only" width="300" height="300"');
			
			?>
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