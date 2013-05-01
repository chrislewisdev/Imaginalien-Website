<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Imaginalien Admin</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<style type="text/css">
			#user-photo
			{
				max-width:800px;
				max-height:800px;
			}
		</style>
		<?php 
			require_once("admin-functions.php");
			require_once("theme-functions.php");
			$moderationStatus = get_moderation_status();
			
			//If an approval/rejection is requested, process it
			if (isset($_POST['approve']))
			{
				stage_submission_approval($_POST['id'], $_POST['final_caption']);
			}
			elseif (isset($_POST['reject']))
			{
				stage_submission_rejection($_POST['id'], $_POST['rejection_notes']);
			}
		?>
		
		<script type="text/javascript">
			//<![CDATA[
			function updateCaptionScore()
			{
				var caption = document.getElementById('caption').value;
				var score = 0;
				
				var letters = caption.split('');
				for (var i = 0; i < letters.length; i++)
				{
					if (letters[i] != ' ')
					{
						score++;
					}
				}
				
				document.getElementById('word_score').innerHTML = score.toString();
			}
			//]]>
		</script>
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
						<li><a href="./view-pending-submissions.php">Entries Pending Moderation</a></li>
						<li><a href="./approved-submissions.php">Currently Approved Entries</a></li>
						<li><a href="./rejected-submissions.php">Currently Rejected Entries</a></li>
						<li><a href="./approval-page.php">Approval Page</a></li>
					<?php	
					}
				?>
				<li><a href="./score-adjustment.php">Player Score Adjustment</a></li>
				<li><a href="./all-submissions.php?date=<?php echo date('Y-m-d'); ?>">See All Submissions</a></li>
			</ul>
		</div>
	</div>
	<div id="content">
		<!-- Moderation Display Code -->
		Moderate this photo.<br />
		<?php
			
			//Retrieve the photo to edit by the ID passed via GET
			$id = $_GET['id'];
			
			$submission = retrieve_submission($id);
			
			if (isset($_POST['approve']))
			{
				?>The submission was successfully approved. <a href="./view-pending-submissions.php">Return to pending submissions</a><br /><?php
			}
			elseif (isset($_POST['reject']))
			{
				?>The submission was successfully rejected. <a href="./view-pending-submissions.php">Return to pending submissions</a><br /><?php
			}
			
			if ($submission == null)
			{
			?>
				Invalid submission ID. 
			<?php
			}
			else
			{
			?>
				<form name="photo-moderation" action="moderate-photo.php?id=<?php echo $submission->id; ?>" method="post">
					<img id="user-photo" src="http://dev.imaginalien.com/page-test/<?php echo $submission->image_data; ?>" /><br />
					Caption: <input type="text" id="caption" name="final_caption" value="<?php echo $submission->caption; ?>" onchange="updateCaptionScore();" /> (apply word corrections if necessary)<br />
					Score: <span id="word_score"><?php echo get_word_length($submission->caption); ?></span> (this is the score the player will get purely from their word)<br />
					Bonus Points: <input type="text" name="bonus_points" value="0" /> (use this to add on points for extra challenges, e.g. Catch-up Challenges)<br />
					Submitted by <?php echo get_user_name($submission->accountID); ?><br />
					Rejection Notes:<br />
					<textarea name="rejection_notes" cols="40">Use this space to leave reasons for rejection if a submission is rejected. (max. 140 chars)</textarea><br />
					
					<!-- Display all photo themes for the user -->
					This photo was submitted during the following themes:
					<ul>
						<?php 
							$themes = get_themes_for_day($submission->date);
							foreach ($themes as $themes)
							{
							?>
								<li><?php echo $theme->description; ?></li>
							<?php
							}
						?>
					</ul>
					
					<input type="hidden" name="id" value="<?php echo $submission->id; ?>" />
					<input type="submit" name="approve" value="Approve Submission" />
					<input type="submit" name="reject" value="Reject Submission" />
				</form>
			<?php	
			}
		?>
	</div>
	</body>
</html>
		