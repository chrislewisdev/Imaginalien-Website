<?php 
	session_start();
	require_once("admin-functions.php");
	
	$authorised = false;
	
	if (isset($_GET['id']))
	{
		$submission = retrieve_submission($_GET['id']);
		
		if ($submission != null)
		{
			//If the submission has not been approved yet, only the author may see it
			if ($submission->status != 'A')
			{
				if (is_user_logged_in() and get_user_id() == $submission->accountID)
				{
					$authorised = true;
				}
			}
			//If the submission is Approved, let anyone view it
			else 
			{
				$authorised = true;
			}
		}
	}
	
	if (!$authorised)
	{
		header('Location: http://www.imaginalien.com');
		exit();
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
			<div id="view-submission">
				<?php
					if ($submission->status == 'R')
					{
					?>
						<p>This submission was rejected by our moderators.<br />
						Reason: <?php echo $submission->rejectionNote; ?><br /></p>
					<?php
					}
				?>
				<img id="user-photo" src="http://imaginalien.com/<?php echo $submission->image_url; ?>" /><br />
				<?php echo $submission->caption; ?><br />
				Submitted by: <?php echo get_user_name($submission->accountID); ?><br />
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