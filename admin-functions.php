<?php
/**
 * admin-functions.php by Chris Lewis
 * Contains various function definitions for implementing the moderation process of Imaginalien.
 */
 
//Account functions are required to retrieve information about users
require_once("account-functions.php");

/** Simple storage class for photo submissions as they are represented on the database. None of this data is encrypted like the Accounts. */
class SubmissionRecord
{
	/** Database ID of the submission. */
	public $id;
	/** ID of the user who submitted this photo. */
	public $accountID;
	/** Time it was submitted- Type of MySQL Date info??? */
	public $submit_time;
	/** URL link to the location where the image file is stored upon the server. */
	public $image_url;
	/** Score for this submission. */
	public $score;
	/** Caption (word) for this submission. */
	public $caption;
	/** Status of this submission- 'P' means Pending Approval, 'A' means Approved, 'R' means Rejected. */
	public $status;
	/** Misc. rejection note of this submission (only used in rejected entries). */
	public $rejectionNote;
	
	function __construct($_id, $_accountID, $_submit_time, $_image_url, $_score, $_caption, $_status, $_rejectionNote)
	{
		$this->id = $_id;
		$this->accountID = $_accountID;
		$this->submit_time = $_submit_time;
		$this->image_url = $_image_url;
		$this->score = $_score;
		$this->caption = $_caption;
		$this->status = $_status;
		$this->rejectionNote = $_rejectionNote;
	}
}

/**
 * Returns the length score for a given word/caption.
 * @param $caption The string to evaluate the length of.
 * @return The length of the caption, not counting spaces.
 */
function get_word_length($caption)
{
	$score = 0;
	foreach (str_split($caption) as $letter)
	{
		if ($letter != ' ') $score++;
	}
	return $score;
}

/**
 * Sets the mod_process entry in the ima_mod_status table to the specified status value. Used to signify when moderation is underway/finished.
 * @param $status New status to set for the moderation process.
 * @return void
 */
function set_moderation_status($status)
{
	$connection = connect();
	
	$update = $connection->prepare("UPDATE ima_mod_status SET status = ? WHERE name = 'mod_process'");
	$update->bind_param("s", $status);
	$update->execute();
	
	$update->close();
	$connection->close();
}

/**
 * Retrieves the current moderation status from the database (Not In Process or Underway).
 * @return A string denoting the current moderation status.
 */
function get_moderation_status()
{
	$connection = connect();
	
	$select = $connection->prepare("SELECT status FROM ima_mod_status WHERE name = 'mod_process'");
	$select->bind_result($status);
	$select->execute();
	$select->store_result();
	$select->fetch();
	
	$connection->close();
	
	return $status;
}

/**
 * Begins a moderation process by moving all currently Pending submissions to Undergoing Moderation.
 * @return true if the operation affected any rows, false otherwise.
 */
function begin_moderation()
{
	$connection = connect();
	
	$result = true;
	$pendingStatus = 'P'; $moderationStatus = 'UM';
	
	//Prepare a query to change status of all Pending submissions ('P') to 'UM' for Undergoing Moderation
	$update = $connection->prepare("UPDATE ima_submissions SET status = ? WHERE status = ?");
	$update->bind_param("ss", $moderationStatus, $pendingStatus);
	$update->execute();
	
	if ($update->affected_rows == 0) $result = false;
	
	$connection->close();
	
	set_moderation_status('U');
	
	return $result;
}

/**
 * Ends a moderation cycle by applying the approval status and score of every photo that's been moderated.
 * @return void
 */
