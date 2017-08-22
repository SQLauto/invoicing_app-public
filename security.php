<?php

//Set Debugging Options
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
require_once ('configuration.php'); //contains database connection info

/*******************************************************************************
* Function Name: connectToMySQL()
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return 1 if the connection was made and 0 if not.
*******************************************************************************/
function connectToMySQL()
{
  $mySQLConnection = 0; //used to track if the database is connected.
  
  $mysql_dbname = DB_NAME; 
  $mysql_username = DB_USER;
  $mysql_pw = DB_PASSWORD;
  $mysql_hostname = DB_HOST;
  
  // Create connection
  $mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);
  
  // Check connection
  if ($mySQLConnection->connect_error) 
  {
    echo "Error connecting to MySQL: <br>" . $mySQLConnection->error;
    return 0;
  }
  else
  {
    return $mySQLConnection;
  }
  
}

/*******************************************************************************
* Function Name: disconnectFromMySQL()
* Description: 
* This function will: 
* Disconnect from MySQL.
*******************************************************************************/
function disconnectFromMySQL($mySQLConnection)
{
  $mySQLConnection->close();
}

/*******************************************************************************
* Function Name: createUser($userObject)
* Description: 
* This function will: 
* accept an object containing user info as an argument
* hash the password
* insert the user info into the user database
* The second parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function createUser($userObject, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
    
  $testObject = $userObject;
  
  $table_name = "employees";
  
  $username = $testObject->vars["username"];
  $employee_name = $testObject->vars["employee_name"];
  $employee_title = $testObject->vars["employee_title"];
  $email = $testObject->vars["email"];
  $password = $testObject->vars["password"];
  $last_logged = $testObject->vars["last_logged"];
  $start_date = $testObject->vars["start_date"];
  $is_active = $testObject->vars["is_active"];
  $require_password_reset = $testObject->vars["require_password_reset"];
  $hourly_rate = $testObject->vars["hourly_rate"];
  $user_group = $testObject->vars["user_group"];
  
  $password = password_hash($password, PASSWORD_DEFAULT);
  
  //direct SQL method
  $sql = "INSERT INTO $table_name (username, employee_name, employee_title, email, password, last_logged, start_date, is_active, require_password_reset, hourly_rate, user_group)VALUES ('$username', '$employee_name', '$employee_title', '$email', '$password', '$last_logged', '$start_date', '$is_active', '$require_password_reset', '$hourly_rate', '$user_group')";
  
  //direct SQL method
  if ($mySQLConnection->query($sql) === TRUE) 
  {
    return 1;
  } 
  else 
  {
    return "Error: " . $sql . "<br>" . $mySQLConnection->error;
  }
  
  return $returnValue;
}


/*******************************************************************************
* Function Name: updateUser($userObject)
* Description: 
* This function will: 
* Accept an object containing user info as an argument.
* Update the user in the user database.
* The user will be identified based on the user id.
* The second parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function updateUser($userObject, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  
  $table_name = "employees";
  
  $testObject = $userObject;
  
  $id = $testObject->vars["id"];
  
  $username = $testObject->vars["username"];
  $employee_name = $testObject->vars["employee_name"];
  $employee_title = $testObject->vars["employee_title"];
  $email = $testObject->vars["email"];
  $password = $testObject->vars["password"];
  $last_logged = $testObject->vars["last_logged"];
  $start_date = $testObject->vars["start_date"];
  $is_active = $testObject->vars["is_active"];
  $require_password_reset = $testObject->vars["require_password_reset"];
  $hourly_rate = $testObject->vars["hourly_rate"];
  $user_group = $testObject->vars["user_group"];
  
  //hash the password
  $password = password_hash($password, PASSWORD_DEFAULT);
  
  //direct SQL method
  $sql = "UPDATE $table_name SET `username` = '$username', `employee_name` = '$employee_name', `employee_title` = '$employee_title', `email` = '$email', `password` = '$password', `last_logged` = '$last_logged', `start_date` = '$start_date', `is_active` = '$is_active', `require_password_reset` = '$require_password_reset', `hourly_rate` = '$hourly_rate', `user_group` = '$user_group' WHERE `id` = '$id';";
  
  //direct SQL method
  if ($mySQLConnection->query($sql) === TRUE) 
  {
    //echo "Record updated successfully<br/>";
    $returnValue = 1;
  } 
  else 
  {
    $returnValue = "Error updating record: " . $mySQLConnection->error . "<br/>";
  }
  
  return $returnValue;
}

function updateUserByName($userObject, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  
  $table_name = "employees";
  
  $testObject = $userObject;
  
  $id = $testObject->vars["id"];
  
  $username = $testObject->vars["username"];
  $employee_name = $testObject->vars["employee_name"];
  $employee_title = $testObject->vars["employee_title"];
  $email = $testObject->vars["email"];
  $password = $testObject->vars["password"];
  $last_logged = $testObject->vars["last_logged"];
  $start_date = $testObject->vars["start_date"];
  $is_active = $testObject->vars["is_active"];
  $require_password_reset = $testObject->vars["require_password_reset"];
  $hourly_rate = $testObject->vars["hourly_rate"];
  $user_group = $testObject->vars["user_group"];
  
  //hash the password
  $password = password_hash($password, PASSWORD_DEFAULT);
  
  //direct SQL method
  $sql = "UPDATE $table_name SET `username` = '$username', `employee_name` = '$employee_name', `employee_title` = '$employee_title', `email` = '$email', `password` = '$password', `last_logged` = '$last_logged', `start_date` = '$start_date', `is_active` = '$is_active', `require_password_reset` = '$require_password_reset', `hourly_rate` = '$hourly_rate', `user_group` = '$user_group' WHERE `username` = '$username';";
  
  //direct SQL method
  if ($mySQLConnection->query($sql) === TRUE) 
  {
    //echo "Record updated successfully<br/>";
    $returnValue = 1;
  } 
  else 
  {
    $returnValue = "Error updating record: " . $mySQLConnection->error . "<br/>";
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: deleteUserByID($userObject, $mySQLConnection)
* Description: 
* This function will: 
* Accept an object containing a user ID as an argument.
* Delete the user from the database.
* The user will be identified based on the user ID.
* The second parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function deleteUser($userObject, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  
  $table_name = "employees";
  
  $id = $userObject->vars["id"];
  
  $sql = "DELETE FROM $table_name WHERE id=$id"; //direct SQL method
  $result =  $mySQLConnection->query($sql); //direct SQL method
  //direct SQL method
  if ( $mySQLConnection->query($sql) === TRUE) 
  {
    //echo "Record deleted successfully<br/>";
    $returnValue = 1;
  } 
  else 
  {
    $returnValue = "Error deleting record: " . $conn->error . "<br/>";
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: getUser($userID, $mySQLConnection)
* Description: 
* This function will: 
* Accepts an argument containing the userID.
* The object received should have a variable labelled "id": $userObject->vars["id"]
* The function returns a single object containing the user data retrieved.
* The user will be identified based on the user ID.
* The second parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function getUser($userID, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  
  $table_name = "employees";
  (object)$testObject->vars["init"] = "1";
  
  $sql = "SELECT * FROM $table_name WHERE id = '$userID' LIMIT 1"; //direct SQL method
  $result =  $mySQLConnection->query($sql); //direct SQL method
  
  while($row = $result->fetch_array())
  {
    $username = $testObject->vars["username"];
    $employee_name = $testObject->vars["employee_name"];
	$employee_title = $testObject->vars["employee_title"];
	$email = $testObject->vars["email"];
	$password = $testObject->vars["password"];
	$last_logged = $testObject->vars["last_logged"];
	$start_date = $testObject->vars["start_date"];
	$is_active = $testObject->vars["is_active"];
	$require_password_reset = $testObject->vars["require_password_reset"];
	$hourly_rate = $testObject->vars["hourly_rate"];
	$user_group = $testObject->vars["user_group"];
  
    $testObject->vars["id"] = $row[0];
    $testObject->vars["username"] = $row[1];
    $testObject->vars["employee_name"] = $row[2];
    $testObject->vars["employee_title"] = $row[3];
    $testObject->vars["email"] = $row[4];
    $testObject->vars["password"] = $row[5];
    $testObject->vars["last_logged"] = $row[6];
    $testObject->vars["start_date"] = $row[7];
    $testObject->vars["is_active"] = $row[8];
    $testObject->vars["require_password_reset"] = $row[9];
    $testObject->vars["hourly_rate"] = $row[10];
	$testObject->vars["user_group"] = $row[11];
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getUserByName($userObject)
* Description: 
* This function will: 
* Accepts an object containing user info as an argument 
* The object received should have a variable labelled "username": $userObject->vars["id"]
* The function returns a single object containing the user data retrieved.
* The user will be identified based on the user ID.
* The second parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function getUserByName($username, $mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  
  //echo "Function: The username received was " . $username . "<br>";
  
  $table_name = "employees";
  
  $sql = "SELECT * FROM $table_name WHERE username = '$username' LIMIT 1"; //direct SQL method
  $result =  $mySQLConnection->query($sql); //direct SQL method
  
  while($row = $result->fetch_array())
  {
    $testObject->vars["id"] = $row[0];
    $testObject->vars["username"] = $row[1];
    $testObject->vars["employee_name"] = $row[2];
    $testObject->vars["employee_title"] = $row[3];
    $testObject->vars["email"] = $row[4];
    $testObject->vars["password"] = $row[5];
    $testObject->vars["last_logged"] = $row[6];
    $testObject->vars["start_date"] = $row[7];
    $testObject->vars["is_active"] = $row[8];
    $testObject->vars["require_password_reset"] = $row[9];
    $testObject->vars["hourly_rate"] = $row[10];
	$testObject->vars["user_group"] = $row[11];
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getUsers($mySQLConnection)
* Description: 
* This function will: 
* Returns an array of objects containing the user data.
* The parameter should be a variable with the connection to the MySQL database.
*******************************************************************************/
function getUsers($mySQLConnection)
{
  $returnValue = 0; //a value to tell us if the process was successful.
  $result = 0;
  $sql = 0;
  $row = 0;
  
  $table_name = "employees";
  
  $sql = "SELECT * FROM $table_name"; //direct SQL method
  $result =  $mySQLConnection->query($sql); //direct SQL method
  
  $outputCount = 0;
  while($row = $result->fetch_array())
  {
    $testObjects[$outputCount]->vars["id"] = $row[0];
    $testObjects[$outputCount]->vars["username"] = $row[1];
    $testObjects[$outputCount]->vars["employee_name"] = $row[2];
    $testObjects[$outputCount]->vars["employee_title"] = $row[3];
    $testObjects[$outputCount]->vars["email"] = $row[4];
    $testObjects[$outputCount]->vars["password"] = $row[5];
    $testObjects[$outputCount]->vars["last_logged"] = $row[6];
    $testObjects[$outputCount]->vars["start_date"] = $row[7];
    $testObjects[$outputCount]->vars["is_active"] = $row[8];
    $testObjects[$outputCount]->vars["require_password_reset"] = $row[9];
    $testObjects[$outputCount]->vars["hourly_rate"] = $row[10];
	$testObjects[$outputCount]->vars["user_group"] = $row[11];

    $outputCount++;
    $returnValue = 1;
  }

  return $testObjects;
  
}

/*******************************************************************************
* Function Name: echoUserData($testObject)
* Description: 
* This function will: 
* Receive an object containing user information.
* Echo the user information.
*******************************************************************************/
function echoUserData($testObject)
{
  echo $id = $testObject->vars["id"];
  echo $username = $testObject->vars["username"];
  echo $employee_name = $testObject->vars["employee_name"];
  echo $employee_title = $testObject->vars["employee_title"];
  echo $email = $testObject->vars["email"];
  echo $password = $testObject->vars["password"];
  echo $last_logged = $testObject->vars["last_logged"];
  echo $start_date = $testObject->vars["start_date"];
  echo $is_active = $testObject->vars["is_active"];
  echo $require_password_reset = $testObject->vars["require_password_reset"];
  echo $hourly_rate = $testObject->vars["hourly_rate"];
  echo $user_group = $testObject->vars["user_group"];
  
  echo "<br/>";
  
  return 0;
}

/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
***************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>