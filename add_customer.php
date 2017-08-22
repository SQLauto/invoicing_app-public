<?php

// Start the session
session_start();

$debugging = 0; //set this to 1 to see debugging output

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
	$insertAddressStreet = "b";
	$insertAddressCity = "c";
	$insertAddressState = "d";
	$insertAddressZip = "e";
	$insertPhone = "f";
	$insertEmail = "g";
	$insertContactName = "h";
	$insertUserGroupID = "i";
	
	if (isset($_GET['custName'])) 
	{
		$insertName = test_input($_GET['custName']); // there is no error here
	}
	
	if (isset($_GET['custStreet'])) 
	{
		$insertAddressStreet = test_input($_GET['custStreet']); // there is no error here
	}
	
	if (isset($_GET['custCity'])) 
	{
		$insertAddressCity = test_input($_GET['custCity']); // there is no error here
	}
	
	if (isset($_GET['custState'])) 
	{
		$insertAddressState = test_input($_GET['custState']); // there is no error here
	}
	
	if (isset($_GET['custZip'])) 
	{
		$insertAddressZip = test_input($_GET['custZip']); // there is no error here
	}
	
	if (isset($_GET['custPhone'])) 
	{
		$insertPhone = test_input($_GET['custPhone']); // there is no error here
	}
	
	if (isset($_GET['custEmail'])) 
	{
		$insertEmail = test_input($_GET['custEmail']); // there is no error here
	}

	if (isset($_GET['custContact'])) 
	{
		$insertContactName = test_input($_GET['custContact']); // there is no error here
	}
	
	if (isset($_GET['custID'])) 
	{
		$insertUserGroupID = test_input($_GET['custID']); // there is no error here
	}
	
	$mySQLConnection = connectToMySQL(); //requires security.php

	$sql = "INSERT INTO customers " . 
	"(name, address_street, address_city, address_state, address_zip, phone, email, contact_name, user_group_id)" .
	"VALUES ('" . $insertName .  "','" . $insertAddressStreet .  "','" . $insertAddressCity .  "','" . $insertAddressState .  "','" . $insertAddressZip .  "','" . $insertPhone .  "','" . $insertEmail .  "','" . $insertContactName .  "','" . $insertUserGroupID .  "')";

	mysqli_query($mySQLConnection,$sql);

	
	mysqli_close($mySQLConnection);
}

?>