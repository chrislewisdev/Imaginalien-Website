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
					<a href="./moderate-photo.php?id=<?php echo $submission->id; ?>">
						<img src="nothing.jpg" width="100" height="100" alt="<?php echo $submission->caption; ?>" />
					</a><br />
					<?php echo $submission->caption; ?>
				</div>
			<?php	
			}
			if ($counter == 0)
			{
				echo "Looks like there are no submissions at the moment.";
			}
			
			foreach (retrieve_game_days('2013-04-10', date('Y-m-d')) as $day)
			{
				echo $day . '<br />';
			}
		?>
		</p>
	</body>
</html>