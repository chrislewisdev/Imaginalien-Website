<!DOCTYPE html>
<html>
	<head>
		<title>Work In Progress</title>
	</head>
	<body>
		<p>
		<?php
			require_once("account-functions.php");
			
			try
			{
				create_account('cl_myles@hotmail.com', 'Chris Lewis', 'abc123');
				echo "All went well.";
			}
			catch (AccountException $e)
			{
				echo $e->getMessage();
			}
		?>
		</p>
	</body>
</html>