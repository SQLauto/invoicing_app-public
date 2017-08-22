<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/26/2017
 * Description: get invoice detail. 
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
	  $invoice_id = test_input($_GET["invoice_id"]);

	  //echo "the user group ID is: " . $user_group_id . "<br/>";

	  $sql = "SELECT * FROM invoice_headers WHERE id = '$invoice_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method

	  while($row = $result->fetch_array())
	  {
		echo "ID: " . $row[0] . "<br/>" .
		"Invoice Number: " . $row[1] . "<br/>" .
		"Customer Name: " . $row[2] . "<br/>" .
		"Address-Street: " . $row[3] . "<br/>" .
		"Address-City: " . $row[4] . "<br/>" .
		"Address-State: " . $row[5] . "<br/>" .
		"Address-Zip: " . $row[6] . "<br/>" .
		"Phone: " . $row[7] . "<br/>" .
		"Email: " . $row[8] . "<br/>" .
		"Contact Name: " . $row[9] . "<br/>" .
		"Project Name: " . $row[10] . "<br/>" .
		"Project Descr.: " . $row[11] . "<br/>" .
		"Project ID: " . $row[12] . "<br/>" .
		"Tax Rate: " . $row[13] . "<br/>" .
		"Customer ID: " . $row[14] . "<br/>" .
		"User Group ID: " . $row[16] . "<br/>" .
		"<br/>" .
		"<br/>";
	  }
	  
	  $sql2 = "SELECT * FROM invoice_line_items WHERE invoice_header_id = '$invoice_id' AND is_voided = '0'"; //direct SQL method
	  $result2 =  $mySQLConnection->query($sql2); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Task Name</th>" . 
		"<th>Task Description</th>" . 
		"<th>Employee Name</th>" . 
		"<th>Hourly Rate</th>" . 
		"<th>Start Time</th>" . 
		"<th>Stop Time</th>" . 
	  "</tr>";
	  
	  while($row2 = $result2->fetch_array())
	  {
		echo "<tr><form>" .
		"<td>" . $row2[0] . "</td>" .
		"<td>" . $row2[8] . "</td>" .
		"<td>" . $row2[9] . "</td>" .
		"<td>" . $row2[5] . "</td>" .
		"<td>" . $row2[7] . "</td>" .
		"<td>" . $row2[2] . "</td>" .
		"<td>" . $row2[3] . "</td>" .
		"</form></tr>";
	  }
	  
	}

}



?>