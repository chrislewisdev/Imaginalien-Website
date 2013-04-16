<?php
/**
 * account-functions.php by Chris Lewis
 * Contains functions related to account creation, login, and anything else necessary.
 */

/** Simple exception class for database connection errors. */
class ConnectionException extends Exception {}
/** Simple exception class for exceptions thrown by account functions. */
class AccountException extends Exception {}

/**
 * Sets up a connection to the Imaginalien database.
 * @return A MySQLi connection object.
 * @throws A ConnectionException on error.
 */
function connect()
{
	$connection = new mysqli('localhost', 'imaginal_chris', 'hagm201chris', 'imaginal_dev_chris_db');
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
	
	//If no existing account was found, go ahead and insert the new record.
	$insert = $connection->prepare("INSERT INTO ima_accounts(email, display_name, password) VALUES(?, ?, ?)");
	$insert->bind_param("sss", $email, $displayName, $password);
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
 * Sets up and authenticates a login session for a user with the provided email/password.
 * @param $email Email of the account to login for.
 * @param $password Password to authenticate with.
 * @return true on success.
 * @throws AccountException on error, with apprporiate error message.
 */
function login($email, $password)
{
	$connection = connect();
	
	//Retrieve the account details from the database
	$select = $connection->prepare("SELECT * FROM ima_accounts WHERE email = ?");
	$select->bind_param("s", $email);
	$select->execute();
	
	//Authenticate against the password
	
	//Set up the session data
}
?>