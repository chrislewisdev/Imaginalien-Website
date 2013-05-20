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
			
			//Retrieve the photo to edit by the ID passed via GET
			$id = $_GET['id'];
			
			//If an approval/rejection is requested, process it
			if (isset($_POST['approve']))
			{
				stage_submission_approval($_POST['id'], $_POST['final_caption'], $_POST['bonus_points']);
			}
			elseif (isset($_POST['reject']))
			{
				stage_submission_rejection($_POST['id'], $_POST['rejection_notes']);
			}
			
			$submission = retrieve_submission($id);
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
			
			function googleIt()
			{
				var queryString = document.getElementById('caption').value.replace(' ', '+');
				
				window.open("http://www.google.com.au/search?q=" + queryString, "_blank");
			}
			//]]>
		</script>
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
		<!-- Moderation Display Code -->
		Moderate this photo.<br />
		<?php
			
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
					<img id="user-photo" src="http://imaginalien.com/<?php echo $submission->image_url; ?>" /><br />
					Caption: <input type="text" id="caption" name="final_caption" value="<?php echo $submission->caption; ?>" onchange="updateCaptionScore();" /> <button type="button" onclick="googleIt();">Google It!</button> (apply word corrections if necessary)<br />
					Score: <span id="word_score"><?php echo get_word_length($submission->caption); ?></span> (this is the score the player will get purely from their word)<br />
					Bonus Points: <input type="text" name="bonus_points" value="<?php echo $submission->bonusPoints; ?>" /> (use this to add on points for extra challenges, e.g. Catch-up Challenges)<br />
					Submitted by <?php echo get_user_name($submission->accountID); ?><br />
					Rejection Notes:<br />
					<textarea name="rejection_notes" cols="40" rows="5"></textarea><br />
					
					<!-- Display all photo themes for the user -->
					This photo was submitted during the following themes: (<?php echo $submission->submit_time; ?>)
					<ul>
						<?php 
							$themes = get_themes_for_day($submission->submit_time);
							foreach ($themes as $theme)
							{
							?>
								<li><?php echo $theme->description; ?></li>
							<?php
							}
						?>
					</ul>
					
					<input type="hidden" name="id" value="<?php echo $submission->id; ?>" />
					<?php
						if ($submission->status != 'A' and $submission->status != 'R')
						{
						?>
							<input type="submit" name="approve" value="Approve Submission" />
							<input type="submit" name="reject" value="Reject Submission" />
						<?php
						}
					?>
				</form>
			<?php	
			}
		?>
	</div>
	</div>
	</body>
</html>
		