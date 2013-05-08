
<br class="mobile-only"/>
<ul>
	<div id="nav-wrapper">
	<li><a href="index.php" title="Home">Home</a></li>
	<li><a href="instructions.php" title="Instructions">How to play</a></li>
	<li><a href="scoreboard.php" title="Scoreboards">Leaderboards</a></li>
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
	
	<li><a href="https://www.facebook.com/Imaginalien">Facebook</a></li>
	</div>
</ul>