function end_moderation()
{
	//To start off, retrieve our list of word stats for this moderation cycle
	$wordStats = generate_word_count_stats();
	
	//Then retrieve all submissions that have been staged for approval
	$approvedSubmissions = retrieve_submissions('UA');
	
	//Loop through all approved submissions and process their approval, with their calculated score
	foreach ($approvedSubmissions as $submission)
	{
		//A caption's score is its length, minus the no. duplicated entries- with a minimum score of 1
		$score = max(get_word_length($submission->caption) - $wordStats[$submission->caption] + 1, 1); // + Bonus Theme Points?
		//echo "Score for " . $submission->caption . ": " . $score . "<br />";
		apply_approval($submission->id, $submission->accountID, $score);
	}
	
	//Now, get all rejected submissions to fully apply their rejection
	$rejectedSubmissions = retrieve_submissions('UR');
	foreach ($rejectedSubmissions as $submission)
	{
		//echo "Rejected: " . $submission->caption;
		apply_rejection($submission->id);
	}
	
	set_moderation_status('N');
}

/**
 * Gets all photo submissions of the specified status (with optional date) and returns them.
 * @param $status The type of submission status to retrieve submissions of. Defaults to Pending.
 * @param $date (Optional) The date (as a string, in Y-m-d format) that all retrieved submissions should fall on.
 * @return An array of SubmissionRecord objects.
 */
