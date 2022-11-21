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
<form method="post" action="" name="reserved" class="Search">
	<h3>Press button to see reserved books</h3>
	<button type="submit" name="View" value="View">View Reserved books</button>
</form>
<?php

//Include the database connection 
//and session page to start session
include('database.php');
include('Session.php');

//If form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
			//get account name from the session
			$Account = $_SESSION["account"];
			
			//use sql to find the books reserved using two INNER JOIN
			$sql = "SELECT * FROM books INNER JOIN resevations ON books.ISBN = resevations.ISBN_FK INNER JOIN users ON users.Username = resevations.UserName_FK WHERE Username = '".$Account."'";
			$result = $db ->query($sql);
			$num_of_results = $result -> num_rows;
			echo "$num_of_results Found";
			
			//If there are results
			if($num_of_results > 0)
			{
				//Print table with data of the book reserved
				echo "<table border ='1'>";
				echo "<tr><th>ISBN</th>";
				echo "<th>BookTitle</th>";
				echo "<th>Author</th>";
				echo "<th>Edition</th>";
				echo "<th>Year</th>";
				echo "<th>Category</th>";
				
				while($row = $result -> fetch_assoc())
				{
					
					echo "<tr><td>";
					echo (htmlentities($row["ISBN"]));
					echo "</td><td>";
					echo (htmlentities($row["BookTitle"]));
					echo "</td><td>";
					echo (htmlentities($row["Author"]));
					echo "</td><td>";
					echo (htmlentities($row["Edition"]));
					echo "</td><td>";
					echo (htmlentities($row["Year"]));
					echo "</td><td>";
					echo (htmlentities($row["Category"]));
					echo "</td><td>";
					//A link in the table to UnReserve.php to remove reservations
					echo('<a href="UnReserve.php?id='.htmlentities($row["ISBN"]).'">Remove reservation</a>  ');
					echo ("</td></tr>");

					
					
				}
			}
	}


?>
<br>
</body>
</html>



