<?php

if (!isset($_COOKIE['user_id'])) 
{ 
	echo "Please sign in to continue.<br/>";
}
else
{
	
	echo "<hr>";
	echo "Search Results:" .
	"<br/>";

	//include other files
	require_once ('security.php'); //contains database connection functions

	//echo "the file was called<br/>";

	$mySQLConnection = connectToMySQL(); //requires security.php

	if ($_SERVER["REQUEST_METHOD"] == "GET") 
	{

	  //echo "the get was set<br/>";

	  //get values from the web form
	  //sanitize the user input
	  $search_term = test_input($_GET["search_term"]);
	  
	  $sql = "SELECT * FROM employees WHERE CONCAT(username,employee_name,employee_title) LIKE '%" . $search_term . "%' LIMIT 5"; 
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Username</th>" . 
		"<th>Name</th>" . 
		"<th>Title</th>" . 
		"<th></th>" .  
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		echo "<tr>" .
		"<td style='width: 15%;'>" . $row[0] . "</td>" .
		"<td style='width: 15%;'>" . $row[1] . "</td>" .
		"<td style='width: 15%;'>" . $row[2] . "</td>" .
		"<td style='width: 15%;'>" . $row[3] . "</td>" .
		"<td style='width: 30%;'><button type='button' onclick='alert(\"Coming soon! This feature will be added to a later release.\")'>Invite</button></td>" .
		"</tr>";
	  }
	  
	  echo "</table>";
	  
	  //echo "<input type='submit' value='Invite'>";
	  
	  echo "</form>";
	  
	}
  
}

?>