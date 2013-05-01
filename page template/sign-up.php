<?php
	require_once("account-functions.php");
	session_start();
	
	//Initialise an error-message holder; if it gets set to anything, the section above login/register form will show the message
	$errorMessage = "";
	//Login/registration success handle to check if we want to redirect to the user profile page
	$loginSuccess = false;

	//Check for a registration request
	if (isset($_POST['register']))
	{
		//Try process the registration
		try
		{
			create_account($_POST['email'], $_POST['display_name'], $_POST['password']);
			login($_POST['email'], $_POST['password']);
			$loginSuccess = true;
		}
		catch (AccountException $e)
		{
			$errorMessage = $e->getMessage();
		}
	}
	//Check for a login request
	if (isset($_POST['login']))
	{
		//Try process the login
		try
		{
			$loginSuccess = login($_POST['email'], $_POST['password']);
			if (!$loginSuccess)
			{
				$errorMessage = "Incorrect password.";
			}
		}
		catch (AccountException $e)
		{
			$errorMessage = $e->getMessage();
		}
	}
	//Check for a logout request
	if (isset($_POST['logout']))
	{
		logout();
		$errorMessage = "Successfully logged out.";
	}
	
	//If a login/register was successfully processed, redirect to the user profile page
	if ($loginSuccess)
	{
		header('Location: http://dev.imaginalien.com/page-test/profile.php');
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
		<hr />
		<div id="content">
			<?php
				//Display an error message if one is available
				if ($errorMessage != "")
				{
				?>
					<div class="message">
						<?php echo $errorMessage; ?>
					</div>
				<?php
				}
			?>
			<div id="register-login-content">
				<div id="register-side">
					<h2>Sign Up</h2>
					<form name="sign-up" action="./sign-up.php" method="post" class="aligned-form" onsubmit="return validateRegistration();">
						<p>
							<label for="display_name">Username:</label> <input type="text" id="register-email" name="display_name" size="20"/><br />
							<label for="email">Email address:</label> <input type="text" id="register-name" name="email" size="40"/>
						</p>
						
						<p>
							<label for="password">Password:</label> <input type="password" id="register-password" name="password" size="20"/><br />
							<label for="password-confirm">Confirm password:</label> <input type="password" id="register-confirm-password" name="password-confirm" size="20"/>
						</p>
						
						<p><input type="submit" name="register" value="Join" class="button"/></p>
					</form>
				</div>
				<div id="login-side">
					<h2>Login</h2>
					<form name="login" action="./sign-up.php" method="post" class="aligned-form" onsubmit="return validateLogin();">
						<p>
							<label for="email">Email address:</label> <input type="text" id="login-email" name="email" size="40"/><br />
							<label for="password">Password:</label> <input type="password" id="login-password" name="password" size="20"/>
						</p>
						
						<p><input type="submit" name="login" value="Login" class="button"/></p>
					</form>
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