<!DOCTYPE html>
<html>
<head>
<title>Library</title>
<link rel="stylesheet" href="Assets/Style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="icon" type="image/x-icon" href="Assets/Photos/favicon.ico">
</head>
<body>



<?php
//connect to database and start session
include('database.php');
include('Session.php');

//run query to get all categories
$resultSet = $db->query("SELECT CategoryID,CategoryDepartment FROM Categories");

if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 5;
        $offset = ($pageno-1) * $no_of_records_per_page;
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
		



if (isset($_POST['department_ID']))
	{        
			$total_pages_sql = "SELECT COUNT(*) FROM books WHERE Category='$selected'";
        
			$result = mysqli_query($db,$total_pages_sql);
			$total_rows = mysqli_fetch_array($result)[0];
			$total_pages = ceil($total_rows / $no_of_records_per_page);
			// run query to find books from the selected category
			$sql = "SELECT * FROM books WHERE Category='$selected' LIMIT $offset, $no_of_records_per_page";
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
<ul class="pagination">
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>
</body>
</html>