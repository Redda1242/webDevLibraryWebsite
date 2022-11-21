
<!DOCTYPE html>
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
<body id="LoginPage">
<form method="post" action="Login.php" name="signin-form" class="Login">
  <h1>Login</h1>
  <div class="form-element">
    <label>Username</label>
    <input class="LoginData" type="text" name="Username"/>
  </div>
  <br>
  <div class="form-element">
    <label>Password</label>
    <input class="LoginData" type="password" name="Password"/>
  </div>
  <p>Don't have an account? <a href="Register.php"> Register</a></p>
  <button type="submit" name="login" value="login">Log In</button>
</form>
<footer>
  <p>Author: Raghd Al Juma 2021</p>
</footer>
</body>
</html>

<?php
	//Start session and unset account in case it was set already
	session_start();   
	unset($_SESSION["account"]);
	
	//Connect to database
    include('database.php');
	
	//If user pressed Login
    if (isset($_POST['login'])) 
	{
		//Assign Username and password entered by user to a variable
		$Username = $db -> real_escape_string(validate($_POST['Username']));
		$Password = $db -> real_escape_string(validate($_POST['Password']));
		
		//Check if User didn't enter anything
		//If usernam and password is empty, Inform user that feild can't be empty
        if(empty($_POST['Username']))
		{
			$UsernameEmpty = "Username can not be empty";
			echo "<p class=\"error\">$UsernameEmpty</p>";
		}
		elseif(empty($_POST['Password']))
		{
			$PasswordEmpty = "Password can not be empty";
			echo "<p class=\"error\">$PasswordEmpty</p>";
		}
		else
		{
			//If all feilds were feild in the form
			//Check using sql statment if Username and password exist in database
			$sql = "SELECT * FROM users WHERE Username='$Username' AND Password='$Password'";
			$result = $db ->query($sql);
			
			//if result exist, Redirect User to the system page 
			if($result -> num_rows == 1)
			{
				//Assign account(Username) in the session, to know who the user is across pages
				$_SESSION["account"] = $_POST["Username"];
				header('location:System.html');
			
			}
			else
			{
				//	If username and password does not exist in the databse, inform user
				$Invalid = "Sorry, Username or password is wrong";
				echo "<p class=\"error\">$Invalid</p>";
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
	
	
	
?>