<?php session_start(); ?>
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
				//create_account('cl_byles@hotmail.com', 'Chris Blewis', 'abc123');
				
				if (!login("cl_byles@hotmail.com", "abc123"))
				{
					echo "Login failed.";
				}
				
				echo "ID: ". get_user_id() . "<br />";
				echo "Email: " . get_user_email() . "<br />";
				echo "Name: " . get_user_name() . "<br />";
			}
			catch (AccountException $e)
			{
				echo $e->getMessage();
			}
		?>
		</p>
	</body>
</html>