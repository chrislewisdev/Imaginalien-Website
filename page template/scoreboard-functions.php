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
		$connection = new mysqli('localhost', 'imaginal_devs', 'hagm201', 'imaginal_data');		
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
			          WHERE STATUS =  'A' and SUBMIT_TIME = '$today' and ima_submissions.account_id = ima_accounts.id
					  GROUP BY display_name
                      ORDER BY  SUM(score) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all.
		{
			$query = "SELECT `display_name` , SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
					  WHERE STATUS =  'A' and SUBMIT_TIME = '$today' and ima_submissions.account_id = ima_accounts.id
					  GROUP BY display_name
					  ORDER BY SUM(score) DESC";
		}	
		echo "<tr><th>Account</th><th>Score</th></tr>";
		if($result = $connection->query($query))
		{
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
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
		$connection = new mysqli('localhost', 'imaginal_devs', 'hagm201', 'imaginal_data');		
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
			          WHERE STATUS =  'A'  and date_format(SUBMIT_TIME, '%U') = '$week' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all
		{
			$query = "SELECT  `display_name` ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
					  WHERE STATUS =  'A'  and date_format(SUBMIT_TIME, '%U') = '$week' and ima_submissions.account_id = ima_accounts.id
					  GROUP BY display_name					  
					  ORDER BY SUM(score) DESC";
		}			
		echo "<tr><th>Account</th><th>Score</th></tr>";
		if($result = $connection->query($query))
		{
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
		}
		$connection->close();
	}
	/**
	 * Gets the scoreboard from the DB to be displayed as html in a table. 
	 * @param number_of_scores, the number of scores you want returned i.e. top 10 etc. 0 means return all.
	 * @return rows, returns all the rows selected from the table.
	 */
	function get_scoreboard_overall($number_of_scores)
	{
		$connection = new mysqli('localhost', 'imaginal_devs', 'hagm201', 'imaginal_data');
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
			          WHERE STATUS =  'A' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all.
		{
			$query = "SELECT  display_name ,  SUM(score)
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  'A' and ima_submissions.account_id = ima_accounts.id
			          GROUP BY display_name
                      ORDER BY SUM(score) DESC";		
		}	
		echo "<tr><th>Account</th><th>Score</th></tr>";
		if($result = $connection->query($query))
		{
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
	        	echo "</tr>"; 
	    	}
			$result->close();
		}
		$connection->close();
	}
?>
