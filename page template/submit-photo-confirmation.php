<?php 
	session_start();
	require_once("image_upload.php");
	require_once("account-functions.php");
	
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
			<?php
					$greeting = array('Thankyou, ', 'Well done, ', 'Thankyou minion ');
					$response .= '<p>';
					$response .= $greeting[array_rand($greeting, 1)];
					$response .= get_user_name();
					$response .= '. ';
					
					$mainText = array('Your data has been received, I will get one of my slaves to look at it soon.',
								  'Your submission has been very useful to me. I will look over it later tonight.',
								  'You seem to have grown in intelligence since you last bowed before me. I enjoyed your submission. I will give you your score tonight!',
								  'You live to serve me another day! The slaves will rate your intel tonight!',
								  'Your submission will assist me greatly! The slaves will review it later tonight!');
					$response .= $mainText[array_rand($mainText, 1)];
					$response .= '</p><p>';
					
					$submissionCount = 3 - checkSubmissionCount(get_user_id());
					if ($submissionCount == 0)
					{
						$response .= 'You have submitted all your photos for today! ';
					}
					else
					{
						$response .= 'You have ';
						$response .= strval($submissionCount);
						
						if ($submissionCount == 1)
							$response .= ' photo left for today. ';
						else
							$response .= ' photos left for today. ';
					}
					
					$response .= 'Your score so far is ';
					$response .= strval(get_user_score());
					$response .= '.</p><p>Keep it up!</p>';
					
					echo $response;
				?>
			<?php 

			echo('<img id="user-photo" src="');
			echo $url;
			echo('" class="center-column center-image desktop-only"/>');
			
			echo('<img id="user-photo" src="');
			echo $url;
			echo('" class="center-column center-image mobile-only"');
			
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