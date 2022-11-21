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


<?php
//connect to database and start session
include('database.php');
include('Session.php');

//run query to get all categories
$resultSet = $db->query("SELECT CategoryID,CategoryDepartment FROM Categories");


?>
<form method="post" action="" name="books" class="Search">
<h3>Please select the Category of the books you would like to see:</h3>
<select name="department[]" >
<?php
//fetch results from the previous query and assign them to a variable and 
//echo them in the select drop down menu
while($rows = $resultSet->fetch_assoc())
{
	$department_name = $rows['CategoryDepartment'];
	$department_ID = $rows['CategoryID'];
	echo "<option value='$department_ID'>$department_ID-$department_name</option>";
}
?>
</select>
<button type="submit" name="department_ID" value="$department_ID">Search</button>

</form>

<?php

//check if department ID is set from the form
if (isset($_POST['department_ID']))
{
	//inform user of the chosen department
	if(!empty($_POST['department']))
	{
		foreach ($_POST['department'] as $selected)
		{
			echo "You choose category $selected";
		}
	}
}


if ($_SERVER["REQUEST_METHOD"] == "POST")
	{        
			// run query to find books from the selected category
			$sql = "SELECT * FROM books WHERE Category='$selected'";
			$result = $db ->query($sql);
			
			//if results found are more than 0
			if($result -> num_rows > 0)
			{
				//display results in a table
				$num_of_results = $result -> num_rows;
				echo "<br>$num_of_results books found <br>";
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
					echo "</td><td>\n";
					//allow user to reserve book
					echo('<a href="Reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve</a> ');
					echo ("</td></tr>\n");
					
					
				}
				
			
			}
			else//inform user if no results found
			{
				echo "<br>Sorry, no results found";
			}
	}
?>
<footer>
  <p>Author: Raghd Al Juma 2021</p>
</footer>
</body>
</html>