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
	/** Status of this submission- 'P' means Pending Approval, 'A' means Approved, 'F' means Failed Approval. */
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
 * Gets all photo submissions of the specified status and returns them.
 * @param $status The type of submission status to retrieve submissions of.
 * @return An array of SubmissionRecord objects.
 */
function retrieve_submissions($status = 'P')
{
	$connection = connect();
	
	//Retrieve all submissions from the database
	$select = $connection->prepare("SELECT * FROM ima_submissions WHERE status = ?");
	$select->bind_param("s", $status);
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
 * Convenience function to approve a submission.
 * @param $id ID of the submission to approve.
 * @param $score Final score to set for the submission.
 * @param $caption Final caption to set for the submission.
 * @return true if successful, false otherwise.
 */
function approve_submission($id, $score, $caption)
{
	//return (update_submission_approval($id, 'A') and update_submission_score($id, $score));
	
	$connection = connect();
	$status = 'A';
	
	$update = $connection->prepare("UPDATE ima_submissions SET status = ?, score = ?, caption = ? WHERE id = ?");
	$update->bind_param("sisi", $status, $score, $caption, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
		$result = false;
	else
		$result = true;
	
	$connection->close();
	
	return $result;
}

/**
 * Convenience function to reject a submission.
 * @param $id ID of the submission to reject.
 * @return true if successful, false otherwise.
 */
function reject_submission($id)
{
	$connection = connect();
	$status = 'F';
	
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
?>