<?php
	require_once("account-functions.php"); 
	session_start();
	
	if (!is_user_logged_in())
	{
		header('Location: http://dev.imaginalien.com/page-test/login-register.php');
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
	</head>
	<body>
	<div id="container">
	<div id="wrapper">
		<div id="header">
			<!--#include file="header.ssi" -->
		</div>
		<div id="nav">
			<!--#include file="navigation.ssi" -->
		</div>
	</div>
		<div id="login">
			<hr/>
			<br/>
			<!--#include file="login.ssi" -->
			<br/>
		</div>
		<div id="content">
			<div id="user-details">
				<?php echo get_user_name(); ?><br />
				Score: <?php echo get_user_score(); ?>
			</div>
			<div id="user-submissions">
				<!-- Display submissions by date? -->
				<!-- Then show rejected entries -->
			</div>
		</div>
		<div id="footer">
			<!--#include file="footer.ssi" -->
		</div>
	</div>
	</body>
</html>