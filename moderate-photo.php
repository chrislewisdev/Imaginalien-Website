<!DOCTYPE html>
<html>
	<head>
		<title>Work In Progress</title>
	</head>
	<body>
		<p>
		<!-- Moderation Display Code -->
		Moderate this photo.<br />
		<?php
			require_once("admin-functions.php");
			
			//Retrieve the photo to edit by the ID passed via GET
			$id = $_GET['id'];
			
			$submission = retrieve_submission($id);
			
			if ($submission == null)
			{
			?>
				Invalid submission ID. 
			<?php
			}
			else
			{
			?>
				Submitted by: <?php echo get_user_name($submission->accountID); ?><br />
				Suggested Score: <br />
				Caption: <?php echo $submission->caption; ?><br />
			<?php	
			}
		?>
		</p>
	</body>
</html>