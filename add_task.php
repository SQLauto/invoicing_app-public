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

	$insertName = "a";
	$insertDescription = "b";
	$insertProjectID = "c";
	$insertUserGroupID = "0";
	
	if (isset($_GET['taskName'])) 
	{
		$insertName = test_input($_GET['taskName']); // there is no error here
	}
	
	if (isset($_GET['taskDescription'])) 
	{
		$insertDescription = test_input($_GET['taskDescription']); // there is no error here
	}
	
	if (isset($_GET['taskProjectID'])) 
	{
		$insertProjectID = test_input($_GET['taskProjectID']); // there is no error here
	}
	
	if (isset($_GET['taskID'])) 
	{
		$insertUserGroupID = test_input($_GET['taskID']); // there is no error here
	}
	
	$mySQLConnection = connectToMySQL(); //requires security.php

	$sql = "INSERT INTO tasks " . 
	"(name, description, project_id, user_group_id)" .
	"VALUES ('" . $insertName .  "','" . $insertDescription .  "','" . $insertProjectID .  "','" . $insertUserGroupID .  "')";
	
	echo $sql;
	
	mysqli_query($mySQLConnection,$sql);

	
	mysqli_close($mySQLConnection);
}

?>