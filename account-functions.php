<?php
/**
 * account-functions.php by Chris Lewis
 * Contains functions related to account creation, login, and anything else necessary.
 */

/** Simple exception class for database connection errors. */
class ConnectionException extends Exception {}
/** Simple exception class for exceptions thrown by account functions. */
class AccountException extends Exception {}

/** Simple data storage for Accounts as they appear ON THE DATABASE. It is used for holding database values, not values for use in real-time. */
class AccountRecord
{
	/** ID (int) of the account on the database- not encrypted. */
	public $id;
	/** Email (string) of the account. Unencrypted */
	public $email;
	/** Display name (string) of the account- not encrypted. */
	public $name;
	/** Total score of the account- not encrypted. */
	public $score;
	/** Salt for safe password storage. Cryptographically secure random number. See http://crackstation.net/hashing-security.htm for more details.*/
	public $salt;
	/** Hashed Password (string) of the account. Never decrypted, but checked against the result of crypt(hash+possiblePassword).*/
	public $hashed_password;
	
	function __construct($_id, $_email, $_name, $_hashed_password, $_score, $_salt)
	{
		$this->id = $_id;
		$this->email = $_email;
		$this->name = $_name;
		$this->score = $_score;
		$this->hashed_password = $_hashed_password;
		$this->salt = $_salt;
		
	}
}

/**
 * Sets up a connection to the Imaginalien database, using dev credentials.
 * @return A MySQLi connection object.
 * @throws A ConnectionException on error.
 */
function connect()
{
	$connection = new mysqli('localhost', 'imaginal_devs', 'hagm201', 'imaginal_data');
	if ($connection->errno != 0)
	{
		throw new ConnectionException($connection->error);
	}
	return $connection;
}

/**
 * Creates a new account entry in the ima_accounts table.
 * @param $email The email to store for the account (will be encrypted).
 * @param $displayName The display name to store for the account.
 * @param $password The password to use for the account (will be encrypted).
 * @return true on success.
 * @throws AccountException on error, with an appropriate error message.
 */
function create_account($email, $displayName, $password)
{
	//Connect to the Imaginalien database
	$connection = connect();
	
	//'Salt' created using secure pseudo-random number generator.	
	//We add this to thwart pre-calculation of hashed common passwords.
	$salt = openssl_random_pseudo_bytes(4, $cstrong);	
	$encodedSalt = base64_encode($salt);

	//We only store the 'hash', not the supplied password.
	//From that point on, we check against the hashed result of the salt+possible password.
	$hashed_password = crypt($password, $encodedSalt);

	//If no existing account was found, go ahead and insert the new record.
	$insert = $connection->prepare("INSERT INTO ima_accounts(email, display_name, salt, password) VALUES(?, ?, ?, ?)");
	$insert->bind_param("ssss", $email, $displayName, $encodedSalt, $hashed_password);
	if (!$insert->execute())
	{
		throw new AccountException($insert->error);
	}
	$insert->close();
	
	//Close the connection
	$connection->close();
	
	return true;
}

/** 
 * Retrieves full account info, identified by the specified e-mail or ID.
 * @param $email Email of the account to retrieve.
 * @param $id The ID of the account to retrieve. If this is specified, email will be ignored.
 * @return An Account object holding the DB info for the account.
 * @throws AccountException when the account can't be found.
 */
function retrieve_account($email, $id = -1)
{
	$connection = connect();
	
	//Retrieve the account details from the database (using our specified method of retrieval)
	if ($id == -1)
	{
		$select = $connection->prepare("SELECT * FROM ima_accounts WHERE email = ?");
		$select->bind_param("s", $email);
	}
	else 
	{
		$select = $connection->prepare("SELECT * FROM ima_accounts WHERE id = ?");
		$select->bind_param("s", $id);
	}
	$select->bind_result($dbID, $dbEmail, $dbName, $dbPassword, $dbScore, $dbSalt);
	$select->execute();
	$select->store_result();
	//Check that we actually got a match
	if ($select->num_rows <= 0)
	{
		throw new AccountException("No accounts for the specified email were found.");
	}
	$select->fetch();
		
	$account = new AccountRecord($dbID, $dbEmail, $dbName, $dbPassword, $dbScore, $dbSalt);
	$select->close();
	$connection->close();
	
	return $account;
}

/**
 * Sets up and authenticates a login session for a user with the provided email/password.
 * @param $email Email of the account to login for.
 * @param $password Password to authenticate with.
 * @return true on success, false if the password was incorrect.
 * @throws AccountException on unexpected error, with appropriate error message.
 */
