<?php
	session_start();

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
			$query = "SELECT  `display_name` ,  `score` 
					  FROM  `ima_submissions` JOIN ima_accounts
			          WHERE STATUS =  'A' and SUBMIT_TIME = '$today' and ima_submissions.account_id = ima_accounts.id
                      ORDER BY  `score` DESC 
                      LIMIT 0 , $number_of_scores";
		}
		else //number_of_scores is 0 therefore return all.
		{
			$query = "SELECT `ima_accounts.display_name` , `ima_submissions.score`
			FROM  `ima_submissions` JOIN ima_accounts
			WHERE STATUS = 'A' and ima_submissions.account_id = ima_accounts.id'
			ORDER BY `score` DESC";
		}	
		
		if($result = $connection->query($query))
		{
			echo "<tr><th>Account</th><th>Score</th></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
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
		# and date(SUBMIT_WEEK) = '$week'
		else //number_of_scores is 0 therefore return all
		{
			$query = "SELECT  `display_name` ,  `score`
			FROM  `ima_submissions` JOIN ima_accounts
			WHERE STATUS = 'A' and date(SUBMIT_WEEK) = '$week''
			ORDER BY SUM(score) DESC";
		}	
		
		if($result = $connection->query($query))
		{
			
			echo "<tr><th>Account</th><th>Score</th></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
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
			$query = "SELECT  `display_name` ,  `score`
			FROM  `ima_submissions` JOIN ima_accounts
			WHERE STATUS = 'A' and ima_submissions.account_id = ima_accounts.id'
			ORDER BY `score` DESC";
			
		}	
		
		if($result = $connection->query($query))
		{
			
			echo "<tr><th>Account</th><th>Score</th></tr>";
			while ($line = $result->fetch_row())
			{
	    		echo "<tr>"; 
	       	 	echo " <td> $line[0] </td>"; 
	        	echo " <td> $line[1] </td>"; 
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
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=320"/>
		<title>Imaginalien</title>
		<link rel="stylesheet" media="only screen and (max-width: 400px)" href="mobile-device.css"/>
		<link rel="stylesheet" media="only screen and (min-width: 401px)" href="desktop.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<script type="text/javascript" src="validation.js"></script>
	</head>
	<body>
	<div id="container">
	<div id="wrapper">
		<div id="header">
			<?php
				ob_start();
				include 'header.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
		<div id="nav">
			<?php
				ob_start();
				include 'navigation.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
	</div>
		<div id="login">
			<hr/>
			<br/>
			<?php
				ob_start();
				include 'login.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
			<br/>
		</div>
		<div id="content">
			<h2 class="indented-heading">Daily Scores</h2>
			<table>
				<?php get_scoreboard_daily(10,null); ?>
			</table>
			<br/>
			<h2 class="indented-heading">Weekly Scores</h2>
			<table>
				<?php get_scoreboard_weekly(10,null); ?>
			</table>
			<br/>
			<h2 class="indented-heading">Overall Scores</h2>
			<table>
				<?php get_scoreboard_montly(10); ?>
			</table>
		</div>
		<div id="footer">
			<?php
				ob_start();
				include 'footer.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
	</div>
	</body>
</html>