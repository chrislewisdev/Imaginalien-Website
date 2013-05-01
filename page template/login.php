<form name="login" action="./sign-up.php" method="post" onsubmit="return validateLogin();">
	<?php
		require_once("account-functions.php");
		//Only output login/register buttons if user is logged in
		if (!is_user_logged_in())
		{
		?>
			<label for="email" class="mobile-only">Email: </label><input type="text" id="login-email" name="email" placeholder="email"/>
			<label for="password" class="mobile-only">Password: </label><input type="password" id="login-password" name="password" placeholder="password"/>
			<input type="submit" name="login" value="Login" class="button"/>
			<a href="sign-up.php" title="Register" class="button">Register</a>
		<?php
		}
		//If someone is logged in, output their name
		else 
		{
		?>
			Welcome, <?php echo get_user_name(); ?>.
			<input type="submit" name="logout" value="Logout" class="button" />
		<?php
		}
	?>
	<a href="submit-photo.php" title="Submit Photo" class="button" id="photo-button">Submit Photo</a>
</form>
