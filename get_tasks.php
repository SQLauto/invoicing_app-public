<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/30/2017
 * Last Updated: 8-6-2017
 * Description: get tasks for the logged in user. 
 ***********************************************************/
 
$projectObject = NULL;
$projectObjectArray = NULL;

//include other files
require_once ('security.php'); //contains database connection functions
require_once ('database_functions.php'); //contains functions for reading database data 

if (!isset($_COOKIE['user_id'])) 
{ 
	echo "Please sign in to continue.<br/>";
}
else
{

	//echo "the file was called<br/>";

	$mySQLConnection = connectToMySQL(); //requires security.php

	if ($_SERVER["REQUEST_METHOD"] == "GET") 
	{

	  //echo "the get was set<br/>";

	  //get values from the web form
	  //sanitize the user input
	  $user_group_id = test_input($_GET["user_group_id"]);
	  
	  //echo "the user group ID is: " . $user_group_id . "<br/>";
	  
	  $sql = "SELECT * FROM tasks WHERE user_group_id = '$user_group_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Name</th>" . 
		"<th>Description</th>" . 
		"<th>Project Name</th>" . 
		"<th></th>" . 
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		$projectObject = getProjectByID($row[3]);
	  
		echo "<tr>" .
		"<td>" . $row[0] . "</td>" .
		"<td>" . $row[1] . "</td>" .
		"<td>" . $row[2] . "</td>" .
		"<td>" . $projectObject->vars['name'] . "</td>" .
		"<td>" .  "<a href='#' onclick='voidTask(" . $user_group_id . "," . $row[0] . ");'>Delete</a>" . "</td>" .
		"</tr>";
	  }
	  
	  //web form for insert new
	  echo "<form action='add_task.php' method='post'>" .
	  "<td></td>" . 
	  "<td>" . "<input type='text' id='taskName'>" . "</td>" . 
	  "<td>" . "<input type='text' id='taskDescription'>" . "</td>";
	  
	  //"<td>" . "<input type='text' id='taskProjectID'>" . "</td>" . 
	  
	  echo "<td><select id='taskProjectID'>";
	  
	  $projectObjectArray = getProjectsByUserGroup($user_group_id);
	  
	  for ($i = 1; $i <= count($projectObjectArray); $i++) 
	  {
		echo "<option value='" . $projectObjectArray[$i]->vars['id'] . "'>" . $projectObjectArray[$i]->vars['name'] . "</option>";
	  }
	  
	  echo "</select></td>";
	  
	  echo "<td>" . "<button onclick=\"addTask()\" style=\"height: 41px; width: 110px;\">Add New</button>" . "</td>" . 
	  //"<td>" . "<input type='submit' value='Add New'>" . "</td>" . 
	  "</tr>" .
	  "<input type='hidden' id='taskID' value='" . $user_group_id . "'>" .
	  "</form>";
	
	  echo "</table>";
	  
	}

}

?>
