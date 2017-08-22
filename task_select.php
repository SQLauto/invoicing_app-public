<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 8/19/2017
 * Last Updated: 8-19-2017
 * Description: This is file outputs a select tag with the 
 * task list as options.
 ***********************************************************/

//include other files
include_once('database_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{

	if (isset($_GET['projectID'])) 
	{
		$projectID = test_input($_GET['projectID']);
	}
	echo "Task: ";
	echo "<select id='timeTaskID'>";
	
	$taskObjectArray = getTasksByProject($projectID);
	
	for ($i = 0; $i < count($taskObjectArray); $i++) 
	{
		echo "<option value='" . $taskObjectArray[$i]->vars['id'] . "'>" . $taskObjectArray[$i]->vars['name'] . "</option>";
	}
	
	echo "</select>";

}

?>
