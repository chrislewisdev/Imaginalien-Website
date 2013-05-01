<?php 
	session_start(); 
	require_once("image_upload.php");
	
	$errorMessage = "";
	
	//Redirect users to login if they aren't already logged in.
	if(! is_user_logged_in())
	{
		//redirect to login page
		header("Location: http://www.imaginalien.com/sign-up.php"); /* Redirect browser */
		exit();
	}
	else
	{
		if(checkSubmissionCount(get_user_id()) > 4)
		{
			//Redirect to 'Sorry, all submissions used up today!'
			//header("Location: http://www.imaginalien.com/allUsedUp.php"); /* Redirect browser */
			//exit();
			$errorMessage = "Sorry, you've used up all your submissions for today. Try again tomorrow!";
		}
	}
?>
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
			<?php
				if ($errorMessage == "")
				{
				?>
					<form action="submit-photo-confirmation.php" method="post" enctype="multipart/form-data" class="aligned-form">
						<label for="file">Your photo:</label>
						<input type="file" name="file" id="file" size="20"/><br />
						<label for="title">Name of your object:</label>
						<input type="text" name="title" /><br />
						<input type="submit" name="submit-photo" value="Submit" class="button"/>
					</form>
				<?php
				}
				else
				{
					echo $errorMessage;
				}
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