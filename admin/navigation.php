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