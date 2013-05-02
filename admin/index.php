<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<?php 
			require_once("admin-functions.php");
			$moderationStatus = get_moderation_status();
		?>
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
		<div id="content">
			<h1>Admin Home</h1>
			Welcome to the Imaginalien Admin Home Page. From here you can start up a new moderation process, or if one is already underway,
			access the moderation pages.
			
			<h2>Begin Moderation</h2>
			<?php
				if ($moderationStatus == 'N')
				{
				?>
					When you hit begin moderation, all photos that have not yet been moderated will be moved into a pool of submissions
					for you to moderate. Any submissions that get sent in while you are moderating will NOT appear in the pool of submissions.
					Instead, they will show up the next time you begin a mdoeration process.
					<form name="begin-moderation" action="view-pending-submissions.php" method="post">
						<input type="hidden" name="mod_begin" value="yes" />
						<input type="submit" name="submit" value="Begin Moderation" />
					</form>
				<?php
				} 
				else
				{
				?>
					Moderation is already underway. Please go to the 'Entries Pending Moderation' page to begin moderation entries.
				<?php	
				}
			?>
		</div>
	</div>
	</body>
</html>