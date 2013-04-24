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
	/** Binary image data for the photo- need to look into how BLOB data can be used for image display. */
	public $image_data;
	/** Score for this submission. */
	public $score;
	/** Caption (word) for this submission. */
	public $caption;
	/** Status of this submission- 'P' means Pending Approval, 'A' means Approved, 'R' means Rejected. */
	public $status;
	
	function __construct($_id, $_accountID, $_submit_time, $_image_data, $_score, $_caption, $_status)
	{
		$this->id = $_id;
		$this->accountID = $_accountID;
		$this->image_data = $_image_data;
		$this->score = $_score;
		$this->caption = $_caption;
		$this->status = $_status;
	}
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
	
	return $result;
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
	$select->bind_result($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus);
	$select->execute();
	$select->store_result();
	
	//Loop through all submissions and build up our list
	$submissions = array();
	while ($select->fetch())
	{
		$submissions[] = new SubmissionRecord($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus);
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
	$select->bind_result($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus);
	$select->execute();
	$select->store_result();
	
	//Check that it actually exists
	if ($select->num_rows <= 0)
	{
		return null;
	}
	
	//Create the submission record object
	$select->fetch();
	$submission = new SubmissionRecord($dbID, $dbAccountID, $dbSubmitTime, $dbImageData, $dbScore, $dbCaption, $dbStatus);
	
	$connection->close();
	
	return $submission;
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
 * Stages a submission for rejection- moves it from Underdoing Moderation to Rejected pending Application
 * @param $id ID of the submission to reject.
 * @return true if successful, false otherwise.
 */
function stage_submission_rejection($id)
{
	$connection = connect();
	$status = 'UR';
	
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

$IMAGINALIEN_LAUNCH_DATE = '2013-05-06';
/**
 * Returns a list of days on which the game was played between the two given dates.
 * @param $startDate Starting date for the game interval. Use $IMAGINALIEN_LAUNCH_DATE to get all days since the game started.
 * @param $endDate Cut-off date for day intervals. Use today's date if looking for all days since the game started until today (inclusive).
 * @return An array of dates on which the game will have been played.
 */
function retrieve_game_days($startDate, $endDate)
{
	$gameDays = array();
	$counter = 0;
	
	$dateIterator = new DateTime($startDate);
	$end = new DateTime($endDate);
	$end->add(new DateInterval('P1D'));
	
	$diff = $dateIterator->diff($end);
	if ($diff->format('%R') == "-") return $gameDays;
	
	do
	{
		$day = $dateIterator->format('D');
		if ($day != "Sun" and $day != "Sat")
		{
			$gameDays[] = $dateIterator->format('Y-m-d');
		}
		$dateIterator->add(new DateInterval('P1D'));
		$counter++;
		if ($counter > 200) return $gameDays;
	} while ($dateIterator != $end);
	
	return $gameDays;
}
?>