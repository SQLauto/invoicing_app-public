<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/26/2017
 * Description: get a list of employees for the current user. 
 ***********************************************************/

if (!isset($_COOKIE['user_id'])) 
{ 
	echo "Please sign in to continue.<br/>";
}
else
{

	//include other files
	require_once ('security.php'); //contains database connection functions

	//echo "the file was called<br/>";

	$mySQLConnection = connectToMySQL(); //requires security.php

	if ($_SERVER["REQUEST_METHOD"] == "GET") 
	{

	  //echo "the get was set<br/>";

	  //get values from the web form
	  //sanitize the user input
	  $user_group_id = test_input($_GET["user_group_id"]);
	  
	  //echo "the user group ID is: " . $user_group_id . "<br/>";
	  
	  $sql = "SELECT * FROM employees WHERE user_group = '$user_group_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Username</th>" . 
		"<th>Name</th>" . 
		"<th>Title</th>" . 
		"<th>Email</th>" . 
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		echo "<tr>" .
		"<td>" . $row[0] . "</td>" .
		"<td>" . $row[1] . "</td>" .
		"<td>" . $row[2] . "</td>" .
		"<td>" . $row[3] . "</td>" .
		"<td>" . $row[4] . "</td>" .
		"</tr>";
	  }
	  
	  echo "</table>";
	  
	  //web form to search 
	  echo "<hr>";
	  echo "<h3>Search for team members to invite.</h3>";
	  
	  echo "<form action='search_employee.php' method='post'>" .
	  "</form>" . 
	  "Search Term: " .
	  "<input type='text' id='search_term' style='width: 30%;'>" .
	  "<br/>" . 
	  "<input type='hidden' value='" . $user_group_id . "'>" . 
	  "<button type='button' style='width: 30%;' onclick='searchForEmployees();'>Search</button>" . 
	  "<br>" . 
	  "<span id=\"searchResults\"></span>";

	  
	  //web form to invite by email
	  echo "<hr>";
	  echo "<h3>Invite a new member by email.</h3>";
	  
	  echo "<form action='add_employee.php' method='post'>" .
	  "Email Address: " .
	  "<input type='text' style='width: 30%;'>" . 
	  "<input type='hidden' value='" . $user_group_id . "'>"
	  . "<br>";
	  //echo "<input type='submit' value='Invite'>";
	  echo "<button type='button' style='width: 30%;' onclick='alert(\"Coming soon! This feature will be added to a later release.\")'>Invite</button>";
	  echo "</form>";
	  
	}
  
}

?>