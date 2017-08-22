<?php

// Start the session
session_start();

//Set Debugging Options
$debugging = 1; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
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

$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION["user_id"];
  if($debugging == 1)
  {
    echo "session ID is set<br/>";
  }
}

if($debugging == 1)
{
  echo "<br/>";
  echo "The user_id is: " . $user_id;
  echo "<br/>";
}

//include other files
include_once('security.php'); //functions for interacting with the user table

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //get values from the web form
  //sanitize the user input
  $username_input = test_input($_POST["user_name"]);
  $password_input = test_input($_POST["password"]);
  $remember_me_input = test_input($_POST["remember_me"]);

  if($debugging == 1)
  {
    echo "The username input was: " . $username_input . "<br/>";
    echo "The password input was: " . $password_input . "<br/>";
    echo "The remember me input was: " . $remember_me_input . "<br/>";
  }
  
  //check the database for the username
  $mySQLConn = connectToMySQL(); //connect to mysql, requires security.php
  
  if($debugging == 1)
  {
    echo "Querying Database for the username..";
  }
  $singleUserObject = getUserByName($username_input, $mySQLConn); //output details on a user, requires security.php
  
  if($debugging == 1)
  {
    echoUserData($singleUserObject); //requires security.php
  }
	
  //check the password
  $hashedPassword = $singleUserObject->vars["password"];
  if($debugging == 1)
  {
    echo "This user's hashed password, read from the database is:<br/>";
    echo $hashedPassword;
    echo "<br/>";
  }
  
  //check the password
  if($debugging == 1)
  {
    echo "Comparing to password input: " . $password_input . "<br/>";
  }
  $isPasswordCorrect = password_verify($password_input, $hashedPassword);
  //echo "The value of is password correct is " . $isPasswordCorrect . "<br/>";

  //interpret the response
  if($isPasswordCorrect == 1)  //if authorized, 
  {
    if($debugging == 1)
    {
      echo "The password is correct! :)<br/>";
    }
    
    //then set the session variables
    $user_id = $singleUserObject->vars["id"];
    $_SESSION["user_id"] = $user_id;
	$user_group = $singleUserObject->vars["user_group"];
    $_SESSION["user_group"] = $user_group;
    
    if($debugging == 1)
    {
      echo "<br/>";
      echo "The user_id is: " . $user_id;
      echo "<br/>";
	  echo "The user_group is: " . $user_group;
      echo "<br/>";
	  
	  echo "The remember_me_input = " . $remember_me_input . "<br/>";
    }
	
	//if the user checked Remember Me, then set a cookie to keep them logged in
	if($remember_me_input == "on")
    {
	  //cookie functionality based on example at: http://www.voidtricks.com/add-remember-me-php/
	  
	  //set the user ID cookie
	  $cookie_name = "user_id";
	  $cookie_value = $user_id;
	  //expiriry time. 86400 = 1 day (86400*30 = 1 month)
	  $expiry = time() + (86400 * 30);
	  //sets the cookie variable
	  setcookie($cookie_name, $cookie_value, $expiry);
	  //check that the cookie was set
	  if($debugging == 1)
      {
	    echo "<br/>User Cookie = " . $_COOKIE['user_id'];
      }
	  
	  //set the password cookie
	  $cookie_name = "password_hash";
	  $cookie_value = $hashedPassword;
	  //expiriry time. 86400 = 1 day (86400*30 = 1 month)
	  $expiry = time() + (86400 * 30);
	  //sets the cookie variable
	  setcookie($cookie_name, $cookie_value, $expiry);
	  //check that the cookie was set
	  if($debugging == 1)
      {
	    echo "<br/>Password Cookie = " . $_COOKIE['password'];
      }
	  
	}
    
    header('Location: index.php'); //header to home page
  }
  else //if not authorized 
  {
    $_SESSION["signin_error_message"] = "That username and password combination is wrong. Please check the info and try again.<br/>";//then display an message to the user
	$_SESSION["signin_wrong_username"] = $username_input;
    $_SESSION["signin_wrong_password"] = $password_input;
	header('Location: index.php'); //header to home page
  }
      
}
else //if nothing was entered
{
  $_SESSION["signin_error_message"] = "User Input was not received. Please try again."; //then display an message to the user
  $_SESSION["signin_wrong_username"] = $username_input;
  $_SESSION["signin_wrong_password"] = $password_input;
  header('Location: index.php'); //header to home page
}
	
?>