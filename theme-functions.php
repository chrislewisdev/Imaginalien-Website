<?php
/**
 * theme-functions.php by Chris Lewis
 * Contains class definitions and functions for information on daily themes in the game.
 */
 
require_once("account-functions.php");
 
/** Basic class to describe a theme record from the database. */
class ThemeRecord
{
	/** Date on which this theme occurred. */
	public $date;
	/** String description of this theme. */
	public $description;
	/** Type of this theme, e.g. Daily ('D') or Catch-up ('C') */
	public $type;
	
	function __construct($_date, $_description, $_type)
	{
		$this->date = $_date;
		$this->description = $_description;
		$this->type = $_type;
	}
}

/**
 * Returns a list of any themes that were in effect on the specified date.
 * @param $date String (in Y-m-d) form specifying the date to check for.
 * @return A list of theme records.
 */
function get_themes_for_day($date)
{
	$connection = connect();
	
	$select = $connection->prepare("SELECT * FROM ima_themes WHERE date = ?");
	$select->bind_param("s", $date);
	$select->bind_result($dbDate, $dbDescription, $dbType);
	$select->execute();
	
	$themes = array();
	while ($select->fetch())
	{
		$themes[] = new ThemeRecord($dbDate, $dbDescription, $dbType);
	}
	
	$connection->close();
	
	return $themes;
}
?>