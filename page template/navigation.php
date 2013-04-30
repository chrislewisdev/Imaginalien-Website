<ul>
	<li><a href="index.php" title="Home">Home</a></li>
	<li><a href="instructions.php" title="Instructions">Instructions</a></li>
	<li><a href="scoreboard.php" title="Scoreboards">Scoreboards</a></li>
	<li><a href="gallery.php" title="Gallery">Gallery</a></li>
	<?php
		require_once("account-functions.php");
		if (is_user_logged_in())
		{
		?>
			<li><a href="profile.php" title="Profile">Profile</a></li>
		<?php
		}
	?>
</ul>