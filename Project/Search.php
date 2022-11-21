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
<div>
<form method="post" action="" name="search-form" class="Search">
	<h3>Please enter Book Title and/or Author</h3>
	<div class="Title">
	<label>Book Title</label>
	<br>
    <input type="text" name="BookTitle"/>
	</div>
	<br>
	<div class="Author">
    <label>Author</label>
	<br>
    <input type="text" name="Author"/>
	</div>
	<button type="submit" name="Search" value="Search">Search</button>
</form>
</div>

<?php
	
	//include database connection and session initiation
    include('database.php');
    include('Session.php');
	
	//if form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//Validate input and Assign submitted data to variable 
		$BookTitle = $db -> real_escape_string(validate($_POST['BookTitle']));
		$Author = $db -> real_escape_string(validate($_POST['Author']));
			
        //If no data enterd , inform user
		if (empty($BookTitle) && empty($Author))
		{
			echo "You have to enter something first";
		}
		elseif (empty($Author) && !empty($BookTitle))//if Only bookTitle is enterd
		{
			//Find books from the database with the booktitle entered
			$sql = "SELECT * FROM books WHERE BookTitle='$BookTitle'";
			$result = $db ->query($sql);
			
			//Display results in a table
			if($result -> num_rows > 0)
			{
				$num_of_results = $result -> num_rows;
				echo "$num_of_results Found";
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
					echo('<a href="Reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve</a> ');
					echo ("</td></tr><br>");
					
					
				}
				
			
			}
			else//If no results found inform user
			{
				echo "Sorry, no results found for $BookTitle";
			}
		}
		elseif (empty($BookTitle) && !empty($Author))// If only Author was entered
		{
			//Find results of books with the enetered author
			$sql = "SELECT * FROM books WHERE Author='$Author'";
			$result = $db ->query($sql);
			
			//Display results if available
			if($result -> num_rows > 0)
			{
				$num_of_results = $result -> num_rows;
				echo "$num_of_results Found";
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
					echo('<a href="Reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve</a>  ');
					echo ("</td></tr><br>");
					
					
				}
			
			}
			else//Inform user if no results are available
			{
				echo "Sorry, no results found for $Author";
			}
   
		}
		elseif (!empty($BookTitle) && !empty($BookTitle)) //If both author and title are entered
		{
			//Find results
			$sql = "SELECT * FROM books WHERE BookTitle='$BookTitle' AND Author='$Author'";
			$result = $db ->query($sql);
			
			//Display results
			if($result -> num_rows > 0)
			{
				$num_of_results = $result -> num_rows;
				echo "$num_of_results Found";
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
					echo('<a href="Reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve</a>  ');
					echo ("</td></tr><br>");
					
					
				}
			
			}//Inform user of no results found
			else
			{
				echo "Sorry, no results found for $BookTitle by $Author";
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
<footer>
  <p>Author: Raghd Al Juma 2021</p>
</footer>
</body>
</html>