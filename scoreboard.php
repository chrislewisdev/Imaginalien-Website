<!DOCTYPE html>
<html>
	
<head>
<?php
	/**
	 * Gets the scoreboard from the DB to be displayed as html in a table. 
	 * @param number_of_scores, the number of scores you want returned i.e. top 10 etc. 0 means return all.
	 * @param today, the date that we want the results for.
	 * @return rows, returns all the rows selected from the table.
	 */
	function get_scoreboard_daily($number_of_scores,$today)
	{
		//If the date is not specified default to today.
		if($today == null)
		{
			$today = date("Y-m-d");
		}
		
		$connection = new mysqli('localhost', 'imaginal_joe', 'hagm201joe', 'imaginal_dev_joe_db');
		
		/* check connection */
		if ($connection->connect_errno)
		{
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
		
		//Query to be sent to the database.
		$query = "";
		
		if($number_of_scores > 0)//Create query with a limited number of returned rows.
		{	
			$query = "SELECT  `display_name` ,  SUM('score`)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  've' and SUBMIT_DATE = '$today' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY  SUM(`score`) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all.
		{
			$query = "SELECT `ima_accounts.display_name` , `ima_submissions.score`
					  FROM  `ima_submissions` JOIN ima_accounts
					  WHERE STATUS = 've' and SUBMIT_DATE = '$today' and ima_submissions.account_id = ima_accounts.id
					  GROUP BY display_name
            		  ORDER BY SUM(`score`) DESC";
		}		
		
		echo "Daily Scores";
		if($result = $connection->query($query))
		{
			echo "<tr><td>Account</td><td>Score</td></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td align='left'> $line[0] </td>"; 
	        	echo " <td align='right'> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
		}
		else
		{
			printf("No Result"); 
		}
		$connection->close();
	}

	/**
	 * Gets the scoreboard from the DB to be displayed as html in a table. 
	 * @param number_of_scores, the number of scores you want returned i.e. top 10 etc. 0 means return all.
	 * @param week, the week number that you want the results for.
	 * @return rows, returns all the rows selected from the table.
	 */
	function get_scoreboard_weekly($number_of_scores,$week)
	{
		//If the date is not specified default to today.
		if($week == null)
		{
			$week = date("W")-1;
		}		
		
		$connection = new mysqli('localhost', 'imaginal_joe', 'hagm201joe', 'imaginal_dev_joe_db');
		
		/* check connection */
		if ($connection->connect_errno)
		{
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
		
		//Query to be sent to the database.
		$query = "";
		
		if($number_of_scores > 0)//Create query with a limited number of returned rows.
		{	
			$query = "SELECT  `display_name` ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  've'  and date_format(SUBMIT_DATE, '%U') = '$week' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		# and date(SUBMIT_WEEK) = '$week'
		else //number_of_scores is 0 therefore return all
		{
			$query = "SELECT  `display_name` ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  've'  and date_format(SUBMIT_DATE, '%U') = '$week' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC";
		}	
		
		echo "Weekly Scores";
		if($result = $connection->query($query))
		{
			
			echo "<tr><td>Account</td><td>Score</td></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td align='left'> $line[0] </td>"; 
	        	echo " <td align='right'> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
		}
		else
		{
			printf("No Result"); 
		}
		$connection->close();
	}

	/**
	 * Gets the scoreboard from the DB to be displayed as html in a table. 
	 * @param number_of_scores, the number of scores you want returned i.e. top 10 etc. 0 means return all.
	 * @param today, the date that we want the results for.
	 * @return rows, returns all the rows selected from the table.
	 */
	function get_scoreboard_montly($number_of_scores)
	{
		$connection = new mysqli('localhost', 'imaginal_joe', 'hagm201joe', 'imaginal_dev_joe_db');
		
		/* check connection */
		if ($connection->connect_errno)
		{
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
		
		//Query to be sent to the database.
		$query = "";
		
		if($number_of_scores > 0)//Create query with a limited number of returned rows.
		{	
			$query = "SELECT  display_name ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  've' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all.
		{
			$query = "SELECT  display_name ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  've' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC ";
			
		}	
		
		echo "Overall Scores";
		if($result = $connection->query($query))
		{
			
			echo "<tr><td>Account</td><td>Score</td></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td align='left'> $line[0] </td>"; 
	        	echo " <td align='right'> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
		}
		else
		{
			printf("No Result"); 
		}
		$connection->close();
	}
?>
</head>
	<body>
		<table border="1">
			<?php get_scoreboard_daily(10,null); ?>
		</table>
		<br/>
		<table border="1">
			<?php get_scoreboard_weekly(10,null); ?>
		</table>
		<br/>
		<table border="1">
			<?php get_scoreboard_montly(10); ?>
		</table>
	</body>	
</html>
