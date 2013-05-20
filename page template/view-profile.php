<?php
	require_once("admin-functions.php"); 
	session_start();

	$id = $_GET['id'];
	try
	{
		$user_name = get_user_name($id);
	}
	catch (AccountException $e)
	{
		header('Location: http://www.imaginalien.com');
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
			<div id="user-details">
				<h1><?php echo $user_name; ?></h1>
				<p><strong><?php echo $user_name; ?>'s Score: <?php echo get_user_score($id); ?></strong></p>
			</div>
			<hr/>
			<div id="user-submissions">
				<h2><?php echo $user_name; ?>'s Submissions </h2>
				
				<div class="submission-grid">
					<?php output_submissions(retrieve_submissions_for_user($id, 'A'), 'view-submission.php'); ?>
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