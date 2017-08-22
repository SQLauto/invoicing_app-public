<?php

// Start the session
session_start();

$debugging = 1; //set this to 1 to see debugging output

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
	$insertTaxRate = "c";
	$insertCustomerID = "d";
	$insertUserGroupID = "0";
	
	if (isset($_GET['projName'])) 
	{
		$insertName = test_input($_GET['projName']); // there is no error here
	}
	
	if (isset($_GET['projDescription'])) 
	{
		$insertDescription = test_input($_GET['projDescription']); // there is no error here
	}
	
	if (isset($_GET['projTaxRate'])) 
	{
		$insertTaxRate = test_input($_GET['projTaxRate']); // there is no error here
	}
	
	if (isset($_GET['projCustomerID'])) 
	{
		$insertCustomerID = test_input($_GET['projCustomerID']); // there is no error here
	}
	
	if (isset($_GET['projID'])) 
	{
		$insertUserGroupID = test_input($_GET['projID']); // there is no error here
	}
	
	$mySQLConnection = connectToMySQL(); //requires security.php

	$sql = "INSERT INTO projects " . 
	"(name, description, tax_rate, customer_id, user_group_id)" .
	"VALUES ('" . $insertName .  "','" . $insertDescription .  "','" . $insertTaxRate .  "','" . $insertCustomerID .  "','" . $insertUserGroupID .  "')";
	
	echo $sql;
	
	mysqli_query($mySQLConnection,$sql);

	
	mysqli_close($mySQLConnection);
}

?>