<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 6/26/2017
 * Description: void a given customer. 
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
	  $customer_id = test_input($_GET["customer_id"]);
	  
	  //echo "the user group ID is: " . $user_group_id . "<br/>";
	  
	  //VOID THE CUSTOMER
	  $sql2 = "UPDATE customers SET is_voided = '1' WHERE id = '$customer_id'"; //direct SQL method
	  $result2 =  $mySQLConnection->query($sql2); //direct SQL method
	  
	  //OUTPUT THE REMAINING CUSTOMERS
	  $sql = "SELECT * FROM customers WHERE user_group_id = '$user_group_id' AND is_voided = '0'"; //direct SQL method
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Name</th>" . 
		"<th>Address Street</th>" . 
		"<th>Address City</th>" . 
		"<th>Address State</th>" . 
		"<th>Address Zip</th>" . 
		"<th>Phone</th>" . 
		"<th>Email</th>" . 
		"<th>Contact Name</th>" . 
		"<th></th>" . 
	  "</tr>";
	  
	  while($row = $result->fetch_array())
	  {
		echo "<tr><form>" .
		"<td>" . $row[0] . "</td>" .
		"<td>" . $row[1] . "</td>" .
		"<td>" . $row[2] . "</td>" .
		"<td>" . $row[3] . "</td>" .
		"<td>" . $row[4] . "</td>" .
		"<td>" . $row[5] . "</td>" .
		"<td>" . $row[6] . "</td>" .
		"<td>" . $row[7] . "</td>" .
		"<td>" . $row[8] . "</td>" .
		"<td>" .  "<a href='#' onclick='voidCustomer(" . $user_group_id . "," . $row[0] . ");'>Delete</a>" . "</td>" .
		"</form></tr>";
	  }
	  
	  //web form for insert new
	  echo "<form action='/get_customers.php' method='post'>" .
	  "<td></td>" . 
	  "<td>" . "<input type='text' id='custName'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custStreet'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custCity'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custState'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custZip'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custPhone'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custEmail'>" . "</td>" . 
	  "<td>" . "<input type='text' id='custContact'>" . "</td>" . 
	  "<td>" . "<button onclick=\"addCustomer()\" style=\"height: 41px; width: 110px;\">Add New</button>" . "</td>" . 
	  //"<td>" . "<input type='submit' value='Add New'>" . "</td>" . 
	  "</tr>" .	  
	  "<input type='hidden' id='custID' value='" . $user_group_id . "'>" .
	  "</form>";

	  echo "</table>";
	  
	}

}



?>