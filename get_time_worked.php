<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/30/2017
 * Last Updated: 8-20-2017
 * Description: get time worked for the logged in user. 
 ***********************************************************/

$taskObject = NULL;
$taskObjectArray = NULL;

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
	  
	  $sql = "SELECT * FROM time_worked WHERE user_group_id = '$user_group_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Task ID</th>" . 
		"<th>Task Name</th>" . 
		"<th>Start Time</th>" . 
		"<th>Stop Time</th>" . 
		"<th></th>" . 
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		$taskObject = getTaskByID($row[1]);
	  
		echo "<tr>" .
		"<td>" . $row[0] . "</td>" .
		"<td>" . $row[1] . "</td>" .
		"<td>" . $taskObject->vars['name'] . "</td>" .
		"<td>" . $row[2] . "</td>" .
		"<td>" . $row[3] . "</td>" .
		"<td>" .  "<a href='#' onclick='voidTimeWorked(" . $user_group_id . "," . $row[0] . ");'>Delete</a>" . "</td>" .
		"</tr>";
	  }
	  
	  //web form for insert new
	  
	  echo "<form action='add_time_worked.php' method='post'>" .
	  "<td></td>" . 
	  "<td></td>";
	  
	  //"<td>" . "<input type='text' id='timeTaskID'>" . "</td>" . 
	  
	  echo "<td><select id='timeTaskID'>";
	  
	  $taskObjectArray = getTasksByUserGroup($user_group_id);
	  
	  for ($i = 0; $i < count($taskObjectArray); $i++) 
	  {
		echo "<option value='" . $taskObjectArray[$i]->vars['id'] . "'>" . $taskObjectArray[$i]->vars['name'] . "</option>";
	  }
	  
	  echo "</select></td>";
	  
	  echo "<td>" . "<input type='text' id='timeStart' name='timeStart' class='datepicker'>" . "</td>" . 
	  "<td>" . "<input type='text' id='timeStop' name='timeStop' class='datepicker'>" . "</td>" . 
	  "<td>" . "<button onclick=\"addTime()\" style=\"height: 41px; width: 110px;\">Add New</button>" . "</td>" . 
	  //"<td>" . "<input type='submit' value='Add New'>" . "</td>" . 
	  "</tr>" .
	  "<input type='hidden' id='timeID' value='" . $user_group_id . "'>" .
	  "</form>";

	  echo "</table>";
 
	}

}

?>

