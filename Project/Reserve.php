<!DOCTYPE html>
<html>
<head>
<title>Library</title>
<link rel="stylesheet" href="Assets/Style.css">
<link rel="icon" type="image/x-icon" href="Assets/Photos/favicon.ico">
</head>
<body>

<header>
<div class="NavBar">
<ul>
	<li><a href="Search.php" > Search books by Title/Author</a></li>
	<li><a href="SearchCategory.php">Search books by category</a></li>
	<li><a href="View.php">View Reserved books</a> </li>
	<a href="Index.html"><img id="icon2" src="Assets/Photos/logout.png"></a>
  
</ul>
</div>
<a href="System.html"><img id="icon" src="Assets/Photos/icon.png" alt="icon"> </a>
<h1>Library System</h1>

<br>
</header>
<br>
<footer>
  <p>Author: Raghd Al Juma 2021</p>
</footer>
</body>
</html>

<?php
//connect to databse 
//start session
include('database.php');
include('Session.php');

//if user clicked on reserve and the id of book is set
if( isset($_POST['Reserve']) && isset($_POST['id'])) {
	//assign username and ISBN of the book to a variable
	$Account = ($_SESSION["account"]);
	$ISBN = $db -> real_escape_string($_POST['id']);
	$sql1 = "SELECT Reserved FROM books WHERE ISBN ='$ISBN'";
	
	//run query to find book using ISBN
	$result = $db->query($sql1);
	$row = $result->fetch_assoc();
	
	//store if book is reserved or not in a variable 
	$Reserved = $row['Reserved'];
	$sql2 = "UPDATE books SET Reserved='Y' WHERE ISBN='".$ISBN."'";
	$sql3 = "INSERT INTO resevations (ISBN_FK, UserName_FK) VALUES ('".$ISBN."','".$Account."')";
	
	//if book is not reserved
	if ($Reserved == 'N')
	{	
		//update book to reserved status 
		$db ->query($sql2);
		
		//add reservation data to reservation table
		$db ->query($sql3);
		
		//redirect to System page
		header('Location:System.html');
	}
	else
	{
		echo "Book is already reserved";
	}

	return;
}


$ID = $db -> real_escape_string($_GET['id']);
$sql = "SELECT BookTitle,ISBN FROM books WHERE ISBN ='$ID'";
$result = $db->query($sql);
$row = $result->fetch_assoc();



echo "<p>Confirm: Reservation ". $row["BookTitle"] . "</p>\n";
echo ('<form method="post"><input type="hidden" ');
echo ('name="id" value="'.htmlentities($row["ISBN"]).'">'."\n");
echo ('<input type="submit" value="Reserve" name="Reserve">');
echo ('<a href="System.html">Cancel</a>');
echo("\n</form>\n");
?>
