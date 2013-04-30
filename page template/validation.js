/**
 * Function to validate the registration form for sign-up. 
 */
function validateRegistration()
{
	var email = document.getElementById("register-email").value;
	var name = document.getElementById("register-name").value;
	var password = document.getElementById("register-password").value;
	var confirmPassword = document.getElementById("register-confirm-password").value;
	
	var errorString = "";
	
	if (email.trim() == "")
	{
		errorString += "Registration email can not be blank\n";
	}
	
	if (name.trim() == "")
	{
		errorString += "Registration name can not be blank\n";
	}
	
	if (password.trim() == "")
	{
		errorString += "Registration password can not be blank\n";
	}
	if (confirmPassword.trim() == "")
	{
		errorString += "You must enter your password twice to confirm.";
	}
	else if (confirmPassword != password)
	{
		errorString += "Password does not match confirmed password";
	}
	
	if (errorString != "")
	{
		alert(errorString);
		return false;
	}
	
	return true;
}

/**
 * Function to validate the login form. 
 */
function validateLogin()
{
	var email = document.getElementById("login-email").value;
	var password = document.getElementById("login-password").value;
	
	var errorString = "";
	
	if (email.trim() == "")
	{
		errorString += "Login email can not be blank\n";
	}
	
	if (password.trim() == "")
	{
		errorString += "Login password can not be blank\n";
	}
	
	if (errorString != "")
	{
		alert(errorString);
		return false;
	}
	
	return true;
}