<?php
	require_once("admin-functions.php"); 
	session_start();
	
	if (!is_user_logged_in())
	{
		header('Location: ./sign-up.php');
	}
	
	$targetDate = date('Y-m-d');
	if (isset($_GET['date']))
	{
		$targetDate = $_GET['date'];
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
			<div id="user-details">
				<h1><?php echo get_user_name(); ?></h1>
				<p><strong>Your Score: <?php echo get_user_score(); ?></strong></p>
			</div>
			<hr/>
			<div id="user-submissions">
				<h2>Your Submissions</h2>
				
				<h3>Pending Moderation</h3>
				<p>Submissions that show up here have not yet been checked by our moderators. Moderation is done every weeknight, so they should show up soon!</p>
				<div class="submission-grid">
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'P'), 'view-submission.php'); ?>
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'UM'), 'view-submission.php'); ?>
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'UA'), 'view-submission.php'); ?>
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'UR'), 'view-submission.php'); ?>
				</div>
				
				<h3>Approved</h3>
				<p>All submissions that show up here have been given the A-OK by our moderators, and have granted you points. Hurray!</p>
				<div class="submission-grid">
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'A'), 'view-submission.php'); ?>
				</div>
				
				<h3>Rejected</h3>
				<p>If any of your submissions are rejected by moderators, they will show up here. You can click on each submission to view it and see why it was rejected.</p>
				<div class="submission-grid">
					<?php output_submissions(retrieve_submissions_for_user(get_user_id(), 'R'), 'view-submission.php'); ?>
				</div>
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