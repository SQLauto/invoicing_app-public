<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/30/2017
 * Last Updated: 8-6-2017
 * Description: void a given project. 
 ***********************************************************/
 
$customerObject = NULL;
$customerObjectArray = NULL;

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
	  $project_id = test_input($_GET["project_id"]);
	  
	  //echo "the user group ID is: " . $user_group_id . "<br/>";
	  
	  //VOID THE PROJECT
	  $sql2 = "UPDATE projects SET is_voided = '1' WHERE id = '$project_id'"; //direct SQL method
	  $result2 =  $mySQLConnection->query($sql2); //direct SQL method
	  
	  //OUTPUT THE REMAINING PROJECTS
	  $sql = "SELECT * FROM projects WHERE user_group_id = '$user_group_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Name</th>" . 
		"<th>Description</th>" . 
		"<th>Tax Rate</th>" . 
		"<th>Customer Name</th>" . 
		"<th></th>" . 
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		$customerObject = getCustomerByID($row[4]);
	  
		echo "<tr>" .
		"<td>" . $row[0] . "</td>" .
		"<td>" . $row[1] . "</td>" .
		"<td>" . $row[2] . "</td>" .
		"<td>" . $row[3] . "</td>" .
		//"<td>" . $row[4] . "</td>" .
		"<td>" . $customerObject->vars['name'] . "</td>" .
		"<td>" .  "<a href='#' onclick='voidProject(" . $user_group_id . "," . $row[0] . ");'>Delete</a>" . "</td>" .
		"</tr>";
	  }
	  
	  //web form for insert new
	  echo "<form action='add_project' method='post'>" .
	  "<td></td>" . 
	  "<td>" . "<input type='text' id='projName'>" . "</td>" . 
	  "<td>" . "<input type='text' id='projDescription'>" . "</td>" . 
	  "<td>" . "<input type='text' id='projTaxRate'>" . "</td>"; 
	  
	  //"<td>" . "<input type='text' id='projCustomerID'>" . "</td>" . 
	  
	  echo "<td><select id='projCustomerID'>";
	  
	  $customerObjectArray = getCustomersByUserGroup($user_group_id);
	  
	  for ($i = 0; $i < count($customerObjectArray); $i++) 
	  {
		echo "<option value='" . $customerObjectArray[$i]->vars['id'] . "'>" . $customerObjectArray[$i]->vars['name'] . "</option>";
	  } 
	  
	  echo "</select></td>";
	  
	  echo "<td>" . "<button onclick=\"addProject()\" style=\"height: 41px; width: 110px;\">Add New</button>" . "</td>" . 
	  //"<td>" . "<input type='submit' value='Add New'>" . "</td>" . 
	  "</tr>" .
	  "<input type='hidden' id='projID' value='" . $user_group_id . "'>" .
	  "</form>";

	  echo "</table>";
	  
	}

}

?>