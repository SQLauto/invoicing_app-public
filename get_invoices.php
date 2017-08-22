<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 6/26/2017
 * Last Updated: 8-18-2017
 * Description: get a list of invoices for the current user. 
 ***********************************************************/
 
if (!isset($_COOKIE['user_id'])) 
{ 
	echo "Please sign in to continue.<br/>";
}
else
{

	//include other files
	require_once ('security.php'); //contains database connection functions

	//for debug
	/*
	echo "Customer Selection Session = " . filter_var($_SESSION["customer_selection"]) . "<br/>";
	echo "Project Selection Session = " . filter_var($_SESSION["project_selection"]) . "<br/>";
	echo "<br/>";
	*/

	if ($_SERVER["REQUEST_METHOD"] == "GET") 
	{
		
		$mySQLConnection = connectToMySQL(); //requires security.php
		
		//get values from the web form
		//sanitize the user input
		$user_group_id = test_input($_GET["user_group_id"]);
		
		echo "<form>";
		
		//select the customer
		/*
		echo "Customer: " .

		"<select>";

		$sql = "SELECT * FROM invoice_headers WHERE user_group_id = '$user_group_id'"; //direct SQL method
		$result =  $mySQLConnection->query($sql); //direct SQL method
		
		while($row = $result->fetch_array())
		{
			echo "<option value='" .
			$row[2] .
			"'>" .  
			$row[2] . 
			"</option>";
		}
		
		echo "</select>" .
		"<br/>" .
		"<br/>";
		*/
		
		echo "<hr>" . 
		"<br/>";
		
		//select the project
		echo "Project: " .
		"<select>";
		
		$sql = "SELECT * " .
		"FROM time_worked " .
		"LEFT JOIN tasks ON time_worked.task_id = tasks.id " .
		"LEFT JOIN projects ON tasks.project_id = projects.id " .
		"LEFT JOIN customers ON projects.customer_id = customers.id " .
		"WHERE time_worked.is_voided = '0' AND time_worked.user_group_id = '$user_group_id'" .
		"GROUP BY customers.name, projects.name;"; //direct SQL method
		
		//SQL
		/*
		SELECT *
		FROM time_worked
		LEFT JOIN tasks ON time_worked.task_id = tasks.id
		LEFT JOIN projects ON tasks.project_id = projects.id
		LEFT JOIN customers ON projects.customer_id = customers.id
		WHERE time_worked.user_group_id = '1'
		GROUP BY customers.name, projects.name;
		*/
		
		$result =  $mySQLConnection->query($sql); //direct SQL method
		
		while($row = $result->fetch_array())
		{
			echo "<option value='" .
			$row[17] .
			"'>" .  
			$row[24] . " - " . $row[17] . 
			"</option>";
		}
		
		echo "</select>" .
		"<br/>";
		
		echo "<h3>Generate New Invoices</h3>";
		
		//submit button
		echo "<button type='button' style='width: 30%;' onclick='alert(\"Coming soon! This feature will be added to a later release.\")'>Generate New Invoice</button>";
	
		echo "</form>";

		echo "<hr>" . 

		"<h3>View Invoice Detail</h3>";

		//select the invoice
		echo "Invoice: " .
		"<select id='chooseInvoice' onchange='displayInvoiceInformation();'>" . 
		"<option value=''> - </option>";
		$sql = "SELECT * FROM invoice_headers WHERE user_group_id = '$user_group_id' AND is_voided = '0'"; //direct SQL method
		$result =  $mySQLConnection->query($sql); //direct SQL method
		
		while($row = $result->fetch_array())
		{
			echo "<option value='" .
			$row[0] .
			"'>" .  
			$row[2] . " - " . $row[1] . 
			"</option>";
		}
		
		echo "</select>" .
		"<br/>" .
		"<br/>";

		//download PDF button
		echo "<button type='button' style='width: 30%;' onclick='openInvoicePDF();'>Download PDF</button>";
		echo "<br/>";
		echo "<br/>";
		
		echo "<span id='invoiceDetail'>";
		
		echo "Select an invoice to see the detail.";
		//output invoice header info
		//output invoice line item info
	  
		echo "</span>";
		echo "<br/>" .
		"<br/>";

		

		//email PDF button
		//echo "<button type='button' style='width: 30%;' onclick='alert(\"Coming soon! This feature will be added to a later release.\")'>Email PDF</button>";

	}

}

?>