<!DOCTYPE html>
<html>
	<head>
		<title>Work In Progress</title>
	</head>
	<body>
		<p>
		<!-- Moderation Display Code -->
		Here is a bunch of photos to moderate.<br />
		<?php
			require_once("admin-functions.php");
			
			//For every pending submission, output a thumbnail with a link to the photo's moderation page
			$counter = 0;
			foreach (retrieve_submissions() as $submission)
			{
				$counter++;
				//Note that although I'm closing the PHP tag here, PHP will actually continue to loop through and output the enclosed HTML
				//for each entry. It's ugly! But it's handy, since you get to layout your HTML nicely rather than echo-ing HTML strings.
			?>
				<div>
					<img src="nothing.jpg" width="100" height="100" alt="<?php echo $submission->caption; ?>" /><br />
					<?php echo $submission->caption; ?>
				</div>
			<?php	
			}
			if ($counter == 0)
			{
				echo "Looks like there are no submissions at the moment.";
			}
		?>
		</p>
	</body>
</html>