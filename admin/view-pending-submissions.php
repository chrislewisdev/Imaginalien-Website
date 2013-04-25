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
			
			if (isset($_POST['mod_begin']))
			{
				begin_moderation();
			}
		?>
	</head>
	<body>
	<div id="container">
		<div id="nav">
			<ul>
				<li><a href="./index.php">Admin Home</a></li>
				<?php 
					if ($moderationStatus == 'U')
					{
					?>
						<li><a href="./index.php">Entries Pending Moderation</a></li>
						<li><a href="./index.php">Currently Approved Entries</a></li>
						<li><a href="./index.php">Currently Rejected Entries</a></li>
						<li><a href="./index.php">Approval Page</a></li>
					<?php	
					}
				?>
				<li><a href="./index.php">Player Score Adjustment</a></li>
				<li><a href="./index.php">See All Submissions</a></li>
			</ul>
		</div>
		<div id="content">
			<?php
				$submissions = retrieve_submissions('UM');
				
				foreach ($submissions as $submission)
				{
				?>
					<div id="submission">
						<img src="nothing.jpg" width="100" height="100" /><br />
						<?php echo $submission->caption; ?>
					</div>
				<?php
				}
			?>
		</div>
	</div>
	</body>
</html>