<?php

/***********************************************************
* Author: Matt Nutsch
* Date: 8/5/2017
* Last Updated: 8-19-2017
* Description: database access fuctions used by other files. 
***********************************************************/

//include other files
require_once ('security.php'); //contains database connection functions

/***********************************************************
* function getCustomerByID($customerID)
* Description: This function returns an object containing customer information.
* 
***********************************************************/
function getCustomerByID($customerID)
{
	$customerObject = NULL;

	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM customers WHERE id = '$customerID' AND is_voided = '0' LIMIT 1"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	while($row = $result->fetch_array())
	{
		$customerObject->vars['id'] = $row[0];
		$customerObject->vars['name'] = $row[1];
	}
	
	return $customerObject;
}

function getProjectByID($projectID)
{
	$projectObject = NULL;

	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM projects WHERE id = '$projectID' AND is_voided = '0' LIMIT 1"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	while($row = $result->fetch_array())
	{
		$projectObject->vars['id'] = $row[0];
		$projectObject->vars['name'] = $row[1];
	}
	
	return $projectObject;
}

function getTaskByID($taskID)
{
	$taskObject = NULL;

	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM tasks WHERE id = '$taskID' AND is_voided = '0' LIMIT 1"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	//echo "DEBUG: sql = " . $sql . "<br/>";
	
	while($row = $result->fetch_array())
	{
		$taskObject->vars['id'] = $row[0];
		$taskObject->vars['name'] = $row[1];
	}
	
	return $taskObject;
}

function getCustomersByUserGroup($userGroupID)
{
	$customerObjectArray = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM customers WHERE user_group_id = '$userGroupID' AND is_voided = '0'"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	echo "DEBUG: sql = " . $sql . "<br/>";
	
	$i = 0;
	while($row = $result->fetch_array())
	{
		$customerObjectArray[$i]->vars['id'] = $row[0];
		$customerObjectArray[$i]->vars['name'] = $row[1];
		$i++;
	}
	
	return $customerObjectArray;
}

function getTasksByUserGroup($userGroupID)
{
	$taskObjectArray = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM tasks WHERE user_group_id = '$userGroupID' AND is_voided = '0'"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	$i = 0;
	while($row = $result->fetch_array())
	{
		$taskObjectArray[$i]->vars['id'] = $row[0];
		$taskObjectArray[$i]->vars['name'] = $row[1];
		$i++;
	}
	
	return $taskObjectArray;
}

function getTasksByProject($projectID)
{
	$taskObjectArray = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM tasks WHERE project_id = '$projectID' AND is_voided = '0'"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	$i = 0;
	while($row = $result->fetch_array())
	{
		$taskObjectArray[$i]->vars['id'] = $row[0];
		$taskObjectArray[$i]->vars['name'] = $row[1];
		$i++;
	}
	
	return $taskObjectArray;
}

function getProjectsByUserGroup($userGroupID)
{
	$projectObjectArray = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM projects WHERE user_group_id = '$userGroupID' AND is_voided = '0'"; //direct SQL method
	$result =  $mySQLConnection->query($sql); //direct SQL method

	$i = 1;
	while($row = $result->fetch_array())
	{
		$projectObjectArray[$i]->vars['id'] = $row[0];
		$projectObjectArray[$i]->vars['name'] = $row[1];
		$projectObjectArray[$i]->vars['customer_id'] = $row[4];
		$i++;
	}
	
	return $projectObjectArray;
}

function getUserGroupByID($userGroupID)
{
	$UserGroupObject = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM user_groups WHERE id = '$userGroupID' AND is_voided = '0'"; //direct SQL method
	
	$result =  $mySQLConnection->query($sql); //direct SQL method

	while($row = $result->fetch_array())
	{
		$UserGroupObject->vars['id'] = $row[0];
		$UserGroupObject->vars['full_name'] = $row[1];
		$UserGroupObject->vars['short_name'] = $row[2];
		$UserGroupObject->vars['default_payment_terms'] = $row[3];
		$UserGroupObject->vars['remit_name'] = $row[4];
		$UserGroupObject->vars['remit_address_street'] = $row[5];
		$UserGroupObject->vars['remit_address_city'] = $row[6];
		$UserGroupObject->vars['remit_address_state'] = $row[7];
		$UserGroupObject->vars['remit_address_zip'] = $row[8];
		$UserGroupObject->vars['remit_phone'] = $row[9];
		$UserGroupObject->vars['remit_email'] = $row[10];
		$UserGroupObject->vars['default_invoice_message_1'] = $row[11];
		$UserGroupObject->vars['default_invoice_message_2'] = $row[12];
		$UserGroupObject->vars['created_date'] = $row[13];
		$UserGroupObject->vars['is_voided'] = $row[14];
	}
	
	return $UserGroupObject;
}

function getPaymentTermsByID($termsID)
{
	$PaymentTermsObject = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM payment_terms WHERE id = '$termsID' AND is_voided = '0'"; //direct SQL method
	
	$result =  $mySQLConnection->query($sql); //direct SQL method

	while($row = $result->fetch_array())
	{
		$PaymentTermsObject->vars['id'] = $row[0];
		$PaymentTermsObject->vars['long_name'] = $row[1];
		$PaymentTermsObject->vars['short_name'] = $row[2];
		$PaymentTermsObject->vars['due_days_plus'] = $row[3];
		$PaymentTermsObject->vars['due_months_plus'] = $row[4];
		$PaymentTermsObject->vars['due_day_of_month'] = $row[5];
		$PaymentTermsObject->vars['use_day_of_month'] = $row[6];
		$PaymentTermsObject->vars['created_date'] = $row[7];
		$PaymentTermsObject->vars['is_voided'] = $row[8];

	}
	
	return $PaymentTermsObject;
}

function getUserGroupsByUserID($userID)
{

	$UserGroupObjectArray = NULL;
	
	$mySQLConnection = connectToMySQL(); //requires security.php
	
	$sql = "SELECT * FROM user_group_members WHERE user_id = '$userID' AND is_voided = '0'"; //direct SQL method
	
	$result =  $mySQLConnection->query($sql); //direct SQL method

	$i = 1;
	while($row = $result->fetch_array())
	{
		$UserGroupObjectArray[$i]->vars['id'] = $row[0];
		$UserGroupObjectArray[$i]->vars['user_group_id'] = $row[1];
		$UserGroupObjectArray[$i]->vars['user_id'] = $row[2];
		$UserGroupObjectArray[$i]->vars['created_date'] = $row[3];
		$UserGroupObjectArray[$i]->vars['is_voided'] = $row[4];
		$i++;
	}
	
	return $UserGroupObjectArray;
}

?>