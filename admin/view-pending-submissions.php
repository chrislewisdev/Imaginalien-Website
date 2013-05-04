<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<?php 
			require_once("admin-functions.php");
			
			if (isset($_POST['mod_begin']))
			{
				begin_moderation();
			}
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
			<div class="submission-grid">
			<?php
				if (output_submissions(retrieve_submissions('UM'), 'moderate-photo.php') == 0)
				{
				?>
					All submissions have been successfully moderated. Go to the Approval Page to complete the moderation process,
					or if you wish to change the approval status of any photos, go to Currently Approved/Rejected Entries to see
					all the submissions that you have already approved or rejected.
				<?php
				}
			?>
			</div>
		</div>
	</div>
	</body>
</html>