function login($email, $password)
{
	$account = retrieve_account($email);
	
	//Authenticate against the password

	$hashed_possible_password = crypt($password, $account->salt);
	
	if ($hashed_possible_password == $account->hashed_password)
	{
		//Set up the session data
		$result = true;
		$_SESSION['imaginal_user_logged_in'] = true;
		$_SESSION['imaginal_user_id'] = $account->id;
		$_SESSION['imaginal_user_name'] = $account->name;
	}
	else
	{
		$result = false;
	}
	
	return $result;
}

/**
 * Checks to see if any user is currently logged in.
 * @return true if someone's logged in, false if not.
 */
function is_user_logged_in()
{
	if (isset($_SESSION['imaginal_user_logged_in']))
	{
		return $_SESSION['imaginal_user_logged_in'];
	}
	else
	{
		return false;
	}
}

/**
 * Convenience function to return the database ID of the current user.
 * @return The ID of the current user, as an int.
 * @throws AccountException if no-one is logged in.
 */
function get_user_id()
{
	if (!is_user_logged_in()) throw new AccountException("Can't retrieve ID when no-one is logged in.");
	else
	{
		return $_SESSION['imaginal_user_id'];
	}
}

/**
 * Convenience function to return the name of the currently logged in user, or if an ID is specified, the user with that ID.
 * @param $id Optional ID to retrieve the name of a specific user.
 * @return The name of the current user as a string.
 * @throws AccountException if no-one is logged in.
 */
function get_user_name($id = -1)
{
	//If no ID was specified, get the ID of the current user
	if ($id == -1)
	{
		if (!is_user_logged_in()) throw new AccountException("Can't retrieve display name when no-one is logged in.");
		else 
		{
			return $_SESSION['imaginal_user_name'];
		}
	}
	else
	{
		$account = retrieve_account('not needed', $id);
		return $account->name;
	}
}

/**
 * Retrieves and decrypts the email of the current user, then returns it. Since email is sensitive information, don't store it anywhere unsafe.
 * @return The email of the current user.
 * @throws AccountException if no-one is logged in.
 */
function get_user_email($id = -1)
{
	if ($id == -1)
	{
		if (!is_user_logged_in()) throw new AccountException("Can't retrieve user email when no-one is logged in.");
		else 
		{
			$id = get_user_id();
		}
	}
	
	$account = retrieve_account('not needed', $id);
	
	$decryptedEmail = $account->email;
	
	return $decryptedEmail;
}

/**
 * Retrieves the score of the current user, or the user with the optional ID.
 * @param $id (Optional) ID of the user to retrieve the score of.
 * @return The integer email of the current user.
 */
function get_user_score($id = -1)
{
	if ($id == -1)
	{
		if (!is_user_logged_in()) throw new AccountException("Can't retrieve user score when no-one is logged in.");
		else 
		{
			$id = get_user_id();
		}
	}
	
	$account = retrieve_account('not needed', $id);
	
	return $account->score;
}

/**
 * Ends the current login session for a user. If no-one is logged in, does nothing.
 * @return void
 */
function logout()
{
	if (isset($_SESSION['imaginal_user_logged_in']))
	{
		if ($_SESSION['imaginal_user_logged_in'])
		{
			$_SESSION['imaginal_user_logged_in'] = false;
			//Set ID and name to erroneous values
			$_SESSION['imaginal_user_id'] = -1;
			$_SESSION['imaginal_user_name'] = '';
		}
	}
}

/**
 * Applies a once-off adjustment to the score of the specified player. The adjustment may be positive or negative, simply pass negative values to decrease player score.
 * @param $id The ID of the user to adjust the score of.
 * @param $adjustment The score adjustment to apply.
 * @return true if the operation was applied successfully, false otherwise.
 */
function adjust_user_score($id, $adjustment)
{
	$connection = connect();
	
	$result = true;
	
	$update = $connection->prepare("UPDATE ima_accounts SET total_score = total_score + ? WHERE id = ?");
	$update->bind_param("is", $adjustment, $id);
	$update->execute();
	
	if ($update->affected_rows == 0)
	{
		$result = false;
	}
	
	$connection->close();
	
	return $result;
}

/**
 * Applies a once-off adjustment to the score of the specified player. The adjustment may be positive or negative, simply pass negative values to decrease player score.
 * @param $name The name of the user to adjust the score of.
 * @param $adjustment The score adjustment to apply.
 * @return true if the operation was applied successfully, false otherwise.
 */
function adjust_user_score_by_name($name, $adjustment)
{
	$connection = connect();
	
	$result = true;
	
	$update = $connection->prepare("UPDATE ima_accounts SET total_score = total_score + ? WHERE display_name = ?");
	$update->bind_param("is", $adjustment, $name);
	$update->execute();
	
	if ($update->affected_rows == 0)
	{
		$result = false;
	}
	
	$connection->close();
	
	return $result;
}
?>