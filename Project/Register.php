
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="Assets/Style.css">
<link rel="icon" type="image/x-icon" href="Assets/Photos/favicon.ico">
</head>
<body>
<header>
<a href="Index.html"><img id="icon" src="Assets/Photos/icon.png" alt="icon"> </a>
<h1>Library System</h1>

<br>
</header>
<body>

<?php
//COnnect to database
include("database.php");

//If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Assign submitted data to variables after checking input
	$Username = $db -> real_escape_string(validate($_POST['Username']));
	$FirstName = $db -> real_escape_string(validate($_POST['FirstName']));
	$Surname = $db -> real_escape_string(validate($_POST['Surname']));
	$Password = $db -> real_escape_string(validate($_POST['Password']));
	$ConfirmPassword = $db -> real_escape_string(validate($_POST['ConfirmPassword']));
	$AddressLine1 = $db -> real_escape_string(validate($_POST['AddressLine1']));
	$AddressLine2 = $db -> real_escape_string(validate($_POST['AddressLine2']));
	$City = $db -> real_escape_string(validate($_POST['City']));
	$Telephone = $db -> real_escape_string(validate($_POST['Telephone']));
	$Mobile = $db -> real_escape_string(validate($_POST['Mobile']));
	
	//Confirm if password match using confirming function
	$result = confirmPassword($Password,$ConfirmPassword);	
	
	//check important feilds are not empty and inform user if so
	if (empty($Username))
	{
		$UsernameERR = "Username is required";
		echo "<p class=\"error\">$UsernameERR </p>";
	}
	elseif (empty($FirstName) || empty($Surname))
	{
		$nameERR = "Names are required";
		echo "<p class=\"error\">$nameERR </p>";
	}	
	elseif (empty($AddressLine1) || empty($AddressLine2))
	{
		$AddressERR = "All Address Lines are required";
		echo "<p class=\"error\">$AddressERR </p>";
	}
	elseif (empty($City))
	{
		$AddressERR = "Please fill in your city";
		echo "<p class=\"error\">$AddressERR </p>";
	}	
	elseif(empty($Mobile) || empty($Telephone))
	{
		$PhoneNumERR = "Mobile and Telephone numbers must be filled";
		echo "<p class=\"error\">$PhoneNumERR </p>";
	}	
	//check if mobile number = 10 , if not inform user
	elseif(strlen($Mobile)!= 10)
	{
		$PhoneNumERR = "Phone number must have 10 digits";
		echo "<p class=\"error\">$PhoneNumERR </p>";
	}
	elseif($result == 1)//If password is confirmed result = 1
	{
		//run sql query to check if username already exist
		$sqlcheck = "SELECT FirstName,Surname FROM users WHERE Username = '$Username'"; 
		$result = $db ->query($sqlcheck);
		
		//if username exist , inform user
		if($result -> num_rows == 1)
		{
			$UsernameTaken = "This Username is unavailable";
			echo "<p class=\"error\">$UsernameTaken</p>";
		}
		else//else insert into database new user data
		{
			$sql= "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$Username', '$Password', '$FirstName', '$Surname', '$AddressLine1', '$AddressLine2', '$City', '$Telephone', '$Mobile')";
			$db ->query($sql);
			//check if insert worked
			$result = $db ->query($sqlcheck);
			
			// if data inserted redirect user to LOGIN page
			if($result -> num_rows == 1)
			{
				header('location:Login.php');
			}
			
			
			
		}
	}
	
}


//Function to validate User input and remove special characters
	function validate($input)
	{
		
       $input = trim($input);
       $input = stripslashes($input);
       $input = htmlspecialchars($input);

       return $input;

    }

//Function to confirm the two passwords entered by user
function confirmPassword($password,$confirm)
{
	//check if feilds are empty first
	if(empty($password))
	{
		$PasswordERR = "Password is required";
		echo "<p class=\"error\">$PasswordERR</p>";
		return 0;
	}
	elseif (empty($confirm))
	{
		$PasswordConfirmERR = "Please confirm Password";
		echo "<p class=\"error\">$PasswordConfirmERR</p>";
		return 0;
	}
	elseif ($password != $confirm)//check if the two passwords match
	{
		$UnmatchedPassword = "Password do not match";
		echo "<p class=\"error\">$UnmatchedPassword</p>";
		return 0;
	}	
	elseif(strlen($password) != 6)//check if password is 6 characters
	{
		$PasswordLengthERR = "Password must have 6 characters";
		echo "<p class=\"error\">$PasswordLengthERR </p>";
		return 0;
	}
	else//if all is correctly enetered return 1
	{
		return 1;
	}
}
?>
<form method="post" id="Register">
<h3>Register</h3>
<p>Username:</p> 
<p><input type="text"  name="Username"></p>
<p>First Name: </p>
<p><input type="text"  name="FirstName"></p>
<p>surname: </p>
<p><input type="text"  name="Surname"></p>
<p>Password:  </p>
<p><input type="password"  name="Password"></p>
<p>Confirm Password:</p>  
<p><input type="password"  name="ConfirmPassword"></p>
<p>Address Line 1:</p>
<p><input type="text" name="AddressLine1"></p>
<p>Address Line 2:</p>
<p><input type="text" name="AddressLine2"></p>  
<p>City:</p>
<p><input type="text"  name="City"></p>
<p>Telephone:</p>
<p><input type="tel" name="Telephone"></p> 
<p>Mobile:</p>
<p><input type="tel" name="Mobile"></p> 
<p><button type="submit" value="Register"> Register </button>
</form>
<footer>
  <p>Author: Raghd Al Juma 2021</p>
</footer>
</body>
</html>

