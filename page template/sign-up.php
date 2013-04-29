<?php session_start(); ?>

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
		<hr/>
		<div id="content">
			<h2>Sign Up</h2>
			<form name="sign-up" action="" method="post" id="sign-up-form">
				<p><label for="username">Username:</label> <input type="text" name="username" size="20"/></p>
				<p><label for="email">Email address:</label> <input type="text" name="email" size="40"/></p>
				<br/>
				<p><label for="password">Password:</label> <input type="text" name="password" size="20"/></p>
				<p><label for="password-confirm">Confirm password:</label> <input type="text" name="password-confirm" size="20"/></p>
				<br/>
				<p><input type="submit" value="Join" class="button"/></p>
			</form>
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