function retrieve_submissions($status = 'P', $date = null)
{
	$connection = connect();
	
	//Since we have an optional date parameter, build up the query as a string before "preparing" it
	$query = "SELECT * FROM ima_submissions WHERE status = ?";
	if ($date != null)
	{
		$query .= " AND submit_time = ?";
	}
	
	//Retrieve all submissions from the database
	$select = $connection->prepare($query);
	if ($date != null)
	{
		$select->bind_param("ss", $status, $date);
	}
	else
	{
		$select->bind_param("s", $status);
	}
	$select->bind_result($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	$select->execute();
	$select->store_result();
	
	//Loop through all submissions and build up our list
	$submissions = array();
	while ($select->fetch())
	{
		$submissions[] = new SubmissionRecord($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	}
	
	$connection->close();
	
	return $submissions;
}

/**
 * Retrieves submissions for a specified user.
 * @param $id The ID of the user to retrieve entries for.
 * @param $status The status for which to retrieve submissions.
 * @param $date (Optional) A specific date for which to retrieve submissions.
 * @return A list of SubmissionRecord objects.
 */
function retrieve_submissions_for_user($id, $status, $date = null)
{
	$connection = connect();
	
	if ($date != null)
	{
		$select = $connection->prepare("SELECT * FROM ima_submissions WHERE account_id = ? AND status = ? AND submit_time = ?");
		$select->bind_param("iss", $id, $status, $date);
	}
	else 
	{
		$select = $connection->prepare("SELECT * FROM ima_submissions WHERE account_id = ? AND status = ?");
		$select->bind_param("is", $id, $status);
	}
	
	$select->bind_result($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	$select->execute();
	$select->store_result();
	
	//Loop through all submissions and build up our list
	$submissions = array();
	while ($select->fetch())
	{
		$submissions[] = new SubmissionRecord($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	}
	
	$connection->close();
	
	return $submissions;
}

/** 
 * Retrieves a single submission entry.
 * @param $id The database ID of the submission to retrieve.
 * @return A SubmissionRecord object of the submission, or null if it doesn't exist.
 */
function retrieve_submission($id)
{
	$connection = connect();
	
	//Retrieve the specified entry from the database
	$select = $connection->prepare("SELECT * FROM ima_submissions WHERE id = ?");
	$select->bind_param("i", $id);
	$select->bind_result($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	$select->execute();
	$select->store_result();
	
	//Check that it actually exists
	if ($select->num_rows <= 0)
	{
		return null;
	}
	
	//Create the submission record object
	$select->fetch();
	$submission = new SubmissionRecord($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus, $dbRejectionNote);
	
	$connection->close();
	
	return $submission;
}

/**
 * Convenience function to output a set of div-contained submission thumbnails.
 * @param $submissions List of submissions to output (e.g. via retrieve_submissions)
 * @param $targetPage (Optional) a page to which to link each thumbnail, with a GET id of the submission ID
 * @return the no. of submissions that were output
 */
function output_submissions($submissions, $targetPage = "")
{
	//$submissions = retrieve_submissions($status, $date);
				
	$counter = 0;
	foreach ($submissions as $submission)
	{
		$counter++;
	?>
		<div class="submission">
			<?php 
				if ($targetPage != "") 
				{
					?><a href="./<?php echo $targetPage; ?>?id=<?php echo $submission->id; ?>"><?php
				}
			?>
			<img src="http://imaginalien.com/<?php echo $submission->image_url; ?>" width="100" height="100" border="0" /><br />
			<?php echo $submission->caption; ?>
			<?php 
				if ($targetPage != "") 
				{
					?></a><?php
				}
			?>
		</div>
	<?php
	}
	
	return $counter;
}

/**
 * Stages a submission for approval- that is, takes a submission that is Undergoing Moderation and changes it to Approved pending Application
 * @param $id ID of the submission to approve.
 * @param $caption Final caption to set for the submission.
 * @return true if successful, false otherwise.
 */
function stage_submission_approval($id, $caption)
{
	$connection = connect();
	$status = 'UA';
	
	$update = $connection->prepare("UPDATE ima_submissions SET status = ?, caption = ? WHERE id = ?");
	$update->bind_param("ssi", $status, $caption, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
		$result = false;
	else
		$result = true;
	
	$connection->close();
	
	return $result;
}

/**
 * Applies full approval for a submission, including updating the score of the player.
 * @param $id The ID of the submission to approve.
 * @param $playerID The ID of the player who submitted this submission.
 * @param $score The final score to set for it, and to update the player score with.
 * @return void
 */
function apply_approval($id, $playerID, $score)
{
	$connection = connect();
	$status = 'A';
	
	$update = $connection->prepare("UPDATE ima_submissions SET status = ?, score = ? WHERE id = ?");
	$update->bind_param("sii", $status, $score, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
		$result = false;
	else
		$result = true;
	
	$connection->close();
	
	adjust_user_score($playerID, $score);
	
	return $result;
}

/**
 * Stages a submission for rejection- moves it from Underdoing Moderation to Rejected pending Application
 * @param $id ID of the submission to reject.
 * @param $reason The string describing why it was rejected
 * @return true if successful, false otherwise.
 */
function stage_submission_rejection($id, $reason)
{
	$connection = connect();
	$status = 'UR';
	
	$update = $connection->prepare("UPDATE ima_submissions SET status = ?, rejection_note = ? WHERE id = ?");
	$update->bind_param("ssi", $status, $reason, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
		$result = false;
	else
		$result = true;
	
	$connection->close();
	
	return $result;
}

/**
 * Applies full rejection to a submission.
 * @param $id The ID of the submission to reject.
 * @return True if the operation completed successfully.
 */
function apply_rejection($id)
{
	$connection = connect();
	$status = 'R';
	
	$update = $connection->prepare("UPDATE ima_submissions SET status = ? WHERE id = ?");
	$update->bind_param("si", $status, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
		$result = false;
	else
		$result = true;
	
	$connection->close();
	
	return $result;
}

/**
 * Based off of all currently staged Approved entries (during Moderation), generates a list of all used words and their usage counts.
 * @return A dictionary where each used word is a key, and its usage count is the value.
 */
function generate_word_count_stats()
{
	$connection = connect();
	
	//Use SQL summary functions to retrieve the count of each word
	$select = $connection->prepare("SELECT caption, COUNT(*) FROM ima_submissions WHERE status = 'UA' GROUP BY caption ORDER BY COUNT(*) ASC");
	$select->bind_result($dbCaption, $dbCount);
	$select->execute();
	$select->store_result();
	
	//Once we have our results, loop through the stats array and build our dictionary of word/usage pairs
	$stats = array();
	while ($select->fetch())
	{
		$stats[$dbCaption] = $dbCount;
	}
	
	$connection->close();
	
	return $stats;
}

$IMAGINALIEN_LAUNCH_DATE = '2013-05-06';
/**
 * Returns a list of days on which the game was played between the two given dates.
 * @param $startDate (string, Y-m-d) Starting date for the game interval. Use $IMAGINALIEN_LAUNCH_DATE to get all days since the game started.
 * @param $endDate (string, Y-m-d) Cut-off date for day intervals. Use today's date if looking for all days since the game started until today (inclusive).
 * @return An array of dates on which the game will have been played.
 */
function retrieve_game_days($startDate, $endDate)
{
	$gameDays = array();
	$counter = 0;
	
	//Create DateTime instances to use for date arithmetic
	$dateIterator = new DateTime($startDate);
	$end = new DateTime($endDate);
	$end->add(new DateInterval('P1D'));
	
	//Check if the end date is earlier than the start date- if it is, return our empty list
	$diff = $dateIterator->diff($end);
	if ($diff->format('%R') == "-") return $gameDays;
	
	//Loop through all days from the start date and, for each weekday, add it into the list of game days
	do
	{
		$day = $dateIterator->format('D');
		if ($day != "Sun" and $day != "Sat")
		{
			$gameDays[] = $dateIterator->format('Y-m-d');
		}
		$dateIterator->add(new DateInterval('P1D'));
		
		//Use a counter to protect against infinite loops (because I don't trust my date arithmetic enough!)
		$counter++;
		if ($counter > 500) return $gameDays;
	} while ($dateIterator != $end);
	
	return $gameDays;
}

/**
 * Outputs a list of days on which the game was played between the two given dates. Uses retrieve_game_days.
 * @param $startDate (string, Y-m-d) Starting date for the game interval. Use $IMAGINALIEN_LAUNCH_DATE to get all days since the game started.
 * @param $endDate (string, Y-m-d) Cut-off date for day intervals. Use today's date if looking for all days since the game started until today (inclusive).
 * @param $targetPage The URL each date should link to, with the date's GET value
 * @return void
 */
function output_game_days($startDate, $endDate, $targetPage)
{
?>
	<ul class="game-dates">
		<?php
			foreach (retrieve_game_days($startDate, $endDate) as $date)
			{
				$dateObject = new DateTime($date);
			?>
				<li><a href="<?php echo $targetPage; ?>?date=<?php echo $date; ?>"><?php echo $dateObject->format('D j M'); ?></a></li>
			<?php
			}
		?>
	</ul>
<?php
}

/**
 * Returns a string representation of the most recent weekday. If it is currently a weekday, it is today; if today is a weekend, it will be Friday.
 */
function most_recent_weekday()
{
	$today = new DateTime(date('Y-m-d'));
	
	while ($today->format('D') == 'Sun' or $today->format('D') == 'Sat')
	{
		$today->sub(new DateInterval('P1D'));
	}
	
	return $today->format('Y-m-d');
}

/**
 * Returns the no. of submissions that are still currently undergoing moderation ('UM') and must be moderated before moderation can end.
 * @return Integer representing no. submissions undergoing moderation.
 */
function count_unmoderated_submissions()
{
	$connection = connect();
	
	$select = $connection->prepare("SELECT COUNT(*) FROM ima_submissions WHERE status = 'UM' GROUP BY status");
	$select->bind_result($count);
	$select->execute();
	$select->store_result();
	$select->fetch();
	
	$connection->close();
	
	return $count;
}

function get_recent_submitted_date()
{
	$connection = connect();
	
	$select = $connection->prepare("SELECT MAX(submit_time) FROM ima_submissions WHERE status = 'A'");
	$select->bind_result($recentDate);
	$select->execute();
	$select->store_result();
	$select->fetch();
	
	$connection->close();
	
	return $recentDate;
}
?>