<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Work In Progress</title>
		<script src="jquery-1.9.1.js" type="text/javascript"></script> 
	</head>
	<body>
		<p>
		<?php
			require_once("account-functions.php");
			//require_once("upload-image.php");
			
			try
			{
				/*if (!login("cl_myles@hotmail.com", "abc123"))
				{
					echo "Login failed.";
				}*/
				
				//create_account("kit@adhatchers.com.au", "Micador", "jjj");
				//echo "new!";
				logout();
				login("kit@adhatchers.com.au", "jjj");
				
				echo "UserID: " . get_user_id() . "<br />";
				echo "Email: " . get_user_email() . "<br />";
				echo "Name: " . get_user_name() . "<br />";
				
				//uploadImage("okokokok", "Something");
			}
			catch (AccountException $e)
			{
				echo $e->getMessage();
			}
		?>
		
		</p>
		
		<form action="image_upload.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file" size="20" /><br />
		<input type="text" name="title" value="title"; />
		<input type="submit" name="submit" value="Submit" />
		</form>

	</body>
</html>