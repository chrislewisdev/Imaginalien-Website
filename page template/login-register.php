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
				$errorMessage = "Incorrect password." . $_POST['password'];
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
			<!-- Display an error message if one is available -->
			<?php
				if ($errorMessage != "")
				{
				?>
					<div class="message">
						<?php echo $errorMessage; ?>
					</div>
				<?php
				}
			?>
			<div id="register-form">
				<form name="register" action="./login-register.php" method="post" onsubmit="return validateRegistration();">
					Email: <input id="register-email" type="text" name="email" /><br />
					Display Name: <input id="register-name" type="text" name="display_name" /><br />
					Password: <input id="register-password" type="text" name="password" /><br />
					<input type="submit" name="register" value="Go" />
				</form>
			</div>
			<div id="login-form">
				<form name="login" action="./login-register.php" method="post" onsubmit="return validateLogin();">
					Email: <input id="login-email" type="text" name="email" /><br />
					Password: <input id="login-password" type="text" name="password" /><br />
					<input type="submit" name="login" value="Go" />
				</form>
			</div>
		</div>
		<div id="footer">
			<!--#include file="footer.ssi" -->
		</div>
	</div>
	</body>
</html>