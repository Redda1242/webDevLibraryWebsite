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
include('database.php');
include('Session.php');

//UnReserve is set and id is set
if( isset($_POST['UnReserve']) && isset($_POST['id'])) {
	
	$Account = ($_SESSION["account"]);
	$ISBN = $db -> real_escape_string($_POST['id']);
	$sql1 = "SELECT Reserved FROM books WHERE ISBN ='$ISBN'";
	//Run query to get book with the ISBN reserved status
	$result = $db->query($sql1);
	$row = $result->fetch_assoc();
	$Reserved = $row['Reserved'];
	
	//update reserved status to N
	//Delete reservations from reservation table
	$sql2 = "UPDATE books SET Reserved='N' WHERE ISBN='".$ISBN."'";
	$sql3 = "DELETE FROM resevations WHERE ISBN_FK='$ISBN' AND UserName_FK='$Account'";
	$db ->query($sql2);
	$db ->query($sql3);
	
	header('Location:View.php');
	
	
	return;

}

$ID = $db -> real_escape_string($_GET['id']);
$sql = "SELECT BookTitle,ISBN FROM books WHERE ISBN ='$ID'";
$result = $db->query($sql);
$row = $result->fetch_assoc();



echo "<p>Confirm: Reservation ". $row["BookTitle"] . "</p>\n";
echo ('<form method="post"><input type="hidden" ');
echo ('name="id" value="'.htmlentities($row["ISBN"]).'">'."\n");
echo ('<input type="submit" value="UnReserve" name="UnReserve">');
echo ('<a href="System.html">Cancel</a>');
echo("\n</form>\n");
?>
