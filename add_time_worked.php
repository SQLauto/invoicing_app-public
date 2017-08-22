<?php

// Start the session
session_start();

$debugging = 0;//set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong><br/>";  
    echo "Start time: ";
    echo(date("Y-m-d H:i:s",$t));
    echo "<br/>";
}

//include other files
require_once ('security.php'); //contains database connection info

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{

	$insertTaskID = "a";
	$insertStart = "b";
	$insertStop = "c";
	$insertUserGroupID = "0";
	
	if (isset($_GET['timeTaskID'])) 
	{
		$insertTaskID = test_input($_GET['timeTaskID']); // there is no error here
	}
	
	if (isset($_GET['timeStart'])) 
	{
		$insertStart = test_input($_GET['timeStart']); // there is no error here
	}
	
	if (isset($_GET['timeStop'])) 
	{
		$insertStop = test_input($_GET['timeStop']); // there is no error here
	}
	
	if (isset($_GET['timeID'])) 
	{
		$insertUserGroupID = test_input($_GET['timeID']); // there is no error here
	}
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "INSERT INTO time_worked " . 
	"(task_id, start_time, stop_time, user_group_id)" .
	"VALUES ('" . $insertTaskID .  "','" . $insertStart .  "','" . $insertStop .  "','" . $insertUserGroupID .  "')";
	
	echo $sql;
	
	mysqli_query($mySQLConnection,$sql);

	
	mysqli_close($mySQLConnection);
}

?>