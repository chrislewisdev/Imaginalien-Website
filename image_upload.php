<?php
/**
 * image_upload.php by Kit Mackenzie
 * Contains functions related to image uploading and daily submission limit.
 */

	session_start();
 	require_once("account-functions.php");
	
/**
 * Attempts to upload an image/caption combo to the Imaginalien server.
 * Images will be stored on the file system, with a URL link to their location on the server.
 * Upon success or failure, players will be redirected to the appropriate webpage.
 */
function attemptSubmission()
{
	$SUBMISSIONS_PER_DAY = 3;
	
	//If today is Saturday or Sunday
	if(date("N", $timestamp) == 6 || date("N", $timestamp) == 7)
	{
		//Wrong day of the week! Redirect
		header("Location: http://www.imaginalien.com/anotherDay.php"); /* Redirect browser */
		exit();
	}
	if(! is_user_logged_in())
	{
		//redirect to login page
		header("Location: http://www.imaginalien.com/login.php"); /* Redirect browser */
		exit();
	}
	else
	{
		$id=get_user_id();
		if(checkSubmissionCount($id) > $SUBMISSIONS_PER_DAY)
		{
			error_log(checkSubmissionCount($id));
			//Redirect to 'Sorry, all submissions used up today!'
			header("Location: http://www.imaginalien.com/allUsedUp.php"); /* Redirect browser */
			exit();
		}
		else
		{
			//Store the file
			$url = storeInServer();
			
			//Store URL and similar in database
			storeInDatabase($url);
			
			//Send response: 'Thanks! You have X more photos remaining today!'
			//header("Location: http://www.imaginalien.com/anotherGo.php"); /* Redirect browser */
			//exit();
		}
	}
}

/**
 * Stores the current photo/caption submission in the ima_submissions database.
 * Image will have already been saved on the file system.
 * @param $url The URL of the image stored in the file system on this server.
 * @throws AccountException on error, with an appropriate error message.
 */
function storeInDatabase($url)
{
	$connection = connect();
	$insert = $connection->prepare("INSERT INTO ima_submissions(account_id, submit_time, image_data, score, caption, status) 
		VALUES(?, ?, ?, ?, ?, ?)");
		
	$account_id = get_user_id(); 
	$date = date('Y-m-d');
	$defaultScore = 0;
	$caption = $_POST['title'];
	$status = 'P';
	
	$insert->bind_param("ssssss", $account_id, $date, $url, $defaultScore, $caption, $status);
	if (!$insert->execute())
	{
		throw new AccountException($insert->error);
	}
	$insert->close();
}
/**
 * Returns the number of times a given user has made a submission within the current day.
 * @param $id the id of the player whose submissions are under investigation.
 * @return The number of submissions the given player has made today already.
 * @throws ConnectionException on error, with an appropriate error message.
 */
function checkSubmissionCount($id)
{
	$connection = connect();
	$date = date('Y-m-d');
	
	if (!$connection)
	{
		echo "Connection error.";
	}
	
	$stmt = $connection->prepare("SELECT caption FROM ima_submissions WHERE submit_time=? AND account_id=?"); 
	if (!$stmt)
	{
		throw new ConnectionException($stmt->error);
	}
	$stmt->bind_param("ss", $date, $id);

	$stmt->execute();
	$stmt->store_result();
	
	$submissionCount = $stmt->num_rows;
	
	return $submissionCount;
}

/**
 * Stores the given image in the file system of this server, and returns a URL to the location of the file.
 * @return A URL which shows the location of the newly-stored file.
 */
function storeInServer()
{
	$date = date('Y_m_d_H_i_s');
	$url = "upload/" . (string)$date . $_FILES["file"]["name"];
	
	if (file_exists($url))
	{
		//Should not occur now the server appends the date to each file.
	}
	else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], $url);
	}
	return $url;
}
	//attemptSubmission();
?>