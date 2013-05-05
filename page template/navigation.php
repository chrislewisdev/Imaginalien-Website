<a href="https://www.facebook.com/Imaginalien"><img src="images/facebookIcon.jpg" title="Imaginalien Facebook Page" alt="Facebook Page" width="100" height="38" id="facebook-icon"/></a>
<br class="mobile-only"/>
<ul>
	<li><a href="index.php" title="Home">Home</a></li>
	<li><a href="instructions.php" title="Instructions">Instructions</a></li>
	<li><a href="scoreboard.php" title="Scoreboards">Leaderboards</a></li>
	<li><a href="gallery.php" title="Gallery">Gathered Intel</a></li>
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