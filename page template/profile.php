<?php
	require_once("account-functions.php"); 
	session_start();
	
	if (!is_user_logged_in())
	{
		header('Location: http://dev.imaginalien.com/page-test/sign-up.php');
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
				Your Score: <?php echo get_user_score(); ?>
			</div>
			<div id="user-submissions">
				<!-- Display submissions by date? -->
				<!-- Then show rejected entries -->
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