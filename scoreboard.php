<?php

/**
 * Gets the scoreboard from the DB to be displayed as html in a table. 
 * @param number_of_scores, the number of scores you want returned i.e. top 10 etc. 0 means return all.
 * @param type, state whether you want the daily, weekly or monthly scores.
 * @return rows, returns all the rows selected from the table.
 */
function get_scoreboard($number_of_scores,$type)
{
	$today = new date("Y-m-d");
	$connection = new mysqli('localhost', 'imaginal_joe', 'hagm201joe', 'imaginal_dev_joe_db');
	
	if(number_of_scores > 0)//Create query with a limited number of returned rows.
	{
		$query = "SELECT `account_id` , `score` FROM `ima_submissions` WHERE STATUS = 've' and ORDER BY `score` DESC LIMIT 0 , '$number_of_scores'";
	}
	else //number_of_scores is 0 therefore return all.
	{
		$query = "SELECT `account_id` , `score` FROM `ima_submissions` WHERE STATUS = 've' ORDER BY `score` DESC";
	}	
	$result = $mysqli->query($query);
	
	
	while ($line = $result->fetch_array(MYSQLI_ASSOC))
	{ 
    	echo "<tr>"; 
        echo " <td align='left'> $line[0] </td>"; 
        echo " <td align='right'> $line[1] </td>"; 
        echo "</tr>"; 
    }

	result.close();
	connection.close();
}
?>
